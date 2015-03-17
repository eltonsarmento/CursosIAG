<?php
// ===================================================================
class SessionPortal {
	// ===============================================================
	private $system = null;
	private $session_name = 'session_system';
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
		$this->startSession();
	}
	// ===============================================================
	private function startSession() {
		
	}
	// ===============================================================
	public function setNameSession($sessionname) {
		if ($sessionname)
			$this->session_name = $sessionname;
	}
	// ===============================================================
	public function endSession() {
	    setcookie("cookie_cod_usuario", "", 0, "/"); //1 mês
		return session_destroy();
	}
	// ===============================================================
	public function addItem($name, $value) {
		if ($name)
			$_SESSION[$name] = $value;
	}
	// ===============================================================
	public function getItem($name) {
		if ($name)
			return $_SESSION[$name];
	}
	// ===============================================================	
	public function deleteItem($name) {
		if ($name)
			unset($_SESSION[$name]);
	}
	// ===============================================================	
}
// ===================================================================