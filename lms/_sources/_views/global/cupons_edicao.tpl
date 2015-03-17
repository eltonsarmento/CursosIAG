
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>GERENCIAR Administrativo</h5>
                <h1>{if $cupom.id}Editar{else}Cadastrar{/if} Cupons</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <a href="/lms/{$categoria}/cupons/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>

                <div class="widget">
                    <h4 class="widgettitle">{if $cupom.id}Editar{else}Cadastrar{/if} Cupons</h4>
                    <div class="widgetcontent">
                
                        <form class="stdform" method="post" action="" enctype="multipart/form-data">
                            <div class="par control-group">
                                <input type="hidden" value="1" name="editar"/>
                                <input type="hidden" value="{$cupom.id}" name="id"/>
                                
                                <!-- NOME CUPOM -->
                                <div class="par control-group">
                                    <label class="control-label" for="firstname">Nome do cupom:*</label>
                                    <div class="controls"><input type="text" name="nome" id="firstname" class="input-xxlarge" placeholder="IAG0001" value="{$cupom.nome}"/></div>
                                    <small class="desc">O cupom deve ser composto de <strong>Letras e Números</strong></small>
                                </div>
                                
                                <!-- TIPO DE CUPOM -->
                                <p>
                                    <label>Tipo de cupom:*</label>
                                     <span class="field">
                                        <select name="tipo" id="selection2" class="uniformselect">
                                            <option value="0" selectd>Selecione o tipo do cupom</option>
                                            <option value="1"{if $cupom.tipo == 1} selected="selected" {/if}>Único</option>
                                            <option value="2"{if $cupom.tipo == 2} selected="selected" {/if}>Intervalo de Tempo</option>
                                            <option value="3"{if $cupom.tipo == 3} selected="selected" {/if}>Quantidade</option>
                                            <option value="4"{if $cupom.tipo == 4} selected="selected" {/if}>Indeterminado</option>
                                        </select></span>
                                </p>

                                <!-- TIPOS -->
                                <div id="p_tempo" {if $cupom.tipo == 3  || $cupom.tipo == 4}style="display:none;"{/if}>
                                    <p>
                                        <label class="control-label" for="firstname">Tempo do cupom:*</label>
                                        <div class="controls">
                                            <input type="text" name="tempo_de" id="tempo_de" class="input-medium campoData datepicker" placeholder="dd/mm/aaaa" value="{$cupom.tempo_de|date_format:"%d/%m/%Y"}" /> até <input type="text" name="tempo_ate" id="tempo_ate" class="input-medium campoData datepicker" placeholder="dd/mm/aaaa" value="{$cupom.tempo_ate|date_format:"%d/%m/%Y"}" /> </div>
                                    </p>
                                </div>
                                
                                <div id="p_qt" {if $cupom.tipo == 1 || $cupom.tipo == 4}style="display:none;"{/if}>
                                    <p>
                                        <label class="control-label" for="firstname">Quantidade de uso do cupom:*</label>
                                        <div class="controls"><input type="text" name="quantidade" id="quantidade" class="input-medium" placeholder="" value="{$cupom.quantidade}"/></div>
                                    </p>
                                </div>
                                
                                <!-- TIPO DESCONTO -->
                                <p>
                                    <label class="control-label" for="firstname">Tipo desconto:*</label>
                                    <span class="field">
                                        <select name="tipo_desconto" class="uniformselect">
                                            <option value="1" {if $cupom.tipo_desconto == 1} selected="selected" {/if}>Valor R$ </option>
                                            <option value="2" {if $cupom.tipo_desconto == 2} selected="selected" {/if}>Percentual %</option>
                                        </select>
                                    </span>
                                </p>

                                <!-- STATUS DO CUPOM -->
                                <p>
                                    <label class="control-label" for="firstname">Status do Cupom:*</label>
                                    <span class="field">
                                        <select name="ativo" class="uniformselect">
                                            <option value="1" {if $cupom.ativo == 1} selected="selected" {/if}>Ativo</option>
                                            <option value="0" {if $cupom.ativo == 0} selected="selected" {/if}>Inativo</option>
                                            <!-- <option value="2" {if $cupom.ativo == 2} selected="selected" {/if}>Usado</option>
                                            <option value="3" {if $cupom.ativo == 3} selected="selected" {/if}>Futuro</option> -->
                                        </select>
                                    </span>
                                </p>
                                
                                <!-- VALOR DO CUPOM -->
                                <p>
                                    <label class="control-label" for="firstname">Valor do cupom:*</label>
                                    <div class="controls"><input type="text" name="valor" id="valor" class="input-medium preco" placeholder="" value="{$cupom.valor}" /></div>
                                </p>

                                <!-- CURSOS ATIVOS -->
                                <p>
                                    <label class="control-label" for="cursos_ativos">Válido para:*</label>
                                    <span class="formwrapper">
                                        <select data-placeholder="Deixe em branco para selecionar todos" name="cursos_ativos[]" class="chzn-select" multiple style="width:550px;" tabindex="4">
                                            <option value=""></option> 
                                            {foreach from=$cursos item=cursoAtivos}
                                            <option value="{$cursoAtivos.id}" {if $cursoAtivos.id|in_array:$cupom.cursos_ativos} selected {/if}>{$cursoAtivos.curso}</option>
                                            {/foreach}
                                        </select>
                                    </span>
                                </p>

                                <!-- CURSOS EXCLUíDOS -->
                                <p>
                                    <label class="control-label" for="cursos_excluidos">Exceto para:*</label>
                                    <span class="formwrapper">
                                        <select data-placeholder="Escolha um curso" name="cursos_excluidos[]" class="chzn-select" multiple style="width:550px;" tabindex="4">
                                            <option value=""></option> 
                                            {foreach from=$cursos item=cursoExcluido}
                                            <option value="{$cursoExcluido.id}" {if $cursoExcluido.id|in_array:$cupom.cursos_excluidos} selected {/if}>{$cursoExcluido.curso}</option>
                                            {/foreach}
                                        </select>
                                    </span>
                                </p>
                            </div>

                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $cupom.id}Editar{else}Cadastrar{/if} Cupom</button>
                            </p>
                       </form>
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

function deletar(id) {
    jConfirm('Deseja excluir este professor?', 'Excluir Professor', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/{$categoria}/professores/apagar/'+id;
        {literal}
    }     
    });
}

jQuery('#selection2').change(function() {
    //Unico
    if (jQuery('#selection2').val() == 1) {
        jQuery('#p_qt').hide('slow');
    } else {
        if (jQuery('#selection2').val() != 4) {
            jQuery('#p_qt').show('slow');    
        }
        
    }

    //Quantidade
    if (jQuery('#selection2').val() == 3) {
        jQuery('#p_tempo').hide('slow');
        jQuery('#tempo_de').val('');
        jQuery('#tempo_ate').val('');
    } else {
        if (jQuery('#selection2').val() != 4) {
            jQuery('#p_tempo').show('slow');
        }
    }

    //Indeterminado
    if (jQuery('#selection2').val() == 4) {
        jQuery('#p_tempo').hide('slow');
        jQuery('#tempo_de').val('');
        jQuery('#tempo_ate').val('');

        jQuery('#p_qt').hide('slow');
    } 
});
</script>  
<script src="/lms/common/js/jquery.price_format.1.8.min.js"></script>
<script src="/lms/common/js/jquery.price_format.1.8.js"></script>
<script>
    jQuery('.preco').priceFormat();
</script>
{/literal}