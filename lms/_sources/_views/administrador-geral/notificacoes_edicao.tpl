
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
            
        </ul>
        
        <div class="pageheader">
             <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-exclamation"></span></div>
            <div class="pagetitle">
                <h5>Gerenciar Notificações</h5>
                <h1>Nova Notificação</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                        <div class="widgetbox">
                            <h4 class="widgettitle">Dados</h4>
                            <div class="widgetcontent">
                                
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="editar"/>
                                    <input type="hidden" value="{$notificacao.id}" name="id"/>
                                    
                                    <p>
                                        <label for="titulo">Título:*</label>
                                        <input type="text" name="titulo" id="titulo" class="input-xxlarge" placeholder="Adriano Gianini" value="{$notificacao.titulo}"/>
                                    </p>

                                    <!-- Destinatario -->
                                    <p>
                                        <label for="destinatario">Destinatário:*</label>
                                        <select name="destinatario_nivel" id="destinatario" class="uniformselect" onchange="mudarNivel();">
                                            <option value="0">Selecione o Destinatário</option>
                                            <option value="4" {if $notificacao.destinatario_nivel == 4} selected {/if}>Alunos</option>
                                            <option value="3" {if $notificacao.destinatario_nivel == 3} selected {/if}>Professores</option>
                                            <option value="5" {if $notificacao.destinatario_nivel == 5} selected {/if}>Parceiros</option>
                                            <option value="2" {if $notificacao.destinatario_nivel == 2} selected {/if}>Coordenadores</option>
                                            <option value="6" {if $notificacao.destinatario_nivel == 6} selected {/if}>Administrativo</option>
                                        </select> 
                                    </p>

                                    <!-- Curso -->
                                    <p id="campo_cursos" {if $notificacao.destinatario_nivel != 4} style="display:none;" {/if}>
                                        <label>Curso:*</label>
                                        <span class="formwrapper">
                                            <select data-placeholder="Selecione o Curso..." class="chzn-select span6" multiple="multiple" name="cursos[]" tabindex="4">
                                                <option value="0" {if "0"|in_array:$notificacao.cursos} selected {/if}>Todos os Cursos</option> 
                                                {foreach item=curso from=$cursos}
                                                <option value="{$curso.id}" {if $curso.id|in_array:$notificacao.cursos} selected {/if}>{$curso.curso}</option> 
                                                {/foreach}
                                            </select>
                                        </span>
                                    </p>
                                    
                                    <!-- Notificação -->
                                    <p>
                                        <label for="notificacao">Notificação:*</label>

                                        <div class="field">
                                            <textarea id="notificacao" name="conteudo" rows="15" cols="80" style="width: 80%" class="tinymce">{$notificacao.conteudo}</textarea>
                                        </div>
                                    </p>
                                    
                                    
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Enviar Notificação</button>
                                    </p>
                                </form>

                            </div>
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
{literal}
<script>
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});


function mudarNivel() {
    if (jQuery("#destinatario").val() == 4) {
        jQuery("#campo_cursos").show('slow');
    } else {
        jQuery("#campo_cursos").hide('slow');
    }
}
</script>
{/literal}