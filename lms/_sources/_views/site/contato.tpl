        <section class="container">
            <section class="page">
                
                <section class="page-title">
                    <h1>Fale Conosco</h1>
                </section><!--.page-title-->

                <section class="page-content">
                    <form action="" class="form-page" method="post">
                        <input type="hidden" value="1" name="enviar"/>

                        {if $msgErro}
                        <!-- ERROR -->
                        <span class="alert alert-error">
                            {$msgErro} <strong>=(</strong>
                        </span>
                        {/if}

                        {if $msgSucesso}
                        <!-- SUCESSO -->
                        <span class="alert alert-success">
                            {$msgSucesso} <strong>=D</strong>
                        </span>
                        {/if}

                        <label>Nome Completo</label>
                        <input type="text" name="nome" value="{$nome}" required="">

                        <label>E-mail</label>
                        <input type="email" name="email" value="{$email}" required="">

                        <label>Mensagem</label>
                        <textarea cols="30" rows="5" name="mensagem" required>{$mensagem}</textarea>

                        <section class="info-confirm">
                            <span>Utilize um e-mail válido para que possamos responder sua dúvida.</span>
                            <button class="btn-orange">Enviar</button>
                        </section><!--.info-confirm-->
                    </form>

                    <section class="balloon-registre">
                        <h1>Atendimento</h1>
                        <ul>
                            <li><p><i class="fa fa-phone"></i> (82) 3034 - 5153</p></li>
                            <li><p><i class="fa fa-clock-o"></i> Horário de atendimento: Segunda à Sexta das 08h00 às 18h00</p></li>
                            <li><p><i class="fa fa-envelope"></i> atendimento@cursosiag.com.br</p></li>
                        </ul>
                        
                        <p>Antes de enviar sua dúvida, que tal verificar no nosso <a href="{$url_site}pagina/faq" style="float:none;">FAQ</a> se sua dúvida já foi respondida, caso não encontre sua resposta, utilize o formulário ao lado.</p>
                        
                    </section><!--.balloon-registre-->

                </section><!--.page-content-->
            </section><!--.page-->
        </section><!--.container-->
        
       