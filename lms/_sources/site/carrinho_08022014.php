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
			case 'ver':					$this->doVer(); break;
			case 'adicionarCurso':		$this->doAdicionarCurso(); break;
			case 'adicionarPlano':		$this->doAdicionarPlano(); break;
			case 'adicionarCupom':		$this->doAdicionarCupom(); break;
			case 'removerCarrinho':		$this->doRemoverCarrinho(); break;
			case 'removerCupom':		$this->doRemoverCupom(); break;
			case 'verificaLogin':		$this->doVerificaLogin(); break;
			case 'verificaCompra':		$this->doVerificaCompra(); break;
			case 'iniciarMoip':			$this->doIniciarMoip(); break;
			case 'pagamento':			$this->doPagamento(); break;
			case 'cancelar':			$this->doCancelar(); break;
			case 'assinarMoip':			$this->doAssinarMoip(); break;
			/*case 'concluirGratuito': 	$this->doConcluirGratuito();break*/
			case 'concluirMoip':		$this->doConcluirMoip(); break;
			case 'concluirPagSeguro':	$this->doConcluirPagSeguro(); break;
			case 'confirmacao':			$this->doConfirmacao(); break;
			default: 					$this->pagina404(); break;
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
		foreach ($carrinho as $key => $item) {
			$produto = array();
			if ($item['tipo'] == 'curso') {
				//Preco 
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
		if ($cupom['id']) {
			if  ($cupom['tipo_desconto'] == 1) {
				$total = max(0, ($total - $cupom['valor']));
			} else {
				$total -= ($total * $cupom['valor'])/100;
				$total = max(0, $total);
			}
		}

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
		$this->system->site->rodape();	
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
				 
		       	
		       	if ($this->system->planos->verificaAssinaturaAtiva(' and usuario_id = ' . $this->system->session->getItem('session_cod_usuario')))
		        	header('Location: ' . $this->system->getUrlSite() . 'carrinho/ver/');
		        else
		        	header('Location: ' . $this->system->getUrlSite() . 'carrinho/verificaCompra/');
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
			foreach ($carrinho as $produto) {
				if ($produto['tipo'] == 'curso') {
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
					$curso = true;
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
		foreach ($carrinho as $key => $item) {
			if ($item['tipo'] == 'curso') {
				$total += $item['valorTotal'];
				$cursoComprado['id'] = $item['id'];
				$cursoComprado['suporte'] = $item['suporte'];
				$cursoComprado['certificado'] = $item['certificado'];
				$cursoComprado['preco_total'] = $item['valorTotal'];
				$cursoComprado['professor_id'] = $item['professor_id'];

				//Comissão que vai para professor (Suporte + Curso)
				$this->system->load->dao('configuracoesgerais');
				$suporteConfig = $this->system->configuracoesgerais->getProdutosSuporte();
				
				$cursoComprado['preco_comissao'] = $item['valor'];
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
		
		//Cupom
		if ($cupom['id']) {
			if  ($cupom['tipo_desconto'] == 1) {
				$total = max(0, ($total - $cupom['valor']));
			} else {
				$total -= ($total * $cupom['valor'])/100;
				$total = max(0, $total);
			}
		}

		$cupom = $this->system->session->getItem('carrinho_cupom');

		$campos = array(
			'usuario_id'		=> 0,
			'aluno_id'			=> $this->system->session->getItem('session_cod_usuario'),
			'cupom_id'			=> ($cupom['id'] ? $cupom['id'] : 0),
			'parceiro_id'		=> 0,
			'forma_desconto'	=> 0,
			'forma_pagamento'	=> 0,
			'status'			=> 0,
			'valor_desconto'	=> 0,
			'valor_total'		=> $total,
			'data_venda'		=> date('d/m/Y'),
			'data_expiracao'	=> '0000-00-00',
			'cursos'			=> $cursos,
			'planos'			=> $planos,
		);

		
		$id = $this->system->vendas->cadastrar($campos);
		$this->system->session->addItem('venda_corrente', $id);
		$this->system->session->addItem('venda_numero', str_pad($id, 5, "0", STR_PAD_LEFT));

		if ($cupom['id']) { //alterar status cupom
			if ($cupom['tipo'] == 1)
				$this->system->cupons->alterarStatus($cupom['id'], 2); //2 = usado
			elseif ($cupom['tipo'] == 3 && $cupom['quantidade'] <= $this->system->cupons->vezesUsada($cupom['id']))
				$this->system->cupons->alterarStatus($cupom['id'], 2); //2 = usado
		}

		if ($this->system->session->getItem('carrinho_total') == 0) {
			$this->doConcluirGratuito();
		} else {
			header('Location: ' . $this->system->getUrlSite() . 'carrinho/pagamento/');
			exit();			
		}
	}
	// ==============================================================
	protected function doPagamento() {
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
			}

			$produtos[$key] = $produto;
		}


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
	protected function doIniciarMoip() {
		$this->system->load->model('pagamento_model');	
		$token = $this->system->input['token'];

		if (!$token) {
			$valor = $this->system->session->getItem('carrinho_total');
			$vendaNumero = $this->system->session->getItem('venda_numero');
			$email = $this->system->session->getItem('session_email');
			$nome = $this->system->session->getItem('session_nome');



			$this->system->pagamento_model->setValor($valor);
			$this->system->pagamento_model->setTransacaoID($vendaNumero);
			$this->system->pagamento_model->setEmailUsuario($email);
			$this->system->pagamento_model->setNomeUsuario($nome);

			$token = $this->system->pagamento_model->getTokenTransacaoMoip();

			if ($token) {
				echo "<script>$('#MoipWidget').attr('data-token','" . $token . "')</script>";
				// echo $token;	
			} else {
				echo "<script>alert('" . $this->system->pagamento_model->getErro() . "')</script>";
			}
		} 
	}
	// ==============================================================
	protected function doConcluirMoip() {
		$vendaID = $this->system->session->getItem('venda_corrente');
		if ($vendaID) {
			$campos['forma_pagamento'] = 2;
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

			header('Location: ' . $this->system->getUrlSite() . 'carrinho/confirmacao');
			exit();
		}	
	}
	// =============================================================
	private function doConcluirCursoAssinatura(){
		$carrinho = $this->system->session->getItem('carrinho_produtos');
		$produto = $carrinho[0];
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

			header('Location: ' . $this->system->getUrlSite() . 'carrinho/confirmacao');
			exit();
		}
	}
	// =============================================================
	protected function doAssinarMoip() {
		$enviar = $this->system->input['enviar'];

		if ($enviar) {

			$erro = array();
			if (!$this->system->input['nome']) $erro[] = 'Preencher campo nome';
			if (!$this->system->input['cpf']) $erro[] = 'Preencher o campo cpf';
			if (!$this->system->input['telefone']) $erro[] = 'Preencher o campo telefone';
			elseif(!$this->system->func->isInt($this->system->input['telefone'])) $erro[] = 'O campo telefone deve conter só números';
			if (!$this->system->input['ddd']) $erro[] = 'Preencher campo ddd';
			elseif(!$this->system->func->isInt($this->system->input['ddd'])) $erro[] = 'O campo ddd deve conter só números';
			if (!$this->system->input['data_nascimento']) $erro[] = 'Preencher campo data de nascimento';
			elseif(!$this->system->func->checkDate($this->system->input['data_nascimento'], false)) $erro[] = 'Data inválida';
			if (!$this->system->input['rua']) $erro[] = 'Preencher campo rua';
			if (!$this->system->input['numero']) $erro[] = 'Preencher campo numero';
			if (!$this->system->input['bairro']) $erro[] = 'Preencher campo bairro';
			if (!$this->system->input['cidade']) $erro[] = 'Preencher campo cidade';
			if (!$this->system->input['estado']) $erro[] = 'Preencher campo estado';
			if (!$this->system->input['cep']) $erro[] = 'Preencher campo cep';
			if (!$this->system->input['nome_cartao']) $erro[] = 'Preencher campo nome cartão';
			if (!$this->system->input['cartao']) $erro[] = 'Preencher o numero do cartão';
			elseif(!$this->system->func->isInt($this->system->input['cartao'])) $erro[] = 'O campo número cartão deve conter só números';
			if (!$this->system->input['mes_cartao']) $erro[] = 'Preencher campo mês cartão';
			if ($this->system->input['mes_cartao'] < 0 || $this->system->input['mes_cartao'] > 12) $erro[] = 'mês inválido';
			if (!$this->system->input['ano_cartao']) $erro[] = 'Preencher campo ano cartão';


			if (count($erro) == 0) {
				$moipAssinatura = array();

				//assinatura
				$moipAssinatura['code'] = $this->system->session->getItem('venda_corrente');
				$moipAssinatura['amount'] = number_format($this->system->session->getItem('carrinho_total'), 2, '', '');

				//plano
				$carrinho = $this->system->session->getItem('carrinho_produtos');
				$plano = current($carrinho);
				$moipAssinatura['plan']['code'] = 'plano' . $plano['id'];

				//Cliente
				$codeCliente = 'cliente' . $this->system->session->getItem('session_cod_usuario');
				$cliente = $this->system->moip->obterDadosCliente($codeCliente);

				$customer['code'] 			= $codeCliente;
				$customer['email'] 			= $this->system->session->getItem('session_email');
				$customer['fullname'] 		= $this->system->input['nome'];
				$customer['cpf'] 			= $this->system->input['cpf'];
				$customer['phone_number'] 	= $this->system->input['telefone'];
				$customer['phone_area_code']= $this->system->input['ddd'];

				list($dia, $mes, $ano) = explode('/', $this->system->input['data_nascimento']);
				$customer['birthdate_day'] 		= $dia;
				$customer['birthdate_month'] 	= $mes;
				$customer['birthdate_year'] 	= $ano;

				//endereço
				$endereco['street'] 	= $this->system->input['rua'];
				$endereco['number'] 	= $this->system->input['numero'];
				$endereco['complement'] = $this->system->input['complemento'];
				$endereco['district'] 	= $this->system->input['bairro'];
				$endereco['city'] 		= $this->system->input['cidade'];
				$endereco['state'] 		= $this->system->input['estado'];
				$endereco['country'] 	= 'BRA';
				$endereco['zipcode'] 	= $this->system->input['cep'];
				
				$customer['address'] 	= $endereco;

				//cartão de credito
				$cartao['holder_name'] 		= $this->system->input['nome_cartao'];
				$cartao['number']			= $this->system->input['cartao'];
				$cartao['expiration_month'] = $this->system->input['mes_cartao'];
				$cartao['expiration_year'] = $this->system->input['ano_cartao'];

				$customer['billing_info']['credit_card'] = $cartao;
				$moipAssinatura['customer'] = $customer;
				
				try {

					if ($cliente) {
						$this->system->moip->atualizarDadosCliente($customer);
						$this->system->moip->atualizarDadosCartao($customer);
					}

					$this->system->moip->cadastrarAssinatura($moipAssinatura, ($cliente ? false: true));	
					// echo "<script type='text/javascript'>$('#popUp').show();</script>";
					flush();
					//time out para solicitar a requisição
					sleep(40);

					$this->system->session->addItem('pagamento_assinatura', true);
					$this->system->session->addItem('pagamento_assinatura_id', $moipAssinatura['code']);
					$vendaID = $moipAssinatura['code'];
					$numero = str_pad($vendaID, 5, "0", STR_PAD_LEFT);
					$alunoID = $this->system->session->getItem('session_cod_usuario');
					//Verifica pagamento
					try {
						$dadosAssinatura = $this->system->moip->obterDadosAssinatura($vendaID);

					} catch(Exception $e)  {
						echo $e->getMessage();
						$this->system->session->addItem('pagamento_assinatura_mensagem', 'Houve uma falha ao tentar realizar o pagamento da assinatura, tente novamente mais tarde. Se o erro persistir, entre em contato com a equipe de suporte.');
					}
					
					if (count($dadosAssinatura['invoices'])) {
						$plano = $dadosAssinatura['invoices'][0];
						
						//Pago
						if ($plano['status']['code'] == 2) {
							$this->system->session->addItem('pagamento_assinatura_mensagem', 'A fatura foi realizado, mas o pagamento está em processo de análise de risco.');

						} elseif ($plano['status']['code'] == 3) {

							$this->system->vendas->alterarPagamento($vendaID, 1);
							
							//Adicionar Plano
							$plano = $this->system->vendas->getPlanoVenda($vendaID);
							$dataExpiracao = date('Y-m-d', mktime(0, 0, 0, (date('m') + $plano['meses']), date('d'), date('Y')));
							$this->system->planos->cadastrarPlanoAluno($plano['id'], $alunoID, $vendaID, $dataExpiracao);
							$this->system->vendas->atualizar($vendaID, array('data_expiracao' => $dataExpiracao));

							//Emails
							//Administrativo
							$this->system->email_model->alteradoStatusVendaAdministrativo($numero);
							
							//Aluno
							$this->system->email_model->vendaAprovadaAluno($alunoID, $numero, date('d/m/Y', strtotime($dataExpiracao)));
							$this->system->session->addItem('pagamento_assinatura_mensagem', 'Seu pagamento foi aprovado e sua assinatura liberada');

							$this->system->email_model->assinaturaContratadaAluno($alunoID, $plano['plano']);
						} elseif ($plano['status']['code'] > 3) {
							$this->system->session->addItem('pagamento_assinatura_mensagem', 'O pagamento da fatura não foi aceito.');
							$this->system->vendas->alterarPagamento($vendaID, 2);
						}
					}


					echo "<script type='text/javascript'>window.location.href='" . $this->system->getUrlSite() . "carrinho/concluirMoip'</script>";
				} catch (Exception $e) {
					echo "<script type='text/javascript'>$('#popUp').hide();</script>";
					echo "<script type='text/javascript'>alert('Houve uma falha na solicitação. " . $e->getMessage() . "')</script>";
				}
			} else {
				echo "<script type='text/javascript'>$('#popUp').hide();</script>";
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
		header('location: ' . $this->system->getUrlSite() . 'carrinho/ver');
		exit();
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

