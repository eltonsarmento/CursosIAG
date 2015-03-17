<?php
require_once(dirname(__FILE__).'/../libraries/moip/autoload.inc.php');
require_once(dirname(__FILE__).'/../libraries/pagseguro/PagSeguroLibrary.php');
// ===================================================================
class Certificados_modelMODEL {
	// ===============================================================
	protected $system = null;
	
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();	
		
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->dao('certificados');
		$this->system->load->dao('curso');
		$this->system->load->dao('aulas');
		$this->system->load->model('email_model');
		
	
	}
	// ===============================================================
	public function gerarCertificadoImpresso($matriculaID) {

		$certificadoDigital = $this->system->certificados->getCertificadoCondicao(' and matricula_curso_id = ' . $matriculaID . ' and tipo_certificado = 1');
		$curso = $this->system->curso->getCurso($certificadoDigital['curso_id']);

		$campos['aluno_id'] = $certificadoDigital['aluno_id'];
		$campos['aluno_nome'] = $certificadoDigital['aluno_nome'];
		$campos['curso_id'] = $certificadoDigital['curso_id'];
		$campos['carga'] = $certificadoDigital['carga'];
		$campos['matricula_curso_id'] = $matriculaID;
		$campos['tipo_certificado'] = 2;
		$campos['status'] = 5;
		$campos['data_emissao'] = date('Y-m-d');
		$id = $this->system->certificados->cadastrar($campos);
		$numero = str_pad($id, 5, "0", STR_PAD_LEFT);

	
		//Gera o PDF para anexo
		$this->system->view->assign(array(
			'url_site'			=> $this->system->getUrlSite(),
			'aluno' 	 	  	=> strtoupper($certificadoDigital['aluno_nome']),
			'curso' 		  	=> strtoupper($curso['curso']),
			'carga'			  	=> $certificadoDigital['carga'],
			'numero'		  	=> $numero,
			'data_solicitacao'	=> date('d/m/Y'),
			'data_emissao'	  	=> date('d') . ' de ' . utf8_encode($this->system->arrays->getMes(date('m'))) . ' de ' . date('Y')
		));

		if ($certificadoDigital['curso_id'] == 78) //Modelo Runrun
			$html = $this->system->view->fetch('global/modelo_certificado_runrun.tpl');
		else //Modelo Padrão
			$html = $this->system->view->fetch('global/modelo_certificado.tpl');

		$caminho = $this->system->getUploadPath() . '/pdf/certificado_grafica_' . $id . '.pdf';
		$this->system->func->htmlToPdf2($html, 'A4-L', true, $caminho);	
		
		//Email grafica
		$graficas = $this->system->configuracoesgerais->getGraficas();

		$this->system->email_model->emailGrafica($numero, $certificadoDigital['aluno_nome'], $curso['curso'], $graficas['grafica_email_1'], array($caminho));
		
		if ($graficas['grafica_email_2'])
			$this->system->email_model->emailGrafica($numero, $certificadoDigital['aluno_nome'], $curso['curso'], $graficas['grafica_email_2'], array($caminho));

		if ($graficas['grafica_email_3'])
			$this->system->email_model->emailGrafica($numero, $certificadoDigital['aluno_nome'], $curso['curso'], $graficas['grafica_email_3'], array($caminho));

		//Email Administrativo
		$this->system->email_model->certificadoEmitidoAdministrativo($numero);

		unlink($caminho);
	}
	// ==============================================================
	public function gerarCertificado($matriculaID) {

		$usuarioId = $this->system->session->getItem('session_cod_usuario');

		$cursoAluno = end($this->system->curso->getCursosAlunos(" and usuario_id = '" . $usuarioId . "' and id = '" . $matriculaID . "'", '', '', false));
		$curso = $this->system->curso->getCurso($cursoAluno['curso_id']);

		$totalAulas = $this->system->aulas->countAulasCurso($curso['id']);
		$aulasAssistidas = $this->system->aulas->countAulasAssistidas($matriculaID);
		$porcentagem = ($aulasAssistidas/$totalAulas)*100;

		
		//gerar certificado se atingiu o minimo para obter o certificado.
		$certificadoConfig = $this->system->configuracoesgerais->getCertificadoPorcentagem();

		if ($porcentagem >= $certificadoConfig['certificado_porcentagem']) {
			
			//digital
			$certificadoDigital = $this->system->certificados->getCertificadoCondicao(' and matricula_curso_id = ' . $matriculaID . ' and tipo_certificado = 1');
			if (empty($certificadoDigital['id'])) {
				$campos['aluno_id'] = $usuarioId;
				$campos['aluno_nome'] = $this->system->session->getItem('session_nome');
				$campos['curso_id'] = $curso['id'];
				$campos['carga'] = $curso['carga_horaria'];
				$campos['matricula_curso_id'] = $matriculaID;
				$campos['tipo_certificado'] = 1;
				$campos['status'] = 1;
				$campos['data_emissao'] = date('Y-m-d');
				$this->system->certificados->cadastrar($campos);

				$this->system->email_model->certificadoEmitidoAluno($usuarioId, $curso['curso']);

				$this->system->load->dao('estatisticas');
				$this->system->estatisticas->cadastrar($usuarioId, $curso['id'], $certificadoConfig['certificado_porcentagem']);

				$this->system->curso->atualizarCursoAluno(array('certificado_emitido' => 1), $matriculaID);
			} 

			//Impresso
			$certificadoImpresso = $this->system->certificados->getCertificadoCondicao(' and matricula_curso_id = ' . $matriculaID . ' and tipo_certificado = 2');
			if (empty($certificadoImpresso['id']) && $cursoAluno['certificado']) {
				$this->gerarCertificadoImpresso($matriculaID);

			} 		
		}
	}
	
	
}
// ===================================================================