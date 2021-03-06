 
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Servidor</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Servidor</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <div class="row-fluid">
                    
                    <div class="span6">

                    <div class="widget">
                    <h4 class="widgettitle">Servidor</h4>
                    <div class="widgetcontent">
                
                	
                        <form class="stdform" method="post" action="">

                            <p>
                                <label>Status da Variação:</label>
                                   <span class="formwrapper">
                                    <strong>Amazon</strong>
                                </span>
                            </p>

                            <p>
                                <label>Servidor:</label>
                                   <span class="formwrapper">
                                    <input type="radio" name="radiofield" checked="checked" /> Amazon
                                    <input type="radio" name="radiofield" /> Vimeo
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
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});
</script>  
{/literal}