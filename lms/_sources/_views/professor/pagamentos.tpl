    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/professor/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Professor</a> <span class="separator"></span></li>
            <li>Meus Pagamentos</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="professor/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-money"></span></div>
            <div class="pagetitle">
                <h5>Painel do Professor</h5>
                <h1>Meus Pagamentos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <table class="table table-bordered responsive" id="dyntable">

                    <thead>
                        <th class="center">Mês Faturado</th>
                        <th class="center">Data do Pagamento</th>
                        <th class="center">Valor</th>
                        <th class="center">Status</th>
                        <th class="center">Comprovante</th>
                        <th>Observações</th>
                    </thead>

                    <tbody>
                        {foreach item=pagamento from=$pagamentos}
                        <tr>

                            <td class="center">{$pagamento.periodo}</td>
                            <td class="center">
                                {if $pagamento.data_pagamento}
                                {$pagamento.data_pagamento|date_format:"%d/%m/%Y"}
                                {/if}
                            </td>
                            <td class="center"><strong>R$ {$pagamento.valor}</strong></td>
                            <td class="center">
                                {if $pagamento.status == 1}
                                <span class="label label-success"><i class="iconfa-ok"></i> Pago</span></span>
                                {elseif $pagamento.status == 0}
                                <span class="label label-warning"><i class="iconfa-warning-sign"></i> Aguardando Liberação</span></span>
                                {/if}
                            </td>
                            <td class="center">
                                {if $pagamento.comprovante}
                                <ul class="tooltipsample">
                                    <li><a href="/lms/professor/pagamentos/baixar/{$pagamento.id}" target="_blank" class="btn btn-warning"  data-placement="bottom" data-rel="tooltip" data-original-title="Comprovante de Pagamento"><i class="iconfa-upload-alt"></i></a></li>
                                </ul>
                                {/if}
                            </td>
                            <td>{$pagamento.observacoes}</td>
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
