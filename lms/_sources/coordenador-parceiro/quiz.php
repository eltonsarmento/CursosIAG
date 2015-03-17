<?php
require_once(dirname(__FILE__).'/../global/quiz.global.php');
// ===================================================================
class Quiz extends QuizGlobal {
	
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'novo': 	$this->doNovo(); break;
			case 'editar': 	$this->doEdicao(); break;
			case 'aulas': 	$this->doBuscarAulas(); break;
			case 'listar': 	$this->doListar(); break;
			case 'apagar':  $this->doDeletar(); break;
			default: 		$this->pagina404(); break;
		}
		
	}
}
// ===================================================================