
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-comments"></span></div>
            <div class="pagetitle">
                <h5>Gerenciamento de Curso</h5>
                <h1>Gerenciar Quiz</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
               {if $categoria == 'professor'}
               <a href="/lms/{$categoria}/quiz/listarCursos" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/>
               {else}
               <a href="/lms/{$categoria}/curso/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/>
               {/if}
               <a href="/lms/{$categoria}/quiz/novo/{$curso.id}" class="btn btn-success"><i class="iconfa-plus"></i> Adicionar novo quiz</a> <br /><br />

               <table class="table table-bordered responsive" id="dyntable">
                    <thead>
                        <tr>
                            <th class="head0">Pergunta</th>
                            <th>Curso</th>
                            <th class="head0">Cadastrado por</th>
                            <th width="85">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach item=quiz from=$quizzes}
                        <tr>
                            <td>{$quiz.pergunta}</td>
                            <td>{$curso.curso}</td>
                            <td>{$quiz.usuario}</td>
                            <td>
                                <ul class="tooltipsample">
                                    <li>
                                      
                                      <a href="/lms/{$categoria}/quiz/editar/{$quiz.id}" class="btn btn-info"  data-placement="bottom" data-rel="tooltip" data-original-title="Editar Quiz"><i class="iconfa-edit"></i></a> 
                                      <a href="javascript:;" class="btn btn-primary confirmbutton" onclick="javascript:deletar({$quiz.id})" data-placement="bottom" data-rel="tooltip" data-original-title="Excluir Quiz"><i class="iconfa-remove"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>
                    
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
    jConfirm('Deseja excluir este quiz?', 'Excluir Quiz', function(r) {
         if (r) {
            {/literal}
            window.location.href='{$url_site}lms/{$categoria}/quiz/apagar/'+id;
            {literal}
        }     
    });
} 
</script>  
{/literal}