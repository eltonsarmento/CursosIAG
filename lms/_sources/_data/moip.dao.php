<?php
// ===================================================================
class MoipDAO {
	// ===============================================================
	private $system = null;
	private $urlAPI = 'https://api.moip.com.br/';
	//private $urlAPI = 'https://sandbox.moip.com.br/';
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();	
		$this->system->load->dao('configuracoesgerais');	
	}
	// ===============================================================
	public function getTransacao($id) {
		$query = $this->system->sql->select('*', 'moip_nasp', "id_transacao = '" . intval($id) . "' ");
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	// NASP
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('moip_nasp', array(
			'id_transacao'		=> $input['id_transacao'],
			'valor'				=> intval($input['valor']),
			'status_pagamento'	=> intval($input['status_pagamento']),
			'cod_moip'			=> intval($input['cod_moip']),
			'forma_pagamento'	=> intval($input['forma_desconto']),
			'tipo_pagamento'	=> trim($input['tipo_pagamento']),
			'parcelas'			=> intval($input['status']),
			'recebedor_login'	=> trim($input['recebedor_login']),
			'email_consumidor'	=> trim($input['email_consumidor'])
		));
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('moip_nasp', array(
			'valor'				=> intval($input['valor']),
			'status_pagamento'	=> intval($input['status_pagamento']),
			'cod_moip'			=> intval($input['cod_moip']),
			'forma_pagamento'	=> intval($input['forma_desconto']),
			'tipo_pagamento'	=> trim($input['tipo_pagamento']),
			'parcelas'			=> intval($input['status']),
			'recebedor_login'	=> trim($input['recebedor_login']),
			'email_consumidor'	=> trim($input['email_consumidor'])
		), "id_transacao = '" . $input['id_transacao'] . "'");
	}
	// ================================================================
	// API Assinatura 
	// ================================================================
	private function acessAPIBasic() {
		$moip = $this->system->configuracoesgerais->getMoip();

		$key = $moip['moip_key'];
    	$token = $moip['moip_token'];

		// $key = 'O4SJ40MXEHCGTKLIUFNNRYOUTJEU531NOYEYJGXA';
		// $token = 'SCKULTGPUHWAIRZOVPLFR4RLU4MAZKMI';
		return base64_encode($token . ':' . $key);
	}
	// ================================================================
	public function cadastrarPlano($plano) { 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/plans"); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($plano));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic() , "Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		$erro = json_decode($response, true);
		if(count($erro['errors'])) {
		    $erro = $erro['errors'][0]['description'];
		    throw new Exception($erro);
		}
	}
	// =================================================================
	public function alterarPlano($plano) { 
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/plans/" . $plano['code']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($plano));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);
		
		$erro = json_decode($response, true);
		if(count($erro['errors'])) {
		    $erro = $erro['errors'][0]['description'];
		    throw new Exception($erro);
		}
	}
	// =================================================================
	public function ativarPlano($code) { 
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/plans/" . $code . "/activate"); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		echo curl_error($ch);
		curl_close($ch);	
	}
	// =================================================================
	public function desativarPlano($code) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/plans/" . $code . "/inactivate");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		echo curl_error($ch);
		curl_close($ch);
	}
	// ==================================================================
	public function cadastrarAssinatura($assinatura, $usuarioNovo = true) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/subscriptions?new_customer=" . ($usuarioNovo ? 'true' : 'false')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($assinatura));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		$erro = json_decode($response, true);
		if(count($erro['errors'])) {
		    $erro = $erro['errors'][0]['description'];
		    throw new Exception($erro);
		}		
	}
	// ==================================================================
	public function ativarAssinatura($codeAssinatura) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/subscriptions/" . $codeAssinatura . "/activate");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		echo curl_error($ch);
		curl_close($ch);			
	}
	// ==================================================================
	public function suspenderAssinatura($codeAssinatura) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/subscriptions/" . $codeAssinatura . "/suspend");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		echo curl_error($ch);
		curl_close($ch);			
	}
	// ==================================================================
	public function obterDadosAssinatura($codeAssinatura) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/subscriptions/" . $codeAssinatura . "/invoices"); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		echo curl_error($ch);
		curl_close($ch);

		$dados = json_decode($response, true);
		if(count($dados['errors'])) {
		    throw new Exception($erro);
		}
		return $dados;
	}
	// ====================================================================
	public function obterDadosCliente($codeCliente) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/customers/".$codeCliente); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		$dados = json_decode($response, true);
		if(count($dados['errors'])) {
		    return false;
		}
		return $dados;
	}
	// =====================================================================
	public function atualizarDadosCliente($cliente) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/customers/" . $cliente['code']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($cliente));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		$erro = json_decode($response, true);
		if(count($erro['errors'])) {
		    $erro = $erro['errors'][0]['description'];
		    throw new Exception($erro);
		}		
	}
	// ========================================================================
	public function atualizarDadosCartao($cliente) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->urlAPI . "assinaturas/v1/customers/" . $cliente['code'] . "/billing_infos");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($cliente['billing_info']));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->acessAPIBasic(), "Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		$erro = json_decode($response, true);
		if(count($erro['errors'])) {
		    $erro = $erro['errors'][0]['description'];
		    throw new Exception($erro);
		}	
	}
	
}
// ===================================================================