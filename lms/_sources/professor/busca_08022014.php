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
				header('Location:' .  $this->system->getUrlSite() .'lms/professor/cursos/buscar/');
				break;
			case 2:
				header('Location:' .  $this->system->getUrlSite() .'lms/professor/duvidas/buscar/');
				break;
			case 3:
				header('Location:' .  $this->system->getUrlSite() .'lms/professor/quiz/buscar/');
				break;
		}
		exit();
	}
	
}
// ===================================================================