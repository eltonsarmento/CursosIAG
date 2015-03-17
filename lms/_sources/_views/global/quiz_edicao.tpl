    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>{if $quiz.id}Editar{else}Cadastrar{/if} Quiz</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-comments"></span></div>
            <div class="pagetitle">
                <h5>{$curso}</h5>
                <h1>{if $quiz.id}Edição{else}Cadastro{/if} de Quiz</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
               
               <a href="/lms/{$categoria}/quiz/listar/{$quiz.curso_id}" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>

               <div class="widget">
                <h4 class="widgettitle">{if $quiz.id}Editar{else}Cadastrar{/if} Quiz - Curso: {$curso}</h4>
                <div class="widgetcontent">
                
                	<div class="row-fluid">
                    
                    	
                        
                        <form class="stdform" method="post" action="/lms/{$categoria}/quiz/editar/">
                            <input type="hidden" value="1" name="editar" />
                            <input type="hidden" value="{$quiz.id}" name="id" />
                            <input type="hidden" value="{$quiz.curso_id}" name="curso_id" />
                            <div class="par control-group">
                                <label class="control-label" for="firstname">Pergunta</label>
                            <div class="controls"><input type="text" name="pergunta" id="firstname" class="input-xxlarge" value="{$quiz.pergunta}" /></div>
                            
                            </div>

                            <p>
                                <label>Opções de Resposta</label>
                                <span class="formwrapper">
                                  <input type="text" name="alternativa1" id="firstname" class="input-xlarge" placeholder="Opção 1" value="{$quiz.alternativa1}"/> <br />
                                  <input type="text" name="alternativa2" id="firstname" class="input-xlarge" placeholder="Opção 2" value="{$quiz.alternativa2}"/> <br />
                                  <input type="text" name="alternativa3" id="firstname" class="input-xlarge" placeholder="Opção 3" value="{$quiz.alternativa3}"/> <br />
                                  <input type="text" name="alternativa4" id="firstname" class="input-xlarge" placeholder="Opção 4" value="{$quiz.alternativa4}"/> <br />
                                  <input type="text" name="alternativa5" id="firstname" class="input-xlarge" placeholder="Opção 5" value="{$quiz.alternativa5}"/> <br />
                                </span>
                            </p>

                            <p>
                                <label>Resposta Correta</label>
                                <span class="formwrapper">
                                  <input type="radio" name="alternativa_correta" value="1" {if $quiz.alternativa_correta == 1} checked="checked" {/if}/> Opção 1
                                  <input type="radio" name="alternativa_correta" value="2" {if $quiz.alternativa_correta == 2} checked="checked" {/if}/> Opção 2
                                  <input type="radio" name="alternativa_correta" value="3" {if $quiz.alternativa_correta == 3} checked="checked" {/if}/> Opção 3
                                  <input type="radio" name="alternativa_correta" value="4" {if $quiz.alternativa_correta == 4} checked="checked" {/if}/> Opção 4
                                  <input type="radio" name="alternativa_correta" value="5" {if $quiz.alternativa_correta == 5} checked="checked" {/if}/> Opção 5
                                </span>
                            </p>
                            
                            <p>
                                <label>Capítulo</label>
                                    <span class="field"><select name="capitulo_id" id="selection1" class="uniformselect" onchange="buscarAula()">
                                        <option value="" selectd>Selecione o capítulo</option>
                                        {foreach from=$capitulos key=k  item=capitulo}
                                        <option value="{$capitulo}" {if $capitulo == $quiz.capitulo_id} selected {/if}>Capítulo {$k+1}</option>
                                        {/foreach}
                                    </select></span>
                            </p>

                            <p>
                                <label>Aula</label>
                                    <span class="field"><select name="aula_id" id="selection2" class="uniformselect">
                                        <option value="0">Selecione a aula</option>
                                        {foreach from=$aulas item=aula}
                                            <option value="{$aula.aula_id}" {if $aula.aula_id == $quiz.aula_id} selected {/if}>{$aula.nome}</option>
                                        {/foreach}
                                    </select></span>
                            </p>
                            
                            <p>
                                <label>Quiz Obrigátorio?</label>
                                    <span class="field"><select name="obrigatorio" id="selection3" class="uniformselect">
                                        <option value="1" {if $quiz.obrigatorio == 1} selected {/if}>Sim</option>
                                        <option value="0" {if $quiz.obrigatorio != 1} selected {/if}>Não</option>
                                    </select></span>
                            </p>
                                                            
                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $quiz.id}Editar{else}Cadastrar{/if} Quiz</button>
                            </p>
                       
                       </form>
                         
                       
                      </div>
                       
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
    // jQuery('select.uniformselect').uniform();
    jQuery(".chzn-select").trigger("liszt:updated");

    {/literal}
    {if $msg_alert}
    jAlert('{$msg_alert}');
    {/if}
    {literal}

});
function buscarAula() {
    var capitulo = jQuery('#selection1').val();
    {/literal}
    jQuery.post('/lms/{$categoria}/quiz/aulas/', {ldelim}capitulo_id:capitulo{rdelim}, function html(html) {ldelim} jQuery('#selection2').html(html); {rdelim});
}
</script>
