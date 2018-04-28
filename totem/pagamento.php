<?php

$username = 'root';
$password = '';

session_start();

try{
$db = new PDO ("mysql:host=localhost; dbname=papafilas", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
   }
catch(PDOException $e)
	{
		die("A Conexão Falhou! Impossível de conectar com o Banco de Dados");
	};

if (isset($_POST['matricula'])){
		$matricula=$_POST['matricula'];	
		$verifica_usuario=getUser($db, $matricula);
		
		if (count($verifica_usuario)>0){
			$usuario=$verifica_usuario[0];
			$_SESSION['usuario']=$usuario;
			if (check_authorization($usuario, $db)){
			echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/credito.php\">";
			// header("Location: /PapaFilasRU/totem/credito.php", TRUE, 307);
			  exit();
			}
			else{
				echo "Usuário não autorizado!";
			}
		}
		
		else{
			try{
				$MW = new PDO ("mysql:host=localhost; dbname=matriculaweb", "root", "");
				$MW->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			}
		catch(PDOException $e)
			{
				die("A Conexão Falhou! Impossível de conectar com o Banco de Dados do Matricula Web");
			};
			
		$verifica_mw = getUser($MW, $matricula);
		
		if (count($verifica_mw)>0){
			$usuario=$verifica_mw[0];
			insertUser($db, $usuario);
			if (check_authorization($usuario, $db)){
				$_SESSION['usuario']=$usuario;
				echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/credito.php\">";
				// header("Location: /PapaFilasRU/totem/credito.php", TRUE, 307);
				 exit();
			}
		else{
				die();
			}
		}
		else{
			echo "Impossível prosseguir com a compra! Usuário não cadastrado!";
			}
	}
}


function getUser($database, $regnum){
	$user = $database->prepare("SELECT * FROM `usuario` WHERE `matricula_usuario` = ?");
						$user->bindValue(1, $regnum);
						$user->execute();
	$user = $user->fetchAll(\PDO::FETCH_ASSOC);
	return $user;
}

function insertUser ($database, $user){
		$SQL = "INSERT INTO `usuario` (`id_usuario`,`matricula_usuario`, `nome_usuario`, `cpf`, `email_usuario`, `id_grupo`, `id_status`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
		$inclui=$database->prepare($SQL);
	    $inclui->bindValue(1, $user['matricula_usuario'], PDO::PARAM_STR);
		$inclui->bindValue(2, $user['nome_usuario'], PDO::PARAM_STR);
		$inclui->bindValue(3, $user['cpf'], PDO::PARAM_STR);
		$inclui->bindValue(4, $user['email_usuario'], PDO::PARAM_STR);
		$inclui->bindValue(5, $user['id_grupo'], PDO::PARAM_STR);
		$inclui->bindValue(6, $user['id_status'], PDO::PARAM_STR);
		$inclui->execute();
}

function check_authorization ($user, $database){
	     $SQL="SELECT `saldo` FROM `carteira_usuario` WHERE `id_usuario` = ?";
		 $id_usuario=$user['id_usuario'];
		 $saldo = $database->prepare($SQL);
				  $saldo->bindValue(1, $id_usuario);
				  $saldo->execute();
		$saldo = $saldo->fetchAll(\PDO::FETCH_ASSOC);
		$saldo = $saldo[0];
		$saldo = $saldo['saldo'];
		$teste = ($saldo>=100);
		 $status=$user['id_status'];
		 if ($status==2){
			 echo "Impossível realizar a compra. A matrícula informada está trancada. <br>";
			 return false;
		 }
		 else{
			if ($saldo>=100){
				echo $saldo;
				echo "<br>";
				echo "Impossível realizar a compra. A matrícula informada já atingiu o limite máximo em créditos permitidos <br>";
				return false;
			}
			else{
				$_SESSION['saldo']=$saldo;
				return true;
			}
		 }
}



?>
