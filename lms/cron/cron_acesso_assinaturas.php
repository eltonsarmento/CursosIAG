<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//load
$system->load->dao('planos');
$system->load->model('email_model');

function enviarEmailAluno($tipoEmail) {
	global $system;
	switch($tipoEmail) {
		case 1: $periodo = date('Y-m-d', mktime(23, 59, 59, date('m'), (date('d')+1), date('Y'))); break;
		case 2: $periodo = date('Y-m-d', mktime(23, 59, 59, date('m'), (date('d')+5), date('Y'))); break;
		case 3: $periodo = date('Y-m-d', mktime(23, 59, 59, date('m'), (date('d')+10), date('Y'))); break;
	}

	$assinaturas = $system->planos->getPlanosAluno("excluido = 0 and data_expiracao = '" . $periodo . "'");	
	
	if (count($assinaturas)) {
		foreach ($assinaturas as $assinatura)	 {
			switch($tipoEmail) {
				case 1: $system->email_model->expiraAssinatura1DiaAluno($assinatura['usuario_id'], $assinatura['plano_id']); break;
				case 2: $system->email_model->expiraAssinatura5DiaAluno($assinatura['usuario_id'], $assinatura['plano_id']); break;
				case 3: $system->email_model->expiraAssinatura10DiaAluno($assinatura['usuario_id'], $assinatura['plano_id']); break;
			}
			
		}
	}	
}

//1 dia
enviarEmailAluno(1);
//5 dias
enviarEmailAluno(2);
//10 dias
enviarEmailAluno(3);
//Expirado
$assinaturas = $system->planos->getPlanosAluno("excluido = 0 and data_expiracao < '" . date('Y-m-d') . "'");	

if (count($assinaturas)) {
	foreach ($assinaturas as $assinatura)	 {
		$system->planos->desativarAssinatura($assinatura['id']);
		$plano = $system->planos->getPlano($assinatura['plano_id']);
		
		//Aluno
		$system->email_model->assinaturaNaoRenovadaAluno($assinatura['usuario_id'], $plano['nome']);
	}
}	

echo 'Finalizado';
die;
// ===================================================================