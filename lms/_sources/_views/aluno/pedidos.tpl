    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/aluno/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Aluno</a> <span class="separator"></span></li>
            <li>Pedidos</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="aluno/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-shopping-cart"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Pedidos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <table class="table table-bordered" id="dyntable">

                    <thead>

                        <th>#</th>
                        <th>Descrição do Pedido</th>
                        <th class="center">Realizado em</th>
                        <th class="center">Forma de Pagamento</th>
                        <th class="center">Link de Boleto</th>
                        <th class="center">Total do Pedido</th>
                        <th class="center">Status</th>
                        <th class="center"><i class="iconfa-truck"></i> Cód de Rastreamento</th>
                        <th>Observações</th>
                        <th width="90">Ações</th>

                    </thead>

                    <tbody>
                        {foreach item=pedido from=$pedidos}
                        <tr>
                            <td>{$pedido.numero}</td>
                            <td><a href="{$url_site}lms/aluno/pedidos/detalhe/{$pedido.id}">
                                {foreach item=curso from=$pedido.cursos}
                                    {$curso.curso}
                                {/foreach}
                                {$pedido.plano.plano}
                                {foreach item=certificado from=$pedido.certificados}
                                    {$certificado.curso}
                                {/foreach}
                                </a>
                            </td>
                            <td class="center"><strong>{$pedido.data_cadastro|date_format:"%d/%m/%Y"}</strong></td>
                            <td class="center">
                                {if $pedido.forma_pagamento == 1} 
                                    PagSeguro
                                {elseif $pedido.forma_pagamento == 2}
                                    Moip
                                {elseif $pedido.forma_pagamento == 3}
                                    PayPal
                                {elseif $pedido.forma_pagamento == 4}
                                    Depósito/Transferência
                                {elseif $pedido.forma_pagamento == 5}
                                    Transferência Internacional
                                {elseif $pedido.forma_pagamento == 6}
                                    Pagarme
				{else}
				    
                                {/if}

                            </td>
                            <td class="center">
                            {if $pedido.boleto_url != ''}
                                <a href="{$pedido.boleto_url}" target="_blank">
                                    <span class="label label-success"> Ver boleto</span></a>
                                    <br/> Codigo Barra: {$pedido.boleto_barcode}
                            {/if}</td>
                            <td class="center">R$ {$pedido.valor}</td>
                            <td class="center">
                                 {if $pedido.status == 0}
                                <span class="label label-info"><i class="iconfa-calendar"></i> Aguardando Pagamento</span>
                                {elseif $pedido.status == 1}
                                <span class="label label-success"><i class="iconfa-ok"></i> Pago</span>
                                {elseif $pedido.status == 2}
                                <span class="label label-important"><i class="iconfa-remove"></i>Cancelado</span>
                                {/if}
                            </td>
                            <td class="center">
                                {if $pedido.codigo_rastreamento}
                                    {$pedido.codigo_rastreamento}
                                {else}
                                    Não Existe
                                {/if}
                            </td>
                            <td>{$pedido.observacoes}</td>
                            <td class="center">
                                <ul class="tooltipsample">
                                    <li><a href="#myModal" onclick="setarValores({$pedido.id});" data-toggle="modal" class="btn btn-warning"  data-placement="bottom" data-rel="tooltip" data-original-title="Enviar Comprovante de Pagamento"><i class="iconfa-upload-alt"></i></a></li>
                                    {if $pedido.status == 0}
                                    <li><a class="btn btn-danger"  data-placement="bottom" data-rel="tooltip" data-original-title="Cancelar Pedido" onclick="window.location.href='/lms/aluno/pedidos/cancelar/{$pedido.id}'"><i class="iconfa-remove"></i></a></li>
                                    {/if}
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
    
</div><!--mainwrapper-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Enviar Comprovante</h3>
    </div>
    <div class="modal-body">
        <form action="" id="form_comprovante_edicao" onsubmit="return false;">
            <div id="retorno_comprovante"></div>
            <input type="hidden" value="" name="venda_id" id="venda_id"/>
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
                <input type="file" name="arquivo"/></span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                </div>
                </div>
            </div>


        <button class="btn btn-primary" onclick="enviaFormulario();">Enviar</button>

        </form>

    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div><!--#myModal-->

{literal}
<script type="text/javascript" src="/lms/common/js/jquery.form.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});
function enviaFormulario() {
    var options = { 
        target:       '#retorno_comprovante',
        resetForm:  true,
        type:       'post',
        url:        '/lms/aluno/pedidos/comprovante'
    };
    jQuery('#form_comprovante_edicao').ajaxSubmit(options); 
    return false;
}

function setarValores(id) {
    jQuery('#venda_id').val(id);
    jQuery('#retorno_comprovante').html('');
}

</script>  
{/literal}