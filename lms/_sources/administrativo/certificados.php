<?php
require_once(dirname(__FILE__).'/../global/certificados.global.php');
// ===================================================================
class Certificados extends CertificadosGlobal {
	
	// ===============================================================
	public function autoRun() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'relatorio': 			$this->doListar(); break;
			case 'buscar': 				$this->doListar(); break;
			case 'salvarStatus': 		$this->doMudarStatus(); break;
			case 'salvarRastreamento': 	$this->doMudarRastreamento(); break;
			case 'gerarRelatorio': 		$this->doRelatorio(); break;
			case 'pdf': 				$this->doPdf(); break;
			case 'jpg': 				$this->doJpg(); break;
			case 'xls': 				$this->doXls(); break;
			default: 		$this->pagina404(); break;
		}	
	}
}
// ===================================================================