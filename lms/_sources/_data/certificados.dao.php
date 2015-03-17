<?php
// ===================================================================
class CertificadosDAO {
	// ===============================================================
	protected $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();		
	}
	// ===============================================================
    public function cadastrar($campos) {
        $campos['excluido'] = 0;
        $campos['data_solicitacao'] = date('Y-m-d');

        $this->system->sql->insert('certificados', $campos);
        return $this->system->sql->nextid();
    }
    // ==============================================================
	public function getCertificados($palavra = '', $limit = '') {
		$sql_extra = '';
        //curso
        if ($palavra != '') 
            $sql_extra = " AND (curso_id IN (SELECT id FROM cursos WHERE curso like '%" . $palavra . "%' and excluido = 0) OR aluno_id IN (SELECT id FROM usuarios WHERE nome like '%" . $palavra . "%' ))";

		$query = $this->system->sql->select('*', 'certificados', "excluido='0'" . $sql_extra, $limit, 'data_solicitacao desc');
        $certificados = $this->system->sql->fetchrowset($query);

        foreach ($certificados as $key => $certificado) {
            //Aluno
            $query = $this->system->sql->select('*', 'usuarios', "id='" . $certificado['aluno_id'] . "'");
            $aluno = $this->system->sql->fetchrowset($query);
            if ($aluno[0]['nome']) 
                $certificados[$key]['aluno'] = $aluno[0];
            
            //Curso
            $query = $this->system->sql->select('*', 'cursos', "id='" . $certificado['curso_id'] . "'");
            $curso = $this->system->sql->fetchrowset($query);
            if ($curso[0]['curso'])
                $certificados[$key]['curso'] = $curso[0];
        }
        return $certificados;
	}
	// ===============================================================
	public function getCertificado($id) {
		$query = $this->system->sql->select('*', 'certificados', "excluido='0' and id = '" . $id . "'");
        $certificado = end($this->system->sql->fetchrowset($query));

        if ($certificado['id']) {
            //Aluno
            $query = $this->system->sql->select('*', 'usuarios', "id='" . $certificado['aluno_id'] . "'");
            $aluno = $this->system->sql->fetchrowset($query);
            if ($aluno[0]['nome'])
                $certificado['aluno'] = $aluno[0];

            //Curso
            $query = $this->system->sql->select('*', 'cursos', "id='" . $certificado['curso_id'] . "'");
            $curso = $this->system->sql->fetchrowset($query);
            if ($curso[0]['curso'])
                $certificado['curso'] = $curso[0];
        }
        return $certificado;
	}
    // ==============================================================
    public function getCertificadosCondicao($campos = '', $limit = '') {
        $query = $this->system->sql->select('*', 'certificados', 'excluido = 0 ' . $campos, $limit);
        return $this->system->sql->fetchrowset($query);
    }
    // ===============================================================
    public function getCertificadoCondicao($campos = '') {
        return end($this->getCertificadosCondicao($campos, 1));
    }
    // ===============================================================
    public function salvarStatus($id, $status) {
        $fields = array('status' => $status);
        if (in_array($status, array(1, 2))) 
            $fields['data_emissao'] = date('Y-m-d');
        $this->system->sql->update('certificados', $fields, "id='" . $id . "'");
    }
    //===============================================================
    public function salvarRastreamento($id, $rastreamento) {
        $this->system->sql->update('certificados', array('codigo_rastreamento' => $rastreamento), "id='" . $id . "'");
    }
    //Relatorios
    //===============================================================
    public function relatorioPorCursos($curso_id, $periodo1, $periodo2, $aluno = 0) {
        //Dados curso
        $query = $this->system->sql->select('count(aula_id) as total', 'cursos_aulas', "curso_id='" . $curso . "' and excluido = '0'");
        $curso = end($this->system->sql->fetchrowset($query));
		
        $query = $this->system->sql->select('id, aluno_id, curso_id, tipo_certificado, data_emissao, matricula_curso_id, status', 'certificados', "excluido = 0 AND tipo_certificado = 2 AND curso_id = '" . $curso_id . "' AND data_emissao >= '" . $periodo1 . "' AND data_emissao <= '" . $periodo2 . "'" . ($aluno? " AND aluno_id = '" . $aluno . "'" : ''));
        $certificados = $this->system->sql->fetchrowset($query);
		
        foreach ($certificados as $key => $certificado) {
            //Dados aluno
            $query = $this->system->sql->select('*', 'usuarios', "id='" . $certificado['aluno_id'] . "' and excluido = '0'");
            $aluno = end($this->system->sql->fetchrowset($query));            
            if ($aluno['id'])
                $certificados[$key]['aluno'] = $aluno;
				
			//Curso
            $query = $this->system->sql->select('*', 'cursos', "id='" . $certificado['curso_id'] . "' and excluido = '0'");
            $curso = end($this->system->sql->fetchrowset($query));            
            if ($curso['id'])
                $certificados[$key]['curso'] = $curso;
				
            //Matricula curso
            // $query = $this->system->sql->select('id, aulas_assistidas', 'cursos_alunos', "id='" . $certificado['matricula_curso_id'] . "' and excluido = '0'");
            // $cursoAluno = end($this->system->sql->fetchrowset($query));            
            // if ($cursoAluno['id']) {
            //     $certificados[$key]['concluido'] = ($curso['total'] ? round(((int)$cursoAluno['aulas_assistidas']/(int)$curso['total'])*100) : 0);
            // }
        }
        return $certificados;
    }
    //===============================================================
    public function relatorioPorAluno($aluno, $periodo1, $periodo2) {
        $query = $this->system->sql->select('aluno_id, curso_id, tipo_certificado, data_emissao, matricula_curso_id, status', 'certificados', "excluido = 0 AND tipo_certificado = 2 AND data_emissao >= '" . $periodo1 . "' AND data_emissao <= '" . $periodo2 . "' AND aluno_id = '" . $aluno . "'");
        $certificados = $this->system->sql->fetchrowset($query);
		
        foreach ($certificados as $key => $certificado) {
            //Curso
            $query = $this->system->sql->select('*', 'cursos', "id='" . $certificado['curso_id'] . "' and excluido = '0'");
            $curso = end($this->system->sql->fetchrowset($query));            
            if ($curso['id'])
                $certificados[$key]['curso'] = $curso;
			
            //Dados aulas
            $query = $this->system->sql->select('count(aula_id) as total', 'cursos_aulas', "curso_id='" . $curso['id'] . "' and excluido = '0'");
            $curso = end($this->system->sql->fetchrowset($query));
			
            //Matricula curso
            // $query = $this->system->sql->select('id, aulas_assistidas', 'cursos_alunos', "id='" . $certificado['matricula_curso_id'] . "' and excluido = '0'");
            // $cursoAluno = end($this->system->sql->fetchrowset($query));            
            // if ($cursoAluno['id']) {
            //     $certificados[$key]['concluido'] = round(($cursoAluno['aulas_assistidas']/$curso['total'])*100);
                
            // }
        }
        return $certificados;   
    }
    //===============================================================
    public function relatorioPorPeriodo($periodo1, $periodo2) {
        $query = $this->system->sql->select('id, aluno_id, curso_id, tipo_certificado, data_emissao, matricula_curso_id, status', 'certificados', "excluido = 0 AND tipo_certificado = 2 AND data_emissao >= '" . $periodo1 . "' AND data_emissao <= '" . $periodo2 . "'");
        $certificados = $this->system->sql->fetchrowset($query);
        foreach ($certificados as $key => $certificado) {
            //Dados aluno
            $query = $this->system->sql->select('*', 'usuarios', "id='" . $certificado['aluno_id'] . "' and excluido = '0'");
            $aluno = end($this->system->sql->fetchrowset($query));            
            if ($aluno['id'])
                $certificados[$key]['aluno'] = $aluno;
				
            //Curso
            $query = $this->system->sql->select('*', 'cursos', "id='" . $certificado['curso_id'] . "' and excluido = '0'");
            $curso = end($this->system->sql->fetchrowset($query));            
            if ($curso['id'])
                $certificados[$key]['curso'] = $curso;
				
            //Dados aulas
            $query = $this->system->sql->select('count(aula_id) as total', 'cursos_aulas', "curso_id='" . $curso['id'] . "' and excluido = '0'");
            $curso = end($this->system->sql->fetchrowset($query));
			
            //Matricula curso
            // $query = $this->system->sql->select('id, aulas_assistidas', 'cursos_alunos', "id='" . $certificado['matricula_curso_id'] . "' and excluido = '0'");
            // $cursoAluno = end($this->system->sql->fetchrowset($query));            
            // if ($cursoAluno['id']) {
            //     $certificados[$key]['concluido'] = round(($cursoAluno['aulas_assistidas']/$curso['total'])*100);
                
            // }
        }
        return $certificados;   
    }
	//===============================================================
	public function getTotalCertificados() {
		$query = $this->system->sql->select('COUNT(1)', 'certificados', "excluido = 0 AND tipo_certificado = 2 " . $campos);
		return $this->system->sql->querycountunit($query);
	}
}
// ===================================================================