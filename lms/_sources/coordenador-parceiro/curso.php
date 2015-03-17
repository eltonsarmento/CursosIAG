<?php
require_once(dirname(__FILE__).'/../global/curso.global.php');
// ===================================================================
class Curso extends CursoGlobal {
	
	// ===============================================================
	public function autoRun() {
		
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
	}

	// ===============================================================
	protected function doEdicao() {
		$id = intval($this->system->input['id']);
		$editar = intval($this->system->input['editar']);

		//Chega acesso do parceiro
		if ($id) 
			$this->acessoParceiro($id);
		

		if ($editar) {
			$this->system->input['url'] = $this->system->func->stringToUrl($this->system->input['curso']);
			$this->system->input['home'] = 0;
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
		$this->system->view->display('coordenador-parceiro/curso_edicao.tpl');
		$this->system->admin->rodape();
	}

}
// ===================================================================