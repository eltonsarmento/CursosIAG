    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel Administrativo</a> <span class="separator"></span></li>
            <li>Pedidos/Vendas</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-shopping-cart"></span></div>
            <div class="pagetitle">
                <h5>Painel Administrativo</h5>
                <h1>Pedidos/Vendas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <table class="table table-bordered">

                    <thead>

                        <th>#</th>
                        <th>Curso</th>
                        <th>Cliente</th>
                        <th class="center">Situação</th>
                        <th class="center">Comprovante</th>
                        <!-- <th class="center">Forma de Pgto</th> -->
                        <!-- <th class="center">Formato</th> -->
                        <th class="center">Data</th>
                        <!-- <th class="center">Qtd</th> -->
                        <th class="center">Total do Pedido</th>
                        <th class="center">Total Líquido</th>
                        <th class="center">Código de Rastreamento</th>
                        <th>Observações</th>
                        <th width="125">Ações</th>

                    </thead>

                    <tbody>
                        {foreach item=venda key=k from=$vendas} 
                        
                        <tr>
                            <input type="hidden" value="{$venda.id}" id="venda_id_{$k}"/>
                            <input type="hidden" value="{$venda.observacoes}" class="observacoes_{$venda.id}" id="observacoes_{$k}"/>
                            <input type="hidden" value="{$venda.codigo_rastreamento}" class="codigo_rastreamento_{$venda.id}" id="codigo_rastreamento_{$k}"/>
                            <input type="hidden" value="{$venda.status}" class="status_{$venda.id}" id="status_{$k}"/>
                            <input type="hidden" value="{$venda.aluno.nome}" id="nome_{$k}"/>
                            <input type="hidden" value="{$venda.aluno.email}" id="email_{$k}"/>
                            <input type="hidden" value="{$venda.aluno.id}" id="aluno_{$k}"/>
                            <td>
                                <a href="/lms/{$categoria}/vendas/detalhes/{$venda.id}">{$venda.numero}</a>
                            </td>
                            <td>
                            {foreach item=curso from=$venda.cursos}
                                {$curso.curso} <br/>
                            {/foreach}
                            {foreach item=plano from=$venda.planos}
                                {$plano.plano} <br/>
                            {/foreach}
                            {foreach item=certificado from=$venda.certificados}
                                {$certificado.curso} <br/>
                            {/foreach}
                            </td>
                            <td>{$venda.aluno.nome}</td>
                            <td class="center td_status_{$venda.id}">
                                {if $venda.status == 0}
                                <span class="label label-info"><i class="iconfa-calendar"></i> Aguardando Pagamento</span>
                                {elseif $venda.status == 1}
                                <span class="label label-success"><i class="iconfa-ok"></i> Pago</span>
                                {elseif $venda.status == 2}
                                <span class="label label-important"><i class="iconfa-remove"></i>Cancelado</span>
                                {/if}

                            </td>
                            <td class="center">
                                {if $venda.comprovante}
                                    <ul class="tooltipsample">
                                        <li><a href="/lms/{$categoria}/vendas/baixarComprovante/{$venda.id}" target="_blank" class="btn btn-warning"><i class="iconfa-upload-alt"></i></a></li>
                                    </ul>
                                {/if}
                            </td>
                          
                            <td class="center">{$venda.data_cadastro|date_format:"%d/%m/%Y"}</td>
                            <td class="center">R$ {$venda.valor_total_bruto}</td>
                            <td class="center">R$ {$venda.valor_total}</td>
                            <td class="center td_rastreamento_{$venda.id}">{$venda.codigo_rastreamento}</td>
                            <td class="td_observacoes_{$venda.id}">{$venda.observacoes}</td>
                            <td>
                            	<ul class="tooltipsample">
                                    <li>
                                        <a href="#myModalHistorico" onclick="setarValoresHistorico({$k});" class="btn btn-primary" data-toggle="modal" data-placement="bottom" data-rel="tooltip" data-original-title="Exibir Histórico"><i class="iconfa-search"></i></a>
                                        <a href="#myModalObs" data-toggle="modal" class="btn btn-default" onclick="setarValoresObservacao({$k});"  data-placement="bottom" data-rel="tooltip" data-original-title="Editar Obeservações"><i class="iconfa-pencil"></i></a>
                                        {if $venda.status == 0}
                                        <a href="#myModal" data-toggle="modal" class="btn btn-info bota_venda_{$venda.id}" onclick="setarValoresPagamento({$k});" data-placement="bottom" data-rel="tooltip" data-original-title="Atualizar status do pedido"><i class="iconfa-repeat"></i></a> 
                                        {/if}
                                        <a href="#myModalcodigo" data-toggle="modal" class="btn btn-primary" onclick="setarValoresRastreamento({$k});" data-placement="bottom" data-rel="tooltip" data-original-title="Enviar código de rastreamento"><i class="iconfa-truck"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        {/foreach}

                    </tbody>    

                </table>

                <!-- PAGINAÇÂO -->
                {$paginacao}
                <!--FIM PAGINAÇÃO -->
                
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

