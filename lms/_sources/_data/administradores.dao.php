<?php
require_once(dirname(__FILE__).'/usuarios.dao.php');
// ===================================================================
class AdministradoresDAO extends UsuariosDAO{
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('usuarios', array(
        	'nome'			=> trim($input['nome']),
        	'senha'			=> trim($input['senha']),
        	'email'			=> trim($input['email']),
        	'nivel'			=> 1,
            'avatar'        => 'avatar_padrao.jpg',
            'cadastro_por_id'   => $this->system->session->getItem('session_cod_usuario'),
        	'data_cadastro' => date('Y-m-d H:i:s'),
        	'ativo'			=> 1
        ));
		$id = $this->system->sql->nextid();
		$this->system->sql->insert('usuarios_dados', array(
			'usuario_id'		=> $id,
			'email_secundario'	=> trim($input['email_secundario']),
			'cpf'				=> trim($input['cpf']),
			'cep'				=> trim($input['cep']),
			'endereco'			=> trim($input['endereco']),
			'complemento'		=> trim($input['complemento']),
			'bairro'			=> trim($input['bairro']),
			'cidade'			=> trim($input['cidade']),
			'estado'			=> trim($input['estado']),
			'telefone'			=> trim($input['telefone']),
        ));

		$this->system->sql->update('usuarios', array('id_md5' => md5($id)), "id='" . $id . "'");

        return $id;
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('usuarios', array(
        	'nome'	=> trim($input['nome']),
           	'email'	=> trim($input['email']),
        ),
		"id='" . $input['id'] . "'");
		
		if ($input['senha']) 
			$this->system->sql->update('usuarios', array('senha' => trim($input['senha'])), "id='" . $input['id'] . "'");
		
		$this->system->sql->update('usuarios_dados', array(
	       	'email_secundario'	=> trim($input['email_secundario']),
	       	'cpf'				=> trim($input['cpf']),
			'cep'				=> trim($input['cep']),
			'endereco'			=> trim($input['endereco']),
			'complemento'		=> trim($input['complemento']),
			'bairro'			=> trim($input['bairro']),
			'cidade'			=> trim($input['cidade']),
			'estado'			=> trim($input['estado']),
			'telefone'			=> trim($input['telefone']),
	     ), "usuario_id='" . $input['id'] . "'");
	}
	// ===============================================================
	public function getAdministradores($palavra = '', $limit = '', $order = 'nome') {
		$query = $this->system->sql->select('*', 'usuarios', "excluido='0' and nivel = '1'" . ($palavra ? " and nome like '%" . $palavra . "%'" : ''), $limit, $order);
		$usuarios =  $this->system->sql->fetchrowset($query);
		return $usuarios;
	}
	// ===============================================================
	public function getAdministrador($id, $dadosCompletos = false) {
		$usuario = parent::getUsuario($id, $dadosCompletos);
        if ($usuario['nivel'] != 1)
            return array();
        return $usuario;
	}
}
// ===================================================================