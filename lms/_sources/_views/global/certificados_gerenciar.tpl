 
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-certificate"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Certificados</h5>
                <h1>Relatório de Certificados</h1>
            </div>
        </div>
        
        <div class="maincontent">
            <div class="maincontentinner">

                <a href="#myModalrelatorio" class="btn btn-success btn-large" data-toggle="modal"><i class="iconfa-list"></i> Gerar Relatório</a><br /><br />

                <table class="table table-bordered" id="dyntable">

                    <thead>
                        
                        <th>#</th>
                        <th>Nome do Aluno</th>
                        <th>Nome do Curso</th>
                        <th class="center">Emitido em</th>
                        <th class="center">Tipo de Certificado</th>
                        <th class="center">Status do Certificado</th>
                        <th class="center"><i class="iconfa-truck"></i> Código de Rastreamento</th>
                        <th width="86">Ações</th>

                    </thead>

                    <tbody>
                        {foreach item=certificado key=k from=$certificados}
                        <tr>
                            <input type="hidden" value="{$certificado.id}" id="certificado_id_{$k}" />
                            <input type="hidden" value="{$certificado.codigo_rastreamento}" id="codigo_rastreamento_{$k}" />
                            <input type="hidden" value="{$certificado.status}" id="status_{$k}" />
                            <td>{$certificado.id}</td>
                            <td>{$certificado.aluno.nome}</td>
                            <td>{$certificado.curso.curso}</td>
                            <td class="center">
                                {if $certificado.data_emissao != ''}
                                    <strong>{$certificado.data_emissao|date_format:"%d/%m/%Y"}</strong>
                                {else}
                                    <strong>Pendente</strong>
                                {/if}
                            </td>
                            <td class="center">
                                {if $certificado.tipo_certificado == 1}
                                    Digital
                                {else}
                                    Impresso
                                {/if}
                            </td>
                            <td class="center" id="td_status_{$k}">
                                {if $certificado.status == 1}
                                <span class="label label-success">
                                    <i class="iconfa-ok"></i> Entregue
                                </span>
                                {elseif $certificado.status == 2}
                                <span class="label label-info">
                                    <i class="iconfa-info-sign"></i> Enviado
                                </span>
                                {elseif $certificado.status == 3}
                                <span class="label label-warning">
                                    <i class="iconfa-warning-sign"></i> Aguardando pagamento
                                </span>
                                {elseif $certificado.status == 4}
                                <span class="label label-important">
                                    <i class="iconfa-remove"></i> Cancelado por falta de pagamento
                                </span>
                                {elseif $certificado.status == 5}
                                <span class="label label-info">
                                    <i class="iconfa-info-sign"></i> Enviado para impressão
                                </span>
                                {/if}

                            </td>
                            <td class="center" id="td_rastreamento_{$k}">
                                {if $certificado.codigo_rastreamento}
                                    {$certificado.codigo_rastreamento}
                                {else}
                                    Não Existe
                                {/if}
                            </td>
                            <td>
                                <ul class="tooltipsample">
                                    <li>    
                                        <a href="#modalStatus" onclick="setarValoresStatus({$k})" data-toggle="modal" class="btn btn-info"  data-placement="bottom" data-rel="tooltip" data-original-title="Atualizar status do pedido"><i class="iconfa-repeat"></i></a>
                                    
                                        <a href="#modalRastreamento" onclick="setarValoresRastreamento({$k})" data-toggle="modal" class="btn btn-primary"  data-placement="bottom" data-rel="tooltip" data-original-title="Enviar código de rastreamento"><i class="iconfa-truck"></i></a>
                                    </li>
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

    <!-- MODAL STATUS -->
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="modalStatus">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h3 id="myModalLabel">Alterar Status do Pedido</h3>
        </div>
        <div class="modal-body">
            <div id="resposta_trocar_status"></div>
            <form action="" id="formStatus" onsubmit="return false;">

                <input type="hidden" value="" name="id" id="modal_status_id"/>
                <input type="hidden" value="" name="posicao" id="posicao_status"/>

                <p class="margintop10">
                    <select class="uniformselect" name="status" id="modal_status">
                        <option value="1">Entregue</option>
                        <option value="2">Enviado</option>
                        <option value="3">Aguardando Liberação</option>
                        <option value="4">Cancelado</option>
                    </select>
                </p>

                <button class="btn btn-primary margintop10" onclick="mudarStatus();">Alterar Status</button>

            </form>

        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>

    </div>

    <!-- MODAL TRANSPORTE -->
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="modalRastreamento">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h3 id="myModalLabel">Código de Rastreamento</h3>
        </div>
        <div class="modal-body">
            <div id="resposta_trocar_rastreamento"></div>
            <form action="" id="formRastreamento" onsubmit="return false;">
                <input type="hidden" value="" name="id" id="modal_rastreamento_id"/>
                <input type="hidden" value="" name="posicao" id="posicao_rastreamento"/>
                <p class="margintop10">
                    <input type="text" name="rastreamento" id="modal_rastreamento" class="input-xlarge">
                </p>

                <button class="btn btn-primary" onclick="mudarRastreamento();">Enviar Código</button>

            </form>

        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>
    </div>

    <!-- MODAL RELATORIO -->
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModalrelatorio">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h3 id="myModalLabel">Filtro de Relatório</h3>
        </div>
        <div class="modal-body">
            <div id="resultado_relatorio"></div>
            <h4>Opções de Exportação</h4>
            <form action="" id="formRelatorio" onsubmit="return false;">

            
            <p class="margintop10">
                <span class="formwrapper">
                    <input type="checkbox" name="tipo_relatorio[]" value="pdf" /> PDF
                    <input type="checkbox" name="tipo_relatorio[]" value="xls" /> XLS
                    <input type="checkbox" name="tipo_relatorio[]" value="jpg" /> JPG
                </span>
            </p>


            <h4 class="margintop10">Filtro de Exportação</h4>

                <p class="margintop10">
                   
                   <label>Curso:</label>
                    <span class="formwrapper">
                       <select data-placeholder="Selecione o curso..." name="curso" style="width:350px" class="chzn-select" tabindex="2">
                        <option value="0">Nenhum Curso</option> 
                        {foreach item=curso from=$cursos}
                        <option value="{$curso.id}">{$curso.curso}</option> 
                        {/foreach}
                      </select>
                    </span>
                 </p>

                 <p class="margintop10">
                   
                   <label>Aluno:</label>
                    <span class="formwrapper">
                       <select data-placeholder="Selecione o Aluno..." name="aluno" style="width:350px" class="chzn-select" tabindex="2">
                        <option value="0">Nenhum aluno</option> 
                        {foreach item=aluno from=$alunos}
                        <option value="{$aluno.id}">{$aluno.nome}</option> 
                        {/foreach}
                      </select>
                    </span>
                 </p>


            <h4 class="margintop10">Período:</h4>

             <p class="margintop10">
                    <span class="formwrapper">

                        <span class="field"><input type="text" name="periodo1" class="input-small" placeholder="06/05/2013" /></span> a <span class="field"><input type="text" name="periodo2" class="input-small" placeholder="06/06/2013" /></span> 

                    </span>
                </p>

            <button class="btn btn-primary" onclick="gerarRelatorio();">Gerar Relatório</button>

            </form>

        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>
    </div>
    <!-- FIM MODAIS -->

