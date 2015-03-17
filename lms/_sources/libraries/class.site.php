<?php
// ===================================================================
class Site {
	// ===============================================================
	private $module = '';
	private $categoria = 'site';
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
		//eval(base64_decode('aWYoZGlybmFtZShfX0ZJTEVfXykgIT0gJy9ob21lL3VuaXZlcnNvZWR1Y2FjaW8vd3d3L2xtcy9fc291cmNlcy9saWJyYXJpZXMnKSBkaWU7teste'));
	}
	// ===============================================================
    public final function Load($module) {
   
        $this->module = $this->_name_cleaner($this->system->func->iif($module == '', 'home', $module));
			
 		if(file_exists($this->system->getRootPath() . '/_sources/'.$this->categoria.'/' . strtolower($this->module) . '.php'))
            $arquivo = $this->system->getRootPath() . '/_sources/'.$this->categoria.'/' . strtolower($this->module) . '.php';
        else {
        	$this->module = 'erro';
        	$arquivo = $this->system->getRootPath() . '/_sources/'.$this->categoria.'/erro.php';
        }
		
		require($arquivo);
	}
	// ===============================================================
	public final function Run() {
		$modulename = ucfirst($this->module);
		$class = new $modulename($this->system);
		$class->autoRun();
	}
	// ===============================================================
    private function _name_cleaner($name) {
        return preg_replace("/[^a-zA-Z0-9\-\_]/", "", $name);
    }
	// ===============================================================
	public function topo($tituloPagina = '', $descricaoPagina = '') {
		$this->system->load->dao('categorias');
		$this->system->load->dao('curso');

		//Categorias com cursos
		if (!$categoriasPais = $this->system->func->getCacheVariaveis('categoriasPaisTopo')) {
			$categoriasPais = $this->system->categorias->getCategoriasNiveis('categoria desc');
			foreach ($categoriasPais as $key => $categoriaPai) {
				$categoriasID = array();
				$categoriasID[] = $categoriaPai['id'];
				if ($categoriaPai['filhas']) {
					foreach ($categoriaPai['filhas'] as $categoriaFilha) 
						$categoriasID[] = $categoriaFilha['id'];
					$categoriasPais[$key]['filhas'];
				}

				$categoriasPais[$key]['ultimosLancamentos'] = $this->system->curso->getCursosByCategorias($categoriasID, 4);
				$categoriasPais[$key]['maisAcessados'] = $this->system->curso->getMaisAcessadosCursosByCategorias($categoriasID, 4);
			}
			$this->system->func->setCacheVariaveis('categoriasPaisTopo', $categoriasPais);	
		}
		
		//Todos os Cursos da Busca
		if (!$cursosLiveSearch = $this->system->func->getCacheVariaveis('cursosLiveSearch')) {
			$cursosLiveSearch = $this->system->curso->getCursosCondicao(' and home = 1', '', 'curso', 'id, curso, destaque_arquivo, url');
			$this->system->func->setCacheVariaveis('cursosLiveSearch', $cursosLiveSearch);	
		}

		$this->system->view->assign(array(
			'usuario_id'		=> $this->system->session->getItem('session_cod_usuario'),
			'usuario_nome'		=> $this->system->session->getItem('session_nome'),
			'usuario_categoria'	=> $this->system->session->getItem('session_nivel_categoria'),
			'carrinhoTotal'		=> count($this->system->session->getItem('carrinho_produtos')),
			'url_site'			=> $this->system->getUrlSite(),
			'categoriasTopo'	=> $categoriasPais,
			'cursosLiveSearch'	=> $cursosLiveSearch,
			'tituloPagina'		=> $tituloPagina,
            'descricaoPagina'   => $descricaoPagina
		));
        echo $this->system->view->fetch($this->categoria.'/estrutura.tpl');
	}
	// ===============================================================
	public function rodape($parametros = array()) {
		if ($parametros['newsletter']) {
			$this->system->view->assign('newsletter', array(
				'conteudo'			=> $parametros['tipo_conteudo'] . ' - ' . $parametros['conteudo']
			));
		} else {
			$this->system->view->assign('newsletter', array(
				'conteudo'			=> 'Página' . ' - ' . 'Home'
			));
		}
		echo $this->system->view->fetch($this->categoria.'/rodape.tpl');
	}
	// ===============================================================
	public function getCategoria() {
		return $this->categoria;
	}
	// ===============================================================
}
// ===================================================================