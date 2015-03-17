function carregaDadosVendaPorDia(categoria, de, ate) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosVendaPorDia/',
		data: { data1: de, data2: ate }}).done(
			function html(html) {
				var data = jQuery.parseJSON(html);
				var tabela = '';
				jQuery('#dia_vendas_ate').html(data.vendas_periodo);
				jQuery('#total_vendas_dia').html('R$ ' + data.total_vendas_dia);
				jQuery('#total_pedidos_dia').html(data.total_pedidos_dia + ' <strong>(' + data.total_pedidos_dia + ' Item)</strong>');
				
				jQuery.each(data.ultimas_10_vendas_dia, function(i, item) {
					tabela += '<tr><td><a href="/lms/' + categoria + '/vendas/detalhes/' + item.id + '">' + item.numero + '</a></td><td>' + item.cliente.nome + '</td><td>' + item.cursos + '</td><td class="center">R$ ' + item.valor_total + '</td></tr>';
					
				});
				jQuery('#tabela_vendas_dia').html(tabela);
			}
		);
}

function carregaDadosVendaPorMes(categoria, mes, ano) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosVendaPorMes/',
		data: { mes: mes, ano: ano }}).done(
			function html(html) {
				var data = jQuery.parseJSON(html);
				var tabela = '';
				jQuery.each(data.ultimas_10_vendas_mes, function(i, item) {
					tabela += '<tr><td><a href="/lms/' + categoria + '/vendas/detalhes/' + item.id + '">' + item.numero + '</a></td><td>' + item.cliente.nome + '</td><td>' + item.cursos + '</td><td class="center">R$ ' + item.valor_total + '</td></tr>';
				});
				jQuery('#tabela_vendas_mes').html(tabela);
			}
		);
}

function carregaDadosVendaPorProdutos(categoria, curso) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosVendaPorProdutos/',
		data: { curso_id: curso }}).done(
			function html(html) {
				var data = jQuery.parseJSON(html);
				var tabela = '';
				jQuery('#tabela_vendas_por_produtos').html(tabela);
				tabela += '<table class="table table-bordered"><thead><th class="center">M&ecirc;s</th><th class="center">Qtd de Vendas</th><th class="center">Valor Total</th></thead><tbody>';
				
				jQuery.each(data, function(i, item) {
					tabela += '<tr><td class="center">' + item.mes + '</td><td class="center">' + item.quantidade + '</td><td>R$ ' + item.total + '</td></tr>';
				});
				
				tabela += '</tbody></table>';
				jQuery('#tabela_vendas_por_produtos').html(tabela);
			}
		);
}

function carregaDadosVendaMaisVendidos(categoria, de, ate) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosVendaMaisVendidos/',
		data: { data1: de, data2: ate }}).done(
			function html(html) {
				var data = jQuery.parseJSON(html);
				var tabela = '';
				jQuery.each(data, function(i, item) {
					tabela += '<tr><td>' + item.curso + '</td><td>' + item.quantidade + '</td><td>R$ ' + item.total + '</td></tr>';
				});
				jQuery('#tabela_vendas_por_mais_vendidos').html(tabela);
			}
		);
}

function carregaDadosVendaTopConsumidores(categoria, mes, ano) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosVendaTopConsumidores/',
		data: { mes: mes, ano: ano }}).done(
			function html(html) {
				var data = jQuery.parseJSON(html);
				var tabela = '';
				jQuery.each(data, function(i, item) {
					tabela += '<tr><td>' + item.nome + '</td><td class="center">' + item.compras + '</td><td class="center">' + item.total_cursos + '</td><td>R$ ' + item.total + '</td></tr>';
				});
				jQuery('#tabela_vendas_top_consumidores').html(tabela);
			}
		);
}

function carregaDadosVendaPorCategorias(categoria, mes, ano, categoria_curso) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosVendaPorCategorias/',
		data: { mes: mes, ano: ano, categoria: categoria_curso }}).done(
			function html(html) {
				var data = jQuery.parseJSON(html);
				var tabela = '';
				jQuery.each(data, function(i, item) {
					tabela += '<tr><td>' + item.numero + '</td><td class="center">' + item.cliente.nome + '</td><td class="center">' + item.cursos + '</td><td class="center">R$ ' + item.valor_total + '</td></tr>';
				});
				jQuery('#tabela_vendas_por_categorias').html(tabela);
			}
		);
}

function carregaDadosVendaCupons(categoria, de, ate) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosVendaCupons/',
		data: { data1: de, data2: ate }}).done(
			function html(html) {
				var data = jQuery.parseJSON(html);
				var tabela = '';
				jQuery('#cupons_total_pedidos').html(data.total_vendas);
				jQuery('#cupons_porcentagem_pedidos').html(data.porcentagem + '%');
				jQuery('#cupons_total_descontos').html(data.total_cupons);
				jQuery.each(data.mais_usados, function(i, item) {
					tabela += item.nome + '<br />';
				});
				jQuery('#cupons_mais_populares').html(tabela);
			}
		);
}

function carregaDadosCertificados(categoria, curso, de, ate) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosCertificados/',
		data: { curso_id: curso, data1: de, data2: ate }}).done(
			function html(html) {
				jQuery('#certificado_quantidade').html(html);
				var data = jQuery.parseJSON(html);
				var tabela = '';
				jQuery('#certificado_quantidade').html(data.total_certificados);
				jQuery.each(data.certificados, function(i, item) {
					var data = item.data_emissao.split(/[-]/);
					tabela += '<tr><td>' + item.id + '</td><td class="center">' + item.aluno.nome + '</td><td class="center">' + item.curso.curso + '</td><td class="center">' + item.aluno.email + '</td><td class="center">' + data[2] + '/' + data[1] + '/' + data[0] + '</td></tr>';
				});
				jQuery('#certificado_total_mes').html(data.mes_certificados);
				jQuery('#tabela_certificados').html(tabela);
			}
		);
}

function carregaDadosAssinatura(categoria, tipo_assinatura, ano, mes) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/vendas/carregaDadosAssinatura/',
		data: { tipo_assinatura: tipo_assinatura, ano: ano, mes:mes }}).done(
			function html(html) {
				if (tipo_assinatura == 1) {
					jQuery('#tabela_assinaturas_ativas').html(html);
				} else {
					jQuery('#tabela_assinaturas_expiradas').html(html);
				}
			}
		);
}
