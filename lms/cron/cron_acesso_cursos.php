<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//load
$system->load->dao('curso');
$system->load->model('email_model');

function enviarEmailAluno($tipoEmail) {
	global $system;
	switch($tipoEmail) {
		case 1: $periodo = date('Y-m-d'); break;
		case 2: $periodo = date('Y-m-d', mktime(23, 59, 59, date('m'), (date('d')+1), date('Y'))); break;
		case 3: $periodo = date('Y-m-d', mktime(23, 59, 59, date('m'), (date('d')+15), date('Y'))); break;
		case 4: $periodo = date('Y-m-d', mktime(23, 59, 59, date('m'), (date('d')+30), date('Y'))); break;
	}

	$matriculas = $system->curso->getCursosAlunos(" and expira like '" . $periodo . "%'");	
	
	list($ano, $mes, $dia) = explode('-', $periodo);
	$expira = $dia.'/'.$mes.'/'.$ano;
	
	if (count($matriculas)) {
		foreach ($matriculas as $matricula)	 {
			switch($tipoEmail) {
				case 1: $system->email_model->expiraCursoHojeAluno($matricula['usuario_id'], $matricula['curso_id'], $expira); break;
				case 2: $system->email_model->expiraCurso1DiaAluno($matricula['usuario_id'], $matricula['curso_id'], $expira); break;
				case 3: $system->email_model->expiraCurso15DiaAluno($matricula['usuario_id'], $matricula['curso_id'], $expira); break;
				case 4: $system->email_model->expiraCurso30DiaAluno($matricula['usuario_id'], $matricula['curso_id'], $expira); break;
			}
			
		}
	}	
}

//hoje
enviarEmailAluno(1);
//1 dia
enviarEmailAluno(2);
//15 dias
enviarEmailAluno(3);
//30 dias
enviarEmailAluno(4);

echo 'Finalizado';
die;
// ===================================================================