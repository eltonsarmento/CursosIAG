<?php
// ===================================================================
class AulasDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$query = $this->system->sql->select('posicao', 'cursos_aulas', "excluido='0' and capitulo_id= '" . $input['id'] . "' and curso_id = '" . $input['curso_id'] . "'", '1', 'posicao desc');
		$posicao =  end($this->system->sql->fetchrowset($query));

		if($posicao['posicao'])
			$posicao = $posicao['posicao']+1;
		else
			$posicao = 1;

		$this->system->sql->insert('cursos_aulas', array(
			'nome'			=> $input['nome'],
			'posicao'		=> $posicao,
			'capitulo_id'	=> intval($input['id']),
			'curso_id'		=> intval($input['curso_id']),
			'usuario_id'	=> intval($input['usuario_id']),
			'nome'			=> $input['nome'],
			'tipo'			=> intval($input['tipo']),
			'resumo'		=> $input['resumo'],
			'duracao'		=> $input['duracao'],
			'vimeo'			=> $input['vimeo'],
			'amazon'		=> $input['amazon'],
			'gratuito'		=> intval($input['gratuito']),
			'data_cadastro'	=> date('Y-m-d H:i:s'),
			'excluido'		=> 0
		));
		return $this->system->sql->nextid();
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('cursos_aulas', array(
        	'nome'			=> $input['nome'],
			'capitulo_id'	=> intval($input['id']),
			'curso_id'		=> intval($input['curso_id']),
			'usuario_id'	=> intval($input['usuario_id']),
			'nome'			=> $input['nome'],
			'tipo'			=> intval($input['tipo']),
			'resumo'		=> $input['resumo'],
			'duracao'		=> $input['duracao'],
			'vimeo'			=> $input['vimeo'],
			'amazon'		=> $input['amazon'],
			'gratuito'		=> intval($input['gratuito']),
        ),
		"aula_id='" . $input['aula_id'] . "'");
		return $input['aula_id'];
	}
	// ===============================================================
	public function getCapitulosByCurso($id) {
		$query = $this->system->sql->select('qt_capitulos', 'cursos', "excluido='0' and id= '" . $id . "'", '', 'curso');
		$curso =  end($this->system->sql->fetchrowset($query));
		if ($curso['qt_capitulos']) {
			$query = $this->system->sql->select('*', 'cursos_capitulos', "curso_id='" . $id . "' AND excluido=0", $curso['qt_capitulos'], 'capitulo ASC');
			$capitulos =  $this->system->sql->fetchrowset($query);
			foreach ($capitulos as $key => $capitulo) {
				$query = $this->system->sql->select('*', 'cursos_aulas', "capitulo_id='" . $capitulo['capitulo_id'] . "' AND curso_id='".$id."' AND excluido=0", '', 'posicao ASC');
				$aulas = $this->system->sql->fetchrowset($query);

				$capitulos[$key]['aulas'] = array();

				foreach ($aulas as $aula) {
					$aula['vimeo'] = base64_encode(urldecode($aula['vimeo']));	
					$aula['amazon'] = base64_encode(urldecode($aula['amazon']));
					$capitulos[$key]['aulas'][] = $aula;
				}
				
				
			}
		}
		return $capitulos;
	}
	// ===============================================================
	public function getAulasByCapitulo($id) {
		$query = $this->system->sql->select('*', 'cursos_aulas', "capitulo_id='" . $id . "' AND excluido=0", '', 'aula_id ASC');
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	public function getCursoIdByCapitulo($id) {
		$query = $this->system->sql->select('*', 'cursos_capitulos', "capitulo_id='" . $id . "' AND excluido=0");
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getCursoIdByAula($id) {
		$query = $this->system->sql->select('curso_id', 'cursos_aulas', "aula_id='" . $id . "' AND excluido=0");
		$resultado = end($this->system->sql->fetchrowset($query));
		if ($resultado['curso_id'])
			return $resultado['curso_id'];
		return false;
	}
	// ===============================================================
	public function deletar($id) {
		//Recupera dados da aula
		$aula = $this->getAula($id);
		
		//Deleta
		$this->system->sql->update('cursos_aulas', array('excluido' => 1), "aula_id='" . $id . "'");

		//Recupera aulas desse capitulo
		$aulas = $this->getAulasByCapitulo($aula['capitulo_id']);

		//Refaz as posições das aulas
		$posicao = 1;
		foreach($aulas as $aula) {
			$this->system->sql->update('cursos_aulas', array('posicao' => $posicao), "aula_id='" . $aula['aula_id'] . "'");		
			$posicao++;	
		}
	}
	// ===============================================================
	public function getAula($id) {
		$query = $this->system->sql->select('*', 'cursos_aulas', "aula_id= '" . $id . "'");
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getAulas($sql = '') {
		$query = $this->system->sql->select('*', 'cursos_aulas', "excluido=0" . $sql, '', 'aula_id ASC');
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	public function salvarPosicaoAulas($curso_id, $capitulos = array()) {
		
		foreach ($capitulos as $capitulo_id => $aulas) {
			if ($aulas) {
				foreach($aulas as $key => $aula) {
					$this->system->sql->update('cursos_aulas', array(
			        	'capitulo_id'		=> $capitulo_id,
						'posicao'			=> ($key+1)
			        ),
					"aula_id='" . $aula . "' and curso_id = '" . $curso_id . "'");
				}
			}	
		}		
	}
	// ===============================================================
	public function salvarPosicaoCapitulos($curso_id, $capitulos = array()) {
		foreach ($capitulos as $key => $capitulo) {
			$this->system->sql->update('cursos_capitulos', array(
				'capitulo'			=> ($key+1)
	        ),
			"capitulo_id='" . $capitulo . "' and curso_id = '" . $curso_id . "'");		
		}
	}
	// ================================================================
	public function getUltimaPosicao($capitulo_id) {
		$query = $this->system->sql->select('posicao', 'cursos_aulas', "capitulo_id = '" . $capitulo_id . "' AND excluido = 0", 1, 'posicao desc');
		$aula = end($this->system->sql->fetchrowset($query));
		return ($aula['posicao']+1);
	}
	
	// ================================================================
	public function getAulaGratuitaByCurso($curso_id) {
		$query = $this->system->sql->select('vimeo, amazon', 'cursos_aulas', "curso_id = '" . $curso_id . "' AND excluido = 0 AND gratuito = 1 AND (vimeo != '' OR  amazon != '')");
		$aulas = $this->system->sql->fetchrowset($query);
		//Escolha aula gratuita randomica
		$aula = $aulas[rand(0, (count($aulas) - 1))]; 

		//Buscando o servidor do curso
		$this->system->load->dao('curso');
		$curso = $this->system->curso->getCurso($curso_id);
		
		if ($curso['servidor'] == 1)//amazon
			$aula['video'] = $aula['amazon'];
		elseif ($curso['servidor'] == 2)
			$aula['video'] = $aula['vimeo'];
		else {
			$this->system->load->dao('configuracoesgerais');
			$servidor = $this->system->configuracoesgerais->getServidor();
			
			if ($servidor['servidor_padrao'] == 1) 	//amazon
				$aula['video'] = $aula['amazon'];
			else  									//vimeo
				$aula['video'] = $aula['vimeo'];	
		}


		if ($aula['video'])
			return base64_encode(urldecode($aula['video']));
		return false;
	}
	// ===============================================================
	public function obterAulasCompletadas($relacionamentoId) {
		$query = $this->system->sql->select('aula_id', 'cursos_alunos_aulas', 'concluida = 1 and rel_curso_id = ' . $relacionamentoId);
		$result = $this->system->sql->fetchrowset($query);
		$return = array();
		foreach($result as $value) {
			$return[] = $value['aula_id'];
		}
		return $return;
	}
	// ===============================================================
	public function obterAulaAtual($relacionamentoId) {
		$query = $this->system->sql->select('aula_id', 'cursos_alunos_aulas', 'concluida = 0 and rel_curso_id = ' . $relacionamentoId);
		$resultado = end($this->system->sql->fetchrowset($query));
		if ($resultado['aula_id'])
			return $resultado['aula_id'];
		return 0;
	}
	// ==============================================================
	public function countAulasAssistidas($relacionamentoId) {
		$query = $this->system->sql->select('count(aula_id) as total', 'cursos_alunos_aulas', "rel_curso_id = '" .  $relacionamentoId . "' and concluida=1");
		$resultado = end($this->system->sql->fetchrowset($query));
		return $resultado['total'];
	}
	// ==============================================================
	public function countAulasCurso($cursoId) {
		$query = $this->system->sql->select('count(aula_id) as total', 'cursos_aulas', "curso_id = '" .  $cursoId . "' and excluido=0");
		$resultado = end($this->system->sql->fetchrowset($query));
		return $resultado['total'];
	}
	// ===============================================================
	public function countQuizRespondido($relacionamentoId) {
		$query = $this->system->sql->select('count(aula_id) as total', 'cursos_alunos_aulas', "rel_curso_id = '" .  $relacionamentoId . "' and quiz_respondido=1");
		$resultado = end($this->system->sql->fetchrowset($query));
		return $resultado['total'];
	}
	// ===============================================================
	public function buscarProximaAula($cursoId, $aulaAtualId) {
		$aulas = $this->buscarAulasOrdem($cursoId);	
	
		//retorna aula
		if (count($aulas)) {
			if ($aulaAtualId == 0)
				return $aulas[0];
			$key = current(array_keys($aulas, $aulaAtualId));
			return $aulas[$key+1];
		}	
	}
	// ===============================================================
	public function buscarAulaAnterior($cursoId, $aulaAtualId) {
		$aulas = $this->buscarAulasOrdem($cursoId);	
	
		//retorna aula
		if (count($aulas)) {
			$key = current(array_keys($aulas, $aulaAtualId));
			if ($key == 0)
				return false;
			return $aulas[$key-1];
		}	
	}
	// ===============================================================
	private function buscarAulasOrdem($cursoId) {
		$query = $this->system->sql->select('qt_capitulos', 'cursos', "excluido='0' and id= '" . $cursoId . "'", '', 'curso');
		$curso =  end($this->system->sql->fetchrowset($query));
		$aulas = array();

		//obtem aulas
		if ($curso['qt_capitulos']) {
			$query = $this->system->sql->select('capitulo_id', 'cursos_capitulos', "curso_id='" . $cursoId . "' AND excluido=0", $curso['qt_capitulos'], 'capitulo ASC');
			$capitulos = $this->system->sql->fetchrowset($query);
			
			foreach ($capitulos as $capitulo) {
				$query = $this->system->sql->select('aula_id', 'cursos_aulas', "capitulo_id='" . $capitulo['capitulo_id'] . "' AND curso_id='".$cursoId."' AND excluido=0", '', 'posicao ASC');
				$aulasCapitulos = $this->system->sql->fetchrowset($query);
				
				foreach($aulasCapitulos as $aula)
					$aulas[] = $aula['aula_id'];
			}

		}
		return $aulas;
	}
	// ===============================================================
	public function liberarAula($aulaId, $relacionamentoId, $usuarioId) {
		$this->system->sql->insert('cursos_alunos_aulas', array(
			'aula_id'		=> $aulaId,
			'rel_curso_id'	=> $relacionamentoId,
			'aluno_id'		=> $usuarioId,
			'concluida'		=> 0
		));
	}
	// ===============================================================
	public function liberarAulaConcluida($aulaId, $relacionamentoId, $usuarioId) { //Criada apenas para scripts
		$this->system->sql->insert('cursos_alunos_aulas', array(
			'aula_id'		=> $aulaId,
			'rel_curso_id'	=> $relacionamentoId,
			'aluno_id'		=> $usuarioId,
			'concluida'		=> 1,
			'liberar_avancar'=> 1
		));
	}
	// ===============================================================
	public function checarAulaLiberada($aulaId, $relacionamentoId) {
		$query = $this->system->sql->select('count(aula_id) as total', 'cursos_alunos_aulas', "aula_id = '" .  $aulaId . "' and rel_curso_id= '" . $relacionamentoId . "'");
		$resultado = end($this->system->sql->fetchrowset($query));
		if ($resultado['total'])
			return true;
		return false;
	}
	// ===============================================================
	public function concluiAula($aulaId, $relacionamentoId) {
		$this->system->sql->update('cursos_alunos_aulas', array('concluida' => 1), "aula_id='" . $aulaId . "' and rel_curso_id = '" . $relacionamentoId . "'");
	}
	// ===============================================================
	public function quizRespondido($aulaId, $relacionamentoId) {
		$this->system->sql->update('cursos_alunos_aulas', array('quiz_respondido' => 1), "aula_id='" . $aulaId . "' and rel_curso_id = '" . $relacionamentoId . "'");
	}
	// ===============================================================
	public function getAulaAluno($aulaId, $relacionamentoId) {
		$query = $this->system->sql->select('*', 'cursos_alunos_aulas', "aula_id = '" .  $aulaId . "' and rel_curso_id= '" . $relacionamentoId . "'");
		return end($this->system->sql->fetchrowset($query));
	}
	// ==============================================================
	public function liberarAvancar($aulaId, $relacionamentoId) {
		$this->system->sql->update('cursos_alunos_aulas', array('liberar_avancar' => 1), "aula_id='" . $aulaId . "' and rel_curso_id = '" . $relacionamentoId . "'");
	}
}
// ===================================================================