<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>LMS IAG - Painel</title>

{if $themecss != 'default'}
<link rel="stylesheet" href="{$url_site}/lms/common/css/style.default.css" type="text/css" />
<link id="skinstyle" rel="stylesheet" href="{$url_site}/lms/common/css/style.{$themecss}.css" type="text/css" />
{else}
<link rel="stylesheet" href="{$url_site}/lms/common/css/style.default.css" type="text/css" />
{/if}
<link rel="stylesheet" href="{$url_site}/lms/common/css/bootstrap-fileupload.min.css" type="text/css" />

<link rel="stylesheet" href="{$url_site}/lms/common/css/responsive-tables.css">
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/bootstrap-timepicker.min.js"></script>

<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.smartWizard.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.autogrow-textarea.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.alerts.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.jgrowl.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/prettify/prettify.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/charCount.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/colorpicker.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/ui.spinner.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery_cookie.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/modernizr.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/custom.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{$url_site}/lms/common/js/excanvas.min.js"></script><![endif]-->

<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.maskedinput.min.js"></script>
<!-- <script type="text/javascript" src="{$url_site}/lms/common/js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.maskedinput-1.3.js"></script> -->


<script type="text/javascript" src="{$url_site}/lms/common/js/elements.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/responsive-tables.js"></script>

<script type="text/javascript" src="{$url_site}/lms/common/js/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="{$url_site}/lms/common/js/wysiwyg.js"></script>

