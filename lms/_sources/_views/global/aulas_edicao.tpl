<div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>{if $aula_id}Editar{else}Cadastrar{/if} Aula</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>{$cursoNome}</h5>
                <h1>{if $aula_id}Editar{else}Cadastrar{/if} Aula - Capítulo {$capituloNome}</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <a href="/lms/{$categoria}/aulas/listar/{$curso_id}" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>
                {if $msg}<h3 style="text-align:center;"> {$msg} </h3>{/if}
                <div class="widget">
                <h4 class="widgettitle">{if $aula_id}Editar{else}Cadastrar{/if} Aula {$n_aula}</h4>
                <div class="widgetcontent">
                
                	<div class="row-fluid">
                    
                    
                        <form class="stdform" method="post" action="/lms/{$categoria}/aulas/editar/">
							<input type="hidden" value="1" name="editar"/>
                            <input type="hidden" value="{$capitulo_id}" name="id" />
							<input type="hidden" value="{$aula_id}" name="aula_id" />
							<input type="hidden" value="{$curso_id}" name="curso_id" />
                            <input type="hidden" value="{$aulas.posicao}" name="posicao"/>
                            <input type="hidden" value="0" name="nova" id="nova"/>
							
                            <div class="par control-group">
                                <label class="control-label" for="firstname">Nome da Aula</label>
                            <div class="controls"><input type="text" name="nome" id="firstname" class="input-xxlarge" value="{$aulas.nome}" /></div>
                            </div>

                            <p>
                                <label>Tipo de Aula</label>
                                <span class="formwrapper">
                                  <input type="radio" name="tipo" {if $aulas.tipo eq 1 || !$aulas.tipo}checked="checked"{/if} value="1" /> Vídeo Aula
                                  <input type="radio" name="tipo" {if $aulas.tipo eq 2}checked="checked"{/if} value="2" /> PPT
                                  <input type="radio" name="tipo" {if $aulas.tipo eq 3}checked="checked"{/if} value="3" /> PDF
                                  <input type="radio" name="tipo" {if $aulas.tipo eq 4}checked="checked"{/if} value="4" /> Texto
                                  <input type="radio" name="tipo" {if $aulas.tipo eq 5}checked="checked"{/if} value="5" /> Materiais Extras
                                </span>
                            </p>

                            <div class="par control-group" id="div-resumo">
                                    <label class="control-label" for="location">Resumo da Aula</label>
                                <div class="controls"><textarea cols="80" rows="5" name="resumo" class="input-xxlarge" id="location">{$aulas.resumo}</textarea></div> 
                            </div>

                            <div class="par control-group" id="div-duracao">
                              
                              <label>Duração da Aula</label>
                                <div class="input-append bootstrap-timepicker">
                                  <input type="text" class="input-small campoDuracao" name="duracao" value="{$aulas.duracao}" />
                                  <span class="add-on"><i class="iconfa-time"></i></span>
                              </div>
                            
                            </div>

                            <div class="par control-group" id="div-vimeo">
                              
                              <label>Link Vimeo</label>
                                <div class="input-append bootstrap-timepicker">
                                  <input type="text" class="input-xlarge" name="vimeo" value="{$aulas.vimeo}" />
                                  <span class="add-on"><i class="iconfa-play"></i></span>
                              </div>
                            
                            </div>

                            <div class="par control-group" id="div-amazon">
                              
                              <label>Link Amazon</label>
                                <div class="input-append bootstrap-timepicker">
                                  <input type="text" class="input-xlarge" name="amazon" value="{$aulas.amazon}" />
                                  <span class="add-on"><i class="iconfa-play"></i></span>
                              </div>
                            
                            </div>

                            <p>
                                    <label>Aula Gratuita?</label>
                                    <span class="field"><select name="gratuito" id="selection2" class="uniformselect">
                                        <option value="2" {if $aulas.gratuito eq 2}selected="selected"{/if}>Não</option>
                                        <option value="1" {if $aulas.gratuito eq 1}selected="selected"{/if}>Sim</option>
                                    </select></span>
                                </p>
							
                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $aula_id}Editar{else}Cadastrar{/if} Aula</button> <button class="btn btn-primary" onclick="javascript:jQuery('#nova').val(1)">{if $aula_id}Editar{else}Cadastrar{/if} Aula e inserir nova</button>
                            </p>
                       
                      

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
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});


jQuery('input[name="tipo"]').on('change', function() {
    ocultarCampos(jQuery(this).val());
});

function ocultarCampos(tipo) {
    if (tipo == 1)  { //Video Aula
        jQuery('#div-resumo').hide('slow')
        jQuery('#div-duracao').show('slow')
        jQuery('#div-vimeo').show('slow')
        jQuery('#div-amazon').show('slow')
    }
    if (tipo == 2) { //PPT
        jQuery('#div-resumo').hide('slow')
        jQuery('#div-duracao').hide('slow')
        jQuery('#div-vimeo').hide('slow')
        jQuery('#div-amazon').show('slow')
    }
    if (tipo == 3) { //PDF
        jQuery('#div-resumo').hide('slow')
        jQuery('#div-duracao').hide('slow')
        jQuery('#div-vimeo').hide('slow')
        jQuery('#div-amazon').show('slow')
    }
    if (tipo == 4) { //Texto
        jQuery('#div-resumo').show('slow')
        jQuery('#div-duracao').hide('slow')
        jQuery('#div-vimeo').hide('slow')
        jQuery('#div-amazon').hide('slow')
    }
    if (tipo == 5) { //Matérias Extras
        jQuery('#div-resumo').show('slow')
        jQuery('#div-duracao').hide('slow')
        jQuery('#div-vimeo').hide('slow')
        jQuery('#div-amazon').hide('slow')
    }
}

{/literal}
{if $aulas.tipo}
ocultarCampos({$aulas.tipo});
{/if}
{literal}

</script>  
{/literal}