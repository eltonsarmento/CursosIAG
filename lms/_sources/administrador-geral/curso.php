<?php
require_once(dirname(__FILE__).'/../global/curso.global.php');
// ===================================================================
class Curso extends CursoGlobal {
	
	// ===============================================================
	public function autoRun() {
		
		$this->system->view->assign('categoria', $this->system->admin->getCategoria());
		switch($this->system->input['do']) {
			case 'listar': 			$this->doListar(); break;
			case 'novo': 			$this->doEdicao(); break;
			case 'editar': 			$this->doEdicao(); break;
			case 'apagar': 			$this->doDeletar(); break;
			case 'buscar': 			$this->doListar(); break;
			case 'salvarServidor': 	$this->doSalvarServidor(); break;
			case 'cursos-alunos': 	$this->doMeusCursos(); break;
			default: 				$this->pagina404(); break;
		}
	}
	// ===============================================================
	private function doMeusCursos() {				
		$this->system->load->dao('alunos');
		$this->system->load->dao('planos');

		$aluno = $this->system->alunos->getUsuarioByEmail($this->system->input['email']);

		$cursos = $this->system->curso->getCursosByAlunoAdmin($aluno['id'], $palavra);		
		$concluidos = array();
		$andamento = array();

		$certificado = $this->system->configuracoesgerais->getProdutosCertificados();

		foreach ($cursos as $curso) {
			//ultima aula
			// tipo venda						
			if($curso['plano_id'] != '' && $curso['plano_id'] != 0){
				$plano = $this->system->planos->getPlano($curso['plano_id']);	
				$curso['tipo_venda'] = 'Plano '.$plano['plano'];
			}else{
				$curso['tipo_venda'] = 'Avulso';
			}

			$ultimaAula = $this->system->aulas->getAula($curso['ultima_aula']);

			if ($ultimaAula['aula_id']) $curso['aula'] = $ultimaAula['nome'];

			//professor
			$professor = $this->system->professores->getProfessor($curso['professor_id']);
			if ($professor['id']) $curso['professor'] = $professor['nome'];

			//porcentagem
			
			if ($curso['aulas_assistidas'])
				$curso['porcentagem'] = round(($curso['aulas_assistidas']/$curso['aulas_total'])*100);
			else 
				$curso['porcentagem'] = 0;


			if ($curso['aulas_assistidas'] >= $curso['aulas_total'])
				$concluidos[] = $curso;
			else 
				$andamento[] = $curso;

			
		}

		

		$this->system->view->assign(array(
			'url_site'		=> 	$this->system->getUrlSite(),
			'concluidos'	=>	$concluidos,
			'andamento'		=>	$andamento,
			'nome_aluno'	=>	$aluno['nome'],
			'certificado'	=> ($certificado['produtos_certificado_tipo'] == 0 ? false: true)
		));
		

		$this->system->admin->topo(2);
		$this->system->view->display('administrador-geral/situacao_alunos.tpl');
		$this->system->admin->rodape();
	}

}
// ===================================================================