    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>{if $curso.id} Editar {else} Cadastrar {/if} Curso</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-book"></span></div>
            <div class="pagetitle">
                <h5>GERENCIAMENTO DE CURSOS</h5>
                <h1>{if $curso.id} Editar {else} Cadastrar Novo{/if} Curso</h1>
            </div>
        </div>

        <div class="maincontent">
            <div class="maincontentinner">
                
                <a href="/lms/{$categoria}/curso/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>

                <!-- START OF DEFAULT WIZARD -->
                <h4 class="subtitle2">{if $curso.id} Editar {else} Cadastrar Novo{/if} Curso</h4>
                    {$error}
                    {if $sucesso} Ação realizada com sucesso! {/if}
                    <form class="stdform" method="post" id="form-curso" action="" enctype='multipart/form-data'>
                        <input type="hidden" value="1" name="editar" />
                        <input type="hidden" value="{$curso.id}" name="id" />
                        <div id="wizard" class="wizard">
                        	<br />
                            <ul class="hormenu">
                                <li>
                                	<a href="#wiz1step1">
                                    	<span class="h2">Passo 1</span>
                                        <span class="label">{if $curso.id} Edição {else} Cadastro {/if} do Produto</span>
                                    </a>
                                </li>
                                <li>
                                	<a href="#wiz1step2">
                                    	<span class="h2">Passo 2</span>
                                        <span class="label">{if $curso.id} Edição {else} Cadastro {/if} do Curso</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- PASSO 1 -->                    	
                            <div id="wiz1step1" class="formwiz">
                            	<h4 class="widgettitle">Passo 1: {if $curso.id} Edição {else} Cadastro {/if} do Produto</h4>
                            	    <!-- Curso -->
                                    <p>
                                        <label>Nome do Curso*</label>
                                        <span class="field"><input type="text" name="curso" value="{$curso.curso}" class="input-xxlarge" /></span>
                                    </p>
                                    <!-- Tags -->
                                    <p>
                                        <label>Tags*</label>
                                        <span class="field">
                                            <input name="tags" id="tags" class="input-large" value="{$curso.tags}" />
                                        </span>
                                    </p>
                                    <!-- Categorias -->                   
                                    <p>
                                        <label>Categorias*</label>
                                        <span class="formwrapper">
                                            {foreach from=$categorias item=categoria_curso}
                                                <input type="checkbox" name="categorias[]" value="{$categoria_curso.id}" {if $categoria_curso.id|in_array:$curso.categorias} checked="checked" {/if}/> {$categoria_curso.categoria}<br />
                                                {foreach from=$categoria_curso.filhas item=categoria_filha}
                                                <span class="marginleft15">&nbsp;</span><input type="checkbox" name="categorias[]" value="{$categoria_filha.id}" {if $categoria_filha.id|in_array:$curso.categorias} checked="checked" {/if} /> {$categoria_filha.categoria}<br />
                                                {/foreach}
                                            {/foreach}
                                        </span>
                                        <br/>
                                    </p>
                                    <!-- Gratuito -->
                                    <p>
                                        <label>Curso Gratuito?*</label>
                                        <span class="field">
                                        <select name="gratuito" id="selection2" class="uniformselect">
                                            <option value="1" {if $curso.gratuito == 1} selected {/if}>Sim</option>
                                            <option value="0" {if $curso.gratuito == 0} selected {/if}>Não</option>
                                        </select></span>
                                    </p>
                                    
                                    <!-- Valor -->
                                    <div class="par">
                                        <label>Valor do Curso*</label>
                                        <div class="input-prepend input-append">
                                          <span class="add-on">R$</span>
                                          <input type="text" id="appendedPrependedInput" class="span2 preco" name="valor" value="{$curso.valor}">
                                        </div>
                                    </div>
                                    
                                    <!-- Variações: DVD, Certificado, Suporte -->
                                    <p>
                                        <label>Variações do Curso </label>
                                            <span class="formwrapper">
                                                <input type="checkbox" name="dvd" value="1" {if $curso.dvd} checked="checked" {/if}/> DVD <br />
                                                {if $certificado.produtos_certificado_tipo != 0}
                                                    <input type="checkbox" name="certificado" value="1" {if $curso.certificado} checked="checked" {/if} /> Certificado Impresso <br />
                                                {/if}
                                                {if $suporte.produtos_suporte_tipo != 0}
                                                <input type="checkbox" name="suporte" value="1" {if $curso.suporte} checked="checked" {/if} /> Suporte<br /> 
                                                {/if}
                                            </span>
                                    </p>

                                    <!-- Home -->
                                    <p>
                                        <label>Exibir na Home?*</label>
                                        <span class="field"><select name="home" id="selection2" class="uniformselect">
                                            <option value="1" {if $curso.home == 1} selected {/if}>Sim</option>
                                            <option value="0"{if $curso.home == 0} selected {/if}>Não</option>
                                        </select></span>
                                    </p>
                            	
                                    <!-- Destaque -->
                                    <p>
                                        <label>Curso Destaque?*</label>
                                        <span class="field"><select name="destaque" id="selection2" class="uniformselect">
                                            <option value="1" {if $curso.destaque == 1} selected {/if}>Sim</option>
                                            <option value="0" {if $curso.destaque == 0} selected {/if}>Não</option>
                                        </select></span>
                                    </p>
                                
                                    <!-- Banner -->
                                    <p>
                                        <label>Exibir no Banner?*</label>
                                        <span class="field"><select name="banner" id="selection2" class="uniformselect">
                                            <option value="1" {if $curso.banner == 1} selected {/if}>Sim</option>
                                            <option value="0" {if $curso.banner == 0} selected {/if}>Não</option>
                                        </select></span>
                                    </p>
                                    
                                    <!-- Banner arquivo -->
                                    <div class="par">
                                        <label>Upload do Banner*</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input span3">
                                                    <i class="iconfa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-file"><span class="fileupload-new">Selecionar Banner</span>
                                                <span class="fileupload-exists">Alterar</span>
                                                <input type="file" name="banner_arquivo"/></span><!-- AQUI -->
                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                                            </div>
                                        </div>
                                        {if $curso.banner_arquivo}
                                            <input type="hidden" value="{$curso.banner_arquivo}" name="visualizar_banner_arquivo"/>
                                            <label><img src="/lms/uploads/imagens/{$curso.banner_arquivo}" width="100" /></label><div style="clear:both;"></div>
                                        {/if}
                                    </div>
                                    
                                    <!-- Imagem destaque -->
                                    <div class="par">
                                        <label>Imagem Destacada*</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input span3">
                                                    <i class="iconfa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-file"><span class="fileupload-new">Selecionar Destacada</span>
                                                <span class="fileupload-exists">Alterar</span>
                                                <input type="file" name="destaque_arquivo" /></span><!-- AQUI -->
                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                                            </div>
                                        </div>
                                        {if $curso.destaque_arquivo}
                                            <input type="hidden" value="{$curso.destaque_arquivo}" name="visualizar_destaque_arquivo"/>
                                            <label><img src="/lms/uploads/imagens/{$curso.destaque_arquivo}" width="100" /></label><div style="clear:both;"></div>
                                        {/if}
                                    </div>
                                    
                                    <!-- cursos -->
                                    <p>
                                        <label>Cursos Relacionados</label>
                                        <span class="formwrapper">
                                            <select data-placeholder="Escolha um curso" name="cursos[]" class="chzn-select" multiple style="width:550px;" tabindex="4">
                                                <option value=""></option> 
                                                {foreach from=$cursos item=cursoRelacionado}
                                                <option value="{$cursoRelacionado.id}" {if $cursoRelacionado.id|in_array:$curso.cursos} selected {/if}>{$cursoRelacionado.curso}</option>
                                                {/foreach}
                                            </select>
                                        </span>
                                    </p>
                                    <!-- Frete -->
                                    <p>
                                        <label>Tipo de Frete*</label>
                                        <span class="formwrapper">
                                   	        <input type="radio" name="frete" value="1" {if $curso.frete == 1}  checked="checked" {/if}/> Gratuito
                                     	    <input type="radio" name="frete" value="2" {if $curso.frete == 2}  checked="checked" {/if}/> Fixo
                                            <input type="radio" name="frete" value="3" {if $curso.frete == 3}  checked="checked" {/if}/> Calculado
                                        </span>
                                    </p>

                                    <p>
                                        <label>Valor do Frete*</label>
                                        <span class="field"><input type="text" id="appendedPrependedInput" class="span2 preco" value="{$curso.valor_frete}" name="valor_frete"></span>
                                    </p>

                                    <p>
                                        <label>Servidor Padrão*</label>
                                        <span class="formwrapper">
                                            <input type="radio" name="servidor" value="1" {if $curso.servidor == 1}  checked="checked" {/if}/> Amazon
                                            <input type="radio" name="servidor" value="2" {if $curso.servidor == 2}  checked="checked" {/if}/> Vimeo
                                            <input type="radio" name="servidor" value="0" {if $curso.servidor == 0}  checked="checked" {/if}/> Default
                                        </span>
                                    </p>
