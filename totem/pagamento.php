<?php
define ('USER_NOT_FOUND', 1);
define ('ENROLLMENT_DROPPED',2);
define ('TOO_MUCH_CREDIT', 3);

session_start();

if (isset($_POST['NumberLote'])){
		$matricula=$_POST['NumberLote'];
		$usuario=getUser($matricula);
		if (!is_null($usuario)){
			$_SESSION['usuario']=$usuario;
			if (check_authorization($usuario)){
			echo "<META http-equiv=\"refresh\" content=\"1;URL=credito.php\">";
			  exit();
			}
			else{
				echo "<META http-equiv=\"refresh\" content=\"1;URL=erro.php\">";
				exit();

			}
		}
		else{
				$_SESSION['ERROR']=USER_NOT_FOUND;
				echo "<META http-equiv=\"refresh\" content=\"1;URL=erro.php\">";
				exit();
		}
}


function getUser($regnum){
	$api_adress = 'http://35.199.101.182/api/usuarios/';
	$api_adress = $api_adress.$regnum;
	$json_user = file_get_contents($api_adress);
	$user = json_decode($json_user, true);
	return $user;
}

function check_authorization ($user){
		 if ($user['ID_STATUS']==2){
		 	 $_SESSION['ERROR']=ENROLLMENT_DROPPED;
			 return false;
		 }

		 else{
			if ($user['SALDO']>=100){
				$_SESSION['ERROR']=TOO_MUCH_CREDIT;
				return false;
			}
			else{
				$_SESSION['saldo']=$user['SALDO'];
				return true;
			}
		 }
}



?>
