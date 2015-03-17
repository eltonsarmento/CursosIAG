   
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

                    <i class="fa fa-angle-right active-row"></i>
                    <section class="circle active-circle">
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
                    <h1>Pagamento</h1>
                    <p>Qual a melhor forma de pagamento?</p>
                </section><!--.page-title-->

                <section class="page-content">
                    <section class="payment-content">
                        <h1 class="payment-title">Seu pedido</h1>
                        
                        <section class="payment-info">
                            <table cellspacing="0">

                                <thead>
                                    <tr>
                                        <th align="left">Plano</th>
                                        <th align="left">Preço</th>
                                        <th align="left">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {foreach item=produto key=k from=$produtos}
                                    <tr>
                                        <td align="left">
                                            <a href="{$url_site}assinaturas/">{$produto.produto}</a>
                                        </td>
                                        <td align="left">R$ {$produto.preco}</td>
                                        <td align="left">R$ {$produto.precoTotal}</td>
                                    </tr>
                                    {/foreach}
                                    <tr>

                                        <td align="right" colspan="2">Subtotal:</td>
                                        <td align="right" colspan="2"><strong>R$ {$total}</strong></td>

                                    </tr>

                                </tbody>

                            </table>

                        </section><!--.payment-info-->

                        <h1 class="payment-title">Formas de Pagamento</h1>

                        <section class="payment-info-confirm"><div id="field_errors"></div></section>
	                         <section class="payment-info-confirm">
                            
    	                        <form id="auto_enviar" action="http://cursosiag.com.br/lms/nasp/pagarme.php" method="POST">    
								    <input type="hidden" name="id_assinatura_pagarme" value="{$id_assinatura_pagarme}"/>    
								</form>

                        	</section>                         

                    	</section><!--.payment-content-->

                </section><!--.page-content-->

            </section><!--.page-->
        
        </section><!--.container-->        
{literal}
<script type="text/javascript">
window.onload = function() { 
    document.getElementById('auto_enviar').submit() 
}
</script>
{/literal}