<?php
$con = mysql_connect('192.168.25.120', 'root', '123456');
$db = mysql_select_db('iag', $con);

$arquivo = 'bd_aa.txt';
$conteudo = file($arquivo);

/*
foreach ($conteudo as $key => $insert) {
	if ($ins = mysql_query($insert, $con)) {
		echo 'Linha: ' . ($key + 1) . ' OK' .'<br>';
	}

	// else {
	//	echo 'Linha: ' . ($key + 1) . ' FAIL' .'<br>';
	//}
	
}
*/

for($i=0;$i<70;$i++)
{
echo 'printing...<br>';
ob_flush();
flush();
sleep(3);
}