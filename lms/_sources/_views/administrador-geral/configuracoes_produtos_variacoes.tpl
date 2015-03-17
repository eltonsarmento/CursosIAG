    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Variações de Produtos</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Variações de Produtos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <div class="row-fluid">
                    
                    <div class="span6">

                    <div class="widget">
                    <h4 class="widgettitle">Suporte </h4>
                    <div class="widgetcontent">
                
                        <form class="stdform" method="post" action="">
                            <input type="hidden" value="1" name="editarSuporte"/>
                            <p>
                                <label>Status da Variação:</label>
                                   <span class="formwrapper">
                                    <strong>
                                    {if $suporte.produtos_suporte_tipo == 1} Gratuito {/if}
                                    {if $suporte.produtos_suporte_tipo == 2} Valor fixo {/if}
                                    {if $suporte.produtos_suporte_tipo == 3} Porcentagem {/if}
                                    {if $suporte.produtos_suporte_tipo == 0} Não disponível {/if}
                                    </strong>
                                </span>
                            </p>

                            <p>
                                <label>Valor:</label>
                                   <span class="formwrapper">
                                    <input type="radio" name="produtos_suporte_tipo" id="produtos_suporte_tipo" value="1" onchange="mudarTipoSuporte(this);" {if $suporte.produtos_suporte_tipo == 1} checked="checked" {/if} /> Gratuito
                                    <input type="radio" name="produtos_suporte_tipo" id="produtos_suporte_tipo" value="2" onchange="mudarTipoSuporte(this);" {if $suporte.produtos_suporte_tipo == 2} checked="checked" {/if}/> Valor Fixo
                                    <input type="radio" name="produtos_suporte_tipo" id="produtos_suporte_tipo" value="3" onchange="mudarTipoSuporte(this);" {if $suporte.produtos_suporte_tipo == 3} checked="checked" {/if}/> Porcentagem
                                    <input type="radio" name="produtos_suporte_tipo" id="produtos_suporte_tipo" value="0" onchange="mudarTipoSuporte(this);" {if $suporte.produtos_suporte_tipo == 0} checked="checked" {/if}/> Não Disponível<br>
                                </span>

                            </p>

                            <p id="p_suporte_valor" {if $suporte.produtos_suporte_tipo != 2 && $suporte.produtos_suporte_tipo != 3} style="display:none;" {/if}>
                                <label>Valor:</label>
                                   <span class="formwrapper">
                                    <input type="text" name="produtos_suporte_valor" value="{$suporte.produtos_suporte_valor}" class="input-medium preco" />
                                </span>

                            </p>
                            
                            <p class="stdformbutton">
                                <button class="btn btn-primary">Salvar Variação</button>
                            </p>
                       
                       </form>
                    
                    </div>
                </div>

                </div>



                <div class="span6">

                    <div class="widget">
                    <h4 class="widgettitle">Certificado Impresso</h4>
                    <div class="widgetcontent">
                
                    
                        <form class="stdform" method="post" action="">
                            <input type="hidden" value="1" name="editarCertificado"/>
                            <p>
                                <label>Status da Variação:</label>
                                   <span class="formwrapper">
                                    <strong>
                                        {if $certificado.produtos_certificado_tipo == 1} Gratuito {/if}
                                        {if $certificado.produtos_certificado_tipo == 2} Valor fixo {/if}
                                        {if $certificado.produtos_certificado_tipo == 0} Não disponível {/if}
                                    </strong>
                                </span>
                            </p>

                            <p>
                                <label>Valor:</label>
                                   <span class="formwrapper">
                                    <input type="radio" name="produtos_certificado_tipo" id="produtos_certificado_tipo" value="1" onchange="mudarTipoCertificado(this);" {if $certificado.produtos_certificado_tipo == 1} checked="checked" {/if} /> Gratuito
                                    <input type="radio" name="produtos_certificado_tipo" id="produtos_certificado_tipo" value="2" onchange="mudarTipoCertificado(this);" {if $certificado.produtos_certificado_tipo == 2} checked="checked" {/if} /> Valor Fixo
                                    <input type="radio" name="produtos_certificado_tipo" id="produtos_certificado_tipo" value="0" onchange="mudarTipoCertificado(this);" {if $certificado.produtos_certificado_tipo == 0} checked="checked" {/if} /> Não Disponível<br>
                                </span>

                            </p>

                            <p id="p_certificado_valor" {if $certificado.produtos_certificado_tipo != 2} style="display:none;" {/if}>
                                <label>Valor:</label>
                                   <span class="formwrapper">
                                    <input type="text" name="produtos_certificado_valor" value="{$certificado.produtos_certificado_valor}" class="input-medium preco" />
                                </span>

                            </p>
                            
                           
                            <p class="stdformbutton">
                                <button class="btn btn-primary">Salvar Variação</button>
                            </p>
                            
                       
                       </form>
                       
                       
                    </div><!--widgetcontent-->
                    
                </div><!--widget-->

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
jQuery(document).ready(function(){
    //Mensagem
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function mudarTipoSuporte(campo) {
    if (jQuery(campo).val() == 2 || jQuery(campo).val() == 3) {
        jQuery("#p_suporte_valor").show("slow");
    } else {
        jQuery("#p_suporte_valor").hide("slow");
    }

}

function mudarTipoCertificado(campo) {
    if (jQuery(campo).val() == 2) {
        jQuery("#p_certificado_valor").show("slow");
    } else {
        jQuery("#p_certificado_valor").hide("slow");
    }

}


</script>
<script src="/lms/common/js/jquery.price_format.1.8.min.js"></script>
<script src="/lms/common/js/jquery.price_format.1.8.js"></script>
<script>
    jQuery('.preco').priceFormat();
</script>

{/literal}