
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/coordenador/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>{if $categoria.id}Editar{else}Cadastrar{/if} Categorias</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="coordenador/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>GERENCIAMENTO DE CATEGORIAS</h5>
                <h1>{if $categoria.id}Editar{else}Cadastrar Nova{/if} Categoria</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
               <div class="widget">
                <h4 class="widgettitle">{if $categoria.id}Editar{else}Cadastrar{/if} Categorias</h4>
                <div class="widgetcontent">
                
                        <form class="stdform" method="post" action="">
                            <input type="hidden" value="1" name="editar"/>
                            <input type="hidden" value="{$categoria.id}" name="id"/>
                            
                            <div class="par control-group">
                                <label class="control-label" for="firstname">Nome da Categoria*</label>
                            <div class="controls"><input type="text" name="categoria" id="firstname" class="input-xxlarge" value="{$categoria.nome}" placeholder="Curso de Adobe Edge Animate"/></div>
                            </div>
                            
                            <p>
                                <label>Categoria Pai</label>
                                <span class="formwrapper">
                                    <select data-placeholder="Selecione a Categoria..." name="categoria_pai_id" class="chzn-select" style="width:350px;" tabindex="4">
                                        <option value="0"></option> 
                                        {foreach from=$categorias_pais item=categoria_pai}
                                        <option value="{$categoria_pai.id}" {if $categoria_pai.id == $categoria.pai} selected {/if}>{$categoria_pai.categoria}</option> 
                                        {/foreach}
                                    </select>
                                </span>
                            </p>
                                                            
                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $categoria.id}Editar{else}Cadastrar{/if} Categoria</button>
                            </p>
                       </form>

                       <!-- CONTEUDO CADASTRADO -->
   <!--                     <div class="span6">
                            <div class="widgetbox">
                                <h4 class="widgettitle">Categorias Cadastradas <a class="close">&times;</a> <a class="minimize">&#8211;</a></h4>
                                <div class="widgetcontent">
                               
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Nome da Categoria</th>
                                            <th class="center">Categoria Pai</th>
                                            <th>Ações</th>
                                        </thead>
                                        <tbody>
                                            {foreach from=$categorias item=categoria}
                                            <tr>
                                                <td >{$categoria.categoria}</td>
                                                <td class="center">{$categoria.categoria_pai}</td>
                                                <td width="90">
                                                    <ul class="tooltipsample">
                                                        <li><a href="/lms/coordenador/categorias/editar/{$categoria.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Categoria"><i class="iconfa-pencil"></i></a></li>
                                                        <li><a href="javascript:;" class="btn btn-primary confirmbutton" onclick="javascript:deletar({$categoria.id})"  data-placement="bottom" data-rel="tooltip" data-original-title="Remover Categoria"><i class="iconfa-remove"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            {/foreach}
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                       </div>-->
                       <!-- FIM CONTEUDO CADASTRADO -->

                </div><!--widgetcontent-->
            </div><!--widget-->

                    
              <div class="clearfix"></div>
                    
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