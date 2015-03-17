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
		
		switch($this->system->input['do']) {
			case 'home': $this->doDashboard(); break;
			default: $this->doDashboard(); break;
		}
	}
	// ===============================================================
	private function doDashboard() {
		$ultimasVendas = $this->system->vendas->getVendas(' and status = ' . 1, 5);
		foreach ($ultimasVendas as $key => $venda) {
			//
			$ultimasVendas[$key]['cliente'] = $this->system->alunos->getAluno($venda['aluno_id']);

			$cursos = $this->system->vendas->getCursosVenda($venda['id']);

			foreach ($cursos as $key2 => $curso) 
				$cursos[$key2] = $this->system->curso->getCurso($curso['id']);
			
			//
			$plano = $this->system->vendas->getPlanoVenda($venda['id']);
			$certificados = $this->system->vendas->getCertificadosVenda($venda['id']);

			$ultimasVendas[$key]['cursos'] = $cursos;
			$ultimasVendas[$key]['certificados'] = $certificados;
			$ultimasVendas[$key]['plano'] = $plano;
		}

		$ultimaNotificacao = $this->system->notificacoes->getUltimaNotificacao($this->system->session->getItem('session_cod_usuario'));

		$this->system->view->assign(array(
			'ultimasVendas'	=> 	$ultimasVendas,
			'ultimaNotificacao'	=>	$ultimaNotificacao
		));
		$this->system->admin->topo(1);
		$this->system->view->display('administrativo/dashboard.tpl');
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