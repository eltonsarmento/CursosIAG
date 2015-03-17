<?php
require_once(dirname(__FILE__).'/../global/vendas.global.php');
// ===================================================================
class Vendas extends VendasGlobal {
	
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'nova': 								$this->doEdicao(); break;
			case 'pedidos': 							$this->doLista(); break;
			case 'calcularPreco':						$this->doCalcularPreco(); break;
			case 'relatorio': 							$this->doRelatorio(); break;
			case 'carregaDadosVendaPorDia': 			$this->docarregaDadosVendaPorDia(); break;
			case 'carregaDadosVendaPorMes': 			$this->docarregaDadosVendaPorMes(); break;
			case 'carregaDadosVendaPorProdutos': 		$this->docarregaDadosVendaPorProdutos(); break;
			case 'carregaDadosVendaMaisVendidos': 		$this->docarregaDadosVendaPorMaisVendidos(); break;
			case 'carregaDadosVendaTopConsumidores': 	$this->docarregaDadosVendaTopConsumidores(); break;
			case 'carregaDadosVendaPorCategorias': 		$this->docarregaDadosVendaPorCategorias(); break;
			case 'carregaDadosVendaCupons': 			$this->docarregaDadosVendaCupons(); break;
			case 'carregaDadosCertificados': 			$this->docarregaDadosCertificados(); break;
			case 'carregaDadosAssinatura':				$this->doCarregaDadosAssinatura(); break;
			case 'salvarPagamento':		 				$this->doAlterarPagamento(); break;
			case 'salvarRastreamento':		 			$this->doAlterarRastreamento(); break;
			case 'salvarObservacoes':		 			$this->doAlterarObservacoes(); break;
			case 'detalhes': 							$this->doDetalhesVenda(); break;
			case 'todas': 								$this->doTodasVendas(); break;
			case 'buscar-vendas': 						$this->doTodasVendas(); break;
			case 'baixarComprovante':					$this->doBaixarComprovante(); break;
			case 'buscarPorAluno':						$this->doBuscarPorAluno(); break;
			case 'cancelar':							$this->doCancelar(); break;
			default: 									$this->pagina404(); break;
		}
	}
	
}
// ===================================================================
