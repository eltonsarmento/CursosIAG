<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//daos
$dia = date('d');
$mes = date('m', mktime(0, 0, 0, (date('m')-1), 1, date('Y')));
$ano = date('Y', mktime(0, 0, 0, (date('m')-1), 1, date('Y')));

//if ($dia == 1) {
	$system->load->dao('parceiros');
	$system->load->dao('vendas');
	$system->load->model('email_model');

	$parceiros = $system->parceiros->getParceiros();	
	$emails = array();
	foreach ($parceiros as $key => $parceiro) {
		$totalRetornar = 0;
		$percentualComissao = 0;

		$percentualComissao = $system->parceiros->getValorExtra($parceiro['id'], 'comissao');
		$totalVendas = number_format($system->vendas->getTotalVendas("and status = 1 and data_venda like '" . $ano . '-' . $mes . "%' and parceiro_id = " . $parceiro['id']), 2, '.', '.');
		$comissao = ($totalVendas * $percentualComissao / 100);

		$totalRetornar = number_format(($totalVendas - $comissao), 2, '.','');
		
		$comprovante = $system->vendas->getComprovante(" and parceiro_id = '" . $parceiro['id'] . "' and mes = '" . $mes . "' and ano = '" . $ano . "'");
		if (!$comprovante['id']) {
			$system->vendas->cadastrarComprovante($parceiro['id'], $totalRetornar, $mes, $ano);

			$usuarioEmail = array();
			$usuarioEmail['nome'] = $parceiro['nome'];
			$usuarioEmail['email'] = $parceiro['email'];
			$emails[] = $usuarioEmail;
		}
	}


	foreach ($emails as $value) 
		$system->email_model->relatorioFechado($value['email'], $value['nome'], $mes, $ano);
//}


echo 'Finalizado';
die;
// ===================================================================