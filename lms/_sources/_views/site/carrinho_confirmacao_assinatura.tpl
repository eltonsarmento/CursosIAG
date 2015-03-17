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

                    <i class="fa fa-angle-right active-row"></i>
                    <section class="circle active-circle">
                        <span>4</span>
                        <p>Confirmação</p>
                    </section><!--.verified-->

                </section><!--.verified-->

                <section class="page-title">
                    <h1>Confirmação</h1>
                </section><!--.page-title-->

                <section class="page-content">
                    <!-- <h2> Assinatura ID: {$assinaturaID}</h2>
                    <h2> Status do pagamento: {$assinaturaMensagem} </h2>

                    {if $boletoURL}
                    <h2> Acesse o boleto de pagameto, <a href="{$boletoURL}" target="_blank">clicando aqui</a> , ou cado caso opte o codigo do boleto é: {$boletoBarcode}.</h2>
                    {/if} -->
                    {if $boletoURL != ''}
                        <div class="text-center">
                        
                            <h2>Pedido Realizado com sucesso!</h2>

                            <h3>Número do pedido: <strong style="color:#e25143;">{$numeroPedido}</strong></h3>
                        
                        </div>
                        
                        <div class="border" style="background:#f0f0f0;width:100%;height:2px;margin: 30px 0;display:block;"></div>
                        
                        <div class="text-center" style="margin-bottom:30px;">
                            
                            <a href="{$boletoURL}" target="_blank" class="btn-orange">Imprimir Boleto</a>
                            
                            <span style="display:block;margin-top:20px;">Você receberá um cópia do boleto em seu e-mail.</span>
                            
                        </div>
                    {/if}


                    <p>Agradecemos a confiança em investir nos nossos treinamentos. A partir de agora temos um compromisso com você por um longo período. Faremos de tudo para que nunca mais seja o mesmo após nossos treinamentos.</p>

                    <p>Qualquer dúvida nosso atendimento está disponível de segunda a sexta em horário comercial ou através do email <a href="mailto:atendimento@cursosiag.com.br">atendimento@cursosiag.com.br</a>.</p>

                    <p>Seja bem vindo a família Cursos IAG.</p>

                    <p> Adriano Gianini - Diretor</p>                   
                </section><!--.page-content-->

            </section><!--.page-->
        
        </section><!--.container-->
        