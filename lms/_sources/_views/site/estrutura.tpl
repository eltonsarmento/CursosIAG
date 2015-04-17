<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <!-- METAS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
  
    <meta name="description" content="{$descricaoPagina}">
   
    <meta name="keywords" content="cursos iag, iag, cursos, ead, formações, adobe, gratuitos, video aulas, videos, aulas, photoshop, dreamweaver, css, html, cursos a distancia">
    <meta name="robots" content="index,follow">
    <meta name="author" content="Cursos IAG - Formação a Distância">
    <meta name="reply-to" content="atendimento@cursosiag.com.br">
    <meta property="og:locale" content="pt_BR"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Cursos IAG - Formação a Distância"/>
    <meta property="og:url" content="http://cursosiag.com.br/"/>
    <meta property="og:site_name" content="Cursos IAG "/>
    <meta name="google-site-verification" content="ckY3xDgNeu_jUEPou2ikztX5utwmFsw-t_DHlLDOFj4" />
        
    <!-- TITLE -->
    <title>{if $tituloPagina} {$tituloPagina} - Cursos IAG {/if}</title>
        
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="{$url_site}lms/common/site/favicon.ico" />
    <link rel="shortcut icon" href="{$url_site}lms/common/site/favicon.ico"/>
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{$url_site}lms/common/site/css/fonts/font.css">
    <link rel="stylesheet" type="text/css" href="{$url_site}lms/common/site/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{$url_site}lms/common/site/css/style.css">
       
    <link rel="stylesheet" type="text/css" href="{$url_site}lms/common/site/css/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="{$url_site}lms/common/site/css/owl-carousel/owl.theme.css">
        
    <!-- JS -->

    <!-- JS CDN -->
        
    <script type="text/javascript" src="{$url_site}lms/common/site/js/jquery-1.10.2.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="{$url_site}lms/common/site/js/jwplayer/jwplayer.js" ></script>
    <script type="text/javascript" src="{$url_site}lms/common/site/js/jwplayer/jwplayer.html5.js"></script>
    <script type="text/javascript">jwplayer.key="iutRDqcT78F7yRwhJrXKoCvFzYyfVxWm4kAJuA==";</script>

    <!-- JS CDN -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="{$url_site}lms/common/site/js/html5shiv.js"></script>
      <script src="{$url_site}lms/common/site/js/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="{$url_site}lms/common/site/js/banner-destaque-0.0.1.js" ></script>
    <script type="text/javascript" src="{$url_site}lms/common/site/js/jquery.modal.js" ></script>
    <script type="text/javascript" src="{$url_site}lms/common/site/js/functions.js"></script>  
    <script type="text/javascript" src="{$url_site}lms/common/js/jquery.base64.js"></script>  
    <script type="text/javascript" src="{$url_site}lms/common/js/kmf.jquery.js"></script>  
    <script type="text/javascript" src="{$url_site}lms/common/site/js/jquery.smooth-scroll.min.js"></script>
    <script type="text/javascript" src="{$url_site}lms/common/site/js/jquery.cookie.js" ></script>
    <script id="navegg" type="text/javascript" src="//tag.navdmp.com/tm32367.js"></script>
    
    <script type="text/javascript" src="{$url_site}lms/common/site/js/owl-carousel/owl.carousel.min.js" ></script>
        
    <script type="text/javascript">
    {literal}
    $(document).ready(function(){
        
        $("#filter").keyup(function(){
            var filter = $(this).val(), count = 0;
         
            $(".search-live article").each(function(){ 
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).fadeOut(200);
                 
                } else {

                    $(this).fadeIn(200);
                    count++;

                }

            });

            if(filter == 0) {
                $(".search-live").fadeOut(200);
            } else {
                $(".search-live").fadeIn(200);
            }

            var numberItems = count;

            $("#filter-count").text(count);
            
        });

        $('#free').on($.modal.CLOSE, function(event, modal) {
            
            jwplayer("videoModal").stop();

        });

        $('#video-institucional').on($.modal.CLOSE, function(event, modal) {
            
            jwplayer("videoModal").stop();

        });

        $('#video-institucional').on($.modal.OPEN, function(event, modal) {
            
            jwplayer("videoModal").play();

        });
        
    });
        
    {/literal}
    
    </script>

    <script>
    {literal}
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-32512989-1', 'auto', {'allowLinker': true});
      ga('require', 'linker');
      ga('linker:autoLink', ['https://pagseguro.uol.com.br/v2/checkout/payment.html'] );    
      ga('send', 'pageview');
      {/literal}
    </script>

    <!-- Start of Async HubSpot Analytics Code -->
    <script type="text/javascript">
    {literal}
    (function(d,s,i,r) {
    if (d.getElementById(i)){return;}
    var n=d.createElement(s),e=d.getElementsByTagName(s)[0];
    n.id=i;n.src='//js.hs-analytics.net/analytics/'+(Math.ceil(new Date()/r)*r)+'/400507.js';
    e.parentNode.insertBefore(n, e);
    })(document,"script","hs-analytics",300000);
    {/literal}
    </script>
    <!-- End of Async HubSpot Analytics Code -->

    </head>
    
    <body> 
    
        <section class="bar-scroll">
            <!-- CONTEUDO TOPO SCROLL -->
            <section class="bar-scroll-content">
                <figure><a href="{$url_site}home/"><img src="{$url_site}lms/common/site/images/logo-cursosiag-bar-scroll.png"></a></figure> 
                <nav>
                    <ul>
                        <li><a href="javascript:;" class="bar-scroll-category">Categorias <i class="fa fa-angle-down"></i></a>

                            <section class="category">

                                <section class="category-content">
                                    <ul>
                                        {foreach item=categoriaTopo from=$categoriasTopo}
                                        <li>
                                            <h1><a href="{$url_site}categoria/{$categoriaTopo.url}">{$categoriaTopo.categoria}</a></h1>
                                            {if $categoriaTopo.filhas}
                                                {foreach item=categoriaFilha from=$categoriaTopo.filhas}
                                                <a href="{$url_site}categoria/{$categoriaFilha.url}">{$categoriaFilha.categoria}</a>
                                                {/foreach}
                                            {/if}
                                        </li>
                                        {/foreach}
                                    </ul>

                                </section>
                            </section>

                        </li>
                    </ul>
                </nav>

                <!-- BUSCA SCROLL -->
                <section class="bar-scroll-search">
                    <form action="{$url_site}curso/buscar" method="post">
                        <input type="text" name="palavras" placeholder="O que você procura?">
                        <button><i class="fa fa-search"></i></button>
                    </form>
                </section>
                <!-- FIM BUSCA SCROLL -->

                <!-- CARRINHO SCROLL -->
                <section class="bar-scroll-cart">
                    <a href="{$url_site}carrinho/ver/"><i class="fa fa-shopping-cart"></i>
                    {if $carrinhoTotal == 0}
                    <p>Ops, seu carrinho esta vazio! :( <!--Você possui <strong>2 itens</strong> no carrinho!--></p></a>                   
                    {else}
                    <p>Você possui <strong>{$carrinhoTotal} itens</strong> no carrinho!</p></a>                   
                    {/if}
                </section>
                <!-- FIM CARRINHO SCROLL -->
            </section>
        </section><!--.bar-scroll-->
        <!-- FIM CONTEUDO TOPO SCROLL -->


        <header>
            <!-- BARRA TOPO -->
            <section class="login-header">
                
                <section class="login-header-content">
                    {if !$usuario_id}
                        <!-- LOGIN -->
                        <form action="{$url_site}lms/" method="post">
                            <input type="hidden" value="1" name="logar"/>
                            <input type="text" name="usuario" placeholder="E-mail">
                            <input type="password" name="senha" placeholder="Senha">
                            <button class="btn-orange">Login</button>
                        </form>

                        <!-- CADASTRO -->
                        <section class="links-login-header">
                            <a href="{$url_site}conta/cadastro" class="cadastro">Cadastre-se</a>
                            <span>|</span>
                            <a href="#esqueceu-a-senha" rel="modal:open">Esqueceu a senha?</a>
                        </section>
                    {else}
                        <!-- USUARIO LOGADO -->
                        <section class="user-login">
                            <span>Olá, <strong>{$usuario_nome}</strong></span>
                            <a href="{$url_site}lms/{$usuario_categoria}/dashboard/home" target="_blank" class="btn-orange">Acessar Campus</a>
                            <a href="{$url_site}lms/{$usuario_categoria}/login/logout" class="btn-red">Sair</a>
                        </section>
                    {/if}

                    <!-- CERTIFICADO -->
                    <section class="certificate-header">
                        <a href="#consultar-certificado" rel="modal:open" class="btn-orange">Consultar certificado</a>
                    </section>
                    
                </section>
                
            </section><!--.login-header-->
            

            <section class="content-header">
                <!-- LOGO -->
                <section class="logo-content-header" itemscope itemtype="http://data-vocabulary.org/Organization">
                    <figure><a href="{$url_site}home/" itemprop="url"><img itemprop="brand" src="{$url_site}lms/common/site/images/logo-cursosiag.png" alt="Cursos IAG"></a></figure>
                </section>
                
                <!-- MENU TOPO -->
                <section class="menu-content-header">
                    <nav>
                        <ul>
                            <!-- <li><a href="#seja-um-revendedor" rel="modal:open">Seja um Revendedor</a></li> -->
                            <li><a href="{$url_site}pagina/termos">Termos e Condições</a></li>
                            <li><a href="{$url_site}contato/">Fale Conosco</a></li> 
                            <li><a href="#seja-um-professor" rel="modal:open">Seja um Professor</a></li>
                            <li><a href="http://cursosiag.com.br/blog" target="_blank">Blog</a></li>
                        </ul>
                    </nav>
                </section>
                
            </section>
            
            <!-- CATEGORIAS -->
            <section class="menu">
                
                <section class="menu-content">
                    <nav>
                        <ul>
                        <li><a href="{$url_site}assinaturas/">Assinaturas</a></li>

                            {foreach item=categoriaTopo from=$categoriasTopo}
                            {if $categoriaTopo.id != 9}
                            <li><a href="{$url_site}categoria/{$categoriaTopo.url}">{$categoriaTopo.categoria}</a>
                                <ul class="tabs left-submenu">
                                    <section class="tabs-menu">
                                        <ul>
                                            {if !empty($categoriaTopo.ultimosLancamentos)}
                                            <li><a href="#tabs-1">Últimos Lançamentos</a></li>
                                            {/if}
                                            {if !empty($categoriaTopo.maisAcessados)}
                                            <li><a href="#tabs-2">Mais Acessados</a></li>
                                            {/if}
                                        </ul>
                                    </section>

                                    <section class="content-tabs">
                                        <div id="tabs-1">
                                            {foreach item=cursoMenu from=$categoriaTopo.ultimosLancamentos}
                                            <article>
                                                <a href="{$url_site}curso/{$cursoMenu.url}">
                                                    <figure><img src="{$url_site}lms/uploads/imagens/{$cursoMenu.destaque_arquivo}" class="imgMiniatura" title="{$cursoMenu.curso}" alt="{$cursoMenu.curso}"></figure>
                                                    <h1>{$cursoMenu.curso}</h1>
                                                </a>
                                            </article>
                                            {/foreach}

                                        </div>

                                        <div id="tabs-2">
                                            {foreach item=cursoMenu from=$categoriaTopo.maisAcessados}
                                            <article>
                                                <a href="{$url_site}curso/{$cursoMenu.url}">
                                                    <figure><img src="{$url_site}lms/uploads/imagens/{$cursoMenu.destaque_arquivo}" class="imgMiniatura" title="{$cursoMenu.curso}" alt="{$cursoMenu.curso}"></figure>
                                                    <h1>{$cursoMenu.curso}</h1>
                                                </a>
                                            </article>
                                            {/foreach}
                                        </div>
                                    </section>
                                </ul>
                            </li>
                            {/if}
                            {/foreach}
                        </ul>
                    
                    </nav>
            
                </section><!--.menu-content-->
            
            </section><!--.menu-->
            <!-- FIM CATEGORIAS -->

            <!-- BUSCA E CARRINHO -->
            <section class="bar-search-cart">
                
                <section class="bar-search-cart-content">
                    <!-- BUSCA -->
                    <section class="search">
                        
                        <form action="{$url_site}curso/buscar" method="post">
                        
                            <span class="search-icon"><i class="fa fa-search"></i></span>
                            
                            <input type="text" id="filter" autocomplete="off" value="" name="palavras" placeholder="O que você procura?">
                            
                            <button class="btn-orange">Buscar</button>

                            <section class="search-live">
                                {foreach item=cursoLiveSearch key=k from=$cursosLiveSearch}
                                <article id="curso-{$k}">
                                    <a href="{$url_site}curso/{$cursoLiveSearch.url}">             
                                        <figure><img src="{$url_site}lms/uploads/imagens/{$cursoLiveSearch.destaque_arquivo}" class="imgMiniatura" title="{$cursoLiveSearch.curso}" alt="{$cursoLiveSearch.curso}"></figure>
                                        <h1>{$cursoLiveSearch.curso}</h1>
                                    </a>
                                </article>
                                {/foreach}

                                <span class="alert-live-search">Foram encontrados <strong id="filter-count"></strong> registros</span>
                            
                            </section><!--.search-live-->
                        
                        </form>
                        
                    </section><!--.search-->
                    
                    <!-- CARRINHO -->
                    <section class="cart">
                        <a href="{$url_site}carrinho/ver/"><span>Você tem <strong>{$carrinhoTotal} Itens</strong> no Carrinho <i class="fa fa-shopping-cart"></i></span></a>
                    </section><!--.cart-->
                
                </section><!--.bar-search-cart-->
                
            </section><!--.bar-search-cart-->
            <!-- FIM BUSCA E CARRINHO -->
            
        </header><!--header-->