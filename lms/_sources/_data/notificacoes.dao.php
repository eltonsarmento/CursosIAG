<?php
// ===================================================================
class NotificacoesDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('notificacoes', array(
        	'id_remetente'			=> $this->system->session->getItem('session_cod_usuario'),
        	'id_destinatario'		=> 0,
        	'destinatario_nivel'	=> $input['destinatario_nivel'],
        	'titulo'				=> trim($input['titulo']),
        	'conteudo'				=> trim($input['conteudo']),
        	'data_hora' 			=> date('Y-m-d H:i:s'),
        	'excluido'				=> 0
        ));
		$id = $this->system->sql->nextid();
		
		if ($input['destinatario_nivel'] == 4) {
			foreach($input['cursos'] as $curso)	{
				$this->system->sql->insert('notificacoes_cursos', array(
        			'notificacao_id'	=> $id,
        			'curso_id'			=> $curso,
        		));	
			}
		}
		
		return $id;
		
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('notificacoes', array(
        	'destinatario_nivel'	=> $input['destinatario_nivel'],
        	'titulo'				=> trim($input['titulo']),
        	'conteudo'				=> trim($input['conteudo']),
        ),
		"id='" . $input['id'] . "'");
		
		$this->system->sql->delete('notificacoes_cursos', "notificacao_id='" . $input['id'] . "'");

		if ($input['destinatario_nivel'] == 4) {
			foreach($input['cursos'] as $curso)	{
				$this->system->sql->insert('notificacoes_cursos', array(
        			'notificacao_id'	=> $input['id'],
        			'curso_id'			=> $curso,
        		));	
			}
		}
	}

	// ===============================================================
	public function getNaoLidas($id_usuario) {
		$notificacoes = array();

		//Montar Sql Extra e obter nivel usuario
		$query = $this->system->sql->select('id, nivel', 'usuarios', "excluido='0' and id = '" . $id_usuario . "' ");
		$usuario = end($this->system->sql->fetchrowset($query));

		//Se aluno
		$sql_extra = '';
		if ($usuario['nivel'] == 4) {

			$queryCursos = $this->system->sql->select('curso_id', 'cursos_alunos', "usuario_id = '" . $usuario['id'] . "' and excluido = 0 and expira >= '" . date('Y-m-d H:i:s') . "'");
			$resultadoCursos =  $this->system->sql->fetchrowset($queryCursos);
			$cursosID = array(0);
			foreach ($resultadoCursos as $resultadoCurso)
				$cursosID[] = $resultadoCurso['curso_id'];

			$sql_extra .= " AND ((id IN (SELECT notificacao_id FROM notificacoes_cursos WHERE curso_id IN (" . implode(',', $cursosID) . ")) AND destinatario_nivel = '4') OR id_destinatario = '" . $usuario['id'] . "')"; 
			
			//$sql_extra .= " AND ((id IN (SELECT notificacao_id FROM notificacoes_cursos WHERE curso_id = 0) AND destinatario_nivel = '4') OR id_destinatario = '" . $usuario['id'] . "')";
		} else 
			$sql_extra .= " AND (destinatario_nivel = '" . $usuario['nivel'] . "' OR id_destinatario = '" . $id_usuario . "')";


		//Não lida
		$sql_extra .= " AND id NOT IN (SELECT notificacao_id from notificacoes_lidas WHERE usuario_id = '" . $usuario['id'] . "')";

		//echo $sql_extra;die;

		//Verificar se é não lida
		$query = $this->system->sql->select('*', 'notificacoes', "excluido='0' " . $sql_extra, '10', 'data_hora desc');
		$resultado =  $this->system->sql->fetchrowset($query);
		
		foreach ($resultado as $key => $notificacao) {
				
				$query = $this->system->sql->select('nome, avatar', 'usuarios', " id = '" . $notificacao['id_remetente'] . "'");
				$remetente =  $this->system->sql->fetchrowset($query);

				if  ($remetente[0]['nome']) {
					$resultado[$key]['remetente'] = $remetente[0]['nome'];
					$resultado[$key]['avatar'] = $remetente[0]['avatar'];
					$resultado[$key]['data'] = date('d/m/Y H:i', strtotime($resultado[$key]['data_hora']));
					$notificacoes['resultado'][] = $resultado[$key];
				}
			
		}
		$query = $this->system->sql->select('count(1) as total', 'notificacoes', "excluido='0' " . $sql_extra);
		$total =  $this->system->sql->fetchrowset($query);
		$notificacoes['total'] = $total[0]['total'];

		return $notificacoes;
	}
	// ===============================================================
	public function getNotificacoes($id_usuario) {
		$notificacoes = array();

		//Montar Sql Extra e obter nivel usuario
		$query = $this->system->sql->select('id, nivel', 'usuarios', "excluido='0' and id = '" . $id_usuario . "' ");
		$usuario = end($this->system->sql->fetchrowset($query));

		//Se aluno
		$sql_extra = '';
		if ($usuario['nivel'] == 4) {

			$queryCursos = $this->system->sql->select('curso_id', 'cursos_alunos', "usuario_id = '" . $usuario['id'] . "' and excluido = 0 and expira >= '" . date('Y-m-d H:i:s') . "'");
			$resultadoCursos =  $this->system->sql->fetchrowset($queryCursos);
			$cursosID = array(0);
			foreach ($resultadoCursos as $resultadoCurso)
				$cursosID[] = $resultadoCurso['curso_id'];

			$sql_extra .= " AND ((id IN (SELECT notificacao_id FROM notificacoes_cursos WHERE curso_id IN (" . implode(',', $cursosID) . ") OR curso_id = 0) AND destinatario_nivel = '4') OR id_destinatario = '" . $usuario['id'] . "')";
		}
		else 
			$sql_extra .= " AND (destinatario_nivel = '" . $usuario['nivel'] . "' OR id_destinatario = '" . $id_usuario . "')";

		//echo $sql_extra;die;

		$query = $this->system->sql->select('*', 'notificacoes', "excluido='0' " . $sql_extra, '', 'data_hora desc');
		$resultado =  $this->system->sql->fetchrowset($query);
		
		foreach ($resultado as $key => $notificacao) {
				$resultado[$key]['conteudo'] = utf8_encode(html_entity_decode($notificacao['conteudo']));

				$query = $this->system->sql->select('nome, avatar', 'usuarios', " id = '" . $notificacao['id_remetente'] . "'");
				$remetente =  $this->system->sql->fetchrowset($query);

				if  ($remetente[0]['nome']) {
					$resultado[$key]['remetente'] = $remetente[0]['nome'];
					$resultado[$key]['avatar'] = $remetente[0]['avatar'];
					$resultado[$key]['data'] = date('d/m/Y H:i', strtotime($resultado[$key]['data_hora']));


					//Lida
					$notificadoLida = end($this->system->sql->fetchrowset($this->system->sql->select('notificacao_id', 'notificacoes_lidas', " notificacao_id = '" . $notificacao['id'] . "' and usuario_id = '" . $id_usuario . "'")));

					$resultado[$key]['lida'] = ($notificadoLida['notificacao_id'] ? true: false);

					$notificacoes[] = $resultado[$key];
				}
			
		}

		return $notificacoes;
	}
	// ===============================================================
	public function getNotificacoesGeral($palavra = '', $limit = '') {
		
		$notificacoes = array();

		$query = $this->system->sql->select('*', 'notificacoes', "excluido='0' and id_destinatario = 0 	" . ($palavra != '' ? " and titulo like '%" . $palavra ."%'" : ''), $limit, 'data_hora desc');
		$notificacoes =  $this->system->sql->fetchrowset($query);
		
		foreach ($notificacoes as $key=>$notificacao) {
			//Destinarario
			switch ($notificacao['destinatario_nivel']) {
				case 2:
					$notificacoes[$key]['destinatario'] = 'Coordenadores';
					break;
				case 3:
					$notificacoes[$key]['destinatario'] = 'Professores';
					break;
				case 4:
					$notificacoes[$key]['destinatario'] = 'Alunos';
					break;
				case 5:
					$notificacoes[$key]['destinatario'] = 'Parceiros';
					break;
				case 6:
					$notificacoes[$key]['destinatario'] = 'Administrativo';
					break;
			}

			//Cursos
			if ($notificacao['destinatario_nivel'] == 4) {
				//todos os cursos
				$query = $this->system->sql->select("curso_id", "notificacoes_cursos", "notificacao_id = '" . $notificacao['id'] . "'");
				$cursos = $this->system->sql->fetchrowset($query);
				foreach ($cursos as $key2 => $curso) {
					$cursos[$key2] = $curso['curso_id'];
				}

				//Exibe a opção todos os cursos
				if (in_array(0, $cursos)) 
					$notificacoes[$key]['cursos'][] = 'Todos os cursos';

				$query = $this->system->sql->select('curso', 'cursos', "excluido='0' and id IN (SELECT curso_id FROM notificacoes_cursos where notificacao_id = '" . $notificacao['id'] . "')");
				$cursos = $this->system->sql->fetchrowset($query);

				foreach ($cursos as $curso) 
					$notificacoes[$key]['cursos'][] = $curso['curso'];
				
			} else {
				$notificacoes[$key]['cursos'] = array();
			}
		}

		//print_r($notificacoes);die;
		return $notificacoes;
	}

	// ===============================================================
	public function getNotificacao($id) {
		$query = $this->system->sql->select('*', 'notificacoes', "excluido='0' and id = '" . $id . "' ");
		$notificacao = end($this->system->sql->fetchrowset($query));
		if ($notificacao['id']) {
			$notificacao['cursos'] = array();

			$query = $this->system->sql->select('curso_id', 'notificacoes_cursos', " notificacao_id = '" . $notificacao['id'] . "' ");
			$cursos = $this->system->sql->fetchrowset($query);
			foreach ($cursos as $curso) {
				$notificacao['cursos'][]  = $curso['curso_id'];
			}
		}
		
		return $notificacao;
	}
	// ===============================================================
	public function lerNotificacao($id) {
		$id_usuario = $this->system->session->getItem('session_cod_usuario');
		$notificacoes = array();

		//Montar Sql Extra e obter nivel usuario
		$query = $this->system->sql->select('id, nivel', 'usuarios', "excluido='0' and id = '" . $id_usuario . "' ");
		$usuario = end($this->system->sql->fetchrowset($query));

		//Se aluno
		$sql_extra = '';
		if ($usuario['nivel'] == 4) 
			$sql_extra .= " AND ((id IN (SELECT notificacao_id FROM notificacoes_cursos WHERE curso_id IN (SELECT curso_id FROM cursos_alunos WHERE usuario_id = '" . $usuario['id'] . "' and excluido = 0 and expira >= '" . date('Y-m-d H:i:s') . "') OR curso_id = 0) AND destinatario_nivel = '4') OR id_destinatario = '" . $usuario['id'] . "')";
		else 
			$sql_extra .= " AND (destinatario_nivel = '" . $usuario['nivel'] . "' OR id_destinatario = '" . $id_usuario . "')";

		$query = $this->system->sql->select('*', 'notificacoes', "excluido='0' and id = '" . $id . "' " . $sql_extra, '', 'data_hora desc');
		$notificacao =  end($this->system->sql->fetchrowset($query));
		
		
		$notificacao['conteudo'] = html_entity_decode($notificacao['conteudo']);

		$query = $this->system->sql->select('nome, avatar', 'usuarios', " id = '" . $notificacao['id_remetente'] . "'");
		$remetente =  $this->system->sql->fetchrowset($query);

		if  ($remetente[0]['nome']) {
			$notificacao['remetente'] = $remetente[0]['nome'];
			$notificacao['avatar'] = $remetente[0]['avatar'];
			$notificacao['data'] = date('d/m/Y H:i', strtotime($resultado[$key]['data_hora']));
		}

		return $notificacao;
	}
	// ===============================================================
	public function deletar($id) {
	 	$this->system->sql->update('notificacoes', array(
             'excluido' 	=> 1),
	 	"id='" . $id . "'");
	}
	// ===============================================================
	public function marcarLida($notificacao) {
		$usuarioID = $this->system->session->getItem('session_cod_usuario');
		$query = $this->system->sql->select("count(1) as total", "notificacoes_lidas", "notificacao_id = '" . $notificacao . "' AND usuario_id =  '" . $usuarioID . "'");
		$total = end($this->system->sql->fetchrowset($query));
		
		if ($total['total'] == 0) {
			$this->system->sql->insert('notificacoes_lidas', array(
	        	'notificacao_id'	=> $notificacao,
	        	'usuario_id'		=> $usuarioID
	        ));
        }
		
	}
	// ===============================================================
	public function getUltimaNotificacao($id_usuario) {
		$query = $this->system->sql->select('id, nivel', 'usuarios', "excluido='0' and id = '" . $id_usuario . "' ");
		$usuario = end($this->system->sql->fetchrowset($query));


		$sql_extra = '';
		if ($usuario['nivel'] == 4) {
			
			$queryCursos = $this->system->sql->select('curso_id', 'cursos_alunos', "usuario_id = '" . $usuario['id'] . "' and excluido = 0 and expira >= '" . date('Y-m-d H:i:s') . "'");
			$resultadoCursos =  $this->system->sql->fetchrowset($queryCursos);
			$cursosID = array(0);
			foreach ($resultadoCursos as $resultadoCurso)
				$cursosID[] = $resultadoCurso['curso_id'];

			$sql_extra .= " AND ((id IN (SELECT notificacao_id FROM notificacoes_cursos WHERE curso_id IN (" . implode(',', $cursosID) . ")) AND destinatario_nivel = '4') OR id_destinatario = '" . $usuario['id'] . "')"; 

			//$sql_extra .= " AND ((id IN (SELECT notificacao_id FROM notificacoes_cursos WHERE curso_id = 0) AND destinatario_nivel = '4') OR id_destinatario = '" . $usuario['id'] . "')";
		} else 
			$sql_extra .= " AND (destinatario_nivel = '" . $usuario['nivel'] . "' OR id_destinatario = '" . $id_usuario . "')";

		$query = $this->system->sql->select('*', 'notificacoes', "excluido='0' " . $sql_extra, '1', 'data_hora desc');
		return  end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function notificacaoEmail($usuarioID, $titulo, $conteudo) {
		$this->system->sql->insert('notificacoes', array(
        	'id_remetente'			=> 2, //Conta do Adriano Gianini
        	'id_destinatario'		=> $usuarioID,
        	'titulo'				=> trim($titulo),
        	'conteudo'				=> trim($conteudo),
        	'data_hora' 			=> date('Y-m-d H:i:s'),
        	'excluido'				=> 0
        ));
		return $this->system->sql->nextid();
	}
}
// ===================================================================