<?php

  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';
  require 'PHPMailer/src/Exception.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  $Mailer = new PHPMailer;

  $Mailer->IsSMTP();

 // envia email HTML
 $Mailer->isHTML(true);

 // codificação UTF-8, a codificação mais usada recentemente
 $Mailer->Charset = 'UTF-8';
 // Configurações do SMTP
 $Mailer->SMTPAuth = true;
 $Mailer->SMTPSecure = 'tls';
 $Mailer->Host = 'smtp.gmail.com';
 $Mailer->Port = 587;
 $Mailer->Username = 'ayrtonlaceda01@gmail.com';
 $Mailer->Password = 'sqn409bla';

 $Mailer->SMTPDebug = 2;

 // Email do remetente
 $Mailer->From = 'ayrtonlaceda01@gmail.com';

 // Nome do remetente
 $Mailer->FromName = 'Ayrton';

 // assunto da mensagem
 $Mailer->Subject = 'APIemail';

 // corpo da mensagem
 $Mailer->Body = 'Essa mensagem foi enviada com a API de email';

 // corpo da mensagem em modo texto
 $Mailer->AltBody = 'Mensagemem texto';

 // adiciona destinatário (pode ser chamado inúmeras vezes)
 $Mailer->AddAddress('moises.dandico23@gmail.com');

 // verifica se enviou corretamente
 if ($Mailer->Send())
 {
   echo "Enviado com sucesso";
 }
 else
 {
   echo 'Erro do PHPMailer:'.$Mailer->ErrorInfo;
 }

?>
