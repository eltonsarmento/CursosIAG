        <section class="container">
            <section class="single-header">
                <section class="single-title">
                	{if $curso.id == 78}
                	<h1><a href="https://secure.runrun.it/pt-BR/trusted_partners/cursos-iag" target="_blank"><img src="/lms/common/site/images/rr_partners_seal_119x40.png"></a>{$curso.curso}</h1>
                	{else}
                    <h1>{$curso.curso}</h1>
                    {/if}
                </section><!--.single-title-->

                <section class="single-menu">
                    <nav>
                        <ul>
                            <li><a href="#course-sidebar">Informações do curso</a></li>
                            <li><a href="#lessons">Conteúdo</a></li>
                            <li><a href="#single-teacher">Sobre o professor</a></li>
                            <li><a href="#single-testimonials">Depoimentos</a></li>
                            <li  class="assinature-featured"><a href="#assinature">Assinatura</a></li>
                        </ul>
                    </nav>
                </section><!--.single-menu-->

                <section class="single-course-info">

                    <!-- AULA GRATUITA -->
                    <section class="single-course-info-video">
                    {if $aulaGratuita}
                        <div id="aulaGratuita"></div>
                    {/if}
                    </section>
                    <!-- FIM AULA GRATUITA -->


                    <section class="single-course-info-price">

                        <section class="price">
                            {if $curso.gratuito == 0}
                            <span><strong class="preco_curso">R$ {$curso.valor}</strong> <small class="6_vezes">ou até 6x de R$ {$curso.valor_6}</small></span>
                            {else}
                            <span><strong class="preco_curso">Gratuito</strong></span>
                            {/if}

                            <button class="btn-green" onclick="$('#formCarrinho').submit();">
                                {if $curso.gratuito == 1}
                                    ESTUDE AGORA
                                {else}
                                    COMPRAR AGORA
                                {/if}

                            </button>

                            <span class="button-disable-single" onclick="javascript:;">
                                {if $curso.gratuito == 1}
                                    ESTUDE AGORA
                                {else}
                                    COMPRAR AGORA
                                {/if}
                                <p>Selecione as opções</p>
                            </span>

                        </section><!--.price-->
                        <form action="{$url_site}carrinho/adicionarCurso/{$curso.id}" id="formCarrinho" method="post">
                        {if $curso.suporte != 0 || $curso.certificado != 0}
                        <section class="option">
                            
                        	<h1>Opções obrigatórias</h1>

                        	<section class="option-content">
                                {if $curso.suporte != 0}
                        		<section class="form-control">
		                            <label>Suporte:</label>
		                            <select id="option" class="option-1 selectCompra" name="suporte">
		                            	<option value="1" selected="">COM SUPORTE {if $precoSuporte > 0} (R$ {$precoSuporte|number_format:2:",":"."}) {else} (GRATUITO) {/if}</option>
		                            	<option value="0">SEM SUPORTE</option>
		                            </select>
	                            </section><!--.form-control-->
                                {/if}

                                {if $curso.certificado != 0}
	                            <section class="form-control">
		                            <label>Certificado:</label>
		                            <select id="option" class="option-2 selectCompra" name="certificado">		                            	
		                            	<option value="1">CERTIFICADO IMPRESSO (R$ {$precoCertificado|number_format:2:",":"."})</option>
		                            	<option value="0" selected="">CERTIFICADO GRATUITO (PDF) </option>
		                            </select>
	                           </section><!--.form-control-->
                               {/if}

                            </section><!--.option-content-->


                        </section><!--.option-->
                        {/if}
                        </form>

                    </section><!--.single-course-info-price-->

                </section><!--.single-course-info-->
            
            </section><!--.single-header-->
            
            <section class="single-content">

                <section class="course-info">

                    <section class="info">

                        <figure><img src="{$url_site}lms/common/site/images/course-info-certi.png"></figure>

                        <h1>Certificado</h1>
                        <p>Impresso ou Digital</p>

                    </section><!--.info-->

                    <section class="info">

                        <figure><img src="{$url_site}lms/common/site/images/course-info-acesso.png"></figure>

                        <h1>Acesso Online</h1>
                        <p>Aulas disponíveis 24 horas!</p>

                    </section><!--.info-->

                    <section class="info">

                        <figure><img src="{$url_site}lms/common/site/images/course-info-suport.png"></figure>

                        <h1>Suporte</h1>
                        <p>Suporte total aos exemplos do curso</p>

                    </section><!--.info-->

                    <section class="info">
                        <a href="{$url_site}assinaturas">
                        <figure><img src="{$url_site}lms/common/site/images/course-info-assi.png"></figure>

                        <h1>Assinatura</h1>
                        <p>Escolha o melhor plano para você!</p>
                        </a>
                    </section><!--.info-->

                </section><!--.course-info-->

                <section class="course-lesson">

                    <aside class="course-sidebar" id="course-sidebar">

                        <h1>Informações do curso</h1>

                        <section class="course-sidebar-info">

                            <h1>Descrição</h1>

                            <section class="content-course-sidebar-info">

                                <p>{$curso.descricao}</p>

                            </section><!--.content-course-sidebar-info-->

                        </section><!--.course-sidebar-info-->

                        <section class="course-sidebar-info">

                            <h1>Público Alvo</h1>

                            <section class="content-course-sidebar-info">

                                <p>{$curso.publico}</p>

                            </section><!--.content-course-sidebar-info-->

                        </section><!--.course-sidebar-info-->

                        <section class="course-sidebar-info">

                            <h1>Informações</h1>

                            <section class="content-course-sidebar-info">

                                <p>{$curso.tecnica}</p>

                            </section><!--.content-course-sidebar-info-->

                        </section><!--.course-sidebar-info-->
                        
                        <section class="course-sidebar-info">

                            <h1>Pré-requisitos</h1>

                            <section class="content-course-sidebar-info">

                                <p>{$curso.requisito}</p>

                            </section><!--.content-course-sidebar-info-->

                        </section><!--.course-sidebar-info-->

                        <section class="course-sidebar-info">

                            <h1>Perfil</h1>

                            <section class="content-course-sidebar-info">

                                <p>{$curso.perfil}</p>

                            </section><!--.content-course-sidebar-info-->

                        </section><!--.course-sidebar-info-->

                    </aside><!--.course-sidebar-->

                    <section class="lessons" id="lessons">

                        <section class="lessons-title">

                            <h1>Aulas</h1>
                            <p>Cronograma do curso</p>

                            <span class="expand"></span>

                        </section><!--.lessons-title-->

                        <section class="lessons-content">
                            
                            {if $curso.url == 'carreira-web-design' || $curso.url == 'carreira-youtuber'}
                            
                            <article class="chapters">

                                <h1>Assista algumas aulas desta carreira <span class="expand"></span></h1>

                                <ul class="collapse shown">
                                   
                                    {foreach item=aula from=$aulas}
                                    
                                    <li>
                                    
                                        <a  href="#free" class="free" onclick="abrirVideo('{if ($servidor == 1)}{$aula.amazon}{else}{$aula.vimeo}{/if}')" rel="modal:open"><i class="fa fa-play-circle"></i>
                                       
                                        Aula - {$aula.nome} <span>{$aula.duracao}</span>
                                        
                                        </a>
                                    
                                    </li>
                                    
                                    {/foreach}
                                    
                                </ul>

                            </article>
                            
                            {else}
                           
                            {foreach item=capitulo key=k from=$capitulos}
                            <article class="chapters">

                                <h1>Capítulo {$capitulo.capitulo} - {$capitulo.descricao} <span class="expand"></span></h1>

                                <ul class="collapse {if $k == 0}shown{/if}">
                                    {foreach item=aula from=$capitulo.aulas}
                                    <li>
                                        {if $aula.gratuito == 1} <a  href="#free" class="free" onclick="abrirVideo('{if ($servidor == 1)}{$aula.amazon}{else}{$aula.vimeo}{/if}')" rel="modal:open"><i class="fa fa-play-circle"></i>{/if}
                                        Aula {$aula.posicao} - {$aula.nome} <span>{$aula.duracao}</span>
                                        {if $aula.gratuito == 1} </a>{/if}
                                    </li>
                                    {/foreach}
                                </ul>

                            </article>
                            {/foreach}
                            
                            {/if}

                        </section><!--.lessons-content-->

                    </section><!--.lessons-->

                </section><!--.course-lesson-->
            
            </section><!--.single-content-->

            <!-- PROFESSOR -->
            <section class="single-teacher" id="single-teacher">

                <section class="single-teacher-content">
                    <h1>Professor do curso</h1>
                    <section class="teacher-info">
                        <figure><img src="{$url_site}lms/uploads/avatar/{$professor.avatar}" width="100"></figure>
                        <p>{$professor.minicurriculo}</p>
                    </section>
                </section>

            </section>
            <!-- FIM PROFESSOR -->

            {if count($depoimentos)}
            <!-- DEPOIMENTOS -->
            <section class="single-testimonials" id="single-testimonials">

                <section class="single-testimonials-content">

                    <h1>Opinião de quem já comprou</h1>
                    
                    <script>
                    $(document).ready(function() {
 
                        $(".testimonials").owlCarousel({
                            items: 4,
                            autoPlay: true,
                            navigation: true,
                            navigationText: ["Depoimentos Anteriores","Próximos Depoimentos"]
                        });
 
                    });
                    </script>

                    <section class="testimonials">
                        {foreach item=depoimento from=$depoimentos}
                        <article>
                            <section class="info-testimonials">
                            <img src="{$url_site}lms/uploads/avatar/{$depoimento.aluno.avatar}" width="100"/>
                            <h3>{$depoimento.aluno.nome}</h3>
                            </section>
                            <section class="description-testimonials">
                            <p>{$depoimento.mensagem}</p>
                            </section>
                        </article>
                        {/foreach}
                        
                        
                        
                    </section>
                    
                    <span class="alert-testimonials">*Apenas alunos que compraram e concluíram o curso podem escrever depoimentos.</span>

                </section>

            </section>
            <!-- FIM DEPOIMENTOS -->
            {/if}

            <!-- FOOTER COMPRA -->
            <section class="single-footer">
                <section class="single-footer-price">
                    {if $curso.gratuito == 0}
                    <span><strong class="preco_curso">R$ {$curso.valor}</strong></span>
                    <span><small class="6_vezes">ou até 6x de R$ {$curso.valor_6}</small></span>
                    {else}
                    <span><strong class="preco_curso">Gratuito</strong></span>
                    {/if}
                    <button class="btn-green" onclick="jQuery('#formCarrinho').submit();">
                        {if $curso.gratuito == 1}
                            ESTUDE AGORA
                        {else}
                            COMPRAR AGORA
                        {/if}
                    </button>
                    <span class="button-disable-single" onclick="jQuery('#formCarrinho').submit();">
                        {if $curso.gratuito == 1}
                            ESTUDE AGORA
                        {else}
                            COMPRAR AGORA
                        {/if}
                        <p>Selecione as opções</p>
                    </span>
                </section>
            </section>
        
            <!-- ASSINATURA -->
            <section class="assinature" id="assinature">
                <section class="assinature-content">
                    <a href="{$url_site}assinaturas/"><h1>Conheça nossos <br/>planos de <strong>assinatura!</strong></h1>
                    <p>Planos a partir de <strong>R$ 59,90</strong> com acesso a <strong>todos os cursos!</strong></p></a>
                </section><!--.assinature-content-->
            </section><!--.assinature-->
            <!-- FIM ASSINATURA -->

            {if !empty($cursosRelacionados)}
            <!-- CURSOS RELACIONADOS -->
            <section class="cursos-content related-cursos">
                <h1>Cursos Relacionados</h1>
                {foreach item=cursoRelacionado from=$cursosRelacionados}
                <article>
                    <figure><a href="{$url_site}curso/{$cursoRelacionado.url}"><img src="{$url_site}lms/uploads/imagens/{$cursoRelacionado.destaque_arquivo}" alt=""></a></figure>
                    
                    <!-- <h2>
                    	{foreach item=categoria from=$cursoRelacionado.categorias}
                    	{$categoria.categoria}
                    	{/foreach}
                    </h2> -->
                    <section class="box-cursos-content">
                        <a href="{$url_site}curso/{$cursoRelacionado.url}"><h1>{$cursoRelacionado.curso}</h1></a>
                        <section class="info-curso">
                            <span>Curso Online</span>
                        </section>
                        
                        <section class="btn">
                            <a href="{$url_site}curso/{$cursoRelacionado.url}" class="btn-orange btn-block">Conheça o Curso</a>
                        </section>
                    
                    </section>
                
                </article><!--.article-->
                {/foreach}
                
            </section>
            <!-- FIM CURSOS RELACIONADOS -->
            {/if}

        </section><!--.container-->

        
        <!-- MODAL -->
        <section class="modal modal-video" id="free">
            <section class="modal-content">
                <div id="videoModal">Carregando</div>
            </section><!--.modal-content-->
        </section><!--.modal-->

