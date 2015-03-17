<?php
require_once(dirname(__FILE__).'/../global/empreendedor.global.php');
// ===================================================================
class Empreendedor extends EmpreendedorGlobal{
	
	// ===============================================================
	public function autoRun() {

		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 	$this->doListar(); break;
			case 'novo': 	$this->doEdicao(); break;
			case 'editar': 	$this->doEdicao(); break;
			case 'apagar': 	$this->doDeletar(); break;
			case 'buscar':	$this->doListar(); break;
			default: 		$this->pagina404(); break;
		}	
   	}
	
}
// ===================================================================