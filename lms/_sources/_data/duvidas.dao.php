<?php
// ===================================================================
class DuvidasDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('duvidas', array(
			'aluno_id'		=> $this->system->session->getItem('session_cod_usuario'),
			'titulo'			=> $input['titulo'],
			'curso_id'			=> $input['curso_id'],
			'professor_id'		=> $input['professor_id'],
			'excluido_aluno'  => 0,
			'excluido_professor'=> 0
		));
		$duvida_id = $this->system->sql->nextid();

		$this->system->sql->insert('duvidas_comentarios', array(
			'duvida_id'			=> $duvida_id,
			'remetente_id'		=> $this->system->session->getItem('session_cod_usuario'),
			'destinatario_id'	=> $input['professor_id'],
			'comentario'		=> $input['comentario'],
			'lido'  			=> 0,
			'data'				=> date('Y-m-d H:i:s')
		));
	}
	// ===============================================================
	public function cadastrarResposta($campos) {
		$this->system->sql->insert('duvidas_comentarios', array(
			'duvida_id'			=> $campos['duvida_id'],
			'remetente_id'		=> $this->system->session->getItem('session_cod_usuario'),
			'destinatario_id'	=> $campos['destinatario_id'],
			'comentario'		=> $campos['comentario'],
			'lido'  			=> 0,
			'data'				=> date('Y-m-d H:i:s')
		));
	}
	// ===============================================================
	public function getNaoLidas($usuario_id, $exibirDuvidasFechadas = true) {

		$whereExtra = '';
		if ($exibirDuvidasFechadas == false) 
			$whereExtra = " AND duvida_id NOT IN (SELECT id FROM duvidas WHERE fechada = 1 AND (aluno_id = '" . $usuario_id . "' OR professor_id =  '" . $usuario_id . "'))";

		$duvidas = array();
		$query = $this->system->sql->select('data, remetente_id, duvida_id', 'duvidas_comentarios', "lido = 0 AND destinatario_id = '" . $usuario_id . "'" . $whereExtra, '10', 'data desc');
		$resultado =  $this->system->sql->fetchrowset($query);
		
		foreach ($resultado as $key => $duvida) {

				//Remetente
				$query = $this->system->sql->select('nome', 'usuarios', "id = '" . $duvida['remetente_id'] . "'");
				$remetente =  end($this->system->sql->fetchrowset($query));				

				if  ($remetente['nome']) {
					$horaAtual = time();
					$horaResposta = strtotime($duvida['data']);
					$diferencaHora = floor(($horaAtual - $horaResposta) / 3600); //Em horas

					$resultado[$key]['remetente'] = $remetente['nome'];
					$resultado[$key]['horas'] = $diferencaHora;
					$duvidas['resultado'][] = $resultado[$key];
				}
			
		}

		$query = $this->system->sql->select('count(1) as total', 'duvidas_comentarios', "lido = 0 AND destinatario_id = '" . $usuario_id . "'" . $whereExtra);
		$total =  $this->system->sql->fetchrowset($query);
		$duvidas['total'] = $total[0]['total'];
		
		return $duvidas;
	}
	// =================================================================
	public function getDuvidas($campos, $limit = '') {//usuario id e o campo professor

		$query = $this->system->sql->select('D.*', 'duvidas as D, duvidas_comentarios as C', 'D.id = C.duvida_id ' . $campos . ' GROUP BY D.id', $limit, 'C.data desc');
		$duvidas = $this->system->sql->fetchrowset($query);

		foreach($duvidas as $key => $duvida) {
			//aluno
			$query = $this->system->sql->select('id, nome, avatar', 'usuarios', "excluido = 0 and id = '" . $duvida['aluno_id'] . "'");
			$duvidas[$key]['aluno'] = end($this->system->sql->fetchrowset($query));

			//professor
			$query = $this->system->sql->select('id, nome, avatar', 'usuarios', "excluido = 0 and id = '" . $duvida['professor_id'] . "'");
			$duvidas[$key]['professor'] = end($this->system->sql->fetchrowset($query));

			//curso
			$query = $this->system->sql->select('curso', 'cursos', "excluido = 0 and id = '" . $duvida['curso_id'] . "'");
			$duvidas[$key]['curso'] = end($this->system->sql->fetchrowset($query));			

			//ultima msg
			$query = $this->system->sql->select('data, comentario, lido, remetente_id', 'duvidas_comentarios', "duvida_id = '" . $duvida['id'] . "'");
			$duvidas[$key]['mensagem'] = end($this->system->sql->fetchrowset($query));

		}
		$duvidas = $this->ordernarDuvidas($duvidas);

		return $duvidas;
	}
	// ==================================================================
	private function ordernarDuvidas($duvidas) {
		$retorno = array();

		foreach ($duvidas as $duvida) {
			if (empty($retorno))
				$retorno[] = $duvida;
			else {
				foreach ($retorno as $key => $duvidaSalva) {
					if ($duvidaSalva['mensagem']['data'] <= $duvida['mensagem']['data']) {

						//Primeira parte do array
						$aux = array();
						for ($i = 0; $i < $key; $i++) 
							$aux[] = $retorno[$i];

						//Insere após a primeira parte
						$aux[] = $duvida;

						//Segunda parte do array
						for ($i = $key; $i < count($retorno); $i++)
							$aux[] = $retorno[$i];

						$retorno = $aux;
						break;
					} elseif ($key+1 >= count($retorno)) {
						$retorno[] = $duvida;
					}
				}
			}

		}
		return $retorno;

	}
	// =================================================================
	public function getDuvida($campos) {
		$query = $this->system->sql->select('*', 'duvidas', $campos);
		$duvida = end($this->system->sql->fetchrowset($query));

		//aluno
		$query = $this->system->sql->select('id, nome, email, avatar', 'usuarios', "excluido = 0 and id = '" . $duvida['aluno_id'] . "'");
		$aluno = end($this->system->sql->fetchrowset($query));

		//professor
		$query = $this->system->sql->select('id, nome, email, avatar', 'usuarios', "excluido = 0 and id = '" . $duvida['professor_id'] . "'");
		$professor = end($this->system->sql->fetchrowset($query));

		//curso
		$query = $this->system->sql->select('id, curso', 'cursos', "excluido = 0 and id = '" . $duvida['curso_id'] . "'");
		$duvida['curso'] = end($this->system->sql->fetchrowset($query));

		//msgs
		$query = $this->system->sql->select('destinatario_id, remetente_id, comentario, data', 'duvidas_comentarios', "duvida_id = '" . $duvida['id'] . "'", '', 'data desc');
		$mensagens = $this->system->sql->fetchrowset($query);
		foreach ($mensagens as $key => $mensagem) {
			//remetente
			if ($mensagem['remetente_id'] == $aluno['id']){
				$mensagem['aluno'] = true;
				$mensagem['remetente'] = $aluno;
			}
			else {
				$mensagem['aluno'] = false;
				$mensagem['remetente'] = $professor;
			}

			//data
			$dia = date('d', strtotime($mensagem['data']));
			$mes = $this->system->arrays->getMes(date('m', strtotime($mensagem['data'])));
			$ano = date('Y', strtotime($mensagem['data']));
			$mensagem['data_formatada'] = $dia . ' de '  . $mes . ' de ' . $ano;

			$mensagens[$key] = $mensagem;

		}
		$duvida['mensagens'] = $mensagens;
		
		return $duvida;
	}
	// =================================================================
	public function lerDuvida($duvidaId, $usuarioId) {
		$this->system->sql->update('duvidas_comentarios', array('lido' => 1), "duvida_id = '" . $duvidaId . "' and destinatario_id = '" . $usuarioId .  "'");
	}
	// ================================================================
	public function excluir($duvidaId, $usuarioId, $aluno) {
		$condicao = "id = '" . $duvidaId ."'";
		if ($aluno) {
			$campo['excluido_aluno'] = 1;
			$condicao .= " and aluno_id = '" . $usuarioId . "'";
		} else {
			$campo['excluido_professor'] = 1;
			$condicao .= " and professor_id = '" . $usuarioId . "'";
		}

		$this->system->sql->update('duvidas', $campo, $condicao);
	}
	// ================================================================
	public function restaurar($duvidaId, $usuarioId, $aluno) {
		$condicao = "id = '" . $duvidaId ."'";
		if ($aluno) {
			$campo['excluido_aluno'] = 0;
			$condicao .= " and aluno_id = '" . $usuarioId . "'";
		} else {
			$campo['excluido_professor'] = 0;
			$condicao .= " and professor_id = '" . $usuarioId . "'";
		}
		$this->system->sql->update('duvidas', $campo, $condicao);
	}
	// =================================================================
	public function atualizar($duvidaId, $campos) {
		$this->system->sql->update('duvidas', $campos, "id = '" . $duvidaId . "'");	
	}
	// =================================================================
	public function countTotalDuvidas($campos = '') {
		$query = $this->system->sql->select('count(1) as total', 'duvidas', $campos);
		$resultado = end($this->system->sql->fetchrowset($query));
		return $resultado['total'];
	}
	// =================================================================
	public function countTotalRespondida($campos = '') {
		$query = $this->system->sql->select('count(1) as total', 'duvidas', 'fechada = 1 ' . $campos);
		$resultado = end($this->system->sql->fetchrowset($query));
		return $resultado['total'];
	}
	// ================================================================
	public function getNaoRespondidas($camposDuvida = '', $camposComentario = '') {
		$query = $this->system->sql->select('*', 'duvidas', 'fechada = 0 ' . $camposDuvida);
		$resultado = $this->system->sql->fetchrowset($query);
		$return = array();
		foreach ($resultado as $duvida) {
			// Não respondida
			$query = $this->system->sql->select('duvida_id, remetente_id', 'duvidas_comentarios', "duvida_id = '" . $duvida['id'] . "'", "1", "data desc");
			$resultado2 = end($this->system->sql->fetchrowset($query));
			
			if ($resultado2['remetente_id'] != $duvida['professor_id']) {
				//dentro do periodo indicado
				$query = $this->system->sql->select('duvida_id, data, comentario', 'duvidas_comentarios', "duvida_id = '" . $duvida['id'] . "'" .  $camposComentario, "1", "data desc");
				$resultado3 = end($this->system->sql->fetchrowset($query));
				//print_r($resultado3);die;
				if ($resultado3['duvida_id']) {
					$duvida['comentario'] = $resultado3['comentario'];
					$return[] = $duvida;
				}
			}
		}
		
		return $return;
	}

}
// ===================================================================