        <section class="container">
        	
        	<section class="page">

	            <section class="page-title">
	            	<h1>Mapa do Site</h1>
	            </section><!--.page-title-->

	            <section class="page-content">

	            	<section class="page-sitemap">

                        <ul>

                            <h1>Cursos Online</h1>

                            {foreach item=categoriaTopo from=$categoriasTopo}
                            <li><a href="{$url_site}categoria/{$categoriaTopo.url}" target="_blank">{$categoriaTopo.categoria}</a>
                            {/foreach}

                        </ul>

                        <ul>

                            <h1>Sobre Nós</h1>

                            <li><a href="{$url_site}pagina/sobre">Sobre a Empresa</a></li>
                            <li><a href="{$url_site}pagina/guia-carreira">Guia de Carreiras</a></li>
                            <li><a href="{$url_site}pagina/termos">Termos e Condições</a></li>

                        </ul>

                        <ul>

                            <h1>Estude Conosco</h1>

                            <li><a href="{$url_site}pagina/10-razoes-estudar">10 Razões para estudar</a></li>
                            <li><a href="{$url_site}pagina/missao-visao">Missão e Valores</a></li>

                        </ul>

                        <ul>

                            <h1>Nossos Produtos</h1>

                            <li><a href="{$url_site}assinaturas">Assinaturas</a></li>
                            <li><a href="{$url_site}pagina/cursos-onlines">Cursos Online</a></li>
                            <li><a href="{$url_site}pagina/suporte">Suporte</a></li>
                            <li><a href="{$url_site}pagina/certificados">Certificados</a></li>
                            <li><a href="{$url_site}pagina/parcerias">Parcerias</a></li>

                        </ul>

                        <ul>

                            <h1>Ajuda</h1>

                            <li><a href="{$url_site}contato">Fale Conosco</a></li>
                            <li><a href="{$url_site}pagina/faq">FAQ</a></a></li>
                            <li><a href="{$url_site}pagina/mapa-site">Mapa do Site</a></li>

                        </ul>

                    </section><!--.page-sitemap-->

	            </section><!--.page-content-->

	        </section><!--.page-->	

        </section><!--.container-->