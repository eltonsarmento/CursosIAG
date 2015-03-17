<?php
require_once(dirname(__FILE__).'/../global/professores.global.php');
// ===================================================================
class Professores extends ProfessoresGlobal {
	
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 				$this->doListar(); break;
			case 'novo': 				$this->doEdicao(); break;
			case 'editar': 				$this->doEdicao(); break;
			case 'apagar': 				$this->doDeletar(); break;
			case 'buscar':				$this->doListar(); break;
			case 'estatisticas': 		$this->doEstatisticas(); break;
			case 'pagamentos': 			$this->doPagamentos(); break;
			case 'atualizaPagamento':	$this->doAtualizarPagamento(); break;
			default: 					$this->pagina404(); break;
		}	    	
	}
}
// ===================================================================