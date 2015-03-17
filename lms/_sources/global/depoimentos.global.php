<?php
// ===================================================================
class DepoimentosGlobal {
	// ===============================================================
	protected $system = null;
	protected $redir = '';
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('depoimentos');
	}
	// ===============================================================
	public function autoRun() {		
		switch($this->system->input['do']) {
			case 'listar': 				$this->doListar(); break;
			case 'aceitar': 			$this->doAceitar(); break;
			case 'recusar': 			$this->doRecusar(); break;
			case 'buscarDepoimento': 	$this->doBuscarDepoimento(); break;
			case 'editar': 				$this->doEditar(); break;
			default: $this->pagina404(); break;
		}
	}
	// ===============================================================
	protected function doListar() {
		$depoimentos = $this->system->depoimentos->getDepoimentos('and status = 0');

		$msg_alert = $this->system->session->getItem('msg_alert');
		if ($msg_alert) {
			$this->system->session->deleteItem('msg_alert');
			$this->system->view->assign('msg_alert', $msg_alert);
		}

		$this->system->view->assign('depoimentos', $depoimentos);
		$this->system->admin->topo(2);
		$this->system->view->display('global/depoimentos_gerenciar.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	protected function doAceitar() {
		$id = $this->system->input['id'];
		$depoimento = $this->system->depoimentos->getDepoimento('and id = ' . $id);		
		
		if ($depoimento['id']) {
			$this->system->depoimentos->atualizar($depoimento['id'], array('status' => 1));
			$this->system->session->addItem('msg_alert', 'Depoimento aprovado!');
			$this->system->func->redirecionar('/depoimentos/listar');
		} 
		$this->system->session->addItem('msg_alert', 'Não foi possível aprovar depoimento!');
		$this->system->func->redirecionar('/depoimentos/listar');
	}
	// ===============================================================
	protected function doBuscarDepoimento() {
		$id = $this->system->input['id'];
		$depoimento = $this->system->depoimentos->getDepoimento('and id = ' . $id);		
		echo '<script>jQuery("#depoimentoModal").val("' . $depoimento['mensagem'] . '")</script>';
	}
	// ===============================================================
	protected function doEditar() {
		$id = $this->system->input['id'];
		if($this->system->input['editar'] && $id) {	
			$mensagem = $this->system->input['mensagem'];
			$this->system->depoimentos->atualizar($id, array('mensagem' => $mensagem));
			echo '<p style="color:green">Atualizado</p>';
			echo '<script type="text/javascript"> jQuery("#p_' . $id . '").html("' . $mensagem . '")</script>';
		}
	}
	// ===============================================================
	protected function doRecusar() {
		$id = $this->system->input['id'];
		$depoimento = $this->system->depoimentos->getDepoimento('and id = ' . $id);		
		
		if ($depoimento['id']) {
			$this->system->depoimentos->atualizar($depoimento['id'], array('status' => 2));
			$this->system->session->addItem('msg_alert', 'Depoimento recusado!');
			$this->system->func->redirecionar('/depoimentos/listar');
		} 
		$this->system->session->addItem('msg_alert', 'Não foi possível recusar esse depoimento!');
		$this->system->func->redirecionar('/depoimentos/listar');
	}
	// ===============================================================
	protected function pagina404() {
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================
