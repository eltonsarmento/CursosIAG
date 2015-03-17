    <div class="rightpanel">
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Configurações de Imagens</li>  
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Configurações de Imagens</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <div class="row-fluid">
                    <!-- IMAGEM DESTACADA -->
                    <div class="span6">
                        <div class="widget">
                            <h4 class="widgettitle">Imagem Destacada</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="editarDestacada"/>
                                    <p>
                                        <label>Largura:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="imagem_destacada_largura" class="span12" value="{$destacada.imagem_destacada_largura}" placeholder="em pixels" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Altura:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="imagem_destacada_altura" value="{$destacada.imagem_destacada_altura}" class="span12" placeholder="em pixels" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Tamanho:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="imagem_destacada_tamanho" value="{$destacada.imagem_destacada_tamanho}" class="input-small" /></span>

                                    </p>

                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                    </p>
                       
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- FIM IMAGEM DESTACADA -->

                    <!-- IMAGEM BANNER -->
                    <div class="span6">
                        <div class="widget">
                            <h4 class="widgettitle">Imagem Banner</h4>
                            <div class="widgetcontent">
                
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="editarBanner"/>
                                    <p>
                                        <label>Largura:</label>
                                            <span class="formwrapper">
                                            <input type="text" name="imagem_banner_largura" value="{$banner.imagem_banner_largura}" class="span12" placeholder="em pixels" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Altura:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="imagem_banner_altura" class="span12" value="{$banner.imagem_banner_altura}" placeholder="em pixels" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Tamanho:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="imagem_banner_tamanho" value="{$banner.imagem_banner_tamanho}" class="input-small" />
                                        </span>

                                    </p>
                           
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- FM IMAGEM BANNER -->
                </div>

                <div class="row-fluid">
                    <!-- IMAGEM PERFIL -->
                    <div class="span6">

                        <div class="widget">
                            <h4 class="widgettitle">Imagem Perfil</h4>
                            <div class="widgetcontent">
                
                                <form class="stdform" method="post" action="">
                                <input type="hidden" value="1" name="editarPerfil"/>
                                    <p>
                                        <label>Largura:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="imagem_perfil_largura" class="span12" value="{$perfil.imagem_perfil_largura}" placeholder="em pixels" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Altura:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="imagem_perfil_altura" value="{$perfil.imagem_perfil_altura}" class="span12" placeholder="em pixels" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Tamanho:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="imagem_perfil_tamanho" value="{$perfil.imagem_perfil_tamanho}" class="input-small"/>
                                        </span>
                                    </p>
                                                           
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>  
                    <!-- FIM IMAGEM PERFIL -->
            
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