<?php
// ===================================================================
class UsuariosDAO {
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('usuarios', array(
			
		));
	
		return $this->system->sql->nextid();
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('usuarios', array(
        	'nome'	=> trim($input['nome']),
        	'email'	=> trim($input['email'])
        ),
		"id='" . $input['id'] . "'");

		$this->system->sql->update('usuarios_dados', array(
        	'cep'			=> trim($input['cep']),
        	'endereco'		=> trim($input['endereco']),
        	'complemento'	=> trim($input['complemento']),
        	'bairro'		=> trim($input['bairro']),
        	'cidade'		=> trim($input['cidade']),
        	'estado'		=> trim($input['estado']),
        	'facebook'		=> trim($input['facebook']),
        	'twitter'		=> trim($input['twitter']),
        	'google'		=> trim($input['google']),
        	'linkedin'		=> trim($input['linkedin']),
        	'website'		=> trim($input['website']),
        	'minicurriculo'	=> trim($input['minicurriculo'])
        ),
		"usuario_id='" . $input['id'] . "'");
	}
	// ===============================================================
	public function atualizarImagem($id, $imagem) {
		$this->system->sql->update('usuarios', array('avatar' => $imagem), "id='" . $id . "'");
	}
	// ===============================================================
	public function getUsuario($id, $dadosCompletos = true) {
		$query = $this->system->sql->select('*', 'usuarios', "excluido='0' and id= '" . $id . "'");
		$usuario = end($this->system->sql->fetchrowset($query));
		if ($usuario['id'] && $dadosCompletos) {
			$query = $this->system->sql->select('*', 'usuarios_dados', "usuario_id= '" . $id . "'");
			$dadosExtras = end($this->system->sql->fetchrowset($query));
			$dadosExtras['data_nascimento'] = date('d/m/Y', strtotime($dadosExtras['data_nascimento']));
			$usuario = array_merge($usuario, $dadosExtras);
		}

		return $usuario;
	}
	// ===============================================================
	public function deletar($id) {
		$this->system->sql->update('usuarios', array(
            'excluido' 	=> 1),
		"id='" . $id . "'");
	}
	// ===============================================================
	public function mudarTema($id, $theme) {
		$this->system->sql->update('usuarios', array(
            'themecss' 	=> $theme),
		"id='" . $id . "'");
	}
	// ===============================================================
	public function atualizarSenha($id, $senha) {
		$this->system->sql->update('usuarios', array(
            'senha' 	=> $senha),
		"id='" . $id . "'");
	}
	// ===============================================================
	public function getValorExtra($id, $campo) {
		$query = $this->system->sql->select($campo, 'usuarios_dados', "usuario_id='" . $id . "'");
		$result = end($this->system->sql->fetchrowset($query));
		return $result[$campo];
	}
	// ===============================================================
	public function checkEmailCadastrado($id, $email) {
		$query = $this->system->sql->select('id', 'usuarios', "id != '" . $id . "' and email = '" . $email . "' and excluido = 0");
		$result = end($this->system->sql->fetchrowset($query));
		if ($result['id'])
			return true;
		return false;
	}
	// ===============================================================
	public function getUsuariosByNivel($nivel) {
		$query = $this->system->sql->select('id, nome, email', 'usuarios', "nivel = '" . $nivel . "' and ativo = 1 and excluido = 0");
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	public function getUsuarioByEmail($email) {
		$query = $this->system->sql->select('*', 'usuarios', "excluido='0' and email = '" . $email . "'");
		$usuario = end($this->system->sql->fetchrowset($query));
		if ($usuario['id']) 
			return $usuario;
	}
	// ===============================================================
	public function getIDByEmail($email) {
		$query = $this->system->sql->select('id', 'usuarios', "email = '" . $email . "' and excluido = 0");
		$usuario = end($this->system->sql->fetchrowset($query));
		if ($usuario['id'])
			return $usuario['id'];
		else
			return 0;
	}
	// ===============================================================
	public function getUsuarioByIdMd5($idMD5) {
		$query = $this->system->sql->select('*', 'usuarios', "excluido='0' and id_md5 = '" . $idMD5 . "'");
		$usuario = end($this->system->sql->fetchrowset($query));
		if ($usuario['id']) 
			return $usuario;
	}
	// ===============================================================
	public function atualizarCampo($id, $campo) {
		$this->system->sql->update('usuarios', $campo, "id='" . $id . "'");
	}
}
// ===================================================================