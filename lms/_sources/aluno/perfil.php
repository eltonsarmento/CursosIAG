<?php
require_once(dirname(__FILE__).'/../global/perfil.global.php');

// ===================================================================
class Perfil extends PerfilGlobal {
	
	public function __construct(&$system) {
		parent::__construct($system);
		$this->system->load->dao('alunos');
	}

	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {	
			case 'editar': $this->doEditar(); break;		
			case 'trocarSenha': $this->doAlterarSenha(); break;
			default: $this->doEditar(); break;
		}
	}

	// ===============================================================
	public function validarDados() {
		$retorno = array();
        if (!$this->system->input['nome']) 
            $retorno['msg'][] = "O campo nome está vazio.";
        
        //email
        $this->system->input['email'] = $this->system->session->getItem('session_email');
        if ($this->system->input['email'] == '')
        	$retorno['msg'][] = "O campo E-mail está vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
        elseif($this->system->alunos->checkEmailCadastrado($this->system->session->getItem('session_cod_usuario'), $this->system->input['email']))
        	$retorno['msg'][] = "Já existe um usuário cadastrado com esse e-mail";

       	//CPF
        if ($this->system->input['cpf'] != '' && !$this->system->func->validaCPF($this->system->input['cpf']))
        	$retorno['msg'][] = "O campo CPF é inválido.";
        
        //CEP
        if ($this->system->input['cep'] == '')
        	$retorno['msg'][] = "O campo CEP está vázio";
			
        //Endereço
        if ($this->system->input['endereco'] == '')
        	$retorno['msg'][] = "O campo Endereço está vázio";
			
        //Bairro
        if ($this->system->input['bairro'] == '')
        	$retorno['msg'][] = "O campo Bairro está vázio";
			
        //Cidade
        if ($this->system->input['cidade'] == '')
        	$retorno['msg'][] = "O campo Cidade está vázio";
			
        //Estado
        if ($this->system->input['estado'] == '')
        	$retorno['msg'][] = "O campo Estado está vázio";

        //Arquivo destaque
		if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
			$extensao = end(explode('.', $_FILES['avatar']['name']));
			if (in_array($extensao, array('jpg', 'jpeg', 'gif', 'png'))) {
				$configPerfil = $this->system->configuracoesgerais->getImagensPerfil();

				if (($_FILES['avatar']['size'] / 1024) > $configPerfil['imagem_perfil_tamanho']) {
					$retorno['msg'][] = 'A Imagem do destaque está com mais de ' . $configPerfil['imagem_perfil_tamanho'] . 'kb';
				}
			} else {
				$retorno['msg'][] = 'Formato de Imagem do destaque inválido';
			}
		}
			
		if(count($retorno) > 0) {
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
		}
        return $retorno;
	}
	
}
// ===================================================================
