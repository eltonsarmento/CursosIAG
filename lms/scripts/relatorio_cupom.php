<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

//load
$system->load->dao('vendas');
$system->load->dao('alunos');
$system->load->dao('curso');


//Configurações
$cupomID = 11;

//Pegar alunos da venda
$vendas = $system->vendas->getVendas(" and cupom_id = '" . $cupomID . "' and status = 1");

$alunos = array();
foreach ($vendas as $venda) {
	$alunos[] = $venda['aluno_id'];
}

//Dados dos alunos
$alunos = array_unique($alunos);



//Gerar XLS
header("Content-type: application/msexcel; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename=relatorio_cupom.xls");

echo '<table>';
echo '<tr>';
echo '<th>Nome</th>';
echo '<th>E-mail</th>';
echo '<th>Cursos</th>';
echo "</tr>";


foreach ($alunos as $aluno) {
	$aluno = $system->alunos->getAluno($aluno);
	$matriculas = $system->curso->getCursosAlunos(" and usuario_id = '" . $aluno['id'] . "'", '', '', false);
	
	echo "<tr>";
	echo "<td>".utf8_decode($aluno['nome'])."</td>";
	echo "<td>{$aluno['email']}</td>";
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