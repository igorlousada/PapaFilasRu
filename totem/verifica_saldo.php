<?php

define ('USER_NOT_FOUND_IN_CHECK', 5);
define ('UNEXPECTED_ERROR_OCURRED', 6);

session_start();

if (isset($_POST['NumberLote'])){
		$matricula=$_POST['NumberLote'];

		if (!UserExists($matricula)){
				$_SESSION['ERROR']=USER_NOT_FOUND_IN_CHECK;
				echo "<META http-equiv=\"refresh\" content=\"1;URL=erro.php\">";
				exit();
		}
    else{
    $usuario=getUser($matricula);
		$saldo = $usuario['SALDO'];
  }
}
else{
  $_SESSION['ERROR']=UNEXPECTED_ERROR_OCURRED;
  echo "<META http-equiv=\"refresh\" content=\"1;URL=erro.php\">";

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
    <a  href="index.php"  class="btn-floating btn-large blue darken-4">
     <i class="  material-icons" align="center">keyboard_backspace</i>
    </a>
  </div>

</div>

<br><br><br><br><br><br>
<!-- Card com saldo atual-->

<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel box z-depth-3">
                <span class="text-align center"><h1 class="header white-text">Saldo Disponível:</h1></span>
                <span class="text-align center">
                <h5 class=" header blue-text" style="text-align: center"> <?php echo "$matricula"; ?></h5>
                <br><br>
                <h3 class="header white-text" style="text-align: center"><?php echo "Seu saldo é de R$" .number_format($saldo, 2, ',', '.')."<br>"; ?></h3>
                </span>

            </div>

        </div>


    </div>

	<br><br><br><br><br><br>

</div>




</body>

</html>
