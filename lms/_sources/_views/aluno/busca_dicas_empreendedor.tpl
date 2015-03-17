    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="{$url_site}lms/aluno/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Aluno</a> <span class="separator"></span></li>
            <li>Meus Cursos</li>
            
            
        </ul>
        
        <div class="pageheader">

            <form action="" method="post" class="right searchbar">
                <input type="hidden" name="busca" value="1">
                <select name="filtro" style="width:300px;">

                    <option value="" selected>Filtrar Por</option>
                    <option value="todos">Todos</option>
                    <option value="vistos">Vistos</option>
                    <option value="nao_vistos">Não Visto</option>
                </select>

                <button class="btn btn-primary">Filtrar</button>

            </form>

            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">

                <h5>Canto do Empreendedor</h5>
                <h1>Listar</h1>

            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">

            <div class="maincontentinner">
                
                <div class="row-fluid">

                    <div class="span8">
                        <h4 class="widgettitle">Mais Materiais</h4>
                        <div class="widgetcontent nopadding">
                            <ul class="commentlist">
                                {foreach from=$dicas item=dica}
                                <li {if $dica.visualizado eq 1}style="background:#f0f0f0;"{else}style="margin-left:0;"{/if} id="dicas_{$dica.id}" class="{if $dica.visualizado eq 1}view {else} not-view {/if}">
                                    <div class="comment-info" style="margin-left:0;">
                                        <h4><strong><a href="#myModal" onclick="abrirMensagem({$dica.id})" data-toggle="modal">{$dica.titulo}</a></strong></h4>
                                        <p>{$dica.descricao|html_entity_decode} </p>
                                    </div>
                                </li>
                                {/foreach}
                                
                            </ul>
                        </div>

                    </div><!--span8-->           
                </div>            
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
    
</div><!--mainwrapper-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
   
    <div class="modal-header">
       
        <h3 id="myModalLabel"  class="text-center"><span id="tituloModal"></span></h3>
        
    </div>
    
    <div class="modal-body" id="conteudoModal">
       
        
        
    </div>
    
    <div class="modal-footer">
       
        <button data-dismiss="modal" class="btn">Fechar</button>
        
    </div>
    
</div><!--#myModal-->

{literal}
<script type="text/javascript">
    function abrirMensagem(id) {     
        jQuery.post('/lms/aluno/empreendedor/ler', {id_dica:id}, function html(json) {
            dados = jQuery.parseJSON(json);
            console.log(dados);
            jQuery('#tituloModal').html(dados.cabecalho);
            if(dados.link_video){
                if(dados.tipo_video == 1){
                    htmlDescricao = "<iframe width='100%' height='278' src='"+dados.link_video+"' frameborder='0' allowfullscreen></iframe>";
                }else{
                    htmlDescricao = "<iframe src='"+dados.link_video+"' width='100%' height='278' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
                }
            }
            jQuery('#conteudoModal').html(htmlDescricao+"<p>"+dados.descricao+"</p>");

        }); 
        jQuery('#dicas_'+id).css({ 'background': "#f0f0f0" });
        jQuery('#dicas_'+id).removeClass('not-view');
        jQuery('#dicas_'+id).addClass('view');        
    }
</script>
{/literal}