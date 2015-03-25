<?php

// ===================================================================
class PlanosDAO {
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('planos', array(
        	'plano' 					=> $input['plano'],
        	'meses'						=> $input['meses'],
        	'valor'						=> $input['valor'],
        	'descricao'					=> $input['descricao'],
        	'status'					=> $input['status'],
        	'codigoPlanoPagarme'		=> $input['codigoPlanoPagarme'],
        	'cursos_qtd_mes'			=> $input['cursos_qtd_mes'],
        	//'cursos_acesso_carreiras'	=> $input['cursos_acesso_carreiras'],
        	'cursos_tipo_acessos'		=> $input['cursos_tipo_acessos'],
        	'imagem_arquivo' 			=> "",
        	'excluido'					=> 0
        ));
        return $this->system->sql->nextid();
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('planos', array(
        	'plano' 					=> $input['plano'],
        	'meses'						=> $input['meses'],
        	'valor'						=> $input['valor'],
        	'descricao'					=> $input['descricao'],
        	'status'					=> $input['status'],
        	'codigoPlanoPagarme'		=> $input['codigoPlanoPagarme'],
        	'cursos_qtd_mes'			=> $input['cursos_qtd_mes'],
        	//'cursos_acesso_carreiras'	=> $input['cursos_acesso_carreiras'],
        	'cursos_tipo_acessos'		=> $input['cursos_tipo_acessos'],
        	'excluido'					=> 0
        ),	"id='" . $input['id'] . "'");
        return $input['id'];
	}
	// ===============================================================
	public function getPlanos($palavra = '', $limit = '', $order = 'plano') {
		$query = $this->system->sql->select('*', 'planos', "excluido='0' " . ($palavra ? " and plano like '%" . $palavra . "%'" : ''), $limit, $order);
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	public function getPlanosCondicao($where = '', $limit = '', $order = 'plano', $campos = '*') {
		$query = $this->system->sql->select($campos, 'planos', "excluido='0' " . $where, $limit, $order);
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	public function getPlano($id) {
		$query = $this->system->sql->select('*', 'planos', "excluido='0' and id= '" . $id . "'");
		$plano = $this->system->sql->fetchrowset($query);
		return $plano[0];
	}
	// ===============================================================
	public function deletar($id) {
	 	$this->system->sql->update('planos', array('excluido' => 1), "id='" . $id . "'");
	}
	// ===============================================================
	public function atualizarImagem($id, $imagem) {
		$this->system->sql->update('planos', array('imagem_arquivo' => $imagem), "id='" . $id . "'");
	}
	// ===============================================================
    public function verificaAssinaturaAtiva($campos) {
        return $this->system->sql->fetchrowset($this->system->sql->select('*', 'planos_alunos', "excluido = 0 and data_expiracao >= '" . date('Y-m-d') . "' " . $campos));
    }
    // ===============================================================
    public function verficaAssinaturaPremium($campos) {
    	return end($this->system->sql->fetchrowset($this->system->sql->select('count(1) qtd', 'planos_alunos', "plano_id = 20 and excluido = 0 " . $campos)));
    }
    //================================================================
	public function cadastrarPlanoAluno($plano, $usuario_id, $assinatura_id, $expiracao) {
		$this->system->sql->insert('planos_alunos', array(
				'usuario_id' 	=> $usuario_id,
				'plano_id' 		=> $plano,
				'assinatura_id' => $assinatura_id,
				'data_expiracao'=> $expiracao,				
				'data_cadastro'	=> date('Y-m-d'),
				'data_periodo'	=> date('Y-m-d'),
				'excluido' 		=> 0
		));
		return true;
	}
	//================================================================
	public function atualizarPlanoAluno($id, $campos) {
		$this->system->sql->update('planos_alunos', $campos, 'id = ' . $id);
	}
	// ===============================================================
	public function buscarPlanosRenovar() {
		return $this->system->sql->fetchrowset($this->system->sql->select('*', 'planos_alunos', "excluido = 0 and data_expiracao < '" . date('Y-m-d') . "' and renovar = 1"));	
	}
	// ===============================================================
	public function desativarAssinatura($id) {
		$this->system->sql->update('planos_alunos', array('excluido' => 1), "id='" . $id . "'");
	}
	// ===============================================================
	public function renovarAssinatura($id, $data_expiracao) {
		$this->system->sql->update('planos_alunos', array(
            'data_expiracao'	=> $data_expiracao,
            'data_periodo'		=> date('Y-m-d'),
            'excluido' 			=> 0
        ),	"id='" . $id . "'");
	}
	// ===============================================================
	public function renovarCursoPlano($id, $data_expiracao) {
		$this->system->sql->update('cursos_alunos', array('expira' => $data_expiracao), "id='" . $id . "'");
	}
	// ===============================================================
	public function getCursoPlano($usuario_id, $dataExpiracao = true) {
		return end($this->system->sql->fetchrowset($this->system->sql->select('c.*', 'planos_alunos p, cursos_alunos c', "p.excluido = 0 and c.id = p.curso_id " . ($dataExpiracao ? " and p.data_expiracao >= '" . date('Y-m-d') . "' " : ""))));
	}
	// ===============================================================
	public function alterarCurso($id, $curso_id) {
		$this->system->sql->update('planos_alunos', array('curso_id' => $curso_id), "id='" . $id . "'");
	}
	// ===============================================================
	public function getPlanoAluno($campo = '') {
		return end($this->system->sql->fetchrowset($this->system->sql->select('*', 'planos_alunos', "excluido = 0 " . $campo)));	
	}
	// ===============================================================
	public function getPlanosAluno($campo = '') {
		return $this->system->sql->fetchrowset($this->system->sql->select('*', 'planos_alunos', $campo));	
	}
	// ===============================================================
	public function getCodePagSeguro($assinaturaID) {
		$venda = end($this->system->sql->fetchrowset($this->system->sql->select('codePagSeguro', 'vendas', "id IN (SELECT assinatura_id FROM planos_alunos WHERE id = '" . $assinaturaID . "')")));	
		return ($venda['codePagSeguro'] ? $venda['codePagSeguro'] : null);
	}
	// ===============================================================
	public function getCodePagarme($assinaturaID) {
		$venda = end($this->system->sql->fetchrowset($this->system->sql->select('codePagarme', 'vendas', "id IN (SELECT assinatura_id FROM planos_alunos WHERE id = '" . $assinaturaID . "')")));	
		return ($venda['codePagarme'] ? $venda['codePagarme'] : null);
	}
	// ===============================================================
	public function getTotalCursosMesAluno($usuario_id, $mes) {
		$query = $this->system->sql->select('COUNT(1)', 'planos_alunos_compras', "usuario_id = '" . $usuario_id . "' AND data_compra LIKE '" . $mes . "-%'");
		return (int)$this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function cadastrarNovaCompraCursoPlanoAluno($usuario_id, $curso_id, $data_compra) {
		$this->system->sql->insert('planos_alunos_compras', array(
				'usuario_id' 	=> $usuario_id,
				'curso_id' 		=> $curso_id,
				'data_compra' 	=> $data_compra
		));
		return true;
	}
	// ===============================================================
}
// ===================================================================