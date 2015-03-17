 <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="/lms/{$categoria}/dashboard/home">Painel principal</a> <span class="separator"></span></li>
            <li>Nova Dúvida</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-envelope"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Nova Dúvida</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                 <div class="widget">
                <h4 class="widgettitle"></h4>
                <div class="widgetcontent">
                
                    <div class="row-fluid">
                    
                        <div class="span12">
                        <form class="stdform" method="post" action="">
                            <input type="hidden" value="1" name="editar"/>
                            
                            <!-- TITULO -->
                            <div class="par control-group">
                                <label class="control-label" for="firstname">Título:*</label>
                                <div class="controls"><input type="text" name="titulo" id="firstname" value="{$duvida.titulo}" class="input-xlarge" placeholder="Função IF"/></div>
                            </div>
                            
                            <!-- CURSO -->                            
                            <p>
                                <label>Curso*</label>
                                <span class="formwrapper">
                                    <select data-placeholder="Selecione o Curso..." style="width:350px" name="curso_id" class="chzn-select" tabindex="2" id="select-curso" onchange="buscarProfessor()">
                                        <option value=""></option> 
                                        {foreach item=curso from=$cursos} 
                                            {if $curso.suporte == 1}
                                            <option value="{$curso.curso_id}"  {if $curso.curso_id == $duvida.curso_id} selected {/if} >{$curso.curso}</option>
                                            {/if}
                                        {/foreach}
                                    </select>
                                </span>
                            </p>

                            <!-- PROFESSOR -->
                            <p>
                                <label>Professor do Curso*</label>
                                <span class="formwrapper" id="selectAula" >
                                    <select data-placeholder="Selecione o Professor..." id="selectAula" style="width:350px" name="professor_id" class="chzn-select" tabindex="2">
                                      <option value=""></option> 
                                      {foreach from=$professores item=professor}
                                        <option value="{$professor.id}" {if $professor.id == $duvida.professor_id} selected{/if} >{$professor.nome}</option> 
                                      {/foreach}
                                    </select>
                                </span>
                            </p>
                            
                            <!-- DUVIDA -->    
                            <p>
                                <label>Dúvida*</label>
                                <textarea class="input-xxlarge" cols="30" name="comentario" rows="5">{$duvida.comentario}</textarea>
                            </p>
                                                            
                            <p class="stdformbutton">
                                <button class="btn btn-primary">Cadastrar Dúvida</button>
                            </p>
                       </form>
                       </div>
                    </div>
                </div><!--widgetcontent-->
            </div><!--widget-->
                
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
    jQuery('select.uniformselect').uniform();
    jQuery('.chzn-select').chosen();

    {/literal}
    {if $msg_alert}
    jAlert('{$msg_alert}');
    {/if}
    {literal}

});
function buscarProfessor() {
    var curso = jQuery('#select-curso').val();
    jQuery.post('/lms/{/literal}{$categoria}{literal}/duvidas/buscarProfessores/', {curso_id:curso}, function html(html) { jQuery('#selectAula').html(html); });
}
</script>
{/literal}