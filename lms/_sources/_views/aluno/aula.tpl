    <script type="text/javascript" src="{$url_site}lms/common/site/js/jwplayer/jwplayer.js" ></script>
    <script type="text/javascript" src="{$url_site}lms/common/site/js/jwplayer/jwplayer.html5.js"></script>
    <script type="text/javascript">jwplayer.key="iutRDqcT78F7yRwhJrXKoCvFzYyfVxWm4kAJuA==";</script>
    <div class="rightpanel">
    
        <ul class="breadcrumbs">
            <li><a href="/lms/aluno/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Painel do Aluno</a> <span class="separator"></span></li>
            <li>Meus Cursos</li>            
        </ul>
        
        <div class="pageheader">

            <form action="" method="post" class="right searchbar">

                <select name="tipo" id="aulaSelect" style="width:300px;">
                    {foreach item=capituloBusca from=$capitulos}
                        <optgroup label="{$capituloBusca.descricao}">
                            {foreach item=aulaBusca from=$capituloBusca.aulas}
                                <option value="{$aulaBusca.aula_id}">Aula {$aulaBusca.posicao} - {$aulaBusca.nome}</option>
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
                                        fallback: 'false',
                                        mute: false,
                                        primary: 'html5'
                                    {rdelim});
                                </script>
                            {elseif $aula.tipo == 2 || $aula.tipo == 3}
                                <iframe src="http://docs.google.com/viewer?url={$aula.arquivo}&embedded=true" width="100%" height="780" style="border: none;"></iframe>
                            {elseif $aula.tipo == 4 || $aula.tipo == 5}
                                <p>{$aula.resumo}</p>
                            {/if}


                        </div>


                        {if $aulaAnterior}
                        <a href="{$url_site}lms/aluno/cursos/aula/{$aulaAnterior}" class="btn btn-primary"><i class="iconfa-arrow-left"></i> Aula Anterior</a>
                        {/if}

                        <!-- 
                        {if $proximaAula}
                        <a href="{$url_site}lms/aluno/cursos/aula/{$proximaAula}" class="btn btn-primary right">Próxima Aula <i class="iconfa-arrow-right"></i></a>
                        {/if}
                         -->
                        

                        <a  href="javascript:;" class="btn btn-primary right" id="botaoAvancar">Avançar <i class="iconfa-arrow-right"></i></a>

                    </div><!--span8-->

                    <div class="span4">

                        <h4 class="widgettitle">Estatísticas</h4>

                        <div class="widgetcontent" style="text-align:center;">

                            <div class="progress progress-primary">

                                <div style="width: {$porcentagem}%;" class="bar"></div>

                            </div><!--progress-->
                            
                            <span>{$porcentagem}% Concluído</span>

                        </div><!--widgetcontent-->  

                        <h4 class="widgettitle">Ações</h4>

                        <div class="widgetcontent">

                            <a href="{$url_site}lms/aluno/cursos/verCurso/{$relacionamentoId}" class="btn btn-primary btn-block">Capítulos</a>

                            {if $suporte}
                                <a href="#novaDuvida" data-toggle="modal" class="btn btn-primary btn-block">Nova Dúvida</a>

                                <a href="{$url_site}lms/aluno/duvidas/listar" class="btn btn-primary btn-block">Minhas Dúvidas</a>
                            {/if}
                            <a href="{$url_site}lms/aluno/cursos/meus-cursos" class="btn btn-info btn-block">Meus Cursos</a>

                            <a href="{$url_site}lms/aluno/certificados/listar" class="btn btn-info btn-block">Meus Certificados</a>
                            
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
{if $suporte}
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="novaDuvida">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h3 id="myModalLabel">Nova Dúvida</h3>
        </div>
        <div class="modal-body">
            
             <form action="" id="formDuvida" onsubmit="return false;">
                <input type="hidden" name="enviar" value="1"/>
                <p>
                    <label>Título</label>
                    <span class="field"><input type="text" class="span5" id="formCampoTitulo" name="titulo"></span> 
                </p>
        
                <p>
                    <label>Dúvida</label>
                    <span class="field"><textarea cols="80" rows="5" class="span5" id="formCampoDuvida" name="duvida"></textarea></span> 
                </p>
            
                <button class="btn btn-primary" id="btnForm">Enviar Dúvida</button>
            </form>

                      
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn">Fechar</button>
        </div>
    </div><!--#myModal-->
{/if}
<div id="resposta_duvida_modal"></div>
</div><!--mainwrapper-->
{literal}
<script type="text/javascript">

jQuery('#btnIr').click(function() {
    {/literal} window.location.href='{$url_site}lms/aluno/cursos/aula/' + jQuery('#aulaSelect').val(); {literal}
    return false;
        
});

jQuery('#btnForm').click(function() {
    if (!jQuery('#formCampoTitulo').val()) {
        jAlert('Preencha o título');
    } else if (!jQuery('#formCampoDuvida').val()) {
        jAlert('Preencha a duvida');
    } else {
        {/literal}
        jQuery.post('/lms/aluno/cursos/duvida/{$relacionamentoId}', jQuery('#formDuvida').serialize(), function html(html) {ldelim} jQuery('#resposta_duvida_modal').html(html); {rdelim});
        {literal}
    }
        
});

function limparForm() {
    jQuery('#formCampoTitulo').val('');
    jQuery('#formCampoDuvida').val('');
}

{/literal}
{if $bloqueio.bloqueado == true && $bloqueio.tempo > 0}

var linkAvancar = false; //Link Avançar não Liberado
var tempo = {$bloqueio.tempo}

function liberarBotao() {ldelim}
    if (tempo == 0) {ldelim}
        jQuery('#botaoAvancar').html('Avançar <i class="iconfa-arrow-right"></i>');
        jQuery.post('{$url_site}lms/aluno/cursos/buscarLink/', {ldelim}aula_id: {$aula.aula_id}{rdelim}, function html(html) {ldelim} linkAvancar = html {rdelim});
    {rdelim} else {ldelim}

        segundos = tempo/1000;
    
        //cronometro = hora + ':' + minuto + ':' + segundos;
        jQuery('#botaoAvancar').html('Liberada em: ' + segundos + ' segundos <i class="iconfa-arrow-right"></i>');
    {rdelim}
{rdelim}

setInterval(function() {ldelim}
    if (tempo != 0) {ldelim}
        tempo = tempo - 1000;
        liberarBotao();
    {rdelim}
{rdelim}, 1000);

{else}
var linkAvancar = '{$linkAvancar}'; //Link Avançar Liberado

{/if}
{literal}

jQuery('#botaoAvancar').click(function(e) { 
    e.preventDefault();
    if (linkAvancar) {
        window.location.href = buscarVideo2(linkAvancar);
    }
});


</script>
{/literal}