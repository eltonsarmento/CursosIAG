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
		$this->system->load->dao('planos');
		$this->system->load->dao('professores');
		$this->system->load->dao('certificados');
		$this->system->load->dao('quiz');
		$this->system->load->dao('duvidas');
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->model('email_model');
		$this->system->load->model('certificados_model');
	}
	// ===============================================================
	public function autoRun() {		
		switch($this->system->input['do']) {
			case 'meus-cursos': 			$this->doMeusCursos(); break;
			case 'buscar': 					$this->doMeusCursos(); break;
			case 'verCurso': 				$this->doVerCurso(); break;
			case 'aula': 					$this->doAula(); break;
			case 'buscarLink':				$this->doBuscarLink(); break;
			case 'avancar': 				$this->doAvancar(); break;
			case 'quiz': 					$this->doQuiz(); break;
			case 'pular': 					$this->doPular(); break;
			case 'duvida': 					$this->doDuvida(); break;
			case 'depoimento':  			$this->doDepoimento(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	//                           CURSOS                             //
	// ===============================================================
	private function doMeusCursos() {
		
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');

		$cursos = $this->system->curso->getCursosByAluno($this->system->session->getItem('session_cod_usuario'), $palavra);		
		$concluidos = array();
		$andamento = array();

		$certificado = $this->system->configuracoesgerais->getProdutosCertificados();

		foreach ($cursos as $curso) {
			// tipo venda						
			if($curso['plano_id'] != '' && $curso['plano_id'] != 0){
				$plano = $this->system->planos->getPlano($curso['plano_id']);	
				$curso['tipo_venda'] = 'Plano '.$plano['plano'];
			}else{
				$curso['tipo_venda'] = 'Avulso';
			}
				
			//ultima aula
			
			$ultimaAula = $this->system->aulas->getAula($curso['ultima_aula']);

			if ($ultimaAula['aula_id']) $curso['aula'] = $ultimaAula['nome'];

			//professor
			$professor = $this->system->professores->getProfessor($curso['professor_id']);
			if ($professor['id']) $curso['professor'] = $professor['nome'];

			//porcentagem
			
			if ($curso['aulas_assistidas'])
				$curso['porcentagem'] = round(($curso['aulas_assistidas']/$curso['aulas_total'])*100);
			else 
				$curso['porcentagem'] = 0;


			if ($curso['aulas_assistidas'] >= $curso['aulas_total'])
				$concluidos[] = $curso;
			else 
				$andamento[] = $curso;
		}
		$this->system->view->assign(array(
			'url_site'		=> 	$this->system->getUrlSite(),
			'concluidos'	=>	$concluidos,
			'andamento'		=>	$andamento,
			'certificado'	=> ($certificado['produtos_certificado_tipo'] == 0 ? false: true)
		));
		
		$this->system->admin->topo(2);
		$this->system->view->display('aluno/cursos.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================//
	// 								CURSO 							  //
	// ===============================================================//
	private function doVerCurso() {
		$relacionamentoId = $this->system->input['id'];
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		$this->verificaAcessoCurso($relacionamentoId);
		$this->system->curso->atualizarCursoAluno(array('ultimo_acesso' => date('Y-m-d')), $relacionamentoId);

		//msg_alert
		$msg_alert = $this->system->session->getItem('msg_alert');
		$this->system->session->deleteItem('msg_alert');

		//curso
		$cursoAluno = end($this->system->curso->getCursosAlunos(" and usuario_id = '" . $usuarioId . "' and id = '" . $relacionamentoId . "'"));
		$curso = $this->system->curso->getCurso($cursoAluno['curso_id']);

		//professor
		$professor = $this->system->professores->getProfessor($curso['professor_id']);
		$professor['minicurriculo'] = $this->system->professores->getValorExtra($professor['id'], 'minicurriculo');

		//porcentagem
		$totalAulas = $this->system->aulas->countAulasCurso($curso['id']);
		if ($totalAulas == 0) {
			$this->system->func->redirecionar('/cursos/meus-cursos');
		}
		$aulasAssistidas = $this->system->aulas->countAulasAssistidas($relacionamentoId);
		$totalQuizRespondido = $this->system->aulas->countQuizRespondido($relacionamentoId);
		
		if ($aulasAssistidas)
			$completo = ($aulasAssistidas/$totalAulas)*100;
		else 
			$completo = 0;


		//gerar certificado se atingiu o minimo para obter o certificado.
		$certificadoConfig = $this->system->configuracoesgerais->getCertificadoPorcentagem();
		if ($completo >= $certificadoConfig['certificado_porcentagem']) {
			$this->system->certificados_model->gerarCertificado($relacionamentoId);
		}

		// duvida
		$totalDuvidas = $this->system->duvidas->countTotalDuvidas("aluno_id = '" . $usuarioId . "' and curso_id = '" . $curso['id'] . "'");
		$totalDuvidasRespondidas = $this->system->duvidas->countTotalRespondida(" and aluno_id = '" . $usuarioId . "' and curso_id = '" . $curso['id'] . "'");

		//aulas
		//caso não tenha aula cadastradas (Primeiro acesso), cadastra a primeira aula como aula atual

		if ($this->system->curso->primeiroAcessso($relacionamentoId)) {
			$proximaAula = $this->system->aulas->buscarProximaAula($curso['id'], 0);

			if ($proximaAula)
				$this->system->aulas->liberarAula($proximaAula, $relacionamentoId, $usuarioId);
		}

		$aulasCompletadas = $this->system->aulas->obterAulasCompletadas($relacionamentoId);
		// print_r($aulasCompletadas);die;


		//Buscar aulas de Materias Extras (Liberar)
		$aulasExtras = $this->system->aulas->getAulas(" and curso_id = '" . $curso['id'] . "' and tipo = 5");
		
		foreach ($aulasExtras as $aulaExtra)  {
			if (!in_array($aulaExtra['aula_id'], $aulasCompletadas)) {
				$this->system->aulas->liberarAula($aulaExtra['aula_id'], $relacionamentoId, $usuarioId);
				$this->system->aulas->liberarAvancar($aulaExtra['aula_id'], $relacionamentoId);
				$this->system->aulas->concluiAula($aulaExtra['aula_id'], $relacionamentoId);
				$aulasCompletadas[] = $aulaExtra['aula_id'];
			}
		}
		
		// print_r($aulasCompletadas);die;

		

		
		$aulaAtual = $this->system->aulas->obterAulaAtual($relacionamentoId);

		//capitulos/aulas
		$capitulos = $this->system->aulas->getCapitulosByCurso($curso['id']);

		foreach ($capitulos as $key=>$capitulo) {
			$status = 0; //Não visto
			//atual
			foreach ($capitulo['aulas'] as $aula) {
				if ($aula['aula_id'] == $aulaAtual) {
					$status = 1;//atual
					break;
				}
			}

			if ($status == 0) {
				foreach ($capitulo['aulas'] as $aula) {
					if (in_array($aula['aula_id'], $aulasCompletadas)) {
						$status = 2;//visto
						break;
					}
				}
			}

			$capitulos[$key]['status'] = $status;
		}

		//
		$this->system->view->assign(array(
			'url_site'					=> $this->system->getUrlSite(),
			'curso'						=> $curso,
			'cursoAluno'				=> $cursoAluno,
			'capitulos' 				=> $capitulos,
			'professor'					=> $professor,
			'completo' 					=> round($completo),
			'faltando'					=> round(100 - $completo),
			'aulasCompletadas' 			=> $aulasCompletadas,
			'aulaAtual'					=> $aulaAtual,
			'msg_alert'					=> $msg_alert,
			'totalQuizRespondido'		=> $totalQuizRespondido,
			'totalDuvidas'				=> $totalDuvidas,
			'totalDuvidasRespondidas' 	=> $totalDuvidasRespondidas
		));

		$this->system->admin->topo(2);
		$this->system->view->display('aluno/curso.tpl');
		$this->system->admin->rodape();
	}
	// ==============================================================//
	//              		 AULA / QUIZ                             //
	// ==============================================================//
	private function doAula() {
		$aulaId = $this->system->input['id'];
		
		$cursoId = $this->system->aulas->getCursoIdByAula($aulaId);
		$relacionamentoId = $this->verificaAcessoCurso(0, $cursoId);
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		if ($this->system->curso->primeiroAcessso($relacionamentoId)) {
			$proximaAula = $this->system->aulas->buscarProximaAula($cursoId, 0);

			if ($proximaAula)
				$this->system->aulas->liberarAula($proximaAula, $relacionamentoId, $usuarioId);
		}

		/*
		if (!$this->system->aulas->checarAulaLiberada($aulaId, $relacionamentoId)) {
			$this->system->session->addItem('msg_alert', 'Essa aula ainda não está liberada. Para libera-la complete as aulas anteriores!');
			$this->system->func->redirecionar('/cursos/verCurso/' . $relacionamentoId);
		}
		*/


		$this->system->curso->atualizarCursoAluno(array('ultima_aula' => $aulaId), $relacionamentoId);
		$cursoAluno = end($this->system->curso->getCursosAlunos(" and id = '" . $relacionamentoId . "'"));

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


		//Bloquear aula por tempo
		$bloqueio['bloqueado'] = false;
		if ($aula['tipo'] == 1) {
			$cursoAlunoAula = $this->system->aulas->getAulaAluno($aulaId, $relacionamentoId);
			if ($cursoAlunoAula['liberar_avancar'] == 0) {
				$bloqueio['bloqueado'] = true;
				
				list($horas, $minutos, $segundos) = explode(':', $aula['duracao']);
				$bloqueio['tempo'] = 0;
				$bloqueio['tempo'] += intval($segundos) * 1000;
				$bloqueio['tempo'] += intval($minutos) * 60 * 1000;
				$bloqueio['tempo'] += intval($horas) * 60 * 60 * 1000;

				$bloqueio['link'] = base64_encode(urldecode($this->system->getUrlSite() . 'lms/aluno/cursos/avancar/' . $aula['aula_id']));
			}
		}

		//porcentagem
		$totalAulas = $this->system->aulas->countAulasCurso($cursoId);
		$aulasAssistidas = $this->system->aulas->countAulasAssistidas($relacionamentoId);
		
		if ($aulasAssistidas)
			$porcentagem = ($aulasAssistidas/$totalAulas)*100;
		else 
			$porcentagem = 0;
		
		$certificadoConfig = $this->system->configuracoesgerais->getCertificadoPorcentagem();
		if ($porcentagem >= $certificadoConfig['certificado_porcentagem']) {
			$this->system->certificados_model->gerarCertificado($relacionamentoId);
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
			'relacionamentoId'	=> $relacionamentoId,
			'aulaAnterior'		=> $aulaAnterior,
			'proximaAula'		=> $proximaAula,
			'linkAvancar'		=> base64_encode(urldecode($this->system->getUrlSite() . 'lms/aluno/cursos/avancar/' . $aula['aula_id'])),
			'suporte'			=> $cursoAluno['suporte'],
			'porcentagem'		=> round($porcentagem),
			'bloqueio'			=> $bloqueio
		));

		

		$this->system->admin->topo(2);
		$this->system->view->display('aluno/aula.tpl');
		$this->system->admin->rodape();
	}
	// ==============================================================
	private function doBuscarLink() {
		$aula = $this->system->input['aula_id'];
		
		echo base64_encode(urldecode($this->system->getUrlSite() . 'lms/aluno/cursos/avancar/' . $aula));
	}
	// ===============================================================
	private function doQuiz() {
		$aulaId = $this->system->input['id'];
		$cursoId = $this->system->aulas->getCursoIdByAula($aulaId);
		$relacionamentoId = $this->verificaAcessoCurso(0, $cursoId);
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		if (!$this->system->aulas->checarAulaLiberada($aulaId, $relacionamentoId)) {
			$this->system->session->addItem('msg_alert', 'Essa aula ainda não está liberada. Para libera-la complete as aulas anteriores!');
			$this->system->func->redirecionar('/cursos/verCurso/' . $relacionamentoId);
		}

		//verifica se existe quiz
		$quiz = $this->system->quiz->getQuizCondicao("and aula_id = '" . $aulaId .  "'");
		if (!$quiz['id']) {
			$this->system->func->redirecionar('/cursos/verCurso/' . $relacionamentoId);	
		}

		$responder = $this->system->input['responder'];

		if ($responder) {
			$alternativa = $this->system->input['alternativa'];	
			if ($alternativa == $quiz['alternativa_correta']) { 
				//acertou

				$this->system->aulas->concluiAula($aulaId, $relacionamentoId);
				$this->system->aulas->quizRespondido($aulaId, $relacionamentoId);
				$proximaAula = $this->system->aulas->buscarProximaAula($cursoId, $aulaId);
				if ($proximaAula) {
					//checa se esta liberada
					if (!$this->system->aulas->checarAulaLiberada($proximaAula, $relacionamentoId)) 
						$this->system->aulas->liberarAula($proximaAula, $relacionamentoId, $usuarioId);	

					$this->system->func->redirecionar('/cursos/aula/' . $proximaAula);
				} else {
					//não existe proxima aula
					$this->system->session->addItem('msg_alert', 'Curso concluído!');
					$this->system->func->redirecionar('/cursos/verCurso/' . $relacionamentoId);		
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
		$this->system->view->display('aluno/quiz.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function doAvancar() {
		$aulaId = $this->system->input['id'];
		$cursoId = $this->system->aulas->getCursoIdByAula($aulaId);
		$relacionamentoId = $this->verificaAcessoCurso(0, $cursoId);
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		if (!$this->system->aulas->checarAulaLiberada($aulaId, $relacionamentoId)) {
			$this->system->session->addItem('msg_alert', 'Essa aula ainda não está liberada. Para libera-la complete as aulas anteriores!');
			$this->system->func->redirecionar('/cursos/verCurso/' . $relacionamentoId);
		}


		$this->system->aulas->liberarAvancar($aulaId, $relacionamentoId);
		//verifica se existe quiz
		$quiz = $this->system->quiz->getQuizCondicao("and aula_id = '" . $aulaId .  "'");

		if ($quiz['id']) {
			$this->system->func->redirecionar('/cursos/quiz/' . $aulaId);
		} else {
			//conclui aula
			$this->system->aulas->concluiAula($aulaId, $relacionamentoId);
			//libera e avança para proxima aula
			$proximaAula = $this->system->aulas->buscarProximaAula($cursoId, $aulaId);
			if ($proximaAula) {
				//checa se esta liberada
				if (!$this->system->aulas->checarAulaLiberada($proximaAula, $relacionamentoId)) 
					$this->system->aulas->liberarAula($proximaAula, $relacionamentoId, $usuarioId);	

				$this->system->func->redirecionar('/cursos/aula/' . $proximaAula);
			} else {
				//não existe proxima aula
				$this->system->session->addItem('msg_alert', 'Curso concluído!');
				$this->system->func->redirecionar('/cursos/verCurso/' . $relacionamentoId);		
			}	
		}
	}
	// ===============================================================
	private function doPular() {
		$aulaId = $this->system->input['id'];
		$cursoId = $this->system->aulas->getCursoIdByAula($aulaId);
		$relacionamentoId = $this->verificaAcessoCurso(0, $cursoId);
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		if (!$this->system->aulas->checarAulaLiberada($aulaId, $relacionamentoId)) {
			$this->system->session->addItem('msg_alert', 'Essa aula ainda não está liberada. Para libera-la complete as aulas anteriores!');
			$this->system->func->redirecionar('/cursos/verCurso/' . $relacionamentoId);
		}

		//verifica se existe quiz
		$quiz = $this->system->quiz->getQuizCondicao("and aula_id = '" . $aulaId .  "'");

		if ($quiz['id'] && $quiz['obrigatorio']) {
			$this->system->func->redirecionar('/cursos/quiz/' . $aulaId);
		} else {
			//conclui aula
			$this->system->aulas->concluiAula($aulaId, $relacionamentoId);
			//libera e avança para proxima aula
			$proximaAula = $this->system->aulas->buscarProximaAula($cursoId, $aulaId);
			if ($proximaAula) {
				//checa se esta liberada
				if (!$this->system->aulas->checarAulaLiberada($proximaAula, $relacionamentoId)) 
					$this->system->aulas->liberarAula($proximaAula, $relacionamentoId, $usuarioId);	

				$this->system->func->redirecionar('/cursos/aula/' . $proximaAula);
			} else {
				//não existe proxima aula
				$this->system->session->addItem('msg_alert', 'Curso concluido!');
				$this->system->func->redirecionar('/cursos/verCurso/' . $relacionamentoId);		
			}	
		}
	}
	// ===============================================================
	private function doDuvida() {
		$relacionamentoId = $this->system->input['id'];
		$usuarioId = $this->system->session->getItem('session_cod_usuario');
		$titulo = $this->system->input['titulo'];
		$duvida = $this->system->input['duvida'];
		$enviar = $this->system->input['enviar'];

		if ($enviar) {

			$this->system->load->dao('duvidas');
			$cursoAluno = end($this->system->curso->getCursosAlunos(" and usuario_id = '" . $usuarioId . "' and id = '" . $relacionamentoId . "'"));
			if ($cursoAluno['id']) {
				$curso = $this->system->curso->getCurso($cursoAluno['curso_id']);
	

				$campos['titulo'] 		= $titulo;
				$campos['curso_id'] 	= $curso['id'];
				$campos['professor_id'] = $curso['professor_id'];
				$campos['comentario'] 	= $duvida;
				$this->system->duvidas->cadastrar($campos);


				$this->system->email_model->novaDuvidaProfessor($curso['id'], $curso['professor_id'], $usuarioId, $titulo, $duvida);
				echo "<script>jAlert('Duvida enviada!'); limparForm();</script>";

			}
			
		}
	}
	// ===============================================================
	private function verificaAcessoCurso($relacionamento = 0, $curso = 0) {
		$usuarioId = $this->system->session->getItem('session_cod_usuario');
		if ($relacionamento) {
			if ($this->system->curso->checarCursoAtivo($relacionamento, $usuarioId))
				return $relacionamento;
			$this->system->func->redirecionar('/cursos/meus-cursos');
			exit();
		} elseif ($curso) {
			$cursoAluno = end($this->system->curso->getCursosAlunos(" and curso_id = '" . $curso . "' and usuario_id = '" . $usuarioId . "'"));
			if ($cursoAluno['id'])
				return $cursoAluno['id'];
		} 
		$this->system->func->redirecionar('/cursos/meus-cursos');
		exit();
	}
	// ===============================================================//
	//                       DEPOIMENTO                              //
	// ===============================================================//
	private function doDepoimento() {
		if ($this->system->input['enviar']) {
			$relacionamentoId = $this->system->input['matricula_id'];
			$usuarioId = $this->system->session->getItem('session_cod_usuario');	

			//cursos
			$cursoAluno = end($this->system->curso->getCursosAlunos(" and usuario_id = '" . $usuarioId . "' and id = '" . $relacionamentoId . "'"));

			if (!$cursoAluno['id']) {
				echo '<p style="color:red">Você não possui esse curso.</p>';
				return;
			}

			//Aulas assistidas
			$totalAulas = $this->system->aulas->countAulasCurso($cursoAluno['curso_id']);
			$aulasAssistidas = $this->system->aulas->countAulasAssistidas($relacionamentoId);
			
			if ($totalAulas != $aulasAssistidas) {
				echo '<p style="color:red">É preciso completar o curso para poder mandar depoimento.</p>';
				return;
			}

			if (!$texto = $this->system->input['texto']) {
				echo '<p style="color:red">Preencha o texto.</p>';
				return;
			}

			$this->system->load->dao('depoimentos');

			$campos['curso_id'] = $cursoAluno['curso_id'];
			$campos['mensagem'] = $texto;

			$this->system->depoimentos->cadastrar($campos);

			echo '<p style="color:green">Depoimento cadastrado com sucesso. Após aprovado, será exibido no site.<p>';
			echo '<script type="text/javascript">jQuery("#modal_texto").val("");</script>';
			return;
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