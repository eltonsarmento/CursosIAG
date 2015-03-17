
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
                <h5>GERENCIAR PROFESSORES</h5>
                <h1>{if $professor.id}Edição{else}Cadastro{/if} de Professor</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
                <a href="/lms/{$categoria}/professores/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>

                <div class="widget">
                    <h4 class="widgettitle">{if $professor.id}Editar{else}Cadastrar{/if} Professores</h4>
                    <div class="widgetcontent">
                
                  <!-- CADASTRO PROFESSOR -->
                      <form class="stdform" method="post" action="" enctype="multipart/form-data">
                            <div class="par control-group">
                                <input type="hidden" value="1" name="editar"/>
                                <input type="hidden" value="{$professor.id}" name="id"/>
                                
                                <!-- NOME COMPLETO -->
                                <label class="control-label" for="firstname">Nome Completo:*</label>
                                <div class="controls"><input type="text" name="nome" id="firstname" class="input-xxlarge" placeholder="Davi de Oliveira" value="{$professor.nome}"/></div>
                                
                                <!-- DATA DE NASCIMENTO -->                    
                                <label class="control-label" for="firstname">Data de Nascimento:*</label>
                                <div class="controls"><input type="text" name="data_nascimento" id="firstname" class="input-large campoData" placeholder="dd/mm/aaaa" value="{$professor.data_nascimento}"/></div>
                                
                                <!-- CPF -->
                                <label class="control-label" for="firstname">CPF:*</label>
                                <div class="controls"><input type="text" name="cpf" id="firstname" class="input-xlarge campoCPF" placeholder="000.000.000-00" value="{$professor.cpf}"/></div>
                                
                                <!-- ENDERECO -->
                                <label class="control-label" for="firstname">Endereço:*</label>
                                <div class="controls"><input type="text" name="endereco" id="firstname" class="input-xxlarge" placeholder="R. Treze de Maio" value="{$professor.endereco}"/></div>
                                <!-- COMPLEMENTO -->
                                <label class="control-label" for="firstname">Complemento:</label>
                                <div class="controls"><input type="text" name="complemento" id="firstname" class="input-xxlarge" placeholder="Próximo ao SESC Poço" value="{$professor.complemento}"/></div>
                                
                                <!-- BAIRRO -->
                                <label class="control-label" for="firstname">Bairro:*</label>
                                <div class="controls"><input type="text" name="bairro" id="firstname" class="input-xlarge" placeholder="Poço" value="{$professor.bairro}"/></div>
                                
                                <!-- ESTADO -->
                                <label class="control-label" for="firstname">Estado:*</label>
                                <div class="controls">
                                    <!-- <input type="text" name="estado" id="firstname" class="input-xlarge" placeholder="Alagoas" value="{$professor.estado}"/> -->
                                    <select id="estados" name="estado"></select>
                                </div>
                                
                                <!-- CIDADE -->
                                <label class="control-label" for="firstname">Cidade:*</label>
                                <div class="controls">
                                    <!-- <input type="text" name="cidade" id="firstname" class="input-xlarge" placeholder="Maceió" value="{$professor.cidade}"/>  -->
                                    <select id="cidades" name="cidade"></select>
                                </div>
                                
                                <!-- CEP -->
                                <label class="control-label" for="firstname">CEP:*</label>
                                <div class="controls"><input type="text" name="cep" id="firstname" class="input-large campoCEP" placeholder="00000-000" value="{$professor.cep}"/></div>
                                
                                <!-- E-MAIL -->
                                <label class="control-label" for="firstname">E-mail:*</label>
                                <div class="controls"><input type="text" name="email" id="firstname" class="input-xlarge" placeholder="seuemail@seudominio.com.br" value="{$professor.email}"/></div>
                                
                                <!-- SENHA -->
                                <label class="control-label" for="firstname">Senha:*</label>
                                <div class="controls"><input type="password" name="senha" id="firstname" class="input-xlarge" placeholder="Sua senha"/></div>

                                <!-- COMISSÃO -->
                                <label class="control-label" for="firstname">Comissão:*</label>
                                <div class="controls"><input type="text" name="comissao" id="firstname" class="input-large inteiro" placeholder="Porcentagem" value="{$professor.comissao}"/></div>
                                
                                <!-- CURRICULO -->
                                <label class="control-label" for="firstname">Mini-currículo:</label>
                                <div class="controls"><textarea cols="30" name="minicurriculo" class="input-xxlarge" rows="5">{$professor.minicurriculo}</textarea></div>

                                <!-- CONTA 1 -->
                                <label class="control-label" for="firstname">Dados Bancários 1:*</label>
                                <div class="controls">
                                    <input type="text" name="banco1" id="firstname" class="input-small" placeholder="Banco" value="{$professor.banco1}"/>
                                    <input type="text" name="agencia1" id="firstname" class="input-small" placeholder="Agência" value="{$professor.agencia1}"/>
                                    <input type="text" name="conta1" id="firstname" class="input-small" placeholder="Conta" value="{$professor.conta1}"/>
                                    <select name="tipoconta1">
                                        <option>Tipo de Conta</option>
                                        <option value="1" {if $professor.tipoconta1 == 1} selected="selected" {/if}>Poupança</option> 
                                        <option value="2" {if $professor.tipoconta1 == 2} selected="selected" {/if}>Corrente</option>   
                                    </select>
                                    <input type="text" name="operacao1" id="firstname" class="input-medium" placeholder="Operação/Variação" value="{$professor.operacao1}"/>
                                </div>
                                
                                <!-- CONTA 2 -->
                                <label class="control-label" for="firstname">Dados Bancários 2:</label>
                                <div class="controls">
                                    <input type="text" name="banco2" id="firstname" class="input-small" placeholder="Banco" value="{$professor.banco2}"/>
                                    <input type="text" name="agencia2" id="firstname" class="input-small" placeholder="Agência" value="{$professor.agencia2}"/>
                                    <input type="text" name="conta2" id="firstname" class="input-small" placeholder="Conta" value="{$professor.conta2}"/>
                                    <select name="tipoconta2">
                                        <option>Tipo de Conta</option>
                                        <option value="1" {if $professor.tipoconta2 == 1} selected="selected" {/if}>Poupança</option> 
                                        <option value="2" {if $professor.tipoconta2 == 2} selected="selected" {/if}>Corrente</option>   
                                    </select>
                                    <input type="text" name="operacao2" id="firstname" class="input-medium" placeholder="Operação/Variação" value="{$professor.operacao2}"/>
                                </div>
                                
                                <!-- STATUS -->
                                <label class="control-label" for="firstname">Status:*</label>
                                <div class="controls">
                                    <select name="ativo">
                                        <option value="1" {if $professor.ativo == 1} selected="selected" {/if}>Ativo</option>
                                        <option value="0" {if $professor.ativo == 0} selected="selected" {/if}>Inativo</option>
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
                                {if $professor.avatar}
                                    <input type="hidden" value="{$professor.avatar}" name="visualizar_avatar"/>
                                    <label><img src="/lms/uploads/avatar/{$professor.avatar}" width="100" /></label><div style="clear:both;"></div>
                                {/if}
                                
                            </div>

                                                            
                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $professor.id}Editar{else}Cadastrar{/if} Professor</button>
                            </p>
                       </form>
                       
                       <!-- FIM CADASTRO PROFESSOR -->
                  
                </div><!--widgetcontent-->
            </div><!--widget-->

                    
              <div class="clearfix"></div>
                    
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
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function deletar(id) {
    jConfirm('Deseja excluir este professor?', 'Excluir Professor', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/{$categoria}/professores/apagar/'+id;
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
        $("#estados").val('{$professor.estado}'); //SETA O VALOR DO ESTADO AQUI !!
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
            $("#cidades").val('{$professor.cidade}');  //SETA O VALOR DA CIDADE AQUI !!
            {literal}
        }).change();        
    });
});
  
</script>
{/literal}