<?php
// ===================================================================
class Pagina {
	// ===============================================================
	protected $system = null;
	private $tituloPagina = 'IAG';
    private $descricaoPagina = 'O Cursos IAG nasceu com um objetivo muito claro: transmitir conhecimento no mais alto nível de detalhes já visto no mercado. Formar profissionais capazes de tirar o máximo das ferramentas, conseguindo então criar projetos e soluções incríveis para os seus clientes.';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'sobre':				$this->doPagina('sobre_empresa', 'Sobre'); break;
			case 'termos':				$this->doTermo(); break;
			case '10-razoes-estudar':	$this->doPagina('10_razoes', '10 razões'); break;
			case 'como-funciona':		$this->doPagina('como_funciona', 'Como funciona'); break;
			case 'missao-visao':		$this->doPagina('missao_visao', 'Missão e Visão'); break;
			case 'historia':			$this->doPagina('historia', 'História'); break;
			case 'proximos-cursos':		$this->doPagina('proximos_cursos', 'Próximos cursos'); break;
			case 'guia-carreira':		$this->doPagina('guia_carreira', 'Guia carreira'); break;
			case 'bastidores':			$this->doPagina('bastidores', 'Bastidores'); break;
			case 'aulas-gratuitas':		$this->doPagina('aulas_gratuitas', 'Aulas gratuitas'); break;
			case 'agencia-digital':		$this->doPagina('agencia_digital', 'Agencia Digital'); break;
			case 'cursos-onlines':		$this->doPagina('cursos_online', 'Cursos Online'); break;
			case 'suporte':				$this->doPagina('suporte', 'Suporte'); break;
			case 'dvds':				$this->doPagina('dvd', 'DVD'); break;
			case 'certificados':		$this->doPagina('certificados', 'Certificados'); break;
			case 'parcerias':			$this->doPagina('parcerias', 'Parcerias'); break;
			case 'faq':					$this->doPagina('faq', 'F.A.Q.'); break;
			case 'atendimento-online':	$this->doPagina('atendimento_online', 'Atendimento Online'); break;
			case 'mapa-site':			$this->doPagina('mapa', 'Mapa'); break;
            case 'vagas':				$this->doPagina('vagas', 'Vagas'); break;
            case 'cursosaovivo':		$this->doPagina('cursosaovivo', 'Cursos ao Vivo'); break;
			case 'promocao':			$this->doPromocao(); break;
			default: 					$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doTermo() {
		$this->system->load->dao('configuracoesgerais');
		$termos = $this->system->configuracoesgerais->getTermosCondicoes();
		$this->system->view->assign('termos', html_entity_decode($termos['termos_condicoes']));

		//exibir
		$this->system->site->topo('Termos', $this->descricaoPagina);
		$this->system->view->display('site/termos.tpl');
		$this->system->site->rodape(array('newsletter' => 1, 'tipo_conteudo' => 'Página', 'conteudo' => 'Termos e Condições'));
	}
	// ===============================================================
	protected function doPagina($pagina, $titulo = '') {
		
		if ($titulo != '')
			$this->tituloPagina = $titulo;

		//exibir
		$this->system->site->topo($this->tituloPagina, $this->descricaoPagina);
		$this->system->view->display('site/estaticas/' . $pagina . '.tpl');
		$this->system->site->rodape(array('newsletter' => 1, 'tipo_conteudo' => 'Página', 'conteudo' => $titulo));	
	}
	// ===============================================================
	protected function doPromocao() {
        
        $this->system->load->dao('curso');
        
        $cursosPromocao = $this->system->curso->getCursosCondicao('and id IN (113,111,109,104,107,103,102,101,100,99,98,97,96,95,94,92,91,90,88,86,85,84,79,76,77,75,74,73,72,71,69,68,67,66,65,63,62,61,60,59,58,56,54,53,49,48,45,42,41,37,33,30,28,26,18,17,7,6,5)', '', 'id desc');
        
		//exibir
        $this->system->view->assign('cursosPromocao', $cursosPromocao);
		$this->system->site->topo('Promoção de Carnaval');
		$this->system->view->display('site/promocao.tpl');
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