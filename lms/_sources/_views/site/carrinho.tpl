        <section class="container">
            
            <section class="page">
                <section class="page-title">
                    <h1>Carrinho</h1>
                    <p>Você é quase um de nossos alunos =D </p>
                </section><!--.page-title-->

                <section class="page-content">

                    {if $msg_error}
                    <!-- ERROR -->                        
                    <span class="alert alert-error">
                        {$msg_error} <strong>=(</strong>
                    </span>
                    {/if}
                    {if $assinante}
                    <div style="width:97%;margin-top:10px;" class="alert alert-error">
                        Você é um assinante, tem certeza que deseja CANCELAR sua matrícula no curso atual, excluindo assim todo histórico de aulas assistidas, e se matricular neste novo curso? É importante lembrar que isto NÃO poderá ser desfeito, deseja prosseguir mesmo assim?
                    </div>
                    {/if}

                    
                    <table cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th align="left" colspan="2">Item</th>
                                <th align="left">Preço</th>
                                <th align="left">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            {foreach item=produto key=k from=$produtos}
                            <tr>
                                <td align="center"><a href="{$url_site}carrinho/removerCarrinho/{$k}" class="del"><i class="fa fa-times"></i></a></td>
                                <td align="center"><figure><img src="{$url_site}lms/uploads/imagens/{$produto.imagem}"></figure></td>
                                <td align="left"  colspan="2">
                                    {if $produto.tipo == 'curso'}
                                    <a href="{$url_site}curso/{$produto.url}">{$produto.produto}</a>
                                    {else}
                                    <a href="{$url_site}assinaturas/">{$produto.produto}</a>
                                    {/if}
                                </td>
                                <td align="left">R$ {$produto.preco}</td>
                                <td align="left">R$ {$produto.precoTotal}</td>
                            </tr>
                            {/foreach}
                            <tr>
                                <td colspan="6">
                                    <section class="actions">
                                        <form action="{$url_site}carrinho/adicionarCupom/" method="post">
                                            <input type="text" name="cupom" required="">
                                            <button class="btn-orange">Aplicar cupom</button>
                                        </form>
                                        {if $cupom}
                                            Usando cupom: {$cupom.nome}<br/> <a href="{$url_site}carrinho/removerCupom">Clique aqui para remover o cupom</a>
                                        {/if}

                                        <section class="actions-buttons">
                                            <a href="{$url_site}" class="btn-default" style="color:#fff !important;">Continuar comprando</a>
                                            <button class="btn-orange" onclick="window.location.href='{$url_site}carrinho/verificaLogin/'">Avançar <i class="fa fa-angle-right"></i></button>
                                        </section>

                                    </section><!--.actions-->
                                </td>
                            </tr>
                            <tr>
                                <td align="right" colspan="5">Subtotal:</td>
                                <td align="right" colspan="1"><strong>R$ {$total}</strong></td>
                            </tr>

                        </tbody>

                    </table>

                </section><!--.page-content-->

            </section><!--.page-->
        
        </section>        
     