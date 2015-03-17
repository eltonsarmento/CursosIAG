<?php
// ===================================================================
class Emails {
	// ===============================================================
	private $system = null;
	private $redir = '';
	private $acessoPermitido = array(
			1, //Administrador Geral
	);
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('emails');
	}
	// ===============================================================
	public function autoRun() {
		if (!eregi('redirecionar=', $_SERVER['QUERY_STRING']) && !$this->system->input['redirecionar'])
    		$this->redir = base64_encode('index.php?'.$_SERVER['QUERY_STRING']);
		else
    		$this->redir = stripslashes($this->system->input['redirecionar']);
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		
		if (in_array($this->system->session->getItem('session_nivel'), $this->acessoPermitido)) {
			switch($this->system->input['do']) {
				case 'listar': 				$this->doListar(); 				break;
				case 'carregarDados':		$this->doCarregarDados(); 		break;
				case 'salvarDados':			$this->doSalvarDados(); 		break;
				case 'salvarDadosEmail': 	$this->doSalvarDadosEmail(); 	break;
				default: 					$this->pagina404();				break;
			}
		} else {
			$this->pagina404();
		}
	}
	// ===============================================================
	private function doSalvarDadosEmail() {
		$ids = $this->system->input['id'];
		$arquivo_id = $this->system->input['arquivo_id'];
		foreach($ids as $id => $valor) {
			$this->system->emails->salvarValorPorId($id, $valor);
		}
		if (is_uploaded_file($_FILES['arquivo']['tmp_name'])) {
			$extensao = $this->system->func->getExtensaoArquivo($_FILES['arquivo']['name']);
			if (in_array($extensao, array('jpg', 'jpeg', 'png'))) {
				$imagem = true;
				if ($_FILES['arquivo']['size'] > 2485760) {
					$retorno['msg'][] = 'Imagem do Cabeçalho está com mais de 2MB';
					$imagem = false;
				}
			} else {
				$retorno['msg'][] = 'Imagem do Cabeçalho inválida';
				$imagem = false;
			}
		}
		if (!count($retorno['msg'])) {
			if ($imagem) {
				$nomearquivo = 'email_cabecalho'.$arquivo_id.'.'.$extensao;
				if (file_exists($this->system->getUploadPath().'/imagens/'.$nomearquivo))
					unlink($this->system->getUploadPath().'/imagens/'.$nomearquivo);
				copy($_FILES['arquivo']['tmp_name'], $this->system->getUploadPath().'/imagens/'.$nomearquivo);
				$this->system->emails->salvarValorPorId($arquivo_id, $nomearquivo);
				$retorno['imagem'] = $this->system->getUrlSite().'lms/uploads/imagens/'.$nomearquivo;
			}
			$retorno['sucesso'] = 'Ação realizada com sucesso!';
			$retorno['msg'] = '';
		}
		echo json_encode($retorno);
	}
	// ===============================================================
	private function doSalvarDados() {
		$id = intval($this->system->input['id']);
		$valor = trim($this->system->input['valor']);
		if ($id)
			$this->system->emails->salvarValorPorId($id, $valor);
		return true;
	}
	// ===============================================================
	private function doCarregarDados() {
		$id = intval($this->system->input['id']);
		echo $valor = html_entity_decode($this->system->emails->getValorPorId($id));
	}
	// ===============================================================
	private function doListar() {
		$id = intval($this->system->input['id']);
		$this->system->admin->topo(13);
		$this->system->view->assign(array(
			'id_atual'		=> ($id ? $id : 1),
			'imagem_atual' 	=> $this->system->getUrlSite().'lms/uploads/imagens/'.$this->system->emails->getValorPorId(86),
			'de_nome' 		=> $this->system->emails->getValorPorId(84),
			'de_email' 		=> $this->system->emails->getValorPorId(85),
			'texto_rodape' 	=> $this->system->emails->getValorPorId(87)
		));
		$this->system->view->display('administrador-geral/emails.tpl');
		$this->system->admin->rodape();
	}
	// ===============================================================
	private function pagina404() {
		$this->system->admin->topo(0);
		$this->system->view->display('global/pagina404.tpl');
		$this->system->admin->rodape();
	}
}
// ===================================================================