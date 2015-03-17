<?php
// ===================================================================
class Categoria {
	// ===============================================================
	protected $system = null;
	private $limit = 12;
	private $tituloPagina = 'Categoria';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('curso');
		$this->system->load->dao('categorias');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'visualizar':	$this->doVisualizar(); break;
			case 'carregarMais':$this->doCarregarMais(); break;
			default: 			$this->doVisualizar(); break;
		}	
	}
	// ===============================================================
	protected function doVisualizar() {
		$id = $this->system->input['id'];
		$ordenacao = $this->system->input['ordenacao'];
		$this->system->session->deleteItem('resultado_busca_mais');

		if (!$id) {
			$url = $this->system->func->getValorUrl(3);
			$id = $this->system->categorias->getIdByUrl($url);
		}

		$categoria = $this->system->categorias->getCategoria($id);

		if(!$categoria['id']) {
			header('location:' . $this->system->getUrlSite() . 'home');
			exit();
		}
		$this->tituloPagina = $categoria['categoria'];

		//Ordenação
		switch($ordenacao) {
			case 1:
				$orderBy = 'curso';
				break;
			case 2:
				$orderBy = 'curso desc';
				break;
			case 3:
				$orderBy = 'valor';
				break;
			case 4:
				$orderBy = 'valor desc';
				break;
			default:
				$orderBy = 'data_cadastro desc';
				break;

		}
		$categoriasFilhas = $this->system->categorias->getCategoriasFilhas(" and categoria_pai_id = " . $id, '', '', 'id');
		foreach ($categoriasFilhas as $key => $value)
			$categoriasID[] = $value['id'];
		$categoriasID[] = $id;

		$cursos = $this->system->curso->getCursosByCategorias($categoriasID, '', $orderBy);		


		//Limitar cursos
		$cursosExibir = array();
		$cursosListarMais = array();
		foreach ($cursos as $key => $curso) {
			$curso['valor'] = str_replace('.', ',', $curso['valor']);
			$curso['categorias'] = $this->system->curso->getCategoriasByCurso($curso['id'], true);

			if ($key < $this->limit)
				$cursosExibir[] = $curso;
			else
				$cursosListarMais[] = $curso;
		}
		$this->system->session->addItem('resultado_busca_mais', $cursosListarMais);
		
		//exibir
		$this->system->view->assign('categoria', $categoria);
		$this->system->view->assign('cursos', $cursosExibir);
		$this->system->view->assign('totalExibindo', count($cursosExibir));
		$this->system->view->assign('total', (count($cursosExibir)+count($cursosListarMais)));
		$this->system->site->topo($this->tituloPagina);
		$this->system->view->display('site/categoria.tpl');
		$this->system->site->rodape();	
	}
	// ==============================================================
	protected function doCarregarMais() {
		$cursos = $this->system->session->getItem('resultado_busca_mais');
		$this->system->session->deleteItem('resultado_busca_mais');

		$cursosExibir = array();
		$cursosListarMais = array();
		foreach ($cursos as $key => $curso) {
			if ($key < $this->limit)
				$cursosExibir[] = $curso;
			else
				$cursosListarMais[] = $curso;
		}
		$this->system->session->addItem('resultado_busca_mais', $cursosListarMais);

		$this->system->view->assign('url_site', $this->system->getUrlSite());
		$this->system->view->assign('cursos', $cursosExibir);
		$this->system->view->display('site/carregar_mais.tpl');
		if (!count($cursosListarMais))  {
			echo "<script>$('#load-more').hide();$('#load-more-disable').fadeIn(500);</script>";
		}
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