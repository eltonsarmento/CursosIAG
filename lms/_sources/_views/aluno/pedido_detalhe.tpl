    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/aluno/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel do Aluno</li>

        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="aluno/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Pedido: #{$venda.numero}</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
               
                <div class="row-fluid">

                    <div class="span12">

                        <div class="widgetbox">

                            <h4 class="widgettitle title-primary">Detalhamento</h4>

                            <div class="widgetcontent">
                               
                                <div class="row-fluid">
                                
                                    <div class="span6">


                                        <p>Aluno: <strong>{$aluno.nome}</strong></p>

                                        <p>E-mail: <strong>{$aluno.email}</strong></p>
                                        
                                        {if $venda.forma_pagamento == 1} 

                                        <p>Pagamento: <strong>PagSeguro</strong></p>
                                        
                                        {elseif $venda.forma_pagamento == 2}
                                           
                                        <p>Pagamento: <strong>Moip</strong></p>
                                            
                                        {elseif $venda.forma_pagamento == 3}
                                           
                                        <p>Pagamento: <strong>PayPal</strong></p>
                                            
                                        {elseif $venda.forma_pagamento == 4}
                                           
                                        <p>Pagamento: <strong>Depósito/Transferência</strong></p>
                                            
                                        {elseif $venda.forma_pagamento == 5}
                                           
                                        <p>Pagamento: <strong>Transferência Internacional</strong></p>
                                            
                                        {elseif $venda.forma_pagamento == 6}
                                           
                                        <p>Pagamento: <strong>Pagar.Me</strong></p>
                                            
                                        {else}

                                        {/if}
                                        
                                        {if $pagseguro.code}

                                        <p>Còdigo Pagseguro: <strong>{$pagseguro.code}</strong></p>
                                        
                                        {/if}
                                        
                                        {if $venda.codigo_rastreamento}
                                        
                                        <p>Código de Rastreamento: <a href="http://www2.correios.com.br/sistemas/rastreamento/" target="_blank">{$venda.codigo_rastreamento}</a></p>
                                        
                                        {/if}

                                    </div><!-- span6 -->

                                    <div class="span6">
                                        
                                        {if $venda.status == 0}
                                        
                                        <p>Status do Pedido: <span class="badge badge-info"><i class="iconfa-refresh"></i> Aguardando Pagamento</span></p>
                                        {elseif $venda.status == 1}
                                        
                                        
                                        <p>Status do Pedido: <span class="badge badge-success"><i class="iconfa-ok"></i> Pago</span></p>
                                        
                                        {elseif $venda.status == 2}
                                        
                                        <p>Status do Pedido: <span class="badge badge-default"><i class="iconfa-remove"></i> Cancelado</span></p>
                                        
                                        {/if}

                                        <p>Total do Pedido: <strong>R$ {$venda.valor}</strong></p>

                                        <p>Data da Compra: <strong>{$venda.data_cadastro|date_format:"%d/%m/%Y"}</strong></p>
                                        
                                        {if $venda.data_expiracao != '0000-00-00'}

                                        <p>Expira em: <span class="badge badge-important">{$venda.data_expiracao|date_format:"%d/%m/%Y"}</span></p>
                                        
                                        {/if}

                                    </div><!-- span6 -->
                                
                                </div><!-- row-fuild -->
                                
                                {if $venda.observacoes}
                                
                                <div class="row-fluid">
                                                                        
                                    <div class="span12">

                                        <p>Observações: <strong>{$venda.observacoes}</strong></p>
                                        
                                    </div><!-- span12 -->
                                    
                                </div><!-- row-fluid -->
                                
                                {/if}

                            </div><!-- widgetcontent -->

                        </div><!-- widgetbox -->

                    </div><!-- span12 -->

                </div><!-- row-fuild -->

                <table class="table table-bordered">

                    <thead>
                        <th>Curso/Plano</th>
                        <th class="center">Valor R$</th>
                        <th class="center">Certificado</th>
                    </thead>

                    <tbody>
                        {foreach item=curso from=$venda.cursos}
                        <tr>
                            <td>{$curso.curso}</td>
                            <td class="center">R$ {$curso.valor}</td>
                            <td class="center">
                                {if $curso.certificado_adquirido}
                                    Impresso
                                {else}
                                    Digital
                                {/if}
                            </td>
                        </tr>
                        {/foreach}

                        {if $venda.plano}
                        <tr>
                            <td>{$venda.plano.plano}</td>
                            <td class="center">R$ {$venda.plano.valor}</td>
                            <td class="center">
                                Digital
                            </td>
                        </tr>
                        {/if}

                        {foreach item=certificado from=$venda.certificados}
                        <tr>
                            <td>{$certificado.curso}</td>
                            <td class="center">R$ {$venda.valor}</td>
                            <td class="center">
                                Impresso
                            </td>
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
    
</div><!--mainwrapper-->
