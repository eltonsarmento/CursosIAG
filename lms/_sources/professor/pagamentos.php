<?php
// ===================================================================
class Pagamentos {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('pagamentos');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {	
			case 'listar':				$this->doListar(); break;		
			case 'baixar':				$this->doBaixar(); break;		
			default: $this->pagina404(); break;
		}
	}

	// ===============================================================
	protected function doListar() {
		$pagamentos = $this->system->pagamentos->getPagamentos(" and t1.usuario_id = '" . $this->system->session->getItem('session_cod_usuario') . "'");

		foreach($pagamentos as $key => $pagamento) {
			list($ano, $mes, $dia) = explode('-', $pagamento['mes_faturado']);
			$pagamentos[$key]['periodo'] = substr($this->system->arrays->getMes($mes), 0, 3) . ' de ' . $ano;
		}

		$this->system->view->assign('pagamentos', $pagamentos);
		$this->system->admin->topo(2);
		$this->system->view->display('professor/pagamentos.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doBaixar() {
		$pagamento = end($this->system->pagamentos->getPagamentos(" and t1.usuario_id = '" . $this->system->session->getItem('session_cod_usuario') . "' and t1.id = '" . $this->system->input['id'] . "'"));

		if ($pagamento['id']) {			
			$file = $this->system->getUploadPath() . '/comprovantes_pagamentos/' . $pagamento['comprovante'];
			header("Content-Disposition: attachment; filename=" . $pagamento['comprovante']);    
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Description: File Transfer");             
			header("Content-Length: " . filesize($file));
			flush(); 

			$fp = fopen($file, "r"); 
			while (!feof($fp))	{
    			echo fread($fp, 65536); 
    			flush(); // this is essential for large downloads
			}  
			fclose($fp); 	
		}
	}
	// ===============================================================
	private function pagina404() {
		$this->system->view->assign('categoria', 'professor');
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
}
// ===================================================================
