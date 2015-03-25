    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/curso/cursos-alunos"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Aluno</a> <span class="separator"></span></li>
            <li>Meus Cursos</li>  
        </ul>
        
        <div class="pageheader">
            <!-- <!-- BUSCA TOPO -->
            <!-- {include file="aluno/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-book"></span></div>
            <div class="pagetitle">
                <h5>Painel do Aluno</h5>
                {if $nome_aluno != ''}
                    <h1>Cursos do Aluno: {$nome_aluno}</h1>
                {else}
                    <h1>Consultar Cursos de Alunos</h1>
                {/if}
            </div>

            <form action="/lms/administrador-geral/curso/cursos-alunos" method="post" class="right searchbar">
                <label>Informe o Id do aluno:</label>                

                <input type="text" name="id" placeholder="Digite sua busca...">

                <button class="btn btn-primary">Buscar</button>

            </form>
        </div><!--pageheader-->

        
        
        <div class="maincontent">
            <div class="maincontentinner">
                
                <div class="row-fluid">

                  <div class="span6">
                        <!-- CURSOS ANDAMENTO -->
                        <div class="widgetbox">
                            <h4 class="widgettitle title-primary">Cursos em Andamento</h4>
                            <div class="widgetcontent">
                                {foreach item=curso from=$andamento name=cursos_andamento}
                                    <div>
                                        <div class="media">
                                            <img src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" style="width:222px; height:124px" class="img-polaroid pull-left">
                                            <div class="media-body">
                                                <h4 class="media-heading"><strong>{$curso.curso}</strong></h4>
                                                <i class="iconfa-user"></i> {$curso.professor}
                                                <div class="media">
                                                    <i class="iconfa-film"></i> {$curso.aulas_total} Aulas | 
                                                    <i class="iconfa-time"></i> Expira em: <strong>{$curso.expira|date_format:"%d/%m/%Y"}</strong> |
                                                    <i class="iconfa-bar-chart"></i> Concluído: <strong>{$curso.porcentagem}%</strong> | 
                                                    <i class="iconfa-signin"></i> Último Acesso: {if $curso.ultimo_acesso != '0000-00-00'} <strong>{$curso.ultimo_acesso|date_format:"%d/%m/%Y"}</strong> {/if}<br> 
                                                    <i class="iconfa-signin"></i> Última Aula: {if $curso.aula} <strong>{$curso.aula}</strong> {/if}
                                                    <a href="{$url_site}lms/aluno/cursos/verCurso/{$curso.id}" class="btn btn-warning margintop18 right"><i class="iconfa-repeat"></i> Retomar Curso</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {if not $smarty.foreach.cursos_andamento.last} <hr> {/if}
                                {/foreach}
                            </div>
                        </div>
                        <!-- FIM CURSOS ANDAMENTO -->

                  </div>

                  <div class="span6">
                        <!-- CURSOS CONCLUIDOS -->
                        <div class="widgetbox">
                            <h4 class="widgettitle title-primary">Cursos Concluídos</h4>
                            <div class="widgetcontent">
                                {foreach item=curso from=$concluidos name=cursos_concluidos}
                                    <div>
                                        <div class="media">
                                            <img src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" style="width:222px; height:124px" class="img-polaroid pull-left">
                                            <div class="media-body">
                                                <h4 class="media-heading"><strong>{$curso.curso}</strong></h4>
                                                <i class="iconfa-user"></i> {$curso.professor}
                                                <div class="media">
                                                    <i class="iconfa-film"></i> {$curso.aulas_total} Aulas | 
                                                    <i class="iconfa-bar-chart"></i> Concluído: <strong class="label label-success">100%</strong>  | 
                                                    <i class="iconfa-signin"></i> Último Acesso: {if $curso.ultimo_acesso != '0000-00-00'} <strong>{$curso.ultimo_acesso|date_format:"%d/%m/%Y"}</strong> {/if}<br/>

                                                    <a href="{$url_site}lms/aluno/cursos/verCurso/{$curso.id}" class="btn btn-inverse margintop18"><i class="iconfa-arrow-right"></i> Assistir Aulas</a>
                                                    {if $curso.curso_certificado && $certificado}
                                                    <a href="{$url_site}lms/aluno/certificados/solicitar-certificado/{$curso.id}" class="btn btn-success margintop18"><i class="iconfa-ok"></i> Solicitar Certificado</a>
                                                    {/if}
                                                    <a href="#myModal" onclick="setarDados({$curso.id})" data-toggle="modal" class="btn btn-info margintop18"><i class="iconfa-comment"></i> Escrever Depoimento</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {if not $smarty.foreach.cursos_conluidos.last} <hr> {/if}
                                {/foreach}
                            </div>
                        </div>
                        <!-- FIM CURSOS CONCLUIDOS -->

                  </div>

                </div>
                
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

<!-- MODAL -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Escrever Depoimento</h3>
    </div>
    <div class="modal-body">
        <div id="retornoDepoimento"></div>
        <form action="" onsubmit="return false;" id="formModal">
            <input type="hidden" value="1" name="enviar"/>
            <input type="hidden" value="" name="matricula_id" id="matricula_id"/>
            <p class="margintop10">
                <textarea cols="30" rows="5" class="span5" name="texto" id="modal_texto"></textarea>
            </p>
        <button class="btn btn-primary" onclick="enviarDepoimento(); return false;">Enviar Depoimento</button>

        </form>

    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div><!--#myModal-->


{literal}
<script type="text/javascript">
function setarDados(matriculaID) {
    jQuery('#matricula_id').val(matriculaID);
}

function enviarDepoimento() {
    jQuery.post('/lms/aluno/cursos/depoimento/', jQuery('#formModal').serialize(), function html(html) { jQuery('#retornoDepoimento').html(html) });
}
</script>
{/literal}