        <section class="container">
            
            <section class="page">
                <section class="verified">
                    <section class="circle active-circle">
                        <span>1</span>
                        <p>Carrinho</p>
                    </section><!--.verified-->

                    <i class="fa fa-angle-right active-row"></i>
                    <section class="circle active-circle">
                        <span>2</span>
                        <p>Identificação</p>
                    </section><!--.verified-->

                    <i class="fa fa-angle-right"></i>

                    <section class="circle">
                        <span>3</span>
                        <p>Pagamento</p>
                    </section><!--.verified-->

                    <i class="fa fa-angle-right"></i>

                    <section class="circle">
                        <span>4</span>
                        <p>Confirmação</p>
                    </section><!--.verified-->

                </section><!--.verified-->

                <section class="page-title">
                    <h1>Identificação</h1>
                    <p>Faça login ou cadastre-se!</p>
                </section><!--.page-title-->

                <section class="page-content">
                    {if $msg_error}
                    <!-- ERROR -->                        
                    <span class="alert alert-error">
                        {$msg_error} <strong>=(</strong>
                    </span>
                    {/if}

                    {if $msg_success}
                    <!-- SUCCESS -->                        
                    <span class="alert alert-success">
                        {$msg_success} <strong>=D</strong>
                    </span>
                    {/if}


                    <form action="" class="form-page" method="post">
                        <input type="hidden" value="1" name="enviar" />
                        
                        <!-- EMAIL -->
                        <label>E-mail</label>
                        <input type="text" name="email">

                        <!-- SENHA -->
                        <label>Senha</label>
                        <input type="password" name="senha">

                        <!-- REDEFINIR SENHA -->
                        <section class="info-confirm">
                            <span><a href="#esqueceu-a-senha" rel="modal:open">Esqueceu a senha?</a></span>
                            <button class="btn-orange">Avançar <i class="fa fa-angle-right"></i></button>
                        </section><!--.info-confirm-->

                    </form>

                    <section class="balloon-registre">
                        <h1>Cadastre-se</h1>
                        <ul>
                            <li><p>Se você ainda não possui usuário em nosso sistema, é preciso criar uma conta para prosseguir.</p></li>
                        </ul>

                        <a href="{$url_site}conta/cadastro" class="btn-orange">Criar Conta</a>

                    </section><!--.balloon-registre-->

                </section><!--.page-content-->

            </section><!--.page-->
        
        </section><!--.container-->
        
