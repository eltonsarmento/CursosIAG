<?php

// ===================================================================
class PagamentosDAO {
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
		$this->system->load->model('email_model');		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('pagamentos', array(
			'usuario_id'		=> intval($input['usuario_id']),
			'mes_faturado'		=> trim($input['mes_faturado']),
			'valor'				=> $input['valor'],
			'data_pagamento'	=> '0000-00-00',
			'status'			=> '0',
			'observacoes'		=> '',
			'comprovante'		=> '',
			'data_cadastro'		=> date('Y-m-d H:i:s'),
			'excluido'			=> 0
		));
	}
	// ===============================================================
	public function atualizar($campos, $where) {
		$this->system->sql->update('pagamentos', $campos, $where);
	}
	// ===============================================================
	public function getPagamentos($campos = '') {
		return $this->system->sql->fetchrowset($this->system->sql->select('t1.*, t2.nome, t2.email', 'pagamentos as t1 left join usuarios as t2 on (t1.usuario_id=t2.id)', "t1.excluido='0' " . $campos, 0, 't2.nome ASC'));
	}
	// ===============================================================
	public function getPagamento($campos) {
		return end($this->getPagamentos($campos));
	}
	// ===============================================================
	public function atualizaObservacao($id, $observacao) {
		$this->system->sql->update('pagamentos', array('observacoes' => $observacao), "id='" . $id . "'");
	}
	// ===============================================================
	public function atualizaComprovante($id, $comprovante) {
		$dados = $this->getPagamento(' and t1.id = ' . $id);
		$this->system->sql->update('pagamentos', array('comprovante' => $comprovante, 'data_pagamento' => date('Y-m-d'), 'status' => 1), "id='" . $id . "'");
		$this->system->email_model->pagamentoRealizadoProfessor($dados['nome'], $dados['email']);
	}
	// ===============================================================
}
// ===================================================================