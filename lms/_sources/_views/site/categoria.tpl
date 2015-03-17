     
        <section class="container">

            <section class="category-title">

                <section class="category-title-content">

                    <h1>Cursos na categoria: {$categoria.categoria}</h1>

                </section><!--.category-title-content-->

            </section><!--.category-title-->

            <section class="category-info">

                <section class="count-registre">

                    <p>Mostrando <strong>{$totalExibindo}</strong> de <strong>{$total}</strong> Cursos</p>

                </section><!--.count-registre-->

                <section class="view-mode-buttons">

                    <a href="#view-list"><i class="fa fa-th-list"></i></a>
                    <a href="#view-grid"><i class="fa fa-th-large"></i></a>

                </section><!--.view-mode-buttons-->

                <section class="order-view">

                    <form>

                        <label>Ordenar por:</label>
                        <select id="selectOrdenacao" onchange="mudarOrdenacao();">
                            <option value="0">Padrão (Recentes)</option>
                            <option value="1">Nome (A - Z)</option>
                            <option value="2">Nome (Z - A)</option>
                            <option value="3">Preço (Menor > Maior)</option>
                            <option value="4">Preço (Maior > Menor)</option>
                        </select>

                    </form>

                </section><!--.order-view-->

            </section><!--.category-info-->

            <section id="views-mode">
        
                <section class="view-mode" id="view-list">
                    <section id="list" class="category-content">
                        {foreach item=curso from=$cursos}
                        <article>
                            <figure><a href="{$url_site}curso/{$curso.url}"><img src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" title="{$curso.curso}" alt="{$curso.curso}"></a></figure>
                            <!-- <h2>
                                {foreach item=categoriaCurso from=$curso.categorias}
                                    {$categoriaCurso.categoria}
                                {/foreach}
                            </h2> -->
                            <section class="box-cursos-content">
                                <a href="{$url_site}curso/{$curso.url}"><h1>{$curso.curso}</h1></a>
                                <section class="btn">
                            
                                    <a href="{$url_site}curso/{$curso.url}" class="btn-green-shadow btn-block">Conheça o Curso</a>
                                
                                </section><!--.btn-->
                            </section><!--.box-cursos-content-->
                        </article><!--.article-->
                        {/foreach}
                    </section><!--.category-content-->
                </section><!--.view-mode-->

                <section class="view-mode" id="view-grid">
                    <section id="list" class="cursos-content">
                        {foreach item=curso from=$cursos}
                        <article>
                            <figure><a href="{$url_site}curso/{$curso.url}"><img src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" title="{$curso.curso}" alt="{$curso.curso}"></a></figure>
                            <!-- <h2>
                                {foreach item=categoriaCurso from=$curso.categorias}
                                    {$categoriaCurso.categoria}
                                {/foreach}
                            </h2> -->
                            <section class="box-cursos-content">
                                <a href="{$url_site}curso/{$curso.url}"><h1>{$curso.curso}</h1></a>
                                <section class="info-curso">
                                    <span>Curso Online</span>
                                </section><!--.info-cursos-->
                                
                                <section class="btn">
                            
                                    <a href="{$url_site}curso/{$curso.url}" class="btn-green-shadow btn-block">Conheça o Curso</a>
                                
                                </section><!--.btn-->
                            </section><!--.box-cursos-content-->
                        </article><!--.article-->
                        {/foreach}
                    </section><!--.cursos-content-->
                </section><!--.view-mode-->

            </section><!--.views-mode-->

            <!-- <section class="load-more">

                <a href="#" id="load-more" class="btn-orange">Carregar mais</a>

                <span id="load-more-disable">Todos os cursos já foram carregados!</span>

            </section><!--.load-more--> -->
        
        </section><!--.container-->

<!-- FORM BUSCA -->
<form id="formBusca" action="{$url_site}categoria/{$categoria.url}" method="post">
    <input type="hidden" name="ordenacao" id="formOrdenacao" value="0"/>
</form>
<!-- FIM FORM BUSCA -->

{literal} 
<script type="text/javascript" src="{$url_site}lms/common/site/js/tabs.checkout.min.js"></script>  
<script type="text/javascript">

function mudarOrdenacao() {
    $('#formOrdenacao').val($("#selectOrdenacao").val());
    $('#formBusca').submit();
}


$(function(){
    $('#views-mode .view-mode:first').show();
    $('.view-mode-buttons a:first').addClass('active');
    
    $('.view-mode-buttons a').click(function(e){
        e.preventDefault();
        $('.view-mode-buttons a').removeClass('active');
        $(this).addClass('active');

        var showViewCategory = $(this).attr('href');

        $('#views-mode .view-mode').hide();
        $(showViewCategory).fadeIn(500);
        return false;
    });

    $('#load-more').click(function(e){
        e.preventDefault();

        var lastRegistre = $('.view-mode #list article:last').attr('lang');
        // $('#load-more').text('Carregando...');
        $.post('/curso/carregarMais/', {lastRegistre: lastRegistre}, function(registres){
            // $('#load-more').text('Carregar mais');
            // $('#load-more').hide();
            
            $('.view-mode #list').append(registres);
        });

    });

});
</script>
{/literal}       