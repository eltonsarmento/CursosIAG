<?php
// ===================================================================
class PagseguroDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function getTransacao($id) {
		$query = $this->system->sql->select('*', 'pagseguro_nasp', "venda_id = '" . intval($id) . "' ");
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('pagseguro_nasp', array(
			'code'					=> trim($input['code']),
			'venda_id'				=> intval($input['venda_id']),
			'status'				=> intval($input['status']),
			'data'					=> trim($input['data']),
			'ultima_atualizacao'	=> trim($input['ultima_atualizacao']),
			'total'					=> $input['total'],
			'total_liquido'			=> $input['total_liquido'],
			'total_taxas'			=> $input['taxas'],
		));
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('pagseguro_nasp', array(
			'status'				=> intval($input['status']),
			'ultima_atualizacao'	=> trim($input['ultima_atualizacao']),
		), "venda_id = '" . $input['venda_id'] . "'");
	}
	
}
// ===================================================================