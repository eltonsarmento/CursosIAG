<?php
require_once(dirname(__FILE__).'/../global/quiz.global.php');
// ===================================================================
class Quiz extends QuizGlobal {
	
	// ===============================================================
	public function autoRun() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'novo': 			$this->doNovo(); break;
			case 'editar': 			$this->doEdicao(); break;
			case 'aulas': 			$this->doBuscarAulas(); break;
			case 'listar': 			$this->doListar(); break;
			case 'apagar':  		$this->doDeletar(); break;
			case 'buscar': 			$this->doListarCursos(); break;
			case 'listarCursos': 	$this->doListarCursos(); break;
			default: 				$this->pagina404(); break;
		}
	}
	// ==============================================================
	protected function doListarCursos() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');

		$cursos = $this->system->curso->getCursosCondicao(" and professor_id = '" . $this->system->session->getItem('session_cod_usuario') . "'" . ($palavra ? " and curso like '%" . $palavra . "%'" : ''));		

		foreach($cursos as $key => $curso) {
			$cursos[$key]['total_quiz'] = $this->system->quiz->getTotalQuiz($curso['id']);

			//Categorias
			$categorias = $this->system->curso->getCategoriasByCurso($curso['id']);
			$cursos[$key]['categorias'] = $categorias;
		}


		$this->system->view->assign(array(
			'url_site'		=> 	$this->system->getUrlSite(),
			'cursos'	=>	$cursos,
		));
		
		$this->system->admin->topo(2);
		$this->system->view->display('professor/cursos_quiz.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doListar() {
		$this->checarAcesso($this->system->input['id'], $this->system->session->getItem('session_cod_usuario'));
		parent::doListar();
	}
	// ===============================================================
	protected function doNovo() {
		$this->checarAcesso($this->system->input['id'], $this->system->session->getItem('session_cod_usuario'));
		parent::doNovo();	
	}
	// ===============================================================
	protected function doEdicao() {
		$cursoId = $this->system->input['curso_id'];
		$quiz = $this->system->quiz->getQuiz($this->system->input['id']);
		$this->checarAcesso(($cursoId? $cursoId : $quiz['curso_id'] ), $this->system->session->getItem('session_cod_usuario'));
		parent::doEdicao();	
	}
	// ===============================================================
	protected function doDeletar() {
		$quiz = $this->system->quiz->getQuiz($this->system->input['id']);
		$this->checarAcesso($quiz['curso_id'], $this->system->session->getItem('session_cod_usuario'));
		parent::doDeletar();	
	}
	// ===============================================================
	private function checarAcesso($cursoId, $professorId) {
		$curso = $this->system->curso->getCursoCondicao(" and id = '" . $cursoId . "' and (professor_id = '" . $professorId . "' OR professor_substituto_id = '" . $professorId . "')");
		if (!$curso['id'])
			$this->system->func->redirecionar('/quiz/listarCursos');
	}
}
// ===================================================================