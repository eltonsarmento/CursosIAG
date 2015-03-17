
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Todos os cursos</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-briefcase"></span></div>
            <div class="pagetitle">
                <h5>Gerenciamento de Cursos</h5>
                <h1>Todos os Cursos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                {if $usuario_nivel == 7}
                <a href="/lms/{$categoria}/curso/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR CURSO</a>
                {/if}

                <!--<h4 class="widgettitle">Cursos</h4>-->
                <table class="table table-bordered responsive" id="dyntable">
                    <thead>
                        <tr>
                            <th class="head0">Nome do Curso</th>
                            <th class="center">Quantidade de Capítulos</th>
                            <th class="center">Quiz Cadastrados</th>
                            <th class="head0">Professor</th>
                            <th class="center">Área</th>
                            <th width="210">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$cursos key=k item=curso}
                        <tr>
                            <td><a href="/lms/{$categoria}/aulas/listar/{$curso.id}">{$curso.curso}</a></td>
                            <td class="center" width="180">{$curso.qt_capitulos}</td>
                            <td class="center" width="180">{$curso.qt_quiz}</td>
                            <td>{$curso.professor}</td>
                            <td class="center">{foreach from=$curso.categorias item=categoria_curso} {$categoria_curso.categoria} <br/> {/foreach}</td>
                            
                            <input type="hidden" value="{$curso.id}" id="curso_id_{$k}" />
                            <input type="hidden" value="{$curso.servidor}" id="servidor_{$k}" />
                            <td>
                                <ul class="tooltipsample">
                                    <li>
                                        <a href="#modalServidor" onclick="setarValores({$k})" data-toggle="modal" class="btn btn-default" data-placement="bottom" data-rel="tooltip" data-original-title="Sevidor Padrão"><i class="iconfa-cogs"></i></a>

                                        <a href="/lms/{$categoria}/aulas/listar/{$curso.id}" class="btn btn-warning" data-placement="bottom" data-rel="tooltip" data-original-title="Gerenciar Capítulos e Aulas"><i class="iconfa-book"></i></a>
                                        
                                        <a href="/lms/{$categoria}/quiz/listar/{$curso.id}" class="btn btn-inverse" data-placement="bottom" data-rel="tooltip" data-original-title="Gerenciar Quiz"><i class="iconfa-question-sign"></i></a>
                                        
                                        <a href="/lms/{$categoria}/curso/editar/{$curso.id}" class="btn btn-info"  data-placement="bottom" data-rel="tooltip" data-original-title="Editar Curso"><i class="iconfa-edit"></i></a> 
                                        
                                        {if ($usuario_nivel == 2 || $usuario_nivel == 1 || $usuario_nivel == 7) && $curso.alunos.total == 0}<a href="javascript:;" class="btn btn-primary confirmbutton"  data-placement="bottom" data-rel="tooltip" onclick="javascript:deletar({$curso.id})"  data-original-title="Excluir Curso"><i class="iconfa-remove"></i></a>{/if}
                                    </li>
                                </ul>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>

                <!--<a href="/lms/{$categoria}/curso/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR CURSO</a>-->
                
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



<!-- MODAL -->
<div aria-hidden="false" aria-labelledby="modalServidor" role="dialog" tabindex="-1" class="modal hide fade in" id="modalServidor">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Servidor Padrão</h3>
    </div>
    <div class="modal-body">
        
        <div id="resposta_trocar_servidor"></div>
        
        <form action="" id="trocar_servidor" onsubmit="return false;">
            <input type="hidden" value="" name="curso_id" id="curso_id" />
            <input type="hidden" value="" name="posicao" id="posicao" />
            <input type="hidden" value="1" name="editar" id="editar" />

            <p class="margintop10">
                <select class="uniformselect" name="servidor" id="servidor_modal">
                    <option value="1">Amazon</option>
                    <option value="2">Vimeo</option>
                    <option value="0">Default</option>

                </select>
            </p>

            <button class="btn btn-primary margintop10" onclick="mudarServidor()">Alterar Servidor</button>

        </form>

    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>
<!-- FIM MODAL -->

{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function mudarServidor() {
    {/literal}
    jQuery.post('/lms/{$categoria}/curso/salvarServidor',  jQuery('#trocar_servidor').serialize(), function html(html) {ldelim} jQuery('#resposta_trocar_servidor').html(html); {rdelim});
    {literal}
}

function setarValores(k) {
    jQuery("#resposta_trocar_servidor").html("");    
    jQuery("#posicao").val(k);
    jQuery("#curso_id").val(jQuery("#curso_id_"+k).val());
    jQuery("#servidor_modal").val(jQuery("#servidor_"+k).val());
}

function deletar(id) {
    jConfirm('Deseja excluir este curso?', 'Excluir curso', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/{$categoria}/curso/apagar/'+id;
        {literal}
    }     
    });
}
</script>
{/literal}