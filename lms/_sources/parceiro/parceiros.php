<?php
require_once(dirname(__FILE__).'/../global/parceiros.global.php');
// ===================================================================
class Parceiros extends ParceirosGlobal {
	
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		
		switch($this->system->input['do']) {
			case 'relatorio': 							$this->doRelatorio(); break;
			case 'carregaDadosVendaPorDia': 			$this->docarregaDadosVendaPorDia(); break;
			case 'carregaDadosVendaPorMes': 			$this->docarregaDadosVendaPorMes(); break;
			case 'carregaDadosVendaPorProdutos': 		$this->docarregaDadosVendaPorProdutos(); break;
			case 'carregaDadosVendaMaisVendidos': 		$this->docarregaDadosVendaPorMaisVendidos(); break;
			case 'carregaDadosVendaTopConsumidores': 	$this->docarregaDadosVendaTopConsumidores(); break;
			case 'carregaDadosVendaPorCategorias': 		$this->docarregaDadosVendaPorCategorias(); break;
			case 'carregaDadosVendaCupons': 			$this->docarregaDadosVendaCupons(); break;
			case 'calcularQuantoRetornar':				$this->doCalcularQuantoRetornar();
			case 'enviarComprovante':					$this->doEnviarComprovante(); break;
			case 'comprovante':							$this->doListarComprovante(); break;
			default: 									$this->pagina404(); break;

		}
	}
	// ===============================================================
	protected function docarregaDadosVendaPorMaisVendidos() {
		$data1 = $this->system->input['data1'];
		$data2 = $this->system->input['data2'];
		$parceiro_id = $this->system->session->getItem('session_cod_usuario');
		
		if (!$data1 || !$data2)
			$data1 = $data2 = date('d/m/Y');
			
		$data1 = $this->system->func->converteData($data1);
		$data2 = $this->system->func->converteData($data2);
		$sql = " and t2.parceiro_id = '" . $parceiro_id . "' and (t2.data_cadastro >= '".$data1." 00:00:00' and t2.data_cadastro <= '".$data2." 23:59:59')";
		$ultimas = $this->system->vendas->getVendasCursoMaisVendido($sql, 0);
		$lista_produtos = array();
		foreach($ultimas as $key => $curso) {
			$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
			$lista_produtos[$key]['curso'] = $curso_dados['curso'];
			$lista_produtos[$key]['quantidade'] = $curso['total'];
			$lista_produtos[$key]['total'] = number_format(($curso_dados['valor'] * $curso['total']), 2, ',', '.');
		}
		echo json_encode($lista_produtos);
	}
	// ===============================================================
	protected function docarregaDadosVendaPorProdutos() {
		$curso_id = (int)$this->system->input['curso_id'];
		$parceiro_id = $this->system->session->getItem('session_cod_usuario');
		if (!$curso_id) return;
		
		$lista_produtos = array();
		$vendas_produtos = $this->system->vendas->getVendasPorCurso($curso_id, " and t2.parceiro_id = '" . $parceiro_id . "' and t2.data_cadastro like '".date('Y')."-%'", 0);
		foreach($vendas_produtos as $item => $vendas) {
			$mes = substr($vendas['data_cadastro'], 5, 2);
			$lista_produtos[$mes]['mes'] = $mes;
			$lista_produtos[$mes]['total'] += $vendas['valor_total'];
			$lista_produtos[$mes]['quantidade']++;
		}
		ksort($lista_produtos);
		if (count($lista_produtos))
			echo json_encode($lista_produtos);
	}
	// ===============================================================
	protected function docarregaDadosVendaPorCategorias() {
		$mes = (int)$this->system->input['mes'];
		$ano = (int)$this->system->input['ano'];
		$categoria_id = (int)$this->system->input['categoria'];
		$parceiro_id = $this->system->session->getItem('session_cod_usuario');
		
		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;
		$sql = " and t1.parceiro_id = '" . $parceiro_id . "' and t1.data_cadastro like '".$ano."-".$mes."%'";
		$ultimas_vendas = $this->system->vendas->getVendasPorCategorias($categoria_id, $sql);
		
		foreach($ultimas_vendas as $key => $vendas) {
			$ultimas_vendas[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
				$cursos[] = $curso_dados['curso'];
			}
			$ultimas_vendas[$key]['cursos'] = implode('<br/>', $cursos);
		}
		echo json_encode($ultimas_vendas);
	}
	// ===============================================================
	protected function docarregaDadosVendaTopConsumidores() {
		$mes = (int)$this->system->input['mes'];
		$ano = (int)$this->system->input['ano'];
		$parceiro_id = $this->system->session->getItem('session_cod_usuario');
		
		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;
		
		$sql = " and t1.parceiro_id = '" . $parceiro_id . "' and t1.data_cadastro like '".$ano."-".$mes."%'";
		$ultimas_vendas = $this->system->vendas->getVendasTopConsumidores($sql, 0);
		foreach($ultimas_vendas as $key => $vendas) {
			$vendas_usuario = $this->system->vendas->getVendas("and parceiro_id != 0 and aluno_id = '".$vendas['id']."' and data_cadastro like '".$ano."-".$mes."%'");
			foreach($vendas_usuario as $key1 => $venda_usuario) {
				$ultimas_vendas[$key]['total_cursos'] += $this->system->vendas->getTotalCursoByCursoId($venda_usuario['id']);
			}
		}
		echo json_encode($ultimas_vendas);
	}
	// ===============================================================
	protected function docarregaDadosVendaPorMes() {
		$mes = (int)$this->system->input['mes'];
		$ano = (int)$this->system->input['ano'];
		$parceiro_id = $this->system->session->getItem('session_cod_usuario');
		
		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;
		
		$sql_mes = " and parceiro_id = '" . $parceiro_id . "' and data_cadastro like '".$ano."-".$mes."%'";
		
		$ultimas_10_vendas_mes = $this->system->vendas->getVendas($sql_mes, 0);
		
		foreach($ultimas_10_vendas_mes as $key => $vendas) {
			$ultimas_10_vendas_mes[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
				$cursos[] = $curso_dados['curso'];
			}
			$ultimas_10_vendas_mes[$key]['cursos'] = implode('<br/>', $cursos);
		}
		echo json_encode(array('ultimas_10_vendas_mes' => $ultimas_10_vendas_mes));
	}
	// ===============================================================
	protected function docarregaDadosVendaPorDia() {
		$data1 = $this->system->input['data1'];
		$data2 = $this->system->input['data2'];
		$parceiro_id = $this->system->session->getItem('session_cod_usuario');
		
		if (!$data1 || !$data2)
			$data1 = $data2 = date('d/m/Y');
		
		if ($data1 == $data2)
			$vendas_periodo = $data1;
		else
			$vendas_periodo = 'de ' . $data1 . ' até ' . $data2;
		
		$data1 = $this->system->func->converteData($data1);
		$data2 = $this->system->func->converteData($data2);
		$sql_dia = " and parceiro_id = '" . $parceiro_id . "' and (data_cadastro >= '".$data1." 00:00:00' and data_cadastro <= '".$data2." 23:59:59')";
		
		$total_vendas_dia = number_format($this->system->vendas->getTotalVendas($sql_dia), 2, ',', '.');
		$total_pedidos_dia = $this->system->vendas->getTotalPedidos($sql_dia);
		$ultimas_10_vendas_dia = $this->system->vendas->getVendas($sql_dia, 10);
		
		foreach($ultimas_10_vendas_dia as $key => $vendas) {
			$ultimas_10_vendas_dia[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
				$cursos[] = $curso_dados['curso'];
			}
			$ultimas_10_vendas_dia[$key]['cursos'] = implode('<br/>', $cursos);
		}
		echo json_encode(array('total_vendas_dia' => $total_vendas_dia, 'total_pedidos_dia' => $total_pedidos_dia, 'ultimas_10_vendas_dia' => $ultimas_10_vendas_dia, 'vendas_periodo' => $vendas_periodo));
	}
	// ===============================================================
	protected function doRelatorio() {
		$this->system->load->dao('parceiros');
		$parceiro_id = $this->system->session->getItem('session_cod_usuario');
		$this->system->admin->topo(2);
		$ultimas_10_vendas = $this->system->vendas->getVendas('and parceiro_id = ' . $parceiro_id, 10);
		foreach($ultimas_10_vendas as $key => $vendas) {
			$ultimas_10_vendas[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
				$cursos[] = $curso_dados['curso'];
			}
			$ultimas_10_vendas[$key]['cursos'] = implode('<br/>', $cursos);
		}

		$this->system->view->assign(array(
			'data1'						=> date('d/m/Y'),
			'data2'						=> date('d/m/Y'),
			'mes'						=> date('m'),
			'ano'						=> date('Y'),
			'categorias'				=> $this->system->categorias->getCategorias(),
			'cursos'					=> $this->system->curso->getCursos(),
			'total_vendas' 				=> number_format($this->system->vendas->getTotalVendas('and parceiro_id = ' . $parceiro_id), 2, ',', '.'),
			'total_retornar'			=> number_format($this->system->vendas->getTotalRetorno("and parceiro_id = " . $parceiro_id), 2, ',', '.'),
			'total_pedidos' 			=> $this->system->vendas->getTotalPedidos('and parceiro_id = ' . $parceiro_id),
			'media_vendas' 				=> number_format(($this->system->vendas->getTotalVendas('and parceiro_id = ' . $parceiro_id) / $this->system->vendas->getTotalPedidos('and parceiro_id = ' . $parceiro_id)), 2, ',', '.'),
			'descontos_usados'			=> number_format($this->system->vendas->getTotalDescontosUsados('and parceiro_id = ' . $parceiro_id), 2, ',', '.'),
			'ultimas_10_vendas'			=> $ultimas_10_vendas,
		));
		
		// pego todas as vendas do mês atual
		$sql = " and parceiro_id = '" . $parceiro_id . "' and data_cadastro like '".date('Y-m')."%'";
		$vendas = $this->system->vendas->getVendas($sql, 0);
		foreach($vendas as $key => $venda) {
			// pego todos os cursos da venda
			foreach($this->system->vendas->getCursosByVenda($venda['id']) as $curso) {
				// pego as categorias do curso
				$curso_dados = $this->system->curso->getCurso($curso['curso_id'], true);
				// percorro as categorias do curso
				foreach($curso_dados['categorias'] as $key2 => $categoria_id) {
					$categoria[$categoria_id]['total'] += $venda['valor_total'];
					$categoria[$categoria_id]['id'] = $categoria_id;
				}
				
			}
		}
		arsort($categoria);
		$categoria = array_slice($categoria, 0, 1);
		$dados_categoria = $this->system->categorias->getCategoria($categoria[0]['id']);
		$this->system->view->assign(array(
			'nome_categoria_mais_vendida' 	=> $dados_categoria['categoria'],
			'valor_categoria_mais_vendida' 	=> number_format($categoria[0]['total'], 2, ',', '.')
		));
		$this->system->view->display('parceiro/parceiros_relatorios.tpl');
		$this->system->admin->rodape();
	}
	// ===================================================================
	protected function doListarComprovante() {
		$comprovantes = $this->system->vendas->getComprovantes(' and parceiro_id = ' . $this->system->session->getItem('session_cod_usuario'));
		
		foreach ($comprovantes as $key => $comprovante) {
			$comprovantes[$key]['mes'] = $this->system->arrays->getMes($comprovante['mes']);
			$comprovantes[$key]['preco'] = 'R$ '  . number_format($comprovante['total'], 2, ',', '.');
		}
		
		$this->system->view->assign('comprovantes', $comprovantes);
		$this->system->admin->topo(2);
		$this->system->view->display('parceiro/parceiros_comprovantes.tpl');
		$this->system->admin->rodape();
	} 
}
// ===================================================================