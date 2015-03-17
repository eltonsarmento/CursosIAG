<?php
// ===================================================================
class Estatisticas {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('estatisticas');

	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		
		switch($this->system->input['do']) {
			case 'listar': $this->doListar(); break;
			case 'buscar': $this->doListar(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	private function doListar() {
		$this->system->load->dao('curso');

		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');

		//Ultimos 10 cursos do aluno

		$this->system->estatisticas->verEstatistica($this->system->session->getItem('session_cod_usuario'));

		$this->system->view->assign('cursos_adquiridos', $this->system->curso->getCursosByAluno($this->system->session->getItem('session_cod_usuario'), $palavra));
		

		$this->system->session->deleteItem('estatisticas_topo');
		
		$this->system->admin->topo(2);
		$this->system->view->display('aluno/estatisticas_gerenciar.tpl');
		$this->system->admin->rodape();
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