<?php
// ===================================================================
class Certificado {
	// ===============================================================
	protected $system = null;
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('certificados');
		$this->system->load->dao('curso');
		$this->system->load->dao('alunos');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'buscar':		$this->doBuscar(); break;
			default: 			$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doBuscar() {
		$id = $this->system->input['id'];
		if ($id) {
			if (substr($id, 0, 4) == 'CIAG');
				$id = substr($id, 4);
			$certificado = $this->system->certificados->getCertificado($id);
			$curso = $this->system->curso->getCurso($certificado['curso_id']);
			$aluno = $this->system->alunos->getAluno($certificado['aluno_id']);
			$data = date('d') . ' de ' . $this->system->arrays->getMes(date('m')) . ' de ' . date('Y');
		}

		//exibir
		$this->system->view->assign('certificado', $certificado);
		$this->system->view->assign('curso', $curso);
		$this->system->view->assign('aluno', $aluno);
		$this->system->view->assign('data', $data);
		$this->system->view->assign('id', $id);
		$this->system->site->topo();
		$this->system->view->display('site/certificado.tpl');
		$this->system->site->rodape(array('newsletter' => 1, 'tipo_conteudo' => 'Página', 'conteudo' => 'Certificado'));
	}
	// ===============================================================
	protected function pagina404() {
		$url = end(explode($this->system->getUrlSite(), $_SERVER['REQUEST_URI']));
		$this->system->view->assign('url', $url);
		$this->system->site->topo(0);
		$this->system->view->display('site/pagina404.tpl');
		$this->system->site->rodape();
	}
}
// ===================================================================