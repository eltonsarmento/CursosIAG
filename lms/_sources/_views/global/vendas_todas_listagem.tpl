    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel Administrativo</a> <span class="separator"></span></li>
            <li>Pedidos/Vendas</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Vendas</h5>
                <h1>Todas as Vendas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <table class="table table-bordered">

                    <thead>

                        <th>#</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Cursos</th>
                        <th class="center">Status</th>
                        <th class="center">Valor Total</th>
                        <th width="40">Ações</th>

                    </thead>

                    <tbody>
                        {foreach item=pedido key=k from=$pedidos} 
                        <tr>
                            <input type="hidden" id="nome_{$pedido.id}" value="{$pedido.cliente.nome}"/>
                            <input type="hidden" id="email_{$pedido.id}" value="{$pedido.cliente.email}"/>
                            <input type="hidden" id="aluno_{$pedido.id}" value="{$pedido.cliente.id}"/>
                            <td><a href="/lms/{$categoria}/vendas/detalhes/{$pedido.id}">{$pedido.numero}</a></td>
                            <td>{$pedido.cliente.nome}</td>
                            <td>{$pedido.cliente.email}</td>
							<td>
                            {foreach item=curso from=$pedido.cursos}
                                {$curso.curso} <br/>
                            {/foreach}
                            {if $pedido.plano.id}
                                {$pedido.plano.plano} <br/>
                            {/if}
                            {foreach item=certificado from=$pedido.certificados}
                                {$certificado.curso} <br/>
                            {/foreach}                     
                            </td>
                            <td class="center">
                                {if $pedido.status == 0}
                                    <span class="label label-info"><i class="iconfa-calendar"></i> Aguardando Pagamento</span>
                                {elseif $pedido.status == 1}
                                    <span class="label label-success"><i class="iconfa-ok"></i> Pago</span>
                                {else}
                                    <span class="label label-important"><i class="iconfa-remove"></i>Cancelado</span>   
                                {/if}
                                {if $pedido.excluido == 1}
                                    <br /><span class="label label-important"><i class="iconfa-remove"></i>Excluido</span>  
                                {/if}
                            </td>
                            <td class="center">R$ {$pedido.valor_total|number_format:2}</td>
                            <td>
                              <ul class="tooltipsample">
                                  <li><a href="#myModal" class="btn btn-primary" onclick="setarValores({$pedido.id})" data-toggle="modal" data-placement="bottom" data-rel="tooltip" data-original-title="Exibir Histórico"><i class="iconfa-search"></i></a></li>
                              </ul>
                            </td>
                        </tr>
                        {/foreach}

                    </tbody>    

                </table>

                 <!-- PAGINAÇÂO -->
                {$paginacao}
                <!--FIM PAGINAÇÃO -->
                
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


<!-- MODAL -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Dados Vendas</h3>
    </div>
    <div class="modal-body">

        <h6>Nome: <span id="modal_nome"></span></h6>
        <h6>E-mail: <span id="modal_email"></span></h6>
        
        <hr />

        <h4>Histórico</h4>

        <br />
        
        <div id="modal_tabela">
            
        </div>
                  
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div><!--#myModal-->
{literal}
<script type="text/javascript">

function setarValores(pedido) {
    jQuery('#modal_nome').html(jQuery('#nome_'+pedido).val());
    jQuery('#modal_email').html(jQuery('#email_'+pedido).val());

    jQuery.post('{/literal}{$url_site}{literal}/lms/{/literal}{$categoria}{literal}/vendas/buscarPorAluno', {aluno_id: jQuery('#aluno_'+pedido).val()}, function html(html) { jQuery('#modal_tabela').html(html)});
}

jQuery('#dyntable_vendas').dataTable({

    "sPaginationType": "full_numbers",
    "aaSorting": [[ 0, "desc" ]],
    "fnDrawCallback": function(oSettings) { 
    jQuery.uniform.update();
    }

});
{/literal}
</script>