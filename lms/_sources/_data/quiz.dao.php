<?php
// ===================================================================
class QuizDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('cursos_quizzes', array(
			'pergunta'				=> $input['pergunta'],
			'alternativa1'			=> $input['alternativa1'],
			'alternativa2'			=> $input['alternativa2'],
			'alternativa3'			=> $input['alternativa3'],
			'alternativa4'			=> $input['alternativa4'],
			'alternativa5'			=> $input['alternativa5'],
			'alternativa_correta' 	=> $input['alternativa_correta'],
			'curso_id'				=> $input['curso_id'],
			'usuario_id'			=> $this->system->session->getItem('session_cod_usuario'),
			'capitulo_id'			=> $input['capitulo_id'],
			'aula_id'				=> $input['aula_id'],
			'obrigatorio'			=> $input['obrigatorio'],
			'excluido'				=> 0
		));
	
		return $this->system->sql->nextid();
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('cursos_quizzes', array(
        	'pergunta'				=> $input['pergunta'],
			'alternativa1'			=> $input['alternativa1'],
			'alternativa2'			=> $input['alternativa2'],
			'alternativa3'			=> $input['alternativa3'],
			'alternativa4'			=> $input['alternativa4'],
			'alternativa5'			=> $input['alternativa5'],
			'alternativa_correta' 	=> $input['alternativa_correta'],
			'curso_id'				=> $input['curso_id'],
			'capitulo_id'			=> $input['capitulo_id'],
			'usuario_id'			=> $this->system->session->getItem('session_cod_usuario'),
			'aula_id'				=> $input['aula_id'],
			'obrigatorio'			=> $input['obrigatorio'],
        ),
		"id='" . $input['id'] . "'");

	}
	// ===============================================================
	public function deletar($id) {
		$this->system->sql->update('cursos_quizzes', array(
            'excluido' 	=> 1),
		"id='" . $id . "'");
	}
	// ===============================================================
	public function getQuizzes($curso_id) {
		$query = $this->system->sql->select('*', 'cursos_quizzes', "excluido='0' and curso_id = '" . $curso_id . "'");
		$quizzes = $this->system->sql->fetchrowset($query);
		foreach ($quizzes as $key => $quiz) {
			//Autor
			$query = $this->system->sql->select('nome', 'usuarios', "excluido='0' and id = '" . $quiz['usuario_id'] . "'");
			$usuario = $this->system->sql->fetchrowset($query);

			if ($usuario[0]['nome'])
				$quizzes[$key]['usuario'] = $usuario[0]['nome'];

		}
		return $quizzes;
	}
	// ===============================================================
	public function getQuizCondicao($condicao) {
		$query = $this->system->sql->select('*', 'cursos_quizzes', "excluido='0'" . $condicao);
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getQuiz($id) {
		$query = $this->system->sql->select('*', 'cursos_quizzes', "excluido='0' and id= '" . $id . "'");
		$quiz =  $this->system->sql->fetchrowset($query);
		return $quiz[0];
	}
	// ===============================================================
	public function getTotalQuiz($curso_id) {
		$query = $this->system->sql->select('COUNT(1)', 'cursos_quizzes', "excluido = 0 and curso_id = " . $curso_id);
		return $this->system->sql->querycountunit($query);
	}
}
// ===================================================================