<?php
// ===================================================================
class Busca {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'buscar': 	$this->doBuscar(); break;
			default: 		$this->doBuscar(); break;
		}
	}
	// ===============================================================
	private function doBuscar() {
		$tipo = $this->system->input['tipo'];
		$palavra = $this->system->input['palavra'];
		if ($palavra) 
			$this->system->session->addItem('palavra_busca', $palavra);
		
		switch($tipo) {
			case 1:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/professor/cursos/buscar/');
				exit();
				break;
			case 2:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/professor/duvidas/buscar/');
				exit();
				break;
			case 3:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/professor/quiz/buscar/');
				exit();
				break;
		}
		exit();
	}
	
}
// ===================================================================