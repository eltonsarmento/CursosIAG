<?php
// ===================================================================
class CoordenadorParceirosGlobal {
	// ===============================================================
	protected $system = null;
	private $redir = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('coordenador_parceiros');
		$this->system->load->dao('configuracoesgerais');
	}
	// ===============================================================
	public function autoRun() {

		$this->system->view->assign('categoria', $this->system->admin->getCategoria());		
		
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
	protected function doEdicao() {
		$id = intval($this->system->input['id']);
		$editar = intval($this->system->input['editar']);
		if ($editar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->input['avatar'] = $this->system->input['visualizar_avatar'];
				$this->system->view->assign('coordenador_parceiro', $this->system->input);
			} else {
				//Salvar
				if ($id) {
					$this->system->coordenador_parceiros->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Parceiro atualizado com sucesso!');
				} else {
					$id = $this->system->coordenador_parceiros->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Parceiro cadastrado com sucesso!');
				}
				
				//Img perfil
				if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
					$extensao = end(explode('.', $_FILES['avatar']['name']));
					$nomearquivo = 'avatar_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/avatar/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/avatar/'.$nomearquivo);
					copy($_FILES['avatar']['tmp_name'], $this->system->getUploadPath().'/avatar/'.$nomearquivo);
					$this->system->coordenador_parceiros->atualizarImagem($id, $nomearquivo);
				}
				
				
				$this->doListar();
				exit();
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('coordenador_parceiro', $this->system->coordenador_parceiros->getCoordenadorParceiro($id, true));
		}
				
		$this->system->admin->topo(14);
		$this->system->view->display('global/coordenador_parceiros_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
        //Nome
        if($this->system->input['nome'] == '') 
            $retorno['msg'][] = "O campo Nome está vázio.";
    
        //Email
        if ($this->system->input['email'] == '')
        	$retorno['msg'][] = "O campo E-mail esta vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
         elseif($this->system->coordenador_parceiros->checkEmailCadastrado($this->system->input['id'], $this->system->input['email']))
        	$retorno['msg'][] = "Já existe um usuário cadastrado com esse e-mail";
        
        //Senha
        if ($this->system->input['id'] == '') {
	        if ($this->system->input['senha'] == '')
	        	$retorno['msg'][] = "O campo Senha esta vázio";
	        elseif (strlen($this->system->input['senha']) < 5)
	        	$retorno['msg'][] = "O campo Senha deve ter pelo menos 5 digitos.";
	    }
        		
        //Arquivo perfil
		if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
			$extensao = end(explode('.', $_FILES['avatar']['name']));
			if (in_array($extensao, array('jpg', 'gif', 'png'))) {
				$configPerfil = $this->system->configuracoesgerais->getImagensPerfil();

				if (($_FILES['avatar']['size'] / 1024) > $configPerfil['imagem_perfil_tamanho']) {
					$retorno['msg'][] = 'A Imagem do perfil está com mais de ' . $configPerfil['imagem_perfil_tamanho'] . 'kb';
				}
			} else {
				$retorno['msg'][] = 'Formato de Imagem do perfil é inválida';
			}
		}
		
		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	protected function doListar() {
		$this->listagem();
		$this->system->admin->topo(14);
		$this->system->view->display('global/coordenador_parceiros_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		$coordenador_parceiros = $this->system->coordenador_parceiros->getCoordenadorParceiros($palavra, $this->limit);
		foreach ($coordenador_parceiros as $key => $parceiro) {
			$coordenador_parceiros[$key]['endereco'] = $this->system->coordenador_parceiros->getValorExtra($parceiro['id'], 'endereco');
			$coordenador_parceiros[$key]['bairro'] = $this->system->coordenador_parceiros->getValorExtra($parceiro['id'], 'bairro');
			$coordenador_parceiros[$key]['cidade'] = $this->system->coordenador_parceiros->getValorExtra($parceiro['id'], 'cidade');
			$coordenador_parceiros[$key]['estado'] = $this->system->coordenador_parceiros->getValorExtra($parceiro['id'], 'estado');
		}

		$this->system->view->assign('coordenador_parceiros', $coordenador_parceiros);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	protected function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$coordenadorParceiro = $this->system->coordenador_parceiros->getCoordenadorParceiro($id);
			if($coordenadorParceiro['nivel'] == 7) {
				$this->system->coordenador_parceiros->deletar($id);
				$this->system->view->assign('msg_alert', 'Coordenador Parceiro excluído com sucesso!');
			} else {
				$this->system->view->assign('msg_alert', 'Não foi possível excluir esse usuário!');	
			}
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