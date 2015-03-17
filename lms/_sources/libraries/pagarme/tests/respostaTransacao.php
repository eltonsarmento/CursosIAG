<?php

	require("Pagarme.php");

    Pagarme::setApiKey("ak_test_VI0RjtmUyIqfXUUYdLHGDOCEUHoUtk");

	$transaction = PagarMe_Transaction::findById("176698");

	$POST['id'] = $transaction->id;
	$POST['fingerprint'] = $transaction->card->fingerprint;
	print_r($POST);
	echo'<br><br><br><br>';
	if(PagarMe::validateFingerprint($POST['id'], $POST['fingerprint'])) {
		echo 'valida';
 	}else{
 		echo 'false';
 	}
    
       
?>
    