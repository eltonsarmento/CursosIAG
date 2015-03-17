<?php
require_once(dirname(__FILE__).'/../global/parceiros.global.php');
// ===================================================================
class Parceiros extends ParceirosGlobal {
	
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		
		switch($this->system->input['do']) {
			case 'listar': 	$this->doListar(); break;
			case 'novo': 	$this->doEdicao(); break;
			case 'editar': 	$this->doEdicao(); break;
			case 'apagar': 	$this->doDeletar(); break;
			case 'buscar':	$this->doListar(); break;
				
			case 'relatorio': 							$this->doRelatorio(); break;
			case 'carregaDadosVendaPorDia': 			$this->docarregaDadosVendaPorDia(); break;
			case 'carregaDadosVendaPorMes': 			$this->docarregaDadosVendaPorMes(); break;
			case 'carregaDadosVendaPorProdutos': 		$this->docarregaDadosVendaPorProdutos(); break;
			case 'carregaDadosVendaMaisVendidos': 		$this->docarregaDadosVendaPorMaisVendidos(); break;
			case 'carregaDadosVendaTopConsumidores': 	$this->docarregaDadosVendaTopConsumidores(); break;
			case 'carregaDadosVendaPorCategorias': 		$this->docarregaDadosVendaPorCategorias(); break;
			case 'carregaDadosVendaCupons': 			$this->docarregaDadosVendaCupons(); break;

			case 'fecharMes':							$this->doFecharMes(); break;

			case 'comprovante':							$this->doListarComprovante(); break;
			case 'downloadComprovante':					$this->doDownloadComprovante(); break;
			
			default: 									$this->pagina404(); break;
		}
	}

	protected function doListarComprovante() {
		$comprovantes = $this->system->vendas->getComprovantes();
		
		foreach ($comprovantes as $key => $comprovante) {
			$comprovantes[$key]['parceiro'] = $this->system->parceiros->getParceiro($comprovante['parceiro_id']);
			$comprovantes[$key]['mes'] = substr($this->system->arrays->getMes($comprovante['mes']), 0, 3);
			$comprovantes[$key]['preco'] = 'R$ '  . number_format($comprovante['total'], 2, ',', '.');
		}
		
		$this->system->view->assign('comprovantes', $comprovantes);
		$this->system->admin->topo(5);
		$this->system->view->display('administrador-geral/parceiros_comprovantes.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================