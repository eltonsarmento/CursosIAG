        <!-- BANNER --> 
        
        <section class="banner-promocional">
           
            <section class="banner-content">
            
                <a href="http://cursosiag.com.br/landings/dreamweaver-cc/" target="_blank" title="Lançamento: Curso de Dreamweaver CC 2014">
                    
                    <img src="{$url_site}lms/common/site/images/banners/banner-dreamweavercc.jpg" alt="Lançamento: Curso de Dreamweaver CC 2014">

                </a>
            
            </section>
            
        </section>
        
        <!--<section class="banner">

            <section class="banner-content">

                <section class="banner-content-nav">

                    <a href="#" class="nav-left"><i class="fa fa-angle-left"></i></a>

                    <a href="#" class="nav-right"><i class="fa fa-angle-right"></i></a>

                </section>

                <ul>

                    {foreach item=curso from=$cursosBanner}

                    <li>

                        <a href="{$url_site}curso/{$curso.url}">

                        <h1>{$curso.curso}</h1>

                        <figure><img src="{$url_site}lms/uploads/imagens/{$curso.banner_arquivo}"></figure>

                        </a>

                    </li>

                    {/foreach}

                </ul>

            </section>

        </section>--> 
        
        <section class="container">
            
            <section class="cursos-content">

                {foreach item=curso from=$cursosDestaque}

                    {if $curso.gratuito == 0}

                    <article itemscope itemtype="http://data-vocabulary.org/Product">

                        <figure><a itemprop="offerURL" href="{$url_site}curso/{$curso.url}"><img itemprop="image" src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" title="{$curso.curso}" alt="{$curso.curso}"></a></figure>
                        <h2 style="display:none;" itemprop="category">

                            {foreach item=categoria from=$curso.categorias}
                                {$categoria.categoria}
                            {/foreach}

                        </h2>

                        <section class="box-cursos-content">
                            
                            <a itemprop="offerURL" href="{$url_site}curso/{$curso.url}"><h1 itemprop="name">{$curso.curso}</h1></a>
                            <section class="info-curso">
                                <span itemprop="description">Curso Online</span>
                            </section><!--.info-cursos-->

                            <section class="btn">
                                
                                <a href="{$url_site}curso/{$curso.url}" class="btn-green-shadow btn-block">Conheça o Curso</a>
                            
                            </section><!--.btn-->
                            
                        </section><!--.box-cursos-content-->
                    
                    </article><!--.article-->

                    {else}

                    <article itemscope itemtype="http://data-vocabulary.org/Product">

                        <figure><a itemprop="offerURL" href="{$url_site}curso/{$curso.url}"><img itemprop="image" src="{$url_site}lms/uploads/imagens/{$curso.destaque_arquivo}" title="{$curso.curso}" alt="{$curso.curso}"></a></figure>
                        <h2 style="display:none;" itemprop="category">
                            {foreach item=categoria from=$curso.categorias}
                                {$categoria.categoria}
                            {/foreach}
                        </h2>

                        <section class="box-cursos-content">
                            
                            <a itemprop="offerURL" href="{$url_site}curso/{$curso.url}"><h1 itemprop="name">{$curso.curso}</h1></a>
                            <section class="info-curso">

                                <span itemprop="description">Curso Online</span>

                            </section><!--.info-cursos-->
                            
                            <section class="btn-free">

                                <a href="{$url_site}curso/{$curso.url}" class="btn-green-shadow btn-block">Conheça</a>

                            </section><!--.btn-->
                            
                            <section class="price">
                                
                                <span><strong>Gratuito</strong></span>
                            
                            </section><!--.price-->

                        </section><!--.box-cursos-content-->
                    
                    </article><!--.article-->

                    {/if}

                {/foreach}
            
            </section><!--.cursos-content-->

            <section class="search-content">

                <section class="search-form">

                    <h1>Não encontrou o que queria? <strong>Procure aqui.</strong></h1>

                    <form action="{$url_site}curso/buscar" method="post">

                        <input type="text" name="palavras" placeholder="O que você procura?">
                        <button class="btn-orange">Buscar</button>

                    </form>

                </section>

            </section>
        
        </section><!--.container-->
        
  