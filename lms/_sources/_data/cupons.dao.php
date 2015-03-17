<?php
// ===================================================================
class CuponsDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('cupons', array(
        	'usuario_id'	=> $this->system->session->getItem('session_cod_usuario'),
        	'nome'			=> trim($input['nome']),
        	'tipo'			=> trim($input['tipo']),
			'tempo_de'		=> trim($this->system->func->converteData($input['tempo_de'])),
			'tempo_ate'		=> trim($this->system->func->converteData($input['tempo_ate'])),
			'quantidade'	=> trim($input['quantidade']),
			'tipo_desconto' => (int)$input['tipo_desconto'],
			'ativo'			=> (int)$input['ativo'],
			'valor'			=> trim(number_format($input['valor'], 2, '.', ',')),
			'data_cadastro' => date('Y-m-d H:i:s'),
			'excluido'		=> 0
        ));
		$id = $this->system->sql->nextid();


		if (count($input['cursos_ativos'])) {
			foreach ($input['cursos_ativos'] as $cursoAtivo)
				$this->system->sql->insert('cupom_cursos_ativos', array(
					'cupom_id'	=> $id,
					'curso_id'	=> $cursoAtivo
				));
		}

		if (count($input['cursos_excluidos'])) {
			foreach ($input['cursos_excluidos'] as $cursoExcluido)
				$this->system->sql->insert('cupom_cursos_excluidos', array(
					'cupom_id'	=> $id,
					'curso_id'	=> $cursoExcluido
				));
		}

		return ;
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('cupons', array(
        	'nome'			=> trim($input['nome']),
        	'tipo'			=> trim($input['tipo']),
			'tempo_de'		=> trim($this->system->func->converteData($input['tempo_de'])),
			'tempo_ate'		=> trim($this->system->func->converteData($input['tempo_ate'])),
			'quantidade'	=> trim($input['quantidade']),
			'tipo_desconto' => (int)$input['tipo_desconto'],
			'ativo'			=> (int)$input['ativo'],
			'valor'			=> trim(number_format($input['valor'], 2, '.', ',')),
        ),
		"id='" . (int)$input['id'] . "'");



		$this->system->sql->delete('cupom_cursos_ativos', "cupom_id='" . intval($input['id']) . "'");
		$this->system->sql->delete('cupom_cursos_excluidos', "cupom_id='" . intval($input['id']) . "'");

		if (count($input['cursos_ativos'])) {
			foreach ($input['cursos_ativos'] as $cursoAtivo)
				$this->system->sql->insert('cupom_cursos_ativos', array(
					'cupom_id'	=> intval($input['id']),
					'curso_id'	=> $cursoAtivo
				));
		}

		if (count($input['cursos_excluidos'])) {
			foreach ($input['cursos_excluidos'] as $cursoExcluido)
				$this->system->sql->insert('cupom_cursos_excluidos', array(
					'cupom_id'	=> intval($input['id']),
					'curso_id'	=> $cursoExcluido
				));
		}


		return (int)$input['id'];
	}
	// ===============================================================
	public function getCupons($palavraChave = '', $order = 'nome') {
		return $this->system->sql->fetchrowset($this->system->sql->select('t1.*, t2.nome as usuario', 'cupons as t1 left join usuarios as t2 on (t1.usuario_id=t2.id)', "t1.excluido='0'" .  ($palavraChave? " AND t1.nome like '%" . $palavraChave . "%'" : '')), 0, $order);
	}
	// ===============================================================
	public function getCupom($id) {
		$query = $this->system->sql->select('*', 'cupons', "excluido='0' and id= '" . $id . "'");
		$cupom = current($this->system->sql->fetchrowset($query));

		//Cursos Ativos
		$cupom['cursos_ativos'] = $this->getCursosValidos($cupom['id']);

		//Cursos Inativos
		$cupom['cursos_excluidos'] = $this->getCursosExcluidos($cupom['id']);
		
		return $cupom;
	}
	// =============================================================
	public function getCursosValidos($id) {
		$result = $this->system->sql->fetchrowset($this->system->sql->select('*', 'cupom_cursos_ativos', "cupom_id= '" . $id . "'"));
		$cursos = array();
		foreach ($result as $curso) 
			$cursos[] = $curso['curso_id'];

		return $cursos;
		
	}
	// ============================================================
	public function getCursosExcluidos($id) {
		$result = $this->system->sql->fetchrowset($this->system->sql->select('*', 'cupom_cursos_excluidos', "cupom_id= '" . $id . "'"));
		$cursos = array();
		foreach ($result as $curso) 
			$cursos[] = $curso['curso_id'];

		return $cursos;
	}
	// =============================================================
	public function getCupomCondicao($condicao) {
		$query = $this->system->sql->select('*', 'cupons', "excluido='0' " . $condicao);
		$cupom = current($this->system->sql->fetchrowset($query));
		if ($cupom['id']) {
			//Cursos Ativos
			$cupom['cursos_ativos'] = $this->getCursosValidos($cupom['id']);

			//Cursos Inativos
			$cupom['cursos_excluidos'] = $this->getCursosExcluidos($cupom['id']);
		}

		return $cupom;
	}
	// ===============================================================
	public function deletar($id) {
		$this->system->sql->update('cupons', array('excluido' => 1), "id='" . $id . "'");
	}
	// ===============================================================
	public function getTotalPedidosComCupom($campos) {
		$query = $this->system->sql->select('COUNT(1)', 'vendas', "excluido = 0 and cupom_id != 0" . $campos);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getTotalCupons($campos) {
		$query = $this->system->sql->select('COUNT(1)', 'cupons', "excluido = 0" . $campos);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getCuponsMaisUsados($campos) {
		return $this->system->sql->fetchrowset($this->system->sql->select('DISTINCT(t1.cupom_id), t2.nome, COUNT(t1.cupom_id) as total', 'vendas AS t1 LEFT JOIN cupons AS t2 ON (t1.cupom_id=t2.id)', "t1.excluido = 0 AND t2.excluido = 0 ".$campos." GROUP BY t1.cupom_id"));
	}
	// ===============================================================
	public function alterarStatus($id, $status) {
		$this->system->sql->update('cupons', array('ativo' => intval($status)), "id='" . intval($id) . "'");
	}
	// ===============================================================
	public function vezesUsada($id) {
		$query = $this->system->sql->select('COUNT(1)', 'vendas', "excluido = 0 AND cupom_id = '" . $id . "'");
		return $this->system->sql->querycountunit($query);	
	}
	// ===============================================================
	public function relatorioUso($limit = '') {
		$query = $this->system->sql->select('cupom_id, COUNT(id) as total, data_cadastro', 'vendas', "excluido = '0' AND cupom_id != '0' GROUP BY cupom_id", $limit, 'data_cadastro');
		$cupons = $this->system->sql->fetchrowset($query);

		foreach($cupons as $key => $cupom) {
			$query = $this->system->sql->select('*', 'cupons', "excluido = '0' AND id = '" . $cupom['cupom_id'] . "'");
			$cupom = end($this->system->sql->fetchrowset($query));			

			if ($cupom['id']) {
				$cupons[$key]['nome'] = $cupom['nome'];
				$cupons[$key]['ativo'] = $cupom['ativo'];
				$cupons[$key]['tipo'] = $cupom['tipo'];
			}
		}

		return $cupons;
	}
}
// ===================================================================