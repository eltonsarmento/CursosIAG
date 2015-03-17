<?php
// ===================================================================
class CategoriasDAO {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function getCategoriasPais() {
		$query = $this->system->sql->select('*', 'categorias', "excluido='0' and categoria_pai_id = '0'", '', 'categoria');
		return $this->system->sql->fetchrowset($query);
	}
	// ===============================================================
	public function getCategoriasFilhas($where = '', $limit = '', $orderby = 'categoria', $campos = '*') {
		$query = $this->system->sql->select($campos, 'categorias', "excluido='0' " . $where, $limit, $orderby);
		return $this->system->sql->fetchrowset($query);
	}

	// ===============================================================
	public function getCategorias($palavra = '', $limit = '') {
	 	$query = $this->system->sql->select('*', 'categorias', "excluido='0'" . ($palavra != ''? " and categoria like '%" . $palavra.  "%'" : ''), $limit, 'categoria');
	 	$categorias =  $this->system->sql->fetchrowset($query);
	 	foreach ($categorias as $key => $categoria) {
	 		if ($categoria['categoria_pai_id'] == 0) {
	 			$categorias[$key]['categoria_pai'] = 'Sem categoria pai';
	 		} else {
	 			$query = $this->system->sql->select('categoria', 'categorias', "excluido='0' and id= '" . $categoria['categoria_pai_id'] . "'");
	 			$categoriaPai =  $this->system->sql->fetchrowset($query);
	 			$categorias[$key]['categoria_pai'] = $categoriaPai[0]['categoria'];
	 		}
	 	}
	 	return $categorias;
	}
	// ===============================================================
	public function getTotalCategorias() {
		$query = $this->system->sql->select('COUNT(id) AS total', 'categorias', "excluido='0'");
		return $this->system->sql->querycountunit($query);
	}
	// ===============================================================
	public function getCategoria($id) {
		$query = $this->system->sql->select('*', 'categorias', "excluido='0' and id = '" . $id ."'");
		return end($this->system->sql->fetchrowset($query));
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('categorias', array(
             'categoria' 		=> $input['categoria'],
             'categoria_pai_id'	=> $input['categoria_pai_id'],
             'status'	        => $input['status'],
             'url'				=> $input['url'],
             'excluido' 		=> 0
		));
        return $this->system->sql->nextid();
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('categorias', array(
            'categoria' 		=> $input['categoria'],
            'categoria_pai_id'	=> $input['categoria_pai_id'],
            'status'	        => $input['status'],
            'url'				=> $input['url'],
        ),	"id='" . $input['id'] . "'");
	}
	// ===============================================================
	public function deletar($id) {
		$this->system->sql->update('categorias', array(
            'excluido' 	=> 1),
		"id='" . $id . "'");
	}
	// ===============================================================
	public function atualizarCampos($id, $campos = array()) {
		$this->system->sql->update('categorias', $campos, "id='" . $id . "'");
	}
	// ===============================================================
	public function getCategoriasNiveis($orderby = 'categoria') {
		$query = $this->system->sql->select('*', 'categorias', "status='0' and excluido='0' and categoria_pai_id = 0", '', $orderby);
		$categorias =  $this->system->sql->fetchrowset($query);
		foreach ($categorias as $key => $categoria) {
				$query = $this->system->sql->select('id, categoria, url', 'categorias', "status='0' and excluido='0' and categoria_pai_id= '" . $categoria['id'] . "'");
				$categoriasFilhas =  $this->system->sql->fetchrowset($query);
				foreach ($categoriasFilhas as $filha) 
					$categorias[$key]['filhas'][] = $filha;	
		}
		return $categorias;
	}
	// ===========================================================
	public function getIdByUrl($url) { 
		$query = $this->system->sql->select('id', 'categorias', "excluido = 0 and url = '" . $url . "'");
		$resultado = end($this->system->sql->fetchrowset($query));
		return ($resultado['id'] ? $resultado['id'] : false);
	}
	// ===============================================================


}
// ===================================================================