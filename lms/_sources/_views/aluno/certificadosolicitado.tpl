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
                
                <div class="alert alert-success alert-block">

                    <button data-dismiss="alert" class="close" type="button">&times;</button>
                    <h4>Solicitação Realizada!</h4>
                    <p style="margin: 8px 0">Certificado Solicitado!</p>

                </div><!--alert-->
                
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
