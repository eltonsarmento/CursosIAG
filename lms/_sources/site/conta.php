<?php
// ===================================================================
class Conta {
	// ===============================================================
	protected $system = null;
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('usuarios');
		$this->system->load->dao('alunos');
		$this->system->load->model('email_model');
		$this->system->load->dao('api');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'cadastro':	$this->doCadastro(); break;
			case 'lembrarSenha':$this->doLembrarSenha(); break;
			case 'redefinirSenha':$this->doRedefinirSenha(); break;
			default: 			$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doCadastro() {
		$editar = $this->system->input['editar'];
		
		if ($editar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msgErro', $erro_msg['msg']);
				$this->system->view->assign($this->system->input);
			} else {
				$campos['nome'] = $this->system->input['nome'];
				$campos['senha'] = $this->system->input['senha'];
				$campos['email'] = $this->system->input['email'];

				//Salvar
				$id = $this->system->alunos->cadastrar($campos);
				$this->system->view->assign('msgSucesso', 'Cadastro realizado com sucesso!');
                
                //$form_data_array = array('email' => $this->system->input['email'], 'nome' => $this->system->input['nome']);
                //$this->system->api->rdStation_lead('Novo Aluno', $form_data_array);
				
				//Email
				$this->system->email_model->cadastroAluno($this->system->input['email'], $this->system->input['nome'], $this->system->input['senha']);

				if (count($this->system->session->getItem('carrinho_produtos')) > 0)  {
					$this->system->session->addItem('msg_success', 'Sua conta foi criada com sucesso, pode realizar o login e continuar sua compra.');
					session_write_close();
					header('location: ' . $this->system->getUrlSite() . 'carrinho/verificaLogin/' );
					exit();
				}
			}
		}

		//exibir
		$this->system->view->assign('categoria', $categoria);
		$this->system->site->topo();
		$this->system->view->display('site/cadastro.tpl');
		$this->system->site->rodape(array('newsletter' => 1, 'tipo_conteudo' => 'Página', 'conteudo' => 'Cadastro'));	
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
        
		//Nome
        if($this->system->input['nome'] == '') 
            $retorno['msg'][] = "O campo nome está vázio.";
		
        //Email
        if ($this->system->input['email'] == '')
        	$retorno['msg'][] = "O campo E-mail está vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
        elseif($this->system->alunos->checkEmailCadastrado(0, $this->system->input['email']))
        	$retorno['msg'][] = "Já existe um usuário cadastrado com esse e-mail";
			
        //Senha
        if ($this->system->input['senha'] == '')
	       	$retorno['msg'][] = "O campo Senha está vázio";
	    elseif (strlen($this->system->input['senha']) < 5)
	       	$retorno['msg'][] = "O campo Senha deve ter pelo menos 5 digitos.";
	    
		if (count($retorno) > 0)
			$retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	protected function doLembrarSenha() {
		$enviar = $this->system->input['enviar'];
		$email = $this->system->input['email'];
		
		if ($enviar) {
			if (!$this->system->func->checkEmail($this->system->input['email']))
        		echo '<span class="alert alert-error" style="width:450px;">O campo E-mail é inválido</span>';
        	elseif(!$this->system->usuarios->checkEmailCadastrado(0, $this->system->input['email']))
        		echo '<span class="alert alert-error" style="width:450px;">Esse email não consta em nossa base</span>';
        	else {
        		$usuario = $this->system->usuarios->getUsuarioByEmail($email);
        		$this->system->email_model->lembrarSenha($usuario['nome'], $usuario['email'], $usuario['id_md5']);
        		echo '<span class="alert alert-success" style="width:450px;"> Foi enviado um e-mail informando os passos a seguir para redefinir a senha</span>';
        	}
		}
	}
	// ===============================================================
	protected function doRedefinirSenha() {
		$idMD5 = $this->system->input['id'];
		$usuario = $this->system->usuarios->getUsuarioByIdMd5($idMD5);
		$editar = $this->system->input['editar'];
		$id = $this->system->input['usuario_id'];
		
		if($editar && $id) {
			$senhaNova = $this->system->input['senha'];
			$senhaConfirmacao = $this->system->input['senha2'];
			
			if (!$senhaNova) 
				$erro[] = 'Necessário senha nova';
			elseif(strlen($senhaNova) < 5)
				$erro[] = 'Nova senha deve ter pelo menos 5 caracteres';
			elseif(!$senhaConfirmacao)
				$erro[] = 'Necessário repetir a senha';
			elseif($senhaNova != $senhaConfirmacao)
				$erro[] = 'A nova senha não corresponde a senha repetida';

			if (count($erro) > 0) {
				$this->system->view->assign('msgErro', implode('<br/>', $erro));		
			} else {
				$this->system->usuarios->atualizarSenha($id, $senhaNova);
				$this->system->view->assign('msgSucesso', 'Senha alterada com sucesso');		
			}
		}
		
		//exibir
		$this->system->view->assign('usuario', $usuario);
		$this->system->site->topo();
		$this->system->view->display('site/redefinir_senha.tpl');
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