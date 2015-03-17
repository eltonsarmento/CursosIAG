<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Modelo E-mail</title>

</head>
<body style="background:#fff;width:600px;font-family:'Arial',sans-serif;color:#999;margin:0 auto;padding:0;">

	<div style="background:#e25143;width:600px;height:auto;padding:20px 0;margin:60px 0 0 0;border-top-left-radius:4px;border-top-right-radius:4px;">

		<div style="width:160px;height:40px;margin:0 auto;"><a href="http://cursosiag.com.br/lms"><img src="{$imagem_header}"></a></div>

	</div>

	<div style="background:#fff;width:558px;padding:20px;border:1px solid #ccc;border-top:0;border-bottom:0;">

		<h1 style="font-size:20px;font-weight:700;text-align:left;color:#999;margin:0 0 20px 0;">{$titulo}</h1>

		{$mensagem}
		<br/>
		<span style="font-size:10px;font-weight:400;color:#f00;">E-mail automático. Por favor, não responda a este endereço de e-mail!</span>

	</div>

	<div style="background:#f0f0f0;width:558px;padding:20px;margin:0;text-align:center;border:1px solid #ccc;border-bottom-left-radius:4px;border-bottom-right-radius:4px;">

		<p style="font-size:14px; font-weight:400; text-align:center;color:#999;">{$texto_rodape}</p>

	</div>

</body>
</html>