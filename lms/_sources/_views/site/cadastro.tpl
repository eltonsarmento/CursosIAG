        <section class="container">
            
            <section class="page">

                <section class="page-title">
                    <h1>Cadastre-se!</h1>
                    <p>Aprenda Web Design, Design Gráfico, Edição de Vídeo e Muito Mais</p>
                </section><!--.page-title-->

                <section class="page-content">
                    <form action="" method="post" class="form-page">
                        <input type="hidden" value="1" name="editar"/>

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

                        <!-- NOME -->
                        <label>Nome Completo</label>
                        <input type="text" name="nome" value="{$nome}">

                        <!-- EMAIL -->
                        <label>E-mail</label>
                        <input type="text" name="email" value="{$email}">

                        <!-- SENHA -->
                        <label>Senha</label>
                        <input type="password" name="senha" value="">

                        <section class="info-confirm">
                            <span><input type="checkbox" name="check" value="" id="check"><label class="check"></label> <p>Li e concordo com os <a href="{$url_site}pagina/termos" target="_blank">Termos de Serviços</a></p></span>
                            <button class="btn-orange" id="cadastro">Criar Conta</button>
                            <span class="button-disable">Criar Conta</span>
                        </section><!--.info-confirm-->

                    </form>

                    <section class="balloon-registre">
                        <h1>Algumas Informações</h1>
                        <ul>
                            <li><p>1) Utilize um e-mail válido, senão não conseguirá resgatar sua senha caso precise. Verifique se seu e-mail está correto antes de prosseguir.</p></li>
                            <li><p>2) Cadastre-se em nossos cursos gratuitos.</p></li>
                        </ul>
                    </section><!--.balloon-registre-->

                </section><!--.page-content-->

            </section><!--.page-->
        
        </section><!--.container-->
     