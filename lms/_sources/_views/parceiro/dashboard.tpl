 
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.html"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel Parceiro</li>
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="parceiro/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h5>Resumo</h5>
                <h1>Painel Parceiro</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <div id="dashboard-left" class="span8">
                        
                        <h5 class="subtitle">Itens</h5>
                        <ul class="shortcuts">
                            <li class="help">
                                <a href="/lms/parceiro/alunos/listar">
                                    <span class="shortcuts-icon iconsi-profile"></span>
                                    <span class="shortcuts-label">Ger. Alunos</span>
                                </a>
                            </li>
                            <li class="archive">
                                <a href="/lms/parceiro/vendas/pedidos">
                                    <span class="shortcuts-icon iconsi-quiz"></span>
                                    <span class="shortcuts-label">Ger. Vendas</span>
                                </a>
                            </li>
                            
                            <li class="products">
                                <a href="/lms/parceiro/vendas/nova">
                                    <span class="shortcuts-icon iconsi-cart"></span>
                                    <span class="shortcuts-label">Fazer Venda</span>
                                </a>
                            </li>                
                            <li class="last lancamentos">
                                <a href="/lms/parceiro/parceiros/relatorio">
                                    <span class="shortcuts-icon iconsi-static"></span>
                                    <span class="shortcuts-label">Rel. de Vendas</span>
                                </a>
                            </li>
                        </ul>
                        
                        <br />
                        
                        <h5 class="subtitle">Últimas Vendas</h5><br />
                        
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome do Curso</th>
                                    <th>Nome do Aluno</th>
                                    <th class="center">Realizado em</th>
                                    <th class="center">Total do Pedido</th>
                                    <th class="center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach item=venda from=$ultimas_10_vendas}
                                <tr>
                                    <td>{$venda.numero}</td>
                                    <td>{$venda.cursos}</td>
                                    <td>{$venda.cliente.nome}</td>
                                    <td>{$venda.data_venda|date_format:"%d/%m/%Y"}</td>
                                    <td class="center">R$ {$venda.valor_total|number_format:2}</td>
                                    <td class="center">
                                        {if $venda.status == 0}
                                        <span class="label label-info"><i class="iconfa-calendar"></i> Aguardando Pagamento</span>
                                        {elseif $venda.status == 1}
                                        <span class="label label-success"><i class="iconfa-ok"></i> Pago</span>
                                        {elseif $venda.status == 2}
                                        <span class="label label-important"><i class="iconfa-remove"></i>Cancelado</span>
                                        {/if}
                                    </td>
                                </tr>
                                {/foreach}
                            </tbody>
                        </table>                      
                        
                    </div><!--span8-->
                    
                    <div id="dashboard-right" class="span4">
                        
                        <h5 class="subtitle">ÚLTIMA NOTIFICAÇÃO</h5>
                        
                        <div class="divider15"></div>
                        
                        {if !empty($ultimaNotificacao)}
                        <div class="alert alert-block">
                              <button data-dismiss="alert" class="close" type="button">&times;</button>
                              <h4>{$ultimaNotificacao.titulo}</h4>
                              <p style="margin: 8px 0">{$ultimaNotificacao.conteudo}</p>
                        </div><!--alert-->
                        {/if}

                        
                       
                        
                        <br />
                                                
                    </div><!--span4-->
                </div><!--row-fluid-->
                
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