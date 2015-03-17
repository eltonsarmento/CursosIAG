<?php
require_once(dirname(__FILE__).'/usuarios.dao.php');

// ===================================================================
class ParceirosDAO extends UsuariosDAO{
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('usuarios', array(
        	'nome'				=> trim($input['nome']),
        	'senha'				=> trim($input['senha']),
        	'email'				=> trim($input['email']),
        	'nivel'				=> 5,
            'avatar'        	=> 'avatar_padrao.jpg',
            'cadastro_por_id'   => $this->system->session->getItem('session_cod_usuario'),
        	'data_cadastro' 	=> date('Y-m-d H:i:s'),
        	'ativo'	        	=> $input['ativo']
        ));
		$id = $this->system->sql->nextid();
		
		$this->system->sql->insert('usuarios_dados', array(
			'usuario_id'	 		=> $id,
			'email_secundario'		=> trim($input['email_secundario']),
        	'cep'			 		=> trim($input['cep']),
        	'cpf'			 		=> trim($input['cpf']),
			'cnpj'			 		=> trim($input['cnpj']),
        	'telefone'		 		=> trim($input['telefone']),
			'website'		 		=> trim($input['website']),
			'data_nascimento'		=> $this->system->func->converteData($input['data_nascimento']),
        	'endereco'		 		=> trim($input['endereco']),
        	'complemento'	 		=> trim($input['complemento']),
        	'bairro'		 		=> trim($input['bairro']),
        	'cidade'		 		=> trim($input['cidade']),
        	'estado'		 		=> trim($input['estado']),
        	'agencia1'		 		=> trim($input['agencia1']),
        	'conta1'		 		=> trim($input['conta1']),
        	'banco1'		 		=> trim($input['banco1']),
			'tipoconta1'	 		=> trim($input['tipoconta1']),
			'operacao1'		 		=> trim($input['operacao1']),
        	'agencia2'		 		=> trim($input['agencia2']),
        	'conta2'		 		=> trim($input['conta2']),
        	'banco2'		 		=> trim($input['banco2']),
			'tipoconta2'	 		=> trim($input['tipoconta2']),
			'operacao2'		 		=> trim($input['operacao2']),
        	'minicurriculo'	 		=> trim($input['minicurriculo']),
			'contato'		 		=> trim($input['contato']),
			'razao_social'	 		=> trim($input['razao_social']),
			'comissao'		 		=> intval($input['comissao']),
        ));

		$this->system->sql->update('usuarios', array('id_md5' => md5($id)), "id='" . $id . "'");

		return $id;
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('usuarios', array(
        	'nome'	=> trim($input['nome']),
           	'email'	=> trim($input['email']),
        	'ativo'	=> $input['ativo']
        ),
		"id='" . $input['id'] . "'");
		
		if ($input['senha']) 
			$this->system->sql->update('usuarios', array('senha' => trim($input['senha'])), "id='" . $input['id'] . "'");
		
		$this->system->sql->update('usuarios_dados', array(
			'email_secundario'		=> trim($input['email_secundario']),
        	'cep'			 		=> trim($input['cep']),
        	'cpf'			 		=> trim($input['cpf']),
			'cnpj'			 		=> trim($input['cnpj']),
			'telefone'		 		=> trim($input['telefone']),
			'website'		 		=> trim($input['website']),
        	'data_nascimento'		=> $this->system->func->converteData($input['data_nascimento']),
        	'endereco'		 		=> trim($input['endereco']),
        	'complemento'	 		=> trim($input['complemento']),
        	'bairro'		 		=> trim($input['bairro']),
        	'cidade'		 		=> trim($input['cidade']),
        	'estado'		 		=> trim($input['estado']),
        	'agencia1'		 		=> trim($input['agencia1']),
        	'conta1'		 		=> trim($input['conta1']),
        	'banco1'		 		=> trim($input['banco1']),
			'tipoconta1'	 		=> trim($input['tipoconta1']),
			'operacao1'		 		=> trim($input['operacao1']),
        	'agencia2'		 		=> trim($input['agencia2']),
        	'conta2'		 		=> trim($input['conta2']),
        	'banco2'		 		=> trim($input['banco2']),
			'tipoconta2'	 		=> trim($input['tipoconta2']),
			'operacao2'		 		=> trim($input['operacao2']),
        	'minicurriculo'	 		=> trim($input['minicurriculo']),
			'contato'		 		=> trim($input['contato']),
			'razao_social'	 		=> trim($input['razao_social']),
			'comissao'				=> intval($input['comissao']),
        ),
		"usuario_id='" . $input['id'] . "'");
	}
	// ===============================================================
	public function getParceiros($palavra = '', $limit = '', $order = 'nome') {
		$query = $this->system->sql->select('*', 'usuarios', "excluido='0' and nivel = '5'" . ($palavra? " and nome like '%" . $palavra . "%'" : ''), $limit, $order);
		$parceiros = $this->system->sql->fetchrowset($query);
		return $parceiros;
	}
	// ===============================================================
	public function getParceiro($id, $dadosCompletos = false) {
		$parceiro = parent::getUsuario($id, $dadosCompletos);
        if ($parceiro['nivel'] != 5)
            return array();
        return $parceiro;
	}
}
// ===================================================================