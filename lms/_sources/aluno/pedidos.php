<?php
// ===================================================================
class Pedidos {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('vendas');
		$this->system->load->dao('curso');
		$this->system->load->dao('alunos');
        $this->system->load->dao('pagseguro');
	}
	// ===============================================================
	public function autoRun() {		
		switch($this->system->input['do']) {
			case 'listar': 		$this->doListar(); break;
			case 'detalhe': 	$this->doDetalhe(); break;
			case 'comprovante':	$this->doComprovante(); break;
			case 'cancelar':	$this->doCancelar(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	private function doListar() {
		
		$pedidos = $this->system->vendas->getVendas(" and aluno_id = '" . $this->system->session->getItem('session_cod_usuario') . "'");
		foreach ($pedidos as $key => $venda) {
			$cursos = $this->system->vendas->getCursosVenda($venda['id']);

			foreach ($cursos as $key2 => $curso)
				$cursos[$key2] = $this->system->curso->getCurso($curso['id']);
			
			//
			$plano = $this->system->vendas->getPlanoVenda($venda['id']);
			$certificados = $this->system->vendas->getCertificadosVenda($venda['id']);
			
			//busca url boleto 	
			if($venda['codePagarme'] != '' && $venda['status'] == 0){
				
				$this->system->load->model('pagarme_model');
				$transacao = $this->system->pagarme_model->formataValoresTransacao($venda['codePagarme']);
				
				$dataExpiracao = implode("-",array_reverse(explode("-",$transacao['boleto_dataExpiracao'])));
				$dataExpiracao = date('d-m-Y',strtotime($dataExpiracao));				
				

				if(strtotime($dataExpiracao) >= strtotime(date('d-m-Y'))){									
				        $pedidos[$key]['boleto_url'] 	 = $transacao['boleto_url'];
					$pedidos[$key]['boleto_barcode'] = $transacao['boleto_barcode'];
				}else{					
					$this->system->vendas->alterarPagamento($venda['id'], 2);
					$pedidos[$key]['status'] = 2;
				}
			}

			$pedidos[$key]['cursos'] = $cursos;
			$pedidos[$key]['plano'] = $plano;
			$pedidos[$key]['certificados'] = $certificados;
			$pedidos[$key]['valor'] = number_format($venda['valor_total'] + $venda['valor_taxas'], 2, ',', '.');
		}


		if ($msg_alert = $this->system->session->getItem('msg_alert')) 
			$this->system->session->deleteItem('msg_alert');

		$this->system->view->assign(array(
			'url_site'		=> $this->system->getUrlSite(),
			'pedidos'		=> $pedidos,
			'msg_alert'		=> $msg_alert
		));
		
		$this->system->admin->topo(2);
		$this->system->view->display('aluno/pedidos.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function doDetalhe() {
		$venda_id = $this->system->input['id'];
		$venda = end($this->system->vendas->getVendas(" and aluno_id = '" . $this->system->session->getItem('session_cod_usuario') . "' and id = '" . $venda_id . "'"));

		if ($venda['id']) {

			$cursos = $this->system->vendas->getCursosVenda($venda['id']);
			foreach ($cursos as $key => $curso) {
                
				$cursos[$key] = $this->system->curso->getCurso($curso['id']);
				$cursos[$key]['certificado_adquirido'] = $curso['certificado'];
				
				$cursos[$key]['valor'] = number_format($curso['preco_total'], 2, ',', '.');
			}
			
			//
			$plano = $this->system->vendas->getPlanoVenda($venda['id']);
			$certificados = $this->system->vendas->getCertificadosVenda($venda['id']);

			$venda['cursos'] 		= $cursos;
			$venda['certificados'] 	= $certificados;
			$venda['plano'] 		= $plano;
			$venda['valor'] 		= number_format($venda['valor_total'] + $venda['valor_taxas'], 2, ',', '.');
            
            $aluno = $this->system->alunos->getAluno($this->system->session->getItem('session_cod_usuario'));
            $pagseguro = $this->system->pagseguro->getTransacao($venda['id']);
            
			$this->system->view->assign(array(
				'url_site'	=> 	$this->system->getUrlSite(),
				'venda'		=>	$venda,
                'aluno'     =>  $aluno,
                'pagseguro' =>  $pagseguro
			));


			$this->system->admin->topo(2);
			$this->system->view->display('aluno/pedido_detalhe.tpl');
			$this->system->admin->rodape();
		} else 
			$this->system->func->redirecionar('/pedidos/listar');
	}
	// ===============================================================
	private function doComprovante() {
		$venda_id = $this->system->input['venda_id'];
		$venda = end($this->system->vendas->getVendas(" and aluno_id = '" . $this->system->session->getItem('session_cod_usuario') . "' and id = '" . $venda_id . "'"));

		if ($venda['id']) {
			if (is_uploaded_file($_FILES['arquivo']['tmp_name'])) {
				$extensao = $this->system->func->getExtensaoArquivo($_FILES['arquivo']['name']);
				if (in_array($extensao, array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'gif'))) {
					$comprovante = true;
					if ($_FILES['arquivo']['size'] > 10485760) {
						echo 'O Comprovante está com mais de 10MB';
						$comprovante = false;
					}
				} else {
					echo 'Comprovante de pagamento inválido';
					$comprovante = false;
				}
			}
			if ($comprovante) {
				$nomearquivo = 'comprovante_pagamento_'.$venda['id'].'.'.$extensao;
				if (file_exists($this->system->getUploadPath().'/comprovantes_alunos/'.$nomearquivo))
					unlink($this->system->getUploadPath().'/comprovantes_alunos/'.$nomearquivo);
				copy($_FILES['arquivo']['tmp_name'], $this->system->getUploadPath().'/comprovantes_alunos/'.$nomearquivo);
				$this->system->vendas->atualizar($venda['id'], array('comprovante' => $nomearquivo));
				echo 'Comprovante salvo com sucesso!';
			}
		}
	}
	// ===============================================================
	protected function doCancelar() {
		$venda_id = $this->system->input['id'];
		$venda = end($this->system->vendas->getVendas(" and usuario_id = '" . $this->system->session->getItem('session_cod_usuario') . "' and id = '" . $venda_id . "' and status = 0"));

		if ($venda['id']) {
			$this->system->vendas->atualizar($venda['id'], array('status' => 2));
			$this->system->session->addItem('msg_alert', 'Venda Nº ' . $venda['numero'] . ' cancelada!');
		} else {
			$this->system->session->addItem('msg_alert', 'Não foi possível cancelar essa venda!');
		}

		$this->system->func->redirecionar('/pedidos/listar');
	}
	// ===============================================================
	private function pagina404() {
		$this->system->view->assign('categoria', 'aluno');
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
}
// ===================================================================