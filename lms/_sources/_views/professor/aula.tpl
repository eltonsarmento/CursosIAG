    <script type="text/javascript" src="{$url_site}lms/common/site/js/jwplayer/jwplayer.js" ></script>
    <script type="text/javascript" src="{$url_site}lms/common/site/js/jwplayer/jwplayer.html5.js"></script>
    <script type="text/javascript">jwplayer.key="iutRDqcT78F7yRwhJrXKoCvFzYyfVxWm4kAJuA==";</script>
    <div class="rightpanel">
    
        <ul class="breadcrumbs">
            <li><a href="{$url_site}lms/professor/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Professor</a> <span class="separator"></span></li>
            <li>Meus Cursos</li>            
        </ul>
        
        <div class="pageheader">

            <form action="" method="post" class="right searchbar">

                <select name="tipo" id="aulaSelect" style="width:300px;">
                    {foreach item=capituloBusca from=$capitulos}
                        <optgroup label="{$capituloBusca.descricao}">
                            {foreach item=aulaBusca from=$capituloBusca.aulas}
                                <option value="{$aulaBusca.aula_id}">{$aulaBusca.nome}</option>
                            {/foreach}
                        </optgroup>
                    {/foreach}
                </select>

                <button class="btn btn-primary" id="btnIr">Ir</button>

            </form>

            <div class="pageicon"><span class="iconfa-book"></span></div>
            <div class="pagetitle">

                <h5>{$curso.curso}</h5>
                <h1>Aula {$aula.posicao} - {$aula.nome}</h1>
                <h5>Capítulo {$capitulo.capitulo}</h5>

            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">

            <div class="maincontentinner">
                <div class="row-fluid">
                    <div class="span8">
                        <h4 class="widgettitle">Aula {$aula.posicao} - {$aula.nome}</h4>
                        <div class="widgetcontent">
                            {if $aula.tipo == 1}
                                <div id='playeraUISyNghULzm'></div>
                                <script type='text/javascript'>
                                    jwplayer('playeraUISyNghULzm').setup({ldelim}
                                        logo: {ldelim}     
                                            file: "{$url_site}lms/common/site/js/jwplayer/imagens/logo-cursosiag.png",
                                            link: "{$url_site}"
                                        {rdelim},
                                        file: buscarVideo2('{$aula.video}'),
                                        title: 'Aula {$aula.posicao} - {$aula.nome}',
                                        width: '100%',
                                        aspectratio: '16:9',
                                        fallback: 'false'
                                    {rdelim});
                                </script>
                            {elseif $aula.tipo == 2 || $aula.tipo == 3}
                                <iframe src="http://docs.google.com/viewer?url={$aula.arquivo}&embedded=true" width="100%" height="780" style="border: none;"></iframe>
                            {elseif $aula.tipo == 4 || $aula.tipo == 5}
                                <p>{$aula.resumo}</p>
                            {/if}


                        </div>

                        {if $aulaAnterior}
                        <a href="{$url_site}lms/professor/cursos/aula/{$aulaAnterior}" class="btn btn-primary"><i class="iconfa-arrow-left"></i> Aula Anterior</a>
                        {/if}

                        <a href="/lms/professor/cursos/avancar/{$aula.aula_id}" class="btn btn-primary right">Avançar <i class="iconfa-arrow-right"></i></a>

                    </div><!--span8-->

                    <div class="span4">                     
                        <h4 class="widgettitle">Ações</h4>
                        <div class="widgetcontent">
                            <a href="{$url_site}lms/professor/cursos/verCurso/{$curso.id}" class="btn btn-primary btn-block">Capítulos</a>
                            <a href="{$url_site}lms/professor/cursos/listar" class="btn btn-info btn-block">Meus Cursos</a>
                        </div><!--widgetcontent-->  
                    </div><!--span4-->             

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
{literal}
<script type="text/javascript">

jQuery('#btnIr').click(function() {
    {/literal} window.location.href='{$url_site}lms/professor/cursos/aula/' + jQuery('#aulaSelect').val(); {literal}
    return false;
        
});

</script>
{/literal}