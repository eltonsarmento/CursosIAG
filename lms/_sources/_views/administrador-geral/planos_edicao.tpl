
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-reorder"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Planos</h5>
                <h1>{if $plano.id}Editar{else}Adicionar{/if} Plano</h1>
            </div>
        </div><!--pageheader-->
        
         <div class="maincontent">
            <div class="maincontentinner">
                
                <div class="row-fluid">
                    
                    <div class="span12">
                        <div class="widgetbox">
                            
                            <h4 class="widgettitle">Dados do Plano</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" value="1" name="editar"/>
                                    <input type="hidden" value="{$plano.id}" name="id"/> 
                                    <p>
                                        <label>Nome do Plano*</label>
                                        <span class="field"><input type="text" name="plano" id="plano" class="input-xxlarge" value="{$plano.plano}"/></span>
                                    </p>
                                    
                                    <p>
                                        <label>Quantidade de Meses*</label>
                                        <span class="field"><input type="text" id="meses" class="input-xlarge inteiro" {if $plano.id}disabled="" {else} name="meses" {/if} value="{$plano.meses}"/></span>
                                        {if $plano.id} <input type="hidden" value="{$plano.meses}" name="meses" />{/if}
                                    </p>

                                    <p>
                                        <label>Valor do Plano*</label>
                                        <span class="field"><input type="text" name="valor" id="valor" class="input-large preco" {if $plano.id} disabled="" {else} name="valor" {/if} value="{$plano.valor}"/></span>
                                        {if $plano.id} <input type="hidden" value="{$plano.valor}" name="valor" />{/if}
                                    </p>

                                    <p>
                                        <label>Tipo de Plano*</label>
                                        <span class="formwrapper">
                                            <input type="radio" class="cursos_tipo_acessos" name="cursos_tipo_acessos" value="1" {if $plano.cursos_tipo_acessos == 1} checked="checked" {/if}/> Novos cursos só após a próxima renovação
                                            <input type="radio" class="cursos_tipo_acessos" name="cursos_tipo_acessos" value="2" {if $plano.cursos_tipo_acessos == 2} checked="checked" {/if}/> Acesso liberado aos novos cursos
                                        </span>
                                    </p>

                                    <p id="cursos_qtd_mes">
                                        <label>Quantidade de Cursos por Mês</label>
                                        <span class="field"><input type="text" id="cursos_qtd_mes" class="input-xlarge inteiro" name="cursos_qtd_mes" value="{$plano.cursos_qtd_mes}"/><br />*Se o campo acima estiver vazio o sistema irá considerar sem limite de compra de cursos</span>
                                    </p>

                                    <!-- <p>
                                        <label>Acesso a Carreiras*</label>
                                        <span class="field">
                                            <select class="uniformselect" name="cursos_acesso_carreiras">
                                                <option value="1" {if $plano.cursos_acesso_carreiras == 1} selected {/if}>Sim</option>
                                                <option value="0" {if $plano.cursos_acesso_carreiras == 0} selected {/if}>Não</option>
                                            </select>
                                        </span>
                                    </p> -->

                                    <p>
                                        <label>Descrição do Plano*</label>
                                        <span class="field"><textarea cols="80" rows="5" name="descricao" class="span6">{$plano.descricao}</textarea></span>
                                    </p>

                                    <p>
                                        <label>Upload da imagem*</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input span3">
                                                    <i class="iconfa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-file"><span class="fileupload-new">Selecionar Banner</span>
                                                <span class="fileupload-exists">Alterar</span>
                                                <input type="file" name="imagem_arquivo"/></span><!-- AQUI -->
                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                                            </div>
                                        </div>
                                        {if $plano.imagem_arquivo}
                                            <input type="hidden" value="{$plano.imagem_arquivo}" name="visualizar_imagem_arquivo"/>
                                            <label><img src="/lms/uploads/imagens/{$plano.imagem_arquivo}" width="100" /></label><div style="clear:both;"></div>
                                        {/if}
                                    </p>

                                    <p>
                                        <label>Status:*</label>
                                        <span class="field">
                                            <select class="uniformselect" name="status">
                                                <option value="1" {if $plano.status == 1} selected {/if}>Ativo</option>
                                                <option value="0" {if $plano.status == 0} selected {/if}>Inativo</option>
                                            </select>
                                        </span>
                                    </p>
                                                                    
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">{if $plano.id}Editar{else}Adicionar{/if} Plano</button>
                                    </p>
                               </form>

                            </div>
                        </div>
                        
                </div>
            
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
{literal}
<script src="/lms/common/js/jquery.price_format.1.8.min.js"></script>
<script src="/lms/common/js/jquery.price_format.1.8.js"></script>
<script>
    jQuery('.preco').priceFormat();
    jQuery('.inteiro').priceFormat({
        centsLimit: 0,
        limit:3
    });
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
    /* jQuery('.cursos_tipo_acessos').on('click', function() {
        if (jQuery('.cursos_tipo_acessos:checked').val() == 1) {
            jQuery('#cursos_qtd_mes').show(300);
        } else {
            jQuery('#cursos_qtd_mes').hide(300);
        }
    });*/
    //Mensagem
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {if $plano.cursos_tipo_acessos == 1} jQuery('#cursos_qtd_mes').show(); {/if}
    {literal}
});
</script>
{/literal}