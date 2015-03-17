    <div class="rightpanel">
     
        <div class="maincontent">
            <div class="maincontentinner">
                <a href="{$url_site}lms/professor/cursos/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>
                <div class="row-fluid">
        
                    <div class="span12">
                        <!-- CURSOS E PROFESSOR  -->
                        <div class="row-fluid">
                            <!-- CURSO -->
                            <div class="span6">
                                <div class="widgetbox">

                                    <h4 class="widgettitle">Informações do Curso</h4>
                                    <div class="widgetcontent">

                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading"><strong>{$curso.curso}</strong></h4>
                                                <p>{$curso.descricao}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- FIM CURSO -->

                            <!-- PROFESSOR -->
                            <div class="span6">
                                <div class="widgetbox">
                                    <h4 class="widgettitle">Professor do Curso</h4>
                                    <div class="widgetcontent">

                                        <div class="topicpanel" style="margin:0;">
                                            <div class="author-thumb"><img src="{$url_site}lms/uploads/avatar/{$professor.avatar}" alt="" /></div>

                                            <div class="topic-content">
                                                <h5><strong>{$professor.nome}</strong></h5>
                                                <p>{$professor.minicurriculo}</p>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- FIM PROFESSOR -->

                        </div>
                        <!-- FIM CURSOS E PROFESSOR  -->

                        <!-- ESTATISTICAS -->
                        <div class="widgetbox">

                            <h4 class="widgettitle">Estatísticas</h4>

                            <div class="widgetcontent">
                                <div class="row-fluid">
                                    <!-- DUVIDAS ENVIADAS -->
                                    <div class="span2">
                                        <span>Dúvidas Enviadas: <strong>{$totalDuvidas}</strong></span>
                                    </div>

                                    <!-- DUVIDAS RESPONDIDAS -->
                                    <div class="span2">
                                        <span>Dúvidas Respondidas: <strong>{$totalDuvidasRespondidas}</strong></span>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- FIM ESTATISTICAS -->

                    </div>

                </div>

                <h3>Capítulos e Aulas</h3>
                <p>Legendas: <span class="label label-primary">Capítulo Visto</span> <span class="label label-warning">Capítulo Atual</span> <span class="label label-inverse">Capítulo Não Visto</span></p><br />

                <div class="row-fluid">                   

                        {foreach item=capitulo key=k from=$capitulos}
                        <div class="widgetbox">
                            <h4 class="widgettitle">Capítulo {$k+1} - {$capitulo.descricao}</h4>
                            <div class="widgetcontent">

                                <ul class="nav nav-list">
                                    {foreach item=aula key=j from=$capitulo.aulas}
                                    <li class="active">
                                        <a href="{$url_site}lms/professor/cursos/aula/{$aula.aula_id}">Aula {$j+1} - {$aula.nome}</a>
                                    </li>
                                    {/foreach}
                                </ul>

                            </div><!--widgetcontent -->

                        </div><!--widgetbox-->
                        {/foreach}
                </div><!--row-->
                
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

{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});
</script>
{/literal}