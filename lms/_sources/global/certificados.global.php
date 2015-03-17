<?php
// ===================================================================
class CertificadosGlobal {
	// ===============================================================
	protected $system = null;
	protected $limit = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('certificados');
		$this->system->load->dao('curso');
		$this->system->load->dao('alunos');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);

    	if (in_array($this->system->session->getItem('session_nivel'), $this->acessoPermitido)) {
    		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
    		switch($this->system->input['do']) {
				case 'relatorio': 			$this->doListar(); break;
				case 'buscar': 				$this->doListar(); break;
				case 'salvarStatus': 		$this->doMudarStatus(); break;
				case 'salvarRastreamento': 	$this->doMudarRastreamento(); break;
				case 'gerarRelatorio': 		$this->doRelatorio(); break;
				case 'pdf': 				$this->doPdf(); break;
				case 'jpg': 				$this->doJpg(); break;
				case 'xls': 				$this->doXls(); break;
				default: 		$this->pagina404(); break;
			}	
    	} else  {
    		$this->pagina404();
    	}	
	}
	
	// ===============================================================
	protected function doListar() {
		$this->listagem();

		$this->system->view->assign('cursos', $this->system->curso->getCursos());		
		$this->system->view->assign('alunos', $this->system->alunos->getAlunos());		

		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('certificados-gerenciar'));
		$this->system->view->display('global/certificados_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function listagem() {
		//modos de busca
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		else $palavra = $this->system->input['palavra_busca'];
			
		$certificados = $this->system->certificados->getCertificados($palavra, $this->limit);
		
		$this->system->view->assign('certificados', $certificados);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	protected function doMudarStatus() {
		$id = $this->system->input['id'];
		$posicao = $this->system->input['posicao'];
		$status = $this->system->input['status'];

		$this->system->certificados->salvarStatus($id, $status);
		echo "Status alterado";
		switch ($status) {
			case 1:
				$html = '<span class="label label-success"><i class="iconfa-ok"></i> Entregue</span>';
				break;
			case 2:
				$html = '<span class="label label-info"><i class="iconfa-info-sign"></i> Enviado</span>';
				break;
			case 3:
				$html = '<span class="label label-warning"><i class="iconfa-warning-sign"></i> Aguardando pagamento</span>';
				break;
			case 4:
				$html = '<span class="label label-important"><i class="iconfa-remove"></i> Cancelado por falta de pagamento</span>';
				break;
			case 5:
				$html = '<span class="label label-info"><i class="iconfa-info-sign"></i> Enviado para impressão </span>';
				break;
		}

		//Email
		$certificado = $this->system->certificados->getCertificado($id);
		
		$this->system->email_model->alteradoStatusCertificadoAluno($certificado['aluno']['email'], $certificado['aluno']['nome'], $certificado['curso']['curso']);

		echo ' <script>jQuery("#td_status_' . $posicao .'").html(\'' . $html . '\')</script>';
		echo ' <script>jQuery("#status_' . $posicao .'").val(\'' . $status . '\')</script>';
	}

	// ===============================================================
	protected function doMudarRastreamento() {
		$id = $this->system->input['id'];
		$posicao = $this->system->input['posicao'];
		$rastreamento = $this->system->input['rastreamento'];

		$this->system->certificados->salvarRastreamento($id, $rastreamento);
		echo "Rastreamento alterado";
		if ($rastreamento) 
			echo '<script type="text/javascript">jQuery("#td_rastreamento_' . $posicao .'").html("' . $rastreamento . '")</script>';	
		else
			echo '<script type="text/javascript">jQuery("#td_rastreamento_' . $posicao .'").html("Não existe")</script>';	
		echo ' <script>jQuery("#codigo_rastreamento_' . $posicao .'").val(\'' . $rastreamento . '\')</script>';
	}
	// ===============================================================
	protected function doRelatorio() {
		$tiposRelatorios = $this->system->input['tipo_relatorio'];
		if (count($tiposRelatorios) == 0) {
			echo '<span style="color:red;">Selecione um tipo de relatório</span>';	
		} elseif (!$this->system->input['periodo1'] || !$this->system->input['periodo2']) {
			echo '<span style="color:red;">Selecione o período!</span>';
		} elseif (!$this->system->func->checkDate($this->system->input['periodo1']) || !$this->system->func->checkDate($this->system->input['periodo2']) ) {
			echo '<span style="color:red;">Data inválida!</span>';
		} else {
			echo '';
			$this->gerarRelatorio();	
			
			if (in_array('pdf',$tiposRelatorios))
				echo '<script type="text/javascript">window.open("'.$this->system->getUrlSite().'lms/'.$this->system->admin->getCategoria().'/certificados/pdf")</script>';
			if (in_array('jpg',$tiposRelatorios))
				echo '<script type="text/javascript">window.open("'.$this->system->getUrlSite().'lms/'.$this->system->admin->getCategoria().'/certificados/jpg")</script>';
			if (in_array('xls',$tiposRelatorios))
				echo '<script type="text/javascript">window.open("'.$this->system->getUrlSite().'lms/'.$this->system->admin->getCategoria().'/certificados/xls")</script>';

			//$this->system->session->deleteItem('relatorio');
		}

	} 
	
	// ===============================================================
	protected function gerarRelatorio() {
		$curso = $this->system->input['curso'];
		$aluno = $this->system->input['aluno'];
		$periodo1 = $this->system->func->converteData($this->system->input['periodo1']);
		$periodo2 = $this->system->func->converteData($this->system->input['periodo2']);

		if ($curso) { //Relatorio Baseado em Curso
			$relatorio['curso'] = $this->system->curso->getCurso($curso);
			$relatorio['certificados'] = $this->system->certificados->relatorioPorCursos($curso, $periodo1, $periodo2, $aluno);
			$relatorio['tipo_relatorio'] = 'curso';

			
		} elseif($aluno) { //Relatorio Baseado em Curso
			$relatorio['aluno'] = $this->system->alunos->getAluno($aluno);
			$relatorio['certificados'] = $this->system->certificados->relatorioPorAluno($aluno, $periodo1, $periodo2);
			$relatorio['tipo_relatorio'] = 'aluno';			

		} else { //Relatorio Baseado em Periodo
			$relatorio['certificados'] = $this->system->certificados->relatorioPorPeriodo($periodo1, $periodo2);
			$relatorio['tipo_relatorio'] = 'periodo';			
		}

		$relatorio['total'] = count($relatorio['certificados']); 
		$relatorio['periodo1'] = $this->system->input['periodo1'];
		$relatorio['periodo2'] = $this->system->input['periodo2'];
		$relatorio['data_atual'] = date('H:i - d/m/Y');
		$relatorio['url_site'] = $this->system->getUrlSite();

		$this->system->session->addItem('relatorio', $relatorio);
	}

	// ===============================================================
	protected function doPdf() {
		$relatorio = $this->system->session->getItem('relatorio');
		$this->system->view->assign('certificados', $relatorio['certificados']);
		$this->system->view->assign('total', $relatorio['total']);
		$this->system->view->assign('periodo1', $relatorio['periodo1']);
		$this->system->view->assign('periodo2', $relatorio['periodo2']);
		$this->system->view->assign('data_atual', $relatorio['data_atual']);
		$this->system->view->assign('url_site', $relatorio['url_site']);
		$this->system->view->assign('dir_site', $this->system->getRootPath());
		
		if ($relatorio['tipo_relatorio'] == 'curso') {
			$this->system->view->assign('curso', $relatorio['curso']);
			$html = $this->system->view->fetch('relatorios/certificado_curso_pdf.tpl');
		}
		if ($relatorio['tipo_relatorio'] == 'aluno') {
			$this->system->view->assign('aluno', $relatorio['aluno']);
			$html = $this->system->view->fetch('relatorios/certificado_aluno_pdf.tpl');
		}
		if ($relatorio['tipo_relatorio'] == 'periodo') {
			$html = $this->system->view->fetch('relatorios/certificado_periodo_pdf.tpl');
		}
		$this->system->func->htmlToPdf2($html);
	}
	// ===============================================================
	protected function doJpg() {
		$relatorio = $this->system->session->getItem('relatorio');
		
		$this->system->view->assign('certificados', $relatorio['certificados']);
		$this->system->view->assign('total', $relatorio['total']);
		$this->system->view->assign('periodo1', $relatorio['periodo1']);
		$this->system->view->assign('periodo2', $relatorio['periodo2']);
		$this->system->view->assign('data_atual', $relatorio['data_atual']);
		$this->system->view->assign('url_site', $relatorio['url_site']);
		
		if ($relatorio['tipo_relatorio'] == 'curso') {
			$this->system->view->assign('curso', $relatorio['curso']);
			$html = $this->system->view->fetch('relatorios/certificado_curso.tpl');
		}
		if ($relatorio['tipo_relatorio'] == 'aluno') {
			$this->system->view->assign('aluno', $relatorio['aluno']);
			$html = $this->system->view->fetch('relatorios/certificado_aluno.tpl');
		}
		if ($relatorio['tipo_relatorio'] == 'periodo') {
			$html = $this->system->view->fetch('relatorios/certificado_periodo.tpl');
		}
		$this->system->func->htmlToJpg($html);
	}
	// ===============================================================
	protected function doXls() {
		$relatorio = $this->system->session->getItem('relatorio');
		
		$this->system->view->assign('certificados', $relatorio['certificados']);
		$this->system->view->assign('total', count($relatorio['total']));
		$this->system->view->assign('periodo1', $relatorio['periodo1']);
		$this->system->view->assign('periodo2', $relatorio['periodo2']);
		$this->system->view->assign('data_atual', $relatorio['data_atual']);
		$this->system->view->assign('url_site', $relatorio['url_site']);
		
		if ($relatorio['tipo_relatorio'] == 'curso') {
			$this->system->view->assign('curso', $relatorio['curso']);	
			$html = $this->system->view->fetch('relatorios/certificado_curso_xls.tpl');
		}
		if ($relatorio['tipo_relatorio'] == 'aluno') {
			$this->system->view->assign('aluno', $relatorio['aluno']);
			$html = $this->system->view->fetch('relatorios/certificado_aluno_xls.tpl');
		}
		if ($relatorio['tipo_relatorio'] == 'periodo') {
			$html = $this->system->view->fetch('relatorios/certificado_periodo_xls.tpl');
		}
		header("Content-type: application/msexcel; charset=ISO-8859-1");
		header("Content-Disposition: attachment; filename=relatorio.xls");
		echo $html;
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================