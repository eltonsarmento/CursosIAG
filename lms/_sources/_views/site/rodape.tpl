      <footer>
            <section class="content-footer-menu">
                <section class="container-footer">
                    <nav>
                        <ul>
                            <h1>Estude Conosco</h1>
                            <li><a href="{$url_site}pagina/10-razoes-estudar">10 Razões para estudar</a></li>
                            <li><a href="{$url_site}pagina/missao-visao">Missão e Valores</a></li>
                        </ul>
                        
                        <ul>
                            <h1>Sobre Nós</h1>
                            <li><a href="{$url_site}pagina/historia">IAG, a história</a></li>
                            <!-- <li><a href="#seja-um-revendedor" rel="modal:open">Seja um Revendedor</a> <span class="ballon-small">Novo</span></li> -->
                        </ul>
                        
                        <ul>
                            <h1>Nossos Produtos</h1>
                            <!-- <li><a href="{$url_site}assinaturas">Assinaturas</a></li> -->
                            <li><a href="{$url_site}pagina/cursos-onlines">Cursos Online</a></li>
                            <li><a href="{$url_site}pagina/suporte">Suporte</a></li>
                            <li><a href="{$url_site}pagina/certificados">Certificados</a></li>
                        </ul>
                        
                        <ul>
                            <h1>Suporte IAG</h1>
                             <li><a href="{$url_site}pagina/faq">FAQ</a></li> 
                            <li><a href="{$url_site}contato/">Contato</a></li>
                            <li><a href="#seja-um-professor" rel="modal:open">Seja um Professor</a></li>
                        </ul>
                        
                        <ul>
                            <h1>Mais Informações</h1>
                            <li><a href="{$url_site}pagina/mapa-site">Mapa do Site</a></li>
                            <li><a href="{$url_site}pagina/termos">Termos e Condições</a></li>
                        </ul>
                    
                    </nav>
                
                </section><!--.container-->
            
            </section><!--.content-content-->

            <section class="content-footer-newsletter">

                <section class="container-footer">

                    <section class="newsletter">

                        <h1>QUER RECEBER CONTEÚDO <strong>EXCLUSIVO</strong> EM SEU E-MAIL?</h1>

                        <p>Clique no botão e preencha seus dados. Você receberá dicas, materiais gratuitos e muito mais.</p>

                         <h2 class="btn-newsletter"><a class="btn-newsletter-a" href="http://landing.cursosiag.com.br/assine-nossa-lista" target="_blank" title="Newsletter IAG">ASSINAR LISTA VIP</a></h1>
                    
                    </section>

                </section>

            </section>

            <section class="content-footer-news-facebook">
                <section class="container-footer">

                    <section class="facebook">
                        <h1>Curta o IAG no Facebook e fique por dentro das novidades!</h1>

                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>

                        <div class="fb-like-box" data-href="http://www.facebook.com/cursosiag" data-width="948" data-height="295" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
                    
                    </section><!--.facebook -->
                </section><!--.container-->
            </section><!--.content-footer-news-facebook-->
            
            <section class="content-footer-info">
                <section class="container-footer">
                    <section class="formas-pg">
                        <h1>Formas de Pagamento</h1>
                        <span></span>
                    </section><!--.formas-pg-->
                    
                    <section class="plataformas">
                        <h1>Plataformas</h1>
                         <a href="http://hostnet.com.br/" target="_blank" class="hostnet"></a>
                        <span class="img-pl"></span>
                    </section><!--.plataformas-->
                </section><!--.container-->
            </section><!--.content-content-->
            
            <section class="content-footer-copyright">
                <section class="container-footer">
                    <section class="container-footer-logo"></section><!--.container-footer-logo-->
                    <section class="container-footer-address">
                        <p><strong>Cursos IAG</strong> - Todos os direitos reservados</p>
                        <p>Rua Dr. Batista Acioly, 126, Sala 104, Jaraguá, Maceió - AL</p>
                    </section><!--.container-footer-address-->
                    
                    <section class="container-footer-call">
                        <h1>(82) <strong>3034-5153</strong></h1>
                        <p>atendimento@cursosiag.com.br</p>
                    </section><!--.container-footer-call-->
                    
                    <section class="container-footer-social">
                        <a href="http://facebook.com/cursosiag" target="_blank" class="facebook"></a>
                        <a href="http://youtube.com/cursosiag" target="_blank" class="youtube"></a>
                    </section><!--.container-footer-social-->
                    <a href="https://plus.google.com/112331731879438654612" rel="publisher"></a> 
                </section><!--.container-footer-->
            </section><!--.content-content-->
        </footer><!--footer-->
        
        <a href="#" class="btn-top"><i class="fa fa-angle-up"></i></a>
        <section class="modal modal-video" id="video-institucional">
            <section class="modal-content">
                <div id="videoModal">Carregando</div>
            </section><!--.modal-content-->
        </section><!--.modal-->

        <!-- ESQUECEU SENHA -->
        <section class="modal" id="esqueceu-a-senha">
            <section class="modal-header">
                <section class="title-header">
                    <h1>Esqueceu sua senha?</h1>
                    <p>Insira seu e-mail abaixo.</p>
                </section><!--.title-header-->
                <a href="#" rel="modal:close" class="close"><i class="fa fa-times"></i></a>
            </section><!--.modal-header-->

            <section class="modal-content">
                <form id="modalEsqueceuSenha" action="" onsubmit="">
                    <div id="retornoModalEsqueceuSenha"></div>
                    <input type="hidden" name="enviar" value="1"/>
                    <label>Seu e-mail</label>
                    <input type="text" name="email">
                    <button class="btn-orange" onclick="enviarModalLembrarSenha(); return false;">Redefinir</button>
                </form>
            </section><!--.modal-content-->
        </section><!--.modal-->

        <!-- MODAL SEJA PROFESSOR -->
        <section class="modal" id="seja-um-professor">
            <section class="modal-header">
                <section class="title-header">
                    <h1>Seja um Professor</h1>
                    <p>Faça parte da nossa equipe!</p>
                </section><!--.title-header-->
                <a href="#" rel="modal:close" class="close"><i class="fa fa-times"></i></a>
            </section><!--.modal-header-->

            <section class="modal-content">
                <form id="modalProfessor">
                    <div id="retornoModalProfessor"></div>
                    <input type="hidden" value="1" name="enviar"/>
                    <label>Seu nome</label>
                    <input type="text" name="nome" id="modal-professor-nome" required="">
                    
                    <label>Seu e-mail</label>
                    <input type="text" name="email" id="modal-professor-email" required="" >

                    <label>Mini-currículo</label>
                    <textarea cols="30" rows="5" name="minicurriculo" id="modal-professor-minicurriculo" required></textarea>

                    <label>Cursos que pode criar</label>
                    <textarea cols="30" rows="5" name="cursos" id="modal-professor-cursos" required></textarea>
                    
                    <label>Aula exemplo</label>
                    <input type="text" name="aula" id="modal-professor-aula" required="">

                    <button class="btn-orange" onclick="enviarModalProfessor(); return false;">Enviar</button>
                </form>
            </section>
        </section>

        <!-- MODAL SEJA UM REVENDEDOR -->
        <section class="modal" id="seja-um-revendedor">
            <section class="modal-header">
                <section class="title-header">
                    <h1>Seja um Revendedor</h1>
                    <p>Comercialize nossos produtos!</p>
                </section><!--.title-header-->
                <a href="#" rel="modal:close" class="close"><i class="fa fa-times"></i></a>
            </section><!--.modal-header-->

            <section class="modal-content">
                <form id="modalRevendedor">
                    <div id="retornoModalRevendedor"></div>
                    <input type="hidden" value="1" name="enviar"/>
                    <label>Seu nome</label>
                    <input type="text" name="nome" id="modal-revendedor-nome" required="">
                    
                    <label>Seu e-mail</label>
                    <input type="text" name="email" id="modal-revendedor-email" required="">

                    <label>Seu site</label>
                    <input type="text" name="site" id="modal-revendedor-site" required="">

                    <label>Área de Atuação</label>
                    <input type="text" name="atuacao" id="modal-revendedor-atuacao" required="">

                    <label>Telefone</label>
                    <input type="text" name="telefone" id="modal-revendedor-telefone">

                    <label>Mensagem</label>
                    <textarea cols="30" rows="5" name="mensagem" id="" required></textarea>

                    <button class="btn-orange" onclick="enviarModalRevendedor(); return false;">Enviar</button>
                </form>
            </section>
        </section>

        <!-- CONSULTAR CERTIFICADO -->
        <section class="modal" id="consultar-certificado">
            <section class="modal-header">
                <section class="title-header">
                    <h1>Consultar certificado</h1>
                    <p>Consulte aqui a originalidade do certificado</p>
                </section><!--.title-header-->

                <a href="#" rel="modal:close" class="close"><i class="fa fa-times"></i></a>
            </section><!--.modal-header-->

            <section class="modal-content">
                <form action="{$url_site}certificado/buscar" method="post">
                    <label>Código do certificado</label>
                    <input type="text" name="id">
                    <button class="btn-orange">Consultar</button>
                </form>
            </section><!--.modal-content-->

        </section><!--.modal-->
        
