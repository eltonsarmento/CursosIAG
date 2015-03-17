<?php
require_once(dirname(__FILE__).'/../_sources/libraries/phpmailer/class.phpmailer.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"

$mail->IsSendmail(); 

$mail->SetFrom('carloswgama@gmail.com', 'Carlos');
$mail->AddAddress('carlos@kmf.com.br');

$mail->Subject    = "Teste sendmail";
$mail->MsgHTML('Enviado');


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
    