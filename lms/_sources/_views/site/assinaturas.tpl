        <section class="container">

            <section class="assinature-title">

                <section class="assinature-title-content">

                    <h1>Assinaturas</h1>

                </section><!--.assinature-title-content-->

            </section><!--.assinature-title-->
			
			<section class="assinature-content">
				{foreach item=plano from=$planos}

				<article>
				
					<h1>{$plano.plano}</h1>

                    <section class="plan-price-total">
                        
                        <span>Pagamento Único de: <strong>R$ {$plano.valor}</strong> equivalente a R$ {math equation="( x / y)" x=$plano.valor y=$plano.meses format="%.2f"}/mês</span>
                    
                    </section><!--.plan-price-total-->
					
					<section class="plan-time">
						
						<span>Tempo de Acesso: <strong>{$plano.meses} {if $plano.meses > 1} Meses {else} Mês {/if}</strong></span>
					
					</section><!--.plan-time-->
					
					<section class="plan-button">
					
						<button class="btn-orange" onclick="javascript:window.location.href='{$url_site}carrinho/adicionarPlano/{$plano.id}'">Assine Agora</button>
						
					</section><!--.plan-button-->

                    <section class="plan-info">
						
						<p>{$plano.descricao}</p>
					
					</section><!--.plan-info-->
				
				</article>

                {/foreach}								
            </section><!--.assinature-content-->
        
        </section><!--.container-->