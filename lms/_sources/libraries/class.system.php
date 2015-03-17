<?php
// ===================================================================
class System {
	// ===============================================================
	private static $root_path = 'D:/projetos/iag/lms/';
	private static $upload_path = 'D:/projetos/iag/lms/uploads';
	private static $url_site  = 'http://localiag.com/';
	private static $email = 'atendimento@cursosiag.com.br'; //Ar
	
	private static $instance;
	private static $categoria;
	
	const DB_SERVIDOR = '192.168.25.120';
	const DB_USUARIO = 'root';
	const DB_SENHA = '123456';
	const DB_NOME = 'iag';
	
	public $view 			= null;
	public $sql 			= null;
	public $emailer			= null;
	public $func 			= null;
	public $input 			= null;
	public $admin 			= null;
	public $session 		= null;
	public $pagination		= null;
	public $load			= null;
	public $arrays			= null;
	private $loginRequerido = true;
	private $loadAdmin 		= true;
	// ===============================================================
	public function __construct($loadAdmin = true, $loginRequerido = true) {
		self::$instance =& $this;
		$this->loginRequerido = $loginRequerido;
		$this->loadAdmin = $loadAdmin;
		$this->loadSystem();
	}
	// ===============================================================
	private function loadSystem() {
		ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
		//ini_set('error_reporting', E_ERROR);
		ini_set('mysql.connect_timeout', 1);
		ini_set('default_socket_timeout', 120);
		//ini_set('error_reporting', E_ALL);
		
		define(LIBS_DIR, self::$root_path . '/_sources/libraries');
		define(SMARTY_DIR, LIBS_DIR . '/smarty/');
		
		define('DATA1', '%d/%m/%Y &agrave;s %H:%M');
		define('DATA2', '%d/%m/%Y');
		define('DATA3', '%d/%m');
		define('DATA4', '%d/%m &agrave;s %H:%M');
		
		require(LIBS_DIR . '/class.mysql.php');
		require(LIBS_DIR . '/class.functions.php');
		require(LIBS_DIR . '/smarty/SmartyBC.class.php');
		require(LIBS_DIR . '/class.input.php');
		require(LIBS_DIR . '/class.loader.php');
		require(LIBS_DIR . '/class.emailer.php');
		require(LIBS_DIR . '/class.imagem.php');
		require(LIBS_DIR . '/class.session.php');
		require(LIBS_DIR . '/class.arrays.php');
		require(LIBS_DIR . '/class.pagination.php');
		
		$this->loadSmarty();
		$this->loadDataBase();
		
		$this->session = new Session();
		$this->load = new Loader();
		
		$this->arrays = new Arrays();

		$this->emailer = new Emailer();

		$this->pagination = new Pagination();
		
		$this->input = Input::parse_incoming();
		$this->func  = new Functions();
		
		if ($this->loadAdmin) {
			require(LIBS_DIR . '/class.admin.php');
			$this->admin 		= new Admin();
			require(LIBS_DIR . '/class.adminchecklogin.php');
			$adminchecklogin 	= new AdminCheckLogin();
			if ($this->loginRequerido)
				$adminchecklogin->checkLoginAdmin();	
		} else {
			require(LIBS_DIR . '/class.site.php');
			$this->site 		= new Site();
		}
	}
	// ===============================================================
	private function loadSmarty() {
		$this->view = new SmartyBC();

		$this->view->template_dir  = self::$root_path.'/_sources/_views/';
		$this->view->compile_dir   = self::$root_path.'/_sources/_views/compiled/';
		//$this->view->compile_dir   = 'F:\iag\compiled';
		$this->view->cache_dir     = self::$root_path.'/_sources/_views/cache/';
		$this->view->compile_check = true;
		$this->view->debugging     = false;

		$my_security_policy = new Smarty_Security($this->view);
		$my_security_policy->allow_php_tag = true;
		$my_security_policy->php_functions = array();
		$my_security_policy->php_modifiers  = array();
		$my_security_policy->php_handling = Smarty::PHP_PASSTHRU;
		$my_security_policy->modifiers = array();
		
		$this->view->enableSecurity($my_security_policy);
	}
	// ===============================================================
	private function loadDataBase() {
		$this->sql = new SqlDB(self::DB_SERVIDOR, self::DB_USUARIO, self::DB_SENHA, self::DB_NOME);
	}
	// ===============================================================
	public function getRootPath() {
		return self::$root_path;
	}
	// ===============================================================
	public function getUrlSite() {
		return self::$url_site;
	}
	// ===============================================================
	public function getEmail() {
		return self::$email;
	}
	// ===============================================================
	public function getKey() {
		return sha1(self::$root_path);
	}
	// ===============================================================
	public function getUploadPath() {
		return self::$upload_path;
	}
	// ===============================================================
	private function loadPageLogin() {
		$this->view->assign(array(
			'form_action'  => 'index.php?module=home&amp;do=login',
			'url_site'	   => $this->getUrlSite(),
			'admin_titulo' => 'Gerenciador de Conte&uacute;do :: Login')
		);
		$this->view->display('lms/login.tpl');
		die;
	}
	// ===============================================================
	public static function &getInstancia() {
		return self::$instance;
	}
	// ===============================================================
}
// ===================================================================
function &getInstancia() {
	return System::getInstancia();
}
// ===================================================================