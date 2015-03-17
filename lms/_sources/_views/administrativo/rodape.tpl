</div><!--mainwrapper-->
<!-- MODAL SENHA -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="modalSenha">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
        <h3 id="myModalLabel">Alterar Senha</h3>
    </div>
    <div class="modal-body">
        <form action="" id="formSenha" onsubmit="return false;">
        	<div id="resposta_trocar_senha"></div>
            <p class="margintop10">
                <input type="password" class="input-large" name="senha_atual" placeholder="Senha atual">
            </p>

            <p class="margintop10">
                <input type="password" class="input-large" name="senha_nova" placeholder="Nova senha">
            </p>

            <p class="margintop10">
                <input type="password" class="input-large" name="senha_confirmacao" placeholder="Repita sua senha">
            </p>

        <button class="btn btn-primary" onclick="alterarSenha();">Alterar Senha</button>

        </form>

    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div><!--#myModal-->
{literal}
<script type="text/javascript" src="/lms/common/js/forms.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        // tabbed widget
        jQuery('.tabbedwidget').tabs();
    });

function alterarSenha() {
	{/literal}
	jQuery.post('/lms/administrativo/perfil/trocarSenha', jQuery('#formSenha').serialize(), function html(html) {ldelim} jQuery('#resposta_trocar_senha').html(html); {rdelim});
	{literal}
}

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47443824-1', 'cursosiag.com.br');
  ga('send', 'pageview');

</script>
{/literal}
</body>
</html>