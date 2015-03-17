<?php
require_once(dirname(__FILE__).'/../global/alunos.global.php');
// ===================================================================
class Alunos extends AlunosGlobal{
	
	// ===============================================================
	public function autoRun() {

		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 	$this->doListar(); break;
			case 'novo': 	$this->doEdicao(); break;
			case 'editar': 	$this->doEdicao(); break;
			case 'apagar': 	$this->doDeletar(); break;
			case 'buscar':	$this->doListar(); break;
			case 'vincular':$this->doVincular(); break;
			default: 		$this->pagina404(); break;
		}	
   	}

	// ==============================================================
	protected function doVincular() {
		
		if($this->system->input['vincular']) {
			$email = $this->system->input['email'];
			$usuario = $this->system->alunos->getUsuarioByEmail($email);

			if (empty($usuario['id'])) 
				$this->system->view->assign('msg_alert', $email . ' não está cadastrado em nosso sistema');
			elseif($usuario['nivel'] != 4) 
				$this->system->view->assign('msg_alert', 'Usuário do e-mail ' . $email . ' não é aluno');
			else {

				$this->system->load->dao('parceiros');
				$parceiro =  $this->system->parceiros->getParceiro($usuario['cadastro_por_id']);

				if (isset($parceiro['id'])) {
					$this->system->view->assign('msg_alert', 'Usuário do e-mail ' . $email . ' já é vinculado a outro parceiro');	
				} else {
					$this->system->alunos->atualizarCampo($usuario['id'], array('cadastro_por_id' => $this->system->session->getItem('session_cod_usuario')));
					$this->system->view->assign('msg_alert', 'Usuário do e-mail ' . $email . ' vinculado com sucesso!');	
				}

			}
		}

		$this->system->admin->topo(2);
		$this->system->view->display('parceiro/aluno_vincular.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================