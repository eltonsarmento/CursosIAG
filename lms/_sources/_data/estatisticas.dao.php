<?php
// ===================================================================
class EstatisticasDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($usuarioId, $cursoId, $porcentagem) {
		$this->system->sql->insert('estatisticas', array(
			'usuario_id' 	=> $usuarioId,
			'curso_id'		=> $cursoId,
			'visualizado'	=> 0,
			'porcentagem'	=> $porcentagem,
			'data_cadastro'	=> date('Y-m-d H:i:s'),
			'excluido'		=> 0
		));
	}
	// ===============================================================
	public function getNaoVistas($usuarioId) {
		$query = $this->system->sql->select('*', 'estatisticas', "usuario_id = '$usuarioId' and excluido = '0' and visualizado = '0'");
		$estatisticas = $this->system->sql->fetchrowset($query);

		$return['conteudo'] = array();
		$return['total'] = $this->countTotalNaoVistas("and usuario_id = '" . $usuarioId . "' and visualizado = '0'");
		foreach ($estatisticas as $key => $estatistica) {
			//curso
			$query = $this->system->sql->select('curso', 'cursos', "excluido = 0 and id = '" . $estatistica['curso_id'] . "'");
			$estatistica['curso'] = end($this->system->sql->fetchrowset($query));
			
			$return['conteudo'][] = $estatistica;
		}

		return $return;
	}
	// =================================================================
	public function verEstatistica($usuarioId) {
		$this->system->sql->update('estatisticas', array('visualizado' => 1), "usuario_id = '" . $usuarioId .  "'");
	}
	// =================================================================
	public function countTotalNaoVistas($campos = '') {
		$query = $this->system->sql->select('count(1) as total', 'estatisticas', 'excluido = 0 ' . $campos);
		$resultado = end($this->system->sql->fetchrowset($query));
		return $resultado['total'];
	}
	
}
// ===================================================================
