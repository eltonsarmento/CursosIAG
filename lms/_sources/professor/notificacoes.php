<?php
require_once(dirname(__FILE__).'/../global/notificacoes.global.php');
// ===================================================================
class Notificacoes extends NotificacoesGlobal {
	
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': $this->doListar(); break;
			case 'ler': $this->doLer(); break;
			default: $this->pagina404(); break;
		}
	}
	
}
// ===================================================================
