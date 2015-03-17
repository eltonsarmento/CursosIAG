<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cursos IAG - Painel</title>
{if $themecss != 'default'}
<link rel="stylesheet" href="/lms/common/css/style.default.css" type="text/css" />
<link id="skinstyle" rel="stylesheet" href="/lms/common/css/style.{$themecss}.css" type="text/css" />
{else}
<link rel="stylesheet" href="/lms/common/css/style.default.css" type="text/css" />
{/if}
<link rel="stylesheet" href="/lms/common/css/responsive-tables.css">
<link rel="stylesheet" href="/lms/common/css/bootstrap-fileupload.min.css" type="text/css" />

<script type="text/javascript" src="/lms/common/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/lms/common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/lms/common/js/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src="/lms/common/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.smartWizard.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.autogrow-textarea.js"></script>
<script type="text/javascript" src="/lms/common/js/charCount.js"></script>
<script type="text/javascript" src="/lms/common/js/colorpicker.js"></script>
<script type="text/javascript" src="/lms/common/js/ui.spinner.min.js"></script>
<script type="text/javascript" src="/lms/common/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery_cookie.js"></script>
<script type="text/javascript" src="/lms/common/js/modernizr.min.js"></script>
<script type="text/javascript" src="/lms/common/js/custom.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.alerts.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.base64.js"></script>  
<script type="text/javascript" src="/lms/common/js/kmf.jquery.js"></script>  
<!-- <script type="text/javascript" src="/lms/common/js/elements.js"></script> -->


<script type="text/javascript" src="/lms/common/js/jquery.maskedinput.min.js"></script>
<!-- <script type="text/javascript" src="/lms/common/js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.maskedinput-1.3.js"></script> -->
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/lms/common/js/excanvas.min.js"></script><![endif]-->

<script type="text/javascript" src="/lms/common/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/lms/common/js/responsive-tables.js"></script>  

{literal}
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
        if(jQuery('.tooltipsample').length > 0)
            jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
            
        jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});

        jQuery('select.uniformselect').uniform();
        
         jQuery('#dyntable').dataTable({
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            },
            "oLanguage":{
                "sProcessing":   "Processando...",
                "sLengthMenu":   "Mostrar _MENU_ registros",
                "sZeroRecords":  "Não foram encontrados resultados",
                "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                "sInfoPostFix":  "",
                "sSearch":       "Buscar:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext":     "Próximo",
                    "sLast":     "Último"
                }
            }
        });


    });
</script>  
{/literal}

</head>

<body>

<div class="mainwrapper">
    
    <div class="header">
        <div class="logo">
            <a href="/lms/professor/dashboard/home"><img src="/lms/common/images/logo.png" alt="" /></a>
        </div>
        <div class="headerinner">
            <ul class="headmenu">
                {if $duvidas_topo.total != 0}
                <!-- DUVIDAS -->
                <li class="odd">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="count">{$duvidas_topo.total}</span>
                        <span class="head-icon head-message"></span>
                        <span class="headmenu-label">Minhas Dúvidas</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-header">Dúvidas</li>
                        {foreach item=duvida_topo from=$duvidas_topo.resultado}
                        <li><a href="/lms/professor/duvidas/listar/{$duvida_topo.duvida_id}"><span class="icon-envelope"></span> Nova mensagem de <strong>{$duvida_topo.remetente}</strong> <small class="muted"> - {$duvida_topo.horas} horas atrás</small></a></li>
                        {/foreach}
                        <li class="viewmore"><a href="/lms/professor/duvidas/listar">Ver todas as dúvidas</a></li>
                    </ul>
                </li>
                {/if}

                <!-- NOTIFICACOES -->
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#">
                    <span class="count">{$notificacoes_topo.total}</span>
                    <span class="head-icon head-users"></span>
                    <span class="headmenu-label">Minhas Notificações</span>
                    </a>
                    <ul class="dropdown-menu newusers">
                        <li class="nav-header">Notificações</li>
                        {foreach from=$notificacoes_topo.resultado item=notificacao}
                        <li>
                            <a href="/lms/professor/notificacoes/listar/{$notificacao.id}">
                                <img src="/lms/uploads/avatar/{$notificacao.avatar}" alt="" class="userthumb" />
                                <strong>{$notificacao.remetente}</strong>
                                <small>{$notificacao.data}</small>
                            </a>
                        </li>
                        {/foreach}
                        <li><a href="/lms/professor/notificacoes/listar">VER TODAS NOTIFICAÇÕES</a></li>
                    </ul>
                </li>
                
                <li class="right">
                    <div class="userloggedinfo">
                        <img src="/lms/uploads/avatar/{$usuario_avatar}" alt="" />
                        <div class="userinfo">
                            <h5>{$usuario_nome} <small>- {$usuario_email}</small></h5>
                            <ul>
                                <li><a href="#modalSenha" data-toggle="modal">Alterar senha</a></li>
                                <li><a href="/lms/professor/login/logout">Sair</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul><!--headmenu-->
        </div>
    </div>
    
    <div class="leftpanel">
        
        <div class="leftmenu">        
            <ul class="nav nav-tabs nav-stacked">
            	<li class="nav-header">Navegação</li>
                <li {if $menu == 1} class="active" {/if}><a href="/lms/professor/dashboard/home"><span class="iconfa-laptop"></span> Principal</a></li>
                <li class="dropdown {if $menu == 2} active {/if}"><a href=""><span class="iconfa-tasks"></span> Painel do Professor</a>
                	<ul>
                    	<li><a href="/lms/professor/cursos/listar">Meus Cursos</a></li>
                        <li><a href="/lms/professor/duvidas/listar">Minhas Dúvidas</a></li>
                        <li><a href="/lms/professor/notificacoes/listar">Minhas Notificações</a></li>
                        <li><a href="/lms/professor/pagamentos/listar">Meus Pagamentos</a></li>
                        <li><a href="/lms/professor/vendas/listar">Minhas Vendas</a></li>
                        <li><a href="/lms/professor/quiz/listarCursos">Meus Questionários</a></li>
                    </ul>
                </li>
                
                <li><a href="/lms/professor/login/logout"><span class="iconfa-signout"></span> Sair</a></li>
                
            </ul>
        </div><!--leftmenu-->
        
    </div><!-- leftpanel -->