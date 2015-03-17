<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//load
$system->load->dao('curso');
$system->load->dao('alunos');


//Configurações
$cursoID = 98;

//Pegar alunos da matricula
$matriculas = $system->curso->getCursosAlunos(" and curso_id = '" . $cursoID . "'", '', '', false);

$alunos = array();
foreach ($matriculas as $matricula) {
	$alunos[] = array('aluno_id' => $matricula['usuario_id'], 'ativo' => ($matricula['excluido'] || $matricula['expira'] < date('Y-m-d H:i:s') ? 'Não' : 'Sim'));
}

//Gerar XLS
header("Content-type: application/msexcel; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename=relatorio_html_css.xls");

echo '<table>';
echo '<tr>';
echo '<th>Nome</th>';
echo '<th>E-mail</th>';
echo '<th>Ativo</th>';
echo '<th>Cursos Adquiridos</th>';
echo "</tr>";


foreach ($alunos as $aluno) {
	$aluno2 = $system->alunos->getAluno($aluno['aluno_id']);
	$matriculas = $system->curso->getCursosAlunos(" and usuario_id = '" . $aluno['aluno_id'] . "'", '', '', false);
	
	echo "<tr>";
	echo "<td>".utf8_decode($aluno2['nome'])."</td>";
	echo "<td>{$aluno2['email']}</td>";
	echo "<td>" . utf8_decode($aluno['ativo']) . "</td>";
	echo "<td>";
	foreach($matriculas as $matricula) {
		$curso = $system->curso->getCurso($matricula['curso_id']);
		echo utf8_decode($curso['curso'])." | ";
	}
	echo "</td>";
	echo "</tr>";

}

echo "</table>";

// ===================================================================