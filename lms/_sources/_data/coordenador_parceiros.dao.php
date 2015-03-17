<?php
require_once(dirname(__FILE__).'/usuarios.dao.php');

// ===================================================================
class Coordenador_parceirosDAO extends UsuariosDAO{
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
        	'nivel'				=> 7,
            'avatar'        	=> 'avatar_padrao.jpg',
            'cadastro_por_id'   => $this->system->session->getItem('session_cod_usuario'),
        	'data_cadastro' 	=> date('Y-m-d H:i:s'),
        	'ativo'	        	=> $input['ativo']
        ));
		$id = $this->system->sql->nextid();
		
		$this->system->sql->insert('usuarios_dados', array(
			'usuario_id'	 		=> $id,
			'endereco'		 		=> trim($input['endereco']),
        	'complemento'	 		=> trim($input['complemento']),
        	'bairro'		 		=> trim($input['bairro']),
        	'cidade'		 		=> trim($input['cidade']),
        	'estado'		 		=> trim($input['estado']),
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

		$this->system->sql->update('usuarios_dados', array(
        	'endereco'		 		=> trim($input['endereco']),
        	'complemento'	 		=> trim($input['complemento']),
        	'bairro'		 		=> trim($input['bairro']),
        	'cidade'		 		=> trim($input['cidade']),
        	'estado'		 		=> trim($input['estado']),
        ),
		"usuario_id='" . $input['id'] . "'");
		
		if ($input['senha']) 
			$this->system->sql->update('usuarios', array('senha' => trim($input['senha'])), "id='" . $input['id'] . "'");
		
	}
	// ===============================================================
	public function getCoordenadorParceiros($palavra = '', $limit = '', $order = 'nome') {
		$query = $this->system->sql->select('*', 'usuarios', "excluido='0' and nivel = '7'" . ($palavra? " and nome like '%" . $palavra . "%'" : ''), $limit, $order);
		$parceiros = $this->system->sql->fetchrowset($query);
		return $parceiros;
	}
	// ===============================================================
	public function getCoordenadorParceiro($id, $dadosCompletos = false) {
		$parceiro = parent::getUsuario($id, $dadosCompletos);
        if ($parceiro['nivel'] != 7)
            return array();
        return $parceiro;
	}
}
// ===================================================================