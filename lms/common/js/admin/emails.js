
function carregaDadosEmail(id1, id2) {
	carregaDados(id1, 'id' + id1);
	carregaDados(id2, 'id' + id2);
}

function salvarDados(id1, id2) {
	jQuery.ajax({
		type: 	"POST",
		url:	'/lms/administrador-geral/emails/salvarDados/',
		data: 	{ id: id1, valor: jQuery('#id' + id1).val() }}).done(
			jQuery.ajax({
			type: 	"POST",
			url:	'/lms/administrador-geral/emails/salvarDados/',
			data: 	{ id: id2, valor: jQuery('#id' + id2).val() }}).done(
				jAlert('A&ccedil;&atilde;o realizada com sucesso!')
			)
		);
}

function salvaDadosOpcoesEmail() {
	var options = { 
        success:	atualizaImagem,
		type:      	'post',
		url:      	'/lms/administrador-geral/emails/salvarDadosEmail'
	};
	jQuery('#form_email_edicao').ajaxSubmit(options); 
	return false;
}

function atualizaImagem(retorno) {
	var data = jQuery.parseJSON(retorno);
	if (data.msg) {
		jAlert(data.msg);
	}
	if (data.sucesso) {
		if (data.imagem) {
			jQuery('#imagem_atual').attr('src', data.imagem);
		}
		jAlert(data.sucesso);
	}
}

function carregaDados(id, aonde) {
	jQuery.ajax({
		type: 	"POST",
		url:	'/lms/administrador-geral/emails/carregarDados/',
		data: 	{ id: id }}).done(
			function html(html) {
				jQuery('#' + aonde).val('');
				jQuery('#' + aonde).val(html);
			}
		);
}