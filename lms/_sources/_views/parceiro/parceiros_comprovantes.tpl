
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/parceiro/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel Parceiro</a> <span class="separator"></span></li>
            <li>Comprovantes Enviados</li>
            
            
        </ul>
        
        <div class="pageheader">
            {include file="parceiro/busca_topo.tpl"}
            <div class="pageicon"><span class="iconfa-signin"></span></div>
            <div class="pagetitle">
                <h5>Painel Parceiro</h5>
                <h1>Comprovantes Enviados</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <table class="table table-bordered">

                    <thead>

                        <th class="center">Mês</th>
                        <th class="center">Total</th>
                        <th>Observações</th>

                    </thead>

                    <tbody>
                        {foreach item=comprovante from=$comprovantes}
                        <tr>
                            <td class="center">{$comprovante.mes} ({$comprovante.ano})</td>
                            <td class="center"><strong>{$comprovante.preco}</strong></td>
                            <td>{$comprovante.observacao}</td>
                        </tr>
                        {/foreach}

                    </tbody>    

                </table>
                
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
