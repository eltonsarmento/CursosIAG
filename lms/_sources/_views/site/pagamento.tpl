    
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
                                        <th align="left">Curso</th>
                                        <th align="left">Preço</th>
                                        <th align="left">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {foreach item=produto key=k from=$produtos}
                                    <tr>
                                        <td align="left">
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

                                        <td align="right" colspan="2">Subtotal:</td>
                                        <td align="right" colspan="2"><strong>R$ {$total}</strong></td>

                                    </tr>

                                </tbody>

                            </table>

                        </section><!--.payment-info-->
                        <h1 class="payment-title">Formas de Pagamento</h1>
                        
                        <style>
                        .pay {
                            width: 49%;
                            margin-bottom: 20px;
                            float: left;
                            text-align: center;
                        }
                        .pay .btn{
                            width: 100%;
                            padding: 15px;
                        }
                        </style>

                        <section class="payment-info-confirm"><div id="field_errors"></div></section>
                         <section class="payment-info-confirm">
                            {if $msgErro}   
                            <span class="alert alert-error">{$msgErro} <strong>=(</strong></span>
                            {/if}

                            <form  method="POST" action="{$url_site}carrinho/concluirPagarme/" >
                                <input type="hidden" name="enviado" value="1">
                                <span><input type="checkbox" name="check-payment" id="check-termos" value=""><label class="check-payment"></label> <p>Li e concordo com os <a href="{$url_site}pagina/termos" target="_blank">Termos de Serviços</a></p></span>
                                <br/><br/>
                                
                            <section class="text-center">
                                
                                <div class="pay" style="margin-right:10px;">
                                    
                                    <img src="{$url_site}lms/common/site/images/payment/logo-payment-pagseguro.png"><br><br>
                                    
                                    <button class="btn btn-green" onclick="finalizarPagamento();return false;">Finalizar pedido com Pagseguro</button>
                                    
                                    <span>Aceitamos cartões nacionais e internacionais (Brasileiros).</span><Br>
                                    <span>Pagamento de assinaturas via cartão de crédito.</span><br/>
                                    <span>(Pagamentos em até 6x sem juros)</span>
                                                                        
                                </div>
                               
                                <div class="pay">
                                    
                                    <img src="{$url_site}lms/common/site/images/payment/logo-payment-pagarme.png"><br><br>
                                    
                                <!-- src="https://pagar.me/assets/checkout/checkout.js" -->
                                {literal}
                                    <script type="text/javascript"
                                        src="https://pagar.me/assets/checkout/checkout.js"
                                        data-button-text="Finalizar pedido com PagarMe"
                                        data-encryption-key="{/literal}{$pagarme_key_encryption}{literal}"
                                        data-customer-data="false"
                                        data-max-installments="12"
                                        data-button-class="btn btn-orange"
                                        data-ui-color="#e25143"
                                        data-create-token="false"
                                        data-amount="{/literal}{$totalPagarme}{literal}">
                                    </script>
                                {/literal}
                                
                                
                                
                                 <span>Aceitamos cartões nacionais e internacionais (Todos os Países).</span><br>
                                 <span>Pagamento de assinaturas via cartão de crédito e boleto.</span><br>
                                 <span>(Pagamentos em até 3x sem juros)</span>
                                
                                 </div>
                                
                            </form>
                                            
                        
                           
                            <a href="{$url_site}carrinho/cancelar/">Cancelar pedido e restaurar carrinho</button>
                            
                            </section> 
                        
                        </section>

                    </section><!--.payment-content-->

                </section><!--.page-content-->

            </section><!--.page-->
        
        </section><!--.container-->
        
<div id="retornoPagamento"></div>
<script type="text/javascript" src="{$url_site}lms/common/site/js/tabs.checkout.min.js"></script> 
<script type="text/javascript" src="{$url_site}lms/common/site/js/jquery.mask.js"></script>
<script type="text/javascript" src="{$url_site}lms/common/site/js/jquery.mask.min.js"></script>
<div id="popUp">
    <h1>Você será redirecionado para a pagina de pagamento!</h1><br/>
    <input type="hidden" value="{$pagarme_key_encryption}" id="pagarme_key_encryption"/>
    <input type="hidden" value="" id="linkEscondido"/>
    <input type="button" value="Clique aqui para continuar!" onclick="abrePaginaPagamento();"/>
</div>
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
function pagarPagSeguro() {
    $.post('/carrinho/concluirPagSeguro/', function html(html) { 
        $('#retornoPagamento').html(html)
    });
}

function finalizarPagamento() {
    if ($('#check-termos').is(':checked')) {
        pagarPagSeguro();
    } else {
        alert('Aceite os termos de compromisso!');        
    }
    
}

function abrePaginaPagamento() {
    window.open($('#linkEscondido').val(), '_blank');
    {/literal}
    window.location.href='{$url_site}carrinho/confirmacao';
    {literal}
}

/*////// Pagarme ////
function pagarPagarme() {
    $.post('/carrinho/concluirPagarme/', function html(html) { $('#retornoPagamento').html(html)});
}

function finalizarPagamento() {
    if ($('#check-termos').is(':checked')) {
        pagarPagarme();
    } else {
        alert('Aceite os termos de compromisso!');
    }
    
}

function abrePaginaPagamento() {
    window.open($('#linkEscondido').val(), '_blank');
    {/literal}
    window.location.href='{$url_site}carrinho/confirmacao';
    {literal}
}*/

</script>
{/literal}

