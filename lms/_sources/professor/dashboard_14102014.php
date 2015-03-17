<?php
// ===================================================================
class Dashboard {
	// ===============================================================
	private $system = null;
	private $redir = '';
	private $totalPreco;
	private $totalPrecoProfessor;
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('duvidas');
		$this->system->load->dao('vendas');
		$this->system->load->dao('alunos');
		$this->system->load->dao('curso');
		$this->system->load->dao('notificacoes');
		$this->system->load->dao('professores');
		$this->system->load->dao('parceiros');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'home': $this->doDashboard(); break;
			default: $this->doDashboard(); break;
		}
	}
	// ===============================================================
	private function doDashboard() {
		//duvidas
		$duvidas = $this->system->duvidas->getDuvidas(" and professor_id = '" . $this->system->session->getItem('session_cod_usuario') . "' and excluido_professor = '0'", 5);

		//vendas
		$where = " and t2.status = 1 and t1.professor_id = '" . $this->system->session->getItem('session_cod_usuario') . "'";

		$ultimas_5_vendas = $this->system->vendas->getVendasPorCursos($where, 5);
		
		$comissaoPorcentagem = $this->system->professores->getValorExtra($this->system->session->getItem('session_cod_usuario'), 'comissao');
		foreach($ultimas_5_vendas as $key => $venda) {
			$venda = $this->system->vendas->getVenda($venda['venda_id']);

			$ultimas_5_vendas[$key]['valor_total'] = 0;
		 	$ultimas_5_vendas[$key]['cliente'] = $this->system->alunos->getAluno($venda['aluno_id']);
		 	$ultimas_5_vendas[$key]['numero'] = $venda['numero'];
		 	$ultimas_5_vendas[$key]['status'] = $venda['status'];

		 	$cursos = array();
		 	$this->totalPreco = 0;
		 	$this->totalPrecoProfessor = 0;
		 	foreach($this->system->vendas->getCursosByVenda($venda['id']) as $curso) {
		 		$curso_dados = end($this->system->curso->getCurso($curso['curso_id'], false));
		 		$this->totalPreco += $curso['preco_total'];;
		 		if ($curso_dados['professor_id'] == $this->system->session->getItem('session_cod_usuario')) {
		 			$cursos[] = $curso_dados['curso'];
		 			$this->totalPrecoProfessor += $curso['preco_comissao'];
		 		}
		 	}

		   	////// TAXA //////
		 	//PagSeguro e MoIP
		 	$valorTaxas = $this->divisaoCustos($venda['valor_taxas']);

		 	
		 	////// CUPOM (SITE) ou DESCONTO (LMS) ////// 
		 	$valorCupom = 0;
		 	if ($venda['cupom_id']) {
		 		$this->system->load->dao('cupons');
		 		$cupom = $this->system->cupons->getCupom($venda['cupom_id']);

		 		if ($cupom['tipo_desconto'] == 1) //Valor inteiro
		 			 $valorCupom = $this->divisaoCustos($cupom['valor']);
		 		else { //Porcentagem
		 			$porcentagemPaga = (100 - $cupom['valor']);
		 			$valorSemCupom = ((100 * $vendas[$key]['valor_total'])/$porcentagemPaga);
		 			$valorCupom = $this->divisaoCustos($valorSemCupom - $vendas[$key]['valor_total']);
		 		}

		 	} else {
 				$valorDesconto = $this->divisaoCustos($venda['valor_desconto']);
		 	}

		 	////// COMISSÃO PARCEIRO (DESCONTO) /////
		 	$valorComissaoParceiro = 0;
		 	if ($venda['parceiro_id']) {
		 		$comissaoParceiro = $this->system->parceiros->getValorExtra($venda['parceiro_id'], 'comissao');
		 		$valorComissaoParceiro = $this->divisaoCustos(($comissaoParceiro * $vendas[$key]['valor_total'])/100);
		 	}

		 	////// BRUTO //////
	 		$valorBruto = ($this->totalPrecoProfessor - $valorComissaoParceiro - $valorTaxas - $valorCupom - $valorDesconto); 		
		 	
		 	////// COMPLETO (VALOR) //////
		 	$valorCompleto = $this->totalPrecoProfessor;

		 	////// LÍQUIDO //////
		 	$valorLiquido = (($comissaoPorcentagem * $valorBruto)/100);
		 	$ultimas_5_vendas[$key]['valor_total'] = number_format($valorLiquido, 2, ',', '.');


		 	$ultimas_5_vendas[$key]['cursos'] = implode('<br/>', $cursos);
		}
		
		
		//notificação
		$ultimaNotificacao = $this->system->notificacoes->getUltimaNotificacao($this->system->session->getItem('session_cod_usuario'));
		$ultimaNotificacao['conteudo'] = strip_tags(html_entity_decode($ultimaNotificacao['conteudo']));
		
		$this->system->view->assign(array(
			'url_site'		=> 	$this->system->getUrlSite(),
			'ultimas_5_vendas'	=> 	$ultimas_5_vendas,
			'ultimaNotificacao'	=>	$ultimaNotificacao,
			'duvidas'			=>  $duvidas
		));
		$this->system->admin->topo(1);
		$this->system->view->display('professor/dashboard.tpl');
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