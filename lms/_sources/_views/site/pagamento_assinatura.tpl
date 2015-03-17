    
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
                            {if $msgErro}   
                            <span class="alert alert-error">{$msgErro} <strong>=(</strong></span>
                            {/if}
                            
                            <!-- <form id="payment_form" action="{$url_site}carrinho/assinar/" method="post" class="form-page">
                                <input name="enviar" value="1" type="hidden" >
                                Número do cartão: <input type="text" name="cartao" id="card_number"/>
                                <br/>
                                Nome (como escrito no cartão): <input type="text" name="nomeCartao" id="card_holder_name"/>
                                <br/>
                                Mês de expiração: <input type="text" id="card_expiration_month" name="mes"/>
                                <br/>
                                Ano de expiração: <input type="text" id="card_expiration_year" name="ano" />
                                <br/>
                                Código de segurança: <input type="text" id="card_cvv" name="cvv"/>
                                <br/>
                                
                                <br/><br/><br/><br/>

                                
                                <button class="btn btn-orange" type="submit"  id="btnFinalizarPedido" >Finalizar pedido</button>
                                <!-- <button class="btn btn-orange" onclick="finalizarPagamento();">Finalizar pedido</button> 
                                <button class="btn btn-default" onclick="window.location.href='{$url_site}carrinho/cancelar/'">Cancelar pedido e restaurar carrinho
                            </form> -->
                            <form  method="POST" action="{$url_site}carrinho/assinar/">        
                                <input name="enviar" value="1" type="hidden" >
                                <span><input type="checkbox" name="check-payment" id="check-termos" value=""><label class="check-payment"></label> <p>Li e concordo com os <a href="{$url_site}pagina/termos" target="_blank">Termos de Serviços</a></p></span>
                                <br/><br/>
                                <button class="btn btn-default" onclick="window.location.href='{$url_site}carrinho/cancelar/'; return false;">Cancelar pedido e restaurar carrinho</button>
                                
                                {literal}
                                    <script type="text/javascript"
                                        src="https://pagar.me/assets/checkout/checkout.js"
                                        data-button-text="Finalizar pedido PagarMe"
                                        data-encryption-key="{/literal}{$pagarme_key_encryption}{literal}"
                                        data-customer-data="false"
                                        data-max-installments="1"                                        
                                        data-button-class="btn-orange"
                                        data-ui-color="#e25143"
                                        data-create-token="false"
                                        data-amount="{/literal}{$totalPagarme}{literal}">
                                    </script>
                                {/literal}
                                <button class="btn btn-green" onclick="finalizarPagamento(); return false;">Finalizar pedido PagSeguro</button>
                            </form>
                        </section>

                         

                    </section><!--.payment-content-->

                </section><!--.page-content-->

            </section><!--.page-->
        
        </section><!--.container-->

        <div id="retornoPagamento"></div>
            
<div id="popUp">
    <h1>Você será redirecionado para a pagina de pagamento!</h1><br/>
    <input type="hidden" value="{$pagarme_key_encryption}" id="pagarme_key_encryption"/>
    <input type="hidden" value="" id="linkEscondido"/>
    <input type="button" value="Clique aqui para continuar!" onclick="abrePaginaPagamento();"/>
</div>

<script type="text/javascript" src="{$url_site}lms/common/site/js/tabs.checkout.min.js"></script> 
<script type="text/javascript" src="{$url_site}lms/common/site/js/jquery.mask.js"></script>
<script type="text/javascript" src="{$url_site}lms/common/site/js/jquery.mask.min.js"></script>
{literal}
<script type="text/javascript">

//$("#check-termos").click();
$("#check-termos").click(function(){
    if ($('#check-termos').is(':checked')){
        $(".pagarme-checkout-btn").attr('disabled',false);
    }else{
        $(".pagarme-checkout-btn").attr('disabled',true);
        alert('Aceite os termos de compromisso!'); 
    }
        
}); 



/*CONTROLE O BOTÃO FINALIZAR PEDIDO*/
$('#btnFinalizarPedido').click(function(e){
    e.preventDefault();
    if ($('#check-termos').is(':checked'))
        $("#payment_form").submit();
    else
        alert('Aceite os termos de compromisso!');  
})


////// PagSeguro ////
function finalizarPagamento() {
    if ($('#check-termos').is(':checked')) {
        pagarAssinatura();
    } else {
        alert('Aceite os termos de compromisso!');
    }  
}

function pagarAssinatura() {    
    $.post('/carrinho/assinarPagSeguro/',  {enviar: 1}, function html(html) {$('#retornoPagamento').html(html)});
}

function abrePaginaPagamento() {
    window.open($('#linkEscondido').val(), '_blank');
    {/literal}
    window.location.href='{$url_site}carrinho/confirmacao';
    {literal}
}


</script>
{/literal}