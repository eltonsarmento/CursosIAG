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
		$this->system->load->dao('notificacoes');
		$this->system->load->dao('vendas');
		$this->system->load->dao('duvidas');
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
				
		//Curso destaque
		$this->system->view->assign('cursoDestaque', end($this->system->curso->getCursosCondicao(' and home = 1', 1, 'id desc')));

		//Ultimos 10 cursos do aluno
		$this->system->view->assign('cursos_adquiridos', $this->system->curso->getCursosByAluno($this->system->session->getItem('session_cod_usuario'), '', 10));
		
		//notificação
		$ultimaNotificacao = $this->system->notificacoes->getUltimaNotificacao($this->system->session->getItem('session_cod_usuario'));
		$ultimaNotificacao['conteudo'] = strip_tags(html_entity_decode($ultimaNotificacao['conteudo']));

		//Ultimos pedidos
		$ultimasVendas = $this->system->vendas->getVendas(" and aluno_id = '" . $this->system->session->getItem('session_cod_usuario') . "'", 10);
		foreach ($ultimasVendas as $key => $venda) {
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

		//duvidas
		$usuarioId = $this->system->session->getItem('session_cod_usuario');
		$duvidas = $this->system->duvidas->getDuvidas("and D.aluno_id = '" . $usuarioId . "' and D.excluido_aluno = 0 and curso_id in (SELECT curso_id FROM cursos_alunos WHERE expira >= '" . date('Y-m-d H:i:s') . "' and excluido = 0 and usuario_id = '" . $usuarioId . "')", 5);
		
		$this->system->view->assign(array(
			'url_site'			=> 	$this->system->getUrlSite(),
			'ultimaNotificacao'	=>	$ultimaNotificacao,
			'ultimasVendas'		=>	$ultimasVendas,
			'duvidas'			=>  $duvidas
		));
		
		$this->system->admin->topo(1);
		$this->system->view->display('aluno/dashboard.tpl');
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