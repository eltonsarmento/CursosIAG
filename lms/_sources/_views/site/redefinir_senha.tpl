        <section class="container">
            
            <section class="page">

                <section class="page-title">
                    <h1>Redefinir senha!</h1>
                    <p>{$usuario.nome}</p>
                </section>

                <section class="page-content">
                    <form action="" method="post" class="form-page">
                        <input type="hidden" value="1" name="editar"/>
                        <input type="hidden" value="{$usuario.id}" name="usuario_id"/>

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

                        <!-- SENHA -->
                        <label>Nova Senha</label>
                        <input type="password" name="senha" value="">

                        <!-- SENHA CONFIRMACAO -->
                        <label>Senha confirmacao</label>
                        <input type="password" name="senha2" value="">

                        <section class="info-confirm">
                            <button class="btn-orange">Redefinir senha</button>
                        </section>
                    </form>

                </section><!--.page-content-->

            </section><!--.page-->
        
        </section><!--.container-->
     