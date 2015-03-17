 
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/aluno/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Aluno</a> <span class="separator"></span></li>
            <li>Solicitar Certificado</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="aluno/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-certificate"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Solicitar Cerfiticado</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <div class="widget">
                <h4 class="widgettitle">Dados de Solicitação</h4>
                <div class="widgetcontent">
                
                    <div class="row-fluid">
                    
                        <div class="span6">
                        <form class="stdform" method="post" action="">
                                    
                                    <p>
                                        <label for="firstname">Curso</label>
                                        <div class="field"><strong>{$curso}</strong></div>
                                    </p>
                            
                                    <p>
                                        <label for="firstname">Professor</label>
                                        <div class="field"><strong>{$professor}</strong></div>
                                    </p>
                        
                                    <p>
                                        <label for="firstname">Carga Horária</label>
                                        <div class="field"><strong>{$carga} Horas</strong></div>
                                    </p>
                                    
                                    <p>
                                        <label for="firstname">E-mail do Aluno</label>
                                        <div class="field"><input type="text" name="firstname" id="firstname" class="input-xxlarge" value="{$email}" disabled="" /></div>
                                    </p>
                                
                                    <p>
                                        <label for="firstname">Nome do Aluno</label>
                                        <div class="field"><input type="text" name="firstname" id="firstname" class="input-xxlarge" value="{$aluno}" disabled="" /></div>
                                    </p>
                                    
                                    <p>
                                        <label for="firstname">E-mail do Aluno</label>
                                        <div class="field"><input type="text" name="firstname" id="firstname" class="input-xxlarge" value="{$email}" disabled="" /></div>
                                    </p>

                                    <p>
                                        <label>Valor total: <h3>{$total}</h3></label>
                                    </p>

                                                                    
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary" onclick="realizarPagamento();return false;" id="botaoSolicitar">Solicitar Certificado</button>
                                    </p>
                               </form>

                       </div>
                      
                    </div>
                </div><!--widgetcontent-->
            </div><!--widget-->
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
<div id="retorno"></div>
<input id="urlPagSeguro" type="hidden" value=""/>

{literal}
<script type="text/javascript">
function realizarPagamento() {

    jQuery('#botaoSolicitar').attr('disabled', 'disabled');
    jQuery('#botaoSolicitar').html('Aguarde...');

    {/literal}
    jQuery.post('/lms/aluno/certificados/comprarcertificado/', {ldelim} id: {$matricula}, comprar: 1 {rdelim}, function html(html) {ldelim} jQuery('#retorno').html(html); {rdelim});
    {literal}


}

function alertPagSeguro() {
    jAlert('Você será direcionado para a página de pagamento', 'PagSeguro', function(){
        window.open(jQuery('#urlPagSeguro').val());
        window.location.href = '/lms/aluno/certificados/certificado-solicitado';
    });
}

</script>
{/literal}


