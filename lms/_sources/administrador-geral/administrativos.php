<?php
// ===================================================================
class Administrativos {
	// ===============================================================
	private $system = null;
	private $redir = '';
	private $limit = '';

	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('administrativos');
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		
    	switch($this->system->input['do']) {
			case 'listar': 	$this->doListar(); break;
			case 'novo': 	$this->doEdicao(); break;
			case 'editar': 	$this->doEdicao(); break;
			case 'apagar': 	$this->doDeletar(); break;
			case 'buscar':	$this->doListar(); break;
			default: 		$this->pagina404(); break;
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
				$this->system->input['avatar'] = $this->system->input['visualizar_avatar'];
				$this->system->view->assign('administrativo', $this->system->input);
			} else {
				//Salvar
				if ($id) {
					$this->system->administrativos->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Administrativo atualizado com sucesso!');
				}
				else {
					$id = $this->system->administrativos->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Administrativo cadastrado com sucesso!');
				}
				
				//Img banner
				if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
					$extensao = end(explode('.', $_FILES['avatar']['name']));
					$nomearquivo = 'avatar_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/avatar/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/avatar/'.$nomearquivo);
					copy($_FILES['avatar']['tmp_name'], $this->system->getUploadPath().'/avatar/'.$nomearquivo);
					$this->system->administrativos->atualizarImagem($id, $nomearquivo);
				}

				$this->doListar();
				exit();
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('administrativo', $this->system->administrativos->getAdministrativo($id, true));
		}
		
		//Listar conteudo cadastrado
		$this->limit = 10;
		$this->listagem();
		
		$this->system->admin->topo(6);
		$this->system->view->display('administrador-geral/administrativos_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDados() {
		$retorno = array();
        //Nome
        if ($this->system->input['nome'] == '') 
            $retorno['msg'][] = "O campo Nome está vázio.";
		
        //Email
        if ($this->system->input['email'] == '')
        	$retorno['msg'][] = "O campo E-mail esta vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
         elseif($this->system->administrativos->checkEmailCadastrado($this->system->input['id'], $this->system->input['email']))
        	$retorno['msg'][] = "Já existe um usuário cadastrado com esse e-mail";
        
        //Senha
        if ($this->system->input['id'] == '') {
	        if ($this->system->input['senha'] == '')
	        	$retorno['msg'][] = "O campo Senha esta vázio";
	        elseif (strlen($this->system->input['senha']) < 5)
	        	$retorno['msg'][] = "O campo Senha deve ter pelo menos 5 digitos.";
	    }
	    
        //Arquivo destaque
		if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
			$extensao = end(explode('.', $_FILES['avatar']['name']));
			if (in_array($extensao, array('jpg', 'gif', 'png'))) {
				$configPerfil = $this->system->configuracoesgerais->getImagensPerfil();

				if (($_FILES['avatar']['size'] / 1024) > $configPerfil['imagem_perfil_tamanho']) {
					$retorno['msg'][] = 'A Imagem do destaque está com mais de ' . $configPerfil['imagem_perfil_tamanho'] . 'kb';
				}
			} else {
				$retorno['msg'][] = 'Formato de Imagem do destaque inválido';
			}
		}
		
		if (count($retorno) > 0)
		   $retorno['msg'] = implode('<br/>', $retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	private function doListar() {
		$this->listagem();
		$this->system->admin->topo(6);
		$this->system->view->display('administrador-geral/administrativos_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		
		$administrativos = $this->system->administrativos->getAdministrativos($palavra, $this->limit);
		foreach ($administrativos as $key => $professor)
			$administrativos[$key]['cpf'] = $this->system->administrativos->getValorExtra($professor['id'], 'cpf');
		
		$this->system->view->assign('administrativos', $administrativos);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	private function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$administrativo = $this->system->administrativos->getAdministrativo($id);
			if($administrativo['nivel'] == 6) {
				$this->system->administrativos->deletar($id);
				$this->system->view->assign('msg_alert', 'Administrativo excluído com sucesso!');
			} else {
				$this->system->view->assign('msg_alert', 'Não foi possível excluir esse usuário!');	
			}
		}
		$this->doListar();
	}
	// ===============================================================
	private function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================