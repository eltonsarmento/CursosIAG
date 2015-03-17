<!doctype html>
<html lang="pt-br">
<head>

	<meta charset="utf-8">
	<title>Relatório de Certificado - Cursos IAG</title>

	<link href="{$url_site}lms/common/relatorio/css/style.css" type="text/css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">

</head>

<body>

	<header>

		<figure><img src="{$url_site}lms/common/relatorio/logo-cursosiag.png"></figure>

	</header>

	<section class="content">

		<h1>RELATÓRIO DE CERTIFICADOS POR ALUNO</h1>

		<h2><strong>Aluno:</strong> {$aluno.nome}</h2>

		<h2><strong>Período:</strong> {$periodo1} a {$periodo2}</h2>

		<!--<h2><strong>Percentual Assistido:</strong> 70%</h2>-->

		<section class="table">

			<table>

				<thead>

					<th>Curso</th>
					<th style="text-align:center;">Percentual Assistido</th>
					<th style="text-align:center;">Data de Emissão</th>
					<th style="text-align:center;">Tipo de Certificado</th>
					<th style="text-align:center;">Status do Certificado</th>

				</thead>

				<tbody>
					{foreach item=certificado from=$certificados}
					<tr>

						<td>{$certificado.curso.curso}</td>
						<td style="text-align:center;">{$certificado.concluido}%</td>
						<td style="text-align:center;">{$certificado.data_emissao|date_format:"%d/%m/%Y"}</td>
						<td style="text-align:center;">{if $certificado.tipo_certificado == 1} Digital {else} Impresso {/if}</td>
						<td style="text-align:center;">
							{if $certificado.status == 1}
                                Entregue
                            {elseif $certificado.status == 2}
                            	Enviado
                            {elseif $certificado.status == 3}
                            	Aguardando pagamento
                            {elseif $certificado.status == 4}
                         		Cancelado por falta de pagamento
                            {/if}
                        </td>
					</tr>
					{/foreach}
					
				</tbody>

			</table>

		</section><!--.table-->

		<h2><strong>Total de Registros:</strong> {$total}</h2>

	</section><!--.content-->

	<footer>

		<span style="float:right;">{$data_atual}</span>

	</footer>

</body>
</html>