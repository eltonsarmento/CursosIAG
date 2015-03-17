<table>
	<tr><td colspan="6"><h1>RELATÓRIO DE CERTIFICADOS POR PERÍODO</h1></td></tr>
	
	<tr>
		<td><strong>Periodo</strong></td><td>{$periodo1} - {$periodo2}</td>
	</tr>
	<tr style="height:30px;"></tr>
	<tr style="border:1px;">
		<th>Aluno</th>
		<th>Curso</th>
		<th>Percentual Assistido</th>
		<th>Data de Emissão</th>
		<th>Tipo de Certificado</th>
		<th>Status do Certificado</th>
	</tr>
	{foreach item=certificado from=$certificados}
	<tr style="border:1px;">

		<td>{$certificado.aluno.nome}</td>
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
	
	<tr style="background-color: #CCCCCC;"><td>Total </td><td>{$total}</td></tr>
	<tr style="height:30px;"></tr>
	<tr><td colspan="4"></td><td> Data Atual - {$data_atual} </td></tr>
</table>