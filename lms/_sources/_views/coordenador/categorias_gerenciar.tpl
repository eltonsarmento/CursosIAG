
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/coordenador/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Todas as Categorias</li>            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="coordenador/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-briefcase"></span></div>
            <div class="pagetitle">
                <h5>Gerenciamento de Categorias</h5>
                <h1>Todas as Categorias</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            	
                <a href="/lms/coordenador/categorias/nova" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVA CATEGORIA</a>
                
                <br /><br />
                <h4 class="widgettitle">Categorias</h4>
                <table class="table table-bordered responsive" id="dyntable">
                    <thead>
                        <tr>
                            <th class="head0">Nome da Categoria</th>
                            <th class="head1 center">Categoria Pai</th>
                            <th class="head0">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$categorias item=categoria}
                        <tr>
                            <td>{$categoria.categoria}</td>
                            <td class="center">{$categoria.categoria_pai}</td>
                            <td width="90">
                            
                            	<ul class="tooltipsample">
                                	<li><a href="/lms/coordenador/categorias/editar/{$categoria.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Categoria"><i class="iconfa-pencil"></i></a></li>
                                    <li><a href="javascript:;" class="btn btn-primary confirmbutton" onclick="javascript:deletar({$categoria.id})" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Categoria"><i class="iconfa-remove"></i></a></li>
                                </ul>

                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>
                
                <br />
                
                <a href="/lms/coordenador/categorias/nova" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVA CATEGORIA</a>
                
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
    jConfirm('Deseja excluir esta categoria?', 'Excluir Categoria', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/coordenador/categorias/apagar/'+id;
        {literal}
    }     
    });
}
</script>
{/literal}