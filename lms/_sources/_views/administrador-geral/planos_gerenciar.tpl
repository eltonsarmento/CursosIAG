    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>

        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-reorder"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Planos</h5>
                <h1>Todos os Planos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <table class="table table-bordered" id="dyntable">
                                
                	<thead>
                        <th>Nome do Plano</th>
                        <th class="center">Quantidade de Meses</th>
                        <th class="center">Valor do plano</th>
                        <th class="center">Status</th>
                        <th>Ações</th>
                    
                    </thead>
                    
                    <tbody>
                    	
                        {foreach item=plano from=$planos }
                        <tr>
                        	<td>{$plano.plano}</td>
                            <td class="center">{$plano.meses} Mese(s)</td>
                            <td class="center">R$ {$plano.valor}</td>
                            <td class="center">
                                {if $plano.status == 1}
                                <span class="label label-success"><i class="iconfa-ok"></i> Ativo</span>
                                {else}
                                <span class="label label-important"><i class="iconfa-remove"></i> Inativo</span>
                                {/if}
                            </td>
                            <td width="90">
                            	
                                <ul class="tooltipsample">
                                    <li><a href="/lms/administrador-geral/planos/editar/{$plano.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Plano"><i class="iconfa-pencil"></i></a></li>
                                    <li><a class="btn btn-danger confirmbutton" onclick="javascript:deletar({$plano.id})" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Plano"><i class="iconfa-remove"></i></a></li>
                                </ul>

                            </td>
                        
                        </tr>
                        {/foreach}
                    
                    </tbody>
                
                </table>
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->

{literal}
<script type="text/javascript">

//Mensagem
{/literal}
{if $msg_alert} jAlert('{$msg_alert}'); {/if}
{literal}

//Delete
function deletar(id, curso_id) {
    jConfirm('Deseja deletar este plano?', 'Deletar Plano', function(r) {
        if (r) {
        {/literal}
        window.location.href='{$url_site}lms/administrador-geral/planos/apagar/'+id;
        {literal}
    }     
    });
}
</script>
{/literal}