<html>
<head>
	<title>Relatório de Certificado - Cursos IAG</title>

	<link href="{$url_site}lms/common/relatorio/css/style.css" type="text/css" rel="stylesheet">
	<!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">-->

</head>

<body>

	<center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{$dir_site}/common/relatorio/logo-cursosiag.png"></center><br>
	<hr>
	<h2>RELATÓRIO DE CERTIFICADOS POR PERÍODO</h2>
	<h3>
		<b>Período:</b> {$periodo1} a {$periodo2}<br>
	</h3><br>

		<!--<h2><strong>Percentual Assistido:</strong> 70%</h2>-->

		<table width="100%" collspan="0" cellspacing="0">

				<tr>

					<td style="background: #222222; color: #FFFFFF; border: 1px solid #666666; font-weight: 400; padding: 5px 10px; text-align:center;">Aluno</td>
					<td style="background: #222222; color: #FFFFFF; border: 1px solid #666666; font-weight: 400; padding: 5px 10px; text-align:center;">Curso</td>
					<td style="background: #222222; color: #FFFFFF; border: 1px solid #666666; font-weight: 400; padding: 5px 10px; text-align:center;">Percentual Assistido</td>
					<td style="background: #222222; color: #FFFFFF; border: 1px solid #666666; font-weight: 400; padding: 5px 10px; text-align:center;">Data de Emissão</td>
					<td style="background: #222222; color: #FFFFFF; border: 1px solid #666666; font-weight: 400; padding: 5px 10px; text-align:center;">Tipo de Certificado</td>
					<td style="background: #222222; color: #FFFFFF; border: 1px solid #666666; font-weight: 400; padding: 5px 10px; text-align:center;">Status do Certificado</td>

				</tr>

				<tbody>
					{foreach item=certificado from=$certificados}
					<tr>
						<td style="background: #F0F0F0; color: #222222; border: 1px solid #CCCCCC; padding: 8px 10px; text-align:center;">{$certificado.aluno.nome}</td>
						<td style="background: #F0F0F0; color: #222222; border: 1px solid #CCCCCC; padding: 8px 10px; text-align:center;">{$certificado.curso.curso}</td>
						<td style="background: #F0F0F0; color: #222222; border: 1px solid #CCCCCC; padding: 8px 10px; text-align:center;">{$certificado.concluido}%</td>
						<td style="background: #F0F0F0; color: #222222; border: 1px solid #CCCCCC; padding: 8px 10px; text-align:center;">{$certificado.data_emissao|date_format:"%d/%m/%Y"}</td>
						<td style="background: #F0F0F0; color: #222222; border: 1px solid #CCCCCC; padding: 8px 10px; text-align:center;">{if $certificado.tipo_certificado == 1} Digital {else} Impresso {/if}</td>
						<td style="background: #F0F0F0; color: #222222; border: 1px solid #CCCCCC; padding: 8px 10px; text-align:center;">
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

		<h3><strong>Total de Registros:</strong> {$total}</h3>
		<hr>
		<font style="float: right !important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$data_atual}</font>

</body>
</html>