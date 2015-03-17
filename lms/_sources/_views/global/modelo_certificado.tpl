<!DOCTYPE html>
<html>
<head>
	<title>Certificado</title>

	<meta charset="utf-8">

	<link rel="stylesheet" href="{$url_site}lms/common/certificado/fonts/font.css">

	{literal}

	<style type="text/css">

	.dados-certificado-title {

		color: #fff;
		font-size: 18px;
		font-weight: 700;
		margin: 400px 0 0 0 !important;

	}

	.dados-certificado-texto {

		font-size: 14px;
		color: #fff;

	}

	.logo {
		margin-bottom: 100px;
	}

	.title {

		font-family: 'bariol_boldbold';
		font-weight: 300;
		font-size: 60px;
	}

	.dados-aluno-texto {

		font-size: 18px;
		margin: 10px 0;
		font-size: 26px;
		/*padding: 20px 0;*/

		text-transform: uppercase;

	}

	.dados-aluno-texto strong {

		font-family: 'bariol_boldbold';
		font-weight: 300;
		font-size: 22px;

	}

	.date {

		font-family: 'bariol_boldbold';
		font-weight: 300;
		font-size: 22px;
		margin: 60px 0 0 0;
		float: left;

	}

	.assinatura {

		width: 187px;
		height: 111px;
		margin: 80px 0 0 0;
		padding: 80px 0 0 0;
		float: right;

	}

	</style>

	{/literal}

</head>
<body>

	<table cellpadding="0" cellspacing="0" border="0" width="100%">

		<tbody>

			<tr>

				<td width="308" style="background:url('{$url_site}lms/common/certificado/ld-direito.jpg') no-repeat;width:308px;height:792px;padding:0 20px;padding-top:600px;">

			   		<h1 class="dados-certificado-title">CURSOS IAG</h1>
			   		<p class="dados-certificado-texto">CNPJ: 11.432.779/0001-30</p>
					<p class="dados-certificado-texto">(82) 3034-5153</p>
					<p class="dados-certificado-texto">www.cursosiag.com.br</p>

					<br>

					<p class="dados-certificado-texto">Rua Treze de Maio, 90, Poço <br>CEP: 57025-410 | Maceió - AL</p>

					<br>

					<p class="dados-certificado-texto">Nº: CIAG{$numero}</p>

				</td>

				<td style="text-align:center;">

					<img src="{$url_site}lms/common/certificado/logo.jpg" width="211" height="54" class="logo">

			   		<span>
			   			<h1 class="title">CERTIFICADO</h1>
			   			<br/><br/><br/><br/><br/><br/>
			   		</span>

			   		<span>
			   			<p class="dados-aluno-texto">CERTIFICAMOS QUE</p>
			   		</span>

			   		<span>
			   			<p class="dados-aluno-texto"><strong>{$aluno}</strong></p>
			   		</span>

			   		<span>
			   			<p class="dados-aluno-texto">CONCLUIU O</p>
			   		</span>

			   		<span>
			   			<p class="dados-aluno-texto"><strong>{$curso}</strong></p>
			   		</span>

			   		<span>
			   			<p class="dados-aluno-texto">EM <strong>{$data_solicitacao}</strong> COM CARGA HORÁRIA DE <strong>{$carga}</strong> HORAS AULA.</p>
			   		</span>

			   		<span>
			   			<p class="dados-aluno-texto date" style="padding-right:200px;padding-top:60px;float:left;"><strong>Maceió, {$data_emissao}.</strong></p>
			   			<img src="{$url_site}lms/common/certificado/assinatura.jpg" width="187" height="111" class="assinatura" style="padding-left:200px;padding-top:80px;float:right;">
			   		</span>

		   		</td>

			</tr>

		</tbody>

	</table>

</body>
</html>

