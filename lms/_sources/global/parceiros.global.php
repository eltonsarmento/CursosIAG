<?php
// ===================================================================
class ParceirosGlobal {
	// ===============================================================
	protected $system = null;
	private $redir = '';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('parceiros');
		$this->system->load->dao('curso');
		$this->system->load->dao('alunos');
		$this->system->load->dao('vendas');
		$this->system->load->dao('categorias');
		$this->system->load->dao('cupons');
		$this->system->load->dao('configuracoesgerais');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		
		if (in_array($this->system->session->getItem('session_nivel'), $this->acessoPermitido)) {
			switch($this->system->input['do']) {
				case 'listar': 	$this->doListar(); break;
				case 'novo': 	$this->doEdicao(); break;
				case 'editar': 	$this->doEdicao(); break;
				case 'apagar': 	$this->doDeletar(); break;
				case 'buscar':	$this->doListar(); break;
					
				case 'relatorio': 							$this->doRelatorio(); break;
				case 'carregaDadosVendaPorDia': 			$this->docarregaDadosVendaPorDia(); break;
				case 'carregaDadosVendaPorMes': 			$this->docarregaDadosVendaPorMes(); break;
				case 'carregaDadosVendaPorProdutos': 		$this->docarregaDadosVendaPorProdutos(); break;
				case 'carregaDadosVendaMaisVendidos': 		$this->docarregaDadosVendaPorMaisVendidos(); break;
				case 'carregaDadosVendaTopConsumidores': 	$this->docarregaDadosVendaTopConsumidores(); break;
				case 'carregaDadosVendaPorCategorias': 		$this->docarregaDadosVendaPorCategorias(); break;
				case 'carregaDadosVendaCupons': 			$this->docarregaDadosVendaCupons(); break;

				case 'fecharMes':							$this->doFecharMes(); break;

				case 'calcularQuantoRetornar':				$this->doCalcularQuantoRetornar();
				case 'enviarComprovante':					$this->doEnviarComprovante(); break;
				case 'comprovante':							$this->doListarComprovante(); break;
				case 'downloadComprovante':					$this->doDownloadComprovante(); break;
				default: 									$this->pagina404(); break;

			}
		} else {
			$this->pagina404();
		}
	}
	// ===============================================================
	protected function docarregaDadosVendaPorMaisVendidos() {
		$data1 = $this->system->input['data1'];
		$data2 = $this->system->input['data2'];
		$parceiro_id = $this->system->session->getItem('relatorio_parceiro_id');

		if (!$data1 || !$data2)
			$data1 = $data2 = date('d/m/Y');
			
		$data1 = $this->system->func->converteData($data1);
		$data2 = $this->system->func->converteData($data2);
		$sql = " and " . ($parceiro_id ? 't2.parceiro_id = ' . $parceiro_id : 't2.parceiro_id != 0') . " and (t2.data_cadastro >= '".$data1." 00:00:00' and t2.data_cadastro <= '".$data2." 23:59:59')";
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
		$parceiro_id = $this->system->session->getItem('relatorio_parceiro_id');
		if (!$curso_id) return;
		
		$lista_produtos = array();
		$vendas_produtos = $this->system->vendas->getVendasPorCurso($curso_id, " and " . ($parceiro_id? 't2.parceiro_id = ' . $parceiro_id : 't2.parceiro_id != 0') . " and t2.data_cadastro like '".date('Y')."-%'", 0);
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
		$parceiro_id = $this->system->session->getItem('relatorio_parceiro_id');

		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;
		$sql = " and " . ($parceiro_id? 't1.parceiro_id = ' . $parceiro_id : 't1.parceiro_id != 0') . " and t1.data_cadastro like '".$ano."-".$mes."%'";
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
		$parceiro_id = $this->system->session->getItem('relatorio_parceiro_id');

		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;
		
		$sql = " and " . ($parceiro_id? 't1.parceiro_id = ' . $parceiro_id : 't1.parceiro_id != 0') . " and t1.data_cadastro like '".$ano."-".$mes."%'";
		$ultimas_vendas = $this->system->vendas->getVendasTopConsumidores($sql, 0);
		foreach($ultimas_vendas as $key => $vendas) {
			$vendas_usuario = $this->system->vendas->getVendas("and " . ($parceiro_id? 'parceiro_id = ' . $parceiro_id : 'parceiro_id != 0') . " and aluno_id = '".$vendas['id']."' and data_cadastro like '".$ano."-".$mes."%'");
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
		$parceiro_id = $this->system->session->getItem('relatorio_parceiro_id');

		if (!$mes || !$ano) {
			$mes = date('m');
			$ano = date('Y');
		}
		elseif ($mes < 10) $mes = '0'.$mes;
		
		$sql_mes = " and " . ($parceiro_id? 'parceiro_id = ' . $parceiro_id : 'parceiro_id != 0') . " and data_cadastro like '".$ano."-".$mes."%'";
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
		$parceiro_id = $this->system->session->getItem('relatorio_parceiro_id');
		
		if (!$data1 || !$data2)
			$data1 = $data2 = date('d/m/Y');
		
		if ($data1 == $data2)
			$vendas_periodo = $data1;
		else
			$vendas_periodo = 'de ' . $data1 . ' até ' . $data2;
		
		$data1 = $this->system->func->converteData($data1);
		$data2 = $this->system->func->converteData($data2);
		$sql_dia = " and " . ($parceiro_id? 'parceiro_id = ' . $parceiro_id : 'parceiro_id != 0') . " and (data_cadastro >= '".$data1." 00:00:00' and data_cadastro <= '".$data2." 23:59:59')";
		
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
		
		$parceiro_id = $this->system->input['id'];
		
		
		if ($parceiro_id) {
			$sql_extra = 'and parceiro_id = ' . $parceiro_id;	
			$this->system->session->addItem('relatorio_parceiro_id', $parceiro_id);
		} else {
			$sql_extra = 'and parceiro_id != 0';	
			$this->system->session->deleteItem('relatorio_parceiro_id');
		}

		$this->system->admin->topo(5);
		$ultimas_10_vendas = $this->system->vendas->getVendas($sql_extra, 10);
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
			'data1'				=> date('d/m/Y'),
			'data2'				=> date('d/m/Y'),
			'mes'				=> date('m'),
			'ano'				=> date('Y'),
			'categorias'		=> $this->system->categorias->getCategorias(),
			'cursos'			=> $this->system->curso->getCursos(),
			'total_vendas' 		=> number_format($this->system->vendas->getTotalVendas($sql_extra), 2, ',', '.'),
			'total_retornar'	=> number_format($this->system->vendas->getTotalRetorno($sql_extra), 2, ',', '.'),
			'total_pedidos' 	=> $this->system->vendas->getTotalPedidos($sql_extra),
			'media_vendas' 		=> number_format(($this->system->vendas->getTotalVendas($sql_extra) / $this->system->vendas->getTotalPedidos($sql_extra)), 2, ',', '.'),
			'descontos_usados'	=> number_format($this->system->vendas->getTotalDescontosUsados($sql_extra), 2, ',', '.'),
			'ultimas_10_vendas'	=> $ultimas_10_vendas,
		));
		
		// pego todas as vendas do mês atual
		$sql =  $sql_extra . " and data_cadastro like '".date('Y-m')."%'";
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
			'valor_categoria_mais_vendida' 	=> number_format($categoria[0]['total'], 2, ',', '.'),
			'parceiros'						=> $this->system->parceiros->getParceiros(),
			'url_site'						=> $this->system->getUrlSite(),
			'parceiro_id'					=> $parceiro_id,
		));
		$this->system->view->display('administrador-geral/parceiros_relatorios.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doEdicao() {
		$id = intval($this->system->input['id']);
		$editar = intval($this->system->input['editar']);
		if ($editar) {
			$erro_msg = $this->validarDados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->input['avatar'] = $this->system->input['visualizar_avatar'];
				$this->system->view->assign('parceiro', $this->system->input);
			} else {
				//Salvar
				if ($id) {
					$this->system->parceiros->atualizar($this->system->input);
					$this->system->view->assign('msg_alert', 'Parceiro atualizado com sucesso!');
				} else {
					$id = $this->system->parceiros->cadastrar($this->system->input);
					$this->system->view->assign('msg_alert', 'Parceiro cadastrado com sucesso!');

					//Email Cadastro
					$this->system->email_model->cadastroParceiro($this->system->input['email'], $this->system->input['nome'], $this->system->input['senha']);
				}
				
				//Img banner
				if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
					$extensao = end(explode('.', $_FILES['avatar']['name']));
					$nomearquivo = 'avatar_'.$id.'.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/avatar/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/avatar/'.$nomearquivo);
					copy($_FILES['avatar']['tmp_name'], $this->system->getUploadPath().'/avatar/'.$nomearquivo);
					$this->system->parceiros->atualizarImagem($id, $nomearquivo);
				}
				
				
				$this->doListar();
				exit();
			}
		} else {
			//Carregar conteudo
			if ($id) 
			    $this->system->view->assign('parceiro', $this->system->parceiros->getParceiro($id, true));
		}
		
		//Listar conteudo cadastrado
		$this->limit = 10;
		$this->listagem();
		
		$this->system->admin->topo(5);
		$this->system->view->display('administrador-geral/parceiros_edicao.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function validarDados() {
		$retorno = array();
        //Nome
        if($this->system->input['nome'] == '') 
            $retorno['msg'][] = "O campo Nome está vázio.";
			
		//Contato
        if($this->system->input['contato'] == '') 
            $retorno['msg'][] = "O campo Contato está vázio.";

        //Data de nascimento
        //if($this->system->input['data_nascimento'] == '') 
        //    $retorno['msg'][] = "O campo Data de Nascimento está vázio.";
        //elseif (!$this->system->func->checkDate($this->system->input['data_nascimento'], false))
        //	$retorno['msg'][] = "O campo Data de Nascimento é inválido.";
       
		//CPF
        // if ($this->system->input['cpf'] == '' && $this->system->input['cnpj'] == '')
        // 	$retorno['msg'][] = "O campo CPF OU CNPJ não pode está vázio";
        if ($this->system->input['cpf'] && !$this->system->func->validaCPF($this->system->input['cpf']))
        	$retorno['msg'][] = "O campo CPF é inválido.";
		elseif ($this->system->input['cnpj'] && !$this->system->func->validaCNPJ($this->system->input['cnpj']))
        	$retorno['msg'][] = "O campo CNPJ é inválido.";
        
        //Endereço
        if ($this->system->input['endereco'] == '')
        	$retorno['msg'][] = "O campo Endereço esta vázio";
			
        //Bairro
        if ($this->system->input['bairro'] == '')
        	$retorno['msg'][] = "O campo Bairro esta vázio";
			
        //Cidade
        if ($this->system->input['cidade'] == '')
        	$retorno['msg'][] = "O campo Cidade esta vázio";
			
        //Estado
        if ($this->system->input['estado'] == '')
        	$retorno['msg'][] = "O campo Estado esta vázio";
			
        //CEP
        if ($this->system->input['cep'] == '')
        	$retorno['msg'][] = "O campo CEP esta vázio";
			
		//Razão Social
        if($this->system->input['razao_social'] == '') 
            $retorno['msg'][] = "O campo Razão Social está vázio.";

        //Comissão
        
        if (!$this->system->input['comissao'])
        	$retorno['msg'][] = "O campo comissão está vázio.";
        elseif (!$this->system->func->isInt($this->system->input['comissao']))
        	$retorno['msg'][] = "O campo comissão deve ser um inteiro.";
        elseif ($this->system->input['comissao'] < 0 || $this->system->input['comissao'] > 100)
        	$retorno['msg'][] = "O campo comissão deve maior que 0 e menor que 100.";
		
        //Email
        if ($this->system->input['email'] == '')
        	$retorno['msg'][] = "O campo E-mail esta vázio";
        elseif(!$this->system->func->checkEmail($this->system->input['email']))
        	$retorno['msg'][] = "O campo E-mail é inválido";
         elseif($this->system->parceiros->checkEmailCadastrado($this->system->input['id'], $this->system->input['email']))
        	$retorno['msg'][] = "Já existe um usuário cadastrado com esse e-mail";

        //Email Secundário
        if($this->system->input['email_secundario'] && !$this->system->func->checkEmail($this->system->input['email_secundario']))
        	$retorno['msg'][] = "O campo E-mail Secundário é inválido";
        
        //Senha
        if ($this->system->input['id'] == '') {
	        if ($this->system->input['senha'] == '')
	        	$retorno['msg'][] = "O campo Senha esta vázio";
	        elseif (strlen($this->system->input['senha']) < 5)
	        	$retorno['msg'][] = "O campo Senha deve ter pelo menos 5 digitos.";
	    }
        //Dados Bancarios
        if ($this->system->input['agencia1'] == '' || $this->system->input['banco1'] == '' || $this->system->input['conta1'] == '' || $this->system->input['tipoconta1'] == 0  || $this->system->input['operacao1'] == '')
        	$retorno['msg'][] = "O campo Dados Bancario 1 deve ser verificado";
		
        //Arquivo destaque
		if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
			$extensao = end(explode('.', $_FILES['avatar']['name']));
			if (in_array($extensao, array('jpg', 'gif', 'png'))) {
				$configPerfil = $this->system->configuracoesgerais->getImagensPerfil();

				if (($_FILES['avatar']['size'] / 1024) > $configPerfil['imagem_perfil_tamanho']) {
					$retorno['msg'][] = 'A Imagem do destaque está com mais de ' . $configPerfil['imagem_perfil_tamanho'] . 'kb';
				}
			} else {
				$retorno['msg'][] = 'Formato de Imagem do destaque inválido';
			}
		}
		
		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	protected function doListar() {
		$this->listagem();
		$this->system->admin->topo(5);
		$this->system->view->display('administrador-geral/parceiros_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function listagem() {
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');
		$parceiros = $this->system->parceiros->getParceiros($palavra, $this->limit);
		foreach ($parceiros as $key => $professor) {
			$parceiros[$key]['email_secundario'] = $this->system->parceiros->getValorExtra($professor['id'], 'email_secundario');
			$parceiros[$key]['cpf'] = $this->system->parceiros->getValorExtra($professor['id'], 'cpf');
			$parceiros[$key]['cnpj'] = $this->system->parceiros->getValorExtra($professor['id'], 'cnpj');
			$parceiros[$key]['razao_social'] = $this->system->parceiros->getValorExtra($professor['id'], 'razao_social');
			$parceiros[$key]['contato'] = $this->system->parceiros->getValorExtra($professor['id'], 'contato');
			$parceiros[$key]['endereco'] = $this->system->parceiros->getValorExtra($professor['id'], 'endereco');
			$parceiros[$key]['bairro'] = $this->system->parceiros->getValorExtra($professor['id'], 'bairro');
			$parceiros[$key]['cidade'] = $this->system->parceiros->getValorExtra($professor['id'], 'cidade');
			$parceiros[$key]['estado'] = $this->system->parceiros->getValorExtra($professor['id'], 'estado');
			$parceiros[$key]['contato'] = $this->system->parceiros->getValorExtra($professor['id'], 'contato');
			$parceiros[$key]['cep'] = $this->system->parceiros->getValorExtra($professor['id'], 'cep');
			$parceiros[$key]['banco1'] = $this->system->parceiros->getValorExtra($professor['id'], 'banco1');
			$parceiros[$key]['agencia1'] = $this->system->parceiros->getValorExtra($professor['id'], 'agencia1');
			$parceiros[$key]['conta1'] = $this->system->parceiros->getValorExtra($professor['id'], 'conta1');
			$parceiros[$key]['tipoconta1'] = $this->system->parceiros->getValorExtra($professor['id'], 'tipoconta1');
			$parceiros[$key]['operacao1'] = $this->system->parceiros->getValorExtra($professor['id'], 'operacao1');
		}
		$this->system->view->assign('parceiros', $parceiros);
		$this->system->view->assign('url_site', $this->system->getUrlSite());
	}
	// ===============================================================
	protected function doDeletar() {
		$id = intval($this->system->input['id']);
		if ($id) {
			$parceiro = $this->system->parceiros->getParceiro($id);
			if($parceiro['nivel'] == 5) {
				$this->system->parceiros->deletar($id);
				$this->system->view->assign('msg_alert', 'Parceiro excluído com sucesso!');
			} else {
				$this->system->view->assign('msg_alert', 'Não foi possível excluir esse usuário!');	
			}
		}
		$this->doListar();
	}
	// ===============================================================
	protected function doTodasVendas() {
		
		$todas_vendas = $this->system->vendas->getVendas();
		foreach($todas_vendas as $key => $vendas) {
			$todas_vendas[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
				$cursos[] = $curso_dados['curso'];
			}
			$todas_vendas[$key]['cursos'] = implode('<br/>', $cursos);
		}
		$this->system->view->assign('pedidos', $todas_vendas);			
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('vendas'));
		$this->system->view->display('global/vendas_todas_listagem.tpl');
		$this->system->admin->rodape();
	}
	// ==============================================================
	protected function doCalcularQuantoRetornar() {
		$data = $this->system->input['data'];
		
		if ($data) {
			list($mes, $ano) = explode('/', $data);
			if (!checkdate($mes, 1, $ano)) 
				echo 'Data Inválida';
			elseif(!$comprovante = $this->system->vendas->getComprovante("and parceiro_id = '" . $this->system->session->getItem('session_cod_usuario') . "' and mes = '" . $mes . "' and ano = '" . $ano . "'")) 
				echo 'Periodo não disponível.';
			else
				echo 'R$ ' .number_format($comprovante['total'], 2, ',', '.');
		}
	}

	// ===============================================================
	protected function doEnviarComprovante() {
		$enviar = $this->system->input['enviar'];
		$data = $this->system->input['data'];
		$observacao = $this->system->input['observacao'];
		$parceiro_id = $this->system->session->getItem('session_cod_usuario');
		
		if ($enviar) {
			list($mes, $ano) = explode('/', $data);
			if (!checkdate(intval($mes), 1, intval($ano))) 
				echo 'Data Inválida';
			elseif(!$comprovante = $this->system->vendas->getComprovante("and parceiro_id = '" . $this->system->session->getItem('session_cod_usuario') . "' and mes = '" . $mes . "' and ano = '" . $ano . "'")) 
				echo 'Periodo não disponível.';
			elseif (!is_uploaded_file($_FILES['comprovante']['tmp_name']))
				echo 'Selecione um arquivo';
			else {
				$extensao = end(explode('.', $_FILES['comprovante']['name']));
				
				if (in_array($extensao, array('jpg', 'jpeg', 'pdf'))) {
					$nomearquivo = 'comprovante_parceiro_' . $parceiro_id . '_'  . $ano . '_' . $mes . '_' . rand(1, 100) . '.' . $extensao;
					// if (file_exists($this->system->getUploadPath().'/comprovantes_pagamentos/'.$nomearquivo))
					//  	unlink($this->system->getUploadPath().'/comprovantes_pagamentos/'.$nomearquivo);
					copy($_FILES['comprovante']['tmp_name'], $this->system->getUploadPath().'/comprovantes_pagamentos/'.$nomearquivo);
					$this->system->vendas->enviarComprovante($parceiro_id, $nomearquivo, $observacao, $mes, $ano);

					echo 'Comprovante referente ao período: ' . $data . ' foi enviado';
				} else {
					echo 'Formato de comprovante deve ser PDF ou JPEG/JPG';
				}
			}
		}
	}
	// ==============================================================
	protected function doFecharMes() {

		$dia = date('d');
		$mes = date('m', mktime(0, 0, 0, (date('m')-1), 1, date('Y')));
		$ano = date('Y', mktime(0, 0, 0, (date('m')-1), 1, date('Y')));

		//if ($dia == 1) {
			$this->system->load->dao('parceiros');
			$this->system->load->dao('vendas');
			$this->system->load->model('email_model');

			$parceiros = $this->system->parceiros->getParceiros();	
			$emails = array();
			foreach ($parceiros as $key => $parceiro) {
				$totalRetornar = 0;
				$percentualComissao = 0;

				$percentualComissao = $this->system->parceiros->getValorExtra($parceiro['id'], 'comissao');
				$totalVendas = number_format($this->system->vendas->getTotalVendas("and status = 1 and data_venda like '" . $ano . '-' . $mes . "%' and parceiro_id = " . $parceiro['id']), 2, '.', '.');
				$comissao = ($totalVendas * $percentualComissao / 100);

				$totalRetornar = number_format(($totalVendas - $comissao), 2, '.','');
				
				$comprovante = $this->system->vendas->getComprovante(" and parceiro_id = '" . $parceiro['id'] . "' and mes = '" . $mes . "' and ano = '" . $ano . "'");
				if (!$comprovante['id']) {
					$this->system->vendas->cadastrarComprovante($parceiro['id'], $totalRetornar, $mes, $ano);

					$usuarioEmail = array();
					$usuarioEmail['nome'] = $parceiro['nome'];
					$usuarioEmail['email'] = $parceiro['email'];
					$emails[] = $usuarioEmail;
				}
			}


			foreach ($emails as $value) 
				$this->system->email_model->relatorioFechado($value['email'], $value['nome'], $mes, $ano);
		//}

		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('vendas'));
		$this->system->view->display('global/parceiros_relatorios_fechado.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doListarComprovante() {} //Codigo na classe parceiros de Parceiro
	// ===============================================================
	protected function doDownloadComprovante() {
		$id = $this->system->input['id'];
		if ($id) {
			$comprovante = $this->system->vendas->getComprovante(" and id = '" . $id . "'");
			if ($comprovante['comprovante']) {
				$file = $this->system->getUploadPath() . '/comprovantes_pagamentos/' . $comprovante['comprovante'];
				header("Content-Disposition: attachment; filename=" . $comprovante['comprovante']);    
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
	protected function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================