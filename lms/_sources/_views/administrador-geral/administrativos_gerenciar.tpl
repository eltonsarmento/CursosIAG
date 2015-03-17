
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Administrativo</h5>
                <h1>Todos os Usuários</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <a href="/lms/administrador-geral/administrativos/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVO ADMINISTRATIVO</a>

                <table class="table table-bordered" id="dyntable">
                                
                	<thead>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </thead>
                    
                    <tbody>
                    	{foreach item=administrativo from=$administrativos}
                        <tr>
                        	<td>{$administrativo.nome}</td>
                            <td>{$administrativo.email}</td>
                            <td width="90">
                            	
                                <ul class="tooltipsample">
                                    <li><a href="/lms/administrador-geral/administrativos/editar/{$administrativo.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Usuário"><i class="iconfa-pencil"></i></a></li>
                                    <li><a  href="javascript:;" onclick="javascript:deletar({$administrativo.id})" class="btn btn-primary confirmbutton" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Usuário"><i class="iconfa-remove"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        {/foreach}
                        
                        
                    
                    </tbody>
                
                </table>

                <a href="/lms/administrador-geral/administrativos/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVO ADMINISTRATIVO</a>
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
{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function deletar(id) {
    jConfirm('Deseja excluir este administrativo?', 'Excluir Administrativo', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/administrador-geral/administrativos/apagar/'+id;
        {literal}
    }     
    });
}
</script>  
{/literal}