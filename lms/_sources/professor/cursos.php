<?php
// ===================================================================
class Cursos {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('curso');
		$this->system->load->dao('aulas');
		$this->system->load->dao('professores');
		$this->system->load->dao('certificados');
		$this->system->load->dao('quiz');
		$this->system->load->dao('duvidas');
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {		
		switch($this->system->input['do']) {
			case 'listar':		$this->doMeusCursos(); break;
			case 'buscar':		$this->doMeusCursos(); break;
			case 'verCurso': 	$this->doVerCurso(); break;
			case 'aula': 		$this->doAula(); break;
			case 'avancar': 	$this->doAvancar(); break;
			case 'quiz': 		$this->doQuiz(); break;
			case 'pular': 		$this->doPular(); break;
			case 'duvida': 		$this->doDuvida(); break;
			case 'certificado': $this->doCertificado(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	//                           CURSOS                             //
	// ===============================================================
	private function doMeusCursos() {
		
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');

		$cursos = $this->system->curso->getCursosCondicao(" and professor_id = '" . $this->system->session->getItem('session_cod_usuario') . "'" . ($palavra ? " and curso like '%" . $palavra . "%'" : ''));		
		
		foreach ($cursos as $key => $curso) {
			//professor
			$professor = $this->system->professores->getProfessor($curso['professor_id']);
			if ($professor['id']) $cursos[$key]['professor'] = $professor['nome'];

			$cursos[$key]['totalAulas'] = $this->system->aulas->countAulasCurso($curso['id']);
		}
		$this->system->view->assign(array(
			'url_site'		=> 	$this->system->getUrlSite(),
			'cursos'	=>	$cursos,
		));
		
		$this->system->admin->topo(2);
		$this->system->view->display('professor/cursos.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================//
	// 								CURSO 							  //
	// ===============================================================//
	private function doVerCurso() {
		$cursoId = $this->system->input['id'];
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		$this->verificaAcessoCurso($cursoId);

		//msg_alert
		$msg_alert = $this->system->session->getItem('msg_alert');
		$this->system->session->deleteItem('msg_alert');

		$curso = $this->system->curso->getCurso($cursoId);

		//professor
		$professor = $this->system->professores->getProfessor($curso['professor_id']);
		$professor['minicurriculo'] = $this->system->professores->getValorExtra($professor['id'], 'minicurriculo');

		//porcentagem
		$totalAulas = $this->system->aulas->countAulasCurso($curso['id']);
		
		// duvida
		$totalDuvidas = $this->system->duvidas->countTotalDuvidas("professor_id = '" . $usuarioId . "' and curso_id = '" . $curso['id'] . "'");
		$totalDuvidasRespondidas = $this->system->duvidas->countTotalRespondida(" and professor_id = '" . $usuarioId . "' and curso_id = '" . $curso['id'] . "'");

		//capitulos/aulas
		$capitulos = $this->system->aulas->getCapitulosByCurso($curso['id']);

		//
		$this->system->view->assign(array(
			'url_site'					=> $this->system->getUrlSite(),
			'curso'						=> $curso,
			'capitulos' 				=> $capitulos,
			'professor'					=> $professor,
			'msg_alert'					=> $msg_alert,
			'totalDuvidas'				=> $totalDuvidas,
			'totalDuvidasRespondidas' 	=> $totalDuvidasRespondidas
		));

		$this->system->admin->topo(2);
		$this->system->view->display('professor/curso.tpl');
		$this->system->admin->rodape();
	}
	// ==============================================================//
	//              		 AULA / QUIZ                             //
	// ==============================================================//
	private function doAula() {
		$aulaId = $this->system->input['id'];
		$cursoId = $this->system->aulas->getCursoIdByAula($aulaId);

		//Lista Aulas
		$capitulos = $this->system->aulas->getCapitulosByCurso($cursoId);
		
		//curso
		$curso = $this->system->curso->getCurso($cursoId);

		//Aula Atual
		$aula = $this->system->aulas->getAula($aulaId);
		if ($aula['tipo'] == 1) { //video aula
			if ($curso['servidor'] == 1)//amazon
				$aula['video'] = $aula['amazon'];
			elseif ($curso['servidor'] == 2)
				$aula['video'] = $aula['vimeo'];
			else {
				$this->system->load->dao('configuracoesgerais');
				$servidor = $this->system->configuracoesgerais->getServidor();
				
				if ($servidor['servidor_padrao'] == 1) 	//amazon
					$aula['video'] = $aula['amazon'];
				else  									//vimeo
					$aula['video'] = $aula['vimeo'];	
			}

			$aula['video'] = base64_encode(urldecode($aula['video']));

		} elseif ($aula['tipo'] == 2 || $aula['tipo'] == 3) { //ppt ou pdf
			$aula['arquivo'] = $aula['amazon'];
		} elseif ($aula['tipo'] == 4 || $aula['tipo'] == 5) { //texto ou materias extras
			// trabalha com o resumo
		}

		//capitulo a aulas anteriores/proximas
		$capitulo = $this->system->curso->getCapitulo($aula['capitulo_id']);
		$aulaAnterior = $this->system->aulas->buscarAulaAnterior($cursoId, $aulaId);
		$proximaAula = $this->system->aulas->buscarProximaAula($cursoId, $aulaId);
		
		//
		$this->system->view->assign(array(
			'url_site'			=> $this->system->getUrlSite(),
			'capitulo' 			=> $capitulo,
			'capitulos' 		=> $capitulos,
			'aula'				=> $aula,
			'curso'				=> $curso,
			'aulaAnterior'		=> $aulaAnterior,
			'proximaAula'		=> $proximaAula,
		));

		$this->system->admin->topo(2);
		$this->system->view->display('professor/aula.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function doQuiz() {
		$aulaId = $this->system->input['id'];
		$cursoId = $this->system->aulas->getCursoIdByAula($aulaId);
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		//verifica se existe quiz
		$quiz = $this->system->quiz->getQuizCondicao("and aula_id = '" . $aulaId .  "'");
		if (!$quiz['id']) {
			$this->system->func->redirecionar('/cursos/verCurso/' . $cursoId);	
		}

		$responder = $this->system->input['responder'];

		if ($responder) {
			$alternativa = $this->system->input['alternativa'];	
			if ($alternativa == $quiz['alternativa_correta']) { 
				//acertou
				$proximaAula = $this->system->aulas->buscarProximaAula($cursoId, $aulaId);
				if ($proximaAula) {
					//checa se esta liberada
					$this->system->func->redirecionar('/cursos/aula/' . $proximaAula);
				} else {
					//não existe proxima aula
					$this->system->session->addItem('msg_alert', 'Curso concluído!');
					$this->system->func->redirecionar('/cursos/verCurso/' . $cursoId);		
				}	
			} else { 
				//errou
				$msg_alert = 'Alternativa incorreta!';
			}
		}
		
		//curso
		$curso = $this->system->curso->getCurso($cursoId);

		//
		$this->system->view->assign(array(
			'url_site'			=> $this->system->getUrlSite(),
			'curso'				=> $curso,
			'quiz'				=> $quiz,
			'aulaId'			=> $aulaId,
			'msg_alert'			=> $msg_alert
		));

		

		$this->system->admin->topo(2);
		$this->system->view->display('professor/quiz.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function doAvancar() {

		$aulaId = $this->system->input['id'];
		$cursoId = $this->system->aulas->getCursoIdByAula($aulaId);
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		//verifica se existe quiz
		$quiz = $this->system->quiz->getQuizCondicao("and aula_id = '" . $aulaId .  "'");

		if ($quiz['id']) {
			$this->system->func->redirecionar('/cursos/quiz/' . $aulaId);
		} else {
			//libera e avança para proxima aula
			$proximaAula = $this->system->aulas->buscarProximaAula($cursoId, $aulaId);
			if ($proximaAula) 
				$this->system->func->redirecionar('/cursos/aula/' . $proximaAula);
			else {
				//não existe proxima aula
				$this->system->session->addItem('msg_alert', 'Curso concluído!');
				$this->system->func->redirecionar('/cursos/verCurso/' . $cursoId);		
			}
		}
	}
	// ===============================================================
	private function doPular() {
		$aulaId = $this->system->input['id'];
		$cursoId = $this->system->aulas->getCursoIdByAula($aulaId);
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		//verifica se existe quiz
		$quiz = $this->system->quiz->getQuizCondicao("and aula_id = '" . $aulaId .  "'");

		if ($quiz['id'] && $quiz['obrigatorio']) {
			$this->system->func->redirecionar('/cursos/quiz/' . $aulaId);
		} else {
			
			$proximaAula = $this->system->aulas->buscarProximaAula($cursoId, $aulaId);
			if ($proximaAula) 
				$this->system->func->redirecionar('/cursos/aula/' . $proximaAula);
			else {
				//não existe proxima aula
				$this->system->session->addItem('msg_alert', 'Curso concluido!');
				$this->system->func->redirecionar('/cursos/verCurso/' . $cursoId);		
			}	
		}
	}
	// ===============================================================
	private function verificaAcessoCurso($cursoId) {
		$usuarioId = $this->system->session->getItem('session_cod_usuario');
		$curso = $this->system->curso->getCursoCondicao("and id = '" . $cursoId . "' and (professor_id = '" . $usuarioId . "' OR professor_substituto_id = '" . $usuarioId . "')");
		if (!$curso['id']) {
			$this->system->func->redirecionar('/cursos/listar');
		}

	}
	// ===============================================================
	private function pagina404() {
		$this->system->view->assign('categoria', 'aluno');
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
}
// ===================================================================