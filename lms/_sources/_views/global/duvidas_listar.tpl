  <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/{$categoria}/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="/lms/{$categoria}/dashboard/home">Painel principal</a> <span class="separator"></span></li>
            <li>Minhas Dúvidas</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="$categoria/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-envelope"></span></div>
            <div class="pagetitle">
                <h5>Painel principal</h5>
                <h1>Minhas Dúvidas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="messagepanel">
                    <a href="/lms/{$categoria}/duvidas/nova" class="btn btn-success btn-large">Criar nova dúvida</a>
                    </div><!--messagehead-->
                    <div class="messagemenu">
                        <ul>
                            <li class="back"><a><span class="iconfa-chevron-left"></span> Voltar</a></li>
                            <li class="active"><a href=""><span class="iconfa-inbox"></span> Dúvidas</a></li>
                            <li><a href=""><span class="iconfa-trash"></span> Lixeira</a></li>
                        </ul>
                    </div>
                    <div class="messagecontent">
                        <!-- LISTAGEM DE DUVIDAS -->
                        <div class="messageleft">
                            <form class="messagesearch">
                                <input type="text" class="input-block-level" />
                            </form>
                            <ul class="msglist">
                                {if empty($duvidas)}
                                    <li><strong>SEM MENSAGENS</strong></li>
                                {else}
                                    {foreach item=duvida from=$duvidas}
                                    <li {if $duvida.duvida_id == $duvida_selecionada}class="selected" {else} {/if}> 
                                        <a href="/lms/{$categoria}/duvidas/listar/{$duvida.duvida_id}" style="text-decoration:none;">
                                        <div class="thumb"><img src="/lms/uploads/avatar/{$duvida.usuario_avatar}" alt="" /></div>
                                        <div class="summary">
                                            <span class="date pull-right"><small>{$duvida.data}</small></span>
                                            <h4>{$duvida.usuario_nome}</h4>
                                            <p><strong>{$duvida.titulo}</strong></p>
                                        </div>
                                        </a>
                                    </li>
                                    {/foreach}
                                {/if}
                            </ul>
                        </div><!--messageleft-->
                        <div class="messageright">
                            <div class="messageview">
                                
                                <div class="btn-group pull-right">
                                    <button data-toggle="dropdown" class="btn dropdown-toggle">Ações <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Excluir Dúvida</a></li>
                                    </ul>
                                </div>
                                
                                <h1 class="subject">Função IF</h1>
                                <div class="msgauthor aluno">
                                    <div class="thumb"><img src="images/photos/thumb1.png" alt="" /></div>
                                    <div class="authorinfo">
                                        <span class="date pull-right">26 de Maio de 2013</span>
                                        <h5><strong>Adriano Gianini</strong> <span>adriano@cursosiag.com.br</span></h5>
                                        <span class="to">Curso de PHP5</span>
                                    </div><!--authorinfo-->
                                </div><!--msgauthor-->
                                <div class="msgbody aluno">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas</p>
                                    
                                    <p>It aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    
                                    <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                                    <p>Regards, <br />Leevanjo</p>
                                </div><!--msgbody-->
                                
                                <div class="msgauthor">
                                    <div class="thumb"><img src="images/photos/thumb10.png" alt="" /></div>
                                    <div class="authorinfo">
                                        <span class="date pull-right">27 de Maio de 2013</span>
                                        <h5><strong>Davi Oliveira</strong> <span>davioliveira@cursosiag.com.br</span></h5>
                                        <span class="to">Curso de PHP5</span>
                                    </div><!--authorinfo-->
                                </div><!--msgauthor-->
                                <div class="msgbody">
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas</p>
                                    
                                    <p>It aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    <p>- Draneim</p>
                                </div><!--msgbody-->
                                
                                <div class="msgauthor aluno">
                                    <div class="thumb"><img src="images/photos/thumb1.png" alt="" /></div>
                                    <div class="authorinfo">
                                        <span class="date pull-right">27 de Maio de 2013</span>
                                        <h5><strong>Adriano Gianini</strong> <span>adriano@cursosiag.com.br</span></h5>
                                        <span class="to">Curso de PHP5</span>
                                    </div><!--authorinfo-->
                                </div><!--msgauthor-->
                                <div class="msgbody aluno">
                                    <p>It aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                </div><!--msgbody-->
                                
                                <div class="msgauthor">
                                    <div class="thumb"><img src="images/photos/thumb10.png" alt="" /></div>
                                    <div class="authorinfo">
                                        <span class="date pull-right">27 de Maio de 2013</span>
                                        <h5><strong>Davi Oliveira</strong> <span>davioliveira@cursosiag.com.br</span></h5>
                                        <span class="to">Curso de PHP5</span>
                                    </div><!--authorinfo-->
                                </div><!--msgauthor-->
                                <div class="msgbody">                                    
                                    <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
                                </div><!--msgbody-->
                            </div><!--messageview-->
                            
                            <div class="msgreply">
                                <div class="thumb"><img src="images/photos/thumb1.png" alt="" /></div>
                                <div class="reply">
                                    <textarea placeholder="Digite aqui..."></textarea>
                                    <button class="btn btn-primary">Enviar</button>
                                </div><!--reply-->

                            </div><!--messagereply-->
                            
                        </div><!--messageright-->
                    </div><!--messagecontent-->
                </div><!--messagepanel-->
                
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