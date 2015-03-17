<div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h1>Vincular Aluno</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <a href="/lms/{$categoria}/alunos/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>

                <div class="row-fluid">
                    
                    <div class="span12">
                        <div class="widgetbox">
                            <h4 class="widgettitle">Informe o e-mail do aluno já cadastrado que gostaria de vincular a sua conta</h4>
                            <div class="widgetcontent">
                                
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="vincular"/>
                                    
                                    <!-- EMAIL -->
                                    <div class="par control-group">
                                        <label class="control-label" for="email">E-mail do Aluno *</label>
                                        <div class="controls"><input type="text" name="email" id="email" value="{$aluno.email}" class="input-xxlarge"/></div>
                                    </div>
                                    
                                    
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Vincular</button>
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
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

</script>  
{/literal}