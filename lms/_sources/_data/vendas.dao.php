<?php
// ===================================================================
class VendasDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('vendas', array(
			'usuario_id'		=> $this->system->session->getItem('session_cod_usuario'),
			'aluno_id'			=> (int)$input['aluno_id'],
			'numero'			=> (int)$input['numero'],
			'comprovante'		=> (int)$input['comprovante'],
			'cupom_id'			=> (int)$input['cupom_id'],
			'parceiro_id'		=> (int)$input['parceiro_id'],
			'forma_desconto'	=> (int)$input['forma_desconto'],
			'forma_pagamento'	=> (int)$input['forma_pagamento'],
			'status'			=> (int)$input['status'],
			'codePagSeguro'		=> trim(($input['codePagSeguro'] ? $input['codePagSeguro'] : '')),
			'valor_taxas'		=> trim(number_format(($input['valor_taxas'] ? $input['valor_taxas'] : 0), 2, '.', '')),
			'valor_desconto'	=> trim(number_format(($input['valor_desconto'] ? $input['valor_desconto'] : 0), 2, '.', '')),
			'valor_total'		=> trim(number_format(($input['valor_total'] ? $input['valor_total'] : 0), 2, '.', '')),
			'data_venda'		=> trim($this->system->func->converteData($input['data_venda'])),
			'data_expiracao'	=> trim($input['data_expiracao']),
			'data_cadastro'		=> date('Y-m-d H:i:s'),
			'excluido'			=> 0
		));
		$id = $this->system->sql->nextid();
		$this->system->sql->update('vendas', array('numero' => $id), "id='" . $id . "'");
		foreach($input['cursos'] as $curso)
			$this->system->sql->insert('vendas_cursos', array('venda_id' => $id, 'curso_id' => $curso['id'], 'certificado' => $curso['certificado'], 'suporte' => $curso['suporte'], 'preco_comissao' => $curso['preco_comissao'], 'preco_total' => $curso['preco_total'], 'professor_id' => $curso['professor_id']));

		foreach($input['planos'] as $plano_id)
			$this->system->sql->insert('vendas_planos', array('venda_id' => $id, 'plano_id' => $plano_id));

		foreach($input['certificados'] as $certificado_id)
			$this->system->sql->insert('vendas_certificados', array('venda_id' => $id, 'matricula_id' => $certificado_id));

		return $id;
	}
	// ===============================================================
	public function atualizar($id, $campos) {
		$this->system->sql->update('vendas', $campos, "id = '" . $id . "'");
	}
	// ===============================================================
	public function deletar($id) {
		$this->system->sql->update('vendas', array('excluido' => 1), "id='" . $id . "'");
	}
	// ===============================================================
	public function getVenda($id) {
		$query = $this->system->sql->select('*', 'vendas', "id= '" . $id . "'");
		$vendas = $this->system->sql->fetchrowset($query);		
		return end($vendas);
	}
	// ===============================================================
	public function getCursosByVenda($id) {
		return $this->system->sql->fetchrowset($this->system->sql->select('*', 'vendas_cursos', "venda_id = " . $id));
	}
	// ================================================================
	public function getCertificadosByVenda($id) {
		return $this->system->sql->fetchrowset($this->system->sql->select('*', 'vendas_certificados', "venda_id = " . $id));
	}
	// ===============================================================
	public function getTotalCursoByCursoId($id) {
		$query = $this->system->sql->select('COUNT(1)', 'vendas_cursos', "venda_id = " . $id);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getVendasPorCategorias($id, $data) {
		return $this->system->sql->fetchrowset($this->system->sql->select('t1.*', 'vendas AS t1 LEFT JOIN vendas_cursos AS t2
ON (t1.id = t2.venda_id)', "t1.excluido = 0 ".$data." AND t2.curso_id IN (SELECT t3.curso_id FROM cursos_categorias AS t3 WHERE t3.curso_id = t2.curso_id AND t3.categoria_id = '".$id."' AND t3.curso_id IN (SELECT t4.id FROM cursos AS t4 WHERE t3.curso_id = t4.id AND t4.excluido = 0)) GROUP BY t1.id"));
	}
	// ===============================================================
	public function getVendas($campos = '', $limit = '') {
		return $this->system->sql->fetchrowset($this->system->sql->select('*', 'vendas', "excluido = 0 " . $campos, $limit, 'data_cadastro desc'));
	}
	// ===============================================================
	public function getVendasBusca($palavra = '', $metodo = 'padrao', $limit = '', $ver_excluidos = 0) {
		$sql_extra = '';
		//Parceiro
		if ($this->system->session->getItem('session_nivel') == 5) 
            $sql_extra .= " parceiro_id = '" . $this->system->session->getItem('session_cod_usuario') . "'";

		//busca
        if ($palavra != '') {
        	if ($metodo == 'padrao') {
        		//venda
        		$sql_extra .= " (id = '" . intval($palavra) . "'";
        		//aluno
        		$query = $this->system->sql->select('id', 'usuarios', "excluido = 0 and nivel = 4 and (nome like '%" . $palavra . "%' OR email like '%" . $palavra . "%')");
        		$resultado = $this->system->sql->fetchrowset($query);
        		if (count($resultado) > 0) {
        			$alunosID = array();
        			foreach ($resultado as $value)
        				$alunosID[] = $value['id'];
        			$sql_extra .= " or aluno_id in (" . implode(',', $alunosID) . ")";	
        		}

				//curso
				$query = $this->system->sql->select('id', 'cursos', "excluido = 0 and curso like '%" . $palavra . "%'");
        		$resultado = $this->system->sql->fetchrowset($query);
        		$vendasCursoID = array();
        		if (count($resultado) > 0) {
        			$cursosID = array();
        			foreach ($resultado as $value)
        				$cursosID[] = $value['id'];
        			$query = $this->system->sql->select('venda_id', 'vendas_cursos', "curso_id in (" . implode(',', $cursosID) . ")");
        			$resultado = $this->system->sql->fetchrowset($query);

        			
        			foreach ($resultado as $value)
        				$vendasCursoID[] = $value['venda_id'];
        			
        		}

        		//Plano
				$query = $this->system->sql->select('id', 'planos', "excluido = 0 and plano like '%" . $palavra . "%'");
        		$resultado = $this->system->sql->fetchrowset($query);
        		$vendasPlanoID = array();
        		if (count($resultado) > 0) {
        			$planosID = array();
        			foreach ($resultado as $value)
        				$planosID[] = $value['id'];
        			$query = $this->system->sql->select('venda_id', 'vendas_planos', "plano_id in (" . implode(',', $planosID) . ")");
        			$resultado = $this->system->sql->fetchrowset($query);

        			foreach ($resultado as $value)
        				$vendasPlanoID[] = $value['venda_id'];
        			
        		}
				
        		$vendasID = array_merge($vendasCursoID, $vendasPlanoID);
        		if (count($vendasID) > 0)
        			$sql_extra .= " or id in (" . implode(',', $vendasID) . ")";	

				$sql_extra .= ')';
        	} 
        }
		return $this->system->sql->fetchrowset($this->system->sql->select('*', 'vendas', ($ver_excluidos ? '' : 'excluido = 0 ') . $sql_extra, $limit, 'data_cadastro desc'));
	}
	// ===============================================================
	public function getVendasPorCurso($curso_id, $campos = '', $limit = '') {
		return $this->system->sql->fetchrowset($this->system->sql->select('DISTINCT(t1.venda_id), t2.data_cadastro, t2.valor_total', 'vendas_cursos AS t1 LEFT JOIN vendas AS t2 ON (t1.venda_id=t2.id)', "t2.excluido = 0 and t1.curso_id = '" . $curso_id . "'" . $campos, '', $limit));
	}
	// ===============================================================
	public function getVendasPorCursos($campos, $limit = '') {
		return $this->system->sql->fetchrowset($this->system->sql->select('DISTINCT(t1.venda_id), t2.data_cadastro, t2.valor_total', 'vendas_cursos AS t1 LEFT JOIN vendas AS t2 ON (t1.venda_id=t2.id)', "t2.excluido = 0 " . $campos, $limit, 'data_cadastro desc'));
	}
	// ===============================================================
	public function getVendasCursoMaisVendido($campos = '', $limit = '') {
		return $this->system->sql->fetchrowset($this->system->sql->select('COUNT(t1.curso_id) as total, t1.curso_id', 'vendas_cursos AS t1 LEFT JOIN
vendas AS t2 ON (t1.venda_id=t2.id)', "t2.excluido = 0" . $campos . ' GROUP BY t1.curso_id ORDER BY total DESC', '', $limit));
	}
	// ===============================================================
	public function getVendasTopConsumidores($campos = '', $limit = '') {
		return $this->system->sql->fetchrowset($this->system->sql->select('COUNT(t1.aluno_id) AS compras, SUM(t1.valor_total) AS total, t2.id, t2.nome', 'vendas AS t1 LEFT JOIN usuarios AS t2 ON (t1.aluno_id=t2.id)', "t2.excluido = 0 and t1.excluido = 0 " . $campos . ' GROUP BY aluno_id ORDER BY total DESC', '', $limit));
	}
	// ===============================================================
	public function getTotal($palavra = '', $metodo = 'padrao') {
		$sql_extra = '';

		//Parceiro
		if ($this->system->session->getItem('session_nivel') == 5) 
            $sql_extra .= " and parceiro_id = '" . $this->system->session->getItem('session_cod_usuario') . "'";

		//busca
        if ($palavra != '') {
        	if ($metodo == 'padrao') {
        		//venda
        		$sql_extra .= " and (id = '" . intval($palavra) . "'";
        		//aluno
        		$query = $this->system->sql->select('id', 'usuarios', "excluido = 0 and nivel = 4 and (nome like '%" . $palavra . "%' OR email like '%" . $palavra . "%')");
        		$resultado = $this->system->sql->fetchrowset($query);
        		if (count($resultado) > 0) {
        			$alunosID = array();
        			foreach ($resultado as $value)
        				$alunosID[] = $value['id'];
        			$sql_extra .= " or aluno_id in (" . implode(',', $alunosID) . ")";	
        		}

				//curso
				$query = $this->system->sql->select('id', 'cursos', "excluido = 0 and curso like '%" . $palavra . "%'");
        		$resultado = $this->system->sql->fetchrowset($query);
        		$vendasCursoID = array();
        		if (count($resultado) > 0) {
        			$cursosID = array();
        			foreach ($resultado as $value)
        				$cursosID[] = $value['id'];
        			$query = $this->system->sql->select('venda_id', 'vendas_cursos', "curso_id in (" . implode(',', $cursosID) . ")");
        			$resultado = $this->system->sql->fetchrowset($query);

        			
        			foreach ($resultado as $value)
        				$vendasCursoID[] = $value['venda_id'];
        			
        		}

        		//Plano
				$query = $this->system->sql->select('id', 'planos', "excluido = 0 and plano like '%" . $palavra . "%'");
        		$resultado = $this->system->sql->fetchrowset($query);
        		$vendasPlanoID = array();
        		if (count($resultado) > 0) {
        			$planosID = array();
        			foreach ($resultado as $value)
        				$planosID[] = $value['id'];
        			$query = $this->system->sql->select('venda_id', 'vendas_planos', "plano_id in (" . implode(',', $planosID) . ")");
        			$resultado = $this->system->sql->fetchrowset($query);

        			foreach ($resultado as $value)
        				$vendasPlanoID[] = $value['venda_id'];
        			
        		}
				
        		$vendasID = array_merge($vendasCursoID, $vendasPlanoID);
        		if (count($vendasID) > 0)
        			$sql_extra .= " or id in (" . implode(',', $vendasID) . ")";	

				$sql_extra .= ')';
        	} 
        }

		$query = $this->system->sql->select('COUNT(1)', 'vendas', ($ver_excluidos ? '' : 'excluido = 0 ') . $sql_extra);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getTotalVendas($campos = '') {
		$query = $this->system->sql->select('SUM(valor_total) as total', 'vendas', "excluido = 0 " . $campos);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getTotalPedidos($campos = '') {
		$query = $this->system->sql->select('COUNT(1)', 'vendas', "excluido = 0 " . $campos);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getTotalItensPedidos($campos = '') {
		$query = $this->system->sql->select('COUNT(t2.venda_id)', 'vendas as t1, vendas_cursos as t2', 't1.id = t2.venda_id  and t1.excluido = 0 ' . $campos);
		$cursos = $this->system->sql->querycountunit($query);

		$query = $this->system->sql->select('COUNT(t2.venda_id)', 'vendas as t1, vendas_planos as t2', 't1.id = t2.venda_id  and t1.excluido = 0 ' .  $campos);
		$planos = $this->system->sql->querycountunit($query);

		$query = $this->system->sql->select('COUNT(t2.venda_id)', 'vendas as t1, vendas_certificados as t2','t1.id = t2.venda_id  and t1.excluido = 0 ' . $campos);
		$certificados = $this->system->sql->querycountunit($query);

		return ($cursos + $planos + $certificados);
	}
	// ===============================================================
	public function getTotalDescontosUsados($campos = '') {
		$query = $this->system->sql->select('SUM(valor_desconto) as total', 'vendas', "excluido = 0 " . $campos);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getTotalClientes($campos = '') {
		$query = $this->system->sql->select('COUNT(1)', 'usuarios', "excluido = 0 and nivel = 4 and ativo = 1" . $campos);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getTotalClientesVendas($campos = '') {
		$query = $this->system->sql->select('COUNT(t1.id)', 'usuarios AS t1', "id IN (SELECT t2.aluno_id FROM vendas AS t2 WHERE t2.aluno_id = t1.id) AND t1.excluido = 0 AND t1.ativo = 1 AND t1.nivel = 4" . $campos);
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getPedidosVendas($limit = '') {
		$sql_extra = '';

		//Parceiro
		if ($this->system->session->getItem('session_nivel') == 5) 
            $sql_extra .= " and parceiro_id = '" . $this->system->session->getItem('session_cod_usuario') . "'";

		$query = $this->system->sql->select('*', 'vendas', "excluido = 0 " . $sql_extra  , $limit);
		$vendas = $this->system->sql->fetchrowset($query);
		foreach($vendas as $key => $venda) {
			//Cliente
			$query = $this->system->sql->select('*', 'usuarios', "id = '" . $venda['aluno_id'] . "'");
			$cliente = end($this->system->sql->fetchrowset($query));

			$vendas[$key]['aluno'] = $cliente;

			//Curso
			$query = $this->system->sql->select('*', 'cursos', "id IN (SELECT curso_id FROM vendas_cursos WHERE venda_id = '" . $venda['id'] . "')");
			$cursos = $this->system->sql->fetchrowset($query);

			$vendas[$key]['cursos'] = $cursos;

			//Planos
			$query = $this->system->sql->select('*', 'planos', "id IN (SELECT plano_id FROM vendas_planos WHERE venda_id = '" . $venda['id'] . "')");
			$planos = $this->system->sql->fetchrowset($query);

			$vendas[$key]['planos'] = $planos;

			//Certificados
			$vendas[$key]['certificados'] = $this->getCertificadosVenda($venda['id']);
			

			$desconto = 0;
			//Cupons
			if ($vendas[$key]['cupom_id']) {
				$query = $this->system->sql->select('*', 'cupons', "id = '" . $venda['cupom_id'] . "'");
				$cupom = end($this->system->sql->fetchrowset($query));

				if ($cupom['id']) {
					$vendas[$key]['cupom'] = $cupom;	
					$desconto = $cupom['valor'];
				}
			}

			//Desconto da venda
			$desconto+= $vendas[$key]['valor_desconto'];
			

			//Removido Cupons e Descontos dados
			$vendas[$key]['valor_total_bruto'] = number_format($vendas[$key]['valor_total'] + $desconto, 2, ',', '.');
		}

		return $vendas;
	}

	// ===============================================================
	public function getPedidosBuscaVendas($palavra = '', $metodo = 'padrao', $limit = '') {
		$vendas = $this->getVendasBusca($palavra, $metodo, $limit);
		foreach($vendas as $key => $venda) {
			//Cliente
			$query = $this->system->sql->select('*', 'usuarios', "id = '" . $venda['aluno_id'] . "'");
			$cliente = end($this->system->sql->fetchrowset($query));

			$vendas[$key]['aluno'] = $cliente;

			//Curso
			$query = $this->system->sql->select('*', 'cursos', "id IN (SELECT curso_id FROM vendas_cursos WHERE venda_id = '" . $venda['id'] . "')");
			$cursos = $this->system->sql->fetchrowset($query);

			$vendas[$key]['cursos'] = $cursos;

			//Planos
			$query = $this->system->sql->select('*', 'planos', "id IN (SELECT plano_id FROM vendas_planos WHERE venda_id = '" . $venda['id'] . "')");
			$planos = $this->system->sql->fetchrowset($query);

			$vendas[$key]['planos'] = $planos;

			//Certificados
			$vendas[$key]['certificados'] = $this->getCertificadosVenda($venda['id']);
			

			$desconto = 0;
			//Cupons
			if ($vendas[$key]['cupom_id']) {
				$query = $this->system->sql->select('*', 'cupons', "id = '" . $venda['cupom_id'] . "'");
				$cupom = end($this->system->sql->fetchrowset($query));

				if ($cupom['id']) {
					$vendas[$key]['cupom'] = $cupom;	
					$desconto = $cupom['valor'];
				}
			}

			//Desconto da venda
			$desconto+= $vendas[$key]['valor_desconto'];
			

			//Removido Cupons e Descontos dados
			$vendas[$key]['valor_total_bruto'] = number_format($vendas[$key]['valor_total'] + $desconto, 2, ',', '.');
		}

		return $vendas;
	}
	// ===============================================================
	public function getCursosVenda($vendaID) {
		$query = $this->system->sql->select('curso_id as id, certificado, suporte, preco_total, preco_comissao', 'vendas_cursos', "venda_id = '" . $vendaID . "'");
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	public function getPlanoVenda($vendaID) {
		$query = $this->system->sql->select('plano_id', 'vendas_planos', "venda_id = '" . $vendaID . "'");
		$plano = end($this->system->sql->fetchrowset($query));
		if (!$plano['plano_id'])
			return array();
		$query = $this->system->sql->select('*', 'planos', "id = '" . $plano['plano_id'] . "'");
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getCertificadosVenda($vendaID) {
		$query = $this->system->sql->select('matricula_id', 'vendas_certificados', "venda_id = '" . $vendaID . "'");
		$matriculas = $this->system->sql->fetchrowset($query);

		$return = array();
		foreach ($matriculas as $matricula) {
			//dados matricula
			$query = $this->system->sql->select('curso_id, usuario_id', 'cursos_alunos', "id = '" . $matricula['matricula_id'] . "'");
			$matricula2 = end($this->system->sql->fetchrowset($query));

			//curso
			$query = $this->system->sql->select('curso', 'cursos', "id = '" . $matricula2['curso_id'] . "'");
			$curso = end($this->system->sql->fetchrowset($query));

			$valor = array();
			$valor['matricula_id'] = $matricula['matricula_id'];
			$valor['aluno_id'] = $matricula2['usuario_id'];
			$valor['curso_id'] = $matricula2['curso_id'];
			$valor['curso'] = $curso['curso'] . ' (Certificado)';

			$return[] = $valor;
		}

		return $return;
	}
	// ===============================================================
	public function alterarPagamento($id, $status) {
		$fields = array('status' => $status);
		if ($status == 1) 
			$fields['data_venda'] = date('Y-m-d');
		$this->system->sql->update('vendas', $fields, "id='" . $id . "'");
	}
	// ===============================================================
	public function alterarRastreamento($id, $codigo_rastreamento) {
		$this->system->sql->update('vendas', array('codigo_rastreamento' => $codigo_rastreamento), "id='" . $id . "'");
	}
	// ===============================================================
	public function alterarObservacoes($id, $observacoes) {
		$this->system->sql->update('vendas', array('observacoes' => $observacoes), "id='" . $id . "'");
	}
	// ===============================================================
	public function getTotalRetorno($campo = '') {
		$query = $this->system->sql->select('SUM(total) as total', 'vendas_comprovantes', "excluido = 0 " . $campo);
		return $this->system->sql->querycountunit($query);
	}
	//=================================================================
	public function enviarComprovante($parceiro_id, $comprovante, $observacao, $mes, $ano) {
		$this->system->sql->update('vendas_comprovantes', array(
			'comprovante'		=> $comprovante,
			'observacao'		=> $observacao,
			'data_envio'		=> date('Y-m-d H:i:s'),
			'enviado'			=> 1),
		 "parceiro_id = '" . $parceiro_id . "' and mes = '" . $mes . "' and ano = '" . $ano . "'");
	}
	//=================================================================
	public function cadastrarComprovante($parceiro_id, $total, $mes, $ano) {
		$this->system->sql->insert('vendas_comprovantes', array(
			'parceiro_id'		=> $parceiro_id,
			'total'				=> $total,
			'mes'				=> (int)$mes,
			'ano'				=> (int)$ano,
			'enviado'			=> 0,
			'data_cadastro'		=> date('Y-m-d H:i:s'),
			'data_envio'		=> '0000-00-00 00:00:00',
			'excluido'			=> 0
		));
	}
	//================================================================
	public function getComprovantes($campo = '') {
		$query = $this->system->sql->select('*', 'vendas_comprovantes', "excluido = 0 " . $campo, '', 'data_cadastro desc');
		return $this->system->sql->fetchrowset($query);
	}
	// ================================================================
	public function getComprovante($campo) {
		$query = $this->system->sql->select('*', 'vendas_comprovantes', "excluido = 0 " . $campo, 1, 'data_cadastro desc');
		return end($this->system->sql->fetchrowset($query));
	}
	// ================================================================
	public function buscarPlanosAbertos($limitarTempo = false) {
		$where = '';
		if ($limitarTempo)
			$where = " and data_cadastro >= '" . date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), (date('d') - 14), date('Y'))) . "'";
		
		$query = $this->system->sql->select('*', 'vendas', "excluido = 0 and status = 0 and id in (SELECT venda_id from vendas_planos)" . $where);
		return $this->system->sql->fetchrowset($query);
	}
	// ================================================================
	public function verificaCompraCursoAberta($usuario_id, $curso_id) {
		$query = $this->system->sql->select('id', 'vendas', "excluido = 0 and status = 0 and usuario_id = '" . $usuario_id . "' and id in (SELECT venda_id from vendas_cursos where curso_id = '" . $curso_id . "')");
		$result = end($this->system->sql->fetchrowset($query));
		return ($result['id'] ? true : false);
	}
	// ================================================================
	public function verificaCompraPlanoAberta($usuario_id, $plano_id) {
		$query = $this->system->sql->select('id', 'vendas', "excluido = 0 and status = 0 and usuario_id = '" . $usuario_id . "' and id in (SELECT venda_id from vendas_planos where plano_id = '" . $plano_id . "')");
		$result = end($this->system->sql->fetchrowset($query));
		return ($result['id'] ? true : false);
	}
	// ===============================================================
	public function tipoVenda($vendaID) {
		$query = $this->system->sql->select('COUNT(1)', 'vendas_cursos', "venda_id = '" . $vendaID . "'");
		$cursos = $this->system->sql->querycountunit($query);
		if ($cursos > 0)
			return 1; //curso


		$query = $this->system->sql->select('COUNT(1)', 'vendas_planos', "venda_id = '" . $vendaID . "'");
		$planos = $this->system->sql->querycountunit($query);

		if ($planos > 0)
			return 2; //planos

		$query = $this->system->sql->select('COUNT(1)', 'vendas_certificados', "venda_id = '" . $vendaID . "'");
		$certificados = $this->system->sql->querycountunit($query);

		if ($certificados > 0)
			return 3; //certificados
	}

	public function getAssinaturasPlanoMes(){
		$planos = array();
		$query = $this->system->sql->select('plano_id', 'vendas_planos', "venda_id IN(SELECT id FROM vendas WHERE STATUS=1 AND data_venda >= '".date('Y-m-01')."' AND data_venda <= '".date('Y-m-d')."')");
		$planoId = $this->system->sql->fetchrowset($query);

		foreach ($planoId as $key => $plano) {
			$planos[$plano['plano_id']]['total']++;

		}
		

		foreach ($planos as $plano_id => $total) {

			$queryPlanoNome = $this->system->sql->select('plano,valor', 'planos', "id='".$plano_id."'");
			$plano = end($this->system->sql->fetchrowset($queryPlanoNome));			
			$planos[$plano_id]['plano'] = $plano['plano'];
			$planos[$plano_id]['valor_total'] = number_format($plano['valor'] * $total['total'], 2, ',', '.');

		}

		return $planos;	
	}
	
}
// ===================================================================