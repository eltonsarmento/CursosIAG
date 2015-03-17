<?php
// ===================================================================
class PagarmeDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function getTransacao($id) {
		$query = $this->system->sql->select('*', 'pagarme_nasp', "code = '" . intval($id) . "' ");
		$pagarme_nasp =  $this->system->sql->fetchrowset($query);
		if(!empty($pagarme_nasp))
			return $pagarme_nasp[0];
		else
			array();
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('pagarme_nasp', array(
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
		$this->system->sql->update('pagarme_nasp', array(
			'status'				=> intval($input['status']),
			'ultima_atualizacao'	=> trim($input['ultima_atualizacao']),
		), "code = '" . $input['venda_id'] . "'");
	}
	
}
// ===================================================================