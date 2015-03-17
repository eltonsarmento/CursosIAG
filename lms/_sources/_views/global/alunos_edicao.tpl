<div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Alunos</h5>
                <h1>{if $aluno.id} Edição {else} Cadastro {/if} de Aluno</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <a href="/lms/{$categoria}/alunos/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>

                <div class="row-fluid">
                    
                    <div class="span12">
                        <div class="widgetbox">
                            <h4 class="widgettitle">Dados do Aluno</h4>
                            <div class="widgetcontent">
                                
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="editar"/>
                                    <input type="hidden" value="{$aluno.id}" name="id"/>

                                    <!-- NOME -->
                                    <div class="par control-group">
                                        <label class="control-label" for="nome">Nome do Aluno *</label>
                                        <div class="controls"><input type="text" name="nome" id="nome" value="{$aluno.nome}" class="input-xxlarge"/></div>
                                    </div>
                                    
                                    <!-- EMAIL -->
                                    <div class="par control-group">
                                        <label class="control-label" for="email">E-mail do Aluno *</label>
                                        <div class="controls"><input type="text" name="email" id="email" value="{$aluno.email}" class="input-xxlarge"/></div>
                                    </div>
                                    
                                    <!-- CPF -->
                                    <div class="par control-group">
                                        <label class="control-label" for="cpf">CPF </label>
                                        <div class="controls"><input type="text" name="cpf" id="cpf" value="{$aluno.cpf}" class="input-xxlarge campoCPF"/></div>
                                    </div>
                                    
                                    <!-- CEP -->
                                    <div class="par control-group">
                                        <label class="control-label" for="cep">Cep *</label>
                                        <div class="controls"><input type="text" name="cep" id="cep" value="{$aluno.cep}" class="input-xxlarge campoCEP"/></div>
                                    </div>

                                    <!-- ENDERECO -->
                                    <div class="par control-group">
                                        <label class="control-label" for="endereco">Endereço *</label>
                                        <div class="controls"><input type="text" name="endereco" id="endereco" value="{$aluno.endereco}" class="input-xxlarge"/></div>
                                    </div>
                                    
                                    <!-- COMPLEMENTO -->
                                    <div class="par control-group">
                                        <label class="control-label" for="complemento">Complemento</label>
                                        <div class="controls"><input type="text" name="complemento" id="complemento" value="{$aluno.complemento}" class="input-xxlarge"/></div>
                                    </div>
                                    
                                    <!-- BAIRRO -->
                                    <div class="par control-group">
                                        <label class="control-label" for="bairro">Bairro *</label>
                                        <div class="controls"><input type="text" name="bairro" id="bairro" value="{$aluno.bairro}" class="input-xxlarge"/></div>
                                    </div>
                                    
                                    <!-- ESTADO -->
                                    <div class="par control-group">
                                        <label class="control-label" for="estado">Estado *</label>
                                        <!-- <div class="controls"><input type="text" name="estado" id="estado" value="{$aluno.estado}" class="input-large"/></div> -->
                                        <select id="estados" name="estado"></select>
                                    </div>
                                    
                                    <!-- CIDADE -->
                                    <div class="par control-group">
                                        <label class="control-label" for="cidade">Cidade *</label>
                                        <!-- <div class="controls"><input type="text" name="cidade" id="cidade" value="{$aluno.cidade}" class="input-large"/></div> -->
                                        <select id="cidades" name="cidade"></select>
                                    </div>
                                    
                                    <!-- TELEFONE -->
                                    <div class="par control-group">
                                        <label class="control-label" for="telefone">Telefone </label>
                                        <div class="controls"><input type="text" name="telefone" id="telefone" value="{$aluno.telefone}" class="input-large campoTelefone"/></div>
                                    </div>                            

                                    <!-- SENHA -->
                                    <div class="par control-group">
                                        <label class="control-label" for="senha">Senha *</label>
                                        <div class="controls"><input type="password" name="senha" id="senha" class="input-large"/></div>
                                    </div>                            
                                                                    
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">{if $aluno.id}Editar{else}Cadastrar{/if} Aluno</button>
                                    </p>
                               </form>

                            </div>
                        </div>
                        
                </div>
                
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

</script>  

<script type="text/javascript"> 
  
jQuery(document).ready(function ($) {
  
    $.getJSON('/lms/common/js/estados_cidades.json', function (data) {
        var items = [];
        var options = '<option value="">Selecione um Estado</option>';  

        $.each(data, function (key, val) {
            options += '<option value="' + val.nome + '">' + val.nome + '</option>';
        });   

        $("#estados").html(options);    
        {/literal}    
        $("#estados").val('{$aluno.estado}'); //SETA O VALOR DO ESTADO AQUI !!
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
            $("#cidades").val('{$aluno.cidade}');  //SETA O VALOR DA CIDADE AQUI !!
            {literal}
        }).change();        
    });
});
  
</script>
{/literal}