<?php
    
    

         require("Pagarme.php");

        Pagarme::setApiKey("ak_test_VI0RjtmUyIqfXUUYdLHGDOCEUHoUtk");
        //R$ 14,99 = 1499
        $transaction = new PagarMe_Transaction(array(
            'amount' => 19999,
            'payment_method' => "boleto",
            'postback_url' => "http://requestb.in/1gmoytx1",
            'boleto_expiration_date' => (date('d/m/Y', strtotime(date('d-m-Y') . ' + 7 days'))),            
            "customer" => array(
                "name" => "Thiago",
                "document_number" => "135.105.251-91",
                "email" => "eltonsarmento@hotmail.com",
                "address" => array(
                    "street" => "Av. Brigadeiro Faria Lima",
                    "neighborhood" => "Jardim Paulistano",
                    "zipcode" => "01452000",
                    "street_number" => "2941",
                    "complementary" => "8º andar"
                ),
                "phone" => array(
                    "ddd" => "11",
                    "number" => "30713261"
                ),
                
            
        )));

        $transaction->charge();

        $boleto_url = $transaction->boleto_url; // URL do boleto bancário
        $boleto_barcode = $transaction->boleto_barcode; // código de barras do boleto bancário

        $transaction->charge();        
    
       
?>
