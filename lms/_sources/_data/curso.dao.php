<?php
// ===================================================================
class CursoDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		
		$this->system->sql->insert('cursos', array(
			'curso'						=> $input['curso'],
			'tags'						=> $input['tags'],
			'gratuito'					=> intval($input['gratuito']),
			'valor'						=> $input['valor'],
			'dvd'						=> intval($input['dvd']),
			'certificado'				=> intval($input['certificado']),
			'suporte'					=> intval($input['suporte']),
			'home'						=> intval($input['home']),
			'destaque'					=> intval($input['destaque']),
			'destaque_arquivo'			=> '',
			'banner' 					=> intval($input['banner']),
			'banner_arquivo'			=> '',
			'frete'						=> intval($input['frete']),
			'valor_frete'				=> intval($input['valor_frete']),
			'servidor'					=> intval($input['servidor']),
			'descricao'					=> trim($input['descricao']),
			'tecnica'					=> trim($input['tecnica']),
			'requisito'					=> trim($input['requisito']),
			'publico'					=> trim($input['publico']),
			'perfil'					=> trim($input['perfil']),
			'professor_id'				=> intval($input['professor_id']),
			'professor_substituto_id'	=> intval($input['professor_substituto_id']),
			'qt_capitulos'				=> intval($input['qt_capitulos']),
			'carga_horaria'				=> intval($input['carga_horaria']),
			'data_cadastro'				=> date('Y-m-d'),
			'data_cadastro_professor'	=> date('Y-m-d'), //serve para o professor ver a vendas apartir do momento que ele foi cadastrado
			'url'						=> $input['url'],
			'usuario_id'				=> intval($this->system->session->getItem('session_cod_usuario')),
			'excluido'					=> 0,
			'review_curso'				=> trim($input['review_curso'])
		));
	
		$id = $this->system->sql->nextid();

		if ($input['categorias'])
			foreach($input['categorias'] as $categoria)
				$this->system->sql->insert('cursos_categorias', array('curso_id' => $id, 'categoria_id' => $categoria));	

		if ($input['cursos'])
			foreach($input['cursos'] as $curso)
				$this->system->sql->insert('cursos_relacionados', array('curso_principal_id' => $id, 'curso_relacionado_id' => $curso));	


        return $id;
	}
	// ===============================================================
	public function atualizar($input) {
		
		$query = $this->system->sql->select('professor_id', 'cursos', "excluido='0' and id = '" .  $input['id'] . "'");
		$professor = end($this->system->sql->fetchrowset($query));

		$this->system->sql->update('cursos', array(
        	'curso'						=> $input['curso'],
			'tags'						=> $input['tags'],
			'gratuito'					=> intval($input['gratuito']),
			'valor'						=> str_replace(',', '.', $input['valor']),
			'dvd'						=> intval($input['dvd']),
			'certificado'				=> intval($input['certificado']),
			'suporte'					=> intval($input['suporte']),
			'home'						=> intval($input['home']),
			'destaque'					=> intval($input['destaque']),			
			'banner' 					=> intval($input['banner']),
			'frete'						=> intval($input['frete']),
			'valor_frete'				=> intval($input['valor_frete']),
			'servidor'					=> intval($input['servidor']),
			'descricao'					=> trim($input['descricao']),
			'tecnica'					=> trim($input['tecnica']),
			'requisito'					=> trim($input['requisito']),
			'publico'					=> trim($input['publico']),
			'perfil'					=> trim($input['perfil']),
			'professor_id'				=> intval($input['professor_id']),
			'professor_substituto_id'	=> intval($input['professor_substituto_id']),
			'qt_capitulos'				=> intval($input['qt_capitulos']),
			'carga_horaria'				=> intval($input['carga_horaria']),
			'url'						=> $input['url'],
			'review_curso'				=> trim($input['review_curso'])
        ),
		"id='" . $input['id'] . "'");

		if ($professor['professor_id'] != $input['professor_id']) {
			$this->system->sql->update('cursos', array(
	        	'data_cadastro_professor'	=> date('Y-m-d'), //serve para o professor ver a vendas apartir do momento que ele foi cadastrado
	        ),
			"id='" . $input['id'] . "'");			
		}

		if (count($input['categorias'])) {
			$this->system->sql->delete('cursos_categorias', "curso_id='" . $input['id'] . "'");
			foreach($input['categorias'] as $categoria)
				$this->system->sql->insert('cursos_categorias', array('curso_id' => $input['id'], 'categoria_id' => $categoria));	
		}

		if (count($input['cursos'])) {
			$this->system->sql->delete('cursos_relacionados', "curso_principal_id='" . $input['id'] . "'");
			foreach($input['cursos'] as $curso)
				$this->system->sql->insert('cursos_relacionados', array('curso_principal_id' => $input['id'], 'curso_relacionado_id' => $curso));	
		}
	}
	// ===============================================================
	public function atualizarImagemDestaque($id, $imagem) {
		$this->system->sql->update('cursos', array('destaque_arquivo' => $imagem), "id='" . $id . "'");
	}
	// ===============================================================
	public function atualizarImagemBanner($id, $imagem) {
		$this->system->sql->update('cursos', array('banner_arquivo' => $imagem), "id='" . $id . "'");
	}
	// ===============================================================
	public function deletar($id) {
	 	$this->system->sql->update('cursos', array(
             'excluido' 	=> 1),
	 	"id='" . $id . "'");
	}
	// ===============================================================
	public function getCursos($palavra = '', $limit = '', $order = 'curso', $campos = '*') {
		$query = $this->system->sql->select($campos, 'cursos', "excluido='0'" . ($palavra != ''? " and curso like '%" . $palavra.  "%'" : ''), $limit, $order);
		$cursos = $this->system->sql->fetchrowset($query);
		return $cursos;
	}
	// ===============================================================
	public function getCursosCondicao($where, $limit = '', $order = 'curso', $campos = '*') {
		$query = $this->system->sql->select($campos, 'cursos', "excluido='0' " . $where, $limit, $order);
		$cursos = $this->system->sql->fetchrowset($query);
		return $cursos;
	}
	// ==============================================================
	public function getCursoCondicao($where, $order = 'curso', $campos = '*') {
		return end($this->getCursosCondicao($where, 1, $order, $campos));
	}
	// ===============================================================
	public function getCategoriasByCurso($id, $pai = false) {
		$query = $this->system->sql->select('categoria_id', 'cursos_categorias', "curso_id='" . $id . "'");
		$categorias =  $this->system->sql->fetchrowset($query);
		foreach ($categorias as $key => $categoria) {
			$query = $this->system->sql->select('*', 'categorias', "id='" . $categoria['categoria_id'] . "'" . ($pai ? ' and categoria_pai_id = 0' : ''));
			$categorias[$key] =  end($this->system->sql->fetchrowset($query));
		}
		return $categorias;
	}
	// ===============================================================
	public function getCategoriaCarreiraByCurso ($id) {
		$query = $this->system->sql->select('count(1) carreira', 'cursos_categorias', "curso_id='" . $id . "' and categoria_id = 19");
		$categoriaCarreira =  end($this->system->sql->fetchrowset($query));
		return $categoriaCarreira;
	}
	// ===============================================================
	public function getCurso($id, $todos_dados = true) {
		$query = $this->system->sql->select('*', 'cursos', "excluido='0' and id= '" . $id . "'", '', 'curso');
		$curso =  $this->system->sql->fetchrowset($query);
		if ($curso[0]['id'] && $todos_dados) {
			$curso = $curso[0];
			//Categorias
			$query = $this->system->sql->select('id', 'categorias', "excluido='0' AND id IN (SELECT categoria_id FROM cursos_categorias WHERE curso_id = '" . $id .  "' )");
			$categorias =  $this->system->sql->fetchrowset($query);
			foreach ($categorias as $categoria)
				$curso['categorias'][] = $categoria['id'];
				
			//Cursos
			$query = $this->system->sql->select('id', 'cursos', "excluido='0' AND id IN (SELECT curso_relacionado_id FROM cursos_relacionados WHERE curso_principal_id = '" . $id .  "' )");
			$cursos =  $this->system->sql->fetchrowset($query);
			foreach ($cursos as $cursoRelacionado)
				$curso['cursos'][] = $cursoRelacionado['id'];

			//Professor
			$query = $this->system->sql->select('id, nome, email', 'usuarios', "excluido='0' AND id = '" . $curso['professor_id'] .  "'");
			$professor =  end($this->system->sql->fetchrowset($query));
			$curso['professor'] = $professor;

		}
		return $curso;
	}
	// ==============================================================
	public function getCursosRelacionados($curso_id, $home = false) { 
		$query = $this->system->sql->select('*', 'cursos', "excluido='0' AND id IN (SELECT curso_relacionado_id FROM cursos_relacionados WHERE curso_principal_id = '" . $curso_id .  "' )" . ($home? ' and home = 1' : ''));
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	public function getCapitulos($curso_id) {
		$query = $this->system->sql->select('qt_capitulos', 'cursos', "excluido='0' and id= '" . $curso_id . "'", '', 'curso');
		$curso =  end($this->system->sql->fetchrowset($query));

		if ($curso['qt_capitulos']) {
			$query = $this->system->sql->select('capitulo_id', 'cursos_capitulos', "excluido='0' and curso_id= '" . $curso_id . "'", $curso['qt_capitulos'], 'capitulo_id');
			$capitulos = $this->system->sql->fetchrowset($query);
			foreach ($capitulos as $key=> $capitulo)
				$capitulos[$key] = $capitulo['capitulo_id'];
			return $capitulos;
		}
		return array();
	}
	// ===============================================================
	public function cadastrarCapitulos($curso_id, $qt_capitulos) {
		//Cadastra
		$query = $this->system->sql->select('count(1) as total', 'cursos_capitulos', "excluido='0' and curso_id= '" . $curso_id . "'");
		$total =  end($this->system->sql->fetchrowset($query));
		$falta = max(0, ($qt_capitulos - $total['total']));

		for ($i = 1; $i <= $falta; $i++) {
			$this->system->sql->insert('cursos_capitulos', array(
				'curso_id'	=> $curso_id,
				'descricao'	=> '',
				'capitulo'	=> ($total['total'] + $i)	
			));	
		}

		//Deleta
		$query = $this->system->sql->select('count(1) as qt_capitulos', 'cursos_capitulos', "excluido='0' and curso_id= '" . $curso_id . "'");
		$curso = end($this->system->sql->fetchrowset($query));
		
		if ($qt_capitulos < $curso['qt_capitulos']) {
			$query = $this->system->sql->select('capitulo_id ', 'cursos_capitulos', "curso_id = '" . $curso_id . "' AND excluido = 0 AND capitulo_id NOT IN (SELECT capitulo_id FROM cursos_aulas WHERE curso_id = '" . $curso_id . "' AND excluido = 0)");
			$capitulos =  $this->system->sql->fetchrowset($query);

			$total = $curso['qt_capitulos'] - $qt_capitulos;
			
			foreach ($capitulos as $key => $capitulo) {
				$this->system->sql->update('cursos_capitulos', array('excluido' => 1),	"capitulo_id='" . $capitulo['capitulo_id'] . "'");
				if (($key+1) == $total) 
					break;
			}

			//ordenar
			$ordem = 1;
			$query = $this->system->sql->select('capitulo_id', 'cursos_capitulos', "excluido='0' and curso_id= '" . $curso_id . "'", '', 'capitulo');
			$capitulos2 = $this->system->sql->fetchrowset($query);
			
			foreach ($capitulos2 as $capitulo) {
				$this->system->sql->update('cursos_capitulos', array('capitulo' => $ordem),	"capitulo_id='" . $capitulo['capitulo_id'] . "'");
				$ordem++;
			}
		}
		
		return true;
	}
	// ===============================================================
	public function getTotalAlunos($curso_id) {
		$query = $this->system->sql->select('count(1) as total', 'cursos_alunos', "excluido='0' and curso_id= '" . $curso_id . "'");
		$total =  end($this->system->sql->fetchrowset($query));
		return $total;
	}

	// ===============================================================
	public function validarMudancaCapitulos($curso_id, $qt_capitulos) {
		$query = $this->system->sql->select('qt_capitulos', 'cursos', "excluido='0' and id= '" . $curso_id . "'", '', 'curso');
		$curso =  end($this->system->sql->fetchrowset($query));

		if ($qt_capitulos < $curso['qt_capitulos']) {
			$query = $this->system->sql->select('COUNT(DISTINCT capitulo_id) AS total ', 'cursos_aulas', "curso_id = '" . $curso_id . "' AND excluido = 0 AND capitulo_id IN (SELECT capitulo_id FROM `cursos_capitulos` WHERE curso_id = '" . $curso_id . "' AND excluido = 0)");
			$capitulos =  end($this->system->sql->fetchrowset($query)); 
			if ($qt_capitulos < $capitulos['total'])
				return false;
		}
		return true;
	}
	// ===============================================================
	public function atualizarDescricaoCapitulo($capitulo_id, $descricao) {
		$this->system->sql->update('cursos_capitulos', array('descricao' => $descricao), "capitulo_id='" . $capitulo_id . "'");
	}
	// ==============================================================
	public function getCapitulo($capitulo_id) {
		$query = $this->system->sql->select('*', 'cursos_capitulos', "excluido='0' and capitulo_id = '" . $capitulo_id . "'");
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getCursosByAluno($usuario_id, $palavra = '', $limit = '') {
		$cursos = array();
		$query = $this->system->sql->select('*', 'cursos_alunos', "excluido='0' and expira >= '" . date('Y-m-d') . "'  and usuario_id= '" . $usuario_id . "' " . ($palavra? "and curso_id in (SELECT id from cursos where curso like '%" . $palavra . "%' )" : ''), $limit, 'curso_id desc');
		$resultado = $this->system->sql->fetchrowset($query);

		foreach ($resultado as $valor) {
			
			$query = $this->system->sql->select('curso, qt_capitulos, professor_id, destaque_arquivo, certificado as curso_certificado ', 'cursos', "excluido='0' and id= '" . $valor['curso_id'] . "'");
			$curso =  end($this->system->sql->fetchrowset($query));
			if ($curso['curso']) {
				//aulas assistidas
				$query = $this->system->sql->select('count(aula_id) as aulas_assistidas', 'cursos_alunos_aulas', "aluno_id = '" .  $usuario_id. "' and rel_curso_id = '" .  $valor['id'] . "' and concluida=1");
				$resultado = end($this->system->sql->fetchrowset($query));
				$curso['aulas_assistidas'] = $resultado['aulas_assistidas'];
				
				//total aulas
				$query = $this->system->sql->select('count(aula_id) as aulas_total', 'cursos_aulas', "excluido = '0' and curso_id = '" .  $valor['curso_id'] . "'");
				$resultado = end($this->system->sql->fetchrowset($query));
				$curso['aulas_total'] = $resultado['aulas_total'];

				$curso = array_merge($curso, $valor);
				$cursos[] = $curso;
			}
		}
		
		return $cursos;
	}
	// ==============================================================
	public function checarCursoAtivo($relacionamento, $usuario_id) {
		$query = $this->system->sql->select('id', 'cursos_alunos', "excluido='0' and expira >= '" . date('Y-m-d') . "' and usuario_id = '" . $usuario_id . "' and id = '" . $relacionamento . "'", 1);
		$resultado = end($this->system->sql->fetchrowset($query));
		if ($resultado['id'])
			return true;
		return false;
	}
	// ==============================================================
	public function getCursosAlunos($campos = '', $limit = '', $orderby = 'curso_id desc', $excluido = true) {
		$query = $this->system->sql->select('*', 'cursos_alunos', ($excluido ? "excluido='0' and expira >= '" . date('Y-m-d') . "'" : "1=1") . $campos, $limit, $orderby);

		return $this->system->sql->fetchrowset($query);
	}
	// ==============================================================
	public function atualizarCursoAluno($campos, $relacionamentoId) {
		$this->system->sql->update('cursos_alunos', $campos, "id='" . $relacionamentoId . "'");
	}
	// ==============================================================
	public function countAlunosAtivosPorCurso($limit = '') {
		$query = $this->system->sql->select('curso_id, count(usuario_id) as total', 'cursos_alunos', "excluido='0' GROUP BY curso_id", $limit, 'count(usuario_id) desc');
		$cursos = $this->system->sql->fetchrowset($query);
		foreach ($cursos as $key => $curso) {
			$query = $this->system->sql->select('curso', 'cursos', "excluido='0' and id = '" . $curso['curso_id'] . "'");
			$resultado = end($this->system->sql->fetchrowset($query));
			
			if ($resultado['curso'])
				$cursos[$key]['curso'] = $resultado['curso'];
		}
		return $cursos;
	}
	//===============================================================
	public function cadastrarCursoAluno($curso, $usuario_id, $expiracao) {
		$this->system->sql->insert('cursos_alunos', array('usuario_id' => $usuario_id, 'curso_id' => $curso['id'], 'expira' => $expiracao, 'certificado_emitido' => 0, 'suporte' => $curso['suporte'], 'certificado' => $curso['certificado'], 'excluido' => 0));
		return $this->system->sql->nextid();
	}
	//===============================================================
	public function cadastrarCursosAluno($cursos, $usuario_id, $expiracao) {
		foreach($cursos as $curso)
			$this->cadastrarCursoAluno($curso, $usuario_id, $expiracao);
		return true;
	}
	// ==============================================================
	public function deleteCursoAluno($id) {
		$this->system->sql->update('cursos_alunos', array(
             'excluido' 	=> 1),
	 	"id='" . $id . "'");
	}
	//===============================================================
	public function salvarServidor($curso_id, $servidor) {
		$this->system->sql->update('cursos', array('servidor' => $servidor), "id='" . $curso_id . "'");
	}
	// ==============================================================
	public function alunosByCurso($curso) {
		$query = $this->system->sql->select('u.id, u.nome, u.email', 'cursos_alunos AS c, usuarios AS u', "c.expira > '" . date('Y-m-d') ."' AND c.excluido = 0 AND c.curso_id = '" . $curso . "' AND u.excluido = 0 AND u.id = c.usuario_id");
		return $this->system->sql->fetchrowset($query);	
	}
	// ==============================================================
	public function getCursosByCategorias($categorias = array(0), $limit = '', $orderby = 'data_cadastro desc') {
		$query = $this->system->sql->select('DISTINCT c.id, c.curso, c.valor, c.destaque_arquivo, c.gratuito, c.url', 'cursos as c, cursos_categorias as ca', "c.excluido = 0 and ca.categoria_id IN (" . implode(',', $categorias) . ")  and c.home = 1 and ca.curso_id = c.id", $limit, $orderby);
		return $this->system->sql->fetchrowset($query);	
	}
	// ==============================================================
	public function getMaisAcessadosCursosByCategorias($categorias = array(0), $limit = '') {
		$query = $this->system->sql->select('DISTINCT c.id, c.curso, c.valor, c.destaque_arquivo, c.gratuito, c.url', 'cursos as c, cursos_categorias as ca, cursos_alunos as a', "c.excluido = 0 and a.curso_id = c.id and ca.categoria_id IN (" . implode(',', $categorias) . ") and ca.curso_id = c.id and c.home = 1 GROUP BY c.id", $limit, 'count(a.usuario_id) desc');
		return $this->system->sql->fetchrowset($query);			
	}
	// =============================================================
	public function primeiroAcessso($relacionamentoId) {

		$curso = end($this->system->sql->fetchrowset($this->system->sql->select('curso_id', 'cursos_alunos', 'id = ' . $relacionamentoId)));
		$capitulo = end($this->system->sql->fetchrowset($this->system->sql->select('capitulo_id', 'cursos_capitulos', 'curso_id = ' . $curso['curso_id'] . ' and excluido = 0 and capitulo = 1')));
		$aula = end($this->system->sql->fetchrowset($this->system->sql->select('aula_id', 'cursos_aulas', 'curso_id = ' . $curso['curso_id'] . ' and capitulo_id = ' . $capitulo['capitulo_id'] . ' and posicao = 1 and excluido = 0')));

		$query = $this->system->sql->select('count(1) as total', 'cursos_alunos_aulas', 'rel_curso_id = ' . $relacionamentoId . ' and aula_id = ' . intval($aula['aula_id']));
		$resultado = end($this->system->sql->fetchrowset($query));
		if ($resultado['total'])
			return false;
		return true;
	}
	// ============================================================
	public function atualizarCampos($id, $campos = array()) {
		if (count($campos) > 0) {
			$this->system->sql->update('cursos', $campos, "id='" . $id . "'");
		}
	}
	// ===========================================================
	public function getIdByUrl($url) { 
		$query = $this->system->sql->select('id', 'cursos', "excluido = 0 and url = '" . $url . "'");
		$resultado = end($this->system->sql->fetchrowset($query));
		return ($resultado['id'] ? $resultado['id'] : false);
	}
	// ===========================================================
	public function verificaCursoAtivo($usuario_id, $curso_id) {
		$query = $this->system->sql->select('id', 'cursos_alunos', "excluido = 0 and usuario_id = '" . $usuario_id . "' and curso_id = '" . $curso_id . "' and expira > '" . date('Y-m-d H:i:s') . "'");
		$resultado = end($this->system->sql->fetchrowset($query));

		return ($resultado['id'] ? true : false);
	}

}
// ===================================================================