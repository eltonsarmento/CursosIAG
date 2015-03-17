<?php
// ===================================================================
class PerfilGlobal {
	// ===============================================================
	protected $system = null;
	protected $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('usuarios');
		$this->system->load->dao('configuracoesgerais');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		
		switch($this->system->input['do']) {
			case 'editar': $this->doEditar(); break;
			// case 'desativar': $this->doDeletar(); break;
			// case 'mudartheme': $this->doMudarTheme(); break;
			case 'trocarSenha': $this->doAlterarSenha(); break;
			default: $this->doEditar(); break;
		}
	}
	// ===============================================================
	protected function doEditar() {
		$id = $this->system->session->getItem('session_cod_usuario');
		if (!$id || ($this->system->session->getItem('session_nivel') != 4)) {
			session_write_close();
			header('Location: ' . $this->system->getUrlSite() . 'lms/'.$this->system->admin->getCategoria().'/dashboard/home/');
			exit();
		}
		$editar = intval($this->system->input['editar']);
		if ($editar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->input['avatar'] = $this->system->input['avatar_arquivo_visualizar'];
				$this->system->view->assign('usuario', $this->system->input);
			} else {
				$this->system->input['id'] = $id;
				$this->system->input['ativo'] = 1;
				switch($this->system->session->getItem('session_nivel')) {
					case 4:
						$this->system->alunos->atualizar($this->system->input);
				}
				$this->system->session->addItem('session_email', $this->system->input['email']);
				$this->system->session->addItem('session_nome', $this->system->input['nome']);

				
				
				if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
					$extensao = end(explode('.', $_FILES['avatar']['name']));
					$nomearquivo = 'avatar_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/avatar/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/avatar/'.$nomearquivo);
					copy($_FILES['avatar']['tmp_name'], $this->system->getUploadPath().'/avatar/'.$nomearquivo);
					$this->system->usuarios->atualizarImagem($id, $nomearquivo);
					$this->system->session->addItem('session_avatar', $nomearquivo);
				}
				
				$this->system->view->assign('msg_alert', 'Ação realizada com sucesso!');
				$this->system->view->assign('usuario', $this->system->usuarios->getUsuario($id));
			}
		} else {
			$this->system->view->assign('usuario', $this->system->usuarios->getUsuario($id));
		}
		$this->system->view->assign('url_site', $this->system->getUrlSite());
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());

		$menu = 0;
		if (in_array($this->system->session->getItem('session_nivel'), array(4))) //Professor e Aluno
			$menu = 2;
		
		$this->system->admin->topo($menu);
		$this->system->view->display($this->system->admin->getCategoria() . '/perfil_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	public function validarDados() {
		$retorno = array();
        if (!$this->system->input['nome']) 
            $retorno['msg'][] = "O campo nome está vazio.";
        
        if (!$this->system->input['email']) 
            $retorno['msg'][] = "O campo email está vazio.";
        elseif(!preg_match('/[a-z0-9]+@[a-z0-9]+\.com/', $this->system->input['email']))
        	$retorno['msg'][] = "Formato de e-mail inválido.";
        if (!$this->system->input['cep']) 
            $retorno['msg'][] = "O campo CEP está vazio.";
        elseif(!preg_match('/[0-9]{5}-[0-9]{3}/', $this->system->input['cep']))
        	$retorno['msg'][] = "O campo CEP está em formato invalido. Formato padrão: 12345-678.";

        if (!$this->system->input['endereco']) 
            $retorno['msg'][] = "O campo endereço está vazio.";

        if (!$this->system->input['bairro']) 
            $retorno['msg'][] = "O campo bairro está vazio.";

        if (!$this->system->input['cidade']) 
            $retorno['msg'][] = "O campo cidade está vazio.";

        if (!$this->system->input['estado']) 
            $retorno['msg'][] = "O campo estado está vazio.";

		// if ($this->system->input['facebook'] && !preg_match('^http://www.facebook.com/(.+)?$', $this->system->input['facebook'])) 
  //           $retorno['msg'][] = "O campo precisa informa o link conforme o exemplo 'http://www.facebook.com/adrianogianini'.";        

  //       if ($this->system->input['twitter'] && !preg_match('^http://www.twitter.com/(.+)?$', $this->system->input['twitter'])) 
  //           $retorno['msg'][] = "O campo precisa informa o link conforme o exemplo 'http://www.twitter.com/adrianogianini'.";        

  //       if ($this->system->input['google'] && !preg_match('^http://plus.google.com/(.+)?$', $this->system->input['google'])) 
  //           $retorno['msg'][] = "O campo precisa informa o link conforme o exemplo 'https://plus.google.com/adrianogianini'.";          
			
		if(count($retorno) > 0) {
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
		}
        return $retorno;
	}
	// ===============================================================
	public function doDeletar() {
		$id = $this->system->session->getItem('session_cod_usuario');
		$this->system->usuarios->deletar($id);
		$this->system->session->endSession();
		session_write_close();
		header('Location:' . $this->system->getUrlSite() . 'lms/') ;
		exit();
	}
	// ===============================================================
	public function doMudarTheme() {
		$id = $this->system->session->getItem('session_cod_usuario');
		$theme = $this->system->input['theme'];
		if ($id && $theme) {
			$this->system->session->addItem('session_themecss', $theme);
			$this->system->usuarios->mudarTema($id, $theme);
		}
	}
	// ===============================================================
	public function doAlterarSenha() {
		$id = $this->system->session->getItem('session_cod_usuario');

		if (!$id) {
			session_write_close();
			header('Location: ' . $this->system->getUrlSite() . 'lms/'.$this->system->admin->getCategoria().'/dashboard/home/');
			exit();
		}

		$usuario  = $this->system->usuarios->getUsuario($id);

		$senhaAtual = $this->system->input['senha_atual'];
		$senhaNova = $this->system->input['senha_nova'];
		$senhaConfirmacao = $this->system->input['senha_confirmacao'];

		if (!$senhaAtual) 
			$erro[] = 'Necessário senha atual';
		elseif ($senhaAtual != $usuario['senha']) 
			$erro[] = 'Senha informada diferente da atual ';

		if (!$senhaNova) 
			$erro[] = 'Necessário senha nova';
		elseif(strlen($senhaNova) < 5)
			$erro[] = 'Nova senha deve ter pelo menos 5 caracteres';
		elseif(!$senhaConfirmacao)
			$erro[] = 'Necessário repetir a senha';
		elseif($senhaNova != $senhaConfirmacao)
			$erro[] = 'A nova senha não corresponde a senha repetida';

		if (count($erro) > 0) {
			echo '<p style="color:red;">' . implode('<br/>', $erro) . '</p>';
		} else {
			$this->system->usuarios->atualizarSenha($id, $senhaNova);
			echo '<p style="color:green;">Senha alterada com sucesso!<p>';
		}
	}

}
// ===================================================================
