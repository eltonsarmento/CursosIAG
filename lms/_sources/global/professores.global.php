<?php
// ===================================================================
class ProfessoresGlobal {
	// ===============================================================
	protected $system = null;
	protected $limit = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('professores');
		$this->system->load->dao('duvidas');
		$this->system->load->dao('pagamentos');
		$this->system->load->dao('configuracoesgerais');
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
				case 'listar': 				$this->doListar(); break;
				case 'novo': 				$this->doEdicao(); break;
				case 'editar': 				$this->doEdicao(); break;
				case 'apagar': 				$this->doDeletar(); break;
				case 'buscar':				$this->doListar(); break;
				case 'estatisticas': 		$this->doEstatisticas(); break;
				case 'pagamentos': 			$this->doPagamentos(); break;
				case 'atualizaPagamento':	$this->doAtualizarPagamento(); break;
				default: 					$this->pagina404(); break;
			}	
    	} else  {
    		$this->pagina404();
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
				$this->system->view->assign('professor', $this->system->input);
			} else {
				//Salvar
				if ($id) {
					$this->system->professores->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Professor atualizado com sucesso!');
				}
				else {
					$id = $this->system->professores->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Professor cadastrado com sucesso!');

					//Email Cadastro
					$this->system->email_model->cadastroProfessor($this->system->input['email'], $this->system->input['nome'], $this->system->input['senha']);

				}
				
				//Img banner
				if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
					$extensao = end(explode('.', $_FILES['avatar']['name']));
					$nomearquivo = 'avatar_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/avatar/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/avatar/'.$nomearquivo);
					copy($_FILES['avatar']['tmp_name'], $this->system->getUploadPath().'/avatar/'.$nomearquivo);
					$this->system->professores->atualizarImagem($id, $nomearquivo);
				}

				$this->doListar();
				exit();
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('professor', $this->system->professores->getProfessor($id, true));
		}
		
		//Listar conteudo cadastrado
		$this->limit = 10;
		$this->listagem();
		
		$this->system->admin->topo(4);
		$this->system->view->display('global/professores_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
		//Nome
        if($this->system->input['nome'] == '') 
            $retorno['msg'][] = "O campo nome está vázio.";

        //Data de nascimento
        if($this->system->input['data_nascimento'] == '') 
            $retorno['msg'][] = "O campo Data de Nascimento está vázio.";
        elseif (!$this->system->func->checkDate($this->system->input['data_nascimento'], false))
        	$retorno['msg'][] = "O campo Data de Nascimento é inválido.";
       
       //CPF
        if ($this->system->input['cpf'] == '')
        	$retorno['msg'][] = "O campo CPF esta vázio";
        elseif (!$this->system->func->validaCPF($this->system->input['cpf']))
        	$retorno['msg'][] = "O campo CPF é inválido.";
        
        //Endereço
        if ($this->system->input['endereco'] == '')
        	$retorno['msg'][] = "O campo Endereço esta vázio";

        //Bairro
        if ($this->system->input['bairro'] == '')
        	$retorno['msg'][] = "O campo Bairro esta vázio";

        //Cidade
        if ($this->system->input['cidade'] == '')
        	$retorno['msg'][] = "O campo Cidade esta vázio";

        //Estado
        if ($this->system->input['estado'] == '')
        	$retorno['msg'][] = "O campo Estado esta vázio";

        //CEP
        if ($this->system->input['cep'] == '')
        	$retorno['msg'][] = "O campo CEP esta vázio";

        //Comissao
        if (!$this->system->input['comissao'])
        	$retorno['msg'][] = "O campo comissão está vázio.";
        elseif (!$this->system->func->isInt($this->system->input['comissao']))
        	$retorno['msg'][] = "O campo comissão deve ser um inteiro.";
        elseif ($this->system->input['comissao'] < 0 || $this->system->input['comissao'] > 100)
        	$retorno['msg'][] = "O campo comissão deve maior que 0 e menor que 100.";

        //Email
        if ($this->system->input['email'] == '')
        	$retorno['msg'][] = "O campo E-mail esta vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
         elseif($this->system->professores->checkEmailCadastrado($this->system->input['id'], $this->system->input['email']))
        	$retorno['msg'][] = "Já existe um usuário cadastrado com esse e-mail";
        
        //Senha
        if ($this->system->input['id'] == '') {
	        if ($this->system->input['senha'] == '')
	        	$retorno['msg'][] = "O campo Senha esta vázio";
	        elseif (strlen($this->system->input['senha']) < 5)
	        	$retorno['msg'][] = "O campo Senha deve ter pelo menos 5 digitos.";
	    }
	    
        //Dados Bancarios
        if ($this->system->input['agencia1'] == '' || $this->system->input['banco1'] == '' || $this->system->input['conta1'] == '' || $this->system->input['tipoconta1'] == 0 || $this->system->input['operacao1'] == '')
        	$retorno['msg'][] = "O campo Dados Bancario 1 deve ser verificado";

        //Arquivo destaque
		if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
			$extensao = end(explode('.', $_FILES['avatar']['name']));
			if (in_array($extensao, array('jpg', 'jpeg', 'gif', 'png'))) {
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
	protected function doListar() {
		$this->listagem();
		$this->system->admin->topo(4);
		$this->system->view->display('global/professores_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		
		$professores = $this->system->professores->getProfessores($palavra, $this->limit);
		foreach ($professores as $key => $professor) {
			$professores[$key]['temCurso'] = $this->system->professores->estaEnsinando($professor['id']);
			$professores[$key]['cpf'] = $this->system->professores->getValorExtra($professor['id'], 'cpf');
			$professores[$key]['estado'] = $this->system->professores->getValorExtra($professor['id'], 'estado');
			$professores[$key]['cidade'] = $this->system->professores->getValorExtra($professor['id'], 'cidade');
		}
		
		$this->system->view->assign('professores', $professores);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	protected function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$professor = $this->system->professores->getProfessor($id);
			if(!$this->system->professores->estaEnsinando($id) && $professor['nivel'] == 3) {
				$this->system->professores->deletar($id);
				$this->system->view->assign('msg_alert', 'Professor excluído com sucesso!');
			} else {
				$this->system->view->assign('msg_alert', 'Não foi possível excluir esse usuário!');	
			}
		}
		$this->doListar();
	}
	// ===============================================================
	protected function doPagamentos() {
		$ano = $this->system->input['ano'];
		$mes = $this->system->input['mes'];

		if (!$mes) $mes = (date('m')-1);
		if (!$ano) $ano = date('Y');

		$sqlExtra = " and t1.mes_faturado = '" . $ano . "-" . $mes . "-01'";
		
		$this->system->admin->topo(4);
		$this->system->view->assign('pagamentos', $this->system->pagamentos->getPagamentos($sqlExtra));
		$this->system->view->display('global/professores_pagamentos.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doAtualizarPagamento() {
		$id = intval($this->system->input['id']);
		$observacao = trim($this->system->input['observacoes']);
		if ($id) {
			$comprovante = false;
			if (is_uploaded_file($_FILES['arquivo']['tmp_name'])) {
				$extensao = $this->system->func->getExtensaoArquivo($_FILES['arquivo']['name']);
				if (in_array($extensao, array('pdf', 'doc', 'docx', 'rar', 'zip'))) {
					$comprovante = true;
					if ($_FILES['arquivo']['size'] > 10485760) {
						$retorno['msg'][] = 'O Comprovante está com mais de 10MB';
						$comprovante = false;
					}
				} else {
					$retorno['msg'][] = 'Comprovante de pagamento inválido';
					$comprovante = false;
				}
			}
			if (!count($retorno['msg'])) {
				$this->system->pagamentos->atualizaObservacao($id, $observacao);
				if ($comprovante) {
					$nomearquivo = 'comprovante_pagamento_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/comprovantes_pagamentos/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/comprovantes_pagamentos/'.$nomearquivo);
					copy($_FILES['arquivo']['tmp_name'], $this->system->getUploadPath().'/comprovantes_pagamentos/'.$nomearquivo);
					$this->system->pagamentos->atualizaComprovante($id, $nomearquivo);
				}
				$retorno['comprovante'] = $comprovante;
				$retorno['observacao'] = $observacao;
				$retorno['id'] = $id;
				$retorno['sucesso'] = 'Pagamento atualizado';
				$retorno['msg'] = '';
			}
		}
		echo json_encode($retorno);
		//print_r($_FILES);
		//print_r($_POST);
	}
	// ===============================================================
	protected function doEstatisticas() {
		$professores = $this->system->professores->getProfessores();

		foreach ($professores as $key => $professor) {
			$professores[$key]['total_cursos'] = $this->system->professores->countTotalCursos($professor['id']);
			$professores[$key]['total_duvidas'] = $this->system->duvidas->countTotalDuvidas("professor_id = '" . $professor['id'] . "'");
			$professores[$key]['total_respondidas'] = $this->system->duvidas->countTotalRespondida("and professor_id = '" . $professor['id'] . "'");
		}
		$this->system->view->assign('professores', $professores);

		$this->system->admin->topo(4);
		$this->system->view->display('global/professores_estatisticas.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================