<script type="text/javascript" src="{$url_site}lms/common/site/js/jwplayer/jwplayer.js" ></script>
<script type="text/javascript" src="{$url_site}lms/common/site/js/jwplayer/jwplayer.html5.js"></script>
<script type="text/javascript">jwplayer.key="iutRDqcT78F7yRwhJrXKoCvFzYyfVxWm4kAJuA==";</script>
<script type="text/javascript" src="{$url_site}lms/common/site/js/expand.js" ></script>
<div id="retorno_preco"></div>
{literal}
<script type="text/javascript">

jQuery('.selectCompra').on('change', function() {
    atualizarPreco();
});

function atualizarPreco() {
    {/literal}
    jQuery.post('{$url_site}curso/preco', {ldelim}     
        preco: '{$curso.valor}',
        suporte_p: '{$precoSuporte}',
        certificado_p: '{$precoCertificado}',
        suporte: jQuery('.option-1').val(),
        certificado: jQuery('.option-2').val()
    {rdelim}, function html(html){ldelim} jQuery('#retorno_preco').html(html) {rdelim});
    {literal}
}


function abrirVideo(video) {
    jwplayer("videoModal").setup({
        logo: {
            {/literal}
            file: "{$url_site}lms/common/site/js/jwplayer/imagens/logo-cursosiag.png",
            link: "{$url_site}"
            {literal}
        },
        file: buscarVideo(video),
        width: 770,
        height: 400
        
    });
}

