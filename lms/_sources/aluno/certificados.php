<?php
// ===================================================================
class Certificados {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('certificados');
		$this->system->load->dao('curso');
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->dao('professores');
		$this->system->load->model('certificados_model');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {		
		switch($this->system->input['do']) {
			case 'listar': 					$this->doListar(); break;
			case 'buscar': 					$this->doListar(); break;
			case 'solicitar-certificado': 	$this->doSolicitarCertificado(); break;
			case 'certificado-solicitado':	$this->doCertificadoSolicitado(); break;
			case 'comprarcertificado':		$this->doComprarCertificado(); break;
			case 'certificado': 			$this->doCertificado(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	private function doListar() {
		$usuarioID = $this->system->session->getItem('session_cod_usuario');
		$certificados = $this->system->certificados->getCertificadosCondicao(" and aluno_id = '" . $usuarioID. "'");
		
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');

		foreach ($certificados as $key => $certificado) {
			$certificados[$key]['curso'] = $this->system->curso->getCurso($certificado['curso_id']);

			if ($palavra) {
				if (stristr($certificados[$key]['curso']['curso'], $palavra) === false) {
					unset($certificados[$key]);
				}
			}
		}

		$this->system->view->assign(array(
			'url_site'		=> 	$this->system->getUrlSite(),
			'certificados'	=>	$certificados,
		));
		
		$this->system->admin->topo(2);
		$this->system->view->display('aluno/certificados.tpl');
		$this->system->admin->rodape();
	}
	// =============================================================
	protected function doSolicitarCertificado() {
		$matriculaID = $this->system->input['id'];
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		$this->verificaAcessoCurso($matriculaID);

		//Configurações Gerais do Certificado
		$certificado = $this->system->configuracoesgerais->getProdutosCertificados();

		//curso
		$cursoAluno = end($this->system->curso->getCursosAlunos(" and usuario_id = '" . $usuarioId . "' and id = '" . $matriculaID . "'"));
		$curso = $this->system->curso->getCurso($cursoAluno['curso_id']);

		//Curso ou Configurações Gerais não liberam a impressão de certificado
		if ($curso['certificado'] == 0 || $certificado['produtos_certificado_tipo'] == 0) {
			$this->system->func->redirecionar('/cursos/meus-cursos');
		}

		//professor
		$professor = $this->system->professores->getProfessor($curso['professor_id']);

		//obtem os valores cadastrando quando gerou o certifiacdo em pdf
		$certificadoDigital = $this->system->certificados->getCertificadoCondicao(' and matricula_curso_id = ' . $matriculaID . ' and tipo_certificado = 1');
		if ($certificadoDigital['id']) {
			$this->system->certificados_model->gerarCertificado($matriculaID);
			$certificadoDigital = $this->system->certificados->getCertificadoCondicao(' and matricula_curso_id = ' . $matriculaID . ' and tipo_certificado = 1');
		}

		$this->system->view->assign(array(
			'curso'		=> $curso['curso'],
			'aluno'		=> $certificadoDigital['aluno_nome'],
			'carga'		=> $certificadoDigital['carga'],
			'email'		=> $this->system->session->getItem('session_email'),
			'professor'	=> $professor['nome'],
			'total'		=> ($certificado['produtos_certificado_tipo'] == 1? 'Gratuito' : 'R$ ' . number_format($certificado['produtos_certificado_valor'], 2, ',', '.')),
			'gratuito'	=> ($certificado['produtos_certificado_tipo'] == 1 ? true : false),
			'matricula'	=> $matriculaID
		));

		$this->system->admin->topo(2);
		$this->system->view->display('aluno/solicitarcertificado.tpl');
		$this->system->admin->rodape();

	}
	// ================================================================
	protected function doComprarCertificado() {

		if ($this->system->input['comprar']) {
			$this->system->load->dao('vendas');

			$matriculaID = $this->system->input['id'];
			$usuarioId = $this->system->session->getItem('session_cod_usuario');

			//Configurações Gerais do Certificado
			$certificado = $this->system->configuracoesgerais->getProdutosCertificados();

			//curso
			$cursoAluno = end($this->system->curso->getCursosAlunos(" and usuario_id = '" . $usuarioId . "' and id = '" . $matriculaID . "'"));
			$curso = $this->system->curso->getCurso($cursoAluno['curso_id']);

			if ($curso['certificado'] == 0 || $certificado['produtos_certificado_tipo'] == 0) { //Curso ou Configurações Gerais não liberam a impressão de certificado
				echo "<script type='text/javascript'>jAlert('Não foi possível realizar o pedido')</script>";
			
			} elseif ($certificado['produtos_certificado_tipo'] == 1) { //Certificado Gratuito
				$this->system->certificados_model->gerarCertificadoImpresso($matriculaID);
				echo "<script type='text/javascript'>window.location.href='" . $this->system->getUrlSite() . "lms/aluno/certificados/certificado-solicitado';</script>";

			} else { //Realiza Compra

				if ($certificado['produtos_certificado_tipo'] == 2) { //certificado valor fixo

					$certificados = array();
					$certificados[] = $matriculaID;

					$valor = number_format($certificado['produtos_certificado_valor'], 2, '.', '');

					$campos = array(
						'usuario_id'		=> 0,
						'aluno_id'			=> $usuarioId,
						'cupom_id'			=> 0,
						'parceiro_id'		=> 0,
						'forma_desconto'	=> 0,
						'forma_pagamento'	=> 1,
						'status'			=> 0,
						'valor_desconto'	=> 0,
						'valor_total'		=> $valor,
						'data_venda'		=> date('d/m/Y'),
						'data_expiracao'	=> '0000-00-00',
						'certificados'		=> $certificados,
					);	

					$id = $this->system->vendas->cadastrar($campos);
					$numero = str_pad($id, 5, "0", STR_PAD_LEFT);

					$this->system->load->model('pagamento_model');

					$this->system->pagamento_model->setValor($valor);
					$this->system->pagamento_model->setTransacaoID($numero);
					$this->system->pagamento_model->setRazao('IAG - Compra de Certificado - Pedido Nº');
					$this->system->pagamento_model->setNotificationURL($this->system->getUrlSite() . 'lms/nasp/pagseguro_certificado.php');
					$this->system->pagamento_model->setEmailUsuario($this->system->session->getItem('session_email'));
					$this->system->pagamento_model->setNomeUsuario($this->system->session->getItem('session_nome'));

					$url = $this->system->pagamento_model->iniciaPagamentoPagSeguro();

					if ($url) 
						echo "<script type='text/javascript'>jQuery('#urlPagSeguro').val('" . $url . "'); alertPagSeguro();</script>";
				}
			}
		}
		
	}
	// ===============================================================
	protected function doCertificadoSolicitado() {
		$this->system->admin->topo(2);
		$this->system->view->display('aluno/certificadosolicitado.tpl');
		$this->system->admin->rodape();
	}
	// ================================================================
	public function doCertificado() {
		$matriculaID = $this->system->input['id'];
		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		$cursoAluno = end($this->system->curso->getCursosAlunos(" and usuario_id = '" . $usuarioId . "' and id = '" . $matriculaID . "'", '', '', false));
		
		if (!$cursoAluno['id'])
			$this->system->func->redirecionar('/cursos/meus-cursos');

		$curso = $this->system->curso->getCurso($cursoAluno['curso_id']);

		//gera o certificado se não tiver gerado
		$this->system->certificados_model->gerarCertificado($matriculaID);

		$certificadoDigital = $this->system->certificados->getCertificadoCondicao(' and matricula_curso_id = ' . $matriculaID . ' and tipo_certificado = 1');

		if ($certificadoDigital['id']) {
			//Gera o PDF
			$this->system->view->assign(array(
				'url_site'			=> $this->system->getUrlSite(),
				'aluno' 	 	  	=> strtoupper($certificadoDigital['aluno_nome']),
				'curso' 		  	=> strtoupper($curso['curso']),
				'carga'			  	=> $certificadoDigital['carga'],
				'numero'		  	=> $certificadoDigital['id'],
				'data_solicitacao'	=> date('d/m/Y', strtotime($certificadoDigital['data_solicitacao'])),
				'data_emissao'	  	=> date('d', strtotime($certificadoDigital['data_emissao'])) . ' de ' . utf8_encode($this->system->arrays->getMes(date('m', strtotime($certificadoDigital['data_emissao'])))) . ' de ' . date('Y', strtotime($certificadoDigital['data_emissao']))
			));

			if ($certificadoDigital['curso_id'] == 78) //Modelo Runrun
				$html = $this->system->view->fetch('global/modelo_certificado_runrun.tpl');
			else //Modelo Padrão
				$html = $this->system->view->fetch('global/modelo_certificado.tpl');
				
			$this->system->func->htmlToPdf2($html, 'A4-L', true);

		} else {
			$this->system->session->addItem('msg_alert', 'Certificado não disponível. Certifique-se que completou a carga mínima de ' . $certificadoConfig['certificado_porcentagem'] . '% para obter o certificado!');
			$this->system->func->redirecionar('/cursos/verCurso/' . $matriculaID);		
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