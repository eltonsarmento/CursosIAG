
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-briefcase"></span></div>
            <div class="pagetitle">
                <h5>GERENCIAR PARCEIROS</h5>
                <h1>{if $coordenador_parceiro.id}Edição{else}Cadastro{/if} de Coordenador Parceiro</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
                <a href="/lms/{$categoria}/coordenadorparceiros/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>
                <div class="widget">
                <h4 class="widgettitle">{if $coordenador_parceiro.id}Editar{else}Cadastrar{/if} Coordenador Parceiro</h4>
                <div class="widgetcontent">
                
                  <form class="stdform" method="post" action="" enctype="multipart/form-data">
                            <div class="par control-group">
                                <input type="hidden" value="1" name="editar"/>
                                <input type="hidden" value="{$coordenador_parceiro.id}" name="id"/>
                                
                                <!-- NOME COMPLETO -->
                                <label class="control-label" for="firstname">Nome:*</label>
                                <div class="controls"><input type="text" name="nome" id="firstname" class="input-xxlarge" placeholder="Adriano Gianini" value="{$coordenador_parceiro.nome}"/></div>
                                
                                <!-- E-MAIL -->
                                <label class="control-label" for="firstname">E-mail:*</label>
                                <div class="controls"><input type="text" name="email" id="firstname" class="input-xlarge" placeholder="seuemail@seudominio.com.br" value="{$coordenador_parceiro.email}"/></div>
                                
                                <!-- ENDERECO -->
                                <label class="control-label" for="firstname">Endereço</label>
                                <div class="controls"><input type="text" name="endereco" id="firstname" class="input-xxlarge" placeholder="R. Treze de Maio" value="{$coordenador_parceiro.endereco}"/></div>
                                
                                <!-- COMPLEMENTO -->
                                <label class="control-label" for="firstname">Complemento:</label>
                                <div class="controls"><input type="text" name="complemento" id="firstname" class="input-xxlarge" placeholder="Próximo ao SESC Poço" value="{$coordenador_parceiro.complemento}"/></div>
                                
                                <!-- BAIRRO -->
                                <label class="control-label" for="firstname">Bairro:</label>
                                <div class="controls"><input type="text" name="bairro" id="firstname" class="input-xlarge" placeholder="Poço" value="{$coordenador_parceiro.bairro}"/></div>
                                
                                <!-- ESTADO -->
                                <label class="control-label" for="firstname">Estado:</label>
                                <div class="controls">
                                    <select id="estados" name="estado"></select>
                                </div>
                                
                                <!-- CIDADE -->
                                <label class="control-label" for="firstname">Cidade:</label>
                                <div class="controls">
                                    <select id="cidades" name="cidade"></select>
                                </div>
                                
                                <!-- SENHA -->
                                <label class="control-label" for="firstname">Senha:*</label>
                                <div class="controls"><input type="password" name="senha" id="firstname" class="input-xlarge" placeholder="Sua senha"/></div>

                                <!-- STATUS -->
                                <label class="control-label" for="firstname">Status:*</label>
                                <div class="controls">
                                    <select name="ativo">
                                        <option value="1" {if $coordenador_parceiro.ativo == 1} selected="selected" {/if}>Ativo</option>
                                        <option value="0" {if $coordenador_parceiro.ativo == 0} selected="selected" {/if}>Inativo</option>
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
                                {if $coordenador_parceiro.avatar}
                                    <input type="hidden" value="{$coordenador_parceiro.avatar}" name="visualizar_avatar"/>
                                    <label><img src="/lms/uploads/avatar/{$coordenador_parceiro.avatar}" width="100" /></label><div style="clear:both;"></div>
                                {/if}
                            </div>

                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $coordenador_parceiro.id}Editar{else}Cadastrar{/if} Parceiro</button>
                            </p>
                       </form>
                       </div>
                       <!-- FIM CADASTRO PARCEIRO -->
            
                 
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
<script src="/lms/common/js/jquery.price_format.1.8.min.js"></script>
<script src="/lms/common/js/jquery.price_format.1.8.js"></script>
<script type="text/javascript">

jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});


jQuery(document).ready(function ($) {
  
    $.getJSON('/lms/common/js/estados_cidades.json', function (data) {
        var items = [];
        var options = '<option value="">Selecione um Estado</option>';  

        $.each(data, function (key, val) {
            options += '<option value="' + val.nome + '">' + val.nome + '</option>';
        });   

        $("#estados").html(options);    
        {/literal}    
        $("#estados").val('{$coordenador_parceiro.estado}'); //SETA O VALOR DO ESTADO AQUI !!
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
            $("#cidades").val('{$coordenador_parceiro.cidade}');  //SETA O VALOR DA CIDADE AQUI !!
            {literal}
        }).change();        
    });
});
  
</script> 
{/literal}