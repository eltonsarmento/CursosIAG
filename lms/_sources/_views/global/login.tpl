<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cursos IAG - Painel</title>
<link rel="stylesheet" href="/lms/common/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="/lms/common/css/style.default.css" type="text/css" />

<script type="text/javascript" src="/lms/common/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/lms/common/js/modernizr.min.js"></script>
<script type="text/javascript" src="/lms/common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/lms/common/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/lms/common/js/custom.js"></script>
{literal}
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });
    });
</script>
{/literal}
</head>

<body class="loginpage">

<div class="loginpanel">
    <div class="loginpanelinner">
        <div class="logo"><img src="/lms/common/images/logo.png" alt="" /></div>
        <form id="login" action="" method="post">
            <input type="hidden" name="logar" value="1"/>

            {if $mensagem_erro}
                <p style="color:white;text-align:center;">{$mensagem_erro}</p>
            {/if}
            <div class="inputwrapper">
                <input type="text" name="usuario" id="username" placeholder="Digite seu e-mail" />
            </div>
            <div class="inputwrapper">
                <input type="password" name="senha" id="password" placeholder="Digite sua senha" />
            </div>
            <div class="inputwrapper">
                <button name="submit">ENTRAR</button>
            </div>
            <div class="inputwrapper">
                <div class="pull-right"><a href="/lms/recuperar-senha">Esqueci a Senha</a></div>
                <label><input type="checkbox" class="remember" value="1" name="lembrar" /> Mantenha-me logado</label>
            </div>
            
        </form>
    </div><!--loginpanelinner-->
</div><!--loginpanel-->

<div class="loginfooter">
    <p>&copy; 2014. Cursos <strong>IAG</strong>. Todos os direitos reservados.</p>
</div>

</body>
</html>
