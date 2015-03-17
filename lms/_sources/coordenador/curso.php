<?php
require_once(dirname(__FILE__).'/../global/curso.global.php');
// ===================================================================
class Curso extends CursoGlobal {
	
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 			$this->doListar(); break;
			case 'novo': 			$this->doEdicao(); break;
			case 'importar': 		$this->doImportar(); break; //In Development
			case 'editar': 			$this->doEdicao(); break;
			case 'apagar': 			$this->doDeletar(); break;
			case 'buscar': 			$this->doListar(); break;
			case 'salvarServidor': 	$this->doSalvarServidor(); break;
			default: 				$this->pagina404(); break;
		}
	}

}
// ===================================================================