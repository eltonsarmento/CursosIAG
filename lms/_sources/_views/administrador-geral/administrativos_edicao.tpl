
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-user"></span></div>
            <div class="pagetitle">
                <h5>GERENCIAR Administrativo</h5>
                <h1>{if $administrativo.id}Edição{else}Cadastro{/if} de Usuário</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
                <a href="/lms/administrador-geral/administrativos/listar" class="btn btn-large"><i class="iconfa-caret-left"></i> Voltar</a> <br/><br/>

                <div class="widget">
                    <h4 class="widgettitle">Dados do Usuário</h4>
                    <div class="widgetcontent">
                
                        <form class="stdform" method="post" action="" enctype="multipart/form-data">
                            <div class="par control-group">
                                <input type="hidden" value="1" name="editar"/>
                                <input type="hidden" value="{$administrativo.id}" name="id"/>
                                
                                <!-- NOME COMPLETO -->
                                <label class="control-label" for="firstname">Nome Completo:*</label>
                                <div class="controls"><input type="text" name="nome" id="firstname" class="input-xxlarge" placeholder="Adriano Gianini" value="{$administrativo.nome}"/></div>
                                
                                <!-- E-MAIL -->
                                <label class="control-label" for="firstname">E-mail:*</label>
                                <div class="controls"><input type="text" name="email" id="firstname" class="input-xxlarge" placeholder="seuemail@seudominio.com.br" value="{$administrativo.email}"/></div>
                                
                                <!-- SENHA -->
                                <label class="control-label" for="firstname">Senha:*</label>
                                <div class="controls"><input type="password" name="senha" id="firstname" class="input-xlarge" placeholder="Sua senha"/></div>
                                
                                <!-- STATUS -->
                                <label class="control-label" for="firstname">Status:*</label>
                                <div class="controls">
                                    <select name="ativo">
                                        <option value="1" {if $administrativo.ativo == 1} selected="selected" {/if}>Ativo</option>
                                        <option value="0" {if $administrativo.ativo == 0} selected="selected" {/if}>Inativo</option>
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
                                {if $administrativo.avatar}
                                    <input type="hidden" value="{$administrativo.avatar}" name="visualizar_avatar"/>
                                    <label><img src="/lms/uploads/avatar/{$administrativo.avatar}" width="100" /></label><div style="clear:both;"></div>
                                {/if}
                                
                            </div>
                            <p class="stdformbutton">
                                <button class="btn btn-primary">{if $administrativo.id}Editar{else}Cadastrar{/if} Usuário</button>
                            </p>
                       </form>
                       </div>
                       <!-- FIM CADASTRO ADMINISTRATIVO -->
                       <!-- ADMINISTRATIVOS CADASTRADOS -->
                       <!--<div class="span6">
                        <div class="widgetbox">
                            <h4 class="widgettitle">Administrativos Cadastrados <a class="close">&times;</a> <a class="minimize">&#8211;</a></h4>
                            <div class="widgetcontent">
                               
                              <table class="table table-bordered">
                                
                                    <thead>  
                                        <th>Nome do administrativo</th>
                                        <th>E-mail</th>
                                        <th class="center">Status</th>
                                        <th>Ações</th>
                                    </thead>
                                    
                                    <tbody>
                                      
                                        {foreach item=administrativo from=$administrativos}
                                        <tr>
                                            <td>{$administrativo.nome}</td>
                                            <td>{$administrativo.email}</td>
                                            <td class="center">
                                                {if $administrativo.ativo == 1}
                                                    <span class="label label-success"><i class="iconfa-ok"></i> Ativo</span>
                                                {else}
                                                    <span class="label label-important"><i class="iconfa-remove"></i> Inativo</span>
                                                {/if}
                                            </td>
                                            <td width="90"> 
                                                <ul class="tooltipsample">
                                                    <li><a href="/lms/administrador-geral/administrativos/editar/{$administrativo.id}" class="btn" data-placement="bottom" data-rel="tooltip" data-original-title="Editar Parceiro"><i class="iconfa-pencil"></i></a></li>
                                                    <li><a href="javascript:;" onclick="javascript:deletar({$administrativo.id})" class="btn btn-primary confirmbutton" data-placement="bottom" data-rel="tooltip" data-original-title="Remover Parceiro"><i class="iconfa-remove"></i></a></li>
                                                   
                                                </ul>
                                            </td>
                                        </tr>
                                        {/foreach}
                                       
                                    </tbody>
                                
                                </table>
                               
                            </div>
                        </div>
                       </div>-->
                       <!-- FIM ADMINISTRATIVOS CADASTRADOS -->
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
    jConfirm('Deseja excluir este administrativo?', 'Excluir Administrativo', function(r) {
         if (r) {
        {/literal}
        window.location.href='{$url_site}lms/administrador-geral/administrativos/apagar/'+id;
        {literal}
    }     
    });
}
</script>  
{/literal}