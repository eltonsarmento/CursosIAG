<script type="text/javascript" src="/lms/common/js/jquery.form.min.js"></script>
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Professores</h5>
                <h1>Gerenciar Pagamentos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <!-- FILTRAR -->
                <form action="" method="post">
                    <select name="ano">
                        <option selected>Selecione o Ano</option>
                        {php}
                        for($i = 2014; $i <= date('Y'); $i++) {
                            echo '<option>'.$i.'</option>';
                        }
                        {/php}
                    </select>

                    <select name="mes">
                        {php}
                        for($i = 1; $i <= 12; $i++) {
                            echo '<option>'.(($i < 10) ? '0' : '').$i.'</option>';
                        }
                        {/php}
                    </select>

                    <input type="submit" value="Filtrar" class="btn btn-primary">
                </form>
                <!-- FIM FILTRAR -->

                <table class="table table-bordered" id="dyntable">
                                
                	<thead>
                        <th>Professor</th>
                        <th class="center">Mês Faturado</th>
                        <th class="center">Data do Pagamento</th>
                        <th class="center">Valor</th>
                        <th class="center">Status</th>
                        <th>Observações</th>
                        <th width="140">Ações</th>
                    </thead>
                    
                    <tbody>
                    	{foreach item=pagamento key=k from=$pagamentos}
                        <tr>
                            <input type="hidden" id="id_{$pagamento.id}" value="{$pagamento.id}"/>
                            <input type="hidden" id="comprovante_{$pagamento.id}" value="{$pagamento.comprovante}"/>
                            <input type="hidden" id="observacoes_{$pagamento.id}" value="{$pagamento.observacoes}"/>
                            <input type="hidden" id="professor_nome_{$pagamento.id}" value="{$pagamento.nome}"/>
                        	<td>{$pagamento.nome}</td>
                            <td class="center">{$pagamento.mes_faturado|date_format:"%b de %Y"}</td>
							<td class="center">{$pagamento.data_pagamento|date_format:"%d/%m/%Y"}</td>
							<td class="center"><strong>R$ {$pagamento.valor|number_format:"2"}</strong></td>
                            <td class="center" id="td_comprovante_{$pagamento.id}">
                                {if $pagamento.status == 1}
                                    <span class="label label-success"><i class="iconfa-ok"></i>Pago</span>
                                {elseif $pagamento.status == 0}
                                    <span class="label label-warning"><i class="iconfa-warning-sign"></i>Aguardando</span>
                                {/if}
                            </td>
						   <td id="observacao_{$pagamento.id}">{$pagamento.observacoes}</td>
						   <td>
                                <ul class="tooltipsample">
                                    <li><a href="#myModalEdit" onclick="setarValores({$pagamento.id});" class="btn" data-toggle="modal" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Pagamento"><i class="iconfa-edit"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                
                </table>
                
                <div class="footer">
                    <div class="footer-left">
                        <span>&copy; {date('Y')}. Cursos IAG.</span>
                    </div>
                    <div class="footer-right">
                        <span>Uma plataforma: <a href="http://www.iteacher.com.br/" title="iTeacher" target="_blank"><img src="http://www.iteacher.com.br/market/common/siteTemp/imgs/logo-iteacher.png" style="vertical-align:top;" width="70" class="img-responsive"></a></span>
                    </div>
                </div><!--footer-->
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
	
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModalEdit">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Editar Pagamento <span id="professor_nome"></span></h3>
    </div>
    <div class="modal-body">
        
        <form action="/lms/{$categoria}/professores/atualizaPagamento" onsubmit="return false;" method="post" enctype="multipart/form-data" id="form_pagamento_edicao">
            <input type="hidden" value="" name="id" id="modal_id" />
        <div class="par margintop10">
          <label>Anexo</label>
          <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="input-append">
        <div class="uneditable-input span3">
            <i class="iconfa-file fileupload-exists"></i>
            <span class="fileupload-preview"></span>
        </div>
        <span class="btn btn-file"><span class="fileupload-new">Selecione o arquivo</span>
        <span class="fileupload-exists">Trocar</span>
        <input type="file" name="arquivo" id="modal_comprovante" /></span>
        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
        </div>
          </div>
      </div>
        
            <p>
                <label>Observações</label>
                <span class="field"><textarea cols="80" name="observacoes" id="modal_observacoes" rows="5" class="span5"></textarea></span> 
            </p>
        

        <button class="btn btn-primary" id="BotaoForm" onclick="javascript:enviaFormulario(this);">Editar</button>

        </form>


    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div><!--#myModal-->
	
{literal}
<script type="text/javascript">
function enviaFormulario(form) {
    jQuery('#BotaoForm').html('Aguarde...');
    jQuery('#BotaoForm').attr('disabled', 'disabled');
    
	var options = { 
        //target:		'#vazio',
        success:	atualizaListagem,
		//clearForm: 	true,
		resetForm: 	true,
		type:      	'post',
		url:      	'/lms/{/literal}{$categoria}{literal}/professores/atualizaPagamento'
	};
	jQuery('#form_pagamento_edicao').ajaxSubmit(options); 
	return false;
}
function atualizaListagem(retorno) {
	var data = jQuery.parseJSON(retorno);
	if (data.msg) {
		jAlert(data.msg);
	}
	if (data.sucesso) {
		jQuery('#observacao_' + data.id).html(data.observacao);
		jQuery('#observacoes_' + data.id).val(data.observacao);
		jQuery('#myModalEdit').modal('hide');
		jAlert(data.sucesso);
	}
    if (data.comprovante) {
        jQuery('#td_comprovante_' + data.id).html('<span class="label label-success"><i class="iconfa-ok"></i>Pago</span>');
    }
}
function setarValores(pagamento) {
    jQuery('#BotaoForm').html('Editar');
    jQuery('#BotaoForm').attr('disabled', false);

	jQuery("#modal_id").val(jQuery("#id_"+pagamento).val());
	jQuery("#modal_comprovante").html(jQuery("#comprovante_"+pagamento).val());
    jQuery("#modal_observacoes").html(jQuery("#observacoes_"+pagamento).val());
    
    jQuery("#professor_nome").html("("+jQuery("#professor_nome_"+pagamento).val()+")");
}

jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function deletar(id) {
    jConfirm('Deseja excluir este professor?', 'Excluir Professor', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/{$categoria}/professores/apagar/'+id;
        {literal}
    }     
    });
}
</script>  
{/literal}