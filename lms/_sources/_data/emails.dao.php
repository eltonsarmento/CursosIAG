<?php

// ===================================================================
class EmailsDAO {
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function getValorPorId($id) {
		return $this->system->sql->querycountunit($this->system->sql->select('valor', 'configuracoes_emails', "id= '" . $id . "'"));
	}
	// ===============================================================
	public function salvarValorPorId($id, $valor) {
		if (!$this->system->sql->querycountunit($this->system->sql->select('id', 'configuracoes_emails', "id= '" . $id . "'")))
			$this->system->sql->insert('configuracoes_emails', array('id' => $id, 'valor' => $valor));
		$this->system->sql->update('configuracoes_emails', array('valor' => $valor), "id='" . $id . "'");
	}
	// ===============================================================
}
// ===================================================================