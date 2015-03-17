<?php
require_once(dirname(__FILE__).'/../_sources/libraries/pagseguro/PagSeguroLibrary.php');


// //Gera Credenciais
// $emailCredencial = "adriano@cursosiag.com.br";
// $token = "53218CFE90E240D6B7E5DFB8C0BFF78E";
// $credenciais = new PagSeguroAccountCredentials($emailCredencial, $token);

// //Obter transações por data
// if ($_GET['lista_transacoes']) {
// 	$pageNumber = 1;
// 	$maxPageResults = 100;
// 	//$dataInicial = date('Y-m-d').'T00:00';
// 	$dataInicial = '2014-07-10T00:00';
// 	$dataFinal = '2014-07-19T23:59'; 
// 	//$dataFinal 	 = date('Y-m-d\TH:i'); 
// 	$transacao = PagSeguroTransactionSearchService::searchByDate($credenciais, $pageNumber, $maxPageResults, $dataInicial, $dataFinal);
// 	$result = $transacao->getTransactions();
// 	print_r($result);
// 	echo "FIM";die;

// }
//Obtem informações da Transacao
// if ($_GET['transacao']) {
// 	$codeTransacao = '93C32315-E86E-4F7E-9CD5-B6371614AFA3';
// 	$transacao = PagSeguroTransactionSearchService::searchByCode($credenciais, $codeTransacao);
// 	print_r($transacao);
// }