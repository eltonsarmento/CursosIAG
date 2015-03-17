    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.html"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>

        </ul>
        
        <div class="pageheader">
            <!-- busca topo -->
              {include file="administrador-geral/busca_topo.tpl"}
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Canto do Empreendedor</h5>
                <h1>Listar</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <a href="/lms/administrador-geral/empreendedor/novo" class="btn btn-success">Cadastrar</a><br/><br/>
               
                <table class="table table-bordered" id="dyntable">
                                
                    <thead>

                        <th>Título</th>
                        <th class="center">Data de Publicação</th>
                        <th>Ações</th>

                    </thead>

                    <tbody>
                        {foreach from=$empreendedor item=cantos}
                        <tr>
                            <td>{$cantos.titulo}</td>
                            <td class="center"><strong>{$cantos.data_cadastro|date_format: "%d/%m/%Y"}</strong></td>
                            <td width="90">

                                <ul class="tooltipsample">
                                    <li><a href="/lms/administrador-geral/empreendedor/editar/{$cantos.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar"><i class="iconfa-pencil"></i></a></li>
                                    <li><a onclick="deletar({$cantos.id})" class="btn btn-danger confirmbutton" data-placement="bottom" data-rel="tooltip" data-original-title="Remover"><i class="iconfa-remove"></i></a></li>
                                </ul>

                            </td>

                        </tr>
                        {/foreach}

                    </tbody>
                                
                </table>
                
              <br/>
              
              <a href="/lms/administrador-geral/empreendedor/novo" class="btn btn-success">Cadastrar</a>
     
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->


{literal}
    <script type="text/javascript">
    jQuery(document).ready(function(){
        {/literal}
        {if $msg_alert} jAlert('{$msg_alert}'); {/if}
        {literal}
    });



    function deletar(id) {
        jConfirm('Deseja excluir este registro?', 'Deletar registro', function(r) {
             if (r) {
            {/literal}
            window.location.href='{$url_site}lms/administrador-geral/empreendedor/apagar/'+id;
            {literal}
        }     
        });
    }
    </script>
{/literal}