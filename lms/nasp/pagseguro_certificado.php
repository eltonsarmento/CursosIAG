<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

$system->load->dao('pagseguro');
$system->load->dao('vendas');
$system->load->dao('curso');
$system->load->dao('certificados');
$system->load->model('email_model');
$system->load->model('pagamento_model');
$system->load->model('certificados_model');

if ($_POST['notificationCode'] && $_POST['notificationType']) {
	$transaction = $system->pagamento_model->obterTransacao($_POST);

	//$transaction->getStatus()->setValue(3);
	//print_r($transaction);die;
	if ($transaction->getCode()) {
		$fields['code'] = $transaction->getCode();
		$fields['venda_id'] = $transaction->getReference();
		$fields['status'] = $transaction->getStatus()->getValue();
		$fields['data']	= $transaction->getDate();
		$fields['ultima_atualizacao'] = $transaction->getLastEventDate();
		$fields['total'] = $transaction->getGrossAmount();
		$fields['total_liquido'] = $transaction->getNetAmount();
		$fields['taxas'] = $transaction->getFeeAmount();
		
		$transacao = $system->pagseguro->getTransacao($transaction->getReference());
		
		//Cadastra no banco
		if ($transacao['venda_id']) 
		 	$system->pagseguro->atualizar($fields);
		else {
		 	$system->pagseguro->cadastrar($fields);
		 	$campos = array(
				'valor_taxas' 		=> $fields['taxas'],
				'valor_total'		=> $fields['total_liquido'],
			);

			$system->vendas->atualizar(intval($fields['venda_id']), $campos);
		}
	}

	//Aprovado

	if ($transaction->getStatus()->getValue() == 3 && $transacao['status'] != 3 ) {

		$venda = $system->vendas->getVenda(intval($fields['venda_id']));
		$system->vendas->alterarPagamento($venda['id'], 1);
		
		//Liberar certificados
		$certificados = $system->vendas->getCertificadosByVenda($venda['id']);
		
		foreach ($certificados as $certificado)
			$system->certificados_model->gerarCertificadoImpresso($certificado['matricula_id']);
		
		$dataExpiracao = date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d'), (date('Y') + 2)));

		$system->vendas->atualizar($venda['id'], array('data_expiracao' => $dataExpiracao));
		

		//Emails
		//Administrativo
		$system->email_model->alteradoStatusVendaAdministrativo($venda['numero']);
		
		//Aluno
		$system->email_model->vendaAprovadaAluno($venda['aluno_id'], $venda['numero'], date('d/m/Y', strtotime($dataExpiracao)));
		foreach ($certificados as $certificado) {
			$cursoAluno = end($system->curso->getCursosAlunos(" and usuario_id = '" . $venda['aluno_id'] . "' and id = '" . $certificado['matricula_id'] . "'"));
			$system->email_model->alteradoStatusCertificadoAluno($venda['aluno_id'], $cursoAluno['curso_id']);
		}
				
	}
}

/*
Status 
1	Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
2	Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
3	Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
4	Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
5	Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
6	Devolvida: o valor da transação foi devolvido para o comprador.
7	Cancelada: a transação foi cancelada sem ter sido finalizada.
*/