<?php 
const DB_SERVIDOR = '192.168.25.100';
const DB_USUARIO = 'root';
const DB_SENHA = '12pqrt33xz';
const DB_NOME = 'iag';

$host = 'mysql.cursosiag.com.br'; // MYSQL database host adress
$db = 'cursosiag'; // MYSQL database name
$user = 'cursosiag'; // Mysql Database user
$pass = 'EdgeCCLmS1$3@'; // Mysql Database password

// Conexão com o bando de dados
$link = mysql_connect($host, $user, $pass);
mysql_select_db($db);

$query = "SELECT * FROM usuarios usu, usuarios_dados usu_dados WHERE usu_dados.estado = 'Alagoas' AND usu.id = usu_dados.usuario_id AND usu.nivel = 4 AND email NOT IN ('carlos@kmf.com.br', 'aluno@kmf.com.br')";
 
$executar_query = mysql_query($query);


$html .= "<table>";
$html .= "<tr>
			<td>
				Nome
			</td>
			<td>
				Email
			</td>
			<td>
				data de cadastro
			</td>
			<td>
				cpf
			</td>
			<td>
				cep
			</td>
			<td>
				data_nascimento
			</td>
			<td>
				cidade
			</td>
			<td>
				endereço
			</td>
			<td>
				complemento
			</td>
		</tr>";

while($ret = mysql_fetch_array($executar_query)){
	$html .= "<tr>";
	$html .= "<td>".$ret['nome']."</td>";
	$html .= "<td>".$ret['email']."</td>";
	$html .= "<td>".$ret['data_cadastro']."</td>";
	$html .= "<td>".$ret['cpf']."</td>";
	$html .= "<td>".$ret['cep']."</td>";
	$html .= "<td>".$ret['data_nascimento']."</td>";
	$html .= "<td>".$ret['cidade']."</td>";
	$html .= "<td>".$ret['endereco']."</td>";
	$html .= "<td>".$ret['complemento']."</td>";
	$html .= "</tr>";
}

$html .= "</table>";


header("Content-type: application/msexcel; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename=relatorio_alunos_alagoanos.xls");
echo $html;
?>

