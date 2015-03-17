    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->

            <div class="pageicon"><span class="iconfa-comment"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Alunos</h5>
                <h1>Gerenciar Depoimentos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <h4 class="widgettitle">Depoimentos</h4>
                <div class="widgetcontent nopadding">
                    <ul class="commentlist">
                        {foreach item=depoimento from=$depoimentos}
                        <li>
                            <img src="/lms/uploads/avatar/{$depoimento.aluno.avatar}" alt="" class="pull-left" />
                            <div class="comment-info">
                                <h4><a href="#" class="alerthtmlbutton">{$depoimento.aluno.nome}</a></h4>
                                <h5>em <strong>{$depoimento.curso.curso}</strong></h5>
                                <p id="p_{$depoimento.id}">{$depoimento.mensagem}</p>
                                <p>
                                    <a href="/lms/{$categoria}/depoimentos/aceitar/{$depoimento.id}" class="btn btn-success">Aceitar Depoimento</a>
                                    <a href="/lms/{$categoria}/depoimentos/recusar/{$depoimento.id}" class="btn btn-danger">Recusar Depoimento</a>
                                    <a href="#editarDepoimento" data-toggle="modal" class="btn btn-info" onclick="setarValores({$depoimento.id})">Editar Depoimento</a>
                                </p>
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

     <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="editarDepoimento">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h3 id="myModalLabel">Editar Depoimento</h3>
        </div>
        <div class="modal-body">
            <p id="retorno_ajax_modal"></p>
            <form action="" onsubmit="return false;" id="formModal">
                <input type="hidden" value="1" name="editar"/>
                <input type="hidden" value="" name="id" id="depoimento_id"/>
                <p>
                    <label>Depoimento</label>
                    <span class="field"><textarea cols="80" rows="5" class="span5" name="mensagem" id="depoimentoModal"></textarea></span> 
                </p>
            

                <button class="btn btn-primary" onclick="editarDepoimento(); return false;">Salvar</button>

            </form>

                      
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>
    </div><!--#myModal-->

    <div id="retorno_ajax"></div>
{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function setarValores(id) {
    {/literal}
    jQuery.post('/lms/{$categoria}/depoimentos/buscarDepoimento/' + id, function html(html) {ldelim} jQuery('#retorno_ajax').html(html); {rdelim});
    {literal}
    jQuery('#depoimento_id').val(id);
}

function editarDepoimento() {
    {/literal}
    jQuery.post('/lms/{$categoria}/depoimentos/editar/', jQuery('#formModal').serialize() , function html(html) {ldelim} jQuery('#retorno_ajax_modal').html(html); {rdelim});
    {literal}
}

</script>
{/literal}