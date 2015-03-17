    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Configurações do Certificado</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Configurações do Certificado</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <div class="row-fluid">
                    <!-- PORCETAGEM -->
                    <div class="span6">
                        <div class="widget">
                            <h4 class="widgettitle">Percentual mínimo para Aprovação</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="editarPorcentagem"/>
                                    <p>
                                        <label>Valor:</label>
                                        <span class="field"><input type="text" id="spinner" name="certificado_porcentagem" class="input-small input-spinner" value="{$porcentagem.certificado_porcentagem}" /></span> 
                                    </p>

                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                    </p>
                       
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODELO -->
                    <div class="span6">
                        <div class="widget">
                            <h4 class="widgettitle">Modelo de Certificado</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" value="1" name="editarModelo"/>
                                    <p>
                                        <label>Anexo</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input span3">
                                                    <i class="iconfa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-file"><span class="fileupload-new">Selecione o arquivo</span>
                                                <span class="fileupload-exists">Trocar</span>
                                                <input type="file" name="imagem" /></span>
                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                                            </div>
                                        </div> 
                                    </p>
                                    {if ($modelo.certificado_modelo)}
                                    <p>
                                         <label>Modelo Atual:</label>
                                         <img src="/lms/uploads/certificados/{$modelo.certificado_modelo}" alt="" class="img-polaroid" />
                                    </p>
                                    {/if}
                           
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- FIM MODELO -->

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