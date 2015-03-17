<?php
    if(!empty($_POST)){
         $CARD_HASH = $_POST['card_hash'];

         require("Pagarme.php");
         Pagarme::setApiKey("ak_test_VI0RjtmUyIqfXUUYdLHGDOCEUHoUtk");

          $transaction = new PagarMe_Transaction(array(
            "amount" => 19950,            
            "card_hash" => $CARD_HASH,
            'postback_url' => "http://requestb.in/19y3in91",
            "installments" => 3,
            "email" => "eltonsarmento@hotmail.com",
            'metadata' => array(
                    'id_pedido'      => 12345,
                    'curso'          => "java para iniciantes",
                    'valor_do_curso' => "199,50"
            ),
            "customer" => array(
                "name" => "Elton Monteiro",                
                "email" => "eltonsarmento@hotmail.com"                
            )
        ));

        try {
            $transaction->charge();                
            //print "salve seu id : ".$transaction['id'];
            print_r($transaction);
        } catch (PagarMe_Exception $e) {
            $msg = str_replace('consulte nossa documentação em https://pagar.me/docs.', 'consulte nosso FAQ.', $e->getMessage());
            echo '<br> Erro : '.$msg;
            
        }
        
        
     }
       
?>
<html>
<head>
    <meta charset="UTF-8">
  <script src="https://pagar.me/assets/pagarme-v2.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head> 

<body>

  <form id="payment_form" action="transacaoCartaoSemAntifraude.php" method="POST">
    Número do cartão: <input type="text" id="card_number"/>
    <br/>
    Nome (como escrito no cartão): <input type="text" id="card_holder_name"/>
    <br/>
    Mês de expiração: <input type="text" id="card_expiration_month"/>
    <br/>
    Ano de expiração: <input type="text" id="card_expiration_year"/>
    <br/>
    Código de segurança: <input type="text" id="card_cvv"/>
    <br/>
    <div id="field_errors"></div>
    <br/>
    <button type="submit">Enviar</button> 
</form>
</body> 

<script type="text/javascript">
$(document).ready(function() { // quando o jQuery estiver carregado...
    PagarMe.encryption_key = "ek_test_hjju4i8qJQm9hgSnbc1xQsTcTj1s6t";


    var form = $("#payment_form");

    form.submit(function(event) { // quando o form for enviado...
        // inicializa um objeto de cartão de crédito e completa
        // com os dados do form
        var creditCard = new PagarMe.creditCard();
        creditCard.cardHolderName = $("#payment_form #card_holder_name").val();
        creditCard.cardExpirationMonth = $("#payment_form #card_expiration_month").val();
        creditCard.cardExpirationYear = $("#payment_form #card_expiration_year").val();
        creditCard.cardNumber = $("#payment_form #card_number").val();
        creditCard.cardCVV = $("#payment_form #card_cvv").val();


        // pega os erros de validação nos campos do form
        var fieldErrors = creditCard.fieldErrors();

        //Verifica se há erros
        var hasErrors = false;
        var msgErros = '';
        for(var field in fieldErrors) { 
            if(field == "card_number") msgErros = "Número do cartão inválido. ";
            if(field == "card_holder_name") msgErros = " Nome (como escrito no cartão) inválido. ";
            if(field == "card_expiration_month") msgErros = "Mês de inspiração inválido. ";
            if(field == "card_expiration_year") msgErros = "Ano de expiração inválido. ";
            if(field == "card_cvv") msgErros = "Código de segurança inválido. ";
            hasErrors = true; break; 
        }

        if(hasErrors) {
            // realiza o tratamento de errors
            //alert(fieldErrors);
            $('#field_errors').html("<br> ** "+msgErros);
        } else {
            // se não há erros, gera o card_hash...
            creditCard.generateHash(function(cardHash) {
                // ...coloca-o no form...
                form.append($('<input type="hidden" name="card_hash">').val(cardHash));
                // e envia o form
                form.get(0).submit();
            });
        }

        return false;
    });
});

</script>
</html> 
