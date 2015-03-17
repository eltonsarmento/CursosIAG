 <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle <span class="separator"></span></li>
            <li>Consultar Alunos</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-shopping-cart"></span></div>
            <div class="pagetitle">
                <h5>Painel Administrativo</h5>
                <h1>Consultar Alunos</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <!-- RESULTADO -->
                <table class="table table-bordered">
                    <thead>
                        <th>Aluno</th>
                        <th>E-mail</th>
                        <th class="center">CEP</th>
                        <th class="center">CPF</th>
                        <th class="center">Telefone</th>
                        <th class="center">Ações</th>
                    </thead>

                    <tbody>
                        {foreach item=aluno key=k from=$alunos}
                        <tr>
                            <!-- DADOS MODAL -->
                            <input type="hidden" id="id_{$k}" value="{$aluno.id}"/>
                            <input type="hidden" id="nome_{$k}" value="{$aluno.nome}"/>
                            <input type="hidden" id="email_{$k}" value="{$aluno.email}"/>
                            <input type="hidden" id="cep_{$k}" value="{$aluno.cep}"/>
                            <input type="hidden" id="cpf_{$k}" value="{$aluno.cpf}"/>
                            <input type="hidden" id="telefone_{$k}" value="{$aluno.telefone}"/>
                            <input type="hidden" id="endereco_{$k}" value="{$aluno.endereco}"/>
                            <input type="hidden" id="bairro_{$k}" value="{$aluno.bairro}"/>
                            <input type="hidden" id="cidade_{$k}" value="{$aluno.cidade}"/>
                            <input type="hidden" id="estado_{$k}" value="{$aluno.estado}"/>
                            <!-- FIM DADOS MODAL -->
                            <td>{$aluno.nome}</td>
                            <td>{$aluno.email}</td>
                            <td>{$aluno.cep}</td>
                            <td>{$aluno.cpf}</td>
                            <td>{$aluno.telefone}</td>
                            <td class="center">
                              <ul class="tooltipsample">
                                <li><a href="#myModal" onclick="setarValores({$k});" class="btn btn-primary" data-toggle="modal" data-placement="bottom" data-rel="tooltip" data-original-title="Cadastro Completo"><i class="iconfa-search"></i></a></li>

                                <li><a href="#myModal2" onclick="historicoCompras({$k});" class="btn btn-primary" data-toggle="modal" data-placement="bottom" data-rel="tooltip" data-original-title="Historico compras"><i class="iconfa-truck"></i></a></li>
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
        <h3 id="myModalLabel">Dados Cadastrais</h3>
    </div>
    <div class="modal-body">
        
        <h4 id="modal_nome"></h4>
        <h6 id="modal_email"></h6>
        
        <hr />
        
        <p>Cep: <strong id="modal_cep"></strong></p>
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
<!-- FIM MODAL -->

<!-- MODAL HISTORICO -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Dados Vendas</h3>
    </div>
    <div class="modal-body">

        <h6>Nome: <span id="modal2_nome"></span></h6>
        <h6>E-mail: <span id="modal2_email"></span></h6>
        
        <hr />

        <h4>Histórico</h4>

        <br />
        
        <div id="modal_tabela">
            
        </div>
                  
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>


{literal}
<script type="text/javascript">

//Edição
function setarValores(aluno) {
    jQuery("#modal_nome").html(jQuery("#nome_"+aluno).val());
    jQuery("#modal_email").html(jQuery("#email_"+aluno).val());
    jQuery("#modal_cep").html(jQuery("#cep_"+aluno).val());
    jQuery("#modal_endereco").html(jQuery("#endereco_"+aluno).val());
    jQuery("#modal_bairro").html(jQuery("#bairro_"+aluno).val());
    jQuery("#modal_cidade").html(jQuery("#cidade_"+aluno).val());
    jQuery("#modal_estado").html(jQuery("#estado_"+aluno).val());
    
}

//Mensagem
{/literal}
{if $msg_alert} jAlert('{$msg_alert}'); {/if}
{literal}

//Delete
function deletar(id, curso_id) {
    jConfirm('Deseja deletar este aluno?', 'Deletar Aluno', function(r) {
        if (r) {
        {/literal}
        window.location.href='{$url_site}lms/{$categoria}/alunos/apagar/'+id;
        {literal}
    }     
    });
}

//Historico compras
function historicoCompras(aluno) {
    jQuery('#modal2_nome').html(jQuery('#nome_'+aluno).val());
    jQuery('#modal2_email').html(jQuery('#email_'+aluno).val());

    jQuery.post('{/literal}{$url_site}{literal}/lms/{/literal}{$categoria}{literal}/vendas/buscarPorAluno', {aluno_id: jQuery('#id_'+aluno).val()}, function html(html) { jQuery('#modal_tabela').html(html)});
}
</script>
{/literal}