<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//daos
$dia = date('d');
$mes = date('m', mktime(0, 0, 0, (date('m')-1), 1, date('Y'))); 
$ano = date('Y', mktime(0, 0, 0, (date('m')-1), 1, date('Y'))); 


//if ($dia == 1) {
	$system->load->dao('pagamentos');
	$system->load->dao('professores');
	$system->load->dao('vendas');
	$system->load->dao('curso');
	$system->load->dao('cupons');
	$system->load->dao('parceiros');

	$professores = $system->professores->getProfessores();	
	//$professores = array(array('id' => 3));

	foreach ($professores as $key => $professor) {

		$totalReceber = 0;
		$percentualComissao = 0;

		$where = " and t2.status = 1 and t1.professor_id = '" . $professor['id'] . "' and t2.data_venda >= '" . $ano ."-". $mes . "-01' and t2.data_venda < '" . date('Y') . "-" . date('m') . "-01'"; 

		$vendas = $system->vendas->getVendasPorCursos($where);
		$percentualComissao = $system->professores->getValorExtra($professor['id'], 'comissao');


		foreach($vendas as $key => $venda) {
			$venda = $system->vendas->getVenda($venda['venda_id']);


		 	//CURSOS
		 	$totalPreco = 0;
		 	$totalPrecoProfessor = 0;
		 	$valorDesconto = 0;
		 	$cursos = array();
			foreach($system->vendas->getCursosByVenda($venda['id']) as $curso) {
		
		 		$totalPreco += $curso['preco_total'];
		 		if ($curso['professor_id'] == $professor['id'])  {

		 			$totalPrecoProfessor += $curso['preco_comissao'];

		 			//Desconto 
		 			$valorDesconto += $curso['preco_desconto'];
		 		}
		 	}

		 	////// TAXA //////
		 	//PagSeguro e MoIP
		 	$valorTaxas = divisaoCustos($venda['valor_taxas']);
		
		 	////// COMISSÃO PARCEIRO (DESCONTO) /////
		 	$valorComissaoParceiro = 0;
		 	if ($venda['parceiro_id']) {
		 		$comissaoParceiro = $system->parceiros->getValorExtra($venda['parceiro_id'], 'comissao');
		 		$valorComissaoParceiro = divisaoCustos(($comissaoParceiro * $venda['valor_total'])/100);		 		
		 	}

		 	////// BRUTO //////
	 		$valorBruto = ($totalPrecoProfessor - $valorComissaoParceiro - $valorTaxas - $valorCupom - $valorDesconto);	 		
		 
		 	////// LÍQUIDO //////
		 	$valorLiquido = (($percentualComissao * $valorBruto)/100);

		 	$totalReceber += $valorLiquido;
		}

		$pagamento = $system->pagamentos->getPagamento(" and t1.usuario_id = '" . $professor['id'] . "' and t1.mes_faturado = '" . $ano ."-". $mes . "-1'");
		if (!$pagamento['id']) {
			$system->pagamentos->cadastrar(array(
				'usuario_id' 		=> $professor['id'],
				'mes_faturado'		=> $ano ."-". $mes . "-1",
				'valor'				=> number_format($totalReceber, 2, '.', ''),
			));
		} else {
			$system->pagamentos->atualizar(array(
				'valor'				=> number_format($totalReceber, 2, '.', ''),
				'data_cadastro'		=> date('Y-m-d H:i:s'),
				),
				"id = '" . $pagamento['id'] . "'"
			);
		}
	}

//}

function divisaoCustos($custo) {
	global $totalPreco, $totalPrecoProfessor;
	$porcentagem = ((100 * $totalPrecoProfessor) / $totalPreco);
	return (($custo * $porcentagem) / 100);
}


echo 'Finalizado';
die;
// ===================================================================