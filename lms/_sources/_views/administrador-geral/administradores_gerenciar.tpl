
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Administrador</h5>
                <h1>Todos os Administradores</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

            	<a href="/lms/administrador-geral/administradores/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVO ADMINISTRADOR</a>

                <table class="table table-bordered" id="dyntable">

                    <thead>

                        <th>Nome</th>
                        <th>E-mail</th>
                        <th class="center">CPF</th>
                        <th class="center">Telefone</th>
                        <th width="135">Ações</th>

                    </thead>

                    <tbody>
                        {foreach item=administrador from=$administradores key=k}
                        <tr>

                            <input type="hidden" value="{$administrador.nome}" id="nome_{$k}"/>
                            <input type="hidden" value="{$administrador.email}" id="email_{$k}"/>
                            <input type="hidden" value="{$administrador.email_secundario}" id="email_secundario_{$k}"/>
                            <input type="hidden" value="{$administrador.cep}" id="cep_{$k}"/>
                            <input type="hidden" value="{$administrador.endereco}" id="endereco_{$k}"/>
                            <input type="hidden" value="{$administrador.bairro}" id="bairro_{$k}"/>
                            <input type="hidden" value="{$administrador.cidade}" id="cidade_{$k}"/>
                            <input type="hidden" value="{$administrador.estado}" id="estado_{$k}"/>
                            <input type="hidden" value="{$administrador.telefone}" id="telefone_{$k}"/>

                            <td><a href="#myModal" onclick="setarValores({$k})"  data-toggle="modal">{$administrador.nome}</a></td>
                            <td>{$administrador.email}</td>
                            <td class="center">{$administrador.cpf}</td>
                            <td class="center">{$administrador.telefone}</td>
                            <td width="130">
                                              
                              <ul class="tooltipsample">
                                <li><a href="#myModal" onclick="setarValores({$k})"  class="btn btn-primary" data-toggle="modal" data-placement="bottom" data-rel="tooltip" data-original-title="Cadastro Completo"><i class="iconfa-search"></i></a></li>
                                <li><a href="/lms/administrador-geral/administradores/editar/{$administrador.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Administrador"><i class="iconfa-pencil"></i></a></li>
                                {if $administrador.id != 2}
                                <li><a class="btn btn-danger confirmbutton" onclick="javascript:deletar({$administrador.id})" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Administrador"><i class="iconfa-remove"></i></a></li>
                                {/if}
                              </ul>

                            </td>

                        </tr>
                        {/foreach}
                        
                    </tbody>    

                </table>

                <a href="/lms/administrador-geral/administradores/novo" class="btn btn-success"><i class="iconfa-plus"></i> ADICIONAR NOVO ADMINISTRADOR</a>
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
            
            <h4 id="modal_nome">Adriano Gianini</h4>
            <h6 id="modal_email">adriano@cursosiag.com.br</h6>
            <h6 id="modal_email_secundario">adriano@cursosiag.com.br</h6>
            
            <hr />
            
            <p>Cep: <strong id="modal_cep">00000-000</strong></p>
            <p>Endereço: <strong id="modal_endereco">Rua Treze de Maio, 90</strong></p>
            <p>Bairro: <strong id="modal_bairro">Poço</strong></p>
            <p>Cidade: <strong id="modal_cidade">Maceió</strong></p>
            <p>Estado: <strong id="modal_estado">Alagoas</strong></p>
            <p>Telefone: <strong id="modal_telefone">(00) 0000-0000</strong></p>

        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>
    </div><!--#myModal-->

{literal}
<script type="text/javascript">

//Edição
function setarValores(k) {
    jQuery("#modal_nome").html(jQuery("#nome_"+k).val());
    jQuery("#modal_email").html(jQuery("#email_"+k).val());
    jQuery("#modal_email_secundario").html(jQuery("#email_secundario_"+k).val());
    jQuery("#modal_cep").html(jQuery("#cep_"+k).val());
    jQuery("#modal_endereco").html(jQuery("#endereco_"+k).val());
    jQuery("#modal_bairro").html(jQuery("#bairro_"+k).val());
    jQuery("#modal_cidade").html(jQuery("#cidade_"+k).val());
    jQuery("#modal_estado").html(jQuery("#estado_"+k).val());
    jQuery("#modal_telefone").html(jQuery("#telefone_"+k).val());
    
}

//Mensagem
{/literal}
{if $msg_alert} jAlert('{$msg_alert}'); {/if}
{literal}

//Delete
function deletar(id, curso_id) {
    jConfirm('Deseja deletar este administrador?', 'Deletar Administrador', function(r) {
        if (r) {
        {/literal}
        window.location.href='{$url_site}lms/administrador-geral/administradores/apagar/'+id;
        {literal}
    }     
    });
}
</script>
{/literal}