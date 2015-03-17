<?php
// ===================================================================
class Contato {
	// ===============================================================
	protected $system = null;
	private $limit = '';
	private $tituloPagina = 'Contato';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'index': 	$this->doIndex(); break;
			default: 		$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doIndex() {
		$enviar = $this->system->input['enviar'];

		if ($enviar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msgErro', $erro_msg['msg']);
				$this->system->view->assign($this->system->input);
			} else {
				$this->system->load->model('email_model');
				
				$mensagem = $this->system->input['mensagem'];
				$deNome = $this->system->input['nome'];
				$deEmail = $this->system->input['email'];
				$this->system->email_model->enviarContato($deNome, $deEmail, $mensagem);
				$this->system->view->assign('mensagem', '');
				$this->system->view->assign('msgSucesso', 'mensagem enviada!');
			}
		}
		
		$this->system->site->topo($this->tituloPagina);
		$this->system->view->display('site/contato.tpl');
		$this->system->site->rodape(array('newsletter' => 1, 'tipo_conteudo' => 'Página', 'conteudo' => 'Contato'));
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
        
		//Nome
        if($this->system->input['nome'] == '') 
            $retorno['msg'][] = "O campo nome está vázio.";
		
        //Email
        if ($this->system->input['email'] == '')
        	$retorno['msg'][] = "O campo E-mail está vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
			
       //Nome
        if($this->system->input['mensagem'] == '') 
            $retorno['msg'][] = "O campo mensagem está vázio.";
	    
		if (count($retorno) > 0)
			$retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	
	// ===============================================================
	protected function pagina404() {
		$url = end(explode($this->system->getUrlSite(), $_SERVER['REQUEST_URI']));
		$this->system->view->assign('url', $url);
		$this->system->site->topo(0);
		$this->system->view->display('site/pagina404.tpl');
		$this->system->site->rodape();
	}
}
// ===================================================================