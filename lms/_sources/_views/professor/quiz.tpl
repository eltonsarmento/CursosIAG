    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/professor/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel do Professor</li>
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="professor/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-comments"></span></div>
            <div class="pagetitle">
                <h5>Quiz</h5>
                <h1>{$curso.curso}</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

            <div class="row-fluid">

                <form class="stdform" method="post" action="">
                    <input type="hidden" value="{$aulaId}" name="id"/>
                    <input type="hidden" value="1" name="responder"/>
                    <div class="span12">

                        <div class="widget-box">

                            <h4 class="widgettitle">Pergunta</h4>
                            <div class="widgetcontent">

                                <div class="par control-group">
                                    
                                    <label class="control-label" for="firstname">Pergunta:</label>
                                    <span class="formwrapper"><strong>{$quiz.pergunta}</strong></span>
                                        
                                </div>

                                <p>
                                
                                    <label>Respostas:</label>

                                    <span class="formwrapper">
                                        <input type="radio" name="alternativa" value="1" /> {$quiz.alternativa1}<br/>
                                        <input type="radio" name="alternativa" value="2" /> {$quiz.alternativa2}<br/>
                                        {if $quiz.alternativa3 != ''} <input type="radio" name="alternativa" value="3" /> {$quiz.alternativa3}<br/> {/if}
                                        {if $quiz.alternativa4 != ''} <input type="radio" name="alternativa" value="4" /> {$quiz.alternativa4}<br/> {/if}
                                        {if $quiz.alternativa5 != ''} <input type="radio" name="alternativa" value="5" /> {$quiz.alternativa5}<br/> {/if}
                                    </span>

                                </p>
                                   
                            </div><!--widgetcontent-->
                                   
                        </div><!--widget-->

                    </div> <!-- span6 -->

                    <button class="btn btn-primary">Enviar Resposta</button>
                    {if $quiz.obrigatorio == 0}
                    <button class="btn btn-primary" id="btnPular">Pular Quiz</button>
                    {/if}
                
                </form>

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
{literal}
<script type="text/javascript">

jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});


jQuery('#btnPular').click(function(){
    {/literal}
    window.location.href="{$url_site}lms/professor/cursos/pular/{$aulaId}";
    {literal}
    return false; 
});
</script>
{/literal}
