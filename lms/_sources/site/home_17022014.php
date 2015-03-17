<?php
// ===================================================================
class Home {
	// ===============================================================
	protected $system = null;
	private $limit = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'index': 	$this->doIndex(); break;
			default: 		$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doIndex() {
		
		$this->system->load->dao('curso');
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->dao('curso');
		
		$cursosHome = $this->system->curso->getCursosCondicao('and home = 1', '', 'id desc');

		foreach($cursosHome as $key => $curso) {
			$cursosHome[$key]['categorias'] = $this->system->curso->getCategoriasByCurso($curso['id'], true);
			$cursosHome[$key]['valor'] = str_replace('.', ',', $curso['valor']);
		}

		$this->system->view->assign(array(
			'cursosDestaque'	=> $cursosHome,
			'cursosBanner'		=> $this->system->curso->getCursosCondicao('and banner = 1'),
			'configBanner'		=> $this->system->configuracoesgerais->getImagensBanner(),
			'configDestacada'	=> $this->system->configuracoesgerais->getImagensDestacada(),
		));
		
		$this->system->site->topo();
		$this->system->view->display('site/index.tpl');
		$this->system->site->rodape();
	}
	
	// ===============================================================
	protected function pagina404() {
		$url = end(explode($this->system->getUrlSite(), $_SERVER['REQUEST_URI']));
		$this->system->view->assign('url', $url);
		$this->system->site->topo(0);
		$this->system->view->display('site/pagina404.tpl');
		$this->system->site->rodape();
	}
}
// ===================================================================