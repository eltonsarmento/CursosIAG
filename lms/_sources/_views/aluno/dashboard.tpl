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
                <h5>Resumo</h5>
                <h1>Painel do Aluno</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <div id="dashboard-left" class="span8">
                        <!-- ITENS MENU -->
                        <h5 class="subtitle">Itens</h5>
                        <ul class="shortcuts">
                            <li class="events">
                                <a href="/lms/aluno/cursos/meus-cursos">
                                    <span class="shortcuts-icon iconsi-event"></span>
                                    <span class="shortcuts-label">Meus Cursos</span>
                                </a>
                            </li>
                            <li class="events">
                                <a href="/lms/aluno/duvidas/listar">
                                    <span class="shortcuts-icon iconsi-questions"></span>
                                    <span class="shortcuts-label">Minhas Dúvidas</span>
                                </a>
                            </li>
                            <li class="products">
                                <a href="/lms/aluno/assinaturas/listar">
                                    <span class="shortcuts-icon iconsi-cart"></span>
                                    <span class="shortcuts-label">Assinaturas</span>
                                </a>
                            </li>
                            <li class="archive">
                                <a href="/lms/aluno/pedidos/listar">
                                    <span class="shortcuts-icon iconsi-archive"></span>
                                    <span class="shortcuts-label">Pedidos</span>
                                </a>
                            </li>
                            <li class="help">
                                <a href="/lms/aluno/certificados/listar">
                                    <span class="shortcuts-icon iconsi-help"></span>
                                    <span class="shortcuts-label">Certificados</span>
                                </a>
                            </li>
                            <li class="help">
                                <a href="/lms/aluno/perfil/editar">
                                    <span class="shortcuts-icon iconsi-profile"></span>
                                    <span class="shortcuts-label">Perfil</span>
                                </a>
                            </li>
                            <li class="last lancamentos">
                                <a href="/lms/aluno/estatisticas/listar">
                                    <span class="shortcuts-icon iconsi-static"></span>
                                    <span class="shortcuts-label">Estatísticas</span>
                                </a>
                            </li>
                            <li class="events">
                                <a href="/lms/aluno/empreendedor/listar">
                                    <span class="shortcuts-icon iconsi-quiz" style="padding: 30px 0 5px 0;"></span>
                                    <span class="shortcuts-label" style="line-height: 16px;">Canto do Empreendedor</span>
                                </a>
                            </li>
                        </ul>
                        
                        <br />
                        
                        <h5 class="subtitle">Estatísticas de desempenho</h5><br />
                        <!-- GRAFICO -->
                        <!-- <div id="chart_div" style="width: 850px; height: 300px;"></div> -->
                        
                        
                        <div class="divider30"></div>
                        
                        <!-- TABELA COM ANDAMENTO DOS CURSOS -->
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th class="head1">Curso</th>
                                    <th class="head0">Percentual concluído</th>
                                    <th class="head1">Certificado emitido</th>
                                    <th class="head0">Expira em</th>
                                    <th class="head1">Retomar curso</th>
                                </tr>
                            </thead>
                            <tbody>
                            {foreach item=curso from=$cursos_adquiridos}
                                <tr>
                                    <td>{$curso.curso}</td>
                                    <td class="center">
                                    <div class="progress progress-warning progress-striped active">
                                        <div style="width: {math equation="(( x / y ) * z )" x=$curso.aulas_assistidas y=$curso.aulas_total z=100}%" class="bar"></div>
                                    </div><!--progress-->
                                    </td>
                                    <td class="center">{if $curso.certificado_emitido == 1} Sim {else} Não {/if}</td>
                                    <td class="center">{$curso.expira|date_format:"%d/%m/%Y"}</td>
                                    <td class="center"><a href="/lms/aluno/cursos/verCurso/{$curso.id}" class="btn btn-warning"><span class="iconfa-repeat"></span> Retomar</a></td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>                      
                        
                    </div><!--span8-->
                    
                    <!-- LATERAL -->
                    <div id="dashboard-right" class="span4">
                        
                        <!-- ULTIMAS NOTIFICAÇÔES -->
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
                        
                        <!-- ULTIMOS LANÇAMENTOS -->
                        <h5 class="subtitle">ÚLTIMO LANÇAMENTO</h5>
                            
                        <div class="divider15"></div>
                        
                        <div class="widgetbox">                        
                        <div class="headtitle">
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn dropdown-toggle">Informações <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                  <li><a href="{$url_site}curso/{$cursoDestaque.url}" target="_blank">Ver Curso</a></li>
                                  <li><a href="{$url_site}" target="_blank">Mais Lançamentos</a></li>
                                </ul>
                            </div>
                            <h4 class="widgettitle">{$cursoDestaque.curso}</h4>
                        </div>
                        <div class="widgetcontent">
                            {$cursoDestaque.descricao}
                        </div><!--widgetcontent-->
                        </div><!--widgetbox-->
                        
                        <!-- DUVIDAS E PEDIDOS -->
                        <div class="tabbedwidget tab-primary">
                            <ul>
                                <li><a href="#tabs-1"><span class="iconfa-question"></span> Últimas dúvidas</a></li>
                                <li><a href="#tabs-2"><span class="iconfa-shopping-cart"></span> Últimos pedidos</a></li>
                                <li><a href="#tabs-3"><span class="iconfa-certificate"></span> Últimos certificados</a></li>
                            </ul>
                            <div id="tabs-1" class="nopadding">
                                <h5 class="tabtitle">Dúvidas</h5>
                                <ul class="userlist">
                                    {foreach item=duvida from=$duvidas}
                                    <li>
                                        <div>
                                            <img src="/lms/uploads/avatar/{$duvida.professor.avatar}" alt="" class="pull-left" />
                                            <div class="uinfo">
                                                <h5>{$duvida.professor.nome}</h5>
                                                <span class="pos">{$duvida.curso.curso}</span>
                                                <span>{$duvida.titulo}</span>
                                            </div>
                                        </div>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                            <div id="tabs-2" class="nopadding">
                                <h5 class="tabtitle">Pedidos</h5>
                                <ul class="userlist userlist-favorites">
                                    {foreach item=venda from=$ultimasVendas}
                                    <li>
                                        <div>
                                            <div class="uinfo">
                                                <a href="{$url_site}lms/aluno/pedidos/detalhe/{$venda.id}">
                                                    <h5>
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
                                                    </h5>
                                                </a>
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

{literal}
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Cursos', 'Aulas Assistidas'],
{/literal}
    {foreach item=curso from=$cursos_adquiridos}
          ['{$curso.curso}',  {$curso.aulas_assistidas}],
    {/foreach}
{literal}   
        ]);

        var options = {
          title: 'Acompanhamento das aulas',
          vAxis: {title: 'Cursos',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
{/literal}