<?php
   
  
    //=====================================================================================================
    //Armazenando um cartão 
    //=====================================================================================================
    require("Pagarme.php");

    Pagarme::setApiKey("ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0");

    $card = new PagarMe_Card(array(
        'card_hash' => "{CARD_HASH}"
    ));

    $card->create();

    $card_id = $card->id;

    //depois salva o card id para posteriormento busca-lo e refazer a compra;


    //=====================================================================================================
    // Recuperando o cartão de uma transação anterior
    //=====================================================================================================
    Pagarme::setApiKey("ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0");

    $transaction = PagarMe_Transaction::findById("{ID DA TRANSAÇÃO}"),
    $card_id = $transaction->card->id;
    //=====================================================================================================
    // Realizando uma transação usando um cartão
    //=====================================================================================================
    Pagarme::setApiKey("ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0");

    $transaction = new PagarMe_Transaction(array(
        'amount' => 1000,
        'card' => PagarMe_Card::findById("{ID DO CARTÃO}"),
    ));

    $transaction->charge();
    
?>