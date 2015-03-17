
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Minhas Notificações</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-comment"></span></div>
            <div class="pagetitle">
                <h1>Minhas Notificações</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <h4 class="widgettitle">Minhas Notificações</h4>
                        <div class="widgetcontent nopadding">
                            <ul class="commentlist">
                                {foreach item=notificacao from=$notificacoes}
                                <li id="li_{$notificacao.id}" {if $notificacao.lida == false} style="background:#f0f0f0;" {/if}>
                                    <img src="/lms/uploads/avatar/{$notificacao.avatar}" alt="" class="pull-left" />
                                    <div class="comment-info">
                                        <input type="hidden" value="{$notificacao.id}" id="id_{$notificacao.id}" />
                                        <h4><a href="javascript:;" class="alerthtmlbutton" onclick="abrirMensagem({$notificacao.id});">{$notificacao.titulo}</a></h4>
                                        <h5>por <strong>{$notificacao.remetente}</strong></h5>
                                        <p>{$notificacao.resumo}</p>
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
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
<div id="retorno_notificacao"></div>
{literal}
<script type="text/javascript">
    function abrirMensagem(id) {     
        jQuery.post('/lms/{/literal}{$categoria}{literal}/notificacoes/ler', {notificacao:id}, function html(html) {jQuery('#retorno_notificacao').html(html)});
        jQuery('#li_'+id).css('background', '#FFFFFF');
    }

{/literal}
{if ($notificacaoAberta)}
abrirMensagem({$notificacaoAberta});
{/if}
{literal}
</script>
{/literal}