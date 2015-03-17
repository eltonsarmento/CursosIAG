<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//load
$system->load->dao('curso');
$system->load->dao('aulas');
$system->load->dao('alunos');


$liberarTodasAulas = true;
$alunoID = 36;
$cursoID = 22;
$matriculaID = 6841; // ID DO CURSOS_ALUNOS
die;
//Rodar	
$capitulos = $system->aulas->getCapitulosByCurso($cursoID);
$cont = 0;
foreach ($capitulos as $capitulo)  {
	foreach ($capitulo['aulas'] as $aula) {

		// if ($cont < 61) {
		if ($cont <= 61) {
			if ($system->aulas->checarAulaLiberada($aula['aula_id'], $matriculaID)) {
				echo 'Aula liberada :' . $aula['aula_id'] . '<br/>';
				$system->aulas->concluiAula($aula['aula_id'], $matriculaID);
				$system->aulas->liberarAvancar($aula['aula_id'], $matriculaID);
				$cont++;
				continue;
			}
			$system->aulas->liberarAula($aula['aula_id'], $matriculaID, $alunoID);
			$system->aulas->concluiAula($aula['aula_id'], $matriculaID);
			$system->aulas->liberarAvancar($aula['aula_id'], $matriculaID);
		} else {
			echo 'Not - ';
		}
		
		$cont++;
		echo $cont . ' - ' . $aula['aula_id'] . '<br/>';
	}
}
	









// ===================================================================