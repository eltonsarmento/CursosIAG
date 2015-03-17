
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cursos IAG</title>
<link rel="stylesheet" href="{$url_site}lms/common/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="{$url_site}lms/common/css/style.shinyblue.css" type="text/css" />

<script type="text/javascript" src="{$url_site}lms/common/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="{$url_site}lms/common/js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="{$url_site}lms/common/js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="{$url_site}lms/common/js/modernizr.min.js"></script>
<script type="text/javascript" src="{$url_site}lms/common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{$url_site}lms/common/js/jquery.cookie.js"></script>
<script type="text/javascript" src="{$url_site}lms/common/js/custom.js"></script>

</head>

<body class="loginpage">

<div class="loginpanel">
    <div class="loginpanelinner">
        <div class="logo animate0 bounceIn"><img src="{$url_site}lms/common/images/logo.png" alt="" /></div>
        <form id="login" action="" method="post">
            <input type="hidden" value="1" name="enviar"/>
            <span style="color:white;">{$msg}</span>
            <div class="inputwrapper login-alert">
                <div class="alert alert-error">Usuário ou senha inválido</div>
            </div>
            <div class="inputwrapper animate1 bounceIn">
                <input type="text" name="email" id="username" placeholder="Digite seu e-mail" />
            </div>
            <div class="inputwrapper animate2 bounceIn">
                <button name="submit">RECUPERAR</button>
            </div>

            <div class="inputwrapper animate3 bounceIn">
                <div class="pull-right">Voltar para o <a href="{$url_site}lms/" class="text-center">Login</a></div>
            </div>
        </form>
    </div><!--loginpanelinner-->
</div><!--loginpanel-->

<div class="loginfooter">
    <p>&copy; {$smarty.now|date_format:"%Y"}. Cursos IAG. Todos os direitos reservados.</p>
</div>

</body>
</html>
