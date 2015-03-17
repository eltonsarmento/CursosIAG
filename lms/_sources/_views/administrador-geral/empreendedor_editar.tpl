  
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
                <h1>{if $empreendedor.id}Editar{else}Cadastrar{/if}</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
        
            <div class="maincontentinner">
                
                <div class="widget">
                    <h4 class="widgettitle">{if $empreendedor.id}Editar{else}Cadastrar{/if}</h4>
                    <div class="widgetcontent">
                        <form class="stdform" method="post" action="">
                            <input type="hidden" name="editar" value="1">
                            <input type="hidden" name="id" value="{$empreendedor.id}">
                            <div class="par control-group">
                                
                                <label class="control-label" for="firstname">Título:*</label>
                                <div class="controls"><input type="text" name="titulo" id="firstname" value="{$empreendedor.titulo}" class="input-xxlarge"/></div>
                                                           
                            </div>
                                                         
                            <style>
                            #mce_0_tbl {
                                width: auto !important;
                            }                            
                            </style>
                                                          
                            <div class="par control-group">
                                
                                <label class="control-label" for="firstname">Descrição:*</label>
                                <div class="controls"><textarea name="descricao" class="tinymce"/>{$empreendedor.descricao}</textarea></div>
                                                           
                            </div>
                                                       
                            <div class="par control-group">
                                
                                <label>Tipo de Vídeo:*</label>
                                <span class="formwrapper">
                                    <div class="radio" id="uniform-undefined"><span><input type="radio" name="tipo_video" style="opacity: 0;" value="1" {if $empreendedor.tipo_video eq 1}checked="checked"{else}{/if} ></span></div> Youtube
                                    <div class="radio" id="uniform-undefined"><span><input type="radio" name="tipo_video" style="opacity: 0;" value="2" {if $empreendedor.tipo_video eq 2}checked="checked"{else}{/if}></span></div> Vimeo
                                </span>
                                                           
                            </div>
                                                        
                            <div class="par control-group">
                                
                                <label>Link do Vídeo:*</label>
                                <div class="input-append"><input type="text" name="link_video" value="{$empreendedor.link_video}" id="firstname" class="input-xxlarge"/><span class="add-on"><i class="iconfa-play"></i></span></div>
                                                           
                            </div>
                                                        
                            <div class="par control-group">
                                
                                <label class="control-label" for="firstname">Fonte:</label>
                                <div class="controls"><input type="text" name="fonte" id="firstname" value="{$empreendedor.fonte}" class="input-xxlarge"/></div>
                                                           
                            </div>
                                                         
                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $empreendedor.id}Editar{else}Cadastrar{/if}</button>
                            </p>
                       </form>
                       
                    </div><!--widgetcontent-->
                </div><!--widget-->
                
               
                
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
        window.location.href='{$url_site}lms/{$modulo}/categorias/apagar/'+id;
        {literal}
    }     
    });
}
</script>
{/literal}