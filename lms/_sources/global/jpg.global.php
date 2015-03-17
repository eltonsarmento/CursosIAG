<?php
// ===================================================================
class JpgGlobal {
	// ===============================================================
	protected $system = null;
	protected $redir = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'download': 	$this->doDownload(); break;
			default: 		$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doDownload() {
		$this->system->view->assign('img_val', $this->system->input['img_val']);
		$this->system->view->display('global/download_jpg.tpl');
		
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================