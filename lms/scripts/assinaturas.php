<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//load
$system->load->dao('planos');
$system->load->dao('pagseguro');
$system->load->model('pagamento_model');
$system->load->model('pagseguro_model');


$fields['venda_id'] = '3415';
$fields['data'] = '2014-09-22T14:18:35.000-03:00';
$dataInicial = substr($fields['data'], 0, 10) . ' 00:00';
$dataFinal = substr($fields['data'], 0, 10) . ' 23:59';
//$preApprovalCode = $system->pagseguro_model->getPreApprovalCodeByVenda(intval($fields['venda_id']), $dataInicial, $dataFinal);
//echo $preApprovalCode;die;
var_dump($system->pagseguro_model->consultarAssinatura('C55720D537377E1CC465AFB65EF6E984'));die;
//var
//$codigos = array('F4E9A0CE767607F004E3EFAE8DB69F7B');



// foreach($codigos as $codePagSeguro) {
//  	var_dump($system->pagseguro_model->consultarAssinatura($codePagSeguro));
//  	$system->pagseguro_model->suspenderAssinatura($codePagSeguro);
//  	var_dump($system->pagseguro_model->consultarAssinatura($codePagSeguro));
//  	echo "<hr/>";
// }



