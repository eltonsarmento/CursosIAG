<script type="text/javascript" src="/lms/common/js/jquery.form.min.js"></script>
<script type="text/javascript" src="/lms/common/js/admin/emails.js"></script>
<script type="text/javascript">
{literal}
jQuery(document).ready(function(){
{/literal}	
	{if $id_atual eq 2}carregaDadosEmail(82, 83);{/if}
	{if $id_atual eq 3}carregaDadosEmail(21, 22);{/if}
	{if $id_atual eq 4}carregaDadosEmail(13, 14);{/if}
	{if $id_atual eq 5}carregaDadosEmail(5, 6);{/if}
	{if $id_atual eq 6}carregaDadosEmail(1, 2);{/if}
{literal}
});
{/literal}
</script>
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Modelos de E-mails</li>
            
            
        </ul>
        
        <div class="pageheader">
			{include file="administrador-geral/busca_topo.tpl"}
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Modelos de E-mails</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <div class="tabbedwidget tab-primary">

                    <ul>
                                
                        <li><a {if $id_atual eq 1}style="background: none repeat scroll 0 0 #FFFFFF; border-bottom: 1px solid #FFFFFF; color: #333333;"{else}style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.1); border: 0 none; color: #FFFFFF;"{/if} href="#a-0" onclick="window.location='/lms/administrador-geral/emails/listar/1';">Opções de E-mail</a></li>
                        <li><a {if $id_atual eq 2}style="background: none repeat scroll 0 0 #FFFFFF; border-bottom: 1px solid #FFFFFF; color: #333333;"{/if} href="#a-1" onclick="window.location='/lms/administrador-geral/emails/listar/2';">Alunos</a></li>
                        <li><a {if $id_atual eq 3}style="background: none repeat scroll 0 0 #FFFFFF; border-bottom: 1px solid #FFFFFF; color: #333333;"{/if} href="#a-2" onclick="window.location='/lms/administrador-geral/emails/listar/3';">Professores</a></li>
                        <li><a {if $id_atual eq 4}style="background: none repeat scroll 0 0 #FFFFFF; border-bottom: 1px solid #FFFFFF; color: #333333;"{/if} href="#a-3" onclick="window.location='/lms/administrador-geral/emails/listar/4';">Administrativo</a></li>
                        <li><a {if $id_atual eq 5}style="background: none repeat scroll 0 0 #FFFFFF; border-bottom: 1px solid #FFFFFF; color: #333333;"{/if} href="#a-4" onclick="window.location='/lms/administrador-geral/emails/listar/5';">Parceiro</a></li>
                        <li><a {if $id_atual eq 6}style="background: none repeat scroll 0 0 #FFFFFF; border-bottom: 1px solid #FFFFFF; color: #333333;"{/if} href="#a-5" onclick="window.location='/lms/administrador-geral/emails/listar/6';">Coordenador</a></li>

                    </ul>
					{if $id_atual eq 1}
					<div class="ui-tabs-panel ui-widget-content ui-corner-bottom">

                        <form id="form_email_edicao">

                        <div class="row-fluid">

                            <div class="span6">

                                 <div class="widgetbox">

                                    <h4 class="widgettitle">Opções de Remetente</h4>

                                    <div class="widgetcontent">

                                        <p>

                                            <label>"De" Nome:</label>
                                            <input type="text" name="id[84]" value="{$de_nome}" class="span12">

                                        </p>

                                        <p>

                                            <label>"De" Endereço de E-mail:</label>
                                            <input type="text" name="id[85]" value="{$de_email}" class="span12">

                                        </p>

                                    </div>

                                  </div>

                            </div><!--.span6-->

                            <div class="span6">

                                 <div class="widgetbox">

                                    <h4 class="widgettitle">Modelo do E-mail</h4>

                                    <div class="widgetcontent">

                                        <p>
											<input type="hidden" value="86" name="arquivo_id" />
                                            <label>Imagem do Cabeçalho</label>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                          <div class="input-append">
                                          <div class="uneditable-input span3">
                                              <i class="iconfa-file fileupload-exists"></i>
                                              <span class="fileupload-preview"></span>
                                          </div>
                                          <span class="btn btn-file"><span class="fileupload-new">Selecione o arquivo</span>
                                          <span class="fileupload-exists">Trocar</span>
                                          <input type="file" name="arquivo" /></span>
                                          <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                                          </div>
                                            </div>

                                        </p>

                                        <p>
                                           <label>Imagem Atual:</label>
                                           <img src="{$imagem_atual}" alt="" id="imagem_atual" class="img-polaroid" />
                                      </p>

                                        <p>

                                            <label>Texto do Rodapé:</label>
                                            <textarea cols="30" rows="5" id="id87" name="id[87]" class="span12">{$texto_rodape}</textarea>

                                        </p>

                                        <p>

                                      <input type="button" onclick="javascript:salvaDadosOpcoesEmail(); return false;" class="btn btn-primary" value="Salvar">

                                    </p>


                                    </div>

                                  </div>

                                    
                            </div><!--.span6-->

                        </div><!--.row-fluid-->

                        </form>

                    </div>
					{/if}
					{if $id_atual eq 2}
					<div class="ui-tabs-panel ui-widget-content ui-corner-bottom">

                       
                            <div class="tabs-left">

                              <ul class="nav nav-tabs">

                                  <li class="active"><a data-toggle="tab" href="#r1" onclick="javascript:carregaDadosEmail(82, 83);">Quando o usuário se cadastrar</a></li>
                                  <!-- <li><a data-toggle="tab" href="#r2" onclick="javascript:carregaDadosEmail(42, 43);">Quando a conta for verificada</a></li> -->
                                  <li><a data-toggle="tab" href="#r3" onclick="javascript:carregaDadosEmail(44, 45);">Quando um pedido for feito</a></li>
                                  <li><a data-toggle="tab" href="#r4" onclick="javascript:carregaDadosEmail(46, 47);">Quando a compra for aprovada / curso liberado</a></li>
                                  <li><a data-toggle="tab" href="#r5" onclick="javascript:carregaDadosEmail(48, 49);">Quando um pedido alterar seu status</a></li>
                                  <li><a data-toggle="tab" href="#r6" onclick="javascript:carregaDadosEmail(50, 51);">Quando iniciar um curso</a></li>
                                  <li><a data-toggle="tab" href="#r7" onclick="javascript:carregaDadosEmail(52, 53);">Quando um professor responder sua dúvida</a></li>
                                  <li><a data-toggle="tab" href="#r8" onclick="javascript:carregaDadosEmail(54, 55);">Quando uma notificação for deixada</a></li>

                                  <li><a data-toggle="tab" href="#r9" onclick="javascript:carregaDadosEmail(56, 57);">Quando um certificado for emitido</a></li>
                                  <li><a data-toggle="tab" href="#r10" onclick="javascript:carregaDadosEmail(58, 59);">Quando o status do certificado for alterado</a></li>
                                  <li><a data-toggle="tab" href="#r11" onclick="javascript:carregaDadosEmail(60, 61);">Quando o acesso estiver vencendo (30 dias antes)</a></li>
                                  <li><a data-toggle="tab" href="#r12" onclick="javascript:carregaDadosEmail(62, 63);">Quando o acesso estiver vencendo (15 dias antes)</a></li>
                                  <li><a data-toggle="tab" href="#r13" onclick="javascript:carregaDadosEmail(64, 65);">Quando o acesso estiver vencendo (1 dia antes)</a></li>
                                  <li><a data-toggle="tab" href="#r14" onclick="javascript:carregaDadosEmail(66, 67);">Quando o acesso estiver vencendo (No dia)</a></li>
                                  <!-- <li><a data-toggle="tab" href="#r15" onclick="javascript:carregaDadosEmail(68, 69);">Quando o acesso estiver vencendo (Um dia depois)</a></li> -->

                                  <li><a data-toggle="tab" href="#r16" onclick="javascript:carregaDadosEmail(70, 71);">Quando uma assinatura for contratada</a></li>
                                  <li><a data-toggle="tab" href="#r17" onclick="javascript:carregaDadosEmail(72, 73);">Quando a assinatura estiver vencendo (10 dias)</a></li>
                                  <li><a data-toggle="tab" href="#r18" onclick="javascript:carregaDadosEmail(74, 75);">Quando a assinatura estiver vencendo (5 dias)</a></li>
                                  <li><a data-toggle="tab" href="#r19" onclick="javascript:carregaDadosEmail(76, 77 );">Quando a assinatura estiver vencendo (1 dia)</a></li>
                                  <li><a data-toggle="tab" href="#r20" onclick="javascript:carregaDadosEmail(78, 79);">Quando a assinatura for renovada (Pagamento recorrente)</a></li>
                                  <li><a data-toggle="tab" href="#r21" onclick="javascript:carregaDadosEmail(80, 81);">Quando a assinatura não for renovada por problemas financeiros</a></li>

                              </ul>

                            <div class="tab-content">

                                <div id="r1" class="tab-pane active">

									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id82" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id83">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(82, 83); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <div id="r2" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id42" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id43">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(42, 43); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r3" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id44" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id45">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(44, 45); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r4" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id46" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id47">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(46, 47); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r5" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id48" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id49">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(48, 49); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r6" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id50" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id51">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(50, 51); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r7" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id52" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id53">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(52, 53); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r8" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id54" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id55">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(54, 55); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r9" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id56" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id57">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(56, 57); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r10" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id58" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id59">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(58, 59); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r11" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id60" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id61">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(60, 61); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r12" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id62" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id63">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(62, 63); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r13" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id64" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id65">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(64, 65); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r14" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id66" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id67">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(66, 67); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r15" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id68" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id69">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(68, 69); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r16" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id70" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id71">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(70, 71); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r17" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id72" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id73">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(72, 73); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r18" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id74" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id75">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(74, 75); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r19" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id76" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id77">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(76, 77); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r20" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id78" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id79">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(78, 79); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r21" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id80" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id81">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(80, 81); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                            </div><!--tab-content-->

                        </div><!--tabbable tabs-left-->

                    </div>
					{/if}
					{if $id_atual eq 3}
					<div class="ui-tabs-panel ui-widget-content ui-corner-bottom">

                        <div class="tabs-left">

                              <ul class="nav nav-tabs">

                                  <li class="active"><a data-toggle="tab" href="#r1" onclick="javascript:carregaDadosEmail(21, 22);">Quando o professor for cadastrado (enviar e-mail com dados de acesso)</a></li>
                                  <li><a data-toggle="tab" href="#r2" onclick="javascript:carregaDadosEmail(23, 24);">Quando um aluno deixar uma dúvida</a></li>
                                  <li><a data-toggle="tab" href="#r3" onclick="javascript:carregaDadosEmail(25, 26);">Após 6 horas da dúvida deixada</a></li>
                                  <li><a data-toggle="tab" href="#r4" onclick="javascript:carregaDadosEmail(27, 28);">Após 12 horas da dúvida deixada</a></li>
                                  <li><a data-toggle="tab" href="#r5" onclick="javascript:carregaDadosEmail(29, 30);">Após 24 horas da dúvida deixada</a></li>
                                  <li><a data-toggle="tab" href="#r6" onclick="javascript:carregaDadosEmail(31, 32);">Após 48 horas da dúvida deixada</a></li>
                                  <li><a data-toggle="tab" href="#r7" onclick="javascript:carregaDadosEmail(33, 34);">Quando vendermos um curso dele</a></li>
                                  <li><a data-toggle="tab" href="#r8" onclick="javascript:carregaDadosEmail(35, 36);">Quando o mês for fechado (envio de relatório simplificado)</a></li>

                                  <li><a data-toggle="tab" href="#r9" onclick="javascript:carregaDadosEmail(37, 38);">Quando um pagamento for feito</a></li>
                                  <li><a data-toggle="tab" href="#r10" onclick="javascript:carregaDadosEmail(39, 40);">Quando uma notificação for deixada</a></li>

                              </ul>

                            <div class="tab-content">

                                <div id="r1" class="tab-pane active">

                                    <div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id21" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id22">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(21, 22); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <div id="r2" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id23" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id24">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(23, 24); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r3" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id25" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id26">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(25, 26); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r4" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id27" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id28">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(27, 28); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r5" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id29" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id30">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(29, 30); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r6" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id31" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id32">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(31, 32); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r7" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id33" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id34">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(33, 34); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r8" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id35" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id36">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(35, 36); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r9" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id37" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id38">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(37, 38); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r10" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id39" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id40">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(39, 40); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                            </div><!--tab-content-->

                        </div><!--tabbable tabs-left-->

                    </div>
					{/if}
					{if $id_atual eq 4}
					<div class="ui-tabs-panel ui-widget-content ui-corner-bottom">

                         <div class="tabs-left">

                              <ul class="nav nav-tabs">

                                  <li class="active"><a data-toggle="tab" href="#r1" onclick="javascript:carregaDadosEmail(13, 14);">Quando uma notificação for deixada</a></li>
                                  <li><a data-toggle="tab" href="#r2" onclick="javascript:carregaDadosEmail(15, 16);">Quando uma venda for feita</a></li>
                                  <li><a data-toggle="tab" href="#r3" onclick="javascript:carregaDadosEmail(17, 18);">Quando uma venda mudar de status</a></li>
                                  <li><a data-toggle="tab" href="#r4" onclick="javascript:carregaDadosEmail(19, 20);">Quando um certificado impresso for gerado / solicitado</a></li>

                              </ul>

                            <div class="tab-content">

                                <div id="r1" class="tab-pane active">

                                    <div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id13" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id14">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(13, 14); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <div id="r2" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id15" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id16">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(15, 16); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r3" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id17" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id18">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(17, 18); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r4" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id19" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id20">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(19, 20); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                            </div><!--tab-content-->

                        </div><!--tabbable tabs-left-->

                    </div>
					{/if}
					{if $id_atual eq 5}
					<div class="ui-tabs-panel ui-widget-content ui-corner-bottom">

                        <div class="tabs-left">

                              <ul class="nav nav-tabs">

                                  <li class="active"><a data-toggle="tab" href="#r1" onclick="javascript:carregaDadosEmail(5, 6);">Sua conta for criada</a></li>
                                  <li><a data-toggle="tab" href="#r2" onclick="javascript:carregaDadosEmail(7, 8);">Quando fecharmos o relatório do mês</a></li>
                                  <!-- <li><a data-toggle="tab" href="#r3" onclick="javascript:carregaDadosEmail(9, 10);">Quando um pagamento for feito</a></li> -->
                                  <li><a data-toggle="tab" href="#r4" onclick="javascript:carregaDadosEmail(11, 12);">Quando uma notificação for deixada</a></li>

                              </ul>

                            <div class="tab-content">

                                <div id="r1" class="tab-pane active">

                                    <div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id5" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id6">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(5, 6); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <div id="r2" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id7" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id8">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(7, 8); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r3" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id9" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id10">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(9, 10); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                                <div id="r4" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id11" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id12">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(11, 12); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                            </div><!--tab-content-->

                        </div><!--tabbable tabs-left-->

                    </div>
					{/if}
					{if $id_atual eq 6}
                    <div class="ui-tabs-panel ui-widget-content ui-corner-bottom">

                        <div class="tabs-left">

                              <ul class="nav nav-tabs">

                                  <li class="active"><a data-toggle="tab" href="#r1" onclick="javascript:carregaDadosEmail(1, 2);">Sua conta for criada</a></li>
                                  <li><a data-toggle="tab" href="#r2" onclick="javascript:carregaDadosEmail(3, 4);">Quando uma notificação for deixada</a></li>
                              </ul>

                            <div class="tab-content">

                                <div id="r1" class="tab-pane active">

                                    <div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id1" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id2">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(1, 2); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <div id="r2" class="tab-pane">
									
									<div class="row-fluid">

                                        <div class="span12">

                                            <form>

                                                <p>
                                                    <label>Título:*</labe><br />
                                                    <span class="field"><input type="text" id="id3" class="span8" placeholder="Digite o título"></span>
                                                </p>
            
                                                <p>

                                                    <div>
                                                    
														<textarea rows="15" cols="80" style="width: 80%" class="tinymce" id="id4">&lt;p&gt;Texto E-mail.&lt;/p&gt;</textarea>

                                                    </div>

                                                </p>

                                                <br />

                                                <input type="button" onclick="javascript:salvarDados(3, 4); return false;" name="submit" value="Alterar Texto" class="btn btn-primary">

                                            </form>

                                        </div>

                                    </div>
									
                                </div>

                            </div><!--tab-content-->

                        </div><!--tabbable tabs-left-->

                    </div>
					{/if}
                </div><!--tabbedwidget-->
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
    