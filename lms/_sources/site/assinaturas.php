<?php
// ===================================================================
class Assinaturas {
	// ===============================================================
	protected $system = null;
	private $tituloPagina = 'Assinaturas';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('planos');
	}
	// ===============================================================
	public function autoRun() {
		//$this->doAguarde();
		//die;
		switch($this->system->input['do']) {
			case 'index':	$this->doIndex(); break;
			default: 			$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doIndex() {
		$planos = $this->system->planos->getPlanosCondicao(' and status = 1', '', 'meses');

		//exibir
		$this->system->view->assign('planos', $planos);
		$this->system->site->topo($this->tituloPagina);
		$this->system->view->display('site/assinaturas.tpl');
		$this->system->site->rodape(array('newsletter' => 1, 'tipo_conteudo' => 'Página', 'conteudo' => 'Assinaturas'));	
	}
	// ===============================================================
	protected function pagina404() {
		$url = end(explode($this->system->getUrlSite(), $_SERVER['REQUEST_URI']));
		$this->system->view->assign('url', $url);
		$this->system->site->topo(0);
		$this->system->view->display('site/pagina404.tpl');
		$this->system->site->rodape();
	}
	// ===============================================================
	protected function doAguarde() {
		$this->system->site->topo($this->tituloPagina);
		$this->system->view->display('site/aguarde.tpl');
		$this->system->site->rodape();
	}
}
// ===================================================================