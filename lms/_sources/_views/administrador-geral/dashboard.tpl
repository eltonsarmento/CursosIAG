    <div class="rightpanel">
    
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
             <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Resumo</h5>
                <h1>Painel do Administrador Geral</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <div id="dashboard-left" class="span8">
                        
                        <h5 class="subtitle">Itens</h5>
                        <ul class="shortcuts">
                            <li class="help">
                                <a href="/lms/administrador-geral/alunos/listar">
                                    <span class="shortcuts-icon iconsi-users"></span>
                                    <span class="shortcuts-label">Ger. Alunos</span>
                                </a>
                            </li>
                            
                            <li class="events">
                                <a href="/lms/administrador-geral/certificados/relatorio">
                                    <span class="shortcuts-icon iconsi-help"></span>
                                    <span class="shortcuts-label">Ger. Certificados</span>
                                </a>
                            </li>
                            
                            <li class="events">
                                <a href="/lms/administrador-geral/professores/listar">
                                    <span class="shortcuts-icon iconsi-profile"></span>
                                    <span class="shortcuts-label">Ger. Professores</span>
                                </a>
                            </li>
                            
                            <li class="events">
                                <a href="/lms/administrador-geral/parceiros/listar">
                                    <span class="shortcuts-icon iconsi-quiz"></span>
                                    <span class="shortcuts-label">Ger. Parceiros</span>
                                </a>
                            </li>
                            
                            <li class="archive">
                                <a href="/lms/administrador-geral/administrativos/listar">
                                    <span class="shortcuts-icon iconsi-profile"></span>
                                    <span class="shortcuts-label">Ger. Usuários</span>
                                </a>
                            </li>
                            
                            <li class="events">
                                <a href="/lms/administrador-geral/curso/listar">
                                    <span class="shortcuts-icon iconsi-event"></span>
                                    <span class="shortcuts-label">Ger. Cursos</span>
                                </a>
                            </li>

                            <li class="events">
                                <a href="/lms/administrador-geral/empreendedor/listar">
                                    <span class="shortcuts-icon iconsi-quiz" style="padding: 30px 0 5px 0;"></span>
                                    <span class="shortcuts-label" style="line-height: 16px;">Canto do Empreendedor</span>
                                </a>
                            </li>
                            
                            <li class="archive">
                                <a href="/lms/administrador-geral/planos/listar">
                                    <span class="shortcuts-icon iconsi-archive"></span>
                                    <span class="shortcuts-label">Ger. Planos</span>
                                </a>
                            </li>
                            
                            <li class="last lancamentos">
                                <a href="/lms/administrador-geral/vendas/relatorio">
                                    <span class="shortcuts-icon iconsi-static"></span>
                                    <span class="shortcuts-label">Ger. Vendas</span>
                                </a>
                            </li>
                            
                            <li class="help">
                                <a href="/lms/administrador-geral/notificacoesadmin/listar">
                                    <span class="shortcuts-icon iconsi-questions"></span>
                                    <span class="shortcuts-label">Ger. Notificações</span>
                                </a>
                            </li>
                            
                            <li class="archive">
                                <a href="/lms/administrador-geral/administradores/listar">
                                    <span class="shortcuts-icon iconsi-profile"></span>
                                    <span class="shortcuts-label">Administradores</span>
                                </a>
                            </li>

                            <li class="help">
                                <a href="/lms/administrador-geral/coordenadores/listar">
                                    <span class="shortcuts-icon iconsi-users"></span>
                                    <span class="shortcuts-label">Coordenadores</span>
                                </a>
                            </li>

                            <li class="last lancamentos">
                                <a href="/lms/administrador-geral/configuracoesgerais/produtos">
                                    <span class="shortcuts-icon iconsi-geral"></span>
                                    <span class="shortcuts-label">Conf. Gerais</span>
                                </a>
                            </li>
                            
                        </ul>
                        
                        
                        <br />
                        
                        <div class="row-fluid">

                                         <div class="span3">

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Total de Vendas</h4>

                                                <div class="widgetcontent">

                                                    <h3 style="text-align:center;">R$ {$total_vendas}</h3>

                                                </div>

                                            </div>

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Total de Pedidos</h4>

                                                <div class="widgetcontent">

                                                    <h3 style="text-align:center;">{$total_pedidos} <strong>({$total_itens_pedidos} Itens)</strong></h3>

                                                </div>
                                                
                                            </div>

                                        </div><!--#span3-->

                                        <div class="span9">

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Últimas 10 Vendas</h4>

                                                <div class="widgetcontent">

                                                    <table class="table table-bordered">

                                                        <thead>

                                                            <th>#</th>
                                                            <th>Cliente</th>
                                                            <th>Cursos</th>
                                                            <th class="center">Total</th>

                                                        </thead>

                                                        <tbody>
                                                            {foreach item=venda from=$ultimasVendas}
                                                            <tr>

                                                                <td><a href="/lms/administrador-geral/vendas/detalhes/{$venda.id}">{$venda.numero}</a></td>
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
                                                                <td class="center">R$ {$venda.valor_total|number_format:2}</td>

                                                            </tr>
                                                            {/foreach}
                                                        </tbody>

                                                    </table>

                                                </div>
                                                
                                            </div>

                                        </div>

                                     </div><!--#row-fluid-->
                        
                    </div><!--span8-->
                    
                    <div id="dashboard-right" class="span4">
                       
                         
                        <div class="tabbedwidget tab-primary">
                            <ul>
                                <li><a href="#tabs-1"><span class="iconfa-money"></span> Últimas Vendas</a></li>
                                <li><a href="#tabs-2"><span class="iconfa-certificate"></span> Últimos Certificados</a></li>
                            </ul>
                            <div id="tabs-1" class="nopadding">
                                <h5 class="tabtitle">Vendas</h5>
                                <ul class="userlist">
                                    {foreach item=venda from=$ultimasVendas}
                                    <li>
                                        <a href="/lms/administrador-geral/vendas/detalhes/{$venda.id}"><div>
                                            <img src="/lms/uploads/avatar/{$venda.cliente.avatar}" alt="" class="pull-left" />
                                            <div class="uinfo">
                                                <h5>{$venda.cliente.nome}</h5>
                                                <span class="pos">#{$venda.numero}</span>
                                                <span>R$ {$venda.valor_total|number_format:2}</span>
                                            </div>
                                        </div></a>
                                    </li>
                                    {/foreach}
                                    
                                </ul>
                            </div>
                            <div id="tabs-2" class="nopadding">
                                <h5 class="tabtitle">Certificados</h5>
                                <ul class="userlist">
                                    {foreach item=certificado from=$certificados}
                                    <li>
                                        <div>
                                            <img src="/lms/uploads/avatar/{$certificado.aluno.avatar}" alt="" class="pull-left" />
                                            <div class="uinfo">
                                                <h5>{$certificado.aluno.nome}</h5>
                                                <span class="pos">{$certificado.curso.curso}</span>
                                                <span>
                                                    {if $certificado.tipo_certificado == 1}
                                                        Digital
                                                    {else}
                                                        Impresso
                                                    {/if}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                        
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
