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
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		
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
				header('Location:' .  $this->system->getUrlSite() .'lms/parceiro/alunos/buscar/');
				break;
			case 2:
				header('Location:' .  $this->system->getUrlSite() .'lms/parceiro/vendas/buscar/');
				break;
		}
		exit();
	}
	
}
// ===================================================================