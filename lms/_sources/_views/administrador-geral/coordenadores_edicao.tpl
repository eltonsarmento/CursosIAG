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
                <h5>Gerenciar Coordenadores</h5>
                <h1>{if $coordenador.id}Editar{else}Cadastrar{/if} Coordenador</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <a href="/lms/administrador-geral/coordenadores/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>
                
                <div class="row-fluid">
                    
                    <div class="span12">
                        <div class="widgetbox">
                            <h4 class="widgettitle">Dados do Coordenador</h4>
                            <div class="widgetcontent">
                                
                                <form class="stdform" method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" value="{$coordenador.id}" name="id"/>
                                    <input type="hidden" value="1" name="editar"/>

                                    <p>
                                        <label>Nome*</label>
                                        <span class="field"><input type="text" name="nome" value="{$coordenador.nome}" class="input-xxlarge" /></span>
                                    </p>

                                    <p>
                                        <label>E-mail*</label>
                                        <span class="field"><input type="text" name="email" value="{$coordenador.email}" class="input-xxlarge" /></span>
                                    </p>

                                    <p>
                                        <label>E-mail Secundário</label>
                                        <span class="field"><input type="text" name="email_secundario" value="{$coordenador.email_secundario}" class="input-xxlarge" /></span>
                                    </p>

                                    <p>
                                        <label>CPF*</label>
                                        <span class="field"><input type="text" name="cpf"  value="{$coordenador.cpf}" class="input-xxlarge campoCPF" /></span>
                                    </p>

                                    <p>
                                        <label>Cep*</label>
                                        <span class="field"><input type="text" name="cep"  value="{$coordenador.cep}" class="input-xxlarge campoCEP" /></span>
                                    </p>

                                    <p>
                                        <label>Endereço*</label>
                                        <span class="field"><input type="text" name="endereco" value="{$coordenador.endereco}" class="input-xxlarge" /></span>
                                    </p>

                                    <p>
                                        <label>Complemento</label>
                                        <span class="field"><input type="text" name="complemento" value="{$coordenador.complemento}" class="input-xxlarge" /></span>
                                    </p>

                                    <p>
                                        <label>Bairro*</label>
                                        <span class="field"><input type="text" name="bairro" value="{$coordenador.bairro}" class="input-large" /></span>
                                    </p>

                                    <p>
                                        <label>Estado*</label>
                                        <span class="field">
                                            <select id="estados" name="estado"></select>
                                            <!-- <input type="text" name="estado" value="{$coordenador.estado}" class="input-large" /> -->
                                        </span>
                                    </p>
                                    
                                    <p>
                                        <label>Cidade*</label>
                                        <span class="field">
                                            <select id="cidades" name="cidade"></select>
                                            <!-- <input type="text" name="cidade" value="{$coordenador.cidade}" class="input-large" /> -->
                                        </span>
                                    </p>

                                    <p>
                                        <label>Telefone</label>
                                        <span class="field"><input type="text" name="telefone" value="{$coordenador.telefone}" class="input-large campoTelefone" /></span>
                                    </p>

                                    <div class="par">
                                        <label>Foto Perfil</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input span3">
                                                    <i class="iconfa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-file"><span class="fileupload-new">Selecione a Foto</span>
                                                <span class="fileupload-exists">Alterar</span>
                                                <input type="file" name="avatar" /></span>
                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                                            </div>
                                        </div>
                                    </div>

                                    {if $coordenador.avatar}
                                        <input type="hidden" value="{$coordenador.avatar}" name="visualizar_avatar"/>
                                        <label><img src="/lms/uploads/avatar/{$coordenador.avatar}" width="100" /></label><div style="clear:both;"></div>
                                    {/if}

                                    <p>
                                        <label>Senha*</label>
                                        <span class="field"><input type="password" name="senha" class="input-xlarge" /></span>
                                    </p>                        
                                                                    
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">{if $coordenador.id}Editar{else}Cadastrar{/if} Coordenador</button>
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

jQuery(document).ready(function ($) {
  
    $.getJSON('/lms/common/js/estados_cidades.json', function (data) {
        var items = [];
        var options = '<option value="">Selecione um Estado</option>';  

        $.each(data, function (key, val) {
            options += '<option value="' + val.nome + '">' + val.nome + '</option>';
        });   

        $("#estados").html(options);    
        {/literal}    
        $("#estados").val('{$coordenador.estado}'); //SETA O VALOR DO ESTADO AQUI !!
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
            $("#cidades").val('{$coordenador.cidade}');  //SETA O VALOR DA CIDADE AQUI !!
            {literal}
        }).change();        
    });
});
</script> 
{/literal}