{/literal}
{if $aulaGratuita}
jwplayer("aulaGratuita").setup({ldelim}
    logo: {ldelim}
        file: "{$url_site}lms/common/site/js/jwplayer/imagens/logo-cursosiag.png",
        link: "{$url_site}"
      {rdelim},
    file: buscarVideo('{$aulaGratuita}'),
    width: 464,
    height: 261,
    autostart: true
{rdelim});
{/if}
{literal}

$(document).ready(function($){

    $(".lessons").expandAll({
        trigger: ".chapters .collapse", 
        ref: ".lessons-title span.expand", 
        showMethod: "slideDown", 
        hideMethod: "slideUp", 
        oneSwitch : false
    });

    $(".chapters").expandAll({trigger: "span.expand", ref: "span.expand", oneSwitch: false});

    atualizarPreco();
    //$( ".btn-green" ).hide();
    //$( ".button-disable-single" ).show();
    $( ".button-disable-single" ).hide();
    // $("#option").change(function(){
    //     if( $(this).val() == '' ){
    //         $( ".btn-green" ).hide();
    //         $( ".button-disable-single" ).show();
    //     }else{
    //         $( ".button-disable-single" ).hide();
    //         $( ".btn-green" ).show();
    //     }
    // });
});
</script>
{/literal}