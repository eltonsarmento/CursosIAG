
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel Administrativo</a> <span class="separator"></span></li>
            <li>Relatórios de Cupons</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Painel Administrativo</h5>
                <h1>Relatórios de Cupons</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <table class="table table-bordered" id="dyntable">

                    <thead>
                        
                        <th>Nome do Cupom</th>
                        <th class="center">Qtd. de utilizações</th>
                        <th class="center">Usado em</th>
                        <th class="center">Tipo do cupom</th>
                        <th class="center">Status do cupom</th>


                    </thead>

                    <tbody>
                        {foreach item=cupom from=$cupons}
                        <tr>

                            <td>{$cupom.nome}</td>
                            <td class="center">{$cupom.total} <strong>vez(es)</strong></td>
                            <td class="center"><strong>{$cupom.data_cadastro|date_format:"%d/%m/%Y"}</strong></td>
                            <td class="center">
                                {if $cupom.tipo eq 1}
                                Único
                                {elseif $cupom.tipo eq 2}
                                Intervalo de Tempo
                                {elseif $cupom.tipo eq 3}
                                Quantidade
                                {elseif $cupom.tipo eq 4}
                                Indeterminado
                                {/if}
                            </td>
                            <td class="center">
                                {if $cupom.ativo eq 0}
                                <span class="label label-important"><i class="iconfa-remove"></i> Inativo</span>
                                {elseif $cupom.ativo eq 1}
                                <span class="label label-success"><i class="iconfa-ok"></i> Ativo</span>
                                {elseif $cupom.ativo eq 2}
                                <span class="label label-warning"><i class="iconfa-minus"></i> Usado</span>
                                {elseif $cupom.ativo eq 3}
                                <span class="label label-info"><i class="iconfa-calendar"></i> Futuro</span>
                                {/if}
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
