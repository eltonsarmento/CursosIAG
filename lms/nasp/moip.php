<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

$system->load->dao('moip');
$system->load->dao('vendas');
$system->load->dao('curso');
$system->load->model('email_model');

if ($_POST['id_transacao']) {
	$transacao = $system->moip->getTransacao($_POST['id_transacao']);
	
	//Cadastra no banco
	if ($transacao['id_transacao']) 
		$system->moip->atualizar($_POST);
	else
		$system->moip->cadastrar($_POST);


	//Aprovado
	if ($_POST['status_pagamento'] == 1 && $transacao['status_pagamento'] != 1 ) {

		$venda = $system->vendas->getVenda(intval($_POST['id_transacao']));
		$system->vendas->alterarPagamento($venda['id'], 1);
		
		//Adicionar curso
		$cursos = $system->vendas->getCursosVenda($venda['id']);
		$dataExpiracao = date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d'), (date('Y') + 2)));
		$system->curso->cadastrarCursosAluno($cursos, $venda['aluno_id'], $dataExpiracao);
		$system->vendas->atualizar($venda['id'], array('data_expiracao' => $dataExpiracao));

		//Emails
		//Administrativo
		$system->email_model->alteradoStatusVendaAdministrativo($venda['numero']);
		
		//Aluno
		$system->email_model->vendaAprovadaAluno($venda['aluno_id'], $venda['numero'], date('d/m/Y', strtotime($dataExpiracao)));

		//Professor
		foreach ($cursos as $curso)
			$system->email_model->vendaCursoProfessor($curso['id'], $venda['numero']);				
	}
}
