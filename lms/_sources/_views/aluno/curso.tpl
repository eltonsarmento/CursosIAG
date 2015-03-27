    <div class="rightpanel">
     
        <div class="maincontent">
            <div class="maincontentinner">
                <a href="{$url_site}lms/aluno/cursos/meus-cursos" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>
                <div class="row-fluid">
        
                    <div class="span12">
                        <!-- CURSOS E PROFESSOR  -->
                        <div class="row-fluid">
                            <!-- CURSO -->
                            <div class="span12">
                                <div class="widgetbox">

                                    <h4 class="widgettitle">Informações do Curso</h4>
                                    <div class="widgetcontent">

                                        <div class="media">
                                            <img src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" class="img-polaroid visible-desktop pull-left">
                                            <div class="media-body">
                                                <h4 class="media-heading"><strong>{$curso.curso}</strong></h4>
                                                <p>{$curso.descricao}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- FIM CURSO -->
                        </div>
                        <div class="row-fluid">   
                            <!-- PROFESSOR -->
                            <div class="span12">
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
                                    
                                    <!-- VISUALIZADO -->
                                    <div class="span2">
                                        <span>Foram visualizados <strong>{$completo}%</strong> do Curso</span>
                                    </div>

                                    <!-- FALTA VISUALIZAR -->
                                    <div class="span2">
                                        <span>Faltam visualizar <strong>{$faltando}%</strong> do Curso</span>
                                    </div>

                                    <!-- EXPIRA -->
                                    <div class="span2">
                                        <span>Data de Expiração: <strong>{$cursoAluno.expira|date_format:"%d/%m/%Y"}</strong></span>
                                    </div>

                                    <!-- QUIZ RESPONDIDO -->
                                    <div class="span2">
                                        <span>Quiz Respondidos: <strong>{$totalQuizRespondido}</strong></span>
                                    </div>

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
                        <!-- widgetbox - visto -->
                        <!-- widgetbox box-warning - atual -->
                        <!-- widgetbox box-inverse - não visto -->
                        <div class="widgetbox {if $capitulo.status == 1} box-warning {elseif $capitulo.status == 0} box-inverse {/if}">
                            <h4 class="widgettitle">Capítulo {$k+1} - {$capitulo.descricao}</h4>
                            <div class="widgetcontent">

                                <ul class="nav nav-list">
                                    <!--class="active" visto -->
                                    <!-- class="current" atual --> 
                                    <!-- nada não visto ainda -->
                                    {foreach item=aula key=j from=$capitulo.aulas}
                                    <li {if $aula.aula_id == $aulaAtual} class="current" {elseif $aula.aula_id|in_array:$aulasCompletadas} class="active" {/if}>
                                        <a href="{$url_site}lms/aluno/cursos/aula/{$aula.aula_id}">Aula {$j+1} - {$aula.nome}</a>
                                    </li>
                                    {/foreach}
                                </ul>

                            </div><!--widgetcontent -->

                        </div><!--widgetbox-->
                        {/foreach}
                </div><!--row-->
            
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