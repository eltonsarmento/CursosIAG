<?php
// ===================================================================
class Dashboard {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('curso');
		$this->system->load->dao('professores');
		$this->system->load->dao('notificacoes');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		
		switch($this->system->input['do']) {
			case 'home': $this->doDashboard(); break;
			default: $this->doDashboard(); break;
		}
	}
	// ===============================================================
	private function doDashboard() {

		//Notificação
		$ultimaNotificacao = $this->system->notificacoes->getUltimaNotificacao($this->system->session->getItem('session_cod_usuario'));
		$ultimaNotificacao['conteudo'] = strip_tags(html_entity_decode($ultimaNotificacao['conteudo']));
		//Cursos
		$cursos = $this->system->curso->getCursos('', 5, 'data_cadastro desc');
		foreach ($cursos as $key => $value) {
			$cursos[$key]['professor'] = $this->system->professores->getProfessor($value['professor_id']);
		}

		//Professores
		$professores = $this->system->professores->getProfessores('', 5, 'data_cadastro desc');

		$this->system->view->assign('professores', $professores);
		$this->system->view->assign('cursos', $cursos);
		$this->system->view->assign('ultimaNotificacao', $ultimaNotificacao);
		$this->system->admin->topo(1);
		$this->system->view->display('coordenador/dashboard.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function pagina404() {
		$this->system->view->assign('categoria', 'coordenador');
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
}
// ===================================================================