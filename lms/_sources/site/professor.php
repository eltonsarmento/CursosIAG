<?php
// ===================================================================
class Professor {
	// ===============================================================
	protected $system = null;
	private $limit = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'contato': 	$this->doContato(); break;
			default: 		$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doContato() {
		$enviar = $this->system->input['enviar'];

		if ($enviar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				echo '<span class="alert alert-error" style="width:450px;">' . $erro_msg['msg'] . '</span>';
			} else {
				$this->system->load->model('email_model');
				
				$nome = $this->system->input['nome'];
				$email = $this->system->input['email'];
				$minicurriculo = $this->system->input['minicurriculo'];
				$cursos = $this->system->input['cursos'];
                $aula = $this->system->input['aula'];
				//$emailDestino = 'jonas@kmf.com.br';
				$emailDestino = 'adriano@cursosiag.com.br';

				$this->system->email_model->sejaUmProfessor($nome, $email, $minicurriculo, $cursos, $emailDestino);
				echo '<span class="alert alert-success" style="width:450px;">Mensagem enviada!</span>';
				echo '<script>limparModalProfessor();</script>';
			}
		}
		
	}

	protected function validarDados() {
		$retorno = array();
        
		//Nome
        if($this->system->input['nome'] == '') 
            $retorno['msg'][] = "O campo Nome está vázio.";
		
        //Email
        if ($this->system->input['email'] == '')
        	$retorno['msg'][] = "O campo E-mail está vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
			
        //Mini-curriculo
        if($this->system->input['minicurriculo'] == '') 
            $retorno['msg'][] = "O campo Mensagem está vázio.";

        //Cursos
        if($this->system->input['cursos'] == '') 
            $retorno['msg'][] = "O campo Cursos está vázio.";
        
        //Aula
        if($this->system->input['aula'] == '') 
            $retorno['msg'][] = "O campo Aula está vázio.";
	    
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