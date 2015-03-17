<?php
require_once(dirname(__FILE__).'/usuarios.dao.php');

// ===================================================================
class AlunosDAO extends UsuariosDAO{
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
        	'nivel'			    => 4,
        	'data_cadastro'     => date('Y-m-d H:i:s'),
            'cadastro_por_id'   => intval($this->system->session->getItem('session_cod_usuario')),
            'avatar'            => 'avatar_padrao.jpg',
        	'ativo'	            => 1,
        ));

		$id = $this->system->sql->nextid();

		$this->system->sql->insert('usuarios_dados', array(
			'usuario_id'	 => $id,
        	'cep'			 => trim($input['cep']),
        	'cpf'			 => trim($input['cpf']),
        	'endereco'		 => trim($input['endereco']),
        	'complemento'	 => trim($input['complemento']),
        	'bairro'		 => trim($input['bairro']),
        	'cidade'		 => trim($input['cidade']),
        	'estado'		 => trim($input['estado']),
        	'telefone'       => trim($input['telefone']),
        ));

        $this->system->sql->update('usuarios', array('id_md5' => md5($id)), "id='" . $id . "'");

        return $id;
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('usuarios', array(
        	'nome'	=> trim($input['nome']),
           	'email'	=> trim($input['email']),
        	'ativo'	=> (isset($input['ativo']) ? $input['ativo'] : 1) 
        ),
		"id='" . $input['id'] . "'");
		
		if ($input['senha']) 
			$this->system->sql->update('usuarios', array('senha' => trim($input['senha'])), "id='" . $input['id'] . "'");
		
		$this->system->sql->update('usuarios_dados', array(
        	'cep'           => trim($input['cep']),
            'cpf'            => trim($input['cpf']),
            'endereco'       => trim($input['endereco']),
            'complemento'    => trim($input['complemento']),
            'bairro'         => trim($input['bairro']),
            'cidade'         => trim($input['cidade']),
            'estado'         => trim($input['estado']),
            'telefone'       => trim($input['telefone'])
        ),
		"usuario_id='" . $input['id'] . "'");
	}
	// ===============================================================
	public function getAlunos($palavra = '', $metodo_busca = '', $limit = '', $order = 'nome') {
		$sql_extra = '';
        if ($palavra != '') {

            //email
            if ($metodo_busca == 'email') 
                $sql_extra .= " and email like '%" . $palavra . "%'";
            
            //cpf
            if ($metodo_busca == 'cpf')  
                $sql_extra .= " and id in (SELECT usuario_id FROM usuarios_dados WHERE cpf = '" . $palavra . "')";   
            
            //padrao
            if ($metodo_busca == 'padrao') 
                $sql_extra .= " and (nome like '%" . $palavra . "%' OR email like '%" . $palavra . "%')";
            
        }
        
        //Parceiro
        if ($this->system->session->getItem('session_nivel') == 5) {
            $sql_extra .= " and cadastro_por_id = '" . $this->system->session->getItem('session_cod_usuario') . "'";
        }

		$query = $this->system->sql->select('*', 'usuarios', "excluido='0' and nivel = '4'" . $sql_extra, $limit, $order);
		$alunos = $this->system->sql->fetchrowset($query);

		return $alunos;
	}
    // ===============================================================
    public function getTotal($palavra = '', $metodo_busca = '') {
        $sql_extra = '';
        if ($palavra != '') {

            //email
            if ($metodo_busca == 'email') 
                $sql_extra .= " and email like '%" . $palavra . "%'";
            
            //cpf
            if ($metodo_busca == 'cpf')  
                $sql_extra .= " and id in (SELECT usuario_id FROM usuarios_dados WHERE cpf = '" . $palavra . "')";   
            
            //padrao
            if ($metodo_busca == 'padrao') 
                $sql_extra .= " and (nome like '%" . $palavra . "%' OR email like '%" . $palavra . "%')";
            
        }
        
        //Parceiro
        if ($this->system->session->getItem('session_nivel') == 5) {
            $sql_extra .= " and cadastro_por_id = '" . $this->system->session->getItem('session_cod_usuario') . "'";
        }

        $query = $this->system->sql->select('count(id) as total', 'usuarios', "excluido='0' and nivel = '4'" . $sql_extra);
        $resultado = end($this->system->sql->fetchrowset($query));
        return $resultado['total'];
    }
	// ===============================================================
	public function getAluno($id, $dadosCompletos = false) {
		$aluno = parent::getUsuario($id, $dadosCompletos);
        if ($aluno['nivel'] != 4)
            return array();
        return $aluno;
	}
    // ===============================================================
    public function getAlunosByCurso($curso_id) {
        $query = $this->system->sql->select('professor_id, professor_substituto_id', 'cursos', "excluido='0' and id = '" . $curso_id . "'");
        $curso = end($this->system->sql->fetchrowset($query));

        //Professores
        $query = $this->system->sql->select('id, nome', 'usuarios', "excluido='0' and id IN (" .implode(',', $curso) . ")");
        $professores = $this->system->sql->fetchrowset($query);
        
        return $professores;
    }
    // ===============================================================
    public function getCursos($usuario_id) {
         $query = $this->system->sql->select('c.*, ca.certificado_emitido ', 'cursos as c, cursos_alunos as ca', "c.id = ca.curso_id AND c.excluido='0' AND ca.excluido = 0 AND ca.usuario_id = '" . $usuario_id . "'");
         return $this->system->sql->fetchrowset($query);
    }
	// ===============================================================
	public function getCadastrosAlunos($campos) {
		return $this->system->sql->fetchrowset($this->system->sql->select('id, nome, data_cadastro', 'usuarios', "excluido=0 and nivel = 4 and ativo = 1" . $campos));
	}
	// ===============================================================
}
// ===================================================================