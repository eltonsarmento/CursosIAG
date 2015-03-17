<?php
// ===================================================================
class Vendas {
	// ===============================================================
	private $system = null;
	private $redir = '';
	private $totalPreco;
	private $totalPrecoProfessor;
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('vendas');
		$this->system->load->dao('alunos');
		$this->system->load->dao('curso');
		$this->system->load->dao('parceiros');
		$this->system->load->dao('professores');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'listar': $this->doListar(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	private function doListar() {
		//vendas
		if ($_POST['ano'])
			$ano = $_POST['ano'];
		else
			$ano = date('Y');

		//
		if ($_POST['mes'])
			$mes = $_POST['mes'];
		else
			$mes = date('m');


		$where = " and t2.status = 1 and t1.professor_id = '" . $this->system->session->getItem('session_cod_usuario') . "' and t2.data_venda like '" . $ano . "-" . $mes . "%'";

		$vendas = $this->system->vendas->getVendasPorCursos($where);

		$totalCupons = 0;
		$totalBruto = 0;
		$totalLiquido = 0;
		$totalCompleto = 0;
		$totalTaxas = 0;
		$comissaoPorcentagem = $this->system->professores->getValorExtra($this->system->session->getItem('session_cod_usuario'), 'comissao');

		foreach($vendas as $key => $venda) {
			$venda = $this->system->vendas->getVenda($venda['venda_id']);

		 	$vendas[$key]['cliente'] = $this->system->alunos->getAluno($venda['aluno_id']);
		 	$vendas[$key]['numero'] = $venda['numero'];
		 	$vendas[$key]['status'] = $venda['status'];
		 	$vendas[$key]['data_venda'] = $venda['data_venda'];
		 	$valorDesconto = 0;

		 	//CURSOS
		 	$this->totalPreco = 0;
		 	$this->totalPrecoProfessor = 0;
		 	$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($venda['id']) as $curso) {
		 		$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
		 		$this->totalPreco += $curso['preco_total'];;
		 		if ($curso['professor_id'] == $this->system->session->getItem('session_cod_usuario')) {
		 			$this->totalPrecoProfessor += $curso['preco_comissao'];
		 			$cursos[] = $curso_dados['curso'];

		 			//desconto
		 			$vendas[$key]['valor_desconto'] = $valorDesconto += $curso['preco_desconto'];
		 		}
		 	}
		 	$vendas[$key]['cursos'] = implode('<br/>', $cursos);

		 	////// TAXA //////
		 	//PagSeguro e MoIP
		 	$valorTaxas = $this->divisaoCustos($venda['valor_taxas']);
		 	$vendas[$key]['valor_taxas'] = number_format($valorTaxas, 2, ',', '.');
		 	
		 	
		 	//echo $vendas[$key]['numero'] . '-' . $vendas[$key]['valor_desconto'] . "<br/>";

		 	if ($vendas[$key]['numero'] == "01918") {
		 	
		 	}
		 	////// COMISSÃO PARCEIRO (DESCONTO) /////
		 	$valorComissaoParceiro = 0;
		 	if ($venda['parceiro_id']) {
		 		$comissaoParceiro = $this->system->parceiros->getValorExtra($venda['parceiro_id'], 'comissao');
		 		$valorComissaoParceiro = $this->divisaoCustos(($comissaoParceiro * $vendas[$key]['valor_total'])/100);
		 		$vendas[$key]['valor_desconto'] += $valorComissaoParceiro;
		 	}

		 	$vendas[$key]['valor_desconto'] = number_format($vendas[$key]['valor_desconto'], 2, ',', '.');

		 	////// BRUTO //////
	 		$valorBruto = ($this->totalPrecoProfessor - $valorComissaoParceiro - $valorTaxas - $valorCupom - $valorDesconto);
	 		$vendas[$key]['valor_bruto'] = number_format($valorBruto, 2, ',', '.');	
		 		
		 	
		 	////// COMPLETO (VALOR) //////
		 	$valorCompleto = $this->totalPrecoProfessor;
		 	$vendas[$key]['valor_completo'] = number_format($this->totalPrecoProfessor, 2, ',', '.');

		 	////// LÍQUIDO //////
		 	$valorLiquido = (($comissaoPorcentagem * $valorBruto)/100);
		 	$vendas[$key]['valor_liquido'] = number_format($valorLiquido, 2, ',', '.');

		 	switch($venda['forma_pagamento']) {
		 		case 1:
		 	 		$vendas[$key]['forma_pagamento'] = 'PagSeguro';
		 	 		break;
		 	 	case 2:
		 	 		$vendas[$key]['forma_pagamento'] = 'Moip';
		 	 		break;
		 	 	case 3:
		 	 		$vendas[$key]['forma_pagamento'] = 'Paypal';
		 	 		break;
		 	 	case 4:
		 	 		$vendas[$key]['forma_pagamento'] = 'Depósito/Transferência';
		 	 		break;
		 	 	case 5:
		 	 		$vendas[$key]['forma_pagamento'] = 'Transferência Internacional';
		 	 		break;
		 	}

		 	$totalCuponsDescontos += ($valorCupom + $valorDesconto + $valorComissaoParceiro);
		 	$totalBruto += $valorBruto;
		 	$totalCompleto += $valorCompleto;
		 	$totalLiquido += $valorLiquido;
		 	$totalTaxas += $valorTaxas;
		}
		
		$this->system->view->assign(array(
			'url_site'				=> 	$this->system->getUrlSite(),
			'vendas'				=> 	$vendas,
			'comissaoPorcentagem'	=> $comissaoPorcentagem,
			'totalTaxas'			=> number_format($totalTaxas, 2, ',', '.'),
			'totalCompleto'			=> number_format($totalCompleto, 2, ',', '.'),
			'totalCuponsDescontos'	=> number_format($totalCuponsDescontos, 2, ',', '.'),
			'totalBruto'			=> number_format($totalBruto, 2, ',', '.'),
			'totalLiquido'			=> number_format($totalLiquido, 2, ',', '.'),
			
			
		));
		
		$this->system->admin->topo(2);
		$this->system->view->display('professor/vendas.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function divisaoCustos($custo) {
		$porcentagem = ((100 * $this->totalPrecoProfessor) / $this->totalPreco);
		return (($custo * $porcentagem) / 100);
	}

	// ===============================================================
	private function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
}
// ===================================================================