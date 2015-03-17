<?php
// ===================================================================
class Admin {
	// ===============================================================
	private $module = '';
	private $system = null;
	private $categoria = '';
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
		$this->categoria = $this->system->session->getItem('session_nivel_categoria');
		//eval(base64_decode('aWYgKCc4MjJlNTcyNjRjODE2ODkwMmM4OTMwNjYzMjYwMjU3NjUxMDBjYzNkJyAhPSBzaGExKGRpcm5hbWUoX19GSUxFX18pKSkge2RpZTt9'));
	}
	// ===============================================================
    public final function Load($module) {
    	if (!$this->categoria)
    		$this->categoria = $this->system->session->getItem('session_nivel_categoria');
    	
        $this->module = $this->_name_cleaner($this->system->func->iif($module == '', 'dashboard', $module));
        			
 		if(file_exists($this->system->getRootPath() . '/_sources/'.$this->system->admin->categoria.'/' . strtolower($this->module) . '.php'))
            $arquivo = $this->system->getRootPath() . '/_sources/'.$this->system->admin->categoria.'/' . strtolower($this->module) . '.php';
        else {
        	session_write_close();
            header('Location: ' . $this->system->getUrlSite() . 'lms/' . $this->system->admin->categoria . '/erro/pagina404');
            exit();
        }
		
		require($arquivo);
	}
	// ===============================================================
	public final function Run() {
		$modulename = ucfirst($this->module);
		$class = new $modulename($this->system);
		$class->autoRun();
	}
	// ===============================================================
    private function _name_cleaner($name) {
        return preg_replace("/[^a-zA-Z0-9\-\_]/", "", $name);
    }
	// ===============================================================
	public function topo($menu = 0, $javascript=array()) {
		//Notificações
		$notificacoes = (array)$this->system->session->getItem('notificacoes_topo');
		if ($this->system->session->getItem('session_nivel') != 1  && empty($notificacoes)) {
			$this->system->load->dao('notificacoes');
			$notificacoes = $this->system->notificacoes->getNaoLidas($this->system->session->getItem('session_cod_usuario'));
			$this->system->session->addItem('notificacoes_topo', $notificacoes);
		}

		//Duvidas
		$duvidas_topo = (array)$this->system->session->getItem('duvidas_topo');
		if (($this->system->session->getItem('session_nivel') == 3 || $this->system->session->getItem('session_nivel') == 4) && empty($duvidas_topo)){ //Professor e aluno
			$this->system->load->dao('duvidas');
			$aluno = ($this->system->session->getItem('session_nivel') == 4 ? true : false);
			$duvidas_topo = $this->system->duvidas->getNaoLidas($this->system->session->getItem('session_cod_usuario'), $aluno);
			$this->system->session->addItem('duvidas_topo', $duvidas_topo);
		}

		//Estatisticas
		$estatisticas_topo = (array)$this->system->session->getItem('estatisticas_topo');
		if ($this->system->session->getItem('session_nivel') == 4 && empty($estatisticas_topo)) {
			$this->system->load->dao('estatisticas');
			$estatisticas_topo = $this->system->estatisticas->getNaoVistas($this->system->session->getItem('session_cod_usuario'));
			$this->system->session->addItem('estatisticas_topo', $estatisticas_topo);
		}

		$this->system->view->assign(array(
			'menu'   				=> $menu,
			'usuario_id'			=> $this->system->session->getItem('session_cod_usuario'),
			'usuario_nome'			=> $this->system->session->getItem('session_nome'),
			'usuario_email'			=> $this->system->session->getItem('session_email'),
			'usuario_avatar'		=> $this->system->session->getItem('session_avatar'),
			'themecss'				=> $this->system->session->getItem('session_themecss'),
			'url_site'				=> $this->system->getUrlSite(),
			'estatisticas_topo'		=> $estatisticas_topo,
			'notificacoes_topo'		=> $notificacoes,
			'duvidas_topo'			=> $duvidas_topo,
		));
        echo $this->system->view->fetch($this->categoria.'/estrutura.tpl');
	}
	// ===============================================================
	public function rodape() {

		echo $this->system->view->fetch($this->categoria.'/rodape.tpl');
	}
	// ===============================================================
	public function getCategoria() {
		return $this->categoria;
	}
	// ===============================================================
}
// ===================================================================