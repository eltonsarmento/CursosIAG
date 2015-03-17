    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Gráfica</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Gráfica</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <!-- GRAFICAS -->
                    <div class="span6">

                        <div class="widget">
                            <h4 class="widgettitle">E-mails</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="editar"/>
                                    <p>
                                        <label>E-mail Principal:*</label>
                                        <div class="field"><input type="text" name="grafica_email_1" value="{$graficas.grafica_email_1}" class="span8" placeholder="E-mail Principal"></div>
                                    </p>

                                    <p>
                                        <label>E-mail Opcional 1:</label>
                                        <div class="field"><input type="text" name="grafica_email_2" value="{$graficas.grafica_email_2}" class="span8" placeholder="E-mail Opcional 1"></div>
                                    </p>

                                    <p>
                                        <label>E-mail Opcional 2:</label>
                                        <div class="field"><input type="text" name="grafica_email_3" value="{$graficas.grafica_email_3}" class="span8" placeholder="E-mail Opcional 2"></div>
                                    </p>
                            
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                    </p>
                                </form>
                            </div><!--widgetcontent-->
                        </div><!--widget-->
                    </div>
                    <!-- FIM GRAFICA -->
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
</script>  
{/literal}