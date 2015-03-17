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
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/alunos/buscar/');
				exit();
				break;
			case 2:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/certificados/buscar/');
				exit();
				break;
			case 3:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/professores/buscar/');
				exit();
				break;
			case 4:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/parceiros/buscar/');
				exit();
				break;
			case 5:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/administrativos/buscar/');
				exit();
				break;
			case 6:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/curso/buscar/');
				exit();
				break;
			case 7:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/planos/buscar/');
				exit();
				break;
			case 8:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/notificacoesadmin/buscar/');
				exit();
				break;
			case 9:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/administradores/buscar/');
				exit();
				break;
			case 10:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/coordenadores/buscar/');
				exit();
				break;
			case 11:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/categorias/buscar/');
				exit();
				break;
			case 12:
				session_write_close();
				header('Location:' .  $this->system->getUrlSite() .'lms/administrador-geral/vendas/buscar-vendas/');
				exit();
				break;
		}
		exit();
	}
	
}
// ===================================================================