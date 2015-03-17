<?php
// ===================================================================
class notificacoesadmin {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('notificacoes');
		$this->system->load->dao('alunos');
		$this->system->load->dao('curso');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		
		switch($this->system->input['do']) {
			case 'nova': 	$this->doEdicao(); break;
			case 'editar': 	$this->doEdicao(); break;
			case 'buscar': 	$this->doListar(); break;
			case 'listar': 	$this->doListar(); break;
			case 'apagar': 	$this->doDeletar(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	private function doEdicao() {
		$id = intval($this->system->input['id']);
		$editar = intval($this->system->input['editar']);
		
		if ($editar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('notificacao', $this->system->input);
			} else {
				//Salvar
				if ($id){
					$this->system->notificacoes->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Notificação atualizada com sucesso!');
				}
				else{
					$id = $this->system->notificacoes->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Notificação cadastrada com sucesso!');
					//$this->system->email_model->envioNotificacoes($this->system->input['titulo'], $this->system->input['conteudo'], $this->system->input['destinatario_nivel'], $this->system->input['cursos']);

				}
				$this->doListar();
				exit();
				
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('notificacao', $this->system->notificacoes->getNotificacao($id));
		}
		$this->system->view->assign('cursos', $this->system->curso->getCursos());
		$this->system->admin->topo(10);
		$this->system->view->display('administrador-geral/notificacoes_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDados() {
		//Titulo
        if ($this->system->input['titulo'] == '' )
        	$retorno['msg'][] = "O campo título deve ser preenchido";

        //Destinatario
        if ($this->system->input['destinatario_nivel'] == 0 )
        	$retorno['msg'][] = "O campo destinatário deve ser preenchido";

        //Curso
        if ($this->system->input['destinatario_nivel'] == 4 && count($this->system->input['cursos']) == 0)
        	$retorno['msg'][] = "O campo cursos deve ter uma opção selecionada";
		
		//Conteudo
        if ($this->system->input['conteudo'] == '' )
        	$retorno['msg'][] = "O campo notificação deve ser preenchido";

		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	private function doListar() {
		$this->listagem();
		$this->system->admin->topo(10);
		$this->system->view->display('administrador-geral/notificacoes_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		
		$notificacoes = $this->system->notificacoes->getNotificacoesGeral($palavra, $this->limit);
		
		$this->system->view->assign('notificacoes', $notificacoes);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}

	// ===============================================================
	private function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$this->system->notificacoes->deletar($id);
			$this->system->view->assign('msg_alert', 'Notificação excluída com sucesso!');
		}
		$this->doListar();
	}

	// ===============================================================
	private function pagina404() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================
