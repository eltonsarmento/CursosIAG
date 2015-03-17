<?php
require_once(dirname(__FILE__).'/../global/aulas.global.php');
// ===================================================================
class Aulas extends AulasGlobal{
	// ===================================================================
	public function autoRun() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 					$this->doListar(); break;
			case 'novo': 					$this->doEdicao(); break;
			case 'editar': 					$this->doEditar(); break;
			case 'apagar': 					$this->doDeletar(); break;
			case 'mudarDescricao': 			$this->doMudarDescricao(); break;
			case 'salvarPosicao': 			$this->doMudarPosicao(); break;
			case 'salvarPosicaoAula': 		$this->doMudarPosicaoAula(); break;
			case 'salvarPosicaoCapitulos': 	$this->doMudarPosicaoCapitulos(); break;
			default: 						$this->pagina404(); break;
		}
	}
	
}
// ===================================================================