<?php
//require_once(dirname(__FILE__).'/../libraries/pagarme/tests/Pagarme.php');
require_once(dirname(__FILE__).'/../libraries/pagarme/Pagarme.php');
// ===================================================================
// Pagarme API - Assinaturas
// ===================================================================
class Pagarme_modelMODEL {
	// ===============================================================
	private $system = null;

	private $nomeCliente = '';
	private $emailCliente = '';
	private $referencia = '';
	private $razao = 'IAG - Compra de Assinatura - Pedido ';
	private $valor = 0.00;
	private $valorMaximo = 0.00;
	private $redirectURL = '';
	private $plano = '';
	private $notificationURL = '';
	private $card_hash = '';	
	private $formaPagamento = '';
	private $detalhesProdutos = '';

	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();	
		$this->system->load->dao('configuracoesgerais');	
		$this->notificationURL = $this->system->getUrlSite() . 'lms/nasp/pagarme.php';		
		//$this->notificationURL = 'http://requestb.in/pb9qozpb';
	}
	// ================================================================
	// API Assinatura Pagarme
	// ================================================================
	private function contaPagarme() {
		$pagarme = $this->system->configuracoesgerais->getPagarme();

		$dados['key_api'] 		   = $pagarme['pagarme_key_api'];
		$dados['key_criptografia'] = $pagarme['pagarme_key_criptografia'];

		return $dados;
	}
	// ===============================================================
	public function gerarSolicitacaoPagarmeAssinatura() {

		$dados = $this->contaPagarme();

		Pagarme::setApiKey($dados['key_api']);
		
		if($this->formaPagamento == 'boleto'){
			$subscription = new PagarMe_Subscription(array(
		        'plan' => PagarMe_Plan::findById($this->plano),	        
		        'postback_url' => $this->notificationURL,
		        "payment_method" => $this->formaPagamento,
		        'customer'  => array(
		            'email' =>  $this->getEmailCliente(),
		            'nome'  =>  $this->getNomeCliente()
		        ),
		        'metadata'  => array(
		            'id_pedido' =>  $this->referencia,
		            'Detalhes Produtos' =>$this->detalhesProdutos	            
		        )	        
		    ));
		}else{
		    $subscription = new PagarMe_Subscription(array(
		        'plan' => PagarMe_Plan::findById($this->plano),
		        'card_hash' => $this->card_hash,
		        'postback_url' => $this->notificationURL,
		        "payment_method" => $this->formaPagamento,
		        'customer'  => array(
		            'email' =>  $this->getEmailCliente(),
		            'nome'  =>  $this->getNomeCliente()
		        ),
		        'metadata'  => array(
		            'id_pedido' =>  $this->referencia,
		            'Detalhes Produtos' =>$this->detalhesProdutos            
		        )	        
		    ));
		}

		try {
            $subscription->create();             
            $retorno['pago'] = true;
            $retorno['conteudo'] = $subscription;
            return $retorno;
        } catch (PagarMe_Exception $e) {
        	$retorno['pago'] = false;
            $retorno['conteudo'] = str_replace('consulte nossa documentação em https://pagar.me/docs.', 'consulte nosso FAQ.', $e->getMessage());
            return '<br> Erro : '.$retorno;
            
        }	    
		
	}

	// =================================================================
	public function suspenderAssinatura($codePagarme) {		
		$dados = $this->contaPagarme();

		Pagarme::setApiKey($dados['key_api']);
		

		$transaction = PagarMe_Transaction::findById($codePagarme);			   
        
		$subscription = PagarMe_Subscription::findById($transaction->subscription_id);      

		
		try {    
		    $subscription->cancel();        
		    
		    if($subscription->getStatus() == 'canceled') {		    	
		        return true;
		    }
		} catch (PagarMe_Exception $e) {
		    //$msg = str_replace('consulte nossa documentação em https://pagar.me/docs.', 'consulte nosso FAQ.', $e->getMessage());
		    //print_r($msg);
		    //return '<br> Erro : '.$msg;		    
		    return false;
		    
		}	    
			
	}

	// =================================================================
	public function criarPlano($plano) {
		$dados = $this->contaPagarme();

		Pagarme::setApiKey($dados['key_api']);

	    $plan = new PagarMe_Plan(array(
	        'amount' => str_replace(".","",$plano['valor']),
	        'days' => (intval($plano['meses']) * 30),
	        'name' => $plano['plano']
	    ));

	    $plan->create();

	    return $plan->id;
	}
	// =================================================================
	public function consultarAssinatura($codePagarme) {
		$dados = $this->contaPagarme();
	}
	// ================================================================
	public function consultarAssinaturaIntervalo($interval = 30) {
		$dados = $this->contaPagarme();

		
	}
	// =================================================================
	// Util
	// =================================================================
	public function validarPeriodo($periodo) {
		return in_array($periodo, array(1, 2, 3, 6, 12));
	}

	// ================================================================
	public function formataValoresTransacao($id){

		$dados = $this->contaPagarme();

		Pagarme::setApiKey($dados['key_api']);

		$transaction = PagarMe_Transaction::findById($id);

	    $valor_transacao       = substr($transaction->amount, 0, -2) . '.' . substr($transaction->amount, -2);
	    $custo 			       = number_format($transaction->cost,0, '.', '');    
	    $valor_custo	       = substr($custo, 0, -2) . '.' . substr($custo, -2);    
	    $TRANSACAO['parcelas'] = $transaction->installments;


	    //BOLETO
	    $TRANSACAO['boleto_url']           = $transaction->boleto_url;
	    $TRANSACAO['boleto_barcode']       = $transaction->boleto_barcode;
	    $TRANSACAO['boleto_dataExpiracao'] = substr($transaction->boleto_expiration_date, 0, 10);

	    if(empty($TRANSACAO['boleto_url'])){
	    	if($TRANSACAO['parcelas'] >= 2 && $TRANSACAO['parcelas'] <= 6) $TRANSACAO['taxas'] = (1.49 + 2.60);
	    	else if($TRANSACAO['parcelas'] >= 7 && $TRANSACAO['parcelas'] <= 12) $TRANSACAO['taxas'] = (1.49 + 2.9);
	    	else $TRANSACAO['taxas'] = (1.49 + 2.5);
	    	//cálculo para ver a taxa
	    	$valores['taxa_05']  = (0.5 * 100) / substr($transaction->amount, 0, -2);
	    	$valores['taxa_05']  = number_format($valores['taxa_05'], 2, '.', '');
	    	$TRANSACAO['taxas']  = $TRANSACAO['taxas'] + $valores['taxa_05'];    	    

		}

	    $TRANSACAO['total'] = number_format($valor_transacao, 2, '.', '');
	    $TRANSACAO['transacao_custo'] = number_format($valor_custo, 2, '.', '');
	    $TRANSACAO['total_liquido']   = number_format(($TRANSACAO['total'] - $TRANSACAO['transacao_custo']), 2, '.', '');
	   	    	   

	    $TRANSACAO['id']       			 = $transaction->id;
	    $TRANSACAO['venda_id'] 			 = $transaction->metadata->id_pedido;
	    $TRANSACAO['status']   			 = $transaction->status;
	    $TRANSACAO['data']     			 = $transaction->date_created;
	    $TRANSACAO['ultima_atualizacao'] = $transaction->date_updated;
	    //Cliente
	    $TRANSACAO['cliente_nome']       = $transaction->customer->name;    
	    $TRANSACAO['cliente_email']      = $transaction->customer->email;
	    $TRANSACAO['cliente_id']         = $transaction->customer->id;
	    //CARTÃO
	    $TRANSACAO['cartao_nome']        = $transaction->card->holder_name;
	    $TRANSACAO['cartao_fingerprint'] = $transaction->card->fingerprint;
	    $TRANSACAO['cartao_id']          = $transaction->card->id;    
	    


	    return $TRANSACAO;
	}
	// ================================================================
	public function formataValoresAssinatura($id,$tipo){

		$dados = $this->contaPagarme();

		Pagarme::setApiKey($dados['key_api']);

		if($tipo == 'transaction'){
			$transaction = PagarMe_Transaction::findById($id);
			$subscription = PagarMe_Subscription::findById($transaction->subscription_id);	
		}else{
			$subscription = PagarMe_Subscription::findById($id);
		}

	    $valor_transacao = substr($subscription->current_transaction->amount, 0, -2) . '.' . substr($subscription->current_transaction->amount, -2);
	    if ($subscription->current_transaction->cost == 0) {
	    	$custo = "380";
	    }else{
	    	$custo           = number_format($subscription->current_transaction->cost,0, '.', '');    	
	    }
	    
	    $valor_custo     = substr($custo, 0, -2) . '.' . substr($custo, -2);    
	    $ASSINATURA['parcelas']  = $subscription->current_transaction->installments;

	    //BOLETO
	    $ASSINATURA['boleto_url']           = $subscription->current_transaction->boleto_url;
	    $ASSINATURA['boleto_barcode']  		= $subscription->current_transaction->boleto_barcode;
	    $ASSINATURA['boleto_dataExpiracao'] = substr($subscription->current_transaction->expiration_date, 0, 10);

	    if(empty($ASSINATURA['boleto_url'])){
	    	if($ASSINATURA['parcelas'] >= 2 && $ASSINATURA['parcelas'] <= 6) $ASSINATURA['taxas'] = (1.49 + 2.60);
	    	else if($ASSINATURA['parcelas'] >= 7 && $ASSINATURA['parcelas'] <= 12) $ASSINATURA['taxas'] = (1.49 + 2.9);
	    	else $ASSINATURA['taxas'] = (1.49 + 2.5);

	    	//cálculo para ver a taxa
	    	$ASSINATURA['transacao_taxa_05']    = (0.5 * 100) / substr($subscription->current_transaction->amount, 0, -2);
	    	$ASSINATURA['transacao_taxa_05']    = number_format($ASSINATURA['transacao_taxa_05'], 2, '.', '');
	    	$ASSINATURA['taxas']                = $ASSINATURA['taxas'] + $ASSINATURA['transacao_taxa_05'];
		}

	    $ASSINATURA['total']                = number_format($valor_transacao, 2, '.', '');	    
	    $ASSINATURA['transacao_custo']      = number_format($valor_custo, 2, '.', '');
	    $ASSINATURA['total_liquido']        = number_format(($ASSINATURA['total'] - $ASSINATURA['transacao_custo']), 2, '.', '');	    
	   
	        

	    $ASSINATURA['venda_id'] 			= $subscription->metadata->id_pedido;
	    $ASSINATURA['id']                   = $subscription->current_transaction->id;        
	    $ASSINATURA['id_asinatura']         = $subscription->id;        
	    $ASSINATURA['data']                 = $subscription->current_transaction->date_created;
	    $ASSINATURA['ultima_atualizacao']   = $subscription->current_transaction->date_updated;    
	    $ASSINATURA['status']               = $subscription->status;
	    //DADOS ASSINATURA
	    $ASSINATURA['data_inicio_cobranca'] = substr($subscription->current_period_start, 0, 10) . ' 00:00';
	    $ASSINATURA['data_fim_cobranca']    = substr($subscription->current_period_end, 0, 10) . ' 23:59';
	    //DADOS CARTÃO
	    $ASSINATURA['cartao_fingerprint']   = $subscription->card->fingerprint;
	    $ASSINATURA['cartao_id']            = $subscription->card->id;
	    $ASSINATURA['cartao_nome']          = $subscription->card->holder_name;	    
	    //DADOS PLANO
	    $ASSINATURA['plano_id']             = $subscription->plan->id;
	    $ASSINATURA['plano_valor']          = $subscription->plan->amount;
	    $ASSINATURA['plano_dias']           = $subscription->plan->days;
	    $ASSINATURA['plano_nome']           = $subscription->plan->name;
	    $ASSINATURA['plano_dias_tiral']     = $subscription->plan->trial_days;
	    $ASSINATURA['plano_data_criacao']   = $subscription->plan->date_created;
	    //DADOS CLIENTE
	    $ASSINATURA['cliente_id']           = $subscription->customer->id;
	    $ASSINATURA['cliente_nome']         = $subscription->customer->name;
	    $ASSINATURA['cliente_cpf']          = $subscription->customer->document_number;
	    $ASSINATURA['cliente_email']        = $subscription->customer->email;
	    $ASSINATURA['cliente_nome']         = $subscription->customer->name;

	    return $ASSINATURA;
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
	// ================================================================
	public function getPlano() {
	    return $this->plano;
	}
	 
	public function setPlano($plano) {
	    return $this->plano = $plano;
	}
	// ==============================================================
	public function getNotificationURL() {
	    return $this->notificationURL;
	}
	// ==============================================================
	public function setNotificationURL($notificationURL) {
	    return $this->notificationURL = $notificationURL;
	}
	// ==============================================================
	public function getCardHash() {
	    return $this->card_hash;
	}
	// ==============================================================
	public function setCardHash($card_hash) {
	    return $this->card_hash = $card_hash;
	}
	// ==============================================================
	public function getFormaPagamento() {
	    return $this->formaPagamento;
	}
	// ==============================================================
	public function setFormaPagamento($formaPagamento) {
	    return $this->formaPagamento = $formaPagamento;
	}
	// ==============================================================
	public function getDetalhesProdutos() {
	    return $this->detalhesProdutos;
	}
	// ==============================================================
	public function setDetalhesProdutos($detalhesProdutos) {
	    return $this->detalhesProdutos = $detalhesProdutos;
	}

}
// ===================================================================