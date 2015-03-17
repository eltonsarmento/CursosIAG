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
		$this->system->load->dao('planos');
		$this->system->load->dao('certificados');
		
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
		
		//Vendas
		$ultimasVendas = $this->system->vendas->getVendas(' and status=' . 1 . " and data_cadastro like '" . date('Y') ."-" . date('m') . "-%'", 5);
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
		

		$this->system->view->assign(array(
			'total_vendas' 			=> number_format($this->system->vendas->getTotalVendas(" and status = 1 and data_cadastro like '" . date('Y') ."-" . date('m') . "-%'"), 2, ',', '.'),
			'total_pedidos' 		=> $this->system->vendas->getTotalPedidos(" and data_cadastro like '" . date('Y') ."-" . date('m') . "-%'"),
			'total_itens_pedidos' 	=> $this->system->vendas->getTotalItensPedidos(" and t1.data_cadastro like '" . date('Y') ."-" . date('m') . "-%'"),
			'ultimasVendas'			=> $ultimasVendas,
			'certificados'			=> $this->system->certificados->getCertificados('', 5)
		));

		$this->system->admin->topo(1);
		$this->system->view->display('administrador-geral/dashboard.tpl');
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