{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function mudarStatus() {
    {/literal}
    jQuery.post('/lms/{$categoria}/certificados/salvarStatus',  jQuery('#formStatus').serialize(), function html(html) {ldelim} jQuery('#resposta_trocar_status').html(html); {rdelim});
    {literal}
}

function mudarRastreamento() {
    {/literal}
    jQuery.post('/lms/{$categoria}/certificados/salvarRastreamento',  jQuery('#formRastreamento').serialize(), function html(html) {ldelim} jQuery('#resposta_trocar_rastreamento').html(html); {rdelim});
    {literal}
}

function setarValoresStatus(k) {
    jQuery("#resposta_trocar_status").html("");    
    jQuery("#posicao_status").val(k);
    jQuery("#modal_status_id").val(jQuery("#certificado_id_"+k).val());
    jQuery("#modal_status").val(jQuery("#status_"+k).val());
}

function setarValoresRastreamento(k) {
    jQuery("#resposta_trocar_rastreamento").html("");    
    jQuery("#posicao_rastreamento").val(k);
    jQuery("#modal_rastreamento_id").val(jQuery("#certificado_id_"+k).val());
    jQuery("#modal_rastreamento").val(jQuery("#codigo_rastreamento_"+k).val());
}

function gerarRelatorio() {
    {/literal}
    jQuery.post('/lms/{$categoria}/certificados/gerarRelatorio',  jQuery('#formRelatorio').serialize(), function html(html) {ldelim} jQuery('#resultado_relatorio').html(html); {rdelim});
    {literal}   
}

</script>
{/literal}
