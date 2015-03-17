<?php
   
  
    //=====================================================================================================
    //Criando um plano
    //
    //Parametros:
    //name              —      Nome do plano. Ex: Plano Gold
    //amount            —      Valor a ser cobrado (em centavos). Ex: R$14,99 = 1499
    //days              —      Dias de duração do plano
    //trial_days        0      Dias de duração do período de trial
    //payment_methods credit_card,boleto  Meios de pagamento aceitos para o plano
    //charges          null    Número de vezes que o usuário deverá ser cobrado. null irá cobrar o usuário indefinidamente, ou até que o plano seja cancelado.
    //installments      1      Número de parcelas a ser cobrado no cartão de crédito. Útil para planos anuais em que o usuário irá parcelar o valor ao longo dos 12 meses.
    //=====================================================================================================
    require("Pagarme.php");

    Pagarme::setApiKey("ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0");

    $plan = new PagarMe_Plan(array(
        'amount' => 4990,
        'days' => 30,
        'name' => "Plano Mensal"
    ));

    $plan->create();

    
    //=====================================================================================================
    // Criando uma assinatura
    //=====================================================================================================
    Pagarme::setApiKey("ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0");

    $subscription = new PagarMe_Subscription(array(
        'plan' => PagarMe_Plan::findById("1234"),
        'card_hash' => "{CARD_HASH}",
        'customer' => array(
            'email' => "email.do.cliente@gmail.com"
        )
    ));

    $subscription->create();
    //1234 pelo ID do plano,
    //{CARD_HASH} pelo card_hash gerado no browser do cliente,
    //
    //=====================================================================================================
    //Recebendo notificações de mudança de status (POSTback)
    //=====================================================================================================
    //
    //Ao fornecer uma postback_url ao criar a assinatura, iremos notificar sua aplicação sempre que o status da assinatura mudar. 
    //Dessa forma, você pode cortar e reativar o serviço de um cliente baseado nas mudanças de status da assinatura.

    Pagarme::setApiKey("ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0");

    $subscription = new PagarMe_Subscription(array(
        'plan' => PagarMe_Plan::findById("1234"),
        'card_hash' => "{CARD_HASH}",
        'customer' => array(
            'email' => "email.do.cliente@gmail.com"
        ),
        'postback_url' => "http://seusite.com/subscriptions/2718"
    ));

    $subscription->create();   
    //=====================================================================================================
    //Cancelando uma assinatura
    //=====================================================================================================
     Pagarme::setApiKey("ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0");

    $subscription = PagarMe_Subscription::findById({ID da Assinatura});
    $subscription->cancel(); // Cancel

    if($subscription->getStatus() == 'canceled') {
        // cancelado
    }
    //Não se esqueça de substituir:
    //- {ID da Assinatura} pelo ID da assinatura,
    //
    //=====================================================================================================
    //Fluxo de cobrança
    //=====================================================================================================
    //Toda assinatura tem um "current_period_start" e um "current_period_end", indicando, respectivamente, o início e o fim do período de cobrança atual.
    //Dessa forma, uma assinatura com um plano de 30 dias criada hoje, terá hoje como current_period_start, e daqui a 30 dias como current_period_end.
    //As cobranças serão sempre realizadas na data do current_period_end.
    //A última transação realizada dentro de uma assinatura está disponível na variável "current_transaction". 
    //Dessa forma, você pode acessar, por exemplo, os dados do boleto bancário da assinatura sem precisar realizar outra requisição.

    //NA CRIAÇÃO DA ASSINATURA
    //
    //CARTÃO DE CRÉDITO
    //status paid ou trialing ou Caso a primeira cobrança ou a validação do cartão de crédito falhe, a assinatura não será criada e um erro será retornado.
    //
    //BOLETO BANCÁRIO
    //
    //será emitido um boleto com 7 dias de validade.A assinatura terá status unpaid até que o boleto bancários seja pago. 
    //Ao detectarmos o pagamento, o status mudará para paid.       
    //Se o plano tiver um período de trial, o boleto será emitido com data de validade para o fim do período de trial e a assinatura terá status trialing. 
    //Ao fim do trial, se o boleto for pago, a assinatura irá para o status paid.
    //Caso o boleto não tenha sido pago até o fim do trial, a assinatura passará para unpaid.
    //
    //=====================================================================================================
    //AO FIM DO PERÍODO DE COBRANÇA ATUAL
    //
    //CARTÃO DE CRÉDITO
    //Ao fim do período atual (current_period_end), iremos realizar a próxima cobrança na assinatura. 
    //Se a cobrança ocorrer com sucesso, a assinatura permanecerá no status paid, e o current_period_start e current_period_end serão atualizados.
    //Caso a cobrança falhe por algum motivo (falta de saldo, transação negada pelo banco, etc), 
    //a assinatura entrará no status pending_payment e o usuário será notificado por e-mail.
    //
    //BOLETO BANCÁRIO
    //Sempre que um boleto de uma assinatura é pago, o próximo boleto é emitido e já está disponível para pagamento. 
    //Dessa forma, após o último pagamento, o boleto correspondente ao período atual já poderá ser pago pelo cliente.
    //
    //Ao detectarmos o pagamento do boleto do período atual, a assinatura continuará com o status paid e o current_period_start e current_period_end 
    //serão atualizados respeitando a data de pagamento do boleto. Dessa forma, se o usuário efetuar o pagamento 5 dias antes do fim do período atual, 
    //o current_period_end terá um acréscimo de 5 dias.
    //
    //Caso o boleto não seja pago até o fim do período, a assinatura entrará no status pending_payment e o usuário será notificado por e-mail.
    //
    //=====================================================================================================
    //DURANTE O STATUS PENDING_PAYMENT
    //Quando a assinatura atinge o fim do período atual sem ser paga, a mesma muda para o status pending_payment. Durante esse status, 
    //tentaremos cobrar o usuário todos os dias e iremos notificá-lo por e-mail caso o pagamento falhe ou não seja detectado novamente.    
    //
    //Sempre que o usuário é notificado por e-mail, mandamos um link para uma página onde ele poderá alterar a forma de pagamento ou 
    //o cartão de crédito utilizado na assinatura.
    //
    //O tempo que a assinatura ficará pending_payment caso o pagamento não seja detectado é, por padrão, de 5 dias. 
    //Esse valor (payment_deadline) pode ser configurado pelo seu Dashboard e é único para sua conta.
    //Caso após todas as 5 tentativas de cobrança a assinatura continue não paga, a mesma passará para o status unpaid.
    //
    //=====================================================================================================
    //DURANTE O STATUS UNPAID
    //
    //Quando a assinatura atinge o status unpaid, você deve cortar o acesso do usuário ao seu serviço/sistema, pois o mesmo encontra-se inadimplente há 5 dias.
    //Durante o status unpaid, faremos mais 4 tentativas de cobrança com um intervalo de 3 dias entre elas. 
    //Tanto o número de tentativas quanto o intervalo entre elas pode ser configurada pelo seu Dashboard, e são únicos para a sua conta.
    //Você pode, opcionalmente, optar por automaticamente cancelar a assinatura caso após todas as tentativas de cobrança 
    //(do status pending_payment e unpaid) ela continue não paga. Essa opção pode ser configurada pelo seu Dashboard e por padrão está desabilitada.
    //
    //=====================================================================================================
    //DURANTE O STATUS CANCELED
    //
    //Após a assinatura ser cancelada, nenhuma tentativa de cobrança será mais feita. Uma assinatura cancelada não pode ser cobrada novamente.
    //
    //=====================================================================================================

?>