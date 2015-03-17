<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//load
$system->load->dao('duvidas');
$system->load->model('email_model');

function enviarEmailProfessor($tipoEmail) {
	global $system;
	switch($tipoEmail) {
		case 1: $periodo = date('Y-m-d H', mktime((date('H')-6), date('i'), date('s'), date('m'), date('d'), date('Y'))); break;
		case 2: $periodo = date('Y-m-d H', mktime((date('H')-12), date('i'), date('s'), date('m'), date('d'), date('Y'))); break;
		case 3: $periodo = date('Y-m-d H', mktime((date('H')-24), date('i'), date('s'), date('m'), date('d'), date('Y'))); break;
		case 4: $periodo = date('Y-m-d H', mktime((date('H')-48), date('i'), date('s'), date('m'), date('d'), date('Y'))); break;
	}
	//echo $periodo . '<br/>';
	
	$duvidas = $system->duvidas->getNaoRespondidas('', " and data like '" . $periodo . "%'");	
	
	if (count($duvidas)) {
		foreach ($duvidas as $duvida)	 {
			switch($tipoEmail) {
				case 1: $system->email_model->duvidaNaoRespondida6Professor($duvida['curso_id'], $duvida['professor_id'], $duvida['aluno_id'], $duvida['titulo'], $duvida['comentario']); break;
				case 2: $system->email_model->duvidaNaoRespondida12Professor($duvida['curso_id'], $duvida['professor_id'], $duvida['aluno_id'], $duvida['titulo'], $duvida['comentario']); break;
				case 3: $system->email_model->duvidaNaoRespondida24Professor($duvida['curso_id'], $duvida['professor_id'], $duvida['aluno_id'], $duvida['titulo'], $duvida['comentario']); break;
				case 4: $system->email_model->duvidaNaoRespondida48Professor($duvida['curso_id'], $duvida['professor_id'], $duvida['aluno_id'], $duvida['titulo'], $duvida['comentario']); break;
			}	
		}
	}	
}

//6 horas
enviarEmailProfessor(1);
//12 horas
enviarEmailProfessor(2);
//24 horas
enviarEmailProfessor(3);
//48 dias
enviarEmailProfessor(4);

echo 'Finalizado';
die;
// ===================================================================