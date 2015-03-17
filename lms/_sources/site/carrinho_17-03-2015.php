<?php
// ===================================================================
class Carrinho {
	// ===============================================================
	protected $system = null;
	private $tituloPagina = 'Carrinho';
	
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('curso');
		$this->system->load->dao('planos');
		$this->system->load->dao('vendas');
		$this->system->load->dao('cupons');
		$this->system->load->dao('moip');
		$this->system->load->model('email_model');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'ver':				$this->doVer(); break;
			case 'adicionarCurso':		$this->doAdicionarCurso(); break;
			case 'adicionarPlano':		$this->doAdicionarPlano(); break;
			case 'adicionarCupom':		$this->doAdicionarCupom(); break;
			case 'removerCarrinho':		$this->doRemoverCarrinho(); break;
			case 'removerCupom':		$this->doRemoverCupom(); break;
			case 'verificaLogin':			$this->doVerificaLogin(); break;
			case 'verificaCompra':		$this->doVerificaCompra(); break;
			case 'iniciarMoip':			$this->doIniciarMoip(); break;
			case 'pagamento':			$this->doPagamento(); break;
			case 'cancelar':			$this->doCancelar(); break;
			case 'assinar':			$this->doAssinar(); break;
			/*case 'concluirGratuito': 	$this->doConcluirGratuito();break*/
			case 'concluirAssinatura':		$this->doConcluirAssinatura(); break;
			case 'concluirPagSeguro':		$this->doConcluirPagSeguro(); break;
			case 'concluirPagarme':		$this->doConcluirPagarme(); break;
			case 'confirmacao':			$this->doConfirmacao(); break;
			default: 				$this->pagina404(); break;
		}	
	}
	// ===============================================================
	protected function doVer() {
		$editar = $this->system->input['editar'];
		$carrinho = $this->system->session->getItem('carrinho_produtos');
		$cupom = $this->system->session->getItem('carrinho_cupom');
		$this->system->session->deleteItem('carrinho_total');
		$produtos = array();
		$total = 0;

		//Se for valor fixo, tem que pegar o valor total dos itens que usará cupom, para dividir o desconto igual entre os itens.
		if ($cupom['id'] && $cupom['tipo_desconto'] == 1) {
			$totalComDesconto = 0; //Total do preço dos itens que usam desconto
			
			foreach ($carrinho as $key => $item) 
				if ($item['tipo'] == 'curso') {
					if ($this->checkCupomCurso($cupom, $item['id'])) 
						$totalComDesconto += $item['valorTotal'];
				}
		}

		foreach ($carrinho as $key => $item) {
			$produto = array();
			if ($item['tipo'] == 'curso') {
				//Preco 
				if ($cupom['id']) {

					if ($this->checkCupomCurso($cupom, $item['id'])) {
						$valorDesconto = 0;
						
						//Fixo
						if ($cupom['tipo_desconto'] == 1) {
							$valorDesconto = number_format($this->system->func->divisaoCusto($totalComDesconto, $item['valorTotal'], $cupom['valor']), 2, '.', '');
						} else { //Porcentagem
							$valorDesconto = number_format((($item['valorTotal'] * $cupom['valor'])/ 100), 2, '.', '');
						}
						$item['valorTotal']-= $valorDesconto;
						$item['valorTotal'] = max(0, $item['valorTotal']);
					}
				}


				$total += $item['valorTotal'];

				$produto['produto'] 	= $item['curso'];
				$produto['preco']		= number_format($item['valor'], 2, ',', '.');
				$produto['precoTotal']	= number_format($item['valorTotal'], 2, ',', '.');
				$produto['imagem']		= $item['destaque_arquivo'];
				$produto['tipo'] 		= 'curso';
				$produto['id'] 			= $item['id'];
				$produto['url']			= $item['url'];
			}
			if ($item['tipo'] == 'plano') {
				//Preco 
				$total += $item['valor'];

				$produto['produto'] 	= $item['plano'];
				$produto['preco']		= number_format($item['valor'], 2, ',', '.');
				$produto['precoTotal']	= number_format($item['valor'], 2, ',', '.');
				$produto['imagem']		= $item['imagem_arquivo'];
				$produto['tipo'] 		= 'plano';
				$produto['id'] 			= $item['id'];	
			}

			$produtos[$key] = $produto;
		}
		//Cupom
		// if ($cupom['id']) {
		// 	if  ($cupom['tipo_desconto'] == 1) {
		// 		$total = max(0, ($total - $cupom['valor']));
		// 	} else {
		// 		$total -= ($total * $cupom['valor'])/100;
		// 		$total = max(0, $total);
		// 	}
		// }

		$this->system->session->addItem('carrinho_total', $total);

		//msg erro
		$msg_error = $this->system->session->getItem('msg_error');
		$this->system->session->deleteItem('msg_error');

		if ($this->system->session->getItem('session_cod_usuario'))
			$assinante = $this->system->planos->verificaAssinaturaAtiva(' and usuario_id = ' . $this->system->session->getItem('session_cod_usuario'));
		
		//exibir
		$this->system->view->assign('produtos', $produtos);
		$this->system->view->assign('total', number_format($total, 2, ',', '.'));
		$this->system->view->assign('msg_error', $msg_error);	
		$this->system->view->assign('msg_success', $msg_success);	
		$this->system->view->assign('cupom', $cupom);
		$this->system->view->assign('assinante', $assinante);
		$this->system->site->topo($this->tituloPagina);
		$this->system->view->display('site/carrinho.tpl');
		$this->system->site->rodape(array('newsletter' => 1, 'tipo_conteudo' => 'Página', 'conteudo' => 'Carrinho'));
	}
	// ==============================================================
	protected function doAdicionarCurso() {
		$this->system->load->dao('configuracoesgerais');
		$suporteConfig = $this->system->configuracoesgerais->getProdutosSuporte();
		$certificadoConfig = $this->system->configuracoesgerais->getProdutosCertificados();

		$curso_id = $this->system->input['id'];
		$certificado = $this->system->input['certificado'];
		$suporte = $this->system->input['suporte'];
		$produto = $this->system->curso->getCursoCondicao(" and id = $curso_id and home = 1");
		$categorias = $this->system->curso->getCategoriaCarreiraByCurso($curso_id);

		if (count($categorias)) {
			$produto['categorias'] = $categorias;
		}


		//calcular o valor total (curso + certificado + suporte)
		if ($produto['gratuito']) {
			$produto['valor'] = 0.00;
			$produto['suporte'] = 0;
		}
		$produto['valorTotal'] = $produto['valor'];
		
		//certificado
		if ($certificadoConfig['produtos_certificado_tipo'] != 0 && $produto['certificado'] != 0) { // 0 = não tem
			$produto['certificado'] = $certificado;	
			if ($certificado)  //Escolheu com certificado
				$produto['valorTotal'] += ($certificadoConfig['produtos_certificado_tipo'] == 2 ? $certificadoConfig['produtos_certificado_valor'] : 0 ); // 2 = valor fixo | 1 = de graça
		} else {
			$produto['certificado'] = 0;
		}
		
		//suporte
		if ($suporteConfig['produtos_suporte_tipo'] != 0 && $produto['suporte'] != 0 ) { // 0 = não tem
			$produto['suporte']	= (isset($suporte)? $suporte : 1);
			if ($produto['suporte']) {
				if ($suporteConfig['produtos_suporte_tipo'] == 2) //valor fixo
					$produto['valorTotal'] += $suporteConfig['produtos_suporte_valor']; 
				if ($suporteConfig['produtos_suporte_tipo'] == 3) //valor fixo
					$produto['valorTotal'] += (($produto['valor'] * $suporteConfig['produtos_suporte_valor']) / 100); 
			}
		} else {
			$produto['suporte']	= 0;
		}
		//tipo
		$produto['tipo'] = 'curso';

		//Adicionar ao carrinho
		$produtos = $this->system->session->getItem('carrinho_produtos');
		$produtos[] = $produto;
		$this->system->session->addItem('carrinho_produtos', $produtos);	
		$this->redirecionarCarrinho();
	}
	// ==============================================================
	protected function doRemoverCarrinho() {
		$key = $this->system->input['id'];
		$produtos = $this->system->session->getItem('carrinho_produtos');
		unset($produtos[$key]);
		$this->system->session->addItem('carrinho_produtos', $produtos);	
		$this->redirecionarCarrinho();	
	}
	// ==============================================================
	protected function doAdicionarPlano() {
		$plano_id = $this->system->input['id'];
		
		$produto = $this->system->planos->getPlano($plano_id);
		if ($produto['status']) {
			//tipo
			$produto['tipo'] = 'plano';

			//Adicionar ao carrinho
			$produtos = $this->system->session->getItem('carrinho_produtos');
			$produtos[] = $produto;
			$this->system->session->addItem('carrinho_produtos', $produtos);		
		}
		
		$this->redirecionarCarrinho();
	}
	// ==============================================================
	protected function doAdicionarCupom() {
		$cupom = $this->system->input['cupom'];

		$cupom = $this->system->cupons->getCupomCondicao(" and nome = '" . $cupom . "'");
		$cupomCarrinho = $this->system->session->getItem('carrinho_cupom');		

		if ($cupomCarrinho['id']) 
			$msg_error = 'Você já esta usando um cupom';		
		elseif (!$cupom['id'] || !$cupom['ativo']) 
			$msg_error = 'Cupom inválido';		
		elseif ($cupom['ativo'] == 2) //Usado
			$msg_error = 'Esse cupom já foi usado';		
		elseif ($cupom['tipo'] == 2) {
			if ($cupom['tempo_de'] > date('Y-m-d') || $cupom['tempo_ate'] < date('Y-m-d'))
				$msg_error = 'Cupom fora do prazo de uso';		
		}

		if ($msg_error) 
			$this->system->session->addItem('msg_error', $msg_error);		
		else 
			$this->system->session->addItem('carrinho_cupom', $cupom);		
		$this->redirecionarCarrinho();
	}
	// ==============================================================
	protected function doRemoverCupom() {
		$this->system->session->deleteItem('carrinho_cupom');		
		$this->redirecionarCarrinho();		
	}
	// ==============================================================
	protected function doVerificaLogin() {
		if ($this->system->session->getItem('session_logged_in') && $this->system->session->getItem('session_nivel') == 4) {
			session_write_close();
			header('Location: ' . $this->system->getUrlSite() . 'carrinho/verificaCompra/');
			exit();
		}

		//msg sucesso
		if ($msg_success = $this->system->session->getItem('msg_success')) {
			$this->system->session->deleteItem('msg_success');			
			$this->system->view->assign('msg_success', $msg_success);	
		}
		
		
		$enviar = $this->system->input['enviar'];
		$email = $this->system->input['email'];
		$senha = $this->system->input['senha'];
		if ($enviar) {
			$this->system->load->dao('login');
		    $dados = $this->system->login->getLoginDao($email, $senha);
			if ($dados) {
				$this->system->session->addItem('session_logged_in', 	true);
				$this->system->session->addItem('session_cod_usuario', 	$dados->id);
				$this->system->session->addItem('session_nome', 		$dados->nome);
				$this->system->session->addItem('session_email', 		$dados->email);
				$this->system->session->addItem('session_avatar', 		$dados->avatar);
				$this->system->session->addItem('session_nivel', 		$dados->nivel);
				$this->system->session->addItem('session_themecss', 	$dados->themecss);

				$categorias = $this->system->arrays->getArrayCategorias();
				$this->system->session->addItem('session_nivel_categoria', $categorias[$dados->nivel]);
				$this->system->login->updateEntrada();

				//$this->system->session->addItem('manter_logado', $dados->id, true);
				setcookie("cookie_cod_usuario", $dados->id, 0, '/', '.cursosiag.com.br'); 
				 
		       	
		       	if ($this->system->planos->verificaAssinaturaAtiva(' and usuario_id = ' . $this->system->session->getItem('session_cod_usuario'))) {
		       		session_write_close();
			        	header('Location: ' . $this->system->getUrlSite() . 'carrinho/ver/');
			        	exit();
		       	}
		        else {
		        	session_write_close();
		        	header('Location: ' . $this->system->getUrlSite() . 'carrinho/verificaCompra/');
		        	exit();
		        }
				exit();
			} else {
				$this->system->view->assign('msg_error', 'Login ou senha inválida');	
			}
		}

		//exibir
		$this->system->site->topo($this->tituloPagina);
		$this->system->view->display('site/verifica_login.tpl');
		$this->system->site->rodape();	
	}
	// ==============================================================
	protected function doVerificaCompra() {
		//Erros
		if (!$carrinho = $this->system->session->getItem('carrinho_produtos')) {
			$msg_error = 'É preciso ter ao menos algum item no carrinho';
		} else {
			$cupom = $this->system->session->getItem('carrinho_cupom');
			$curso = false;
			$plano = false;
			$cursosCarrinho = array();
			foreach ($carrinho as $produto) {

				if ($produto['tipo'] == 'curso') {
					if (count($produto['categorias'])) {
						
						$campos = " and usuario_id = ". $this->system->session->getItem('session_cod_usuario') ."";
						$planos = $this->system->planos->verficaAssinaturaPremium($campos);
						
						if ($produto['categorias']['carreira']) {
							if (!$planos['qtd']) {
								$msg_error = 'O curso '. $produto['curso'] .' só está disponível para assinatura premium.';		
								break;	
							}
							
						}
					}
					if ($plano == true) {
						$msg_error = 'Deve-se apenas comprar curso ou assinatura, não podendo comprar os dois ao mesmo tempo.';		
						break;
					}
					if ($this->system->planos->verificaAssinaturaAtiva(' and usuario_id = ' . $this->system->session->getItem('session_cod_usuario')) && $curso == true) {
						$msg_error = 'Você possui um plano. Para trocar/assinar um novo curso em sua assinatura você deve selecionar apenas um curso';		
						break;
					}
					if ($this->system->curso->verificaCursoAtivo($this->system->session->getItem('session_cod_usuario'), $produto['id'])) {
						$msg_error = 'Você já possui o curso ' . $produto['curso'] . '. Apenas poderá comprar esse mesmo curso quando seu acesso a esse curso expirar.';		
						break;
					}
					if ($this->system->vendas->verificaCompraCursoAberta($this->system->session->getItem('session_cod_usuario'), $produto['id'])) {
						$msg_error = 'Já existe uma compra aberta com ' . $produto['curso'] . '. Se não deseja finaliza-la, você poderá cancela-la em seu painel LMS.';		
						break;
					}
					if (in_array($produto['id'], $cursosCarrinho)) {
						$msg_error = 'Já existe o item ' . $produto['curso'] . ' no carrinho. Você não pode comprar o mesmo curso.';	
						break;	
					}
					
					$curso = true;
					$cursosCarrinho[] = $produto['id'];
				}
				if ($produto['tipo'] == 'plano') {
					if ($this->system->planos->verificaAssinaturaAtiva(' and usuario_id = ' . $this->system->session->getItem('session_cod_usuario'))) {
						$msg_error = 'Você já possui um plano de assinatura, por tanto não pode adquirir outro';		
						break;
					} elseif ($curso == true) {
						$msg_error = 'Deve-se apenas comprar curso ou assinatura, não podendo comprar os dois ao mesmo tempo.';		
						break;
					} elseif ($plano == true) {
						$msg_error = 'Você possui mais de um plano no carrinho. Apenas pode selecionar um plano';		
						break;
					} elseif ($cupom['id']) {
						$msg_error = 'Você não pode usar cupom para adquirir um plano!';		
						break;
					} elseif ($this->system->vendas->verificaCompraPlanoAberta($this->system->session->getItem('session_cod_usuario'), $produto['id'])) {
						$msg_error = 'Já existe uma compra aberta com ' . $produto['plano'] . '. Se não deseja finaliza-la, você poderá cancela-la em seu painel LMS.';		
						break;
					}

					$plano = true;	
				}
			}
		}

		if ($msg_error) {
			$this->system->session->addItem('msg_error', $msg_error);	
			$this->redirecionarCarrinho();		
		}
		
		//Apaga venda aberta não concretizada
		$vendaID = $this->system->session->getItem('venda_corrente');
		if ($vendaID) {
			$this->system->vendas->deletar($vendaID);
		}
		

		//adquirir novo curso na assinatura
		if ($this->system->planos->verificaAssinaturaAtiva(' and usuario_id = ' . $this->system->session->getItem('session_cod_usuario')) && $curso == true) {
			$this->doConcluirCursoAssinatura();
			exit();
		} 


		//Realizar venda
		$carrinho = $this->system->session->getItem('carrinho_produtos');
		$cupom = $this->system->session->getItem('carrinho_cupom');
		$cursos = array();
		$planos = array();
		$total = 0;
		$valorDescontoCompra = 0;

		//Se for valor fixo, tem que pegar o valor total dos itens que usará cupom, para dividir o desconto igual entre os itens.
		if ($cupom['id'] && $cupom['tipo_desconto'] == 1) {
			$totalComDesconto = 0; //Total do preço dos itens que usam desconto
			
			foreach ($carrinho as $key => $item) 
				if ($item['tipo'] == 'curso') {
					if ($this->checkCupomCurso($cupom, $item['id'])) 
						$totalComDesconto += $item['valorTotal'];
				}
		}



		foreach ($carrinho as $key => $item) {
			if ($item['tipo'] == 'curso') {
				$valorSemDesconto = $item['valorTotal'];
				$valorDesconto = 0;
				$cupomID = 0;


				if ($cupom['id']) {

					if ($this->checkCupomCurso($cupom, $item['id'])) {
						$cupomID = $cupom['id'];
						//Fixo
						if ($cupom['tipo_desconto'] == 1) {
							$valorDesconto = number_format($this->system->func->divisaoCusto($totalComDesconto, $item['valorTotal'], $cupom['valor']), 2, '.', '');
						} else { //Porcentagem
							$valorDesconto = number_format((($item['valorTotal'] * $cupom['valor'])/ 100), 2, '.', '');
						}
						$valorDescontoCompra += $valorDesconto;
						$item['valorTotal']-= $valorDesconto;
					}
				}



				$total += $item['valorTotal'];
				$cursoComprado['id'] 				= $item['id'];
				$cursoComprado['suporte'] 			= $item['suporte'];
				$cursoComprado['certificado'] 		= $item['certificado'];
				$cursoComprado['preco_total'] 		= $valorSemDesconto; //Preço + certificado + suporte
				$cursoComprado['preco_desconto']	= $valorDesconto; //Desconto dado ao produto
				$cursoComprado['professor_id'] 		= $item['professor_id'];
				$cursoComprado['cupom_id']			= $cupomID;

				//Comissão que vai para professor (Suporte + Curso)
				$this->system->load->dao('configuracoesgerais');
				$suporteConfig = $this->system->configuracoesgerais->getProdutosSuporte();
				
				$cursoComprado['preco_comissao'] = $item['valor']; //Preço do curso + suporte que será colhido a baixo
				if ($cursoComprado['suporte']) {

					//Preco do suporte 
					//Fixo
					if ($suporteConfig['produtos_suporte_tipo'] == 2) 
						$cursoComprado['preco_comissao'] += $suporteConfig['produtos_suporte_valor'];
						
					//Porcentagem
					if ($suporteConfig['produtos_suporte_tipo'] == 3) {
						$valor = (($item['valor'] * $suporteConfig['produtos_suporte_valor'])/100);
						$cursoComprado['preco_comissao'] += $valor;
					}
				}

				$cursos[] = $cursoComprado;
				
			}
			if ($item['tipo'] == 'plano') {
				$total += $item['valor'];
				$planos[] = $item['id'];
			}
		}
		
		$cupom = $this->system->session->getItem('carrinho_cupom');

		$campos = array(
			'usuario_id'		=> 0,
			'aluno_id'			=> $this->system->session->getItem('session_cod_usuario'),
			'cupom_id'			=> ($cupom['id'] ? $cupom['id'] : 0),
			'parceiro_id'		=> 0,
			'numero'			=> 00,
			'comprovante'		=> '',
			'forma_desconto'	=> 0,
			'forma_pagamento'	=> 0,
			'status'			=> 0,
			'valor_desconto'	=> $valorDescontoCompra,
			'valor_total'		=> $total,
			'data_venda'		=> date('d/m/Y'),
			'data_expiracao'	=> '0000-00-00',
			'cursos'			=> $cursos,
			'planos'			=> $planos,
		);

		
		$id = $this->system->vendas->cadastrar($campos);
		$this->system->session->addItem('venda_corrente', $id);
		$this->system->session->addItem('venda_numero', str_pad($id, 5, "0", STR_PAD_LEFT));
		$this->system->session->addItem('venda_numero_pagarme', $id);

		if ($cupom['id']) { //alterar status cupom
			if ($cupom['tipo'] == 1)
				$this->system->cupons->alterarStatus($cupom['id'], 2); //2 = usado
			elseif ($cupom['tipo'] == 3 && $cupom['quantidade'] <= $this->system->cupons->vezesUsada($cupom['id']))
				$this->system->cupons->alterarStatus($cupom['id'], 2); //2 = usado
		}

		if ($this->system->session->getItem('carrinho_total') == 0) {
			$this->doConcluirGratuito();
		} else {
			session_write_close();
			header('Location: ' . $this->system->getUrlSite() . 'carrinho/pagamento/');
			exit();			
		}
	}
	// ==============================================================
	protected function doPagamento() {
		$this->system->session->deleteItem('detalhesProdutos');
		$detalhesProdutos = "";
		$vendaID = $this->system->session->getItem('venda_corrente');
		$vendaNumero = $this->system->session->getItem('venda_numero');
		if (!$vendaID) {
			$this->system->session->addItem('msg_error', 'Houve uma falha, tente novamente mais tarde');	
			$this->redirecionarCarrinho();		
		}

		$carrinho = $this->system->session->getItem('carrinho_produtos');
		$cupom = $this->system->session->getItem('carrinho_cupom');
		$total = $this->system->session->getItem('carrinho_total');
		$produtos = array();
		$plano = false;
		foreach ($carrinho as $key => $item) {
			$produto = array();
			if ($item['tipo'] == 'curso') {
				$produto['produto'] 	= $item['curso'];
				$produto['preco']		= number_format($item['valor'], 2, ',', '.');
				$produto['precoTotal']	= number_format($item['valorTotal'], 2, ',', '.');
				$produto['imagem']		= $item['destaque_arquivo'];
				$produto['tipo'] 		= 'curso';
				$produto['id'] 			= $item['id'];
				$detalhesProdutos .= "ID : ".$item['id'] . " - Curso : ".$item['curso'];
				if(strlen($detalhesProdutos) < 53){
					$res = 53 - strlen($detalhesProdutos);
					for ($i=0; $i < $res; $i++) { 
						$detalhesProdutos .= '-';	
					}
				}else{
					$res = 105 - strlen($detalhesProdutos);
					for ($i=0; $i < $res; $i++) { 
						$detalhesProdutos .= ' -';	
					}
				}
				$detalhesProdutos .='-------------------------------------------------------';
			}
			if ($item['tipo'] == 'plano') {
				$plano 					= true;
				$moip_plano				= 'plano'.$item['id'];
				$produto['produto'] 	= $item['plano'];
				$produto['preco']		= number_format($item['valor'], 2, ',', '.');
				$produto['precoTotal']	= number_format($item['valor'], 2, ',', '.');
				$produto['imagem']		= $item['imagem_arquivo'];
				$produto['tipo'] 		= 'plano';
				$produto['id'] 			= $item['id'];	
				$detalhesProdutos .= "ID : ".$item['id'] . "  - Plano : ".$item['plano'];
			}

			$produtos[$key] = $produto;
		}
		$this->system->session->addItem('detalhesProdutos',$detalhesProdutos);

		$pagarme = $this->system->configuracoesgerais->getPagarme();
		$this->system->view->assign('pagarme_key_encryption', $pagarme['pagarme_key_criptografia']);
		//exibir
		$this->system->view->assign('produtos', $produtos);
		$this->system->view->assign('total', number_format($total, 2, ',', '.'));
		$this->system->view->assign('msg_error', $msg_error);	
		$this->system->view->assign('cupom', $cupom);	
		$this->system->site->topo($this->tituloPagina);
		if ($plano)
			$this->system->view->display('site/pagamento_assinatura.tpl');
		else
			$this->system->view->display('site/pagamento.tpl');
		$this->system->site->rodape();	
	}	
	// ==============================================================
	protected function doConcluirAssinatura() {
		$vendaID = $this->system->session->getItem('venda_corrente');
		if ($vendaID) {
			$campos['forma_pagamento'] = 1;
			$this->system->vendas->atualizar($vendaID, $campos);
			echo "<script type='text/javascript'>window.location.href='" . $this->system->getUrlSite(). "carrinho/confirmacao'</script>";
		}
	}
	// ==============================================================
	protected function doConcluirPagSeguro() {
		$this->system->load->model('pagamento_model');	
		
		$valor = $this->system->session->getItem('carrinho_total');
		$vendaNumero = $this->system->session->getItem('venda_numero');
		$email = $this->system->session->getItem('session_email');
		$nome = $this->system->session->getItem('session_nome');

		$this->system->pagamento_model->setValor($valor);
		$this->system->pagamento_model->setTransacaoID($vendaNumero);
		$this->system->pagamento_model->setEmailUsuario($email);
		$this->system->pagamento_model->setNomeUsuario($nome);

		$url = $this->system->pagamento_model->iniciaPagamentoPagSeguro();

		if ($url) {
			echo "<script> $('#linkEscondido').val('" . $url . "'); </script>";
			echo "<script> $('#popUp').show(); </script>";
			// echo "<script type='text/javascript'>window.open('" . $url . "', '_blank');</script>";
		}

		//Finaliza compra
		$vendaID = $this->system->session->getItem('venda_corrente');

		if ($vendaID) {
			$campos['forma_pagamento'] = 1;
			$this->system->vendas->atualizar($vendaID, $campos);
			// echo "<script type='text/javascript'>window.location.href='" . $this->system->getUrlSite(). "carrinho/confirmacao'</script>";
		}	
	}
	// ==============================================================
	protected function doConcluirPagarme() {

		$card_hash = $this->system->input["card_hash"];
		if($card_hash){
			$this->system->load->model('pagamento_model');	
			$valor = number_format($this->system->session->getItem('carrinho_total'),2,'','');
			$vendaNumero = $this->system->session->getItem('venda_numero_pagarme');
			$email = $this->system->session->getItem('session_email');
			$nome = $this->system->session->getItem('session_nome');

			
			$parcelas  = $this->system->input["parcelas"];		
			$detalhesProdutos = $this->system->session->getItem('detalhesProdutos');

			$this->system->pagamento_model->setValor($valor);
			$this->system->pagamento_model->setTransacaoID($vendaNumero);
			$this->system->pagamento_model->setDetalhesProdutos($detalhesProdutos);
			$this->system->pagamento_model->setEmailUsuario($email);
			$this->system->pagamento_model->setNomeUsuario($nome);
			$this->system->pagamento_model->setParcelas($parcelas);
			$this->system->pagamento_model->setCard_Hash($card_hash);

			$id = $this->system->pagamento_model->iniciaPagamentoPagarme();


			if ($id) {
				echo "<script type='text/javascript'>window.location.href='" . $this->system->getUrlSite(). "carrinho/confirmacao'</script>";			
				//Finaliza compra
				$vendaID = $this->system->session->getItem('venda_corrente');

				if ($vendaID) {
					$campos['forma_pagamento'] = 1;
					$this->system->vendas->atualizar($vendaID, $campos);
					// echo "<script type='text/javascript'>window.location.href='" . $this->system->getUrlSite(). "carrinho/confirmacao'</script>";
				}	
			}
			die();
		}
	}
	// =============================================================
	private function doConcluirGratuito() {
		$vendaID = $this->system->session->getItem('venda_corrente');
		$numero = $this->system->session->getItem('venda_numero');
		if ($vendaID) {
			$campos['status'] = 1;
			$campos['data_expiracao'] = date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d'), (date('Y') + 2)));
			$this->system->vendas->atualizar($vendaID, $campos);

			$produtos = $this->system->session->getItem('carrinho_produtos');
			$this->system->load->model('email_model');

			foreach ($produtos as $produto)  {
				if ($produto['tipo'] == 'curso') {
					$this->system->curso->cadastrarCursosAluno(array($produto), $this->system->session->getItem('session_cod_usuario'), date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), (date('Y') + 2))));
					$this->system->email_model->vendaCursoProfessor($produto['id'], $numero);
				}
				// if ($produto['tipo'] == 'plano') {
				// 	$this->system->planos->cadastrarPlanoAluno($produto['id'], $this->system->session->getItem('session_cod_usuario'), date('Y-m-d', mktime(0, 0, 0, (date('m') + $produto['meses']), date('d'), date('Y'))));
				// }
				
				$this->system->email_model->vendaAprovadaAluno($this->system->session->getItem('session_cod_usuario'), $numero, date('d/m/Y'));

				$this->system->email_model->vendaRealizadaAdministrativo($numero);
			}

			session_write_close();
			header('Location: ' . $this->system->getUrlSite() . 'carrinho/confirmacao');
			exit();
		}	
	}
	// =============================================================
	private function doConcluirCursoAssinatura(){
		$carrinho = $this->system->session->getItem('carrinho_produtos');
		$produto = current($carrinho);
		$usuarioID = $this->system->session->getItem('session_cod_usuario');
		$assinaturaAtual = $this->system->planos->getPlanoAluno('and usuario_id = ' . $usuarioID);

		if ($assinaturaAtual['id']) {

			$curso['id'] = $produto['id'];
			$curso['suporte'] = 1;
			$curso['certificado'] = 0;
			//adiciona novo curso
			$id = $this->system->curso->cadastrarCursoAluno($curso, $usuarioID, $assinaturaAtual['data_expiracao']);
			//remove curso anterior
			$this->system->curso->deleteCursoAluno($assinaturaAtual['curso_id']);

			$this->system->planos->alterarCurso($assinaturaAtual['id'], $id);

			//email
			$this->system->load->model('email_model');
			$this->system->email_model->iniciarCurso($usuarioID, $curso['id'], date('d/m/Y', strtotime($assinaturaAtual['data_expiracao'])));

			session_write_close();
			header('Location: ' . $this->system->getUrlSite() . 'carrinho/confirmacao');
			exit();
		}
	}
	// =============================================================
	protected function doAssinar() {
		$enviar = $this->system->input['enviar'];
		$this->system->load->model('pagarme_model');
		
		
		if ($enviar) {			
			$erro = array();
			$card_hash = $this->system->input["card_hash"];
			$carrinho = $this->system->session->getItem('carrinho_produtos');
			$detalhesProdutos = $this->system->session->getItem('detalhesProdutos');
			$plano = current($carrinho);
			if (!$this->system->pagarme_model->validarPeriodo($plano['meses'])) $erro[] = 'Periodo de plano inválido.';
			//if (empty($card_hash)) $erro[] = 'Card Hash inválido ou inexistente.';

			if (count($erro) == 0) {
				
				$this->system->pagarme_model->setNomeCliente($this->system->session->getItem('session_nome'));
				$this->system->pagarme_model->setEmailCliente($this->system->session->getItem('session_email'));
				$this->system->pagarme_model->setReferencia($this->system->session->getItem('venda_numero_pagarme'));
				$this->system->pagarme_model->setValor(number_format($plano['valor'],2,'',''));
				$this->system->pagarme_model->setPlano($plano['codigoPlanoPagarme']);
				$this->system->pagarme_model->setDetalhesProdutos($detalhesProdutos);
				$this->system->pagarme_model->setRedirectURL($this->system->getUrlSite() . 'carrinho/confirmacao');
				$this->system->pagarme_model->setCardHash($card_hash);				

				try {
					
					$status = $this->system->pagarme_model->gerarSolicitacaoPagarmeAssinatura();

					if ($status == "paid") {
						$this->system->vendas->atualizar($this->system->session->getItem('venda_numero_pagarme'), array('forma_pagamento' => 1));
						echo "<script type='text/javascript'>window.location.href='" . $this->system->getUrlSite(). "carrinho/confirmacao'</script>";
						//echo "<script> $('#linkEscondido').val('" . $url . "'); </script>";
						//echo "<script> $('#popUp').show(); </script>";
						// echo "<script type='text/javascript'>window.open('" . $url . "', '_blank');</script>";
					}else{
						echo '<script type="text/javascript">alert("Houve uma falha na solicitação. \n' . $id . '")</script>';		
					}

				} catch (Exception $e) {
					echo '<script type="text/javascript">alert("Houve uma falha na solicitação. \n' . $e->getMessage() . '")</script>';	
				}
				

				
			} else {
				echo '<script type="text/javascript">alert("Houve uma falha na solicitação. \n' . implode('\n', $erro) . '")</script>';
			}
		}
	}
	// =============================================================
	protected function doAssinarANTIGO() {
		$enviar = $this->system->input['enviar'];
		$this->system->load->model('pagseguro_model');

		if ($enviar) {

			$erro = array();
			$carrinho = $this->system->session->getItem('carrinho_produtos');
			$plano = current($carrinho);
			if (!$this->system->pagseguro_model->validarPeriodo($plano['meses'])) $erro[] = 'Periodo de plano inválido.';


			if (count($erro) == 0) {


			
				$this->system->pagseguro_model->setNomeCliente($this->system->session->getItem('session_nome'));
				$this->system->pagseguro_model->setEmailCliente($this->system->session->getItem('session_email'));
				$this->system->pagseguro_model->setReferencia($this->system->session->getItem('venda_corrente'));
				$this->system->pagseguro_model->setValor($plano['valor']);
				$this->system->pagseguro_model->setPeriodicidade($plano['meses']);
				$this->system->pagseguro_model->setRedirectURL($this->system->getUrlSite() . 'carrinho/confirmacao');
				
				try {
					
					$url = $this->system->pagseguro_model->gerarSolicitacaoPagSeguro();

					$this->system->vendas->atualizar($this->system->session->getItem('venda_corrente'), array('forma_pagamento' => 1));
					
					if ($url) {
						echo "<script> $('#linkEscondido').val('" . $url . "'); </script>";
						echo "<script> $('#popUp').show(); </script>";
						// echo "<script type='text/javascript'>window.open('" . $url . "', '_blank');</script>";
					}

				} catch (Exception $e) {
					echo '<script type="text/javascript">alert("Houve uma falha na solicitação. \n' . $e->getMessage() . '")</script>';	
				}
				

				
			} else {
				echo '<script type="text/javascript">alert("Houve uma falha na solicitação. \n' . implode('\n', $erro) . '")</script>';
			}
		}
	}
	// ==============================================================
	protected function doConfirmacao() {	

		$assinatura = $this->system->session->getItem('pagamento_assinatura');
		$assinaturaID = $this->system->session->getItem('pagamento_assinatura_id');
		$assinaturaMensagem = $this->system->session->getItem('pagamento_assinatura_mensagem');

		$this->system->session->deleteItem('venda_corrente');
		$this->system->session->deleteItem('venda_numero');
		$this->system->session->deleteItem('msg_error');
		$this->system->session->deleteItem('carrinho_produtos');
		$this->system->session->deleteItem('carrinho_cupom');
		$this->system->session->deleteItem('carrinho_total');
		$this->system->session->deleteItem('pagamento_assinatura_mensagem');
		$this->system->session->deleteItem('pagamento_assinatura');
		$this->system->session->deleteItem('pagamento_assinatura_id');

		if (!$assinatura) {
			$this->system->site->topo($this->tituloPagina);
			$this->system->view->display('site/carrinho_confirmacao.tpl');
			$this->system->site->rodape();		
		} else {
			$this->system->view->assign('assinaturaID', $assinaturaID);
			$this->system->view->assign('assinaturaMensagem', $assinaturaMensagem);

			$this->system->site->topo($this->tituloPagina);
			$this->system->view->display('site/carrinho_confirmacao_assinatura.tpl');
			$this->system->site->rodape();		
		}	
	}
	// ==============================================================
	protected function doCancelar() {
		$vendaID = $this->system->session->getItem('venda_corrente');	
		if ($vendaID) {
			$this->system->vendas->deletar($vendaID);
			$this->system->session->deleteItem('venda_corrente');	
			$this->system->session->deleteItem('venda_numero');	
		}
		$this->system->session->addItem('msg_error', 'Venda cancelada');	
		$this->redirecionarCarrinho();		
	}
	// ==============================================================
	private function redirecionarCarrinho() {
		session_write_close();
		header('location: ' . $this->system->getUrlSite() . 'carrinho/ver');
		exit();
	}
	// ===============================================================
	private function checkCupomCurso($cupom, $cursoID) {
		return ((count($cupom['cursos_ativos']) == 0 && !in_array($cursoID, $cupom['cursos_excluidos'])) || (count($cupom['cursos_ativos']) > 0 && in_array($cursoID, $cupom['cursos_ativos'])));
	}
	// ===============================================================
	protected function pagina404() {
		$url = end(explode($this->system->getUrlSite(), $_SERVER['REQUEST_URI']));
		$this->system->view->assign('url', $url);
		$this->system->site->topo(0);
		$this->system->view->display('site/pagina404.tpl');
		$this->system->site->rodape();
	}
}
// ===================================================================


