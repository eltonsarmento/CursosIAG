<?php
// ===================================================================
class Coordenadores {
	// ===============================================================
	private $system = null;
	private $redir = '';
	private $limit = '';

	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('coordenadores');
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
				$this->system->view->assign('coordenador', $this->system->input);
			} else {
				//Salvar
				if ($id) {
					$this->system->coordenadores->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Coordenador atualizado com sucesso!');
				}
				else {
					$id = $this->system->coordenadores->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Coordenador cadastrado com sucesso!');

					//Email Cadastro
					$this->system->email_model->cadastroCoordenador($this->system->input['email'], $this->system->input['nome'], $this->system->input['senha']);
				}
				
				//Img banner
				if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
					$extensao = end(explode('.', $_FILES['avatar']['name']));
					$nomearquivo = 'avatar_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/avatar/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/avatar/'.$nomearquivo);
					copy($_FILES['avatar']['tmp_name'], $this->system->getUploadPath().'/avatar/'.$nomearquivo);
					$this->system->coordenadores->atualizarImagem($id, $nomearquivo);
				}
				
				$this->doListar();
				exit();
				
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('coordenador', $this->system->coordenadores->getCoordenador($id, true));
		}
		
		$this->system->admin->topo(12);
		$this->system->view->display('administrador-geral/coordenadores_edicao.tpl');
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
        	$retorno['msg'][] = "O campo E-mail está vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
         elseif($this->system->coordenadores->checkEmailCadastrado($this->system->input['id'], $this->system->input['email']))
        	$retorno['msg'][] = "Já existe um usuário cadastrado com esse e-mail";
        
        //Email Secundário
        if($this->system->input['email_secundario'] && !$this->system->func->checkEmail($this->system->input['email_secundario']))
        	$retorno['msg'][] = "O campo E-mail Secundário é inválido";

        //CPF
        if ($this->system->input['cpf'] == '')
        	$retorno['msg'][] = "O campo CPF está vázio";
        elseif(!$this->system->func->validaCPF($this->system->input['cpf']))
        	$retorno['msg'][] = "O campo CPF é inválido.";

        //CEP
        if ($this->system->input['cep'] == '')
        	$retorno['msg'][] = "O campo CEP está vázio";

        //Endereço
        if ($this->system->input['endereco'] == '')
        	$retorno['msg'][] = "O campo Endereço está vázio";

        //Bairro
		if ($this->system->input['bairro'] == '')
        	$retorno['msg'][] = "O campo Bairro está vázio";        
        
        //Cidade
        if ($this->system->input['cidade'] == '')
        	$retorno['msg'][] = "O campo Cidade está vázio";

        //Estado
        if ($this->system->input['estado'] == '')
        	$retorno['msg'][] = "O campo Estado está vázio";

        //Senha
        if ($this->system->input['id'] == '') {
	        if ($this->system->input['senha'] == '')
	        	$retorno['msg'][] = "O campo Senha está vázio";
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
		$this->system->admin->topo(12);
		$this->system->view->display('administrador-geral/coordenadores_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		
		$coordenadores = $this->system->coordenadores->getCoordenadores($palavra, $this->limit);
		foreach ($coordenadores as $key => $coordenador) {
			$coordenadores[$key]['email_secundario'] = $this->system->coordenadores->getValorExtra($coordenador['id'], 'email_secundario');
			$coordenadores[$key]['cpf'] = $this->system->coordenadores->getValorExtra($coordenador['id'], 'cpf');
			$coordenadores[$key]['cep'] = $this->system->coordenadores->getValorExtra($coordenador['id'], 'cep');
			$coordenadores[$key]['bairro'] = $this->system->coordenadores->getValorExtra($coordenador['id'], 'bairro');
			$coordenadores[$key]['endereco'] = $this->system->coordenadores->getValorExtra($coordenador['id'], 'endereco');
			$coordenadores[$key]['cidade'] = $this->system->coordenadores->getValorExtra($coordenador['id'], 'cidade');
			$coordenadores[$key]['estado'] = $this->system->coordenadores->getValorExtra($coordenador['id'], 'estado');
			$coordenadores[$key]['telefone'] = $this->system->coordenadores->getValorExtra($coordenador['id'], 'telefone');
		}
		
		$this->system->view->assign('coordenadores', $coordenadores);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	private function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$coordenador = $this->system->coordenadores->getCoordenador($id);
			if($coordenador['nivel'] == 2) {
				$this->system->coordenadores->deletar($id);
				$this->system->view->assign('msg_alert', 'Coordenador excluído com sucesso!');
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