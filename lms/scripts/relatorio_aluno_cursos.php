<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//load
$system->load->dao('curso');
$system->load->dao('alunos');


//Configurações
$alunoID = 36;

//Gerar XLS
header("Content-type: application/msexcel; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename=relatorio_aluno.xls");

echo '<table>';
echo '<tr>';
echo '<th>Curso</th>';
echo '<th>Ativo</th>';
echo "</tr>";

$matriculas = $system->curso->getCursosAlunos(" and usuario_id = '" . $alunoID . "'", '', '', false);
foreach($matriculas as $matricula) {
	$curso = $system->curso->getCurso($matricula['curso_id']);
	
	echo "<tr>";
	echo "<td>".utf8_decode($curso['curso'])."</td>";
	echo "<td>" . utf8_decode(($matricula['excluido'] == 0 && $matricula['expira'] >= date('Y-m-d H:i:s') ? 'Sim' : 'Não')) . "</td>";
	echo "</tr>";
}

echo "</table>";

// ===================================================================