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
			// case 'relatorio': 							$this->doRelatorio(); break;
			// case 'carregaDadosVendaPorDia': 			$this->docarregaDadosVendaPorDia(); break;
			// case 'carregaDadosVendaPorMes': 			$this->docarregaDadosVendaPorMes(); break;
			// case 'carregaDadosVendaPorProdutos': 		$this->docarregaDadosVendaPorProdutos(); break;
			// case 'carregaDadosVendaMaisVendidos': 		$this->docarregaDadosVendaPorMaisVendidos(); break;
			// case 'carregaDadosVendaTopConsumidores': 	$this->docarregaDadosVendaTopConsumidores(); break;
			// case 'carregaDadosVendaPorCategorias': 		$this->docarregaDadosVendaPorCategorias(); break;
			// case 'carregaDadosVendaCupons': 			$this->docarregaDadosVendaCupons(); break;
			// case 'carregaDadosCertificados': 			$this->docarregaDadosCertificados(); break;
			case 'salvarPagamento':		 				$this->doAlterarPagamento(); break;
			case 'salvarRastreamento':		 			$this->doAlterarRastreamento(); break;
			case 'salvarObservacoes':		 			$this->doAlterarObservacoes(); break;
			case 'detalhes': 							$this->doDetalhesVenda(); break;
			case 'todas': 								$this->doTodasVendas(); break;
			case 'baixarComprovante':					$this->doBaixarComprovante(); break;
			case 'buscarPorAluno':						$this->doBuscarPorAluno(); break;
			default: 									$this->pagina404(); break;

		}
	}

	// ===============================================================
	protected function doTodasVendas() {
		
		$todas_vendas = $this->system->vendas->getVendas('and parceiro_id = ' . $this->system->session->getItem('session_cod_usuario'));
		foreach($todas_vendas as $key => $vendas) {
			$todas_vendas[$key]['cliente'] = $this->system->alunos->getAluno($vendas['aluno_id']);
			$cursos = array();
			foreach($this->system->vendas->getCursosByVenda($vendas['id']) as $curso) {
				$cursos[] = end($this->system->curso->getCurso($curso['curso_id'], false));
			}

			$todas_vendas[$key]['cursos'] = $cursos;
		}
		$this->system->view->assign('pedidos', $todas_vendas);			
		$this->system->admin->topo($this->system->func->posicoesMenusGlobais('vendas'));
		$this->system->view->display('global/vendas_todas_listagem.tpl');
		$this->system->admin->rodape();
	}
	
}
// ===================================================================
