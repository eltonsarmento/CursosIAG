<?php
// ===================================================================
class AlunosGlobal {
	// ===============================================================
	protected $system = null;
	private $limit = '';
	private $exibirPorPagina = 10;
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('alunos');
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
	protected function doEdicao() {
		$id = intval($this->system->input['id']);
		$editar = intval($this->system->input['editar']);
		if ($editar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('aluno', $this->system->input);
			} else {
				//Salvar
				if ($id) {
					$this->system->alunos->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Aluno atualizado com sucesso!');
				}
				else {
					$id = $this->system->alunos->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Aluno cadastrado com sucesso!');
					
					//Email
					$this->system->email_model->cadastroAluno($this->system->input['email'], $this->system->input['nome'], $this->system->input['senha']);
				}
				

				$this->doListar();
				exit();
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('aluno', $this->system->alunos->getAluno($id, true));
		}
		
		$this->system->admin->topo(2);
		$this->system->view->display('global/alunos_edicao.tpl');
		$this->system->admin->rodape();
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
        elseif($this->system->alunos->checkEmailCadastrado($this->system->input['id'], $this->system->input['email']))
        	$retorno['msg'][] = "Já existe um usuário cadastrado com esse e-mail";
			
       //CPF
        if ($this->system->input['cpf'] != '' && !$this->system->func->validaCPF($this->system->input['cpf']))
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
	    
		if (count($retorno) > 0)
			$retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	protected function doListar() {

		$this->listagem();
		$this->system->admin->topo(2);
		$this->system->view->display('global/alunos_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function listagem() {
		//modos de busca
		$palavra = $this->system->session->getItem('palavra_busca');
		$metodo_busca = 'padrao';
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		else {
			$palavra = $this->system->input['palavra_busca'];
		//	$metodo_busca = $this->system->input['metodo_busca'];
		}

		//Paginação
		$pagina = ($this->system->input['pag'] ? $this->system->input['pag'] : 1);
		if ($palavra)
			$paginacao['base_url'] = $this->system->func->baseurl('/alunos/buscar&palavra_busca=' . $palavra);
		else
			$paginacao['base_url'] = $this->system->func->baseurl('/alunos/listar');
		$paginacao['per_page'] = $this->exibirPorPagina;
		$paginacao['total_rows'] = $this->system->alunos->getTotal($palavra, $metodo_busca);
		$paginacao['cur_page'] = $pagina;
		$this->system->pagination->initialize($paginacao);
		$this->system->view->assign('paginacao', $this->system->pagination->create_links());
		
		//Resultado
		$inicial = ($this->exibirPorPagina * ($pagina - 1));
		$final = $this->exibirPorPagina;
		$limit = $inicial . ',' . $final;
		
		$alunos = $this->system->alunos->getAlunos($palavra, $metodo_busca, $limit);
		foreach ($alunos as $key => $aluno) {
			$alunos[$key]['cursos'] = $this->system->alunos->getCursos($aluno['id']);
			$alunos[$key]['cep'] = $this->system->alunos->getValorExtra($aluno['id'], 'cep');
			$alunos[$key]['endereco'] = $this->system->alunos->getValorExtra($aluno['id'], 'endereco');
			$alunos[$key]['bairro'] = $this->system->alunos->getValorExtra($aluno['id'], 'bairro');
			$alunos[$key]['cidade'] = $this->system->alunos->getValorExtra($aluno['id'], 'cidade');
			$alunos[$key]['estado'] = $this->system->alunos->getValorExtra($aluno['id'], 'estado');
			$alunos[$key]['cpf'] = $this->system->alunos->getValorExtra($aluno['id'], 'cpf');
			$alunos[$key]['telefone'] = $this->system->alunos->getValorExtra($aluno['id'], 'telefone');
		}
		$this->system->view->assign('alunos', $alunos);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	protected function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$cursos = $this->system->alunos->getCursos($id);
			$aluno = $this->system->alunos->getAluno($id);
			if(count($cursos) == 0 && $aluno['nivel'] == 4) {
				$this->system->alunos->deletar($id);
				$this->system->view->assign('msg_alert', 'Aluno excluído com sucesso!');
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