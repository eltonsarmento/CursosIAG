<?php
// ===================================================================
class Planos {
	// ===============================================================
	private $system = null;
	private $redir = '';
	private $limit = '';
	private $producao = true;
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('planos');
		$this->system->load->dao('moip');
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
				$this->system->view->assign('plano', $this->system->input);
			} else {
				//Salvar
				if ($id) {
					$this->system->planos->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Plano atualizado com sucesso!');
				}
				else {
					$this->system->load->model('pagarme_model');
					$campos = $this->system->input;
					
					//Criação de plano no pagarme.
					if ($this->producao)
						$idPlano = $this->system->pagarme_model->criarPlano($campos);
					
					//if ($idPlano) {
						$this->system->input['codigoPlanoPagarme'] = $idPlano;
						$id = $this->system->planos->cadastrar($this->system->input);
						$this->system->view->assign('msg_alert', 'Plano cadastrado com sucesso!');
					//}
				}

				//Img banner
				if (is_uploaded_file($_FILES['imagem_arquivo']['tmp_name'])) {
					$extensao = explode('.', $_FILES['imagem_arquivo']['name']);
					$extensao = end($extensao);
					$nomearquivo = 'plano_imagem_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/imagens/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/imagens/'.$nomearquivo);
					copy($_FILES['imagem_arquivo']['tmp_name'], $this->system->getUploadPath().'/imagens/'.$nomearquivo);
					$this->system->planos->atualizarImagem($id, $nomearquivo);
				}

				//Moip
				/*
				if ($this->producao) {
					$moipPlano = array(
						"code" => "plano".$id,
	    				"name" => $this->system->input['plano'],
	    				"description" => $this->system->input['descricao'],
	    				"amount" => str_replace('.', '', $this->system->input['valor']), //em centavos
	    				"status" => ($this->system->input['status'] ? "ACTIVE" : "INACTIVE"),
	    				"interval" => array(
	        					"length" => $this->system->input['meses'],
	        					"unit" => "MONTH"
	    				)
	    			);
				}

				
				if ($this->producao) {
					try {
						if ($this->system->input['id'])  {
		    				if ($this->system->input['status'])
	    						$this->system->moip->ativarPlano($moipPlano['code']);	
	    					else
	    						$this->system->moip->desativarPlano($moipPlano['code']);	
						}
	    				else
	    					$this->system->moip->cadastrarPlano($moipPlano);	
					} catch (Exception $e) {
						$this->system->view->assign('msg_alert', $e->getMessage());
					}
				}
    			*/
    			
				$this->doListar();
				die;
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('plano', $this->system->planos->getPlano($id));
		}
		
		$this->system->admin->topo(8);
		$this->system->view->display('administrador-geral/planos_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDados() {
		$retorno = array();
    	
    	//plano
    	if($this->system->input['plano'] == '') 
            $retorno['msg'][] = "O campo Nome do Plano está vázio.";

        //meses
        if($this->system->input['meses'] == '') 
            $retorno['msg'][] = "O campo Quantidade de Meses está vázio.";
        elseif(intval($this->system->input['meses']) == 0)
            $retorno['msg'][] = "O campo Quantidade de Meses deve ser númerico maior que zero.";
        else
        	$this->system->input['meses'] = intval($this->system->input['meses']);

        //valor
        if ($this->system->input['valor'] == '') 
            $retorno['msg'][] = "O campo Valor do Plano está vázio.";

        if ($this->system->input['cursos_tipo_acessos'] == '') 
            $retorno['msg'][] = "O campo Tipo de Plano precisa ser selecionado.";

        // formato novo de planos
    	//if ($this->system->input['cursos_tipo_acessos'] == 1 && intval($this->system->input['cursos_qtd_mes']) == 0) 
        //    $retorno['msg'][] = "O campo Quantidade de Cursos do Plano está vázio e deve ser númerico maior que zero.";
        //else
        //	$this->system->input['cursos_qtd_mes'] = intval($this->system->input['cursos_qtd_mes']);

        //imagem 
		if (!is_uploaded_file($_FILES['imagem_arquivo']['tmp_name']) && !$this->system->input['id']) {
           $retorno['msg'][] = 'Selecione a Imagem do plano';
		} elseif (is_uploaded_file($_FILES['imagem_arquivo']['tmp_name'])) {
			$extensao = end(explode('.', $_FILES['imagem_arquivo']['name']));
			if (!in_array($extensao, array('jpg', 'jpeg', 'gif', 'png'))) {
				$retorno['msg'][] = 'Formato de Imagem do banner inválido';
			}
		}

		if (count($retorno))
		   $retorno['msg'] = implode('<br/>', $retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	private function doListar() {
		$this->listagem();
		$this->system->admin->topo(8);
		$this->system->view->display('administrador-geral/planos_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		
		$planos = $this->system->planos->getPlanos($palavra, $this->limit);
		
		$this->system->view->assign('planos', $planos);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	private function doDeletar() {
		$id = intval($this->system->input['id']);
		$plano = $this->system->planos->getPlano($id);
		if ($plano['id']) {

			$this->system->planos->deletar($plano['id']);
			$this->system->view->assign('msg_alert', 'Plano "' . $plano['plano'] . '" excluído com sucesso!');
		} else {
			$this->system->view->assign('msg_alert', 'Não foi possível excluir esse plano!');	
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