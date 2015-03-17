function carregaDadosVendaPorDia(categoria, de, ate) {
	jQuery.ajax({
		type: "POST",
		url: '/lms/' + categoria + '/parceiros/carregaDadosVendaPorDia/',
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
		url: '/lms/' + categoria + '/parceiros/carregaDadosVendaPorMes/',
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
		url: '/lms/' + categoria + '/parceiros/carregaDadosVendaPorProdutos/',
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
		url: '/lms/' + categoria + '/parceiros/carregaDadosVendaMaisVendidos/',
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
		url: '/lms/' + categoria + '/parceiros/carregaDadosVendaTopConsumidores/',
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
		url: '/lms/' + categoria + '/parceiros/carregaDadosVendaPorCategorias/',
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
		url: '/lms/' + categoria + '/parceiros/carregaDadosVendaCupons/',
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
