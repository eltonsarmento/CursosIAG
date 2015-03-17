<?php
// ===================================================================
class CategoriasGlobal {
	// ===============================================================
	protected $system = null;
	protected $redir = '';
	protected $limit = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('categorias');
	}
	// ===============================================================
	public function autoRun() {

		switch($this->system->input['do']) {
			case 'listar': 	$this->doListar(); break;
			case 'nova': 	$this->doEdicao(); break;
			case 'editar': 	$this->doEdicao(); break;
			case 'apagar': 	$this->doDeletar(); break;
			case 'buscar':	$this->doListar(); break;
			default: 		$this->pagina404(); break;
		}
	}
	// ===============================================================
	protected function doEdicao() {
		$id = intval($this->system->input['id']);
		$editar = intval($this->system->input['editar']);
		
		if ($editar) {
			$this->system->input['url'] = $this->system->func->stringToUrl($this->system->input['categoria']);
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
			} else {
				if ($id) {
					$this->system->categorias->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Categoria alterada com sucesso!');
				}
				else {
					$id = $this->system->categorias->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Categoria cadastrada com sucesso!');
				}
				
				$this->system->input = array();
				unset($id);
			}
			$this->system->view->assign('categoria', array(
			   	'id' 	=> $id,
			    'nome' 	=> $this->system->input['categoria'],
			    'pai'	=> intval($this->system->input['categoria_pai_id']),
                'status' 	=> $this->system->input['status']
			));
		} else {
			if ($id) {
	            $categoria = $this->system->categorias->getCategoria($id);
			    $this->system->view->assign('categoria', array(
			    	'id' 	=> $categoria['id'],
				    'nome' 	=> $categoria['categoria'],
				    'pai'	=> $categoria['categoria_pai_id'],
                    'status' => $categoria['status']
				));
			}
		}

		//Listar conteudo cadastrado
		$this->limit = 10;
		$this->listagem();


		$this->system->view->assign('categorias_pais', $this->system->categorias->getCategoriasPais());
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('categorias'));
		$this->system->view->display('global/categoria_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
        $categoria = $this->system->input['categoria'];
        $url = $this->system->input['url'];
		
        if($categoria == '') 
            $retorno['msg'][] = "O campo de categoria está vazio.";
        elseif (!$this->system->func->isUnique('categorias', 'url', $url,  ' and excluido = 0 ' . ($this->system->input['id'] ? ' and id != ' . $this->system->input['id'] : '')))
        	$retorno['msg'][] = "Já existe uma categoria com esse nome, por favor usar outro nome, pois as urls são os nomes das categorias.";

		if(count($retorno) > 0){
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
		}
        return $retorno;
	}
	// ===============================================================
	protected function doListar() {
		$this->listagem();
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('categorias'));
		$this->system->view->display('global/categorias_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		
		$this->system->view->assign('categorias', $this->system->categorias->getCategorias($palavra, $this->limit));
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	protected function doDeletar() {
		$id = intval($this->system->input['id']);
		$categoria = $this->system->categorias->getCategoria($id);
		if ($categoria['id']) {
			$this->system->categorias->deletar($id);	
			$this->system->view->assign('msg_alert','Categoria ' . $categoria['categoria'] . ' excluída com sucesso');
		} 
		
		$this->system->func->redirecionar('/categorias/listar');
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->view->assign('categoria', 'coordenador');
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================