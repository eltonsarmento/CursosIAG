<?php
// ===================================================================
class configuracoesgerais {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('configuracoesgerais');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		
		switch($this->system->input['do']) {
			case 'produtos':$this->doEdicaoProdutos(); break;
			case 'termos':$this->doEdicaoTermos(); break;
			case 'pagamentos':$this->doEdicaoPagamentos(); break;
			case 'pagamentosMudarStatus':$this->doAlterarStatusPagamento(); break;
			case 'imagens':$this->doEdicaoImagens(); break;
			case 'certificados':$this->doEdicaoCertificados(); break;
			case 'servidores':$this->doEdicaoServidores(); break;
			case 'graficas':$this->doEdicaoGrafica(); break;
			case 'pdf':$this->doPdf(); break;
			case 'jpg':$this->doJpg(); break;
			default: $this->pagina404(); break;
		}
	}
	// ======================= PRODUTOS  ==========================
	private function doEdicaoProdutos() {
		$editarCertificado = intval($this->system->input['editarCertificado']);
		$editarSuporte = intval($this->system->input['editarSuporte']);
		
		//Suporte
		if ($editarSuporte) {
			$erro_msg = $this->validarDadosProdutos();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('suporte', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarProdutos($this->system->input);
				$this->system->view->assign('msg_alert', 'Variação de Suporte Estendido atualizada com sucesso!');
				$this->system->view->assign('suporte', $this->system->input);
			}
		} else {
		    $this->system->view->assign('suporte', $this->system->configuracoesgerais->getProdutosSuporte());
		}

		//Certificado
		if ($editarCertificado) {
			$erro_msg = $this->validarDadosProdutos();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('certificado', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarProdutos($this->system->input);
				$this->system->view->assign('msg_alert', 'Variação de Certificado atualizada com sucesso!');
				$this->system->view->assign('certificado', $this->system->input);
			}
		} else {
		    $this->system->view->assign('certificado', $this->system->configuracoesgerais->getProdutosCertificados());
		}

		$this->system->admin->topo(13);
		$this->system->view->display('administrador-geral/configuracoes_produtos_variacoes.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDadosProdutos() {
		
		//Suporte Estendido
        if ($this->system->input['produtos_suporte_tipo'] == 2 && !$this->system->input['produtos_suporte_valor'])
        	$retorno['msg'][] = "O campo preço deve ser preenchido";

        //Certificado
        if ($this->system->input['produtos_certificado_tipo'] == 2 && !$this->system->input['produtos_certificado_valor'])
        	$retorno['msg'][] = "O campo preço deve ser preenchido";

		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// =================== TERMOS E CONDIÇÕES ========================
	private function doEdicaoTermos() {
		$editar = intval($this->system->input['editar']);
		
		if ($editar) {
			$erro_msg = $this->validarDadosTermo();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('termos', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarTermos($this->system->input);
				$this->system->view->assign('msg_alert', 'Termos e Condições atualizado com sucesso!');
				$this->system->view->assign('termos', $this->system->input);
			}
		} else {
		    $this->system->view->assign('termos', $this->system->configuracoesgerais->getTermosCondicoes());
		}

		$this->system->admin->topo(13);
		$this->system->view->display('administrador-geral/configuracoes_termos_condicoes.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDadosTermo() {
		
		//Termos e Condições
        if ($this->system->input['termos_condicoes'] == '')
        	$retorno['msg'][] = "O campo Termos e Condições deve ser preenchido";

		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ======================= PAGAMENTOS ============================
	private function doEdicaoPagamentos() {
		$editarPagseguro = intval($this->system->input['editarPagseguro']);
		$editarMoip = intval($this->system->input['editarMoip']);
		$editarPaypal = intval($this->system->input['editarPaypal']);
		$editarPagarme = intval($this->system->input['editarPagarme']);
		
		//Pagarme
		if ($editarPagarme) {
			$erro_msg = $this->validarDadosPagamentos();

			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('pagarme', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarPagamentos($this->system->input);
				$this->system->view->assign('msg_alert', 'Pagarme atualizado com sucesso!');
				$this->system->view->assign('pagarme', $this->system->input);
			}
		} else {
		    $this->system->view->assign('pagarme', $this->system->configuracoesgerais->getPagarme());
		}
		//Pagseguro
		if ($editarPagseguro) {
			$erro_msg = $this->validarDadosPagamentos();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('pagseguro', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarPagamentos($this->system->input);
				$this->system->view->assign('msg_alert', 'Pagseguro atualizado com sucesso!');
				$this->system->view->assign('pagseguro', $this->system->input);
			}
		} else {
		    $this->system->view->assign('pagseguro', $this->system->configuracoesgerais->getPagseguro());
		}
		//Moip
		if ($editarMoip) {
			$erro_msg = $this->validarDadosPagamentos();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('moip', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarPagamentos($this->system->input);
				$this->system->view->assign('msg_alert', 'Moip atualizado com sucesso!');
				$this->system->view->assign('moip', $this->system->input);
			}
		} else {
		    $this->system->view->assign('moip', $this->system->configuracoesgerais->getMoip());
		}
		//Paypal
		if ($editarPaypal) {
			$erro_msg = $this->validarDadosPagamentos();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('paypal', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarPagamentos($this->system->input);
				$this->system->view->assign('msg_alert', 'PayPal atualizado com sucesso!');
				$this->system->view->assign('paypal', $this->system->input);
			}
		} else {
		    $this->system->view->assign('paypal', $this->system->configuracoesgerais->getPayPal());
		}

		$this->system->admin->topo(13);
		$this->system->view->display('administrador-geral/configuracoes_pagamentos.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDadosPagamentos() {
		
		//Pagarme
		if ($this->system->input['editarPagarme']) {
	        if ($this->system->input['pagarme_key_api'] == '')
	        	$retorno['msg'][] = "O campo Chave Api de Cadastro deve ser preenchida";	        
	       	if ($this->system->input['pagarme_key_criptografia'] == '')
	        	$retorno['msg'][] = "O campo Chave de Criptografia deve ser preenchida";
	    }
	    //Pagseguro
		if ($this->system->input['editarPagseguro']) {
	        if ($this->system->input['pagseguro_email'] == '')
	        	$retorno['msg'][] = "O campo E-mail de Cadastro deve ser preenchido";
	        elseif(!$this->system->func->checkEmail($this->system->input['pagseguro_email']))
        		$retorno['msg'][] = "O campo E-mail é inválido";
	       	if ($this->system->input['pagseguro_token'] == '')
	        	$retorno['msg'][] = "O campo Token de Segurança deve ser preenchido";
	    }
	    //Moip
	    if ($this->system->input['editarMoip']) {
	        if ($this->system->input['moip_key'] == '')
	        	$retorno['msg'][] = "O campo Key deve ser preenchido";
	       	if ($this->system->input['moip_token'] == '')
	        	$retorno['msg'][] = "O campo Token deve ser preenchido";
	    }

	    //Paypal
	    if ($this->system->input['editarPaypal']) {
	        if ($this->system->input['paypal_usuario'] == '')
	        	$retorno['msg'][] = "O campo Usuário deve ser preenchido";
	        if ($this->system->input['paypal_assinatura'] == '')
	        	$retorno['msg'][] = "O campo Assinatura deve ser preenchido";
	    }


		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	private function doAlterarStatusPagamento() {		
		$this->system->configuracoesgerais->atualizarStatusPagamentos($this->system->input);
		echo "<script>location.reload();</script>";
	}
	// =======================++ IMAGENS +++==========================
	private function doEdicaoImagens() {
		$editarDestacada = intval($this->system->input['editarDestacada']);
		$editarBanner = intval($this->system->input['editarBanner']);
		$editarPerfil = intval($this->system->input['editarPerfil']);
		
		//Destacada
		if ($editarDestacada) {
			$erro_msg = $this->validarDadosImagens();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('destacada', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarImagens($this->system->input);
				$this->system->view->assign('msg_alert', 'Imagem destacada atualizada com sucesso!');
				$this->system->view->assign('destacada', $this->system->input);
			}
		} else {
		    $this->system->view->assign('destacada', $this->system->configuracoesgerais->getImagensDestacada());
		}

		//Banner
		if ($editarBanner) {
			$erro_msg = $this->validarDadosImagens();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('banner', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarImagens($this->system->input);
				$this->system->view->assign('msg_alert', 'Imagem banner atualizada com sucesso!');
				$this->system->view->assign('banner', $this->system->input);
			}
		} else {
		    $this->system->view->assign('banner', $this->system->configuracoesgerais->getImagensBanner());
		}

		//Perfil
		if ($editarPerfil) {
			$erro_msg = $this->validarDadosImagens();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('perfil', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarImagens($this->system->input);
				$this->system->view->assign('msg_alert', 'Imagem perfil atualizada com sucesso!');
				$this->system->view->assign('perfil', $this->system->input);
			}
		} else {
		    $this->system->view->assign('perfil', $this->system->configuracoesgerais->getImagensPerfil());
		}

		$this->system->admin->topo(13);
		$this->system->view->display('administrador-geral/configuracoes_imagens.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDadosImagens() {
		
		//Destacada
		if ($this->system->input['editarDestacada']) {
	        if ($this->system->input['imagem_destacada_largura'] == '')
	        	$retorno['msg'][] = "O campo largura deve ser preenchido";
	        elseif (intval($this->system->input['imagem_destacada_largura']) == 0) 
	        	$retorno['msg'][] = "O campo largura deve ser um número maior que 0";

	        if ($this->system->input['imagem_destacada_altura'] == '')
	        	$retorno['msg'][] = "O campo altura deve ser preenchido";
	        elseif (intval($this->system->input['imagem_destacada_altura']) == 0) 
	        	$retorno['msg'][] = "O campo altura deve ser um número maior que 0";

	        if ($this->system->input['imagem_destacada_tamanho'] == '')
	        	$retorno['msg'][] = "O campo tamanho deve ser preenchido";
	        elseif (intval($this->system->input['imagem_destacada_tamanho']) == 0) 
	        	$retorno['msg'][] = "O campo tamanho deve ser um número maior que 0";
	    }

	    //Banner
		if ($this->system->input['editarBanner']) {
	        if ($this->system->input['imagem_banner_largura'] == '')
	        	$retorno['msg'][] = "O campo largura deve ser preenchido";
	        elseif (intval($this->system->input['imagem_banner_largura']) == 0) 
	        	$retorno['msg'][] = "O campo largura deve ser um número maior que 0";

	        if ($this->system->input['imagem_banner_altura'] == '')
	        	$retorno['msg'][] = "O campo altura deve ser preenchido";
	        elseif (intval($this->system->input['imagem_banner_altura']) == 0) 
	        	$retorno['msg'][] = "O campo altura deve ser um número maior que 0";

	        if ($this->system->input['imagem_banner_tamanho'] == '')
	        	$retorno['msg'][] = "O campo tamanho deve ser preenchido";
	        elseif (intval($this->system->input['imagem_banner_tamanho']) == 0) 
	        	$retorno['msg'][] = "O campo tamanho deve ser um número maior que 0";
	    }

	    //Destacada
		if ($this->system->input['editarPerfil']) {
	        if ($this->system->input['imagem_perfil_largura'] == '')
	        	$retorno['msg'][] = "O campo largura deve ser preenchido";
	        elseif (intval($this->system->input['imagem_perfil_largura']) == 0) 
	        	$retorno['msg'][] = "O campo largura deve ser um número maior que 0";

	        if ($this->system->input['imagem_perfil_altura'] == '')
	        	$retorno['msg'][] = "O campo altura deve ser preenchido";
	        elseif (intval($this->system->input['imagem_perfil_altura']) == 0) 
	        	$retorno['msg'][] = "O campo altura deve ser um número maior que 0";

	        if ($this->system->input['imagem_perfil_tamanho'] == '')
	        	$retorno['msg'][] = "O campo tamanho deve ser preenchido";
	        elseif (intval($this->system->input['imagem_perfil_tamanho']) == 0) 
	        	$retorno['msg'][] = "O campo tamanho deve ser um número maior que 0";
	    }


		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ======================= CERTIFICADOS ==========================
	private function doEdicaoCertificados() {
		$editarPorcentagem = intval($this->system->input['editarPorcentagem']);
		$editarModelo = intval($this->system->input['editarModelo']);
		
		//Porcentagem
		if ($editarPorcentagem) {
			$erro_msg = $this->validarDadosCertificados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('porcentagem', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarCertificados($this->system->input);
				$this->system->view->assign('msg_alert', 'Porcentagem atualizada com sucesso!');
				$this->system->view->assign('porcentagem', $this->system->input);
			}
		} else {
		    $this->system->view->assign('porcentagem', $this->system->configuracoesgerais->getCertificadoPorcentagem());
		}

		//Modelo
		if ($editarModelo) {
			$erro_msg = $this->validarDadosCertificados();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('modelo', $this->system->input);
			} else {
				//IMG Modelo
				if (is_uploaded_file($_FILES['imagem']['tmp_name'])) {
					$extensao = end(explode('.', $_FILES['imagem']['name']));
					$nomearquivo = 'certificado_modelo.'.$extensao;
					if (file_exists($this->system->getUploadPath().'/certificados/'.$nomearquivo))
						unlink($this->system->getUploadPath().'/certificados/'.$nomearquivo);
					copy($_FILES['imagem']['tmp_name'], $this->system->getUploadPath().'/certificados/'.$nomearquivo);
					$this->system->configuracoesgerais->atualizarCertificados(array('certificado_modelo' => $nomearquivo));
				}

				$this->system->view->assign('msg_alert', 'Modelo atualizado com sucesso!');
				$this->system->view->assign('modelo', array('certificado_modelo' => $nomearquivo));
			}
		} else {
		    $this->system->view->assign('modelo', $this->system->configuracoesgerais->getCertificadoModelo());
		}

		$this->system->admin->topo(13);
		$this->system->view->display('administrador-geral/configuracoes_certificado.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDadosCertificados() {
		
		//Porcentagem
		if ($this->system->input['editarPorcentagem']) {
	        if ($this->system->input['certificado_porcentagem'] == '')
	        	$retorno['msg'][] = "O campo porcetagem deve ser preenchido";
	        elseif (intval($this->system->input['certificado_porcentagem']) == 0) 
	        	$retorno['msg'][] = "O campo porcetagem deve ser um número maior que 0";
	    }

	    //Modelo
		if ($this->system->input['editarModelo']) {
			if ($_FILES['imagem']['size'] == 0)
				$retorno['msg'][] = 'Selecione uma imagem';
	        elseif (is_uploaded_file($_FILES['imagem']['tmp_name'])) {
				$extensao = end(explode('.', $_FILES['imagem']['name']));
				if (in_array($extensao, array('jpg', 'jpeg', 'gif', 'png'))) {
					if ($_FILES['imagem']['size'] > 2097152) {
						$retorno['msg'][] = 'A Imagem do destaque está com mais de 2mb';
					}
				} else {
					$retorno['msg'][] = 'Formato de Imagem do destaque inválido';
				}
			} 
	    }

		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ======================= SERVIDORES ==========================
	private function doEdicaoServidores() {
		$editar = intval($this->system->input['editar']);
		
		//Servidor
		if ($editar) {
			$this->system->configuracoesgerais->atualizarServidor($this->system->input);
			$this->system->view->assign('msg_alert', 'Servidor atualizado com sucesso!');
			$this->system->view->assign('servidor', $this->system->input);
		} else {
		    $this->system->view->assign('servidor', $this->system->configuracoesgerais->getServidor());
		}
		
		$this->system->admin->topo(13);
		$this->system->view->display('administrador-geral/configuracoes_servidores.tpl');
		$this->system->admin->rodape();
	}
	// ======================= GRAFICA ==========================
	private function doEdicaoGrafica() {
		$editar = intval($this->system->input['editar']);
		
		if ($editar) {
			$erro_msg = $this->validarDadosGrafica();
			
			if ($erro_msg) {
				$this->system->view->assign('msg_alert', $erro_msg['msg']);
				$this->system->view->assign('graficas', $this->system->input);
			} else {
				$this->system->configuracoesgerais->atualizarGraficas($this->system->input);
				$this->system->view->assign('msg_alert', 'Gráficas atualizadas com sucesso!');
				$this->system->view->assign('graficas', $this->system->input);
			}
		} else {
		    $this->system->view->assign('graficas', $this->system->configuracoesgerais->getGraficas());
		}

		$this->system->admin->topo(13);
		$this->system->view->display('administrador-geral/configuracoes_graficas.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function validarDadosGrafica() {
		
        if ($this->system->input['grafica_email_1'] == '')
        	$retorno['msg'][] = "O campo E-mail Principal deve ser preenchido";
        elseif(!$this->system->func->checkEmail($this->system->input['grafica_email_1']))
        	$retorno['msg'][] = "O campo E-mail Principal não é um e-mail válido";

		if ($this->system->input['grafica_email_2'] != '')
        	if(!$this->system->func->checkEmail($this->system->input['grafica_email_2']))
        		$retorno['msg'][] = "O campo E-mail Opcional 1 não é um e-mail válido";

        if ($this->system->input['grafica_email_3'] != '')
        	if(!$this->system->func->checkEmail($this->system->input['grafica_email_3']))
        		$retorno['msg'][] = "O campo E-mail Opcional 2 não é um e-mail válido";        

		if (count($retorno) > 0)
		   $retorno['msg'] = implode("<br/>",$retorno['msg']);
        return $retorno;
	}
	// ===============================================================
	private function doPdf() {
		$this->system->func->htmlToPdf($this->getHtml());
	}
	// ===============================================================
	private function doJpg() {
		$this->system->func->htmlToJpg($this->getHtml());
	}
	// ===============================================================
	private function getHtml() {
		$html = "<html>
					<body>Teste</body>
				</html>";
		return $html;
	}
	// ===============================================================
	private function pagina404() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================
