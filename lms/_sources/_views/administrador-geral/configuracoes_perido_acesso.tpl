    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Período de Acesso</li>
            
            
        </ul>
        
        <div class="pageheader">            
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Período de Acesso</h1>
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
                            <input type="hidden" value="1" name="editar"/>                           
                                
                                   
                                    <label>Período de Acesso em (MESES): </label>
                                    <input type="number"  maxlength="02" name="periodoAcesso" value="{$periodo.periodo_acesso}" class="input-medium" />
                                

                            
                            <p class="stdformbutton">
                                <button class="btn btn-primary">Salvar</button>
                            </p>
                       
                       </form>
                    
                    </div>
                </div>

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