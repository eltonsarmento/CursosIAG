<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
require_once(dirname(__FILE__).'/../_sources/libraries/pagarme/Pagarme.php');
$system = new System(false);

$system->load->dao('pagarme');
$system->load->dao('vendas');
$system->load->dao('curso');
$system->load->model('email_model');
$system->load->dao('configuracoesgerais');	
$system->load->model('pagarme_model');

if ($_POST['fingerprint']) {

	$pagarme = $system->configuracoesgerais->getPagarme();

	Pagarme::setApiKey($pagarme['pagarme_key_api']);

	//if(PagarMe::validateFingerprint($_POST['id'], $_POST['fingerprint'])) {		 	
		
		$id_transacao = $_POST['id'];
		
		
		if($_POST['object'] == 'transaction')
			$transaction = $system->pagarme_model->formataValoresTransacao($id_transacao);
		elseif($_POST['object'] == 'subscription')
			$transaction = $system->pagarme_model->formataValoresAssinatura($id_transacao,'subscription');


		if (!empty($transaction['id'])) {
			$fields['code'] 			  = $transaction['id'];
			$fields['venda_id'] 		  = $transaction['venda_id'];
			$fields['status'] 			  = 0;//($transaction['status'] == 'paid' ? 1 : 0);
			$fields['data']				  = substr($transaction['data'], 0, 10) . ' 00:00';
			$fields['ultima_atualizacao'] = substr($transaction['ultima_atualizacao'], 0, 10);
			$fields['total'] 			  = $transaction['total'];
			$fields['total_liquido']      = $transaction['total_liquido'];
			$fields['taxas']              = $transaction['transacao_custo'];//$transaction['taxas'] = as taxas da operação
			//$fields['custo']              = $transaction['transacao_custo'];			
			
			$transacao = $system->pagarme->getTransacao($transaction['id']);						
			//mail("eltonsarmento@hotmail.com","passo 1","transaction_id ". $transaction['id'] . print_r($transacao));
			//Cadastra no banco
			if ($transacao['venda_id']) 
			 	$system->pagarme->atualizar($fields);
			else {			 	
				$system->pagarme->cadastrar($fields);
				$campos = array(			 		
					'valor_taxas' 		=> $fields['taxas'],
					'valor_total'		=> $fields['total_liquido'],
				);				
				$system->vendas->atualizar(intval($fields['venda_id']), $campos);

				$transacao = $system->pagarme->getTransacao($transaction['id']);
			}
		}
		///////   Aprovado ///////
		// Assinaturas //
		if ($system->vendas->tipoVenda(intval($fields['venda_id'])) == 2) { //Planos

			/*
			$dataInicial = $transaction['data_inicio_cobranca']; //substr($subscription->current_period_start, 0, 10) . ' 00:00';
			$dataFinal   = $transaction['data_fim_cobranca'];    //substr($subscription->current_period_end, 0, 10) . ' 23:59';
			*/
			$dataInicial = substr($fields['data'], 0, 10) . ' 00:00';
			$dataFinal = substr($fields['data'], 0, 10) . ' 23:59';
			
			$system->vendas->atualizar(intval($fields['venda_id']), array('codePagarme' => $fields['code']));


			//Aprovado
			//if ($transaction->getStatus()->getValue() == 3) {		
			if ($transaction['status'] == 'paid') {

				$venda = $system->vendas->getVenda(intval($fields['venda_id']));
				$plano = $system->vendas->getPlanoVenda($venda['id']);
				
				//Nova Assinatura
				//if ($transacao['status'] != 3 || $venda['status'] == 0) { 
				if ($venda['status'] == 0 || $venda['status'] == 2) { 
				 	$system->vendas->alterarPagamento($venda['id'], 1);
				
					//Adicionar Plano
					$dataExpiracao = date('Y-m-d', mktime(0, 0, 0, (date('m') + $plano['meses']), date('d'), date('Y')));
					$system->planos->cadastrarPlanoAluno($plano['id'], $venda['aluno_id'], $venda['id'], $dataExpiracao);
					$system->vendas->atualizar($venda['id'], array('data_expiracao' => $dataExpiracao));

					//Emails
					//Administrativo
					$system->email_model->alteradoStatusVendaAdministrativo($venda['numero']);
					
					//Aluno
					$system->email_model->vendaAprovadaAluno($venda['aluno_id'], $venda['numero'], date('d/m/Y', strtotime($dataExpiracao)));

					$system->email_model->assinaturaContratadaAluno($venda['aluno_id'], $plano['plano']);
				 }
				 //Renova
				 elseif ($transacao['ultima_atualizacao'] != $fields['ultima_atualizacao']) {

				 	$assinatura = end($system->planos->getPlanosAluno("assinatura_id = '" . $venda['id'] . "'"));
					$dataExpiracao = date('Y-m-d', mktime(0, 0, 0, (date('m') + $plano['meses']), date('d'), date('Y')));

					$campos = array(
						'usuario_id'		=> 0,
						'aluno_id'			=> $assinatura['usuario_id'],
						'cupom_id'			=> 0,
						'parceiro_id'		=> 0,
						'forma_desconto'	=> 0,
						'forma_pagamento'	=> 0,
						'status'			=> 1,
						'valor_desconto'	=> 0,
						'codePagSeguro'		=> $venda['codePagSeguro'],
						'codePagarme'		=> $venda['codePagarme'],
						'valor_taxas'		=> $fields['taxas'],
						'valor_total'		=> $fields['total_liquido'],
						'data_venda'		=> date('d/m/Y'),
						'data_expiracao'	=> $dataExpiracao,
						'cursos'			=> array(),
						'planos'			=> array($plano['id']),
					);
				
					$id = $system->vendas->cadastrar($campos);
				
					$system->planos->renovarAssinatura($assinatura['id'], $dataExpiracao);
					$system->planos->renovarCursoPlano(intval($assinatura['curso_id']), $dataExpiracao);

					//Aluno
					$system->email_model->assinaturaRenovadaAluno($assinatura['usuario_id'], $plano['nome']);

				 }
				 $system->pagarme->atualizar(array('status' => 1, 'ultima_atualizacao' => date('Y-m-d H:i:s'), 'code' => $fields['code']));
			}
		}
		// Cursos //
		elseif($system->vendas->tipoVenda(intval($fields['venda_id'])) == 1) { //Cursos			
			if ($transaction['status'] == 'paid' && $transacao['status'] != 1 ) {
				$venda = $system->vendas->getVenda(intval($fields['venda_id']));
				$system->vendas->alterarPagamento($venda['id'], 1);
				
				//Adicionar curso
				$cursos = $system->vendas->getCursosVenda($venda['id']);
				//Periodo Acesso
				$pediodoAcesso = $system->configuracoesgerais->getPeriodoAcesso();
				if (empty($pediodoAcesso['periodo_acesso']))
					$pediodoAcesso['periodo_acesso'] = 24;
				$dataExpiracao = date('Y-m-d H:i:s', mktime(23, 59, 59, (date('m') + intval($pediodoAcesso['periodo_acesso']))));
				//$dataExpiracao = date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d'), (date('Y') + 2)));
				$system->curso->cadastrarCursosAluno($cursos, $venda['aluno_id'], $dataExpiracao,0);

				$system->vendas->atualizar($venda['id'], array('data_expiracao' => $dataExpiracao));				
											
				
				$system->pagarme->atualizar(array('status' => 1, 'ultima_atualizacao' => date('Y-m-d H:i:s'), 'code' => $fields['code']));
				

				//Professor
				foreach ($cursos as $curso)
					$system->email_model->vendaCursoProfessor($curso['id'], $venda['numero']);		
				//Administrativo
				$system->email_model->alteradoStatusVendaAdministrativo($venda['numero']);
				
				//Aluno
				$system->email_model->vendaAprovadaAluno($venda['aluno_id'], $venda['numero'], date('d/m/Y', strtotime($dataExpiracao)));
			}
		}	
	
	//}if(PagarMe::validateFingerprint($_POST['id'], $_POST['fingerprint'])) {		 	
		
}else{ // Primeira ocorrencia de assinatua. somente quando o cliente compra que é submetido para um form.php  e direciona para cá.

		$pagarme = $system->configuracoesgerais->getPagarme();

		Pagarme::setApiKey($pagarme['pagarme_key_api']);
		
		$id_transacao_assinatura = $_POST['id_assinatura_pagarme'];//$system->session->getItem('id_assinatura_pagarme');

		//echo "id transacao = ".$id_transacao_assinatura;
		$transaction = $system->pagarme_model->formataValoresAssinatura($id_transacao_assinatura,'subscription');

		if (!empty($transaction['id'])) {
			$fields['code'] 			  = $transaction['id'];
			$fields['code_assinatura'] 	  = $transaction['id_asinatura'];
			$fields['venda_id'] 		  = $transaction['venda_id'];
			$fields['status'] 			  = $transaction['status'];
			$fields['data']				  = substr($transaction['data'], 0, 10) . ' 00:00';
			$fields['ultima_atualizacao'] = substr($transaction['ultima_atualizacao'], 0, 10);
			$fields['total'] 			  = $transaction['total'];
			$fields['total_liquido']      = $transaction['total_liquido'];
			$fields['taxas']              = $transaction['transacao_custo'];
			//$fields['custo']              = $transaction['transacao_custo'];			
			
			$transacao = $system->pagarme->getTransacao($transaction['id']);
			
			//Cadastra no banco
			if ($transacao['venda_id'])
			 	$system->pagarme->atualizar($fields);
			else {
			 	$system->pagarme->cadastrar($fields);
			 	$campos = array(			 		
					'valor_taxas' 		=> $fields['taxas'],
					'valor_total'		=> $fields['total_liquido'],
				);

				$system->vendas->atualizar(intval($fields['venda_id']), $campos);
			}
		}

		// Assinaturas //
		if ($system->vendas->tipoVenda(intval($fields['venda_id'])) == 2) { //Planos
			/*
			$dataInicial = $transaction['data_inicio_cobranca']; //substr($subscription->current_period_start, 0, 10) . ' 00:00';
			$dataFinal   = $transaction['data_fim_cobranca'];    //substr($subscription->current_period_end, 0, 10) . ' 23:59';
			*/
			$dataInicial = substr($fields['data'], 0, 10) . ' 00:00';
			$dataFinal = substr($fields['data'], 0, 10) . ' 23:59';
					
			$system->vendas->atualizar(intval($fields['venda_id']), array('codePagarme' => $fields['code']));

			//Aprovado
			//if ($transaction->getStatus()->getValue() == 3) {
			if ($transaction['status'] == 'paid') {

				$venda = $system->vendas->getVenda(intval($fields['venda_id']));
				$plano = $system->vendas->getPlanoVenda($venda['id']);
				
				//Nova Assinatura
				//if ($transacao['status'] != 3 || $venda['status'] == 0) { 
				if ($venda['status'] == 0 || $venda['status'] == 2) { 
				 	$system->vendas->alterarPagamento($venda['id'], 1);
				
					//Adicionar Plano
					$dataExpiracao = date('Y-m-d', mktime(0, 0, 0, (date('m') + $plano['meses']), date('d'), date('Y')));
					$system->planos->cadastrarPlanoAluno($plano['id'], $venda['aluno_id'], $venda['id'], $dataExpiracao);
					$system->vendas->atualizar($venda['id'], array('data_expiracao' => $dataExpiracao));

					//Emails
					//Administrativo
					$system->email_model->alteradoStatusVendaAdministrativo($venda['numero']);
					
					//Aluno
					$system->email_model->vendaAprovadaAluno($venda['aluno_id'], $venda['numero'], date('d/m/Y', strtotime($dataExpiracao)));

					$system->email_model->assinaturaContratadaAluno($venda['aluno_id'], $plano['plano']);
				 }
				 //Renova
				 elseif ($transacao['ultima_atualizacao'] != $fields['ultima_atualizacao']) {

				 	$assinatura = end($system->planos->getPlanosAluno("assinatura_id = '" . $venda['id'] . "'"));
					$dataExpiracao = date('Y-m-d', mktime(0, 0, 0, (date('m') + $plano['meses']), date('d'), date('Y')));

					$campos = array(
						'usuario_id'		=> 0,
						'aluno_id'			=> $assinatura['usuario_id'],
						'cupom_id'			=> 0,
						'parceiro_id'		=> 0,
						'forma_desconto'	=> 0,
						'forma_pagamento'	=> 0,
						'status'			=> 1,
						'valor_desconto'	=> 0,
						'codePagSeguro'		=> $venda['codePagSeguro'],
						'codePagarme'		=> $venda['codePagarme'],
						'valor_taxas'		=> $fields['taxas'],
						'valor_total'		=> $fields['total_liquido'],
						'data_venda'		=> date('d/m/Y'),
						'data_expiracao'	=> $dataExpiracao,
						'cursos'			=> array(),
						'planos'			=> array($plano['id']),
					);
				
					$id = $system->vendas->cadastrar($campos);
				
					$system->planos->renovarAssinatura($assinatura['id'], $dataExpiracao);
					$system->planos->renovarCursoPlano(intval($assinatura['curso_id']), $dataExpiracao);

					//Aluno
					$system->email_model->assinaturaRenovadaAluno($assinatura['usuario_id'], $plano['nome']);
				 }
				 $system->pagarme->atualizar(array('status' => 1, 'ultima_atualizacao' => date('Y-m-d H:i:s'), 'code' => $fields['code']));
			}
			$system->session->deleteItem('id_assinatura_pagarme');
			//header('Location: ' . $system->getUrlSite() . 'carrinho/confirmacao');
			echo "<script type='text/javascript'>window.location.href='" . $system->getUrlSite(). "carrinho/confirmacao'</script>";
			exit();

		}
}
