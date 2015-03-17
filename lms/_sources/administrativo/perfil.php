<?php
require_once(dirname(__FILE__).'/../global/perfil.global.php');

// ===================================================================
class Perfil extends PerfilGlobal {
	
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {			
			case 'trocarSenha': $this->doAlterarSenha(); break;
			default: $this->doEditar(); break;
		}
	}
	
}
// ===================================================================
