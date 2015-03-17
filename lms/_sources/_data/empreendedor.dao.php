<?php
// ===================================================================
class EmpreendedorDAO {
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
	public function cadastrar($input) {
		$this->system->sql->insert('canto_empreendedor', array(
        	'titulo'		    => trim($input['titulo']),
        	'descricao'			=> trim($input['descricao']),
        	'tipo_video'        => intval($input['tipo_video']),
        	'link_video'	    => trim($input['link_video']),
        	'data_cadastro'     => date('Y-m-d H:i:s'),
            'fonte'             => trim($input['fonte']),
        ));

		$id = $this->system->sql->nextid();
        return $id;
	}
	// ===============================================================
	public function atualizar($input) {
		$this->system->sql->update('canto_empreendedor', array(
        	'titulo'           => trim($input['titulo']),
            'descricao'         => trim($input['descricao']),
            'tipo_video'        => intval($input['tipo_video']),
            'link_video'        => trim($input['link_video']),
            'data_cadastro'     => date('Y-m-d H:i:s'),
            'fonte'             => trim($input['fonte']),
        ),
		"id='" . $input['id'] . "'");
		
		
	}
    // ===============================================================
    public function excluir($id){
        $this->system->sql->update('canto_empreendedor', array(
            'excluido'           => 1,
        ),
        "id='" . $id . "'");
    }
	// ===============================================================
    public function getCantosEmpreendedores(){
        $order = "data_cadastro";
        $limit = "";
        $queryEmpreendedor = $this->system->sql->select('*', 'canto_empreendedor','excluido=0',$limit, $order);
        $empreendedor = $this->system->sql->fetchrowset($queryEmpreendedor);
        return $empreendedor;
    }
    // ===============================================================
    public function getCantoEmpreendedor($id){
        $queryEmpreendedor = $this->system->sql->select('*', 'canto_empreendedor',"excluido=0 and id='".$id."'");
        $empreendedor = end($this->system->sql->fetchrowset($queryEmpreendedor));
        return $empreendedor;   
    }
    // ===============================================================
    public function getUltimoPostado(){
        $order = "data_cadastro desc";
        $limit = "1";
        $queryEmpreendedor = $this->system->sql->select('*', 'canto_empreendedor','excluido=0',$limit, $order);
        $empreendedor = end($this->system->sql->fetchrowset($queryEmpreendedor));
        return $empreendedor;   
    }
    // ===============================================================
    public function getMaisDicasEmpreendedor($id){
        $order = "";
        $limit = "";
        /*$queryEmpreendedor = $this->system->sql->select('DISTINCT c.*, v.visualizado', 'canto_empreendedor c LEFT JOIN canto_empreendedor_visualizacao v ON c.id = v.id_dica LEFT JOIN usuarios u ON v.id_usuario = u.id',"c.id NOT IN(".$id.")",$limit, $order);*/

        $queryEmpreendedor = $this->system->sql->select('*', 'canto_empreendedor', "excluido=0 and id NOT IN(".$id.")");
        $empreendedor = $this->system->sql->fetchrowset($queryEmpreendedor);
        foreach ($empreendedor as $key => $emp) {
            $visualizado = end($this->system->sql->fetchrowset($this->system->sql->select('visualizado', 'canto_empreendedor_visualizacao', "id_dica='".$emp['id']."' and id_usuario='".$this->system->session->getItem('session_cod_usuario')."'")));
            $empreendedor[$key]['visualizado'] = $visualizado['visualizado'] == "" ? 0 : $visualizado['visualizado'];
        }
        

        return $empreendedor;      
    }

    // ===============================================================
    public function lerDicasEmpreendedor($id_usuario, $id_dica){
        $queryDicaJaLida = $this->system->sql->select('count(1) qtd', 'canto_empreendedor_visualizacao',"id_dica=".$id_dica." and id_usuario=".$this->system->session->getItem('session_cod_usuario')."");
        $quantidade = end($this->system->sql->fetchrowset($queryDicaJaLida));
        
        if($quantidade['qtd'] == 0) {
            $this->system->sql->insert('canto_empreendedor_visualizacao', array(
                'id_usuario'        => $id_usuario,
                'id_dica'           => $id_dica,
            ));
            $id = $this->system->sql->nextid();
            return $id;    
        }
    }

    // ================METODOS PARA BUSCA=============================
    public function buscarTodasAsDicas(){
        $order = "";
        $limit = "";
        $queryTodas = $this->system->sql->select('*, c.id', 'canto_empreendedor c LEFT JOIN canto_empreendedor_visualizacao v ON c.id = v.id_dica LEFT JOIN usuarios u ON v.id_usuario = u.id',"c.excluido=0",$limit, $order);
        $todas = $this->system->sql->fetchrowset($queryTodas);
        return $todas;     
    }

    // ===============================================================
    public function buscarTodasAsDicasLidas(){
        $order = "";
        $limit = "";
        $queryTodas = $this->system->sql->select('*, c.id', 'canto_empreendedor c LEFT JOIN canto_empreendedor_visualizacao v ON c.id = v.id_dica LEFT JOIN usuarios u ON v.id_usuario = u.id',"c.id IN(SELECT id_dica FROM canto_empreendedor_visualizacao) and c.excluido=0",$limit, $order);
        $todas = $this->system->sql->fetchrowset($queryTodas);
        return $todas;     
    }
    // ===============================================================
    public function buscarTodasAsDicasNaoLidas(){
        $order = "";
        $limit = "";
        $queryTodas = $this->system->sql->select('*, c.id', 'canto_empreendedor c LEFT JOIN canto_empreendedor_visualizacao v ON c.id = v.id_dica LEFT JOIN usuarios u ON v.id_usuario = u.id',"c.id NOT IN(SELECT id_dica FROM canto_empreendedor_visualizacao) and c.excluido=0",$limit, $order);
        $todas = $this->system->sql->fetchrowset($queryTodas);
        return $todas;     
    }

    // ===============================================================
}
// ===================================================================