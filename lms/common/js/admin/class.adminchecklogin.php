<?php
// ===================================================================
class AdminCheckLogin {
	// ===============================================================
	private $permitido = false;
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
	}
	// ===============================================================
	public function checkLoginAdmin() {
		if ($this->system->session->getItem('session_logged_in')) {
    		if ($this->system->session->getItem('session_id')) {
       			$this->permitido = true;
    		}
		}
		
		if ($this->system->input['usuario'] && $this->system->input['senha'])
			$this->executarLogin();
		
		if ($this->permitido == false)
			$this->loadPageLogin();
	}
	// ===============================================================
	private function executarLogin() {
		$this->system->load->dao('login');
		$dados = $this->system->login->getLoginDao($this->system->input['usuario'], $this->system->input['senha']);
		if ($dados) {
			$this->system->session->addItem('session_id', 			$dados['id']);
			$this->system->session->addItem('session_nivel', 		$dados['nivel']);
			$this->system->session->addItem('session_nome', 		$dados['nome']);
			$this->system->session->addItem('session_email', 		$dados['email']);
			$this->system->session->addItem('session_senha', 		$dados['senha']);
			$this->system->session->addItem('session_logged_in', 	true);
			$this->permitido = true;
			$this->system->login->updateEntrada();
			Header('location: index.php?module=home');
			die;
		}
		$this->system->view->assign('erroLogin', true);
	}
	// ===============================================================
	private function loadPageLogin() {
		$this->system->view->assign(array(
			'form_action'  => 'index.php?module=home&amp;do=login',
			'url_site'	   => $this->system->getUrlSite(),
			'admin_titulo' => 'Gerenciador de Conte&uacute;do :: Login')
		);
		$this->system->view->display('admin/loginPageAdmin.tpl');
		die;
	}
	// ===============================================================
}
// ===================================================================