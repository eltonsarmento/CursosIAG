    <div class="rightpanel">
    
        <ul class="breadcrumbs">
            <li><a href="/lms/administrativo/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel Administrativo</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrativo/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h5>Resumo</h5>
                <h1>Painel Administrativo</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <div id="dashboard-left" class="span8">
                        
                        <h5 class="subtitle">Itens</h5>
                        
                        <ul class="shortcuts">
                            <li class="archive">
                                <a href="/lms/administrativo/vendas/pedidos">
                                    <span class="shortcuts-icon iconsi-archive"></span>
                                    <span class="shortcuts-label">Pedidos/Vendas</span>
                                </a>
                            </li>
                            <li class="help">
                                <a href="/lms/administrativo/alunos/listar">
                                    <span class="shortcuts-icon iconsi-profile"></span>
                                    <span class="shortcuts-label">Consultar Alunos</span>
                                </a>
                            </li>
                            <li class="products">
                                <a href="/lms/administrativo/certificados/relatorio">
                                    <span class="shortcuts-icon iconsi-help"></span>
                                    <span class="shortcuts-label">Ger. Certificados</span>
                                </a>
                            </li>
                            <li class="events">
                                <a href="/lms/administrativo/cupons/listar">
                                    <span class="shortcuts-icon iconsi-event"></span>
                                    <span class="shortcuts-label">Ger. Cupons</span>
                                </a>
                            </li>
                    
                            
                            <li class="last lancamentos">
                                <a href="/lms/administrativo/cupons/relatorio">
                                    <span class="shortcuts-icon iconsi-static"></span>
                                    <span class="shortcuts-label">Rel. Cupons</span>
                                </a>
                            </li>
                        </ul>
                        
                        <br />
                        
                        <h5 class="subtitle">Últimas Vendas</h5><br />
                        
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome do Aluno</th>
                                    <th>Nome do Curso</th>
                                    <th class="center">Realizado em</th>
                                    <th class="center">Total do Pedido</th>
                                    <th class="center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach item=venda from=$ultimasVendas}
                                    <tr>
                                        <td>{$venda.numero}</td>
                                        <td>{$venda.cliente.nome}</td>
                                        <td>
                                            {if !empty($venda.cursos)}
                                                {foreach item=curso from=$venda.cursos}
                                                    {$curso.curso}<br/>
                                                {/foreach}
                                            {/if}
                                            {if !empty($venda.certificados)}
                                                {foreach item=certificado from=$venda.certificados}
                                                    {$certificado.curso}<br/>
                                                {/foreach}
                                            {/if}
                                            {if !empty($venda.plano)}
                                                {$venda.plano.plano}
                                            {/if}
                                        </td>
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
                              <p style="margin: 8px 0">{$ultimaNotificacao.conteudo|substr:0:200}...</p>
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
{literal}
<script type="text/javascript">
    jQuery(document).ready(function() {
        // tabbed widget
        jQuery('.tabbedwidget').tabs();
    });
</script>
{/literal}