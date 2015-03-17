<?php   
require("Pagarme.php");
Pagarme::setApiKey("ak_test_VI0RjtmUyIqfXUUYdLHGDOCEUHoUtk");


$subscription = PagarMe_Subscription::findById("13140");
$ASSINATURA = formataValoresAssinatura($subscription);

print_r($ASSINATURA);
echo '<br><br><br><br><br>';
print_r($subscription);

function formataValoresAssinatura($subscription){

    $valor_transacao = substr($subscription->current_transaction->amount, 0, -2) . '.' . substr($subscription->current_transaction->amount, -2);
    $custo           = number_format($subscription->current_transaction->cost,0, '.', '');    
    $valor_custo     = substr($custo, 0, -2) . '.' . substr($custo, -2);    
    $ASSINATURA['parcelas']  = $subscription->current_transaction->installments;

    if($ASSINATURA['parcelas'] >= 2 && $ASSINATURA['parcelas'] <= 6) $ASSINATURA['taxas'] = (1.49 + 2.60);
    else if($ASSINATURA['parcelas'] >= 7 && $ASSINATURA['parcelas'] <= 12) $ASSINATURA['taxas'] = (1.49 + 2.9);
    else $ASSINATURA['taxas'] = (1.49 + 2.5);

    $ASSINATURA['total']                = number_format($valor_transacao, 2, '.', '');
    $ASSINATURA['transacao_custo']      = number_format($valor_custo, 2, '.', '');
    $ASSINATURA['total_liquido']        = number_format(($ASSINATURA['total'] - $ASSINATURA['transacao_custo']), 2, '.', '');
   
    $ASSINATURA['transacao_taxa_05']    = (0.5 * 100) / substr($subscription->current_transaction->amount, 0, -2);
    $ASSINATURA['transacao_taxa_05']    = number_format($ASSINATURA['transacao_taxa_05'], 2, '.', '');
    $ASSINATURA['taxas']                = $ASSINATURA['taxas'] + $ASSINATURA['transacao_taxa_05'];    

    $ASSINATURA['id']                   = $subscription->current_transaction->id;        
    $ASSINATURA['data']                 = $subscription->current_transaction->date_created;
    $ASSINATURA['ultima_atualizacao']   = $subscription->current_transaction->date_updated;    
    $ASSINATURA['status']               = $subscription->current_transaction->status;
    //DADOS ASSINATURA
    $ASSINATURA['data_inicio_cobranca'] = substr($subscription->current_period_start, 0, 10) . ' 00:00';
    $ASSINATURA['data_fim_cobranca']    = substr($subscription->current_period_end, 0, 10) . ' 23:59';
    //DADOS CARTÃO
    $ASSINATURA['cartao_fingerprint']   = $subscription->card->fingerprint;
    $ASSINATURA['cartao_id']            = $subscription->card->id;
    $ASSINATURA['cartao_nome']          = $subscription->card->holder_name;
    //BOLETO
    //DADOS CARTÃO
    $ASSINATURA['boleto_url']           = $subscription->current_transaction->boleto_url;
    $ASSINATURA['boleto_codigoBarras']  = $subscription->current_transaction->boleto_barcode;
    $ASSINATURA['boleto_dataExpiracao'] = $subscription->current_transaction->expiration_date;    
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
?>
