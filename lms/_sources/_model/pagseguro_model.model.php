<?php
// ===================================================================
// PagSeguro API - Assinaturas
// ===================================================================
class Pagseguro_modelMODEL {
	// ===============================================================
	private $system = null;
	private $urlAPI = 'https://ws.pagseguro.uol.com.br/v2/pre-approvals/';
	private $urlPagamento = 'https://pagseguro.uol.com.br/v2/pre-approvals/request.html?code=';


	private $nomeCliente = '';
	private $emailCliente = '';
	private $referencia = '';
	private $razao = 'IAG - Compra de Assinatura - Pedido ';
	private $valor = 0.00;
	private $periodicidade = 'MONTHLY';
	private $valorMaximo = 0.00;
	private $redirectURL = '';
	private $preApprovalCode = '';

	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();	
		$this->system->load->dao('configuracoesgerais');	
	}
	// ================================================================
	// API Assinatura PagSeguro
	// ================================================================
	private function contaPagSeguro() {
		$pagSeguro = $this->system->configuracoesgerais->getPagseguro();
		
		$dados['email'] = $pagSeguro['pagseguro_email'];
		$dados['token'] = $pagSeguro['pagseguro_token'];

		return $dados;
	}
	// ===============================================================
	public function gerarSolicitacaoPagSeguro() {

		$dados = $this->contaPagSeguro();
		

		//Dados do cliente
		$dados['senderEmail'] 					= $this->getEmailCliente();
		$dados['senderName'] 					= $this->getNomeCliente();

		//Dados da assinatura
		$dados['preApprovalCharge'] 			= 'auto';
		$dados['preApprovalName']				= $this->getReferencia();
		$dados['preApprovalDetails']			= $this->getRazao() . $this->getReferencia();
		$dados['preApprovalAmountPerPayment']	= $this->getValor();
		$dados['preApprovalPeriod']				= $this->getPeriodicidade();
		$dados['preApprovalFinalDate']			= date('Y-m-d\TH:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d'), (date('Y')+2))); //2 anos
		$dados['preApprovalMaxTotalAmount']		= $this->getValorMaximo();
		$dados['redirectURL']					= $this->getRedirectURL();
		$dados['reference']						= $this->getReferencia();

		$dados = http_build_query($dados);

		$curl = curl_init($this->urlAPI . 'request');
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
		$xml = curl_exec($curl);
		curl_close($curl);

		//Problema Token do vendedor
		if ($xml == 'Unauthorized') {
			throw new Exception("Token inválido");
		}

		$xml = simplexml_load_string($xml);
		
		//Erros
		if ($xml[0]->error) {
			$erros = array();

			foreach ($xml as $erro) 
				$erros[] = $erro->message;

			throw new Exception(implode(", ", $erros));
		}

		if (isset($xml->code)) {
			return $this->getUrlPagamento() . $xml->code;
		}
	}

	// =================================================================
	public function suspenderAssinatura($codePagSeguro) {
		$dados = $this->contaPagSeguro();

		$dados = '?' . http_build_query($dados);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->urlAPI . 'cancel/' . $codePagSeguro . $dados);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		
		$xml = curl_exec($curl);
		curl_close($curl);		

		//Problema Token do vendedor
		if ($xml == 'Unauthorized') {
			throw new Exception("Token inválido");
		}

		$xml = simplexml_load_string($xml);
		
		//Erros
		if ($xml[0]->error) {
			$erros = array();

			foreach ($xml as $erro) 
				$erros[] = $erro->message;

			throw new Exception(implode(", ", $erros));
		}

		return ($xml->status == 'OK'? true : false);	
	}

	// =================================================================
	public function consultarAssinatura($codePagSeguro) {
		$dados = $this->contaPagSeguro();

		$dados = '?' . http_build_query($dados);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->urlAPI . $codePagSeguro . $dados);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		$xml = curl_exec($curl);
		curl_close($curl);

		//Problema Token do vendedor
		if ($xml == 'Unauthorized') {
			throw new Exception("Token inválido");
		}

		$xml = simplexml_load_string($xml);
		
		//Erros
		if ($xml[0]->error) {
			$erros = array();

			foreach ($xml as $erro) 
				$erros[] = $erro->message;

			throw new Exception(implode(", ", $erros));
		}

		if ($xml->code == $codePagSeguro) {
			return $xml;
		}
	}
	// ================================================================
	public function consultarAssinaturaIntervalo($interval = 30) {
		$dados = $this->contaPagSeguro();

		$dados['interval'] = $interval;
		$dados = '?' . http_build_query($dados);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->urlAPI . 'notifications' . $dados);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		$xml = curl_exec($curl);
		curl_close($curl);

		//Problema Token do vendedor
		if ($xml == 'Unauthorized') {
			throw new Exception("Token inválido");
		}

		$xml = simplexml_load_string($xml);
		
		//Erros
		if ($xml[0]->error) {
			$erros = array();

			foreach ($xml as $erro) 
				$erros[] = $erro->message;

			throw new Exception(implode(", ", $erros));
		}

		if (count($xml->totalPages)) {
			return $xml;
		}
	}
	// ================================================================
	public function consultarAssinaturaPeriodo($dataInicial, $dataFinal, $maxPageResults = 100, $page = 1) {
		$dados = $this->contaPagSeguro();

		$dados['initialDate'] = date('Y-m-d\TH:i', strtotime($dataInicial));
		$dados['finalDate'] = date('Y-m-d\TH:i', strtotime($dataFinal));
		$dados['maxPageResults'] = $maxPageResults;
		$dados['page'] = $page;
		$dados = '?' . http_build_query($dados);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->urlAPI . $dados);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		$xml = curl_exec($curl);
		curl_close($curl);

		//Problema Token do vendedor
		if ($xml == 'Unauthorized') {
			throw new Exception("Token inválido");
		}

		$xml = simplexml_load_string($xml);
		
		//Erros
		if ($xml[0]->error) {
			$erros = array();

			foreach ($xml as $erro) 
				$erros[] = $erro->message;

			throw new Exception(implode(", ", $erros));
		}

		if (count($xml->totalPages)) {
			return $xml;
		}
	}
	// =================================================================
	// Util
	// =================================================================
	public function validarPeriodo($periodo) {
		return in_array($periodo, array(1, 2, 3, 6, 12));
	}

	// ================================================================
	public function getPreApprovalCodeByVenda($vendaID, $dataInicial = '', $dataFinal = '') {
		try {
			if ($dataInicial && $dataFinal)
				$xml = $this->consultarAssinaturaPeriodo($dataInicial, $dataFinal);
			else
				$xml = $this->consultarAssinaturaIntervalo(30);
		
			foreach ($xml->preApprovals->preApproval as $preApproval) {
				if ($vendaID == $preApproval->name) {
					return $preApproval->code;
				}
			}	
			//Não achou 
			return false;

		} catch (Exception $e) {
			return false;
		}
	}
	// =================================================================
	// GET e SET
	// =================================================================
	public function getUrlPagamento() {
	    return $this->urlPagamento;
	}
	 
	public function getNomeCliente() {
	    return $this->nomeCliente;
	}
	 
	public function setNomeCliente($nomeCliente) {
	    return $this->nomeCliente = $nomeCliente;
	}
	// ================================================================
	public function getEmailCliente() {
	    return $this->emailCliente;
	}
	 
	public function setEmailCliente($emailCliente) {
	    return $this->emailCliente = $emailCliente;
	}
	// ================================================================
	public function getReferencia() {
	    return $this->referencia;
	}
	 
	public function setReferencia($referencia) {
	    return $this->referencia = $referencia;
	}
	// ================================================================
	public function getRazao() {
	    return $this->razao;
	}
	 
	public function setRazao($razao) {
	    return $this->razao = $razao;
	}
	// ================================================================
	public function getValor() {
	    return $this->valor;
	}
	 
	public function setValor($valor) {
	    return $this->valor = $valor;
	}
	// ================================================================
	public function getPeriodicidade() {
	    return $this->periodicidade;
	}
	 
	public function setPeriodicidade($periodicidade) {
		switch($periodicidade) {
			case 1:
				$this->periodicidade = 'MONTHLY';
				break;
			case 2:
				$this->periodicidade = 'BIMONTHLY';
				break;
			case 3:
				$this->periodicidade = 'TRIMONTHLY';
				break;
			case 6:
				$this->periodicidade = 'SEMIANNUALLY';
				break;
			case 12:
				$this->periodicidade = 'YEARLY';
				break;
			default:
				$this->periodicidade = '-'; //error
				break;
		}

	    return $this->periodicidade;
	}
	// ================================================================
	public function getValorMaximo() {
		if ($this->periodicidade == 0.00) {
			switch ($this->periodicidade) {
				case 'MONTHLY':
					$this->valorMaximo = $this->valor * 24;
					break;
				case 'BIMONTHLY':
					$this->valorMaximo = $this->valor * 12;
					break;
				case 'TRIMONTHLY':
					$this->valorMaximo = $this->valor * 8;
					break;
				case 'SEMIANNUALLY':
					$this->valorMaximo = $this->valor * 4;
					break;
				case 'YEARLY':
					$this->valorMaximo = $this->valor * 2;
					break;
			}	
		}
		
	    return number_format($this->valorMaximo, 2, '.', '');
	}
	 
	public function setValorMaximo($valorMaximo) {
	    return $this->valorMaximo = $valorMaximo;
	}
	// ================================================================
	public function getRedirectURL() {
	    return $this->redirectURL;
	}
	 
	public function setRedirectURL($redirectURL) {
	    return $this->redirectURL = $redirectURL;
	}
	// ================================================================
	public function getPreApprovalCode() {
	    return $this->preApprovalCode;
	}
	 
	public function setPreApprovalCode($preApprovalCode) {
	    return $this->preApprovalCode = $preApprovalCode;
	}

}
// ===================================================================