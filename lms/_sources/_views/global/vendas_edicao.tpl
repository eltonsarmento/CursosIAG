<div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel principal</a> <span class="separator"></span></li>
            <li>Gerenciar Vendas</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-bar-chart"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Vendas</h5>
                <h1>Nova Venda</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <div class="row-fluid">
                    
                    <div class="span12">
                        <div class="widgetbox">
                            <h4 class="widgettitle">Dados da Venda</h4>
                            <div class="widgetcontent">
                                
                                <form class="stdform" method="post" action="" id="form_vendas" onsubmit="return confirmaVenda();">
									<input type="hidden" value="0" name="valor_total" id="valor_total" />
									<input type="hidden" value="1" name="editar" id="editar" />
                                    <p>
                                        <label>Nome do Aluno*</label>
                                        <span class="formwrapper">
                                            <select data-placeholder="Buscar um aluno" style="width:350px" name="aluno_id" class="chzn-select" tabindex="2">
                                              <option value=""></option> 
                                              {foreach item=aluno from=$alunos}
                                                <option value="{$aluno.id}" {if $vendas.aluno_id == $aluno.id} selected="" {/if}>{$aluno.nome} - {$aluno.email}</option>
                                              {/foreach}
                                            </select>
                                        </span>
                                    </p>
                                    
                                    <p>
                                        <label>Cursos que esta comprando*</label>
                                        <span class="formwrapper">
                                            <select data-placeholder="Escolha um curso" name="cursos[]" id="cursos" class="chzn-select input-xxlarge" multiple="multiple" tabindex="4" onchange="javascript:mudarPreco()">
                                              <option value=""></option> 
                                              {foreach item=curso from=$cursos}
                                                <option value="{$curso.id}" {if $curso.id|in_array:$vendas.cursos} selected {/if}>{$curso.curso}</option>
                                              {/foreach}
                                            </select>
                                        </span>
                                    </p>
									{if $periodoLiberado}
									<div class="par control-group">
										<label class="control-label" for="data_venda">Data da Venda*</label>
										<div class="controls"><input type="text" name="data_venda" class="input-small campoData" value="{$vendas.data_venda}"/></div>
                                    </div>

                                    <div class="par control-group">
                                        <label class="control-label" for="data_expiracao">Data de Expiração*</label>
                                        <div class="controls"><input type="text" name="data_expiracao" class="input-small campoData" value="{$vendas.data_expiracao}"/></div>
                                    </div>
                                    {/if}

                                    <div class="par control-group">
                                        <label class="control-label">Tipo de desconto*</label>
                                        <span class="formwrapper">
                                            <input type="radio" name="forma_desconto" value="1" onclick="javascript:mudarPreco();" {if $vendas.forma_desconto == 1} checked="checked" {/if}/> Valor
                                            <input type="radio" name="forma_desconto" value="2" onclick="javascript:mudarPreco();" {if $vendas.forma_desconto == 2} checked="checked" {/if}/> Percentagem
                                            <input type="radio" name="forma_desconto" value="0" onclick="javascript:mudarPreco();" {if $vendas.forma_desconto == 0} checked="checked" {/if}/> Sem desconto
                                        </span>
                                    </div>
									
									<p>
                                        <label>Forma de pagamento:*</label>
                                        <span class="field">
                                            <select name="forma_pagamento" class="uniformselect">
                                                <option value="0" {if $vendas.forma_pagamento == 0} selected="" {/if}>Selecione uma opção</option>
                                                <option value="1" {if $vendas.forma_pagamento == 1} selected="" {/if}>Pagseguro</option>
                                                <option value="2" {if $vendas.forma_pagamento == 2} selected="" {/if}>Moip</option>
                                                <option value="3" {if $vendas.forma_pagamento == 3} selected="" {/if}>PayPal</option>
                                                <option value="4" {if $vendas.forma_pagamento == 4} selected="" {/if}>Depósito/Transferência</option>
                                                <option value="5" {if $vendas.forma_pagamento == 5} selected="" {/if}>Transferência Internacional</option>
                                            </select>
                                        </span>
                                    </p>

                                    <div id="p_desconto" style="{if $vendas.forma_desconto == 0} display:none; {/if}">
                                        <div class="par control-group">
    										<label class="control-label" for="desconto">Valor do desconto*</label>
    										<div class="controls"><input type="text" name="valor_desconto" value="{$vendas.valor_desconto}" id="desconto" class="input-large preco" onblur="javascript:mudarPreco();"/></div>
                                        </div>
                                    </div>
                                    
                                    <p>
                                        <label>Valor total: <h3>R$ <span id="preco">0.00</span></h3></label>
                                    </p>
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary"><i class="iconfa-ok"></i> Realizar Venda</button>
                                    </p>
                               </form>

                            </div>
                        </div>
                        
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
function mudarPreco() {
    {/literal}
    jQuery.post('/lms/{$categoria}/vendas/calcularPreco', jQuery('#form_vendas').serialize(), function html(html) {ldelim} jQuery('#preco').html(html); jQuery('#valor_total').val(html); {rdelim});
    {literal}
}

//Confirmar venda
var confirmado = false;

function confirmaVenda() {
    
    if (confirmado == false) {
        jConfirm('Tem certeza que deseja finalizar a venda?', 'Finalizar venda', function(r) {
            if (r) {
                confirmado = true;
                jQuery('#form_vendas').submit();
            }   
        }); 
    }
    

    return confirmado;
}

jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

jQuery('input[name="forma_desconto"]').on("click",function() {
    if (jQuery('input[name="forma_desconto"]:checked').val() == 0) {
        jQuery('#p_desconto').hide('slow');
        jQuery('#desconto').val('');
    } else {
        jQuery('#p_desconto').show('slow');
    }
});

mudarPreco();

</script>
<script src="/lms/common/js/jquery.price_format.1.8.min.js"></script>
<script src="/lms/common/js/jquery.price_format.1.8.js"></script>
<script>
    jQuery('.preco').priceFormat();
</script>
{/literal}