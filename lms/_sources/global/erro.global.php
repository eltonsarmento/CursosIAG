<?php
// ===================================================================
class ErroGlobal {
	// ===============================================================
	protected $system = null;
	protected $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('notificacoes');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'pagina404': $this->pagina404(); break;
			default: $this->doListar(); break;
		}
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================
