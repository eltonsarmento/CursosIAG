  
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/professor/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel do Professor</li>
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="professor/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h5>Resumo</h5>
                <h1>Painel do Professor</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <div id="dashboard-left" class="span8">
                        
                        <h5 class="subtitle">Itens</h5>
                        <ul class="shortcuts">
                            <li class="events">
                                <a href="/lms/professor/cursos/listar">
                                    <span class="shortcuts-icon iconsi-event"></span>
                                    <span class="shortcuts-label">Meus Cursos</span>
                                </a>
                            </li>
                            <li class="events">
                                <a href="/lms/professor/duvidas/listar">
                                    <span class="shortcuts-icon iconsi-questions"></span>
                                    <span class="shortcuts-label">Minhas Dúvidas</span>
                                </a>
                            </li>
                            <li class="products">
                                <a href="/lms/professor/pagamentos/listar">
                                    <span class="shortcuts-icon iconsi-cart"></span>
                                    <span class="shortcuts-label">Pagamentos</span>
                                </a>
                            </li>
                            <li class="archive">
                                <a href="/lms/professor/vendas/listar">
                                    <span class="shortcuts-icon iconsi-archive"></span>
                                    <span class="shortcuts-label">Minhas Vendas</span>
                                </a>
                            </li>
                            <li class="last lancamentos">
                                <a href="/lms/professor/quiz/listarCursos">
                                    <span class="shortcuts-icon iconsi-quiz"></span>
                                    <span class="shortcuts-label">Questionários</span>
                                </a>
                            </li>
                        </ul>
                        
                        <br />

                        <h5 class="subtitle">Assinaturas</h5><br />
                        
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th>Nome do Plano</th>
                                    <th class="center">Qtd de Assinantes</th>
                                    <th class="center">Total Mensal</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach from=$assinaturas key=$key item=assinatura}
                                <tr>
                                    <td>{$assinatura.plano}</td>
                                    <td class="center"><strong>{$assinatura.total}</strong></td>
                                    <td class="center"><strong>R$ {$assinatura.valor_total}</strong></td>
                                </tr>
                                {/foreach}
                            </tbody>

                        </table>
                        
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
                                {foreach item=venda from=$ultimas_5_vendas}
                                <tr>
                                    <td>{$venda.numero}</td>
                                    <td>{$venda.cursos}</td>
                                    <td>{$venda.cliente.nome}</td>
                                    <td class="center"><strong>{$venda.data_cadastro|date_format:"%d/%m/%Y"}</strong></td>
                                    <td class="center"><strong>R$ {$venda.valor_total}</strong></td>
                                    <td class="center">
                                        {if $venda.status == 0}
                                        <span class="label label-info"><i class="iconfa-calendar"></i> Aguardando Pagamento</span>
                                        {elseif $venda.status == 1}
                                        <span class="label label-success"><i class="iconfa-ok"></i> Aprovado</span>
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
                        
                        <div class="tabbedwidget tab-primary">
                            <ul>
                                <li><a href="#tabs-1"><span class="iconfa-question"></span> Últimas dúvidas</a></li>
                            </ul>
                            <div id="tabs-1" class="nopadding">
                                <h5 class="tabtitle">Dúvidas</h5>
                                <ul class="userlist">
                                    {foreach item=duvida from=$duvidas}
                                    <li>
                                        <div onclick="window.location.href='/lms/professor/duvidas/listar/{$duvida.id}'">
                                            <img src="/lms/uploads/avatar/{$duvida.aluno.avatar}" alt="" class="pull-left" />
                                            <div class="uinfo">
                                                <h5>{$duvida.aluno.nome}</h5>
                                                <span class="pos">{$duvida.curso.curso}</span>
                                                <span>{$duvida.titulo}</span>
                                            </div>
                                        </div>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                            
                        </div><!--tabbedwidget-->
                        
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
    
