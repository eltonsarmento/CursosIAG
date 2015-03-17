    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="/lms/administrador-geral/dashboard/home"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="#">Configurações Gerais</a> <span class="separator"></span></li>
            <li>Informações de Pagamento</li>
            
            
        </ul>
        
        <div class="pageheader">
            <!-- BUSCA TOPO -->
            {include file="administrador-geral/busca_topo.tpl"}
            <!-- FIM BUSCA TOPO -->
            <div class="pageicon"><span class="iconfa-tasks"></span></div>
            <div class="pagetitle">
                <h5>Configurações Gerais</h5>
                <h1>Informações de Pagamento</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">

                <div class="row-fluid">

                    <!-- PAGARME -->
                    <div class="span6">
                        <div class="widget">
                            <h4 class="widgettitle">Pagarme</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="editarPagarme" />
                                    <input type="hidden" value="{$pagarme.pagarme_status}" name="pagarme_status"/>

                                    <p>
                                        <label>Status da Variação:</label>
                                        <span class="formwrapper">
                                            {if $pagarme.pagarme_status == 1}
                                                <strong>Ativo</strong>
                                            {else}
                                                <strong>Inativo</strong>
                                            {/if}
                                        </span>
                                    </p>

                                    <p>
                                        <label>Chave da API:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="pagarme_key_api" value="{$pagarme.pagarme_key_api}" class="span12" placeholder="ak_test_VI0RjtmUyIqfXUUYdLHGDOCEUHoUtk"  />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Chave de criptografia:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="pagarme_key_criptografia" value="{$pagarme.pagarme_key_criptografia}" class="span12" placeholder="ek_test_hjju4i8qJQm9hgSnbc1xQsTcTj1s6t" />
                                        </span>
                                    </p>
                        
                       
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                        {if $pagarme.pagarme_status eq 1}
                                            <button class="btn btn-danger" onclick="mudarStatusPagarme(); return false;">Desabilitar Variação</button>
                                        {else} 
                                            <button class="btn btn-success" onclick="mudarStatusPagarme(); return false;">Habilitar Variação</button>
                                        {/if}
                                    </p>
                   
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- PAGARME -->

                    <!-- PAGSEGURO -->
                     <div class="span6">
                        <div class="widget">
                            <h4 class="widgettitle">Pagseguro</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1" name="editarPagseguro" />
                                    <input type="hidden" value="{$pagseguro.pagseguro_status}" name="pagseguro_status"/>

                                    <p>
                                        <label>Status da Variação:</label>
                                        <span class="formwrapper">
                                            {if $pagseguro.pagseguro_status == 1}
                                                <strong>Ativo</strong>
                                            {else}
                                                <strong>Inativo</strong>
                                            {/if}
                                        </span>
                                    </p>

                                    <p>
                                        <label>E-mail de Cadastro:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="pagseguro_email" value="{$pagseguro.pagseguro_email}" class="span12" placeholder="adriano@adrianogianini.com.br" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Token de Segurança:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="pagseguro_token" value="{$pagseguro.pagseguro_token}" class="span12" placeholder="8DD59BE949F748608998A2E6879FE8A4" />
                                        </span>
                                    </p>
                        
                       
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                        {if $pagseguro.pagseguro_status == 1}
                                            <button class="btn btn-danger" onclick="mudarStatusPagseguro(); return false;">Desabilitar Variação</button>
                                        {else} 
                                            <button class="btn btn-success" onclick="mudarStatusPagseguro(); return false;">Habilitar Variação</button>
                                        {/if}
                                    </p>
                   
                                </form>
                            </div>
                        </div>
                    </div> 
                    <!-- FIM PAGSEGURO -->

                    <!-- MOIP -->
                    <!--
                    <div class="span6">
                        <div class="widget">
                            <h4 class="widgettitle">Moip</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="">
                                    
                                    <input type="hidden" value="1" name="editarMoip"/>
                                    <input type="hidden" value="{$moip.moip_status}" name="moip_status"/>

                                    <p>
                                        <label>Status da Variação:</label>
                                        <span class="formwrapper">
                                            {if $moip.moip_status == 1}
                                                <strong>Ativo</strong>
                                            {else}
                                                <strong>Inativo</strong>
                                            {/if}
                                        </span>
                                    </p>

                                    <p> 
                                        <label>Key:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="moip_key" value="{$moip.moip_key}" class="span12" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Token:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="moip_token" value="{$moip.moip_token}" class="span12" />
                                        </span>
                                    </p>
                           
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                        {if $moip.moip_status == 1}
                                            <button class="btn btn-danger" onclick="mudarStatusMoip(); return false;">Desabilitar Variação</button>
                                        {else} 
                                            <button class="btn btn-success" onclick="mudarStatusMoip(); return false;">Habilitar Variação</button>
                                        {/if}
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>-->
                    <!-- FIM MOIP -->
                </div>

                <div class="row-fluid">
                    <!-- PAYPAL -->
                    <!--
                    <div class="span6">
                        <div class="widget">
                            <h4 class="widgettitle">Paypal</h4>
                            <div class="widgetcontent">
                                <form class="stdform" method="post" action="">
                                    <input type="hidden" value="1"  name="editarPaypal"/>
                                    <input type="hidden" value="{$paypal.paypal_status}" name="paypal_status"/>
                                    <p>
                                        <label>Status da Variação:</label>
                                        <span class="formwrapper">
                                            {if $paypal.paypal_status == 1}
                                                <strong>Ativo</strong>
                                            {else}
                                                <strong>Inativo</strong>
                                            {/if}
                                        </span>
                                    </p>

                                    <p>
                                        <label>Usuário:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="paypal_usuario" value="{$paypal.paypal_usuario}" class="span12" placeholder="adrianogianini" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Senha:</label>
                                        <span class="formwrapper">
                                            <input type="password" name="paypal_senha" value="" class="span12" />
                                        </span>
                                    </p>

                                    <p>
                                        <label>Assinatura:</label>
                                        <span class="formwrapper">
                                            <input type="text" name="paypal_assinatura" value="{$paypal.paypal_assinatura}" class="span12" />
                                        </span>
                                    </p>
                            
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary">Salvar Variação</button>
                                        {if $paypal.paypal_status == 1}
                                            <button class="btn btn-danger" onclick="mudarStatusPaypal(); return false;">Desabilitar Variação</button>
                                        {else} 
                                            <button class="btn btn-success" onclick="mudarStatusPaypal(); return false;">Habilitar Variação</button>
                                        {/if}
                                    </p>                     
                                </form>
                            </div>
                        </div>
                    </div>  -->
                    <!-- FIM PAYPAL -->
                </div>
            </div>
        </div>
        <div class="footer">
                    <div class="footer-left">
                        <span>&copy; {date('Y')}. Cursos IAG.</span>
                    </div>
                    <div class="footer-right">
                        <span>Uma plataforma: <a href="http://www.iteacher.com.br/" title="iTeacher" target="_blank"><img src="http://www.iteacher.com.br/market/common/siteTemp/imgs/logo-iteacher.png" style="vertical-align:top;" width="70" class="img-responsive"></a></span>
                    </div>
                </div><!--footer-->
    </div><!--rightpanel-->
    <div id="resposta_trocar_status"></div>
{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    {/literal}
    {if $msg_alert} jAlert('{$msg_alert}'); {/if}
    {literal}
});

