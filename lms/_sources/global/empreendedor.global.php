<?php
// ===================================================================
class EmpreendedorGlobal {
	// ===============================================================
	protected $system = null;
	private $limit = '';
	private $exibirPorPagina = 10;
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('empreendedor');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);


    	if (in_array($this->system->session->getItem('session_nivel'), $this->acessoPermitido)) {
    		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
    		switch($this->system->input['do']) {

				case 'listar': 	$this->doListar(); break;
				case 'novo': 	$this->doEdicao(); break;
				case 'editar': 	$this->doEdicao(); break;
				case 'apagar': 	$this->doDeletar(); break;
				case 'buscar':	$this->doListar(); break;
				default: 		$this->pagina404(); break;
			}	
    	} else  {
    		$this->pagina404();
    	}	
	}
	// ===============================================================
	protected function doEdicao(){
		$editar = $this->system->input['editar'];
		$id = $this->system->input['id'];

		if($editar){
			$msg_alert = $this->validarDados();
			if($msg_alert){
				$this->system->view->assign('empreendedor', $this->system->input);	
				$this->system->view->assign('msg_alert', $msg_alert['msg']);	
			}else{
				if($id){
					$this->system->empreendedor->atualizar($this->system->input);
					$msg_alert = "Atualizado com sucesso!";
					$this->system->view->assign('msg_alert', $msg_alert);	
					$this->system->view->assign('empreendedor', $this->system->input);	
				}else{
					$this->system->empreendedor->cadastrar($this->system->input);
					$msg_alert = "Cadastrado com sucesso!";
					$this->system->view->assign('msg_alert', $msg_alert);	
				}	
			}			
		}else{
			if($id){
				$empreendedor = $this->system->empreendedor->getCantoEmpreendedor($id);
				$this->system->view->assign('empreendedor', $empreendedor);	
			}

		}
		$this->system->admin->topo(15);
		$this->system->view->display('administrador-geral/empreendedor_editar.tpl');
		$this->system->admin->rodape();
	}

	protected function validarDados() {
		$retorno = array();  
		//Titulo
        if($this->system->input['titulo'] == '') 
            $retorno['msg'][] = "O campo Titulo está vázio.";
		
        //Descricao
        if ($this->system->input['descricao'] == '')
        	$retorno['msg'][] = "O campo Descrição está vázio";

        //Tipo do video
        if ($this->system->input['tipo_video'] == '')
        	$retorno['msg'][] = "O campo Tipo do vídeo deve ser preenchido";
			
        //Link do video
        if ($this->system->input['link_video'] == '')
        	$retorno['msg'][] = "O campo Link do vídeo está vázio";
			
        //Fonte
        if ($this->system->input['fonte'] == '')
        	$retorno['msg'][] = "O campo Fonte está vázio";

		if (count($retorno) > 0)
			$retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	protected function doListar() {
		$this->listagem();
		$this->system->admin->topo(15);
		$this->system->view->display('administrador-geral/empreendedor_listar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function listagem() {
		$empreendedor = $this->system->empreendedor->getCantosEmpreendedores();
		$this->system->view->assign('empreendedor',$empreendedor);
	}
	// ===============================================================
	protected function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$this->system->empreendedor->excluir($id);
			$this->system->view->assign('msg_alert', 'Excluído com sucesso!');
		}
		$this->doListar();
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================