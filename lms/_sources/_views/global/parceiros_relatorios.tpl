<script type="text/javascript" src="/lms/common/js/admin/parceiros.js"></script>
<script type="text/javascript">
{literal}
jQuery(document).ready(function(){
{/literal}
    carregaDadosVendaPorDia('{$categoria}', '{$data1}', '{$data2}');
    carregaDadosVendaPorMes('{$categoria}', '{$mes}', '{$ano}');
    carregaDadosVendaMaisVendidos('{$categoria}', '{$data1}', '{$data2}');
    carregaDadosVendaTopConsumidores('{$categoria}', '{$mes}', '{$ano}');
    carregaDadosVendaPorCategorias('{$categoria}', '{$mes}', '{$ano}', jQuery('.vendas_por_categorias_categoria').val());
    carregaDadosVendaCupons('{$categoria}', '{$data1}', '{$data2}');
{literal}
});
{/literal}
</script>
<div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
            
        </ul>
        
        <div class="pageheader">
            {include file="$categoria/busca_topo.tpl"}
            <div class="pageicon"><span class="iconfa-bar-chart"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Vendas</h5>
                <h1>Relatório de Vendas</h1>
            </div>
        </div><!--pageheader-->
            
        <div class="maincontent">
            <div class="maincontentinner">
                
                <a href="{$url_base}/lms/{$categoria}/vendas/fecharRelatorio" class="btn btn-warning btn-large" data-toggle="modal"><i class="iconfa-bar-chart"></i> Fechar relatório do mês</a><br /><br />

                <div class="tabbedwidget tab-primary">

                    <ul>
                                
                        <li><a href="#a-1">Vendas</a></li>

                    </ul>

                    <div id="a-1">

                       
                            <div class="tabs-left">

                              <ul class="nav nav-tabs">

                                  <li class="active"><a data-toggle="tab" href="#rA">Visão Geral</a></li>
                                  <li><a data-toggle="tab" href="#rB">Vendas por Dia</a></li>
                                  <li><a data-toggle="tab" href="#rC">Vendas por Mês</a></li>
                                  <li><a data-toggle="tab" href="#rD">Vendas por Produtos</a></li>
                                  <li><a data-toggle="tab" href="#rE">Mais Vendidos</a></li>
                                  <li><a data-toggle="tab" href="#rF">Top Consumidores</a></li>
                                  <li><a data-toggle="tab" href="#rG">Vendas por Categorias</a></li>
                                  <li><a data-toggle="tab" href="#rH">Relatório de Assinaturas</a></li>

                              </ul>

                            <div class="tab-content">

                                <div id="rA" class="tab-pane active">

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

                                                    <h3 style="text-align:center;">{$total_pedidos} <strong>({$total_pedidos} Itens)</strong></h3>

                                                </div>
                                                
                                            </div>

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Média Total de Vendas</h4>

                                                <div class="widgetcontent">

                                                    <h3 style="text-align:center;">R$ {$media_vendas}</h3>

                                                </div>
                                                
                                            </div>

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Descontos Usados</h4>

                                                <div class="widgetcontent">

                                                    <h3 style="text-align:center;">R$ {$descontos_usados}</h3>

                                                </div>
                                                
                                            </div>

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Total retornar</h4>

                                                <div class="widgetcontent">

                                                    <h3 style="text-align:center;">R$ {$total_retornar}</h3>

                                                </div>
                                                
                                            </div>

                                        </div><!--#span3-->

                                        <div class="span9">

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Últimas 10 Vendas</h4>

                                                <div class="widgetcontent">

                                                    <!--<h3 style="text-align:center;">n/a</h3>-->

                                                    <table class="table table-bordered">

                                                        <thead>

                                                            <th>#</th>
                                                            <th>Cliente</th>
                                                            <th>Cursos</th>
                                                            <th class="center">Total</th>

                                                        </thead>

                                                        <tbody>
															{foreach item=venda from=$ultimas_10_vendas}
                                                            <tr>

                                                                <td><a href="/lms/{$categoria}/vendas/detalhes/{$venda.id}">{$venda.numero}</a></td>
                                                                <td>{$venda.cliente.nome}</td>
                                                                <td>
																	{$venda.cursos}
																</td>
                                                                <td class="center">R$ {$venda.valor_total|number_format:2}</td>

                                                            </tr>
															{/foreach}
                                                        </tbody>

                                                    </table>

                                                    <a href="/lms/{$categoria}/vendas/todas/" class="btn btn-primary">Todas as Vendas</a>

                                                </div>
                                                
                                            </div>

                                        </div>

                                     </div><!--#row-fluid-->

                                </div>

                                <div id="rB" class="tab-pane">

                                    <div class="row-fluid">

                                      <form action="" method="get">

                                        <p style="float:left;">

                                          <span class="field">De: <input id="datepicker" type="text" name="data1" class="input-medium venda_dia_data1" /></span>

                                        </p>

                                        <p style="float:left; margin:0 10px;">

                                          <span class="field">Para: <input id="datepicker-2" type="text" name="data2" class="input-medium venda_dia_data2" /></span>

                                        </p>

                                        <p>

                                            <input type="button" onclick="javascript:carregaDadosVendaPorDia('{$categoria}', jQuery('.venda_dia_data1').val(), jQuery('.venda_dia_data2').val()); return false;" class="btn btn-primary" value="Mostrar">

                                        </p>

                                      </form>

                                    </div><!--#row-fluid-->

                                    <div class="row-fluid">

                                         <div class="span3">

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Total de Vendas</h4>

                                                <div class="widgetcontent">

                                                    <h3 style="text-align:center;" id="total_vendas_dia">R$ 00,00</h3>

                                                </div>

                                            </div>

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Total de Pedidos</h4>

                                                <div class="widgetcontent">

                                                    <h3 style="text-align:center;" id="total_pedidos_dia">0 <strong>(0 Item)</strong></h3>

                                                </div>
                                                
                                            </div>

                                        </div><!--#span3-->

                                        <div class="span9">

                                            <div class="widgetbox">

                                                <h4 class="widgettitle">Total de Vendas - <span id="dia_vendas_ate"></span></h4>

                                                <div class="widgetcontent">

                                                    <table class="table table-bordered">

                                                        <thead>

                                                            <th>#</th>
                                                            <th>Cliente</th>
                                                            <th>Cursos</th>
                                                            <th class="center">Total</th>

                                                        </thead>

                                                        <tbody id="tabela_vendas_dia">
                                                        </tbody>

                                                    </table>

                                                </div>
                                                
                                            </div>

                                        </div>

                                     </div><!--#row-fluid-->

                                </div>

                                <div id="rC" class="tab-pane">
                                    
                                    <form>

                                            <div class="row-fluid">

                                            <div class="span9">

                                                <label>Ano:</label>

                                                <span class="field">

                                                    <select name="vendas_por_mes_ano" id="vendas_por_mes_ano" class="vendas_por_mes_ano">

                                                        <option selected>Selecione o Ano</option>
                                                        {php}
                                                        for($i = 2013; $i <= date('Y'); $i++) {
                                                            echo '<option>'.$i.'</option>';
                                                        }
                                                        {/php}
                                                    </select>

                                                </span>

                                                <label>Mês:</label>

                                                <span class="field">

                                                    <select name="vendas_por_mes_mes" id="vendas_por_mes_mes" class="vendas_por_mes_mes">
                                                        <option selected>Selecione o Mês</option>
                                                        {php}
                                                        for($i = 1; $i <= 12; $i++) {
                                                            echo '<option>'.(($i < 10) ? '0' : '').$i.'</option>';
                                                        }
                                                        {/php}
                                                    </select>

                                                </span>

                                                <p>
                                                    <input type="button" onclick="javascript:carregaDadosVendaPorMes('{$categoria}', jQuery('.vendas_por_mes_mes').val(), jQuery('.vendas_por_mes_ano').val()); return false;" class="btn btn-primary" value="Mostrar">

                                                </p>

                                            </div>

                                            </div>

                                        </form>

                                        <br />

                                        <table class="table table-bordered">

                                            <thead>

                                                <th>#</th>
                                                <th>Cliente</th>
                                                <th>Cursos</th>
                                                <th class="center">Valor Total</th>

                                            </thead>

                                            <tbody id="tabela_vendas_mes">
                                            </tbody>

                                        </table>

                                </div>

                                <div id="rD" class="tab-pane">

                                  <div class="row-fluid">
                                    
                                    <div class="span12">

                                      <form action="">

                                        <p>
                                                                
                                          <span class="formwrapper">

                                            <select name="vendas_por_produto_curso_id" id="vendas_por_produto_curso_id" class="input-xxlarge vendas_por_produto_curso_id">
                                              <option value="" selectd>Selecione o Curso</option> 
                                              {foreach item=curso from=$cursos}
                                                <option value="{$curso.id}">{$curso.curso}</option>
                                              {/foreach}
                                            </select>

                                          </span>

                                        </p>
                                      
                                      
                                        <p>
                                            <input type="button" onclick="javascript:carregaDadosVendaPorProdutos('{$categoria}', jQuery('.vendas_por_produto_curso_id').val()); return false;" class="btn btn-primary" value="Mostrar">
                                        </p>

                                      </form>

                                      </div><!--.span12--> 
                                  
                                  </div><!--.row-fluid-->

                                  <div class="row-fluid">

                                      <div class="span12" id="tabela_vendas_por_produtos">

                                        

                                      </div><!--.span12-->

                                    </div><!--.row-fluid-->

                                </div>

                                <div id="rE" class="tab-pane">
                                    
                                    <div class="row-fluid">

                                      <form action="" method="get">

                                        <p style="float:left;">

                                          <span class="field">De: <input id="datepicker" type="text" name="date" class="input-medium venda_mais_vendido_data1" /></span>

                                        </p>

                                        <p style="float:left; margin:0 10px;">

                                          <span class="field">Para: <input id="datepicker-2" type="text" name="date" class="input-medium venda_mais_vendido_data2" /></span>

                                        </p>

                                        <p>

                                            <input type="button" onclick="javascript:carregaDadosVendaMaisVendidos('{$categoria}', jQuery('.venda_mais_vendido_data1').val(), jQuery('.venda_mais_vendido_data2').val()); return false;" class="btn btn-primary" value="Mostrar">

                                        </p>

                                      </form>

                                      </div><!--#row-fluid-->

                                  <div class="row-fluid">

                                      <div class="span12">

                                        <table class="table table-bordered">

                                            <thead>

                                                <th>Produto</th>
                                                <th class="center">Qtd de Vendas</th>
                                                <th class="center">Valor Total</th>

                                            </thead>

                                            <tbody id="tabela_vendas_por_mais_vendidos">
                                            </tbody>

                                        </table>

                                      </div><!--.span12-->

                                    </div><!--.row-fluid-->

                                </div>

                                <div id="rF" class="tab-pane">
                                    
                                    <form>

                                            <div class="row-fluid">

                                            <div class="span3">

                                                <label>Ano:</label>

                                                <span class="field">

                                                    <select name="vendas_top_consumidores_ano" id="vendas_top_consumidores_ano" class="vendas_top_consumidores_ano">

                                                        <option selected>Selecione o Ano</option>
                                                        {php}
                                                        for($i = 2013; $i <= date('Y'); $i++) {
                                                            echo '<option>'.$i.'</option>';
                                                        }
                                                        {/php}
                                                    </select>

                                                </span>

                                                <label>Mês:</label>

                                                <span class="field">

                                                    <select name="vendas_top_consumidores_mes" id="vendas_top_consumidores_mes" class="vendas_top_consumidores_mes">
                                                        <option selected>Selecione o Mês</option>
                                                        {php}
                                                        for($i = 1; $i <= 12; $i++) {
                                                            echo '<option>'.(($i < 10) ? '0' : '').$i.'</option>';
                                                        }
                                                        {/php}
                                                    </select>

                                                </span>

                                                <p>

                                                  <input type="button" onclick="javascript:carregaDadosVendaTopConsumidores('{$categoria}', jQuery('.vendas_top_consumidores_mes').val(), jQuery('.vendas_top_consumidores_ano').val()); return false;" class="btn btn-primary" value="Mostrar">

                                                </p>

                                            </div>

                                            </div>

                                        </form>

                                        <table class="table table-bordered">

                                            <thead>

                                                <th>Nome do Aluno</th>
                                                <th class="center">Nº de Compras</th>
                                                <th class="center">Cursos</th>
                                                <th class="center">Valor Total</th>

                                            </thead>

                                            <tbody id="tabela_vendas_top_consumidores">
                                            </tbody>

                                        </table>

                                </div>

                                <div id="rG" class="tab-pane">
                                    
                                    <form>

                                            <div class="row-fluid">

                                            <div class="span9">

                                                <label>Ano:</label>

                                                <span class="field">

                                                    <select name="vendas_por_categorias_ano" id="vendas_por_categorias_ano" class="vendas_por_categorias_ano">

                                                        <option selected>Selecione o Ano</option>
                                                        {php}
                                                        for($i = 2013; $i <= date('Y'); $i++) {
                                                            echo '<option>'.$i.'</option>';
                                                        }
                                                        {/php}
                                                    </select>

                                                </span>

                                                <label>Mês:</label>

                                                <span class="field">

                                                    <select name="vendas_por_categorias_mes" id="vendas_por_categorias_mes" class="vendas_por_categorias_mes">
                                                        <option selected>Selecione o Mês</option>
                                                        {php}
                                                        for($i = 1; $i <= 12; $i++) {
                                                            echo '<option>'.(($i < 10) ? '0' : '').$i.'</option>';
                                                        }
                                                        {/php}
                                                    </select>

                                                </span>

                                                <label>Categoria:</label>
                                                                
                                                <span class="field">

                                                  <select name="vendas_por_categorias_categoria" id="vendas_por_categorias_categoria" class="input-xxlarge vendas_por_categorias_categoria">

                                                    {foreach from=$categorias item=categoria_curso}
                                                        <option value="{$categoria_curso.id}">{$categoria_curso.categoria}</option>
                                                        {foreach from=$categoria_curso.filhas item=categoria_filha}
                                                            <option value="{$categoria_filha.id}">{$categoria_filha.categoria}</option>
                                                        {/foreach}
                                                    {/foreach}

                                                  </select>

                                                </span>

                                                <p>

                                                    <input type="button" onclick="javascript:carregaDadosVendaPorCategorias('{$categoria}', jQuery('.vendas_por_categorias_mes').val(), jQuery('.vendas_por_categorias_ano').val(), jQuery('.vendas_por_categorias_categoria').val()); return false;" class="btn btn-primary" value="Mostrar">

                                                </p>

                                            </div>

                                            <div class="span3">

                                                <div class="widgetbox">

                                                    <h4 class="widgettitle" style="text-align:center;">Categoria Mais Vendida</h4>

                                                    <div class="widgetcontent">

                                                        <h3 style="text-align:center;">{$nome_categoria_mais_vendida}</h3>
                                                        <h6 style="text-align:center;">R$ {$valor_categoria_mais_vendida}</h6>

                                                    </div>
                                                    
                                                </div>

                                            </div>

                                            </div>

                                        </form>

                                        <br />

                                        <table class="table table-bordered">

                                            <thead>

                                                <th>Nº do Pedido</th>
                                                <th>Cliente</th>
                                                <th>Cursos</th>
                                                <th class="center">Valor Total</th>

                                            </thead>

                                            <tbody id="tabela_vendas_por_categorias"></tbody>

                                        </table>

                                </div>

                                <div id="rH" class="tab-pane">
                                        
                                        <form>

                                            <div class="row-fluid">

                                            <div class="span3">

                                                <label>Tipo de Assinatura:</label>

                                                <span class="field">

                                                    <select>

                                                        <option selected>Selecione o Tipo</option>
                                                        <option>Ativas</option>
                                                        <option>Expiradas</option>

                                                    </select>

                                                </span>

                                                <label>Ano:</label>

                                                <span class="field">

                                                    <select>

                                                        <option selected>Selecione o Ano</option>
                                                        <option>2013</option>

                                                    </select>

                                                </span>

                                                <label>Mês:</label>

                                                <span class="field"> 

                                                    <select>

                                                        <option selected>Selecione o Mês</option>
                                                        <option>01</option>

                                                    </select>

                                                </span>

                                                <p>

                                                  <input type="submit" class="btn btn-primary" value="Mostrar">

                                                </p>

                                            </div>

                                            </div>

                                        </form>


                                        <strong>Se a opção escolhida for "Assinaturas Ativas", exibir essa tabela!</strong>

                                        <table class="table table-bordered">

                                            <thead>

                                                <th>Nome do Plano</th>
                                                <th class="center">Qtd de Assinantes</th>
                                                <th class="center">Total Mensal</th>

                                            </thead>

                                            <tbody>

                                                <tr>

                                                    <td>n/a</td>
                                                    <td class="center">n/a</td>
                                                    <td class="center">n/a</td>

                                                </tr>

                                            </tbody>

                                        </table>

                                        <strong>Se a opção escolhida for "Assinaturas Expiradas", exibir essa tabela!</strong>

                                        <table class="table table-bordered">

                                            <thead>

                                                <th>Nome do Aluno</th>
                                                <th>E-mail</th>
                                                <th>Nome do Plano</th>
                                                <th class="center">Data de Expiração</th>

                                            </thead>

                                            <tbody>

                                                <tr>

                                                    <td>n/a</td>
                                                    <td>n/a</td>
                                                    <td>n/a</td>
                                                    <td class="center">n/a</td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>

                            </div><!--tab-content-->

                        </div><!--tabbable tabs-left-->

                    </div>
                    
                </div><!--tabbedwidget--> 
                
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