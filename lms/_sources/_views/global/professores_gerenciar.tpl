
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
                <h1>Todos os Professores</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <a href="/lms/{$categoria}/professores/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR PROFESSOR</a>

                <table class="table table-bordered"  id="dyntable">
                                
                	<thead>
                        <th>Professor</th>
                        <th>E-mail</th>
                        <th class="center">CIDADE</th>
						<th class="center">ESTADO</th>
						<th class="center">CPF</th>
						<th class="center">Status</th>
                        <th>Ações</th>
                    </thead>
                    
                    <tbody>
                    	{foreach item=professor from=$professores}
                        <tr>
                        	<td>{$professor.nome}</td>
                            <td>{$professor.email}</td>
							<td class="center">{$professor.cidade}</td>
							<td class="center">{$professor.estado}</td>
                            <td class="center">{$professor.cpf}</td>
							<td class="center">
                                {if $professor.ativo == 1}
                                    <span class="label label-success"><i class="iconfa-ok"></i> Ativo</span>
                                {else}
                                    <span class="label label-important"><i class="iconfa-remove"></i> Inativo</span>
                                {/if}
                            </td>
                            <td width="90">
                            	
                                <ul class="tooltipsample">
                                    <li><a href="/lms/{$categoria}/professores/editar/{$professor.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Professor"><i class="iconfa-pencil"></i></a></li>
                                    {if $professor.temCurso == false}
                                    <li><a  href="javascript:;" onclick="javascript:deletar({$professor.id})" class="btn btn-primary confirmbutton" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Professor"><i class="iconfa-remove"></i></a></li>
                                    {/if}
                                </ul>
                            </td>
                        </tr>
                        {/foreach}
                        
                        
                    
                    </tbody>
                
                </table>

                <a href="/lms/{$categoria}/professores/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR PROFESSOR</a>
                
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