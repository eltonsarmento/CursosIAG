<?php
// ===================================================================
class AdminCheckLogin {
	// ===============================================================
	private $permitido = false;
	private $system = null;
	private $mensagem = false;
	private $debug = true;

	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
	}
	// ===============================================================
	public function checkLoginAdmin() {

		if (!$this->system->session->getItem('session_logged_in')) {
			$this->verificarCookie();
		}

		if ($this->system->session->getItem('session_logged_in')) {
    		if ($this->system->session->getItem('session_cod_usuario')) {
    			$this->permitido = true;
    		}
		}
		
		if ($this->system->input['logar'] && $this->system->input['usuario'] && $this->system->input['senha'])
			$this->executarLogin();
		
		if ($this->permitido == false) {
			
			if ($this->debug) {
				//DEBUG
				if ($_SERVER['REQUEST_URI'] != '/lms/')  {
					$log['link'] = $_SERVER['REQUEST_URI'];
					$log['logado'] = ($this->system->session->getItem('session_logged_in') ? 'Sim' : 'Nao');
					$log['usuario'] = $this->system->session->getItem('session_cod_usuario');
					$log['data'] = date('Y-m-d H:i:s');
					$log['sessao'] = session_id();
					$log['host'] = $_SERVER['SERVER_NAME'];
					$log['ip'] = $this->system->func->getIP();
					

					$fp = fopen($this->system->getRootPath() . '/logs/log-' . date('Y-m-d') . '.txt', 'a');
					$escreve = fwrite($fp, json_encode($log)."\n");
					fclose($fp);	
				}
				//FIM DEBUG
			}
			
			$this->loadPageLogin();
		}
	}
	// ===============================================================
	private function executarLogin() {

		$this->system->load->dao('login');
	    $dados = $this->system->login->getLoginDao($this->system->input['usuario'], $this->system->input['senha']);
	    if ($dados->id) {
	    	if ($this->system->login->checarBanco($dados->id)) {
	    		$this->mensagem = 'Existe alguém logado nessa conta.<br/> Caso você tenha se logado em outra máquina<br/> e esqueceu de deslogar,<br/> espere 1h para ter seu acesso liberado.';
	    		return;
	    	}
	    }
		if ($dados) {
			$this->system->session->addItem('session_logged_in', 	true);
			$this->system->session->addItem('session_cod_usuario', 	$dados->id);
			$this->system->session->addItem('session_nome', 		$dados->nome);
			$this->system->session->addItem('session_email', 		$dados->email);
			// $this->system->session->addItem('session_senha', 		$dados->senha);
			$this->system->session->addItem('session_avatar', 		$dados->avatar);
			$this->system->session->addItem('session_nivel', 		$dados->nivel);
			$this->system->session->addItem('session_themecss', 	$dados->themecss);
			
			$categorias = $this->system->arrays->getArrayCategorias();
			$this->system->session->addItem('session_nivel_categoria', $categorias[$dados->nivel]);
			
			$this->system->login->updateEntrada($dados->id);
			if ($this->system->input['lembrar']) 
			 	$expire = time() + 60 * 60 * 24 * 30;
	        else
	        	$expire = null;
	        setcookie("cookie_cod_usuario", $dados->id, $expire, '/', '.cursosiag.com.br'); //1 mês

	        if ($this->debug) {
		        //DEBUG
		        $log['logado'] = ($this->system->session->getItem('session_logged_in') ? 'Sim' : 'Nao');
				$log['usuario'] = $this->system->session->getItem('session_cod_usuario');
				$log['nivel'] = $this->system->session->getItem('session_nivel');
				$log['data'] = date('Y-m-d H:i:s');
				$log['sessao'] = session_id();
				$log['host'] = $_SERVER['SERVER_NAME'];
				$log['ip'] = $this->system->func->getIP();

				$fp = fopen($this->system->getRootPath() . '/logs/log-' . date('Y-m-d') . '.txt', 'a');
				$escreve = fwrite($fp, json_encode($log)."\n");
				fclose($fp);	
				//FIM DEBUG
			}

			session_write_close();
	        Header('location: ' . $this->system->getUrlSite() . 'lms/' . $categorias[$dados->nivel] . '/dashboard/home');
			exit();
		}
		$this->mensagem = 'Usuário ou senha incorreta.';
	}
	// ===============================================================
	private function loadPageLogin() {
		$this->system->view->assign(array(
			'form_action'  => 'index.php?module=home&amp;do=login',
			'url_site'	   => $this->system->getUrlSite(),
			'mensagem_erro'	=> $this->mensagem,
			'admin_titulo' => 'Gerenciador de Conte&uacute;do :: Login')
		);
		$this->system->view->display('global/login.tpl');
		die;
	}
	// ===============================================================
	private function verificarCookie() {
		if ($_COOKIE["cookie_cod_usuario"]) {
			$usuario_id = $_COOKIE["cookie_cod_usuario"];
			$this->system->load->dao('usuarios');
			$dados = $this->system->usuarios->getUsuario($usuario_id);
			if (count($dados) > 0) {
				$this->system->session->addItem('session_logged_in', 	true);
				$this->system->session->addItem('session_cod_usuario', 	$dados['id']);
				$this->system->session->addItem('session_nome', 		$dados['nome']);
				$this->system->session->addItem('session_email', 		$dados['email']);
				// $this->system->session->addItem('session_senha', 	$dados->senha);
				$this->system->session->addItem('session_avatar', 		$dados['avatar']);
				$this->system->session->addItem('session_nivel', 		$dados['nivel']);
				$this->system->session->addItem('session_themecss', 	$dados['themecss']);
				
				$categorias = $this->system->arrays->getArrayCategorias();
				$this->system->session->addItem('session_nivel_categoria', $categorias[$dados['nivel']]);

				$this->system->load->dao('login');
				$this->system->login->updateEntrada($dados['id']);

				if ($this->debug) {
					//DEBUG
					$log['cookie'] = 1;
			        $log['logado'] = ($this->system->session->getItem('session_logged_in') ? 'Sim' : 'Nao');
					$log['usuario'] = $this->system->session->getItem('session_cod_usuario');
					$log['nivel'] = $this->system->session->getItem('session_nivel');
					$log['data'] = date('Y-m-d H:i:s');
					$log['sessao'] = session_id();
					$log['host'] = $_SERVER['SERVER_NAME'];
					$log['ip'] = $this->system->func->getIP();

					$fp = fopen($this->system->getRootPath() . '/logs/log-' . date('Y-m-d') . '.txt', 'a');
					$escreve = fwrite($fp, json_encode($log)."\n");
					fclose($fp);	
					//FIM DEBUG
				}
			}
		}
	}
	// ===============================================================
}
// ===================================================================