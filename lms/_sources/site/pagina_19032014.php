<?php
// ===================================================================
class Pagina {
	// ===============================================================
	protected $system = null;
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'sobre':				$this->doPagina('sobre_empresa'); break;
			case 'termos':				$this->doTermo(); break;
			case '10-razoes-estudar':	$this->doPagina('10_razoes'); break;
			case 'como-funciona':		$this->doPagina('como_funciona'); break;
			case 'missao-visao':		$this->doPagina('missao_visao'); break;
			case 'historia':			$this->doPagina('historia'); break;
			case 'proximos-cursos':		$this->doPagina('proximos_cursos'); break;
			case 'guia-carreira':		$this->doPagina('guia_carreira'); break;
			case 'bastidores':			$this->doPagina('bastidores'); break;
			case 'aulas-gratuitas':		$this->doPagina('aulas_gratuitas'); break;
			case 'agencia-digital':		$this->doPagina('agencia_digital'); break;
			case 'cursos-onlines':		$this->doPagina('cursos_online'); break;
			case 'suporte':				$this->doPagina('suporte'); break;
			case 'dvds':				$this->doPagina('dvd'); break;
			case 'certificados':		$this->doPagina('certificados'); break;
			case 'parcerias':			$this->doPagina('parcerias'); break;
			case 'faq':					$this->doPagina('faq'); break;
			case 'atendimento-online':	$this->doPagina('atendimento_online'); break;
			case 'mapa-site':			$this->doPagina('mapa'); break;
			default: 					$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doTermo() {
		$this->system->load->dao('configuracoesgerais');
		$termos = $this->system->configuracoesgerais->getTermosCondicoes();
		$this->system->view->assign('termos', html_entity_decode($termos['termos_condicoes']));

		//exibir
		$this->system->site->topo();
		$this->system->view->display('site/termos.tpl');
		$this->system->site->rodape();	
	}
	// ===============================================================
	protected function doPagina($pagina) {
		
		//exibir
		$this->system->site->topo();
		$this->system->view->display('site/estaticas/' . $pagina . '.tpl');
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