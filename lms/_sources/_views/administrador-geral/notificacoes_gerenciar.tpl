    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>

        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-exclamation"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Notificações</h5>
                <h1>Todas as Notificações</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <table class="table table-bordered" id="dyntable">
                                
                	<thead>
                    	
                        <th>Título</th>
                        <th class="center">Destinatário</th>
                        <th class="center">Curso</th>
                        <th>Ações</th>
                    
                    </thead>
                                    
                    <tbody>
                        {foreach item=notificacao key=k from=$notificacoes}
                            <input type="hidden" value="{$notificacao.titulo}" id="titulo_{$k}"/>
                            <input type="hidden" value="{$notificacao.conteudo}" id="conteudo_{$k}"/>
                            <tr>
                            	<td><a href="#myModal" data-toggle="modal" onclick="setarValores({$k})">{$notificacao.titulo}</a></td>
                                <td class="center">{$notificacao.destinatario}</td>
                                <td class="center">
                                    {foreach item=curso from=$notificacao.cursos}
                                        {$curso} <br/>
                                    {/foreach}
                                </td>
                                <td width="135">
                                	
                                    <ul class="tooltipsample">
                                        <li><a href="#myModal" onclick="setarValores({$k})" data-toggle="modal" class="btn btn-primary" data-placement="bottom" data-rel="tooltip" data-original-title="Visualizar Notificação"><i class="iconfa-search"></i></a></li>
                                        <li><a href="/lms/administrador-geral/notificacoesadmin/editar/{$notificacao.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Notificação"><i class="iconfa-pencil"></i></a></li>
                                        <li><a class="btn btn-danger confirmbutton" onclick="deletar({$notificacao.id});" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Notificação"><i class="iconfa-remove"></i></a></li>
                                    </ul>

                                </td>
                            
                            </tr>
                        {/foreach}
                                    
                    </tbody>
                            
                </table>
                
            </div>
        </div>
        
    </div>
  
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h3 id="myModalLabel">Visualizar Notificação</h3>
        </div>
        <div class="modal-body">

            <h4 id="modal_titulo"></h4>

            <div id="modal_conteudo"></div>
        </div>

        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>
    </div><!--#myModal-->

{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function setarValores(k) {
    jQuery("#modal_titulo").html(jQuery("#titulo_"+k).val());
    jQuery("#modal_conteudo").html(jQuery("#conteudo_"+k).val());
}

function deletar(id) {
    jConfirm('Deseja excluir esta notificação?', 'Excluir notificação', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/administrador-geral/notificacoesadmin/apagar/'+id;
        {literal}
    }     
    });
}
</script>
{/literal}