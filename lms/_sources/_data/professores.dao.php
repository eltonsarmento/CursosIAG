<?php
require_once(dirname(__FILE__).'/usuarios.dao.php');

// ===================================================================
class ProfessoresDAO extends UsuariosDAO{
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('usuarios', array(
        	'nome'			    => trim($input['nome']),
        	'senha'			    => trim($input['senha']),
        	'email'			    => trim($input['email']),
        	'nivel'			    => 3,
            'avatar'            => 'avatar_padrao.jpg',
        	'data_cadastro'     => date('Y-m-d H:i:s'),
            'cadastro_por_id'   => $this->system->session->getItem('session_cod_usuario'),
        	'ativo'	            => $input['ativo'],
            'id_md5'            => ''
        ));
		$id = $this->system->sql->nextid();
		
		$this->system->sql->insert('usuarios_dados', array(
			'usuario_id'	 => $id,
        	'cep'			 => trim($input['cep']),
        	'cpf'			 => trim($input['cpf']),
        	'data_nascimento'=> $this->system->func->converteData($input['data_nascimento']),
        	'endereco'		 => trim($input['endereco']),
        	'complemento'	 => trim($input['complemento']),
        	'bairro'		 => trim($input['bairro']),
        	'cidade'		 => trim($input['cidade']),
        	'estado'		 => trim($input['estado']),
        	'agencia1'		 => trim($input['agencia1']),
        	'conta1'		 => trim($input['conta1']),
        	'banco1'		 => trim($input['banco1']),
			'tipoconta1'	 => trim($input['tipoconta1']),
			'operacao1'		 => trim($input['operacao1']),
        	'agencia2'		 => trim($input['agencia2']),
        	'conta2'		 => trim($input['conta2']),
        	'banco2'		 => trim($input['banco2']),
			'tipoconta2'	 => trim($input['tipoconta2']),
			'operacao2'		 => trim($input['operacao2']),
        	'minicurriculo'	 => trim($input['minicurriculo']),
            'comissao'       => intval($input['comissao']),
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
        	'cep'			 => trim($input['cep']),
        	'cpf'			 => trim($input['cpf']),
        	'data_nascimento'=> $this->system->func->converteData($input['data_nascimento']),
        	'endereco'		 => trim($input['endereco']),
        	'complemento'	 => trim($input['complemento']),
        	'bairro'		 => trim($input['bairro']),
        	'cidade'		 => trim($input['cidade']),
        	'estado'		 => trim($input['estado']),
        	'agencia1'		 => trim($input['agencia1']),
        	'conta1'		 => trim($input['conta1']),
        	'banco1'		 => trim($input['banco1']),
			'tipoconta1'	 => trim($input['tipoconta1']),
			'operacao1'		 => trim($input['operacao1']),
        	'agencia2'		 => trim($input['agencia2']),
        	'conta2'		 => trim($input['conta2']),
        	'banco2'		 => trim($input['banco2']),
			'tipoconta2'	 => trim($input['tipoconta2']),
			'operacao2'		 => trim($input['operacao2']),
        	'minicurriculo'	 => trim($input['minicurriculo']),
            'comissao'       => intval($input['comissao'])
        ),
		"usuario_id='" . $input['id'] . "'");
	}
	// ===============================================================
	public function getProfessores($palavra = '', $limit = '', $order = 'nome') {
		$query = $this->system->sql->select('*', 'usuarios', "excluido='0' and nivel = '3'" . ($palavra? " and nome like '%" . $palavra . "%'" : ''), $limit, $order);
		$professores =  $this->system->sql->fetchrowset($query);
		return $professores;
	}
	// ===============================================================
	public function getProfessor($id, $dadosCompletos = false) {
		$professor = parent::getUsuario($id, $dadosCompletos);
        if ($professor['nivel'] != 3)
            return array();
        return $professor;
	}
	// ===============================================================
	public function estaEnsinando($id) {
		$query = $this->system->sql->select('count(1) as total', 'cursos', "excluido='0' and (professor_id = '" . $id . "' or professor_substituto_id = '" . $id . "')");
		$resultado = end($this->system->sql->fetchrowset($query));
		if ($resultado['total'] > 0)
			return true;
		return false;
	}
    // ===============================================================
    public function countTotalCursos($id) {
        $query = $this->system->sql->select('count(1) as total', 'cursos', "excluido='0' and (professor_id = '" . $id . "' or professor_substituto_id = '" . $id . "')");
        $resultado = end($this->system->sql->fetchrowset($query));
        return $resultado['total'];
    }
    // ===============================================================
    public function getProfessoresByCurso($curso_id) {
        $query = $this->system->sql->select('professor_id, professor_substituto_id', 'cursos', "excluido='0' and id = '" . $curso_id . "'");
        $curso = end($this->system->sql->fetchrowset($query));
        //Professores
        $query = $this->system->sql->select('id, nome', 'usuarios', "excluido='0' and id IN (" .implode(',', $curso) . ")");
        $professores = $this->system->sql->fetchrowset($query);
        return $professores;
    }
}
// ===================================================================