<?php
require_once(dirname(__FILE__).'/../global/empreendedor.global.php');
// ===================================================================
class Empreendedor extends EmpreendedorGlobal{
	
	// ===============================================================
	public function autoRun() {

		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 	$this->doListar(); break;
			case 'ler': 	$this->doLer(); break;
			default: 		$this->pagina404(); break;
		}	
   	}

   	// ===============================================================
   	protected function doListar(){
   		$busca = $this->system->input['busca'];
   		if ($busca) {
   			$this->doBuscar();
   			exit;
   		}
   		$ultimo = $this->system->empreendedor->getUltimoPostado();
   		$maisDicasPostadas = $this->system->empreendedor->getMaisDicasEmpreendedor($ultimo['id']);
   		//print_r($maisDicasPostadas);die;
   		$this->system->view->assign('mais_dicas', $maisDicasPostadas);
   		$this->system->view->assign('ultima_dica', $ultimo);
   		$this->system->admin->topo(3);
   		$this->system->view->display('aluno/canto_empreendedor.tpl');
   		$this->system->admin->rodape();
   	}

   	// ===============================================================
	protected function doLer() {	

		$id_dica = $this->system->input['id_dica'];
		$id_usuario = $this->system->session->getItem('session_cod_usuario');
		$conteudoDica = array();
		$this->system->empreendedor->lerDicasEmpreendedor($id_usuario, $id_dica);
		$dica = $this->system->empreendedor->getCantoEmpreendedor($id_dica);
		

		if ($dica['id']) {
			$conteudo = explode("\n", $dica['descricao']);
			$msg = "";
			foreach ($conteudo as $linha) {
				$msg .=  $linha ;
			}
			$conteudoDica['descricao'] = html_entity_decode($msg);
			$conteudoDica['cabecalho'] = html_entity_decode($dica['titulo']);
			$conteudoDica['link_video'] = $dica['link_video'];
			$conteudoDica['tipo_video'] = $dica['tipo_video'];

			
			echo json_encode($conteudoDica);
		}
	}

	// ===============================================================
	protected function doBuscar(){
		$dicas = array();
		$condicao = $this->system->input['filtro'];
		if ($condicao == 'todos') {
			
   			$dicas = $this->system->empreendedor->buscarTodasAsDicas();
		}elseif ($condicao == 'vistos') {
			$dicas = $this->system->empreendedor->buscarTodasAsDicasLidas();
		}elseif ($condicao == 'nao_vistos') {
			$dicas = $this->system->empreendedor->buscarTodasAsDicasNaoLidas();
		}

		$this->system->view->assign('dicas', $dicas);
		$this->system->admin->topo(3);
		$this->system->view->display('aluno/busca_dicas_empreendedor.tpl');
		$this->system->admin->rodape();
	}
	
}
// ===================================================================