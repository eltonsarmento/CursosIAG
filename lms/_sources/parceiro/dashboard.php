<?php
// ===================================================================
class Dashboard {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('vendas');
		$this->system->load->dao('alunos');
		$this->system->load->dao('curso');
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
		$ultimas_10_vendas = $this->system->vendas->getVendas(" and parceiro_id = '" . $this->system->session->getItem('session_cod_usuario') . "'", 5);
		foreach($ultimas_10_vendas as $key => $vendas) {
			$ultimas_10_vendas[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
				$cursos[] = $curso_dados['curso'];
			}
			$ultimas_10_vendas[$key]['cursos'] = implode('<br/>', $cursos);
		}
		$ultimaNotificacao = $this->system->notificacoes->getUltimaNotificacao($this->system->session->getItem('session_cod_usuario'));
		$this->system->view->assign(array(
			'ultimas_10_vendas'	=> 	$ultimas_10_vendas,
			'ultimaNotificacao'	=>	$ultimaNotificacao
		));
		$this->system->admin->topo(1);
		$this->system->view->display('parceiro/dashboard.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
}
// ===================================================================