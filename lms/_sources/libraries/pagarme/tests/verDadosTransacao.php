<?php   
require("Pagarme.php");
Pagarme::setApiKey("ak_test_VI0RjtmUyIqfXUUYdLHGDOCEUHoUtk");

$transaction = PagarMe_Transaction::findById("177784");

$TRANSACAO = formataValoresTransacao($transaction);



echo utf8_decode("valor da transação : ".$TRANSACAO['total']);
echo "<br>valor de custo : ".$TRANSACAO['transacao_custo'];
echo '<br><br><br><br><br>';
print_r($TRANSACAO);

//echo '<br><br><br><br><br>';       
//print_r($transaction);


function formataValoresTransacao($transaction){

    $valor_transacao       = substr($transaction->amount, 0, -2) . '.' . substr($transaction->amount, -2);
    $custo 			       = number_format($transaction->cost,0, '.', '');    
    $valor_custo	       = substr($custo, 0, -2) . '.' . substr($custo, -2);    
    $TRANSACAO['parcelas'] = $transaction->installments;

    if($TRANSACAO['parcelas'] >= 2 && $TRANSACAO['parcelas'] <= 6) $TRANSACAO['taxas'] = (1.49 + 2.60);
    else if($TRANSACAO['parcelas'] >= 7 && $TRANSACAO['parcelas'] <= 12) $TRANSACAO['taxas'] = (1.49 + 2.9);
    else $TRANSACAO['taxas'] = (1.49 + 2.5);

    $TRANSACAO['total'] = number_format($valor_transacao, 2, '.', '');
    $TRANSACAO['transacao_custo'] = number_format($valor_custo, 2, '.', '');
    $TRANSACAO['total_liquido']   = number_format(($TRANSACAO['total'] - $TRANSACAO['transacao_custo']), 2, '.', '');
   
    $valores['taxa_05']  = (0.5 * 100) / substr($transaction->amount, 0, -2);
    $valores['taxa_05']  = number_format($valores['taxa_05'], 2, '.', '');
    $TRANSACAO['taxas']  = $TRANSACAO['taxas'] + $valores['taxa_05'];    


    $TRANSACAO['id']       = $transaction->id;
    $TRANSACAO['venda_id'] = $transaction->metadata->id_pedido;
    $TRANSACAO['status']   = $transaction->status;
    $TRANSACAO['data']     = $transaction->date_created;
    //Cliente
    $TRANSACAO['cliente_nome']       = $transaction->customer->name;    
    $TRANSACAO['cliente_email']      = $transaction->customer->email;
    $TRANSACAO['cliente_id']         = $transaction->customer->id;
    //CARTÃO
    $TRANSACAO['cartao_nome']         = $transaction->card->holder_name;
    $TRANSACAO['cartao_fingerprint']  = $transaction->card->fingerprint;
    $TRANSACAO['cartao_id']           = $transaction->card->id;    

    return $TRANSACAO;
}
?>
