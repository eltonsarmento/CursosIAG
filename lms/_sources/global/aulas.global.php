<?php
// ===================================================================
class AulasGlobal {
	// ===============================================================
	protected $system = null;
	protected $redir = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('aulas');
		$this->system->load->dao('curso');
		$this->system->load->dao('categorias');
		// $this->system->load->dao('professores');
	}
	// ===============================================================
	public function autoRun() {
				
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 					$this->doListar(); break;
			case 'novo': 					$this->doEdicao(); break;
			case 'editar': 					$this->doEditar(); break;
			case 'apagar': 					$this->doDeletar(); break;
			case 'mudarDescricao': 			$this->doMudarDescricao(); break;
			case 'salvarPosicao': 			$this->doMudarPosicao(); break;
			case 'salvarPosicaoAula': 		$this->doMudarPosicaoAula(); break;
			case 'salvarPosicaoCapitulos': 	$this->doMudarPosicaoCapitulos(); break;
			default: 						$this->pagina404(); break;
		}
		
	}
	// ===============================================================
	protected function doEditar() {
		if (!intval($this->system->input['editar'])) {
			$this->system->input['aula_id'] = $this->system->input['id'];
			$aula = $this->system->aulas->getAula($this->system->input['aula_id']);
			$this->system->input['id'] = $aula['capitulo_id'];
		}
		$this->doEdicao();
	}
	// ===============================================================
	protected function doEdicao() {
		$id = intval($this->system->input['id']); // capitulo_id
		$aula_id = intval($this->system->input['aula_id']);
		$editar = intval($this->system->input['editar']);
		
		if ($editar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('aulas', $this->system->input);
				$aula['posicao'] = $this->system->input['posicao'];
			} else {
				//Salvar
				if ($aula_id) {
					$this->system->aulas->atualizar($this->system->input);
					$this->system->view->assign('msg', 'Aula editada com sucesso!');
				}
				else {
					$this->system->aulas->cadastrar($this->system->input);
					$this->system->view->assign('msg', 'Aula cadastrada com sucesso!');
				}
				$this->system->input['id'] = $this->system->input['curso_id'];
				if (!$this->system->input['nova']) {
					if ($aula_id) 
						$this->system->session->addItem('msg', 'Aula editada com sucesso!');
					else
						$this->system->session->addItem('msg', 'Aula cadastrada com sucesso!');

					$this->system->func->redirecionar('/aulas/listar/' . $this->system->input['curso_id']);
					//$this->doListar();
					exit();
				}
				$aula_id = 0;
				//$this->system->view->assign('curso', $this->system->aulas->getAula($id));
			}
		} else {
			//Carregar conteudo
			if ($aula_id) {
				$aula = $this->system->aulas->getAula($aula_id);
			    $this->system->view->assign('aulas', $aula);
			}
		}
		
		$capitulo = $this->system->aulas->getCursoIdByCapitulo($id);
		$curso_id = $capitulo['curso_id'];
		$curso = $this->system->curso->getCurso($curso_id);

		//Chega acesso do parceiro
		if ($this->system->session->getItem('session_nivel') == 7 && $curso['id']) 
			$this->acessoParceiro($curso['id']);
		
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('curso'));
		$this->system->view->assign(array(
			'curso_id' 		=> $curso_id,
			'capitulo_id' 	=> $id,
			'aula_id' 		=> $aula_id,
			'url_site'		=> $this->system->getUrlSite(),
			'cursoNome' 	=> $curso['curso'],
			'capituloNome'	=> $capitulo['capitulo'],
			'n_aula'		=> ($aula['posicao'] ? $aula['posicao'] : $this->system->aulas->getUltimaPosicao($id)),
		));
		$this->system->view->display('global/aulas_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	public function validarDados() {
		$retorno = array();
        if (!$this->system->input['nome']) 
            $retorno['msg'][] = "O campo de nome está vazio.";
        
        if (!$this->system->input['tipo']) 
            $retorno['msg'][] = "Escolha o tipo da aula.";	

        //Video aula
        if ($this->system->input['tipo'] == 1 ) {
        	if (!$this->system->input['duracao']) 
            	$retorno['msg'][] = "A duração deve ser preenchida";

            if (!$this->system->input['vimeo'] && !$this->system->input['amazon'])
            	$retorno['msg'][] = "Um link vimeo ou amazon deve ser preenchido"; 
        }

        //PPT e pdf
        if ($this->system->input['tipo'] == 2 || $this->system->input['tipo'] == 3) {
            if (!$this->system->input['amazon'])
            	$retorno['msg'][] = "Um link amazon deve ser preenchido";
            if ($this->system->input['vimeo'])
            	$retorno['msg'][] = "Não é permitido link vimeo para esse tipo de conteúdo"; 
        }
        
        //Texto
        if ($this->system->input['tipo'] == 4) {
        	if (!$this->system->input['resumo'])
            	$retorno['msg'][] = "O resumo deve ser preenchido";
            if ($this->system->input['vimeo'])
            	$retorno['msg'][] = "Não é permitido link vimeo para esse tipo de conteúdo";
            if ($this->system->input['amazon'])
            	$retorno['msg'][] = "Não é permitido link amazon para esse tipo de conteúdo"; 
        }

        if(count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	protected function doListar() {
		$curso_id = (int)$this->system->input['id'];


		//msg
		if ($msg = $this->system->session->getItem('msg')) {
			$this->system->view->assign('msg', $msg);
			$this->system->session->deleteItem('msg');
		}

		//Chega acesso do parceiro
		if ($this->system->session->getItem('session_nivel') == 7 && $curso_id) 
			$this->acessoParceiro($curso_id);

		$curso = $this->system->curso->getCurso($curso_id);
		
		if ($this->system->session->getItem('alteradoPosicao')) {
			$this->system->view->assign(array('msg_alert' => 'Posições Alteradas!'));
			$this->system->session->deleteItem('alteradoPosicao');
		}

		$this->system->view->assign(array(
			'url_site'	=> $this->system->getUrlSite(),
			'cursoNome' => $curso['curso'],
			'curso_id' => $curso_id,
			'capitulos'	=> $this->system->aulas->getCapitulosByCurso($curso_id),
		));
		
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('curso'));
		$this->system->view->display('global/aulas_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$aula = $this->system->aulas->getAula($id);

			if ($this->system->session->getItem('session_nivel') == 7 && $aula['curso_id']) 
				$this->acessoParceiro($aula['curso_id']);

			$this->system->aulas->deletar($id);
			//$this->system->input['id'] = $aula['curso_id'];
		}
		//$this->system->view->assign('msg_alert','Aula excluída com sucesso!');
		$this->system->session->addItem('msg', 'Aula excluída com sucesso!');
		$this->system->func->redirecionar('/aulas/listar/' . $this->system->input['curso_id']);
		exit();
		//$this->doListar();
	}
	// ===============================================================
	protected function doMudarDescricao() {
		$capitulo_id = $this->system->input['capitulo_id'];
		$descricao = $this->system->input['descricao_edicao'];
		$editar = $this->system->input['editar'];
		$capitulo_posicao = $this->system->input['capitulo_posicao'];
		if ($editar && $capitulo_id) {
			$this->system->curso->atualizarDescricaoCapitulo($capitulo_id, $descricao);
			echo "Atualizado com sucesso!";
			echo "<script>
					jQuery('#capitulo_" . $capitulo_posicao . "').html('" . $descricao . "')
					jQuery('#descricao_" . $capitulo_posicao . "').val('" . $descricao . "')
			</script>";
		}
	}
	// ===============================================================
	protected function doMudarPosicao() {
		$capitulos = $this->system->input['capitulos'];
		$aulas = $this->system->input['aulas'];
		$curso_id = $this->system->input['curso'];
		$aulasAUX = array();
		foreach ($capitulos as $key => $capitulo)
			$aulasAUX[$capitulo] = $aulas[$key];

		$aulas = $aulasAUX;

		$this->system->aulas->salvarPosicaoCapitulos($curso_id, $capitulos);
		$this->system->aulas->salvarPosicaoAulas($curso_id, $aulas);

		$this->system->session->addItem('alteradoPosicao', true);

		echo "<script>window.location.reload();</script>";
	}
	// ==============================================================
	protected function acessoParceiro($cursoID) {
		// Parceiro
		if ($this->system->session->getItem('session_nivel') == 7) {
			$curso = $this->system->curso->getCurso($cursoID);

			//Curso não cadastrado pelo parceiro OU curso liberado para exibir na home 
			if ($curso['usuario_id'] != $this->system->session->getItem('session_cod_usuario') || $curso['home'] == 1) {
				$this->system->func->redirecionar('/curso/listar');
				exit();
			}	
		}
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================