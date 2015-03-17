<?php
// ===================================================================
class Assinaturas {
	// ===============================================================
	private $system = null;
	private $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('planos');
		$this->system->load->model('pagseguro_model');
		$this->system->load->model('pagarme_model');
		$this->system->load->dao('curso');
		$this->system->load->dao('vendas');
	}
	// ===============================================================
	public function autoRun() {		
		switch($this->system->input['do']) {
			case 'listar': 		$this->doListar(); break;
			case 'buscar': 		$this->doListar(); break;
			case 'renovar': 	$this->doRenovar(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	private function doListar() {
		
		$palavra = $this->system->session->getItem('palavra_busca');
		if ($palavra) $this->system->session->deleteItem('palavra_busca');

		$assinaturas = $this->system->planos->getPlanosAluno('usuario_id = ' . $this->system->session->getItem('session_cod_usuario'));
		foreach ($assinaturas as $key => $assinatura) {
			$assinaturas[$key]['plano'] = $this->system->planos->getPlano($assinatura['plano_id']);

			if ($palavra) {
				if (stristr($assinaturas[$key]['plano']['plano'], $palavra) === false) {
					unset($assinaturas[$key]);
				}
			}
		}

		$this->system->view->assign(array(
			'url_site'		=> 	$this->system->getUrlSite(),
			'assinaturas'	=>	$assinaturas,
		));
		
		$this->system->admin->topo(2);
		$this->system->view->display('aluno/assinaturas.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function doRenovar() {
		$assinaturaID = $this->system->input['assinatura'];
		if ($assinaturaID) {
			$assinatura = $this->system->planos->getPlanoAluno(' and usuario_id = ' . $this->system->session->getItem('session_cod_usuario') . ' and id = ' . $assinaturaID);			
			if ($assinatura['id']) {
				if ($assinatura['renovar']) {

					try {
						$codePagSeguro = $this->system->planos->getCodePagSeguro($assinatura['id']);												
						if($codePagSeguro){							
							$this->system->pagseguro_model->suspenderAssinatura($codePagSeguro);
						}else{
							$venda = $this->system->vendas->getVenda(intval($assinatura['assinatura_id']));					
							$this->system->pagarme_model->suspenderAssinatura($venda['codePagarme']);
						}										
						$this->system->planos->atualizarPlanoAluno($assinatura['id'], array('renovar' => 0));
						echo '<script>jQuery("#cancelar_assinatura_' . $assinatura['id'] . '").html("");</script>';	
						echo '<script>jAlert("Sua assinatura não será renovada!")</script>';
					} catch (Exception $e){
						//echo '<script>jAlert("Houve uma falha no cancelamento! ' . $e->getMessage() . '")</script>';
						echo '<script>jAlert("Houve uma falha no cancelamento! ")</script>';
					}
					
				} 
			}
		}
	}
	// ===============================================================
	private function pagina404() {
		$this->system->view->assign('categoria', 'aluno');
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
}
// ===================================================================