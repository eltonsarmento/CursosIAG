<?php
// ===================================================================
class Arrays {
	// ===============================================================
	public function getArrayCategorias() {
		return array(
			1 => 'administrador-geral',
			2 => 'coordenador',
			3 => 'professor',
			4 => 'aluno',
			5 => 'parceiro',
			6 => 'administrativo',
			7 => 'coordenador-parceiro'
		);
	}
	// ===============================================================
	public function getArrayNivel() {
		return array(
			1 => 'Usuário',
			2 => 'Administrador',
			3 => 'Administrador Geral'
		);
	}
	// ===============================================================
	public function getMes($mes) {
		$meses = array(
			'01' 	=> 'Janeiro',
			'02' 	=> 'Fevereiro',
			'03' 	=> 'Março',
			'04' 	=> 'Abril',
			'05' 	=> 'Maio',
			'06' 	=> 'Junho',
			'07' 	=> 'Julho',
			'08' 	=> 'Agosto',
			'09' 	=> 'Setembro',
			'10' 	=> 'Outubro',
			'11' 	=> 'Novembro',
			'12' 	=> 'Dezembro'
		);
		return $meses[$mes];
	}
	// ===============================================================
}
// ===================================================================