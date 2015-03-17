<?php
// ===================================================================
class NotificacoesGlobal {
	// ===============================================================
	protected $system = null;
	protected $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('notificacoes');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': $this->doListar(); break;
			case 'ler': $this->doLer(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	protected function doListar() {
		$notificacaoID = $this->system->input['id'];
		$id = $this->system->session->getItem('session_cod_usuario');
		if (!$id) {
			session_write_close();
			header('Location: ' . $this->system->getUrlSite() . 'lms/'.$this->system->admin->getCategoria().'/dashboard/home/');
			exit();
		}
		//$this->system->notificacoes->marcarLida($id);
		$notificacoes = $this->system->notificacoes->getNotificacoes($id);
		foreach ($notificacoes as $key => $notificacao) {
			$notificacoes[$key]['resumo'] = utf8_decode(substr(strip_tags(html_entity_decode($notificacao['conteudo'])), 0, 200));
			$notificacoes[$key]['conteudo'] = utf8_decode($notificacao['conteudo']);
		}
		$this->system->view->assign('notificacoes', $notificacoes);
		$this->system->view->assign('notificacaoAberta', $notificacaoID);
		// $this->system->view->assign('url_site', $this->system->getUrlSite());
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());

		$menu = 0;
		if (in_array($this->system->session->getItem('session_nivel'), array(3, 4))) //Professor e Aluno
			$menu = 2;
			
		$this->system->admin->topo($menu);
		$this->system->view->display('global/notificacoes_listar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doLer() {
		$notificacao = $this->system->input['notificacao'];
		$this->system->notificacoes->marcarLida($notificacao);

		$notificacao = $this->system->notificacoes->lerNotificacao($notificacao);

		$this->system->session->deleteItem('notificacoes_topo');
		
		if ($notificacao['id']) {
			$conteudo = explode("\n", $notificacao['conteudo']);
			$msg = "' '";
			foreach ($conteudo as $linha) {
				$msg .= "+'". $linha . "'";
			}

			echo "<script type='text/javascript'>jAlert(" . $msg . ",'" . $notificacao['titulo'] . "')</script>";
		}
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================
