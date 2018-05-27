<?php

define ('USER_NOT_FOUND_IN_CHECK', 5);
define ('UNEXPECTED_ERROR_OCURRED', 6);

session_start();

if (isset($_POST['NumberLote'])){
		$matricula=$_POST['NumberLote'];

		if (!UserExists($matricula)){
				$_SESSION['ERROR']=USER_NOT_FOUND_IN_CHECK;
				echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/erro.php\">";
				exit();
		}
    else{
    $usuario=getUser($matricula);
		$saldo = $usuario['SALDO'];
  }
}
else{
  $_SESSION['ERROR']=UNEXPECTED_ERROR_OCURRED;
  echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/erro.php\">";

}


  function UserExists($regnum){
  $responsecode = getResponseCode($regnum);
  if ($responsecode == 200)
    return true;
  else
    return false;
}


function getResponseCode($regnum){
  $api_adress = 'http://35.199.101.182/api/usuarios/'.$regnum;
  $header = get_headers($api_adress);
  $code = substr($header[0], 9, 3);
  return $code;
}


function getUser($regnum){
	$api_adress = 'http://35.199.101.182/api/usuarios/';
	$api_adress = $api_adress.$regnum;
	$json_user = file_get_contents($api_adress);
	$user = json_decode($json_user, true);
	return $user;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <title>comprar</title>

<!-- Importando google icons-->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- importando arquivos CSS-->
<link rel="stylesheet" href="css/materialize.min.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" href="css/style.css" />

</head>

<body>
<div class="container">

  <div class="fixed-action-btn">
    <a  href="pagina-inicial.html"  class="btn-floating btn-large blue darken-4">
      <iclass="large material-icons" class="material-icons"><i class="material-icons">keyboard_backspace</i>
    </a>
    <ul>
      <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>
      <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
      <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
      <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
</ul>
  </div>

</div>

<!-- Mensagem inicial-->
<div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <h5 class="header blue-text text-darken-4"> <?php echo "Olá, $matricula"; ?></h5>
<br />
<br />
<br />
<br />
<br />
<div class=" container">
    <div class="row center">
      <h3 class="header blue-text text-darken-4"> <i class=" small material-icons">autorenew
</i>Conta RU</h3>
    </div>
  </div>
  <div class="darken-4 blue container">
    <div class="row center">
<br />
<br />
<h1 class="header white-text">Saldo Disponível:</h1>
</div>
<h3 class="header white-text"> <i class="  small material-icons">assignment_turned_in
</i><?php echo "Seu saldo é de R$" .number_format($saldo, 2, ',', '.')."<br>"; ?></h3>
<br />
<br />
<br />
<br />
<br />
</div>
</div>


</div>



</script>
</body>

</html>
