<?php
// ===================================================================
class Erro {
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
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	protected function pagina404() {
		$url = end(explode($this->system->getUrlSite(), $_SERVER['REQUEST_URI']));
		$this->system->view->assign('url', $url);
		$this->system->site->topo(0);
		$this->system->view->display('site/pagina404.tpl');
		$this->system->site->rodape(array('newsletter' => 1, 'tipo_conteudo' => 'Página', 'conteudo' => 'Página não encontrada'));
	}
}
// ===================================================================
