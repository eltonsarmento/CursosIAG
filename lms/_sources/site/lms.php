<?php
// ===================================================================
class Lms {
	// ===============================================================
	protected $system = null;
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('usuarios');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'recuperarSenha':		$this->doRecuperarSenha(); break;
			default: 					$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doRecuperarSenha() {

		$enviar = $this->system->input['enviar'];
		$email = $this->system->input['email'];
		
		if ($enviar) {
			if (!$this->system->func->checkEmail($this->system->input['email']))
        		$msg = 'O campo E-mail é inválido';
        	elseif(!$this->system->usuarios->checkEmailCadastrado(0, $this->system->input['email']))
        		$msg = 'Esse email não consta em nossa base';
        	else {
        		$usuario = $this->system->usuarios->getUsuarioByEmail($email);
        		$this->system->email_model->lembrarSenha($usuario['nome'], $usuario['email'], $usuario['id_md5']);
        		$msg = 'Foi enviado um e-mail informando os passos a seguir para redefinir a senha';
        	}
		}
		$this->system->view->assign('msg', ($msg));
		$this->system->view->assign('url_site', $this->system->getUrlSite());
		$this->system->view->display('global/recuperar_senha.tpl');
	}
	// ===============================================================
	protected function pagina404() {
		session_write_close();
		header('Location: ' . $this->system->getUrlSite() . '/lms');
		exit();
	}
}
// ===================================================================