<!-- MODAL STATUS -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Alterar Status do Pedido</h3>
    </div>
    <div class="modal-body">
        
        <form action="" id="formStatus" onsubmit="return false;">
            <div id="resposta_trocar_pagamento"></div>
            <input type="hidden" name="editar" value="1"/>
            <input type="hidden" name="venda_id" value="" id="venda_id_modal_pagamento"/>
            <p class="margintop10">
                <select class="uniformselect" name="status" id="status_modal">
                    <option value="0">Aguardando Liberação</option>
                    <option value="1">Pago</option>
                    <option value="2">Cancelado</option>
                </select>
            </p>

            <button class="btn btn-primary margintop10" onclick="alterarPagamento();">Alterar Status</button>

        </form>

    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>

<!-- MODAL CODIGO RASTREAMENTO -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModalcodigo">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Código de Rastreamento</h3>
    </div>
    <div class="modal-body">
        
        <form action="" id="formRastreamento" onsubmit="return false;">
            <div id="resposta_trocar_rastreamento"></div>
            <input type="hidden" name="editar" value="1"/>
            <input type="hidden" value="" name="venda_id" id="venda_id_modal_rastreamento"/>
            <p class="margintop10">
                <input type="text" name="codigo_rastreamento" class="input-xlarge" id="codigo_rastreamento_modal">
            </p>

            <button class="btn btn-primary" onclick="alterarRastreamento();">Enviar Código</button>

        </form>

    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>

<!-- MODAL OBSERVACAO -->
<div aria-hidden="false" aria-labelledby="myModalObs" role="dialog" tabindex="-1" class="modal hide fade in" id="myModalObs">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Editar Observações</h3>
    </div>
    <div class="modal-body">
        
        <form action="" id="formObservacao" onsubmit="return false;">
            <div id="resposta_trocar_observacao"></div>
            <input type="hidden" name="editar" value="1"/>
            <input type="hidden" value="" name="venda_id" id="venda_id_modal_observacao"/>
            <p class="margintop10">
                <textarea class="span5" cols="30" rows="5" name="observacoes" id="observacao_modal"></textarea>
            </p>

            <button class="btn btn-primary margintop10" onclick="alterarObservacao();">Editar Observações</button>

        </form>

    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>

<!-- MODAL HISTORICO -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModalHistorico">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Dados Vendas</h3>
    </div>
    <div class="modal-body">

        <h6>Nome: <span id="modal_nome"></span></h6>
        <h6>E-mail: <span id="modal_email"></span></h6>
        
        <hr />

        <h4>Histórico</h4>

        <br />
        
        <div id="modal_tabela">
            
        </div>
                  
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>

{literal}
<script type="text/javascript">
//Historico
function setarValoresHistorico(k) {
    jQuery('#modal_nome').html(jQuery('#nome_'+k).val());
    jQuery('#modal_email').html(jQuery('#email_'+k).val());

    jQuery.post('{/literal}{$url_site}{literal}/lms/{/literal}{$categoria}{literal}/vendas/buscarPorAluno', {aluno_id: jQuery('#aluno_'+k).val()}, function html(html) { jQuery('#modal_tabela').html(html)});
}

//Pagamento
function setarValoresPagamento(k) {
    jQuery('#status_modal').val(jQuery("#status_"+k).val());
    jQuery('#venda_id_modal_pagamento').val(jQuery("#venda_id_"+k).val());
}

function alterarPagamento() {
    jQuery('#resposta_trocar_pagamento').html('Processando...');
    {/literal}
    jQuery.post('/lms/{$categoria}/vendas/salvarPagamento',  jQuery('#formStatus').serialize(), function html(html) {ldelim} jQuery('#resposta_trocar_pagamento').html(html); {rdelim});
    {literal}   
}
//Rastreamento
function setarValoresRastreamento(k) {
    jQuery('#codigo_rastreamento_modal').val(jQuery("#codigo_rastreamento_"+k).val());
    jQuery('#venda_id_modal_rastreamento').val(jQuery("#venda_id_"+k).val());
}

function alterarRastreamento() {
    {/literal}
    jQuery.post('/lms/{$categoria}/vendas/salvarRastreamento',  jQuery('#formRastreamento').serialize(), function html(html) {ldelim} jQuery('#resposta_trocar_rastreamento').html(html); {rdelim});
    {literal}
}

//Observacao
function setarValoresObservacao(k) {
    jQuery('#observacao_modal').val(jQuery("#observacoes_"+k).val());
    jQuery('#venda_id_modal_observacao').val(jQuery("#venda_id_"+k).val());
}

function alterarObservacao() {
    {/literal}
    jQuery.post('/lms/{$categoria}/vendas/salvarObservacoes',  jQuery('#formObservacao').serialize(), function html(html) {ldelim} jQuery('#resposta_trocar_observacao').html(html); {rdelim});
    {literal}
}

</script>
{/literal}