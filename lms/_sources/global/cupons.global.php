<?php
// ===================================================================
class CuponsGlobal {
	// ===============================================================
	protected $system = null;
	protected $limit = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('cupons');
		$this->system->load->dao('curso');
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
				case 'listar': 			$this->doListar(); break;
				case 'buscar':			$this->doListar(); break;
				case 'novo': 			$this->doEdicao(); break;
				case 'editar': 			$this->doEdicao(); break;
				case 'apagar': 			$this->doDeletar(); break;
				case 'relatorio':		$this->doRelatorio(); break;
				default: 				$this->pagina404(); break;
			}	
    	} else  {
    		$this->pagina404();
    	}	
	}
	// ===============================================================
	protected function doEdicao() {
		$id 	= intval($this->system->input['id']);
		$editar = intval($this->system->input['editar']);
		if ($editar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('cupom', $this->system->input);
			} else {
				if ($id) {
					$this->system->cupons->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Cupom atualizado com sucesso!');
				}
				else {
					$id = $this->system->cupons->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Cupom cadastrado com sucesso!');
				}
				
				$this->doListar();
				exit();
			}
		} else {
			if ($id) 
			    $this->system->view->assign('cupom', $this->system->cupons->getCupom($id));
		}
		//Listar conteudo cadastrado
		$this->limit = 10;
		$this->listagem();
		
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('cupons'));
		$this->system->view->assign('cursos', $this->system->curso->getCursos());
		$this->system->view->display('global/cupons_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
		$id 	 = intval($this->system->input['id']);

		if($this->system->input['nome'] == '') 
            $retorno['msg'][] = "O campo Nome está vazio.";
        elseif(!$this->system->func->isUnique('cupons', 'nome', $this->system->input['nome'], "and excluido = '0' " . ($id? "and id != '" . $id .  "'" : ''))) 
			$retorno['msg'][] = "Já existe um cupom com esse nome.";

		if ($this->system->input['tipo'] == 0)
        	$retorno['msg'][] = "O campo Tipo está vazio";
		
		if ($this->system->input['tipo'] == 2) {
			if($this->system->input['tempo_de'] == '') 
				$retorno['msg'][] = "O campo Tempo De está vazio.";
			elseif (!$this->system->func->checkDate($this->system->input['tempo_de'], false))
				$retorno['msg'][] = "O campo Tempo De é inválido.";
			
			if($this->system->input['tempo_ate'] == '') 
				$retorno['msg'][] = "O campo Tempo Até está vázio.";
			elseif (!$this->system->func->checkDate($this->system->input['tempo_ate'], true))
				$retorno['msg'][] = "O campo Tempo Até é inválido.";
		}

		if ($this->system->input['tipo'] == 3) {
			if ($this->system->input['quantidade'] == '')
				$retorno['msg'][] = "O campo Quantidade está vazio";
		}
		
		if ($this->system->input['valor'] == '')
        	$retorno['msg'][] = "O campo Valor está vazio";

        if (count($this->system->input['cursos_excluidos']) && count($this->system->input['cursos_ativos'])) {
        	$retorno['msg'][] = "Não pode selecionar cursos excluídos se tiver selecionado cursos válidos";
        }
	   
		if (count($retorno) > 0)
		   $retorno['msg'] = implode('<br/>', $retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	protected function doListar() {
		$this->listagem();
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('cupons'));
		$this->system->view->display('global/cupons_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');

		$cupons = $this->system->cupons->getCupons($palavra);
		$this->system->view->assign('cupons', $cupons);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	protected function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$this->system->cupons->deletar($id);
			$this->system->view->assign('msg_alert', 'Cupom excluído com sucesso!');
		}
		$this->doListar();
	}
	// ===============================================================
	protected function doRelatorio() {
		$this->system->view->assign('cupons', $this->system->cupons->relatorioUso());
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('cupons'));
		$this->system->view->display('global/cupons_relatorio.tpl');
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