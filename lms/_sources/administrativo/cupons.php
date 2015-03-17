<?php
require_once(dirname(__FILE__).'/../global/cupons.global.php');
// ===================================================================
class Cupons extends CuponsGlobal {
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 			$this->doListar(); break;
			case 'buscar':			$this->doListar(); break;
			case 'novo': 			$this->doEdicao(); break;
			case 'editar': 			$this->doEdicao(); break;
			case 'apagar': 			$this->doDeletar(); break;
			case 'relatorio':		$this->doRelatorio(); break;
			default: 				$this->pagina404(); break;
		}	
    	
	}
	
}
// ===================================================================