<?php
// ===================================================================
class ConfiguracoesgeraisDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// Variação de Produtos
	// ===============================================================
	public function atualizarProdutos($input) {
		$fields = array();
		if (isset($input['produtos_suporte_tipo'])) $fields['produtos_suporte_tipo'] = $input['produtos_suporte_tipo'];
		if (isset($input['produtos_suporte_valor'])) $fields['produtos_suporte_valor'] = $input['produtos_suporte_valor'];
		if (isset($input['produtos_certificado_tipo'])) $fields['produtos_certificado_tipo'] = $input['produtos_certificado_tipo'];
		if (isset($input['produtos_certificado_valor'])) $fields['produtos_certificado_valor'] = $input['produtos_certificado_valor'];
		
		$this->system->sql->update('configuracoes_gerais', $fields);
	}
	// ===============================================================
	public function getProdutosSuporte() {
		$query = $this->system->sql->select('produtos_suporte_tipo, produtos_suporte_valor', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}	
	// ===============================================================
	public function getProdutosCertificados() {
		$query = $this->system->sql->select('produtos_certificado_tipo, produtos_certificado_valor', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// Periodo Acesso
	// ===============================================================
	public function atualizarPeriodoAcesso($input) {
		$fields = array();
		if (isset($input['periodoAcesso'])) $fields['periodo_acesso'] = $input['periodoAcesso'];
		
		$this->system->sql->update('configuracoes_gerais', $fields);
	}
	// ===============================================================
	public function getPeriodoAcesso() {
		$query = $this->system->sql->select('periodo_acesso', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// Termos e Condições
	// ===============================================================
	public function atualizarTermos($input) {
		$fields = array();
		if (isset($input['termos_condicoes'])) $fields['termos_condicoes'] = $input['termos_condicoes'];
		
		$this->system->sql->update('configuracoes_gerais', $fields);
	}
	// ===============================================================
	public function getTermosCondicoes() {
		$query = $this->system->sql->select('termos_condicoes', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// Pagamentos
	// ===============================================================
	public function atualizarPagamentos($input) {		
		$fields = array();
		if (isset($input['pagseguro_email'])) $fields['pagseguro_email'] = $input['pagseguro_email'];
		if (isset($input['pagseguro_token'])) $fields['pagseguro_token'] = $input['pagseguro_token'];
		if (isset($input['pagarme_key_api'])) $fields['pagarme_key_api'] = $input['pagarme_key_api'];		
		if (isset($input['pagarme_key_criptografia'])) $fields['pagarme_key_criptografia'] = $input['pagarme_key_criptografia'];		
		if (isset($input['moip_key'])) $fields['moip_key'] = $input['moip_key'];
		if (isset($input['moip_token'])) $fields['moip_token'] = $input['moip_token'];
		if (isset($input['paypal_usuario'])) $fields['paypal_usuario'] = $input['paypal_usuario'];
		if (isset($input['paypal_senha']) && $input['paypal_senha'] != '') $fields['paypal_senha'] = $input['paypal_senha'];
		if (isset($input['paypal_assinatura'])) $fields['paypal_assinatura'] = $input['paypal_assinatura'];
		
		$this->system->sql->update('configuracoes_api_pagamentos', $fields);
	}
	// ===============================================================
	public function atualizarStatusPagamentos($input) {
		$fields = array();
		if (isset($input['pagseguro_status'])) $fields['pagseguro_status'] = ($input['pagseguro_status'] ? 0 : 1);
		if (isset($input['pagarme_status'])) $fields['pagarme_status'] = ($input['pagarme_status'] ? 0 : 1);
		if (isset($input['moip_status'])) $fields['moip_status'] = ($input['moip_status'] ? 0 : 1 );
		if (isset($input['paypal_status'])) $fields['paypal_status'] = ($input['paypal_status'] ? 0 : 1);
		
		$this->system->sql->update('configuracoes_api_pagamentos', $fields);
	}
	// ===============================================================
	public function getPagseguro() {
		$query = $this->system->sql->select('pagseguro_status, pagseguro_email, pagseguro_token', 'configuracoes_api_pagamentos');	
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getMoip() {
		$query = $this->system->sql->select('moip_status, moip_key, moip_token', 'configuracoes_api_pagamentos');	
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getPayPal() {
		$query = $this->system->sql->select('paypal_status, paypal_usuario, paypal_senha, paypal_assinatura', 'configuracoes_api_pagamentos');	
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getPagarme() {
		$query = $this->system->sql->select('pagarme_status, pagarme_key_api,pagarme_key_criptografia', 'configuracoes_api_pagamentos');	
		$vetor = $this->system->sql->fetchrowset($query);
		return end($vetor);
	}
	// Imagens
	// ===============================================================
	public function atualizarImagens($input) {
		$fields = array();
		if (isset($input['imagem_destacada_largura'])) $fields['imagem_destacada_largura'] = intval($input['imagem_destacada_largura']);
		if (isset($input['imagem_destacada_altura'])) $fields['imagem_destacada_altura'] = intval($input['imagem_destacada_altura']);
		if (isset($input['imagem_destacada_tamanho'])) $fields['imagem_destacada_tamanho'] = intval($input['imagem_destacada_tamanho']);
		if (isset($input['imagem_banner_largura'])) $fields['imagem_banner_largura'] = intval($input['imagem_banner_largura']);
		if (isset($input['imagem_banner_altura'])) $fields['imagem_banner_altura'] = intval($input['imagem_banner_altura']);
		if (isset($input['imagem_banner_tamanho'])) $fields['imagem_banner_tamanho'] = intval($input['imagem_banner_tamanho']);
		if (isset($input['imagem_perfil_largura'])) $fields['imagem_perfil_largura'] = intval($input['imagem_perfil_largura']);
		if (isset($input['imagem_perfil_altura'])) $fields['imagem_perfil_altura'] = intval($input['imagem_perfil_altura']);
		if (isset($input['imagem_perfil_tamanho'])) $fields['imagem_perfil_tamanho'] = intval($input['imagem_perfil_tamanho']);
		
		$this->system->sql->update('configuracoes_gerais', $fields);
	}
	
	// ===============================================================
	public function getImagensDestacada() {
		$query = $this->system->sql->select('imagem_destacada_largura, imagem_destacada_altura, imagem_destacada_tamanho', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getImagensBanner() {
		$query = $this->system->sql->select('imagem_banner_largura, imagem_banner_altura, imagem_banner_tamanho', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getImagensPerfil() {
		$query = $this->system->sql->select('imagem_perfil_largura, imagem_perfil_altura, imagem_perfil_tamanho', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// Certificados
	// ===============================================================
	public function atualizarCertificados($input) {
		$fields = array();
		if (isset($input['certificado_porcentagem'])) $fields['certificado_porcentagem'] = intval($input['certificado_porcentagem']);
		if (isset($input['certificado_modelo'])) $fields['certificado_modelo'] = $input['certificado_modelo'];
		
		$this->system->sql->update('configuracoes_gerais', $fields);
	}
	
	// ===============================================================
	public function getCertificadoPorcentagem() {
		$query = $this->system->sql->select('certificado_porcentagem', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function getCertificadoModelo() {
		$query = $this->system->sql->select('certificado_modelo', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// Servidor
	// ===============================================================
	public function atualizarServidor($input) {
		$fields = array();
		if (isset($input['servidor_padrao'])) $fields['servidor_padrao'] = intval($input['servidor_padrao']);
		
		$this->system->sql->update('configuracoes_gerais', $fields);
	}
	// ===============================================================
	public function getServidor() {
		$query = $this->system->sql->select('servidor_padrao', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
	// Gráfica
	// ===============================================================
	public function atualizarGraficas($input) {
		$fields = array();
		if (isset($input['grafica_email_1'])) $fields['grafica_email_1'] = $input['grafica_email_1'];
		if (isset($input['grafica_email_2'])) $fields['grafica_email_2'] = $input['grafica_email_2'];
		if (isset($input['grafica_email_3'])) $fields['grafica_email_3'] = $input['grafica_email_3'];
		
		$this->system->sql->update('configuracoes_gerais', $fields);
	}
	// ===============================================================
	public function getGraficas() {
		$query = $this->system->sql->select('grafica_email_1, grafica_email_2, grafica_email_3', 'configuracoes_gerais');	
		return end($this->system->sql->fetchrowset($query));
	}
}
// ===================================================================