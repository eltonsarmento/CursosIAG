<?php
// ===================================================================
class DuvidasGlobal {
	// ===============================================================
	protected $system = null;
	protected $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('duvidas');
		$this->system->load->dao('professores');
		$this->system->load->dao('curso');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {		
		switch($this->system->input['do']) {
			case 'listar': 				$this->doListar(); break;
			case 'buscar': 				$this->doListar(); break;
			case 'excluidos': 			$this->doExcluidos(); break;
			case 'excluir': 			$this->doExcluir(); break;
			case 'restaurar': 			$this->doRestaurar(); break;
			case 'nova': 				$this->doCadastro(); break;
			case 'responder':			$this->doResponder(); break;
			case 'fechar':				$this->doFechar(); break;
			case 'buscarProfessores': 	$this->doMudarProfessores(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	protected function doListar() {}
	// ===============================================================
	protected function doExcluidos() {}
	// ===============================================================
	protected function doExcluir() {
		$usuarioId = $this->system->session->getItem('session_cod_usuario');
		$duvidaId = $this->system->input['id'];

		$duvida = $this->system->duvidas->getDuvida("(aluno_id = '" . $usuarioId . "' OR professor_id = '" . $usuarioId . "') AND id = '" . $duvidaId . "' and fechada = 0" );
		if ($duvida['id']) {
			//se a duvida estiver excluida, ativa novamente
			$this->system->duvidas->atualizar($duvida['id'], array('fechada' => 1));

			if ($duvida['aluno_id'] != $usuarioId)
				$destinatarioId = $duvida['aluno_id'];
			else
				$destinatarioId = $duvida['professor_id'];

			$campos['duvida_id'] = $duvidaId;
			$campos['destinatario_id'] = $destinatarioId;
			$campos['comentario'] = ' -- DÚVIDA FECHADA --';

			$this->system->duvidas->cadastrarResposta($campos);
		}


		if ($this->system->session->getItem('session_nivel_categoria') == 'aluno')
			$this->system->duvidas->excluir($duvidaId, $usuarioId, true);
		else 
			$this->system->duvidas->excluir($duvidaId, $usuarioId, false);

		$this->system->func->redirecionar('/duvidas/listar');
	}
	// ===============================================================
	protected function doRestaurar() {
		$usuarioId = $this->system->session->getItem('session_cod_usuario');
		$duvidaId = $this->system->input['id'];

		if ($this->system->session->getItem('session_nivel_categoria') == 'aluno')
			$this->system->duvidas->restaurar($duvidaId, $usuarioId, true);
		else 
			$this->system->duvidas->restaurar($duvidaId, $usuarioId, false);

		$this->system->func->redirecionar('/duvidas/excluidos');
	}
	// ===============================================================
	protected function doResponder() {
		$usuarioId = $this->system->session->getItem('session_cod_usuario');
		$duvidaId = $this->system->input['id'];

		$duvida = $this->system->duvidas->getDuvida("(aluno_id = '" . $usuarioId . "' OR professor_id = '" . $usuarioId . "') AND id = '" . $duvidaId . "'" );

		if ($duvida['id']) {
			//se a duvida estiver excluida, ativa novamente
			$this->system->duvidas->atualizar($duvida['id'], array('excluido_aluno' => 0, 'excluido_professor' => 0, 'fechada' => 0));

			if ($duvida['aluno_id'] != $usuarioId)
				$destinatarioId = $duvida['aluno_id'];
			else
				$destinatarioId = $duvida['professor_id'];

			$comentario = trim(nl2br($this->system->input['comentario']));
			$campos['duvida_id'] = $duvidaId;
			$campos['destinatario_id'] = $destinatarioId;
			$campos['comentario'] = $comentario;

			$this->system->duvidas->cadastrarResposta($campos);

			//Email para o professor
			if ($duvida['aluno_id'] == $usuarioId)
				$this->system->email_model->novaDuvidaProfessor($duvida['curso_id'], $duvida['professor_id'], $duvida['aluno_id'], $duvida['titulo'], $comentario);
			else 
				$this->system->email_model->respostaDuvidaAluno($duvida['professor_id'], $duvida['aluno_id'], $duvida['titulo'], $comentario);
		}
		$this->system->func->redirecionar('/duvidas/listar/' . $duvidaId);
	}
	// ===============================================================
	protected function doFechar() {
		$usuarioId = $this->system->session->getItem('session_cod_usuario');
		$duvidaId = $this->system->input['id'];

		$duvida = $this->system->duvidas->getDuvida("(aluno_id = '" . $usuarioId . "' OR professor_id = '" . $usuarioId . "') AND id = '" . $duvidaId . "'" );

		if ($duvida['id']) {
			//se a duvida estiver excluida, ativa novamente
			$this->system->duvidas->atualizar($duvida['id'], array('fechada' => 1));

			if ($duvida['aluno_id'] != $usuarioId)
				$destinatarioId = $duvida['aluno_id'];
			else
				$destinatarioId = $duvida['professor_id'];

			$campos['duvida_id'] = $duvidaId;
			$campos['destinatario_id'] = $destinatarioId;
			$campos['comentario'] = ' -- DÚVIDA FECHADA --';

			$this->system->duvidas->cadastrarResposta($campos);
		}
		$this->system->func->redirecionar('/duvidas/listar/' . $duvidaId);}
	// ===============================================================
	protected function doCadastro() {
		$usuario_id = $this->system->session->getItem('session_cod_usuario');
		
		$editar = intval($this->system->input['editar']);
		if ($editar) {
			//Verifica
			$erro_msg = $this->validarDados();
			if ($erro_msg) {
				$duvida = $this->system->input;
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('duvida', $duvida);
			} else {
				//Salvar
				$this->system->input['comentario'] = trim(nl2br($this->system->input['comentario']));
				$this->system->duvidas->cadastrar($this->system->input);
				$this->system->view->assign('msg_alert', 'Ação realizada com sucesso!');


				//Email para o professor
				$this->system->email_model->novaDuvidaProfessor($this->system->input['curso_id'], $this->system->input['professor_id'], $usuario_id, $this->system->input['titulo'], $this->system->input['comentario']);
			}
		}

		//Cursos do aluno
		$this->system->view->assign('cursos', $this->system->curso->getCursosByAluno($usuario_id));

		//Professores do curso
		if ($duvida['curso_id'])
			$this->system->view->assign('professores', $this->system->professores->getProfessoresByCurso($duvida['curso_id']));

		$this->system->view->assign('categoria', $this->system->admin->getCategoria());

		$this->system->admin->topo(2);
		$this->system->view->display('global/duvidas_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
        if (!$this->system->input['titulo']) 
            $retorno['msg'][] = "O campo título está vázio.";
        
        if (!$this->system->input['curso_id']) 
            $retorno['msg'][] = "O campo curso está vázio.";

        if (!$this->system->input['professor_id']) 
            $retorno['msg'][] = "O campo professor está vázio.";
			
		if (!$this->system->input['comentario']) 
            $retorno['msg'][] = "O campo comentário deve ser preenchido.";
		
		if(count($retorno)>0){
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
		}
        return $retorno;
	}
	// ===============================================================
	protected function doMudarProfessores() {
		$curso_id = $this->system->input['curso_id'];
		$professores =  $this->system->professores->getProfessoresByCurso($curso_id);

		echo '<select data-placeholder="Selecione o Professor..." style="width:350px" id="selectAula" name="professor_id" class="chzn-select" tabindex="2">';
		echo '<option value=""></option> ';
		foreach ($professores as $professor) 
			echo "<option value='" . $professor['id'] . "'>" . $professor['nome'] . "</option>";
		echo '</select><script>jQuery(".chzn-select").chosen();</script>';
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================