{literal}

<script type="text/javascript">

//Seja um professor
function enviarModalProfessor() {
    $.post('/professor/contato/', $('#modalProfessor').serialize(), function html(html) { $('#retornoModalProfessor').html(html)});
}

function limparModalProfessor() {
    $('#modal-professor-nome').val('');
    $('#modal-professor-email').val('');
    $('#modal-professor-minicurriculo').val('');
    $('#modal-professor-cursos').val('');
    $('#modal-professor-aula').val('');
}

//Esqueceu senha
function enviarModalLembrarSenha() {
    $.post('/conta/lembrarSenha/', $('#modalEsqueceuSenha').serialize(), function html(html) { $('#retornoModalEsqueceuSenha').html(html)});
}

function limparModalProfessor() {
    $('#modal-lembrar-email').val('');
}
</script>

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?1JXbe0EHBaLE7lD3ldxObY6Z1ixxfAho";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
<script>

$(function() {
    $( "#accordion" ).accordion();
});
</script>

<script type="text/javascript">
    jwplayer("videoModal").setup({
        file: 'http://cursosiag.com.br/lms/common/site/media/VideoInstitucionalCursosIAG.mp4',
        width: 770,
        height: 400
    });
</script>

<script type="text/javascript">
    setTimeout(function(){var a=document.createElement("script");
    var b=document.getElementsByTagName("script")[0];
    a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0022/3431.js?"+Math.floor(new Date().getTime()/3600000);
    a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TZXNFH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TZXNFH');</script>
<!-- End Google Tag Manager -->

<!-- CÓDIGO MONITORAMENTO DE LEADS DO RD STATION -->
<script type="text/javascript" src="https://d335luupugsy2.cloudfront.net/js/lead-tracking/0.1.0/lead-tracking.min.js"></script>
<script type="text/javascript">
  LeadTracking.init({ token: 'c6afdcfc58eded9c1077be69a6f68c2d' });
</script>
<!-- FIM DO CÓDIGO DE MONITORAMENTO DE LEADS DO RD STATION -->

{/literal}

</body>
</html>