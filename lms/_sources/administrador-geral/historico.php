<?php
// ===================================================================
class Historico {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct(&$system) {
		$this->system = $system;
		$this->system->load->dao('alunos');
		$this->system->load->dao('curso');
		$this->system->load->dao('aulas');
	}
	// ===============================================================
	public function autoRun() {
		switch($this->system->input['do']) {
			case 'editar': 	$this->doEditar(); break;
			case 'salvar': 	$this->doSalvar(); break;
			default: 		$this->pagina404(); break;
		}	
	}
	// ===============================================================
	private function getAulas($curso_id, $limite) {
		$query = $this->system->sql->select('*', 'cursos_aulas', "excluido=0 and curso_id = " . $curso_id, $limite, 'aula_id ASC');
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	private function doSalvar() {
		$curso_id = intval($this->system->input['curso_id']);
		$aluno_id = intval($this->system->input['aluno_id']);
		$porcentagem = intval($this->system->input['porcentagem']);

		if ($curso_id && $aluno_id && $porcentagem) {
			//porcentagem
			$totalAulas = $this->system->aulas->countAulasCurso($curso_id);
			$total_inserir = ceil(($totalAulas * $porcentagem) / 100);
			
			$cursoAluno = end($this->system->curso->getCursosAlunos(" and curso_id = '" . $curso_id . "' and usuario_id = '" . $aluno_id . "'"));
			$relacionamentoId = $cursoAluno['id'];
			$aulas = $this->getAulas($curso_id, $total_inserir);

			$ultima_aula = $aulas[count($aulas) - 1]['aula_id'];

			foreach ($aulas as $key => $aula) {
				//if ($aula['aula_id'] != $ultima_aula)
				$this->system->aulas->liberarAulaConcluida($aula['aula_id'], $relacionamentoId, $aluno_id);
			}

			//$this->system->aulas->liberarAula($ultima_aula, $relacionamentoId, $aluno_id);
			//$this->system->curso->atualizarCursoAluno(array('ultima_aula' => $ultima_aula), $relacionamentoId);
		}
	}
	// ===============================================================
	private function doEditar() {
		$id = intval($this->system->input['id']);
		$this->system->admin->topo(2);
		
		$aluno = $this->system->alunos->getAluno($id, true);
		$this->system->view->assign('aluno', $aluno);
		$this->system->view->assign('cursos', $this->system->alunos->getCursos($aluno['id']));

		$this->system->view->display('administrador-geral/historico_gerenciar.tpl');
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