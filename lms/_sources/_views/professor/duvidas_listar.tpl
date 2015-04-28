  <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/professor/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="javascript:;">Painel do professor</a> <span class="separator"></span></li>
            <li>Minhas Dúvidas</li>
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="professor/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-envelope"></span></div>
            <div class="pagetitle">
                <h5>Painel principal</h5>
                <h1>Minhas Dúvidas</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                    <div class="messagemenu">
                        <ul>
                            <li class="back"><a><span class="iconfa-chevron-left"></span> Voltar</a></li>
                            <li {if $secao == 1} class="active" {/if}><a href="/lms/professor/duvidas/listar/"><span class="iconfa-inbox"></span> Dúvidas</a></li>
                            <li {if $secao == 2} class="active" {/if}><a href="/lms/professor/duvidas/excluidos/"><span class="iconfa-trash"></span> Lixeira</a></li>
                        </ul>
                    </div>
                    <div class="messagecontent">
                        <!-- LISTAGEM DE DUVIDAS -->
                        <div class="messageleft">
                            <form class="messagesearch" action="">
                                <input type="text" name="palavra" class="input-block-level" />
                            </form>
                            <ul class="msglist">
                                {if empty($duvidas)}
                                    <li><strong>SEM MENSAGENS</strong></li>
                                {else}
                                    {foreach item=duvidaLateral from=$duvidas}
                                    <li {if $duvidaLateral.id == $duvida_selecionada} class="selected" {elseif $duvidaLateral.mensagem.lido == 0 && $duvidaLateral.mensagem.remetente_id != $usuario_id} class="unread" {/if}> 
                                        <a href="/lms/professor/duvidas/listar/{$duvidaLateral.id}" style="text-decoration:none;">
                                            <div class="thumb"><img src="/lms/uploads/avatar/{$duvidaLateral.avatar}" alt="" /></div>
                                            <div class="summary">
                                                <span class="date pull-right"><small>{$duvidaLateral.mensagem.data|date_format:"%d/%m/%Y"}</small></span>
                                                <h4>{$duvidaLateral.nome}</h4>
                                                <p><strong>{$duvidaLateral.titulo}</strong> - {$duvidaLateral.mensagem.comentario|substr:0:20}...</p>
                                            </div>
                                        </a>
                                    </li>
                                    {/foreach}
                                {/if}
                            </ul>
                        </div><!--messageleft-->
                         <div class="messageright">
                            {if $duvida.id}
                            <div class="messageview">
                                
                                <div class="btn-group pull-right">
                                    <button data-toggle="dropdown" class="btn dropdown-toggle">Ações <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="/lms/professor/duvidas/excluir/{$duvida.id}">Deletar Dúvida</a></li>
                                        {if $duvida.fechada == 0}
                                        <li><a href="/lms/aluno/duvidas/fechar/{$duvida.id}">Fechar Dúvida</a></li>
                                        {/if}
                                    </ul>
                                </div>
                                
                                <h1 class="subject">{$duvida.titulo}</h1>
                                {foreach item=mensagem from=$duvida.mensagens}
                                    <div class="msgauthor {if $mensagem.aluno} aluno {/if}">
                                        <div class="msgbody">
                                            <p>{$mensagem.comentario}</p>
                                        </div>
                                        <br clear="both"/>
                                        <div class="thumb"><img src="/lms/uploads/avatar/{$mensagem.remetente.avatar}" alt="" /></div>
                                        <div class="authorinfo">
                                            <h5><strong>{$mensagem.remetente.nome}</strong> <span>{$mensagem.remetente.email}</span></h5>
                                            <span class="to">{$duvida.curso.curso}</span>
                                        </div><!--authorinfo-->
                                    </div><!--msgauthor-->
                                {/foreach}
                            </div><!--messageview-->
                            
                            <div class="msgreply">
                                <form action="/lms/professor/duvidas/responder/{$duvida.id}" method="post"/>
                                    <input type="hidden" value="enviar"/>
                                    <div class="reply">
                                        <textarea placeholder="Digite aqui..." name="comentario" required=""></textarea>
                                        <button class="btn btn-primary">Enviar</button>
                                    </div><!--reply-->
                                </form>

                            </div><!--messagereply-->
                            {/if}
                            
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