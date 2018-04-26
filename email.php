<?php

  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';
  require 'PHPMailer/src/Exception.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  $email = $_POST['Email'];
  //$assunto = $_POST['Assunto'];
  $Nome = $_POST['Nome'];
  $saldo = $_POST['Saldo'];
  $creditos = $_POST['Creditos'];

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
 $Mailer->FromName = 'PAPAFILAS';

 // assunto da mensagem
 $Mailer->Subject = 'Atualização de Creditos';

 // corpo da mensagem
 $mensagem = $Nome.", você comprou ".$creditos." creditos, e seu saldo é de $".$saldo."\n\n P@P@filas";
 $Mailer->Body = $mensagem;

 // corpo da mensagem em modo texto
 //$Mailer->AltBody = $mensagem;

 // adiciona destinatário (pode ser chamado inúmeras vezes)
 $Mailer->AddAddress($email);

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
