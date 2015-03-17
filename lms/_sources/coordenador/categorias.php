<?php
require_once(dirname(__FILE__).'/../global/categorias.global.php');
// ===================================================================
class Categorias extends CategoriasGlobal {
	// ===============================================================
	public function autoRun() {

		$this->system->view->assign('modulo', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 	$this->doListar(); break;
			case 'nova': 	$this->doEdicao(); break;
			case 'editar': 	$this->doEdicao(); break;
			case 'apagar': 	$this->doDeletar(); break;
			case 'buscar':	$this->doListar(); break;
			default: 		$this->pagina404(); break;
		}
	}
}
// ===================================================================