   
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/aluno/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Aluno</a> <span class="separator"></span></li>
            <li>Editar Perfil</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="aluno/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                <h1>Editar Perfil</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    	<div class="span4 profile-left">
                        
                        <div class="widgetbox profile-photo">
                            <div class="headtitle">
                                <h4 class="widgettitle">Foto do Perfil</h4>
                            </div>
                            <div class="widgetcontent">
                                <div class="profilethumb">
                                    <img src="/lms/uploads/avatar/{$usuario.avatar}" alt="" class="img-polaroid" />
                                </div><!--profilethumb-->
                            </div>
                        </div>
                            
                            
                        <form action="" class="editprofileform" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="1" name="editar"/>


                                <div class="widgetbox profile-notifications">
                                    <h4 class="widgettitle">Alterar Foto</h4>
                                    <div class="widgetcontent">

                                    <input type="file" name="avatar" class="btn btn-file span12" value="Alterar Foto">

                                    </div>
                                </div>


                                <div class="widgetbox login-information">
                                    <h4 class="widgettitle">Informações de Login</h4>
                                    <div class="widgetcontent">
                                        <!-- <p>
                                            <label>E-mail:</label>
                                            <input type="text" name="email" class="input-xlarge" value="{$usuario.email}" />
                                        </p> -->
                                        <p>
                                            <label style="padding:0">Senha</label>
                                            <a href="#myModal" data-toggle="modal">Alterar Senha?</a>
                                        </p>
                                    </div>
                                </div>

                                <div class="widgetbox profile-notifications">
                                    <h4 class="widgettitle">Newsletter</h4>
                                    <div class="widgetcontent">
                                        <p>
                                            <a href="http://adrianogianini.us2.list-manage.com/subscribe/post?u=3a5144edd8eab2a9a997d8f4f&amp;id=f120e1268e" target="_blank">Quero receber e-mails de promoções e cursos novos</a>
                                        </p>
                                    </div>
                                </div>
                            
                        </div><!--span4-->
                        <div class="span8">
 
                                <div class="widgetbox personal-information">
                                    <h4 class="widgettitle">Informações Pessoais</h4>
                                    <div class="widgetcontent">

                                        <div class="row-fluid">

                                            <div class="span6">

                                                <p>
                                                    <label>Nome Completo:</label>
                                                    <input type="text" name="nome" class="span10" value="{$usuario.nome}" />
                                                </p>
                                                <p>
                                                    <label>CPF:</label>
                                                    <input type="text" name="cpf" id="cpf" class="span10" value="{$usuario.cpf}" />
                                                </p>
                                                <p>
                                                    <label>Telefone:</label>
                                                    <input type="text" id="telefone"name="telefone" class="span6" value="{$usuario.telefone}" />
                                                </p>
                                                <p>
                                                    <label>Endereço:</label>
                                                    <input type="text" name="endereco" class="span10" value="{$usuario.endereco}" />
                                                </p>
                                                <p>
                                                    <label>Complemento:</label>
                                                    <input type="text" name="complemento" class="span10" value="{$usuario.complemento}" />
                                                </p>
                                                <p>
                                                    <label>Bairro:</label>
                                                    <input type="text" name="bairro" class="span6" value="{$usuario.bairro}" />
                                                </p>
                                                <p>
                                                    <label>Estado:</label>
                                                    <select id="estados" name="estado"></select>
                                                </p>
                                                <p>
                                                    <label>Cidade:</label>
                                                    <select id="cidades" name="cidade"></select>
                                                </p>
                                                <p>
                                                    <label>Cep:</label>
                                                    <input type="text" name="cep" id="cep" class="span6" value="{$usuario.cep}" />
                                                </p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <p>
                                    <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                                </p>
                                
                            </form>
                        </div><!--span8-->
                    </div><!--row-fluid-->
                    
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
    
</div><!--mainwrapper-->

<!-- Modal Alterar Senha -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Alterar Senha</h3>
    </div>
    <div class="modal-body">
        <form action="" id="trocar_senha">
        
            <div id="resposta_trocar_senha"></div>
            <p class="margintop10">
                <input type="password" class="input-large" name="senha_atual" placeholder="Senha atual">
            </p>

            <p class="margintop10">
                <input type="password" class="input-large" name="senha_nova" placeholder="Nova senha">
            </p>

            <p class="margintop10">
                <input type="password" class="input-large" name="senha_confirmacao" placeholder="Repita sua senha">
            </p>

            <button class="btn btn-primary" onclick="alterarSenha(); return false;">Alterar Senha</button>

        </div>

    </form>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>
<!-- Fim Modal Alterar Senha -->

{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}


    //Estado
    jQuery.getJSON('{/literal}{$url_site}{literal}lms/common/js/estados_cidades.json', function (data) {
        var items = [];
        var options = '<option value="">Selecione um Estado</option>';  

        jQuery.each(data, function (key, val) {
            options += '<option value="' + val.nome + '">' + val.nome + '</option>';
        });   

        jQuery("#estados").html(options);    
        {/literal}    
        jQuery("#estados").val('{$usuario.estado}'); //SETA O VALOR DO ESTADO AQUI !!
        {literal}
        jQuery("#estados").change(function () {        
            var options_cidades = '';
            var str = "";         
        
            jQuery("#estados option:selected").each(function () {
                str += jQuery(this).text();
            });
        
            jQuery.each(data, function (key, val) {

                if(val.nome == str) { 

                    jQuery.each(val.cidades, function (key_city, val_city) {
                        options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                    });  
                }
            });

            jQuery("#cidades").html(options_cidades);
            {/literal}
            jQuery("#cidades").val('{$usuario.cidade}');  //SETA O VALOR DA CIDADE AQUI !!
            {literal}
        }).change();        
    });


    //Mascara Telefone
    jQuery('#telefone').focusout(function(){
        var phone, element;
        element = jQuery(this);
        element.unmask();
        /* removo tudo que não for numeros (\D) */
        phone = element.val().replace(/\D/g, '');
        if(phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    }).trigger('focusout');

    //Mascara CPF
    jQuery("#cpf").mask("999.999.999-99");

    //Mascara CEP
    jQuery("#cep").mask("99999-999");
    
});

function alterarSenha() {
    jQuery.post('{/literal}{$url_site}{literal}lms/aluno/perfil/trocarSenha', jQuery('#trocar_senha').serialize(), function html(html) { jQuery('#resposta_trocar_senha').html(html); });
}
</script>
{/literal}