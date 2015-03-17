
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Coordenadores Parceiros</h5>
                <h1>Todos os Coordenadores Parceiros</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <a href="/lms/{$categoria}/coordenadorparceiros/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVO COORDENADOR PARCEIRO</a>

                <table class="table table-bordered" id="dyntable">
                                
                	<thead>
                        <tr>
							<th>Nome</th>
                            <th>E-mail</th>
                            <th class="center">Cidade</th>
                            <th class="center">Estado</th>
                            <th width="135">Ações</th>
						</tr>
					</thead>
                    <tbody>
                    	{foreach item=coordenador_parceiro key=k from=$coordenador_parceiros}
						
                        <tr>
                            <!-- DADOS MODAL -->
                            <input type="hidden" id="nome_{$k}" value="{$coordenador_parceiro.nome}"/>
                            <input type="hidden" id="email_{$k}" value="{$coordenador_parceiro.email}"/>
                            
                            <input type="hidden" id="endereco_{$k}" value="{$coordenador_parceiro.endereco}"/>
                            <input type="hidden" id="bairro_{$k}" value="{$coordenador_parceiro.bairro}"/>
                            <input type="hidden" id="cidade_{$k}" value="{$coordenador_parceiro.cidade}"/>
                            <input type="hidden" id="estado_{$k}" value="{$coordenador_parceiro.estado}"/>
                            
                            
                            <!-- FIM DADOS MODAL -->
                        	<td>{$coordenador_parceiro.nome}</td>
                            <td>{$coordenador_parceiro.email}</td>
							<td class="center">{$coordenador_parceiro.cidade}</td>
							<td class="center">{$coordenador_parceiro.estado}</td>
                            <td width="90">
                                <ul class="tooltipsample">
									<li><a href="#myModal" onclick="setarValores({$k});" class="btn btn-primary" data-toggle="modal" data-placement="bottom" data-rel="tooltip" data-original-title="Cadastro Completo"><i class="iconfa-search"></i></a></li>
                                    <li><a href="/lms/{$categoria}/coordenadorparceiros/editar/{$coordenador_parceiro.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Parceiro"><i class="iconfa-pencil"></i></a></li>
                                    <li><a  href="javascript:;" onclick="javascript:deletar({$coordenador_parceiro.id})" class="btn btn-primary confirmbutton" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Parceiro"><i class="iconfa-remove"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>

                <a href="/lms/{$categoria}/coordenadorparceiros/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVO COORDENADOR PARCEIRO</a>
                
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Dados Cadastrais</h3>
    </div>
    <div class="modal-body">
        
        <h4 id="modal_nome"></h4>
        <h6 id="modal_email"></h6>
        
        <hr />
    
        <p>Endereço: <strong id="modal_endereco"></strong></p>
        <p>Bairro: <strong id="modal_bairro"></strong></p>
        <p>Cidade: <strong id="modal_cidade"></strong></p>
        <p>Estado: <strong id="modal_estado"></strong></p>
        
        <hr />
        
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>
{literal}
<script type="text/javascript">
function setarValores(parceiro) {
    jQuery("#modal_nome").html(jQuery("#nome_"+parceiro).val());
    jQuery("#modal_email").html(jQuery("#email_"+parceiro).val());
	
	jQuery("#modal_cep").html(jQuery("#cep_"+parceiro).val());
	jQuery("#modal_endereco").html(jQuery("#endereco_"+parceiro).val());
    jQuery("#modal_bairro").html(jQuery("#bairro_"+parceiro).val());
    jQuery("#modal_cidade").html(jQuery("#cidade_"+parceiro).val());
    jQuery("#modal_estado").html(jQuery("#estado_"+parceiro).val());
    
}

jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function deletar(id) {
    jConfirm('Deseja excluir este Coordenador Parceiro?', 'Excluir Coordenador Parceiros', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/{$categoria}/coordenadorparceiros/apagar/'+id;
        {literal}
    }     
    });
}
</script>  
{/literal}