<script type="text/javascript" src="{$url_site}/lms/common/js/jquery.dataTables.min.js"></script>

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
            "aaSortingFixed": [[0,'asc']],
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
            <a href="{$url_site}/lms/administrador-geral/dashboard/home"><img src="{$url_site}/lms/common/images/logo.png" alt="" /></a>
        </div>
        <div class="headerinner">
            <ul class="headmenu">
                {if $notificacoes_topo.total != 0}
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
                            <a href="">
                                <img src="{$url_site}/lms/uploads/avatar/{$notificacao.avatar}" alt="" class="userthumb" />
                                <strong>{$notificacao.remetente}</strong>
                                <small>{$notificacao.data}</small>
                            </a>
                        </li>
                        {/foreach}
                        <li><a href="{$url_site}/lms/aluno/notificacoes/listar">VER TODAS NOTIFICAÇÕES</a></li>
                    </ul>
                </li>
                {/if}
              <li class="right">
                    <div class="userloggedinfo">
                        <img src="{$url_site}/lms/uploads/avatar/{$usuario_avatar}" alt="" />
                        <div class="userinfo">
                            <h5>{$usuario_nome} <small>- {$usuario_email}</small></h5>
                            <ul>
                                <li><a href="#modalSenha" data-toggle="modal">Alterar senha</a></li>
                                <li><a href="{$url_site}/lms/administrador-geral/login/logout">Sair</a></li>
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
                <li {if $menu == 1} class="active" {/if}><a href="{$url_site}/lms/administrador-geral/dashboard/home"><span class="iconfa-laptop"></span> Principal</a></li>
                <li class="dropdown {if $menu == 2} active {/if}"><a href="#"><span class="iconfa-group"></span> Gerenciar Alunos</a>
                    <ul>
                        <li><a href="{$url_site}/lms/administrador-geral/alunos/novo">Cadastrar Aluno</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/alunos/listar">Todos os Alunos</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/depoimentos/listar">Gerenciar depoimentos</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/curso/cursos-alunos">Consultar Situação</a></li>
                    </ul>
                </li>
                <li class="dropdown {if $menu == 3} active {/if}"><a href="#"><span class="iconfa-certificate"></span> Gerenciar Certificados</a>
                  <ul>
                      <li><a href="{$url_site}/lms/administrador-geral/certificados/relatorio">Relatórios de Certificados</a></li>
                  </ul>
                </li>
                <li class="dropdown {if $menu == 4} active {/if}"><a href="#"><span class="iconfa-user"></span> Gerenciar Professores</a>
                    <ul>
                        <li><a href="{$url_site}/lms/administrador-geral/professores/novo">Cadastrar Professor</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/professores/listar">Todos os Professores</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/professores/estatisticas">Estatísticas</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/professores/pagamentos">Gerenciar Pagamentos</a></li>
                    </ul>
                </li>
                
                <li class="dropdown {if $menu == 5} active {/if}"><a href="#"><span class="iconfa-briefcase"></span> Gerenciar Parceiros</a>
                    <ul>
                        <li><a href="{$url_site}/lms/administrador-geral/parceiros/novo">Cadastrar Parceiro</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/parceiros/listar">Gerenciar Parceiro</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/parceiros/relatorio">Relatórios de vendas</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/parceiros/comprovante">Repasses Financeiros</a></li>
                    </ul>
                </li>
                
                <li class="dropdown {if $menu == 6} active {/if}"><a href="#"><span class="iconfa-money"></span> Gerenciar Administrativo</a>
                    <ul>
                        <li><a href="{$url_site}/lms/administrador-geral/administrativos/novo">Cadastrar Usuário</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/administrativos/listar">Todos os Usuários</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/cupons/listar">Gerenciar Cupons</a></li>
                    </ul>
                </li>

                <li class="dropdown {if $menu == 14} active {/if}"><a href="#"><span class="iconfa-cogs"></span> Gerenciar Categorias</a>
                    <ul>
                        <li><a href="{$url_site}/lms/administrador-geral/categorias/listar"> Todas as Categorias</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/categorias/nova"> Nova Categoria</a></li>
                    </ul>
                </li>
                
                <li class="dropdown {if $menu == 7} active {/if}"><a href="#"><span class="iconfa-book"></span> Gerenciar Cursos</a>
                    <ul>
                        <li><a href="{$url_site}/lms/administrador-geral/curso/novo">Cadastrar Cursos/Produtos</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/curso/listar">Todos os Cursos</a></li>
                    </ul>
                </li>

                <li class="dropdown {if $menu == 15} active {/if}"><a href="#"><span class="iconfa-tasks"></span> Canto do Empreendedor</a>
                  <ul>
                      <li><a href="{$url_site}/lms/administrador-geral/empreendedor/listar">Listar</a></li>
                      <li><a href="{$url_site}/lms/administrador-geral/empreendedor/novo">Cadastrar</a></li>
                    </ul>
                </li>

                <li class="dropdown {if $menu == 8} active {/if}"><a href="#"><span class="iconfa-reorder"></span> Gerenciar Planos</a>
                  <ul>
                      <li><a href="{$url_site}/lms/administrador-geral/planos/listar">Todos os Planos</a></li>
                      <li><a href="{$url_site}/lms/administrador-geral/planos/novo">Adicionar Plano</a></li>
                    </ul>
                </li>
                
                <li class="dropdown {if $menu == 9} active {/if}"><a href="#"><span class="iconfa-bar-chart"></span> Gerenciar Vendas</a>
                    <ul>
                        <li><a href="{$url_site}/lms/administrador-geral/vendas/nova">Nova Venda</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/vendas/relatorio">Relatórios de Vendas</a></li>
                    </ul>
                </li>

                <li class="dropdown {if $menu == 10} active {/if}"><a href="#"><span class="iconfa-exclamation"></span> Gerenciar Notificações</a>
                  <ul>
                      <li><a href="{$url_site}/lms/administrador-geral/notificacoesadmin/nova">Nova Notificação</a></li>
                      <li><a href="{$url_site}/lms/administrador-geral/notificacoesadmin/listar">Todas as Notificações</a></li>
                    </ul>
                </li>

                <li class="dropdown {if $menu == 11} active {/if}"><a href="#"><span class="iconfa-user"></span> Gerenciar Administrador</a>
                  <ul>
                      <li><a href="{$url_site}/lms/administrador-geral/administradores/novo">Cadastrar Administrador</a></li>
                      <li><a href="{$url_site}/lms/administrador-geral/administradores/listar">Todos os Administradores</a></li>
                    </ul>
                </li>

                <li class="dropdown {if $menu == 12} active {/if}"><a href="#"><span class="iconfa-group"></span> Gerenciar Coordenadores</a>
                  <ul>
                      <li><a href="{$url_site}/lms/administrador-geral/coordenadores/novo">Cadastrar Coordenador</a></li>
                      <li><a href="{$url_site}/lms/administrador-geral/coordenadores/listar">Todos os Coordenadores</a></li>
                    </ul>
                </li>
                <li class="dropdown {if $menu == 14} active {/if}"><a href="#"><span class="iconfa-group"></span> Gerenciar Coordenador Parceiro</a>
                  <ul>
                      <li><a href="{$url_site}/lms/administrador-geral/coordenadorparceiros/novo">Cadastrar Coordenador Parceiro</a></li>
                      <li><a href="{$url_site}/lms/administrador-geral/coordenadorparceiros/listar">Todos os Coordenadores Parceiros</a></li>
                    </ul>
                </li>
                
                <li class="dropdown {if $menu == 13} active {/if}"><a href="#"><span class="iconfa-cogs"></span> Configurações Gerais</a>
                    <ul>
                        <li><a href="{$url_site}/lms/administrador-geral/configuracoesgerais/produtos">Variações de Produtos</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/emails/listar">Modelos de E-mails</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/configuracoesgerais/termos">Termos e Condições</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/configuracoesgerais/pagamentos">Configurações de Pagamento</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/configuracoesgerais/imagens">Configurações de Imagens</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/configuracoesgerais/certificados">Configurações do Certificado</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/configuracoesgerais/servidores">Servidor</a></li>
                        <li><a href="{$url_site}/lms/administrador-geral/configuracoesgerais/graficas">Gráfica</a></li>
                    </ul>
                </li>
                
                <li><a href="{$url_site}/lms/administrador-geral/login/logout"><span class="iconfa-signout"></span> Sair</a></li>
                
            </ul>
        </div><!--leftmenu-->
        
    </div><!-- leftpanel -->