function mudarStatusPagseguro() {
    {/literal}
    jQuery.post('/lms/administrador-geral/configuracoesgerais/pagamentosMudarStatus', {ldelim} pagseguro_status:{$pagseguro.pagseguro_status} {rdelim}, function html(html) {ldelim} jQuery('#resposta_trocar_status').html(html); {rdelim});
    {literal}
}

function mudarStatusPagarme() {
    {/literal}
    jQuery.post('/lms/administrador-geral/configuracoesgerais/pagamentosMudarStatus', {ldelim} pagarme_status:{$pagarme.pagarme_status} {rdelim}, function html(html) {ldelim} jQuery('#resposta_trocar_status').html(html); {rdelim});
    {literal}
}

function mudarStatusMoip() {
    {/literal}
    jQuery.post('/lms/administrador-geral/configuracoesgerais/pagamentosMudarStatus', {ldelim} moip_status:{$moip.moip_status} {rdelim}, function html(html) {ldelim} jQuery('#resposta_trocar_status').html(html); {rdelim});
    {literal}
}

function mudarStatusPaypal() {
    {/literal}
    jQuery.post('/lms/administrador-geral/configuracoesgerais/pagamentosMudarStatus', {ldelim} paypal_status:{$paypal.paypal_status} {rdelim}, function html(html) {ldelim} jQuery('#resposta_trocar_status').html(html); {rdelim});
    {literal}
}
</script>  
{/literal}