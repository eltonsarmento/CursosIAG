<?php
require_once(dirname(__FILE__).'/../global/depoimentos.global.php');
// ===================================================================
class Depoimentos extends DepoimentosGlobal {
	
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 				$this->doListar(); break;
			case 'aceitar': 			$this->doAceitar(); break;
			case 'recusar': 			$this->doRecusar(); break;
			case 'buscarDepoimento': 	$this->doBuscarDepoimento(); break;
			case 'editar': 				$this->doEditar(); break;
			default: $this->pagina404(); break;
		}
	}

}
// ===================================================================