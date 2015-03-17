
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-briefcase"></span></div>
            <div class="pagetitle">
                <h5>GERENCIAR PARCEIROS</h5>
                <h1>{if $parceiro.id}Edição{else}Cadastro{/if} de Parceiro</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
                <a href="/lms/administrador-geral/parceiros/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>
                <div class="widget">
                <h4 class="widgettitle">{if $parceiro.id}Editar{else}Cadastrar{/if} Parceiro</h4>
                <div class="widgetcontent">
                
                  <form class="stdform" method="post" action="" enctype="multipart/form-data">
                            <div class="par control-group">
                                <input type="hidden" value="1" name="editar"/>
                                <input type="hidden" value="{$parceiro.id}" name="id"/>
                                
                                <!-- NOME COMPLETO -->
                                <label class="control-label" for="firstname">Nome:*</label>
                                <div class="controls"><input type="text" name="nome" id="firstname" class="input-xxlarge" placeholder="VIdeo Aulas IAG" value="{$parceiro.nome}"/></div>
                                
                                <label class="control-label" for="firstname">Site:</label>
                                <div class="controls"><input type="text" name="website" id="firstname" class="input-xxlarge" placeholder="http://seusite.com.br" value="{$parceiro.website}"/></div>
                                
                                <!-- E-MAIL -->
                                <label class="control-label" for="firstname">E-mail:*</label>
                                <div class="controls"><input type="text" name="email" id="firstname" class="input-xlarge" placeholder="seuemail@seudominio.com.br" value="{$parceiro.email}"/></div>

                                <!-- E-MAIL Secundário -->
                                <label class="control-label" for="email_secundario">E-mail Secundário</label>
                                <div class="controls"><input type="text" name="email_secundario" id="email_secundario" class="input-xlarge" placeholder="seuemail@seudominio.com.br" value="{$parceiro.email_secundario}"/></div>
                                
                                <label class="control-label" for="firstname">Contato:*</label>
                                <div class="controls"><input type="text" name="contato" id="firstname" class="input-xlarge" placeholder="Adriano Gianini" value="{$parceiro.contato}"/></div>
                                
                                <!-- TELEFONE -->
                                <label class="control-label" for="telefone">Telefone:*</label>
                                <div class="controls"><input type="text" name="telefone" id="telefone" value="{$parceiro.telefone}" placeholder="(82) 0000 - 0000" class="input-large campoTelefone"/></div>
                                
                                <!-- ENDERECO -->
                                <label class="control-label" for="firstname">Endereço:*</label>
                                <div class="controls"><input type="text" name="endereco" id="firstname" class="input-xxlarge" placeholder="R. Treze de Maio" value="{$parceiro.endereco}"/></div>
                                
                                <!-- COMPLEMENTO -->
                                <label class="control-label" for="firstname">Complemento:</label>
                                <div class="controls"><input type="text" name="complemento" id="firstname" class="input-xxlarge" placeholder="Próximo ao SESC Poço" value="{$parceiro.complemento}"/></div>
                                
                                <!-- BAIRRO -->
                                <label class="control-label" for="firstname">Bairro:*</label>
                                <div class="controls"><input type="text" name="bairro" id="firstname" class="input-xlarge" placeholder="Poço" value="{$parceiro.bairro}"/></div>
                                
                                <!-- ESTADO -->
                                <label class="control-label" for="firstname">Estado:*</label>
                                <div class="controls">
                                    <!-- <input type="text" name="estado" id="firstname" class="input-xlarge" placeholder="Alagoas" value="{$parceiro.estado}"/> -->
                                    <select id="estados" name="estado"></select>
                                </div>
                                
                                <!-- CIDADE -->
                                <label class="control-label" for="firstname">Cidade:*</label>
                                <div class="controls">
                                    <!-- <input type="text" name="cidade" id="firstname" class="input-xlarge" placeholder="Maceió" value="{$parceiro.cidade}"/> -->
                                    <select id="cidades" name="cidade"></select>
                                </div>
                                
                                <!-- CEP -->
                                <label class="control-label" for="firstname">CEP:*</label>
                                <div class="controls"><input type="text" name="cep" id="firstname" class="input-large campoCEP" placeholder="00000-000" value="{$parceiro.cep}"/></div>
                                
                                <!-- CPF -->
                                <label class="control-label" for="firstname">CPF:*</label>
                                <div class="controls"><input type="text" name="cpf" id="firstname" class="input-xlarge campoCPF" placeholder="000.000.000-00" value="{$parceiro.cpf}"/></div>
                                
                                <!-- CNPJ -->
                                <label class="control-label" for="firstname">CNPJ:*</label>
                                <div class="controls"><input type="text" name="cnpj" id="firstname" class="input-xlarge campoCNPJ" placeholder="00.000.000/0000-00" value="{$parceiro.cnpj}"/></div>
                                
                                <!-- ENDERECO -->
                                <label class="control-label" for="firstname">Razão Social:*</label>
                                <div class="controls"><input type="text" name="razao_social" id="firstname" class="input-large" placeholder="Ensino a Distância/EAD" value="{$parceiro.razao_social}"/></div>
                                
                                <!-- COMISSÃO -->
                                <label class="control-label" for="firstname">Comissão:*</label>
                                <div class="controls"><input type="text" name="comissao" id="firstname" class="input-large inteiro" placeholder="Porcentagem" value="{$parceiro.comissao}"/></div>

                                <!-- SENHA -->
                                <label class="control-label" for="firstname">Senha:*</label>
                                <div class="controls"><input type="password" name="senha" id="firstname" class="input-xlarge" placeholder="Sua senha"/></div>
                                
                                <!-- CONTA 1 -->
                                <label class="control-label" for="firstname">Dados Bancários 1:*</label>
                                <div class="controls">
                                    <input type="text" name="banco1" id="firstname" class="input-small" placeholder="Banco" value="{$parceiro.banco1}"/>
                                    <input type="text" name="agencia1" id="firstname" class="input-small" placeholder="Agência" value="{$parceiro.agencia1}"/>
                                    <input type="text" name="conta1" id="firstname" class="input-small" placeholder="Conta" value="{$parceiro.conta1}"/>
                                    <select name="tipoconta1">
                                        <option>Tipo de Conta</option>
                                        <option value="1" {if $parceiro.tipoconta1 == 1} selected="selected" {/if}>Poupança</option> 
                                        <option value="2" {if $parceiro.tipoconta1 == 2} selected="selected" {/if}>Corrente</option>   
                                    </select>
                                    <input type="text" name="operacao1" id="firstname" class="input-medium" placeholder="Operação/Variação" value="{$parceiro.operacao1}"/>
                                </div>

                                <!-- STATUS -->
                                <label class="control-label" for="firstname">Status:*</label>
                                <div class="controls">
                                    <select name="ativo">
                                        <option value="1" {if $parceiro.ativo == 1} selected="selected" {/if}>Ativo</option>
                                        <option value="0" {if $parceiro.ativo == 0} selected="selected" {/if}>Inativo</option>
                                    </select>
                                </div>
                                
                                <!-- AVATAR -->
                                <div class="par margintop10">
                                    <label>Foto:</label>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="input-append">
                                            <div class="uneditable-input span3">
                                                <i class="iconfa-file fileupload-exists"></i>
                                                <span class="fileupload-preview"></span>
                                            </div>
                                            <span class="btn btn-file"><span class="fileupload-new">Selecione o arquivo</span>
                                            <span class="fileupload-exists">Trocar</span>
                                            <input type="file" name="avatar"/></span> <!-- AQUI -->
                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                                        </div>
                                    </div>
                                </div>
                                {if $parceiro.avatar}
                                    <input type="hidden" value="{$parceiro.avatar}" name="visualizar_avatar"/>
                                    <label><img src="/lms/uploads/avatar/{$parceiro.avatar}" width="100" /></label><div style="clear:both;"></div>
                                {/if}
                            </div>

                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $parceiro.id}Editar{else}Cadastrar{/if} Parceiro</button>
                            </p>
                       </form>
                       </div>
                       <!-- FIM CADASTRO PARCEIRO -->
            
                 
                </div><!--widget-->

                    
              <div class="clearfix"></div>
                    
              <div class="footer"></div><!--footer-->

            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
{literal}
<script src="/lms/common/js/jquery.price_format.1.8.min.js"></script>
<script src="/lms/common/js/jquery.price_format.1.8.js"></script>
<script type="text/javascript">
    jQuery('.inteiro').priceFormat({
        centsLimit: 0,
        limit:3
    });


jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function deletar(id) {
    jConfirm('Deseja excluir este parceiro?', 'Excluir Parceiro', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/administrador-geral/parceiros/apagar/'+id;
        {literal}
    }     
    });
}

jQuery(document).ready(function ($) {
  
    $.getJSON('/lms/common/js/estados_cidades.json', function (data) {
        var items = [];
        var options = '<option value="">Selecione um Estado</option>';  

        $.each(data, function (key, val) {
            options += '<option value="' + val.nome + '">' + val.nome + '</option>';
        });   

        $("#estados").html(options);    
        {/literal}    
        $("#estados").val('{$parceiro.estado}'); //SETA O VALOR DO ESTADO AQUI !!
        {literal}
        $("#estados").change(function () {        
            var options_cidades = '';
            var str = "";         
        
            $("#estados option:selected").each(function () {
                str += $(this).text();
            });
        
            $.each(data, function (key, val) {

                if(val.nome == str) { 

                    $.each(val.cidades, function (key_city, val_city) {
                        options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                    });  
                }
            });

            $("#cidades").html(options_cidades);
            {/literal}
            $("#cidades").val('{$parceiro.cidade}');  //SETA O VALOR DA CIDADE AQUI !!
            {literal}
        }).change();        
    });
});
  
</script> 
{/literal}