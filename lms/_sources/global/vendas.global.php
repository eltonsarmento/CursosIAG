<?php
// ===================================================================
class VendasGlobal {
	// ===============================================================
	protected $system = null;
	private $totalPreco = 0;
	private $totalPrecoProfessor = 0;
	protected $exibirPorPagina = 10;

	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('curso');
		$this->system->load->dao('alunos');
		$this->system->load->dao('vendas');
		$this->system->load->dao('categorias');
		$this->system->load->dao('cupons');
		$this->system->load->dao('certificados');
		$this->system->load->model('email_model');
        $this->system->load->dao('pagseguro');
	}
	// ===============================================================
	public function autoRun() {
		if (in_array($this->system->session->getItem('session_nivel'), $this->acessoPermitido)) {
    		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
			switch($this->system->input['do']) {
				case 'nova': 								$this->doEdicao(); break;
				case 'pedidos': 							$this->doLista(); break; 
				case 'buscar': 								$this->doLista(); break;
				case 'buscar-vendas': 						$this->doTodasVendas(); break;
				case 'calcularPreco':						$this->doCalcularPreco(); break;
				case 'relatorio': 							$this->doRelatorio(); break;
				case 'carregaDadosVendaPorDia': 			$this->docarregaDadosVendaPorDia(); break;
				case 'carregaDadosVendaPorMes': 			$this->docarregaDadosVendaPorMes(); break;
				case 'carregaDadosVendaPorProdutos': 		$this->docarregaDadosVendaPorProdutos(); break;
				case 'carregaDadosVendaMaisVendidos': 		$this->docarregaDadosVendaPorMaisVendidos(); break;
				case 'carregaDadosVendaTopConsumidores': 	$this->docarregaDadosVendaTopConsumidores(); break;
				case 'carregaDadosVendaPorCategorias': 		$this->docarregaDadosVendaPorCategorias(); break;
				case 'carregaDadosVendaCupons': 			$this->docarregaDadosVendaCupons(); break;
				case 'carregaDadosCertificados': 			$this->docarregaDadosCertificados(); break;
				case 'carregaDadosAssinatura':				$this->doCarregaDadosAssinatura(); break;
				case 'salvarPagamento':		 				$this->doAlterarPagamento(); break;
				case 'salvarRastreamento':		 			$this->doAlterarRastreamento(); break;
				case 'salvarObservacoes':		 			$this->doAlterarObservacoes(); break;
				case 'detalhes': 							$this->doDetalhesVenda(); break;
				case 'todas': 								$this->doTodasVendas(); break;
				case 'baixarComprovante':					$this->doBaixarComprovante(); break;
				case 'buscarPorAluno':						$this->doBuscarPorAluno(); break;
				case 'cancelar':							$this->doCancelar(); break;
				case 'reativar':							$this->doReativar(); break;
				case 'baixarListaAlunosCursoMes':			$this->dobaixarListaAlunosCursoMes(); break;
				default: 									$this->pagina404(); break;
			}
		} else {
			$this->pagina404();
		}
	}
	// ===============================================================
	protected function dobaixarListaAlunosCursoMes() {
		$curso_id = intval($this->system->input['curso']);
		$mes = $this->system->input['mes'];
		$ano = $this->system->input['ano'];

		if ($curso_id && $mes && $ano) {

			$vendas_produtos = $this->system->vendas->getVendasPorCurso($curso_id, " and data_cadastro like '".$ano."-".$mes."-%'", 0);

			if (count($vendas_produtos)) {
				$html  = '';  
				$html .= '<table border="1">';  
				$html .= '<tr>';  
				$html .= '<td align="center"><b>NOME</b></td>';  
				$html .= '<td align="center"><b>EMAIL</b></td>';  
				$html .= '</tr>'; 

				foreach($vendas_produtos as $item => $vendas) {
					$venda = $this->system->vendas->getVenda($vendas['venda_id']);
					$aluno = $this->system->alunos->getAluno($venda['usuario_id']);

					$html .= '<tr>';  
					$html .= '<td align="center">'.$aluno['nome'].'</td>';  
					$html .= '<td align="center">'.$aluno['email'].'</td>';
					$html .= '</tr>';
				}

				$arquivo = 'alunos_curso_'.$mes.'_'.$ano.'.xls';  
				$html .= '</table>';  
				  
				header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
				header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
				header ("Cache-Control: no-cache, must-revalidate");  
				header ("Pragma: no-cache");  
				header ("Content-type: application/x-msexcel");  
				header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );  
				header ("Content-Description: PHP Generated Data" );  
				  
				echo $html;
			}
			die;
		}
	}
	// ===============================================================
	protected function doEdicao() {
		$editar = intval($this->system->input['editar']);
		if ($editar) {
			$erro_msg = $this->validarDados();
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('vendas', $this->system->input);
			} else {
				//Salvar
				$this->system->input['status'] = 1;
				if ($this->system->session->getItem('session_nivel') == 5) {
					$this->system->input['data_venda'] = date('d/m/Y');
					$this->system->input['data_expiracao'] = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), (date('Y') + 2)));
				} 
				else {
					$this->system->input['data_expiracao'] = $this->system->func->converteData($this->system->input['data_expiracao']);
				}
				
				
				if ($this->system->session->getItem('session_nivel') == 5)
					$this->system->input['parceiro_id'] = $this->system->session->getItem('session_cod_usuario');
				
				if ($this->system->input['forma_desconto'] == 2) {
					//Porcentagem menor que 100
					if ($this->system->input['valor_desconto'] < 100) {
							$porcentagemPaga = 100 - $this->system->input['valor_desconto'];

							$valorTotal = ((100 * $this->system->input['valor_total'])/$porcentagemPaga);
							$this->system->input['valor_desconto'] = $valorTotal - $this->system->input['valor_total'];	
					} else { //100 de porcentagem
						$cursos = $this->system->input['cursos'];
						$this->system->input['valor_desconto'] = 0;
						foreach ($cursos as $curso) {
							$curso = $this->system->curso->getCurso($curso);
							if (!$curso['gratuito'] && $curso['valor'] != '0.00') {
								$this->system->input['valor_desconto'] += $curso['valor'];
							}

							//suporte
							if ($curso['suporte']) {
								$this->system->load->dao('configuracoesgerais');
								$suporteConfig = $this->system->configuracoesgerais->getProdutosSuporte();
								
								//Valor fixo
								if ($suporteConfig['produtos_suporte_tipo'] == 2) 
									$this->system->input['valor_desconto'] += $suporteConfig['produtos_suporte_valor'];
								
								//Porcentagem
								if ($suporteConfig['produtos_suporte_tipo'] == 3) {
									$valor = (($curso['valor'] * $suporteConfig['produtos_suporte_valor'])/100);
									$this->system->input['valor_desconto'] += $valor;
								}
							}
						}
					}
					
				}

				//Cursos Adicionar Suporte
				$valorTotalCompraSemDesconto = number_format(($this->system->input['valor_total'] + $this->system->input['valor_desconto']), 2, '.', '');
				$cursos = array();

				foreach($this->system->input['cursos'] as $curso_id) {
					$this->system->load->dao('configuracoesgerais');

					$curso['id'] = $curso_id;
					$dadosCurso = $this->system->curso->getCurso($curso_id);
					$suporteConfig = $this->system->configuracoesgerais->getProdutosSuporte();
					$curso['preco_comissao'] = 0;

					//Preco do curso puro
					if (!$dadosCurso['gratuito'] && $dadosCurso['valor'] != '0.00') 
						$curso['preco_comissao'] += $dadosCurso['valor'];

					if ($dadosCurso['suporte'] && in_array($suporteConfig['produtos_suporte_tipo'], array(1, 2, 3))) {
						$curso['suporte'] = 1;
						
						//Preco do suporte 
						//Fixo
						if ($suporteConfig['produtos_suporte_tipo'] == 2) 
							$curso['preco_comissao'] += $suporteConfig['produtos_suporte_valor'];
							
						//Porcentagem
						if ($suporteConfig['produtos_suporte_tipo'] == 3) {
							$valor = (($dadosCurso['valor'] * $suporteConfig['produtos_suporte_valor'])/100);
							$curso['preco_comissao'] += $valor;
						}

					} else 
						$curso['suporte'] = 0;
						
					$curso['professor_id'] = $dadosCurso['professor_id'];
					$curso['certificado'] = 0;
					$curso['preco_total'] = $curso['preco_comissao'];

					//Desconto do curso
					$curso['preco_desconto'] = number_format($this->system->func->divisaoCusto($valorTotalCompraSemDesconto, $curso['preco_total'], $this->system->input['valor_desconto']), 2, '.', '');

					$cursos[] = $curso;
				}
				
				$this->system->input['cursos'] = $cursos;


				$vendaID = $this->system->vendas->cadastrar($this->system->input);
				$this->system->curso->cadastrarCursosAluno($cursos, $this->system->input['aluno_id'], $this->system->input['data_expiracao'] . ' 23:59:59');
				
				$this->system->view->assign('msg_alert', 'Ação realizada com sucesso!');

				//Email Venda 
				$numero = str_pad($vendaID, 5, "0", STR_PAD_LEFT);
				foreach ($this->system->input['cursos'] as $curso)
					$this->system->email_model->vendaCursoProfessor($curso['id'], $numero);
				//
				$this->system->email_model->vendaRealizadaAdministrativo($numero);
				//
				$this->system->email_model->vendaAprovadaAluno($this->system->input['aluno_id'], $numero, date('d/m/Y', strtotime($this->system->input['data_expiracao'] . ' 23:59:59')));

			}
		} 
		

		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('vendas'));
		$this->system->view->assign(array(
			'alunos' 		 => $this->system->alunos->getAlunos(),
			'cursos' 		 => ($this->system->session->getItem('session_nivel') == 5 ? $this->system->curso->getCursosCondicao(' and home=1 ') : $this->system->curso->getCursos()) ,
			'data_venda'	 => date('d/m/Y'),
			'periodoLiberado'=> ($this->system->session->getItem('session_nivel') == 1 ? true : false)
		));
		

		$this->system->view->display('global/vendas_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
        if (!$this->system->input['aluno_id'])
            $retorno['msg'][] = "O campo Nome do Aluno está vazio.";
        
        if (!count($this->system->input['cursos']))
            $retorno['msg'][] = "Selecione ao menos um curso.";
        elseif ($this->system->input['aluno_id']) {
        	foreach ($this->system->input['cursos'] as $curso) {
		    	if ($this->system->curso->verificaCursoAtivo($this->system->input['aluno_id'], $curso)) {
		    		$dadosCurso = $this->system->curso->getCurso($curso);
					$retorno['msg'][] = 'O aluno já possui o curso ' . $dadosCurso['curso'] . '. Apenas poderá vende esse mesmo curso para este aluno quando seu acesso ao curso expirar.';		
					break;
				}
				if ($this->system->vendas->verificaCompraCursoAberta($this->system->input['aluno_id'], $curso)) {
					$dadosCurso = $this->system->curso->getCurso($curso);
					$retorno['msg'][] = 'O aluno já possui uma compra aberta com ' . $dadosCurso['curso'] . '. . Apenas poderá vende esse mesmo curso para este aluno, se ele cancelar a compra.';	
					break;
				}
			}
        }
		
		if ($this->system->session->getItem('session_nivel') == 1) {
			if (!$this->system->input['data_venda'])
	            $retorno['msg'][] = "O campo Data da Venda está vazio.";

	        if (!$this->system->input['data_expiracao'])
	            $retorno['msg'][] = "O campo Data de Expiração está vazio.";
    	}
		
		if (!$this->system->input['forma_pagamento'])
            $retorno['msg'][] = "Selecione a Forma de Pagamento.";
		
        if (count($retorno) > 0)
		   $retorno['msg'] = implode('<br/>', $retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	protected function docarregaDadosCertificados() {
		$data1 = $this->system->input['data1'];
		$data2 = $this->system->input['data2'];
		$curso_id = $this->system->input['curso_id'];
		
		if (!$data1 || !$data2)
			$data1 = $data2 = date('d/m/Y');
			
		$data1 = $this->system->func->converteData($data1);
		$data2 = $this->system->func->converteData($data2);
		
		if ($curso_id)
			$certificados['certificados'] = $this->system->certificados->relatorioPorCursos($curso_id, $data1 . ' 00:00:00', $data2 . ' 23:59:59');
		else
			$certificados['certificados'] = $this->system->certificados->relatorioPorPeriodo($data1 . ' 00:00:00', $data2 . ' 23:59:59');
		
		$certificados['mes_certificados'] = count($this->system->certificados->relatorioPorPeriodo(date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'));
		$certificados['total_certificados'] = $this->system->certificados->getTotalCertificados();
		echo json_encode($certificados);
	}
	// ===============================================================
	protected function docarregaDadosVendaCupons() {
		$data1 = $this->system->input['data1'];
		$data2 = $this->system->input['data2'];
		
		if (!$data1 || !$data2)
			$data1 = $data2 = date('d/m/Y');
			
		$data1 = $this->system->func->converteData($data1);
		$data2 = $this->system->func->converteData($data2);
		$cupons['total_vendas'] = $this->system->cupons->getTotalPedidosComCupom(" and (data_cadastro >= '".$data1." 00:00:00' and data_cadastro <= '".$data2." 23:59:59')");
		$cupons['total_cupons'] = $this->system->cupons->getTotalCupons(" and (data_cadastro >= '".$data1." 00:00:00' and data_cadastro <= '".$data2." 23:59:59')");
		$cupons['porcentagem'] = ($cupons['total_vendas'] / $this->system->vendas->getTotalPedidos(" and (data_cadastro >= '".$data1." 00:00:00' and data_cadastro <= '".$data2." 23:59:59')")) * 100;
		$cupons['mais_usados'] =  $this->system->cupons->getCuponsMaisUsados(" and (t1.data_cadastro >= '".$data1." 00:00:00' and t1.data_cadastro <= '".$data2." 23:59:59')");
		echo json_encode($cupons);
	}
	// ===============================================================
	protected function docarregaDadosVendaPorMaisVendidos() {
		$data1 = $this->system->input['data1'];
		$data2 = $this->system->input['data2'];
		
		if (!$data1 || !$data2)
			$data1 = $data2 = date('d/m/Y');
			
		$data1 = $this->system->func->converteData($data1);
		$data2 = $this->system->func->converteData($data2);
		$sql = " and (t2.data_cadastro >= '".$data1." 00:00:00' and t2.data_cadastro <= '".$data2." 23:59:59')";
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
		$ano = (int)$this->system->input['ano'];

		if (!$curso_id) return;
		
		$lista_produtos = array();
		$vendas_produtos = $this->system->vendas->getVendasPorCurso($curso_id, " and data_cadastro like '".$ano."-%'", 0);

		foreach($vendas_produtos as $item => $vendas) {
			$cursos = $this->system->vendas->getCursosByVenda($vendas['venda_id']);
			
			$totalProduto = 0;
			foreach ($cursos as $curso) {
				if ($curso['curso_id'] == $curso_id)
					$totalProduto = $curso['preco_total'];
			}

			$mes = substr($vendas['data_cadastro'], 5, 2);
			$lista_produtos[$mes]['mes'] = $mes;
			$lista_produtos[$mes]['total'] += $totalProduto;
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
		
		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;
		$sql = " and t1.data_cadastro like '".$ano."-".$mes."%'";
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
		
		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;
		
		$sql = " and t1.data_cadastro like '".$ano."-".$mes."%'";
		$ultimas_vendas = $this->system->vendas->getVendasTopConsumidores($sql, 0);
		foreach($ultimas_vendas as $key => $vendas) {
			$vendas_usuario = $this->system->vendas->getVendas("and aluno_id = '".$vendas['id']."' and data_cadastro like '".$ano."-".$mes."%'");
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
		$professor = (int)$this->system->input['professor'];
		
		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;

		$sql_mes = "  and status = 1 and data_cadastro like '".$ano."-".$mes."%'";

		if ($professor) 
			$sql_mes .= " and id IN (SELECT venda_id FROM `vendas_cursos` WHERE professor_id = '" . $professor . "')";
		

		$ultimas_10_vendas_mes = $this->system->vendas->getVendas($sql_mes, 0);
		
		foreach($ultimas_10_vendas_mes as $key => $vendas) {
			$ultimas_10_vendas_mes[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$produtos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
				$produtos[] = $curso_dados['curso'];
			}

			//Plano
			$plano = $this->system->vendas->getPlanoVenda($vendas['id']);
			$produtos[] = $plano['plano'];

			//Certificado
			$certificados = $this->system->vendas->getCertificadosVenda($vendas['id']);
			foreach ($certificados as $certificado) {
				$produtos[] = $certificado['curso']	;
			}

			$ultimas_10_vendas_mes[$key]['cursos'] = implode('<br/>', $produtos);
		}
                
		echo json_encode(array('ultimas_10_vendas_mes' => $ultimas_10_vendas_mes, 'total_vendas_mes' => $this->system->vendas->getTotalPedidos(" and data_cadastro like '" . $ano ."-" . $mes . "-%'")));
	}
	// ===============================================================
	protected function docarregaDadosVendaPorDia() {
		$data1 = $this->system->input['data1'];
		$data2 = $this->system->input['data2'];
		
		if (!$data1 || !$data2)
			$data1 = $data2 = date('d/m/Y');
		
		if ($data1 == $data2)
			$vendas_periodo = $data1;
		else
			$vendas_periodo = 'de ' . $data1 . ' até ' . $data2;
		
		$data1 = $this->system->func->converteData($data1);
		$data2 = $this->system->func->converteData($data2);
		$sql_dia = " and id in (SELECT venda_id FROM vendas_cursos) and (data_cadastro >= '".$data1." 00:00:00' and data_cadastro <= '".$data2." 23:59:59')";
		
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
	protected function doCarregaDadosAssinatura() {
		$ano = $this->system->input['ano'];
		$mes = $this->system->input['mes'];
		$this->system->load->dao('planos');
		if (!$ano)
			$ano = date('Y');
		if (!$mes)
			$mes = date('m');
		$tipoAssinatura = $this->system->input['tipo_assinatura'];

		if ($tipoAssinatura) { //assinaturas ativas
			$campo = "excluido = 0 and data_periodo like '" . $ano . "-" . $mes . "-%'";
			$assinaturas = $this->system->planos->getPlanosAluno($campo);
			
			$retorno = array();
			foreach($assinaturas as $assinatura) {
				$plano = $this->system->planos->getPlano($assinatura['plano_id']);
				$retorno[$assinatura['plano_id']]['plano'] = $plano['plano'];
				$retorno[$assinatura['plano_id']]['valor'] += $plano['valor'];
				$retorno[$assinatura['plano_id']]['total']++;
			}

			foreach($retorno as $plano) {
				 echo '<tr>';
				 echo '<td>' . $plano['plano'] . '</td>';
                 echo '<td class="center">' . $plano['total'] . '</td>';
                 echo '<td class="center">' . number_format($plano['valor'], 2, ',', '.') . '</td>';
                 echo '</tr>';
			}		

		} else { //assinaturas expiradas ou que vão expirar
			$campo = "data_expiracao like '" . $ano . "-" . $mes . "-%'";
			$assinaturas = $this->system->planos->getPlanosAluno($campo);
		
			foreach($assinaturas as $assinatura) {
				$aluno = $this->system->alunos->getAluno($assinatura['usuario_id']);
				$plano = $this->system->planos->getPlano($assinatura['plano_id']);
				
				echo '<tr>';
                echo '<td>' . $aluno['nome'] . '</td>';
                echo '<td>' . $aluno['email'] . '</td>';
                echo '<td>' . $plano['plano'] . '</td>';
                echo '<td class="center">' . date('d/m/Y', strtotime($assinatura['data_expiracao'])) .  '</td>';
                echo '</tr>';
			}
		}
	}
	// ===============================================================
	protected function doRelatorio() {
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('vendas'));
		$ultimas_10_vendas = $this->system->vendas->getVendas('', 10);
		foreach($ultimas_10_vendas as $key => $vendas) {
			$ultimas_10_vendas[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$cursos[] = end($this->system->curso->getCurso($curso['curso_id'], false));
			}

			//
			$plano = $this->system->vendas->getPlanoVenda($vendas['id']);
			$certificados = $this->system->vendas->getCertificadosVenda($vendas['id']);

			$ultimas_10_vendas[$key]['cursos']			= $cursos;
			$ultimas_10_vendas[$key]['plano'] 			= $plano;
			$ultimas_10_vendas[$key]['certificados'] 	= $certificados;
		}
		
		$this->system->view->assign(array(
			'professores'			=> $this->system->professores->getProfessores(),
			'data1'					=> date('d/m/Y'),
			'data2'					=> date('d/m/Y'),
			'mes'					=> date('m'),
			'ano'					=> date('Y'),
			'categorias'			=> $this->system->categorias->getCategorias(),
			'cursos'				=> $this->system->curso->getCursos(),
			'total_vendas' 			=> number_format($this->system->vendas->getTotalVendas(" and status = 1 and data_cadastro like '" . date('Y') ."-" . date('m') . "-%'"), 2, ',', '.'),
			'total_pedidos' 		=> $this->system->vendas->getTotalPedidos(" and data_cadastro like '" . date('Y') ."-" . date('m') . "-%'"),
			'total_itens_pedidos' 	=> $this->system->vendas->getTotalItensPedidos(" and t1.data_cadastro like '" . date('Y') ."-" . date('m') . "-%'"),
			'media_vendas' 			=> number_format(($this->system->vendas->getTotalVendas(" and status = 1 and data_cadastro like '" . date('Y') ."-" . date('m') . "-%'") / $this->system->vendas->getTotalPedidos(" and status = 1 and data_cadastro like '" . date('Y') ."-" . date('m') . "-%'")), 2, ',', '.'),
			'descontos_usados'		=> number_format($this->system->vendas->getTotalDescontosUsados(" and status = 1  and data_cadastro like '" . date('Y') ."-" . date('m') . "-%'"), 2, ',', '.'),
			'ultimas_10_vendas'		=> $ultimas_10_vendas
		));
		
		// pego todas as vendas do mês atual
		$sql = " and data_cadastro like '".date('Y-m')."%'";
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
			'valor_categoria_mais_vendida' 	=> $categoria[0]['total']
		));
		
		$lista_cadastro = array();
		$sql = " and data_cadastro like '".date('Y-m')."%'";
		$cadastros = $this->system->alunos->getCadastrosAlunos($sql);
		foreach($cadastros as $key => $cadastro) {
			$dia = substr($cadastro['data_cadastro'], 8, 2);
			$lista_cadastro[$dia]++;
		}
		ksort($lista_cadastro);
		$this->system->view->assign(array(
			'total_clientes' => $this->system->vendas->getTotalClientes(),
			'total_clientes_vendas' => $this->system->vendas->getTotalClientesVendas(),
			'total_clientes_cadastros' => $lista_cadastro
		));
		
		$this->system->view->display('global/vendas_relatorios.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doDetalhesVenda() {
		
		$id = (int)$this->system->input['id'];
		$venda = $this->system->vendas->getVenda($id);
		
		if ($this->system->session->getItem('session_nivel') == 5 && ($venda['parceiro_id'] != $this->system->session->getItem('session_cod_usuario')))
			$this->system->func->redirecionar('/vendas/todas');

		foreach($this->system->vendas->getCursosByVenda($venda['id']) as $curso) {
			$curso2 = $this->system->curso->getCurso($curso['curso_id'], true);
			$curso2['valor'] = number_format($curso['preco_total'], 2, ',', '.');
			$curso2['certificado'] = $curso['certificado'];


			if ($venda['status'] == 1) { //Pago
				$cursoAluno = end($this->system->curso->getCursosAlunos(" and curso_id = '" . $curso2['id'] . "' and usuario_id = '" . $venda['aluno_id'] . "'"));
				if ($cursoAluno['id']) { //Curso existe
					//Ativa 
					$this->system->load->dao('aulas');
					$totalAulas = $this->system->aulas->countAulasCurso($curso2['id']);
					$aulasAssistidas = $this->system->aulas->countAulasAssistidas($cursoAluno['id']);
					$curso2['completo'] = round(($aulasAssistidas/$totalAulas)*100);
				}
				else
					$curso2['completo'] = 0;
			} else 
				$curso2['completo'] = 0;	

			 $cursos[] = $curso2;
		}
		
		$botaoCancelar = false;
		if ($this->system->session->getItem('session_nivel') == 1 && $venda['status'] == 1)
			$botaoCancelar = true;
        
        $aluno = $this->system->alunos->getAluno($venda['aluno_id']);
        $pagseguro = $this->system->pagseguro->getTransacao($venda['id']);

		$this->system->view->assign(array(
			'total_pedido' 			=> number_format($venda['valor_total'], 2, ',', '.'),
			'id'					=> $venda['id'],
			'codigo_rastreamento' 	=> $venda['codigo_rastreamento'],
			'status' 				=> $venda['status'],
			'numero' 				=> $venda['numero'],
			'observacoes' 			=> $venda['observacoes'],
			'data_cadastro' 		=> $venda['data_cadastro'],
			'data_expiracao' 		=> $venda['data_expiracao'],
			'forma_pagamento' 		=> $venda['forma_pagamento'],
			'cursos'				=> $cursos,
			'plano'					=> $this->system->vendas->getPlanoVenda($venda['id']),
			'certificados' 			=> $this->system->vendas->getCertificadosVenda($venda['id']),
			'botaoCancelar'			=> $botaoCancelar,
            'botaoAtivar'			=> $venda['excluido'],
            'aluno'                 => $aluno,
            'pagseguro'             => $pagseguro
		));
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('vendas'));
		if ($this->system->session->getItem('session_nivel') == 6)
			$this->system->view->display('administrativo/vendas_detalhes.tpl');
		else
			$this->system->view->display('global/vendas_detalhes.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doCalcularPreco() {
		$cursos = $this->system->input['cursos'];
		$forma_desconto = $this->system->input['forma_desconto'];
		$desconto = $this->system->input['valor_desconto'];
		$preco = 0.00;
		
		if (count($cursos)) {
			foreach ($cursos as $curso) {
				$curso = $this->system->curso->getCurso($curso);
				if (!$curso['gratuito'] && $curso['valor'] != '0.00') {
					$preco += $curso['valor'];
				}

				//suporte
				if ($curso['suporte']) {
					$this->system->load->dao('configuracoesgerais');
					$suporteConfig = $this->system->configuracoesgerais->getProdutosSuporte();
					
					//Valor fixo
					if ($suporteConfig['produtos_suporte_tipo'] == 2) 
						$preco += $suporteConfig['produtos_suporte_valor'];
					
					//Porcentagem
					if ($suporteConfig['produtos_suporte_tipo'] == 3) {
						$valor = (($curso['valor'] * $suporteConfig['produtos_suporte_valor'])/100);
						$preco += $valor;
					}
				}
			}
		}
		switch($forma_desconto)  {
			case 1:
				$desconto = str_replace(',', '.', $desconto);
				$preco -= $desconto;
				break;
			case 2:
				$desconto = str_replace(',', '.', $desconto);
				$preco -= ($preco * $desconto) / 100;
				break;
		}
		$preco = number_format(round(max(0, $preco), 2), 2, '.', ',');
		echo $preco;
	}
	// ===============================================================
	protected function doLista() {

		//modos de busca
		$palavra = $this->system->session->getItem('palavra_busca');
		$metodo_busca = 'padrao';
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		else {
			$palavra = $this->system->input['palavra_busca'];
		//	$metodo_busca = $this->system->input['metodo_busca'];
		}

		//Paginação
		$pagina = ($this->system->input['pag'] ? $this->system->input['pag'] : 1);
		if ($palavra)
			$paginacao['base_url'] = $this->system->func->baseurl('/vendas/buscar&palavra_busca=' . $palavra);
		else
			$paginacao['base_url'] = $this->system->func->baseurl('/vendas/pedidos');
		$paginacao['per_page'] = $this->exibirPorPagina;
		$paginacao['total_rows'] = $this->system->vendas->getTotal($palavra, $metodo_busca);
		$paginacao['cur_page'] = $pagina;
		$this->system->pagination->initialize($paginacao);
		$this->system->view->assign('paginacao', $this->system->pagination->create_links());
		
		//Resultado
		$inicial = ($this->exibirPorPagina * ($pagina - 1));
		$final = $this->exibirPorPagina;
		$limit = $inicial . ',' . $final;


		$this->system->view->assign('vendas', $this->system->vendas->getPedidosBuscaVendas($palavra, $metodo_busca, $limit));			
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('vendas'));
		$this->system->view->display('global/vendas_pedidos_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doTodasVendas() {
		
		//modos de busca
		$palavra = trim($this->system->session->getItem('palavra_busca'));
		$metodo_busca = 'padrao';
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		else {
			$palavra = $this->system->input['palavra_busca'];
		}

		//Paginação
		$pagina = ($this->system->input['pag'] ? $this->system->input['pag'] : 1);
		if ($palavra)
			$paginacao['base_url'] = $this->system->func->baseurl('/vendas/buscar-vendas&palavra_busca=' . $palavra);
		else
			$paginacao['base_url'] = $this->system->func->baseurl('/vendas/todas');
		$paginacao['per_page'] = $this->exibirPorPagina;
		$paginacao['total_rows'] = $this->system->vendas->getTotal($palavra, $metodo_busca, 1);
		$paginacao['cur_page'] = $pagina;
		$this->system->pagination->initialize($paginacao);
		$this->system->view->assign('paginacao', $this->system->pagination->create_links());
		
		//Resultado
		$inicial = ($this->exibirPorPagina * ($pagina - 1));
		$final = $this->exibirPorPagina;
		$limit = $inicial . ',' . $final;		

		$todas_vendas = $this->system->vendas->getVendasBusca($palavra, $metodo_busca, $limit, 1);

		foreach($todas_vendas as $key => $vendas) {
			$todas_vendas[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);

			//cursos
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$cursos[] = end($this->system->curso->getCurso($curso['curso_id'], false));
			}

			$plano = $this->system->vendas->getPlanoVenda($vendas['id']);

			$certificados = $this->system->vendas->getCertificadosVenda($vendas['id']);

			$todas_vendas[$key]['cursos'] 		= $cursos;
			$todas_vendas[$key]['plano'] 		= $plano;
			$todas_vendas[$key]['certificados'] = $certificados;
		}
		
		$this->system->view->assign('pedidos', $todas_vendas);			
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('vendas'));
		$this->system->view->display('global/vendas_todas_listagem.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doAlterarPagamento() {
		$editar = $this->system->input['editar'];
		$vendaID = $this->system->input['venda_id'];
		$status = $this->system->input['status'];


		if ($editar) {
			$venda = $this->system->vendas->getVenda($vendaID);
			if ($venda['id'] && ($venda['status'] != 1)) {
				$this->system->vendas->alterarPagamento($vendaID, $status);
				echo "Pagamento atualizado";
				echo "<script type='text/javascript'>jQuery('.status_" . $vendaID . "').val('" . $status . "')</script>";
				if ($status == 0)
					$htmlTd = '<span class="label label-info"><i class="iconfa-calendar"></i> Aguardando Pagamento</span>';
				if ($status == 1) {
					$htmlTd = '<span class="label label-success"><i class="iconfa-ok"></i> Pago</span>';
					echo "<script type='text/javascript'>jQuery('.bota_venda_" . $vendaID . "').hide()</script>";
				} if ($status == 2) 
					$htmlTd = '<span class="label label-important"><i class="iconfa-remove"></i>Cancelado</span>';
				echo "<script type='text/javascript'>jQuery('.td_status_" . $vendaID . "').html('" . $htmlTd . "')</script>";
			} else {
				echo "Status da venda não pode ser alterado!";
			}
		}

		//Email
		$venda = $this->system->vendas->getVenda($vendaID);
		$this->system->email_model->alteradoStatusVendaAdministrativo($venda['numero']);
		///
		if ($status == 1) {

			//Email
			$this->system->email_model->vendaAprovadaAluno($venda['aluno_id'], $venda['numero'], date('d/m/Y'));

			//Adicionar Curso
			$dataExpiracao = date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d'), (date('Y') + 2)));
			$cursos = $this->system->vendas->getCursosVenda($vendaID);
			if (!empty($cursos)) {
				$this->system->curso->cadastrarCursosAluno($cursos, $venda['aluno_id'], $dataExpiracao);
				
				//Email Professor
				foreach ($cursos as $curso)
					$this->system->email_model->vendaCursoProfessor($curso['id'], $venda['numero']);	
			}

			//Adicionar plano
			$plano = $this->system->vendas->getPlanoVenda($venda['id']);
			if ($plano['id']) {
				$dataExpiracao = date('Y-m-d', mktime(0, 0, 0, (date('m') + $plano['meses']), date('d'), date('Y')));
				$this->system->planos->cadastrarPlanoAluno($plano['id'], $venda['aluno_id'], $venda['id'], $dataExpiracao);
			}
			$this->system->vendas->atualizar($venda['id'], array('data_expiracao' => $dataExpiracao));

			//liberar certificado
			$this->system->load->model('certificados_model');
			$certificados = $this->system->vendas->getCertificadosVenda($venda['id']);
			foreach ($certificados as $certificado)
				$this->system->certificados_model->gerarCertificadoImpresso($certificado['matricula_id']);

			//Email Certificado
			foreach ($certificados as $certificado) {
				$cursoAluno = end($this->system->curso->getCursosAlunos(" and usuario_id = '" . $venda['aluno_id'] . "' and id = '" . $certificado['matricula_id'] . "'"));
				$this->system->email_model->alteradoStatusCertificadoAluno($venda['aluno_id'], $cursoAluno['curso_id']);
			}
				
		}
		
	}
	// ===============================================================
	protected function doAlterarRastreamento() {
		$editar = $this->system->input['editar'];
		$vendaID = $this->system->input['venda_id'];
		$codigo_rastreamento = $this->system->input['codigo_rastreamento'];
		if ($editar) {
			$this->system->vendas->alterarRastreamento($vendaID, $codigo_rastreamento);
			echo "Rastreamento atualizado";
			echo "<script type='text/javascript'>jQuery('.codigo_rastreamento_" . $vendaID . "').val('" . $codigo_rastreamento . "')</script>";
			echo "<script type='text/javascript'>jQuery('.td_rastreamento_" . $vendaID . "').html('" . $codigo_rastreamento . "')</script>";
		}
	}
	// ===============================================================
	protected function doAlterarObservacoes() {
		$editar = $this->system->input['editar'];
		$vendaID = $this->system->input['venda_id'];
		$observacoes = $this->system->input['observacoes'];
		if ($editar) {
			$this->system->vendas->alterarObservacoes($vendaID, $observacoes);
			echo "Observações atualizadas";
			echo "<script type='text/javascript'>jQuery('.observacoes_" . $vendaID . "').val('" . $observacoes . "')</script>";
			echo "<script type='text/javascript'>jQuery('.td_observacoes_" . $vendaID . "').html('" . $observacoes . "')</script>";
		}
	}
	// ===============================================================
	protected function doBaixarComprovante() {
		$vendaID = $this->system->input['id'];
		if ($vendaID) {
			$venda = $this->system->vendas->getVenda($vendaID);	

			if ($venda['comprovante']) {
				$file = $this->system->getUploadPath() . '/comprovantes_alunos/' . $venda['comprovante'];
				header("Content-Disposition: attachment; filename=" . $venda['comprovante']);    
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header("Content-Description: File Transfer");             
				header("Content-Length: " . filesize($file));
				flush(); 

				$fp = fopen($file, "r"); 
				while (!feof($fp))	{
	    			echo fread($fp, 65536); 
	    			flush(); // this is essential for large downloads
				}  
				fclose($fp); 	
			}
		}
	}
	// ===============================================================
	protected function doBuscarPorAluno() {
		$alunoID = $this->system->input['aluno_id'];

		$todas_vendas = $this->system->vendas->getVendas(' and aluno_id = ' . $alunoID);

		$cliente = $this->system->alunos->getAluno($vendas['aluno_id']);
		foreach($todas_vendas as $key => $vendas) {
			
			//cursos
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$cursos[] = end($this->system->curso->getCurso($curso['curso_id'], false));
			}

			$plano = $this->system->vendas->getPlanoVenda($vendas['id']);

			$certificados = $this->system->vendas->getCertificadosVenda($vendas['id']);

			$todas_vendas[$key]['cursos'] 		= $cursos;
			$todas_vendas[$key]['plano'] 		= $plano;
			$todas_vendas[$key]['certificados'] = $certificados;
		}

		echo '<table class="table table-bordered" >';
		echo '<thead>';
		echo '<th>#</th>';
        echo '<th>Cursos</th>';
       	echo '<th class="center">Status</th>';
        echo '<th class="center">Data</th>';
        echo '<th class="center">Valor Total</th>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($todas_vendas as $pedido) {
        	echo '<tr>';
        	//Numero
        	echo '<td><a href="' . $this->system->getUrlSite() . 'lms/' . $this->system->admin->getCategoria() .  '/vendas/detalhes/' . $pedido['id'] . '">' . $pedido['numero'] . '</a></td>';
        	//Cursos
        	echo '<td>';
        		foreach ($pedido['cursos'] as $curso)
        			echo $curso['curso'] . '<br/>';
        		if ($pedido['plano']['id'])
        			echo $pedido['plano']['plano'];
        		foreach ($pedido['certificados'] as $certificado)
        			echo $certificado['curso'] . '<br/>';
        	echo '</td>';
        	//Status
        	echo '<td>';
        	if ($pedido['status'] == 0)
            	echo '<span class="label label-info"><i class="iconfa-calendar"></i> Aguardando Pagamento</span>';
            elseif ($pedido['status'] == 1)
                echo '<span class="label label-success"><i class="iconfa-ok"></i> Pago</span>';
            else
                echo '<span class="label label-important"><i class="iconfa-remove"></i>Cancelado</span>';
        	echo '</td>';
        	//Data
        	echo '<td class="center">' . date('d/m/Y', strtotime($pedido['data_cadastro'])) . '</td>';
        	//Preço
        	echo '<td class="center">' . number_format($pedido['valor_total'], 2, ',', '.') . '</td>';
        	echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
	}
	// ===============================================================
	public function doCancelar() {
		$id = $this->system->input['id'];
		$venda = $this->system->vendas->getVenda($id);
		$this->system->vendas->alterarPagamento($id, 2);

		$regerarDados = array();
		//cursos
		foreach($this->system->vendas->getCursosByVenda($id) as $curso) {
			$cursoAluno = end($this->system->curso->getCursosAlunos(" and curso_id = '" . $curso['curso_id'] . "' and usuario_id = '" . $venda['aluno_id'] . "'"));
			$this->system->curso->deleteCursoAluno($cursoAluno['id']);
			$regerarDados[] = $curso['professor_id'];
		}

		//planos
		$plano = $this->system->vendas->getPlanoVenda($venda['id']);
		if ($plano['id']) {
			$planoAluno = $this->system->planos->getPlanoAluno(" and usuario_id = '" . $venda['aluno_id'] . "' and plano_id = '" . $plano['id'] . "'");	
			if ($planoAluno['id'])
				$this->system->planos->desativarAssinatura($planoAluno['id']);
		}

		if (count($regerarDados) > 0) {
			list($ano, $mes, $dia) = explode('-', $venda['data_venda']);
			if (date('Y-m') != $ano.'-'.$mes) {
				$this->regerarComissaoProfessor($regerarDados, $mes, $ano);
			}
		}

		$this->system->func->redirecionar('/vendas/detalhes/' . $id);
	}
	// ===============================================================
	public function doReativar() {
		$id = $this->system->input['id'];
		$venda = $this->system->vendas->getVenda($id);
		if ($venda['id'])
			$this->system->vendas->atualizar($id, array('excluido' => 0));
		$this->system->func->redirecionar('/vendas/detalhes/' . $id);
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
	// EXCLUSIVO DE CANCELAR COMPRA 
	// =========================================================================================================
	private function regerarComissaoProfessor($professores = array(), $mes = 0, $ano = 0) {
		$this->system->load->dao('pagamentos');
		$this->system->load->dao('parceiros');
		foreach ($professores as $professor_id) {
			
			$totalReceber = 0;
			$percentualComissao = 0;

			$where = " and t2.status = 1 and t1.professor_id = '" . $professor_id . "' and t2.data_venda >= '" . $ano ."-". $mes . "-1' and t2.data_venda < '" . date('Y') . "-" . date('m') . "-1'";
			$vendas = $this->system->vendas->getVendasPorCursos($where);

			$percentualComissao = $this->system->professores->getValorExtra($professor_id, 'comissao');

			foreach($vendas as $key => $venda) {
				$venda = $this->system->vendas->getVenda($venda['venda_id']);

			 	//CURSOS
			 	$this->totalPreco = 0;
			 	$this->totalPrecoProfessor = 0;
			 	$cursos = array();
				foreach($this->system->vendas->getCursosByVenda($venda['id']) as $curso) {
			 		$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
			 		$this->totalPreco += $curso['preco_total'];
			 		if ($curso_dados['professor_id'] == $professor_id) 
			 			$this->totalPrecoProfessor += $curso['preco_comissao'];
			 	}

			 	////// TAXA //////
			 	//PagSeguro e MoIP
			 	$valorTaxas = $this->divisaoCustos($venda['valor_taxas']);
			 	
			 	////// CUPOM (SITE) ou DESCONTO (LMS) ////// 
			 	$valorCupom = 0;
			 	$valorDesconto = 0;
			 	if ($venda['cupom_id']) {
			 		
			 		$cupom = $this->system->cupons->getCupom($venda['cupom_id']);

			 		if ($cupom['tipo_desconto'] == 1) //Valor inteiro
			 			 $valorCupom = $this->divisaoCustos($cupom['valor']);
			 		else { //Porcentagem
			 			$porcentagemPaga = (100 - $cupom['valor']);
			 			$valorSemCupom = ((100 * $venda['valor_total'])/$porcentagemPaga);
			 			$valorCupom = $this->divisaoCustos($valorSemCupom - $venda['valor_total']);
			 		}
			 	} else 
	 				$valorDesconto = $this->divisaoCustos($venda['valor_desconto']);
			

			 	////// COMISSÃO PARCEIRO (DESCONTO) /////
			 	$valorComissaoParceiro = 0;
			 	if ($venda['parceiro_id']) {
			 		$comissaoParceiro = $this->system->parceiros->getValorExtra($venda['parceiro_id'], 'comissao');
			 		$valorComissaoParceiro = $this->divisaoCustos(($comissaoParceiro * $venda['valor_total'])/100);		 		
			 	}

			 	////// BRUTO //////
		 		$valorBruto = ($this->totalPrecoProfessor - $valorComissaoParceiro - $valorTaxas - $valorCupom - $valorDesconto);	 		
			 	
			 	////// LÍQUIDO //////
			 	$valorLiquido = (($percentualComissao * $valorBruto)/100);

			 	$totalReceber += $valorLiquido;
			}

			$pagamento = $this->system->pagamentos->getPagamento(" and t1.usuario_id = '" . $professor_id . "' and t1.mes_faturado = '" . $ano ."-". $mes . "-1'");
			if ($pagamento['id']) {
				$this->system->pagamentos->atualizar(array(
					'valor'				=> number_format($totalReceber, 2),
					'data_cadastro'		=> date('Y-m-d H:i:s'),
					),
					"id = '" . $pagamento['id'] . "'"
				);
			}
		}
	}
	// =======================================================================================================================================
	private function divisaoCustos($custo) {
		
		$porcentagem = ((100 * $totalPrecoProfessor) / $totalPreco);
		return (($custo * $porcentagem) / 100);
	}
}
// ===================================================================