<p>&nbsp;</p>
                            </div><!--#wiz1step1-->
                            <!-- FIM PASSO 1 -->
                            
                            <!-- PASSO 2 -->
                            <div id="wiz1step2" class="formwiz">
                            	<h4 class="widgettitle">Passo 2: {if $curso.id} Edição {else} Cadastro {/if} do Curso</h4>
                                
                                    <!-- Descrição -->
                                	<p>
                                        <label>Descrição do Curso*</label>
                                        <span class="field"><textarea cols="80" rows="5" name="descricao" class="span6">{$curso.descricao}</textarea></span>
                                    </p>
                                    <!-- Técnica -->
                                    <p>
                                        <label>Informações Técnicas*</label>
                                        <span class="field"><textarea cols="80" rows="5" name="tecnica" class="span6">{$curso.tecnica}</textarea></span>
                                    </p>
                                    <!-- Requisito -->
                                    <p>
                                        <label>Pré-requisitos*</label>
                                        <span class="field"><textarea cols="80" rows="5" name="requisito" class="span6">{$curso.requisito}</textarea></span>
                                    </p>
                                    <!-- Publico -->
                                    <p>
                                        <label>Público Alvo*</label>
                                        <span class="field"><textarea cols="80" rows="5" name="publico" class="span6">{$curso.publico}</textarea></span>
                                    </p>
                                    <!-- Perfil -->
                                    <p>
                                        <label>Perfil do Aluno*</label>
                                        <span class="field"><textarea cols="80" rows="5" name="perfil" class="span6">{$curso.perfil}</textarea></span>
                                    </p>
                                    <!-- Professores -->
                                    <p>
                                        <label>Professor do Curso*</label>
                                        <span class="formwrapper">
                                            <select data-placeholder="Selecione o Professor..." name="professor_id" style="width:350px" class="chzn-select" tabindex="2">
                                                <option value="0">Nenhum Professor</option> 
                                                {foreach from=$professores item=professor}
                                                    <option value="{$professor.id}" {if $curso.professor_id == $professor.id}  selected {/if}>{$professor.nome}</option> 
                                                {/foreach}
                                            </select>
                                        </span>
                                    </p>
                                    <!-- Professor substituto -->
                                    <p>
                                        <label>Professor do Substituto</label>
                                        <span class="formwrapper">
                                            <select data-placeholder="Selecione o Professor..." name="professor_substituto_id" style="width:350px" class="chzn-select" tabindex="2">
                                                <option value="0">Nenhum Professor</option> 
                                                {foreach from=$professores item=professor}
                                                    <option value="{$professor.id}" {if $curso.professor_substituto_id == $professor.id}  selected {/if}>{$professor.nome}</option> 
                                                {/foreach}
                                            </select>
                                        </span>
                                   	</p>
                                   
                                    <!-- QT Capítulos -->
                                    <p>
                                        <label>Quantidade de Capítulos</label>
                                         <span class="field"><input type="text" name="qt_capitulos" class="input-small" value="{$curso.qt_capitulos}"/></span>
                                    </p>

                                    <!-- CARGA HORARIA -->
                                    <p>
                                        <label>Carga horária</label>
                                        <span class="field"><input type="text" name="carga_horaria" class="input-small" value="{$curso.carga_horaria}"/></span>
                                    </p>

                                    <!-- REVIEW DO CURSO -->
                                    <p>
                                        <label>Review do Curso*</label>
                                        <span class="field"><input type="text" name="review_curso" value="{$curso.review_curso}" class="input-xxlarge" /></span>
                                    </p>
                                                                                                  
                            </div><!--#wiz1step2-->
                            <!-- PASSO 2 -->

                        </div><!--#wizard-->
                    </form>
                    <!-- END OF DEFAULT WIZARD -->
                    
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

    // Smart Wizard   
    jQuery('#wizard').smartWizard({onFinish: onFinishCallback});
    jQuery('#wizard2').smartWizard({onFinish: onFinishCallback});
    
    jQuery(".chzn-select").trigger("liszt:updated");

    //Mensagem
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});
function onFinishCallback(){
    jQuery('#form-curso').submit();
}
</script>
<script src="/lms/common/js/jquery.price_format.1.8.min.js"></script>
<script src="/lms/common/js/jquery.price_format.1.8.js"></script>
<script>
    jQuery('.preco').priceFormat();
</script>

{/literal}