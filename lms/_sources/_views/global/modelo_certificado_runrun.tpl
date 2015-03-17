<!DOCTYPE html>
<html>
<head>
	<title>Certificado</title>

	<meta charset="utf-8">

	<link rel="stylesheet" href="{$url_site}lms/common/certificado_runrun/fonts/font.css">

	{literal}

	<style type="text/css">

	* {

		margin: 0;
		padding: 0;

	}

	body {

		font-family: 'bariol_regularregular';
		margin: 0;
		padding: 0;

	}

	table {

		margin: 0;
		padding: 0;

	}

	tr {

		margin: 0;
		padding: 0;

	}

	td {

		margin: 0;
		padding: 0;

	}

	.dados-certificado-title {

		color: #fff;
		font-size: 18px;
		font-weight: 700;
		margin: 400px 0 0 0;

	}

	.dados-certificado-texto {

		font-size: 14px;
		color: #fff;

	}

	.selo {

		width: 119px;
		height: 40px;
		margin: 20px auto;

	}

	.logo {

		width: 211px;
		height: 54px;
		margin: 0 30px;

	}

	.runrunit {

		width: 188px;
		height: 54px;
		margin: 0 30px;

	}

	.title {

		font-family: 'bariol_boldbold';
		font-weight: 300;
		font-size: 60px;
		padding: 10px 0 40px 0;
		text-align: center;
		
	}

	.dados-aluno-texto {

		font-size: 18px;
		margin: 10px 0;
		text-transform: uppercase;

	}

	.dados-aluno-texto-destaque {

		font-family: 'bariol_boldbold';
		font-weight: 300;
		font-size: 22px;

	}

	.date {

		font-family: 'bariol_boldbold';
		font-weight: 300;
		font-size: 22px;
		margin: 80px 0 0 0;
		float: left;

	}


	.assinatura {

		width: 187px;
		height: 111px;
		margin: 30px 0 0 0;
		float: right;

	}

	</style>
	{/literal}

</head>
<body>

	<table cellpadding="0" cellspacing="0" border="0" width="970">

		<tbody>

			<tr>

				<td width="308" style="background:url('{$url_site}lms/common/certificado_runrun/ld-direito.jpg') no-repeat;width:308px;height:792px;padding:0 20px;padding-top:600px;">

			   		<h1 class="dados-certificado-title">CURSOS IAG</h1>
			   		<p class="dados-certificado-texto">CNPJ: 11.432.779/0001-30</p>
					<p class="dados-certificado-texto">(82) 3034-5153</p>
					<p class="dados-certificado-texto">www.cursosiag.com.br</p>

					<br>

					<p class="dados-certificado-texto">Rua Treze de Maio, 90, Poço <br>CEP: 57025-410 | Maceió - AL</p>

					<br>

					<p class="dados-certificado-texto">Nº: CIA{$numero}</p>

				</td>

				<td style="padding:20px 40px;text-align:center;">

			   		<img src="{$url_site}lms/common/certificado_runrun/logo.jpg" width="211" height="54" class="logo"> <img src="{$url_site}lms/common/certificado_runrun/logo-runrunit.png" width="188" height="54" class="runrunit">

			   		<img src="{$url_site}lms/common/certificado_runrun/rr_partners_seal_119x40.png" width="119" height="40" class="selo">

			   		<h1 class="title">CERTIFICADO</h1>

			   		<p class="dados-aluno-texto">CERTIFICAMOS QUE</p>

			   		<p class="dados-aluno-texto"><strong class="dados-aluno-texto-destaque">{$aluno}</strong></p>

			   		<p class="dados-aluno-texto">CONCLUIU O CURSO DE</p>

			   		<p class="dados-aluno-texto"><strong class="dados-aluno-texto-destaque">{$curso}</strong></p>

			   		<p class="dados-aluno-texto">EM <strong class="dados-aluno-texto-destaque">{$data_solicitacao}</strong> COM CARGA HORÁRIA DE <strong class="dados-aluno-texto-destaque">{$carga}</strong> HORAS AULA.</p>

			   		<p class="dados-aluno-texto date"><strong class="dados-aluno-texto-destaque">Maceió, {$data_emissao}.</strong></p>

			   		<img src="{$url_site}lms/common/certificado_runrun/assinatura.jpg" width="187" height="111" class="assinatura">

		   		</td>

			</tr>

		</tbody>

	</table>

</body>
</html>

