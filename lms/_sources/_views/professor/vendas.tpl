    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/professor/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Professor</a> <span class="separator"></span></li>
            <li>Minhas Vendas</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="professor/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-shopping-cart"></span></div>
            <div class="pagetitle">
                <h5>Painel do Professor</h5>
                <h1>Minhas Vendas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <form action="" method="post">
                    <select name="ano">
                        <option selected>Selecione o Ano</option>
                        {php}
                        for($i = 2014; $i <= date('Y'); $i++) {
                            echo '<option>'.$i.'</option>';
                        }
                        {/php}
                    </select>

                    <select name="mes">
                        {php}
                        for($i = 1; $i <= 12; $i++) {
                            echo '<option>'.(($i < 10) ? '0' : '').$i.'</option>';
                        }
                        {/php}
                    </select>

                    <input type="submit" value="Filtrar" class="btn btn-primary">
                </form>
                <!-- <a href="#myModal" class="btn btn-success btn-large" data-toggle="modal"><i class="iconfa-list"></i> Gerar Relatório</a><br /><br /> -->
                <table class="table table-bordered responsive">
                    <thead>
                        <th>#</th>
                        <th>Curso</th>
                        <th>Cliente</th>
                        
                        <th class="center">Forma de Pgto</th>
                        <th class="center">Formato</th>
                        <th class="center">Data</th>
                        <th class="center">Porcentagem</th>
                        <th class="center">Taxa</th>
                        <th class="center">Cupom/Desconto<span style="color: #f00;">*</span></th>
                        <th class="center">Valor</th>
                        <th class="center">Total Bruto<span style="color: #f00;">*</span></th>
                        <th class="center">Total Líquido<span style="color: #f00;">*</span></th>
                    </thead>

                    <tbody>
                        {foreach item=venda from=$vendas}
                        <tr>
                            <td class="center">{$venda.numero}</td>
                            <td>{$venda.cursos}</td>
                            <td>{$venda.cliente.nome}</td>
                            <td class="center">{$venda.forma_pagamento}</td>
                            <td class="center">Curso Online</td>
                            <td class="center">{$venda.data_venda|date_format:"%d/%m/%Y"}</td>
                            <td class="center">{$comissaoPorcentagem}%</td>
                            <td class="center">R$ {$venda.valor_taxas}</td>
                            <td class="center">R$ {$venda.valor_desconto}</td>
                            <td class="center">R$ {$venda.valor_completo}</td>
                            <td class="center">R$ {$venda.valor_bruto}</td>
                            <td class="center">R$ {$venda.valor_liquido}</td>
                        </tr>
                        {/foreach}


                        <tr>

                            <td colspan="7"><strong class="right">Total por Mês:</strong></td>
                            <td><strong>R$ {$totalTaxas}</strong></td>
                            <td><strong>R$ {$totalCuponsDescontos}</strong></td>
                            <td><strong>R$ {$totalCompleto}</strong></td>
                            <td><strong>R$ {$totalBruto}</strong></td>
                            <td><strong>R$ {$totalLiquido}</strong></td>

                        </tr>

                    </tbody>    

                </table>

                <strong><span style="color: #f00;">*</span> Cupom:</strong> Valor do Cupom promocional | <strong><span style="color: #f00;">*</span> Total Bruto:</strong> Total já inputado os descontos e taxas, cupons, campanhas | <strong><span style="color: #f00;">*</span> Total Líquido:</strong> Total de repasse aos tutores <br />

                <small>As taxas são divididas pela quantidade de tutores na mesma venda</small><br /><br />

                <!-- <a href="#myModal" class="btn btn-success btn-large" data-toggle="modal"><i class="iconfa-list"></i> Gerar Relatório</a> -->
                
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
    
    <!-- MODAL RELATORIO -->
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h3 id="myModalLabel">Filtro de Relatório</h3>
        </div>
        <div class="modal-body">
            <h4>Opções de Exportação</h4>
            <form action="">

                <p class="margintop10">
                    <span class="formwrapper">
                        <input type="checkbox" name="check2" /> PDF
                        <input type="checkbox" name="check2" /> XLS
                        <input type="checkbox" name="check2" /> JPG
                    </span>
                </p>

                <h4 class="margintop10">Opcionais</h4>

                <p class="margintop10">
                    <span class="formwrapper">
                        <input type="checkbox" name="check2" /> Imposto Retido<br />
                    </span>
                </p>

                <h4 class="margintop10">Data</h4>

                <p class="margintop10">
                        <span class="formwrapper">
                            <span class="field"><input type="text" name="date" class="input-small" placeholder="06/05" /></span> a <span class="field"><input type="text" name="date" class="input-small" placeholder="06/06" /></span> 
                        </span>
                </p>

                <button class="btn btn-primary">Gerar Relatório</button>

            </form>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>
    </div>
