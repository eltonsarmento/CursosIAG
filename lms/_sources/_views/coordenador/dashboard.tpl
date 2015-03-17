    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/coordenador/dashboard"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Painel de Controle</li>
        </ul>
        <!-- BUSCA TOPO -->
        <div class="pageheader">
            {include file="coordenador/busca_topo.tpl"}
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                <h5>Resumo</h5>
                <h1>Painel Coordenador</h1>
            </div>
        </div>
        
        <!-- FIM BUSCA TOPO -->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <div id="dashboard-left" class="span8">
                        
                        <h5 class="subtitle">Itens</h5>
                        <ul class="shortcuts">
                            <li class="events">
                                <a href="/lms/coordenador/categorias/listar">
                                    <span class="shortcuts-icon iconsi-quiz"></span>
                                    <span class="shortcuts-label">Ger. Categorias</span>
                                </a>
                            </li>
                            <li class="events">
                                <a href="/lms/coordenador/curso/listar">
                                    <span class="shortcuts-icon iconsi-event"></span>
                                    <span class="shortcuts-label">Ger. Cursos</span>
                                </a>
                            </li>
                            <li class="events">
                                <a href="/lms/coordenador/professores/listar">
                                    <span class="shortcuts-icon iconsi-profile"></span>
                                    <span class="shortcuts-label">Ger. Professores</span>
                                </a>
                            </li>
                        </ul>
                        
                        <br />
                        
                        <h5 class="subtitle">Cursos Cadastrados</h5><br />
                        <table class="table table-bordered responsive">
                            <thead>
                                <tr>
                                    <th class="head1">Curso</th>
                                    <th class="head0">Professor</th>
                                    <th class="head1">Data Cadastro</th>
                                </tr>
                            </thead>

                            <tbody>
                                {foreach item=curso from=$cursos}
                                <tr>
                                    <td>{$curso.curso}</td>
                                    <td class="center">{$curso.professor.nome}</td>
                                    <td class="center">{$curso.data_cadastro|date_format:"%d/%m/%Y"}</td>
                                </tr>
                                {/foreach}
                            </tbody>
                        </table>                                              
                        
                        <div class="divider30"></div>
                        
                    </div><!--span8-->
                    
                    <div id="dashboard-right" class="span4">
                        
                        <h5 class="subtitle">ÚLTIMA NOTIFICAÇÃO</h5>
                        
                        <div class="divider15"></div>
                        
                       {if !empty($ultimaNotificacao)}
                        <div class="alert alert-block">
                              <button data-dismiss="alert" class="close" type="button">&times;</button>
                              <h4>{$ultimaNotificacao.titulo}</h4>
                              <p style="margin: 8px 0">{$ultimaNotificacao.conteudo}</p>
                        </div><!--alert-->
                        {/if}
                        
                        <br />
                        
                        
                        <div class="tabbedwidget tab-primary">
                            <ul>
                                <li><a href="#tabs-1"><span class="iconfa-book"></span> Últimos Cursos</a></li>
                                <li><a href="#tabs-2"><span class="iconfa-user"></span> Últimos Professores</a></li>
                            </ul>
                            <div id="tabs-1" class="nopadding">
                                <h5 class="tabtitle">CURSOS</h5>
                                <ul class="userlist">
                                    {foreach item=curso from=$cursos}
                                    <li>
                                        <div>
                                            <img src="/lms/uploads/avatar/{$curso.professor.avatar}" alt="" class="pull-left" />
                                            <div class="uinfo">
                                                <h5>{$curso.professor.nome}</h5>
                                                <span class="pos">{$curso.curso}</span>
                                                <br/>
                                            </div>
                                        </div>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                            <div id="tabs-2" class="nopadding">
                                <h5 class="tabtitle">PROFESSORES</h5>
                                <ul class="userlist userlist-favorites">
                                    {foreach item=professor from=$professores}
                                    <li>
                                        <div>
                                            <img src="/lms/uploads/avatar/{$professor.avatar}" alt="" class="pull-left" />
                                            <div class="uinfo">
                                                <h5>{$professor.nome}</h5>
                                                <p class="link">
                                                    <a href="/lms/coordenador/professores/editar/{$professor.id}"><i class="iconfa-pencil"></i> Editar</a>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                        
                        <br />
                                                
                    </div><!--span4-->
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
 