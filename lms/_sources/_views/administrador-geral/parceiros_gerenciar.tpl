
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
                <h5>Gerenciar Parceiros</h5>
                <h1>Todos os Parceiros</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <a href="/lms/administrador-geral/parceiros/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVO PARCEIRO</a>

                <table class="table table-bordered" id="dyntable">
                                
                	<thead>
                        <tr>
							<th>Nome</th>
                                        <th>Contato</th>
                                        <th>E-mail</th>
                                        <th class="center">Cidade</th>
                                        <th class="center">Estado</th>
                                        <th class="center">CPF/CNPJ</th>
                                        <th class="center">Razão Social</th>
                                        <th width="135">Ações</th>
						</tr>
					</thead>
                    <tbody>
                    	{foreach item=parceiro key=k from=$parceiros}
						
                        <tr>
                            <!-- DADOS MODAL -->
                            <input type="hidden" id="nome_{$k}" value="{$parceiro.nome}"/>
                            <input type="hidden" id="contato_{$k}" value="{$parceiro.contato}"/>
                            <input type="hidden" id="email_{$k}" value="{$parceiro.email}"/>
                            <input type="hidden" id="email_sec_{$k}" value="{$parceiro.email_secundario}"/>
                            
                            <input type="hidden" id="razao_social_{$k}" value="{$parceiro.razao_social}"/>
                            <input type="hidden" id="cpf_{$k}" value="{$parceiro.cpf}"/>
                            <input type="hidden" id="cnpj_{$k}" value="{$parceiro.cnpj}"/>
                            <input type="hidden" id="cep_{$k}" value="{$parceiro.cep}"/>
                            <input type="hidden" id="telefone_{$k}" value="{$parceiro.telefone}"/>
                            <input type="hidden" id="endereco_{$k}" value="{$parceiro.endereco}"/>
                            <input type="hidden" id="bairro_{$k}" value="{$parceiro.bairro}"/>
                            <input type="hidden" id="cidade_{$k}" value="{$parceiro.cidade}"/>
                            <input type="hidden" id="estado_{$k}" value="{$parceiro.estado}"/>
                            
                            <input type="hidden" id="banco1_{$k}" value="{$parceiro.banco1}"/>
                            <input type="hidden" id="agencia1_{$k}" value="{$parceiro.agencia1}"/>
                            <input type="hidden" id="conta1_{$k}" value="{$parceiro.conta1}"/>
                            <input type="hidden" id="tipoconta1_{$k}" value="{if $parceiro.tipoconta1 eq 1}Poupança{else}Corrente{/if}"/>
                            <input type="hidden" id="operacao1_{$k}" value="{$parceiro.operacao1}"/>
                            <!-- FIM DADOS MODAL -->
                        	<td>{$parceiro.nome}</td>
							<td>{$parceiro.contato}</td>
                            <td>{$parceiro.email}</td>
							<td class="center">{$parceiro.cidade}</td>
							<td class="center">{$parceiro.estado}</td>
							<td class="center">{$parceiro.cpf}{if $parceiro.cpf && $parceiro.cnpj}/{/if}{$parceiro.cnpj}</td>
							<td class="center">{$parceiro.razao_social}</td>
                            <td width="90">
                                <ul class="tooltipsample">
									<li><a href="#myModal" onclick="setarValores({$k});" class="btn btn-primary" data-toggle="modal" data-placement="bottom" data-rel="tooltip" data-original-title="Cadastro Completo"><i class="iconfa-search"></i></a></li>
                                    <li><a href="/lms/administrador-geral/parceiros/editar/{$parceiro.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Parceiro"><i class="iconfa-pencil"></i></a></li>
                                    {if $parceiro.temCurso == false}
                                    <li><a  href="javascript:;" onclick="javascript:deletar({$parceiro.id})" class="btn btn-primary confirmbutton" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Parceiro"><i class="iconfa-remove"></i></a></li>
                                    {/if}
                                </ul>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>

                <a href="/lms/administrador-geral/parceiros/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVO PARCEIRO</a>
            </div><!--maincontentinner-->
        </div><!--maincontent-->
    </div><!--rightpanel-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Dados Cadastrais</h3>
    </div>
    <div class="modal-body">
        
        <h4 id="modal_nome"></h4>
        <h4 id="modal_contato"></h4>
        <h6 id="modal_email"></h6>
        <h6 id="modal_email_sec"></h6>
        
        <hr />
        
        <p>Razão Social: <strong id="modal_razao_social"></strong></p>
        <p>CPF: <strong id="modal_cpf"></strong></p>
		<p>CNPJ: <strong id="modal_cnpj"></strong></p>
		
        <p>Cep: <strong id="modal_cep"></strong></p>
        <p>Endereço: <strong id="modal_endereco"></strong></p>
        <p>Bairro: <strong id="modal_bairro"></strong></p>
        <p>Cidade: <strong id="modal_cidade"></strong></p>
        <p>Estado: <strong id="modal_estado"></strong></p>
        
        <hr />
        
        <p>Banco: <strong id="modal_banco1"></strong></p>
        <p>Agência: <strong id="modal_agencia1"></strong></p>
        <p>Conta: <strong id="modal_conta1"></strong></p>
        <p>Tipo de Conta: <strong id="modal_tipoconta1"></strong></p>
        <p>Operação/Variação: <strong id="modal_operacao1"></strong></p>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>
{literal}
<script type="text/javascript">
function setarValores(parceiro) {
    jQuery("#modal_nome").html(jQuery("#nome_"+parceiro).val());
	jQuery("#modal_contato").html(jQuery("#contato_"+parceiro).val());
    jQuery("#modal_email").html(jQuery("#email_"+parceiro).val());
    jQuery("#modal_email_sec").html(jQuery("#email_sec_"+parceiro).val());
	
	jQuery("#modal_razao_social").html(jQuery("#razao_social_"+parceiro).val());
	jQuery("#modal_cpf").html(jQuery("#cpf_"+parceiro).val());
	jQuery("#modal_cnpj").html(jQuery("#cnpj_"+parceiro).val());
	jQuery("#modal_cep").html(jQuery("#cep_"+parceiro).val());
	jQuery("#modal_endereco").html(jQuery("#endereco_"+parceiro).val());
    jQuery("#modal_bairro").html(jQuery("#bairro_"+parceiro).val());
    jQuery("#modal_cidade").html(jQuery("#cidade_"+parceiro).val());
    jQuery("#modal_estado").html(jQuery("#estado_"+parceiro).val());
    
	jQuery("#modal_banco1").html(jQuery("#banco1_"+parceiro).val());
	jQuery("#modal_agencia1").html(jQuery("#agencia1_"+parceiro).val());
	jQuery("#modal_conta1").html(jQuery("#conta1_"+parceiro).val());
	jQuery("#modal_tipoconta1").html(jQuery("#tipoconta1_"+parceiro).val());
	jQuery("#modal_operacao1").html(jQuery("#operacao1_"+parceiro).val());
}

jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function deletar(id) {
    jConfirm('Deseja excluir este parceiros?', 'Excluir Parceiros', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/administrador-geral/parceiros/apagar/'+id;
        {literal}
    }     
    });
}
</script>  
{/literal}