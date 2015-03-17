   <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
            
        </ul>
        
        <div class="pageheader">    
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->

            <div class="pageicon"><span class="iconfa-money"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Parceiros</h5>
                <h1>Repasses Financeiros</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                  
                <table class="table table-bordered" id="dyntable">
                    <thead>
                        <th>Nome do Parceiro</th>
                        <th class="center">Mês Faturado</th>
                        <th class="center">Data do Pagamento</th>
                        <th class="center">Valor</th>
                        <th class="center">Status</th>
                        <th class="center">Comprovante</th>
                        <th>Observações</th>
                    </thead>

                    <tbody>
                        {foreach item=comprovante from=$comprovantes}
                        <tr>
                            <td>{$comprovante.parceiro.nome}</td>
                            <td class="center">{$comprovante.mes} de {$comprovante.ano}</td>
                            <td class="center">
                                {if $comprovante.enviado == 1}
                                {$comprovante.data_envio|date_format:"%d/%m/%Y"}
                                {/if}
                            </td>
                            <td class="center"><strong>R$ {$comprovante.preco}</strong></td>
                            <td class="center"> 
                                {if $comprovante.enviado == 1}
                                    <span class="label label-success"><i class="iconfa-ok"></i> Pago</span></span>
                                {else}
                                    <span class="label label-warning"><i class="iconfa-warning-sign"></i> Aguardando pagamento</span></span>
                                {/if}
                            </td>
                            <td class="center">
                                {if $comprovante.enviado == 1}
                                <ul class="tooltipsample">
                                    <li><a href="/lms/administrador-geral/parceiros/downloadComprovante/{$comprovante.id}" target="_blank" class="btn btn-warning"  data-placement="bottom" data-rel="tooltip" data-original-title="Comprovante de Pagamento"><i class="iconfa-upload-alt"></i></a></li>
                                </ul>
                                {/if}
                            </td>
                            <td>{$comprovante.observacao}</td>
                        </tr>
                        {/foreach}
                    </tbody>    

                </table>

                
                <div class="footer"></div><!--footer-->
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->