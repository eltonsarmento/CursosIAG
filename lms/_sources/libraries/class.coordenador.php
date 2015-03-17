<?php
// ===================================================================
class Coordenador {
	// ===============================================================
	private $module = '';
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
	}
	// ===============================================================
    public final function Load($module) {
        $this->module = $this->_name_cleaner($this->system->func->iif($module == '', 'dashboard', $module));
        if(file_exists($this->system->getRootPath() . '/_sources/global/' . strtolower($this->module) . '.php'))
             $arquivo = $this->system->getRootPath() . '/_sources/global/' . strtolower($this->module) . '.php'; 
 		elseif(file_exists($this->system->getRootPath() . '/_sources/coordenador/' . strtolower($this->module) . '.php'))
             $arquivo = $this->system->getRootPath() . '/_sources/coordenador/' . strtolower($this->module) . '.php';
         else
             $arquivo = $this->system->getRootPath() . '/_sources/coordenador/dashboard.php';
             
		require($arquivo);
	}
	// ===============================================================
	public final function Run() {
		$modulename = ucfirst($this->module);
		$class = new $modulename($this->system);
		$class->autoRun();
	}
	// ===============================================================
	public function topo($menu=0) {
		$this->system->view->assign(array(
			'menu'   		=> $menu,
			'usuario_id'	=> $this->system->session->getItem('session_cod_usuario'),
			'usuario_nome'	=> $this->system->session->getItem('session_nome'),
			'usuario_email'	=> $this->system->session->getItem('session_email'),
			)
		);
        echo $this->system->view->fetch('coordenador/estrutura.tpl');
	}
	// ===============================================================
	public function rodape() {
		echo $this->system->view->fetch('coordenador/rodape.tpl');
	}
	// ===============================================================
    private function _name_cleaner($name) {
        return preg_replace("/[^a-zA-Z0-9\-\_]/", "", $name);
    }
    // ===============================================================
}
// ===================================================================