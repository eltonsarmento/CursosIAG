<?php
// ===================================================================
class CoordenadorCheckLogin {
	// ===============================================================
	private $permitido = false;
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
	}
	// ===============================================================
	public function checkLoginCoordenador() {
		if ($this->system->session->getItem('session_logged_in')) {
    		if ($this->system->session->getItem('session_cod_usuario')) {
    			if ($this->system->session->getItem('session_nivel') == 2) {
       				$this->permitido = true;
       			}
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
			$this->system->session->addItem('session_cod_usuario', $dados->id);
			$this->system->session->addItem('session_logged_in', true);
			$this->system->session->addItem('session_nome', $dados->nome);
			$this->system->session->addItem('session_email', $dados->email);
			$this->system->session->addItem('session_senha', $dados->senha);
			$this->system->session->addItem('session_nivel', $dados->nivel);

			switch($dados->nivel) {
				case 1:
					$nivel = 'administrador';
					break;
				case 2:
					$nivel = 'coordenador';
					break;
			}

			$this->permitido = true;
	        $this->system->login->updateEntrada();
	        Header('location: /lms/' . $nivel . '/dashboard/home');
		}
	}
	// ===============================================================
	private function loadPageLogin() {
		$this->system->view->display('admin/loginPageAdmin.tpl');
		die;
	}
	// ===============================================================
}
// ===================================================================