<?php
// ===================================================================
class CursoGlobal {
	// ===============================================================
	protected $system = null;
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('curso');
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->dao('quiz');
		$this->system->load->dao('categorias');
		$this->system->load->dao('professores');
	}
	// ===============================================================
	public function autoRun() {
				
		if (in_array($this->system->session->getItem('session_nivel'), $this->acessoPermitido)) {
    		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
			switch($this->system->input['do']) {
				case 'listar': 			$this->doListar(); break;
				case 'novo': 			$this->doEdicao(); break;
				case 'editar': 			$this->doEdicao(); break;
				case 'apagar': 			$this->doDeletar(); break;
				case 'buscar': 			$this->doListar(); break;
				case 'salvarServidor': 	$this->doSalvarServidor(); break;
				default: 				$this->pagina404(); break;
			}
		} else {
			$this->pagina404();
		}
	}
	// ===============================================================
	protected function doEdicao() {
		$id = intval($this->system->input['id']);
		$editar = intval($this->system->input['editar']);

		if ($editar) {
			$this->system->input['url'] = $this->system->func->stringToUrl($this->system->input['curso']);
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->input['destaque_arquivo'] = $this->system->input['visualizar_destaque_arquivo'];
				$this->system->input['banner_arquivo'] = $this->system->input['visualizar_banner_arquivo'];
				$this->system->view->assign('curso', $this->system->input);
			} else {
				//Salvar

				if ($id) {
					$this->system->curso->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Curso "' . $this->system->input['curso'] . '" editado com sucesso!');
				}
				else {
					$id = $this->system->curso->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Curso "' . $this->system->input['curso'] . '" cadastrado com sucesso!');
				}
				$this->system->curso->cadastrarCapitulos($id, $this->system->input['qt_capitulos']);
				//Img banner
				if (is_uploaded_file($_FILES['banner_arquivo']['tmp_name'])) {
					$extensao = substr($_FILES['banner_arquivo']['name'], -3);
					$nomearquivo = 'curso_banner_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/imagens/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/imagens/'.$nomearquivo);
					copy($_FILES['banner_arquivo']['tmp_name'], $this->system->getUploadPath().'/imagens/'.$nomearquivo);
					$this->system->curso->atualizarImagemBanner($id, $nomearquivo);
				}
				//Img destaque
				if (is_uploaded_file($_FILES['destaque_arquivo']['tmp_name'])) {
					$extensao = substr($_FILES['destaque_arquivo']['name'], -3);
					$nomearquivo = 'curso_destaque_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/imagens/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/imagens/'.$nomearquivo);
					copy($_FILES['destaque_arquivo']['tmp_name'], $this->system->getUploadPath().'/imagens/'.$nomearquivo);
					$this->system->curso->atualizarImagemDestaque($id, $nomearquivo);
				}

				$this->doListar();
				exit();
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('curso', $this->system->curso->getCurso($id));
		}
		
		$this->system->view->assign('certificado', $this->system->configuracoesgerais->getProdutosCertificados());
		$this->system->view->assign('suporte', $this->system->configuracoesgerais->getProdutosSuporte());
		$this->system->view->assign('categorias', $this->system->categorias->getCategoriasNiveis());
		$this->system->view->assign('cursos', $this->system->curso->getCursos());
		$this->system->view->assign('professores', $this->system->professores->getProfessores());
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('curso'));
		$this->system->view->display('global/curso_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	public function validarDados() {
		$retorno = array();
        if (!$this->system->input['curso']) 
            $retorno['msg'][] = "O campo de curso está vazio.";
        elseif (!$this->system->func->isUnique('cursos', 'url', $this->system->input['url'],  ' and excluido = 0 ' . ($this->system->input['id'] ? ' and id != ' . $this->system->input['id'] : '')))
        	$retorno['msg'][] = "Já existe um curso com esse nome, por favor usar outro, pois as urls são os nomes dos cursos.";
        
        if (!$this->system->input['tags']) 
            $retorno['msg'][] = "O campo de tags está vazio.";

        if (count($this->system->input['categorias']) == 0) 
            $retorno['msg'][] = "Escolha uma categoria.";
			
        if (!$this->system->input['gratuito'] && !$this->system->input['valor']) 
            $retorno['msg'][] = "Escolha um preço para o curso.";

        if (!$this->system->input['frete']) 
            $retorno['msg'][] = "Escolha um tipo de frete.";
			
        if (!$this->system->input['descricao']) 
            $retorno['msg'][] = "O campo descrição precisa ser preenchido.";
			
		if (!$this->system->input['requisito']) 
            $retorno['msg'][] = "O campo pré-requisito precisa ser preenchido.";
		
		if (!$this->system->input['publico']) 
            $retorno['msg'][] = "O campo público alvo precisa ser preenchido.";
		
		if (!$this->system->input['perfil']) 
            $retorno['msg'][] = "O campo perfil do aluno precisa ser preenchido.";
			
        if ($this->system->input['professor_id'] == 0) 
            $retorno['msg'][] = "O campo professor precisa ser preenchido.";
			
        if(!$this->system->input['qt_capitulos']) 
			$this->system->input['qt_capitulos'] = 1;

		if (!$this->system->func->isInt($this->system->input['carga_horaria']))
			$retorno['msg'][] = "O campo carga horária deve ser inteiro.";

		if ($this->system->input['id']) {
			if (!$this->system->curso->validarMudancaCapitulos($this->system->input['id'], $this->system->input['qt_capitulos']))
				$retorno['msg'][] = "Não é possivel reduzir o numero de capítulos. Existe capitulos com aula.";
		}

		if ($this->system->input['frete'] == 2 && !$this->system->input['valor_frete']) 
			$retorno['msg'][] = "Escolha um preço para o frete.";

		
		//Banner 
		if (!is_uploaded_file($_FILES['banner_arquivo']['tmp_name']) && !$this->system->input['id']) {
           $retorno['msg'][] = 'Selecione a Imagem do banner';
		} elseif (is_uploaded_file($_FILES['banner_arquivo']['tmp_name'])) {

			$configBanner = $this->system->configuracoesgerais->getImagensBanner();

			$extensao = end(explode('.', $_FILES['banner_arquivo']['name']));
			if (in_array($extensao, array('jpg', 'jpeg', 'gif', 'png'))) {
				if (($_FILES['banner_arquivo']['size']/1024) > $configBanner['imagem_banner_tamanho']) {
					$retorno['msg'][] = 'A Imagem do banner está com mais de ' . $configBanner['imagem_banner_tamanho'] . 'kb';
				}
			} else {
				$retorno['msg'][] = 'Formato de Imagem do banner inválido';
			}
		}

		//Arquivo destaque
		if (!is_uploaded_file($_FILES['destaque_arquivo']['tmp_name']) && !$this->system->input['id']) {
           $retorno['msg'][] = 'Selecione a Imagem do destaque';
		} elseif (is_uploaded_file($_FILES['destaque_arquivo']['tmp_name'])) {
			
			$configDestaque = $this->system->configuracoesgerais->getImagensDestacada();

			$extensao = end(explode('.', $_FILES['destaque_arquivo']['name']));
			if (in_array($extensao, array('jpg', 'jpeg', 'gif', 'png'))) {
				if (($_FILES['destaque_arquivo']['size'] / 1024) > $configDestaque['imagem_destacada_tamanho']) {
					$retorno['msg'][] = 'A Imagem do destaque está com mais de ' . $configDestaque['imagem_destacada_tamanho'] . 'kb';
				}
			} else {
				$retorno['msg'][] = 'Formato de Imagem do destaque inválido';
			}
		}

		if(count($retorno)>0){
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
		}
        return $retorno;
	}
	// ===============================================================
	protected function doListar() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');

		$sql = ($palavra != ''? " and curso like '%" . $palavra.  "%'" : '');
		if ($this->system->session->getItem('session_nivel') == 7) 
			$sql .= " and usuario_id = '"  . $this->system->session->getItem('session_cod_usuario') . "' and home = 0 ";

		$cursos = $this->system->curso->getCursosCondicao($sql);
		foreach ($cursos as $key => $curso) {
			//Professor
			$professor = $this->system->professores->getProfessor($curso['professor_id']);
			$cursos[$key]['professor'] = $professor['nome'];
			
			//Categorias
			$categorias = $this->system->curso->getCategoriasByCurso($curso['id']);
			$cursos[$key]['categorias'] = $categorias;
			
			//Alunos
			$cursos[$key]['alunos'] = $this->system->curso->getTotalAlunos($curso['id']);
			
			//Quiz
			$cursos[$key]['qt_quiz'] = $this->system->quiz->getTotalQuiz($curso['id']);
		}

		$this->system->view->assign('usuario_nivel', $this->system->session->getItem('session_nivel'));
		$this->system->view->assign('cursos', $cursos);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('curso'));
		$this->system->view->display('global/cursos_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doDeletar() {
		

		$id = intval($this->system->input['id']);
		
		//Chega acesso do parceiro
		if ($this->system->session->getItem('session_nivel') == 7 && $id) 
			$this->acessoParceiro($id);

		if ($id) {

			$curso = $this->system->curso->getCurso($id);
			$alunos = $this->system->curso->getTotalAlunos($curso['id']);
			if($curso['id'] && in_array($this->system->session->getItem('session_nivel'), array(1, 2, 7)) && $alunos['total'] == 0) {
				$this->system->curso->deletar($id);
				$this->system->view->assign('msg_alert', 'Curso "' . $curso['curso'] . '" excluído com sucesso!');
			} else {
				$this->system->view->assign('msg_alert', 'Não foi possível excluir esse curso!');	
			}
		}
		$this->doListar();
	}
	//===============================================================
    protected function doImportar() {
        $this->system->admin->topo($this->system->func->posicoesMenusGlobais('curso'));
		$this->system->view->display('global/cursos_importar.tpl');
        $this->system->admin->rodape();
    }
	//===============================================================
	protected function doSalvarServidor() {
		$curso_id = $this->system->input['curso_id'];
		$servidor = $this->system->input['servidor'];
		$posicao = $this->system->input['posicao'];
		$editar = $this->system->input['editar'];

		if ($editar && $curso_id) {
			$this->system->curso->salvarServidor($curso_id, $servidor);
			echo "Servidor atualizado com sucesso";
			echo "<script type='text/javascript'>
					jQuery('#servidor_" . $posicao . "').val('" . $servidor . "')
				</script>";
		}
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