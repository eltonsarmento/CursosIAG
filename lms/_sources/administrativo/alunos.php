<?php
require_once(dirname(__FILE__).'/../global/alunos.global.php');
// ===================================================================
class Alunos extends AlunosGlobal{
	
	// ===============================================================
	public function autoRun() {

		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 	$this->doListar(); break;
			//case 'novo': 	$this->doEdicao(); break;
			//case 'editar': 	$this->doEdicao(); break;
			//case 'apagar': 	$this->doDeletar(); break;
			case 'buscar':	$this->doListar(); break;
			default: 		$this->pagina404(); break;
		}	
   	}
   	// ===============================================================
   	protected function doListar() {
		$this->listagem();
		$this->system->admin->topo(2);
		$this->system->view->display('administrativo/alunos_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	
}
// ===================================================================