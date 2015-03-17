    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>            
            <li>Editar Perfil</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>Painel</h5>
                <h1>Editar Perfil</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    	<div class="span4 profile-left">
                        
                        <form action="" class="editprofileform" method="post">

                        <div class="widgetbox profile-photo">
                            <div class="headtitle">
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn dropdown-toggle">Ações <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><a href="#">Alterar Foto</a></li>
                                    </ul>
                                </div>
                                <h4 class="widgettitle">Foto do Perfil</h4>
                            </div>
                            <div class="widgetcontent">
                                <div class="profilethumb">
                                    <img src="/uploads/imagens/{$usuario.avatar_arquivo}" alt="" class="img-polaroid" />
                                </div><!--profilethumb-->
                            </div>
                        </div>
                            
                        
                        
                        <input type="hidden" value="1" name="editar" />
                        <div class="widgetbox login-information">
                            <h4 class="widgettitle">Informações de Login</h4>
                            <div class="widgetcontent">
                                <p>
                                    <label>E-mail:</label>
                                    <input type="text" name="email" class="input-xlarge" value="{$usuario.email}" />
                                </p>
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
                                                    <input type="text" name="nome" class="input-xlarge" value="{$usuario.nome}" />
                                                </p>
                                                <p>
                                                    <label>Cep:</label>
                                                    <input type="text" name="cep" class="input-xlarge campoCep" value="{$usuario.cep}" />
                                                </p>
                                                <p>
                                                    <label>Endereço:</label>
                                                    <input type="text" name="endereco" class="input-xlarge" value="{$usuario.endereco}" />
                                                </p>
                                                <p>
                                                    <label>Complemento:</label>
                                                    <input type="text" name="complemento" class="input-xlarge" value="{$usuario.complemento}" />
                                                </p>
                                                <p>
                                                    <label>Bairro:</label>
                                                    <input type="text" name="bairro" class="input-xlarge" value="{$usuario.bairro}" />
                                                </p>
                                                <p>
                                                    <label>Cidade:</label>
                                                    <input type="text" name="cidade" class="input-xlarge" value="{$usuario.cidade}" />
                                                </p>
                                                <p>
                                                    <label>Estado:</label>
                                                    <input type="text" name="estado" class="input-xlarge" value="{$usuario.estado}" />
                                                </p> 
                                            </div>

                                            <div class="span6">

                                                <p>
                                                    <label>Facebook:</label>
                                                    <input type="text" name="facebook" class="input-xlarge" value="{$usuario.facebook}" />
                                                </p>
                                                <p>
                                                    <label>Twitter:</label>
                                                    <input type="text" name="twitter" class="input-xlarge" value="{$usuario.twitter}" />
                                                </p>
                                                <p>
                                                    <label>Google+:</label>
                                                    <input type="text" name="google" class="input-xlarge" value="{$usuario.google}" />
                                                </p>
                                                <p>
                                                    <label>LinkedIn:</label>
                                                    <input type="text" name="linkedin" class="input-xlarge" value="{$usuario.linkedin}" />
                                                </p>
                                                <p>
                                                    <label>Website:</label>
                                                    <input type="text" name="website" class="input-xlarge" value="{$usuario.website}" />
                                                </p>
                                                <p>
                                                    <label>Mini Currículo:</label>
                                                    <textarea name="curriculo" class="span8">{$usuario.curriculo}</textarea>
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

<!-- Modal Alterar Senha -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Alterar Senha</h3>
    </div>
    <div class="modal-body">
        <h4>Opções de Exportação</h4>
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
});

function alterarSenha() {
    jQuery.post('/lms/global/perfil/trocarSenha', jQuery('#trocar_senha').serialize(), function html(html) { jQuery('#resposta_trocar_senha').html(html); });
}
</script>
{/literal}