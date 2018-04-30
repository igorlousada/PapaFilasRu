<?php 

try{
	
$username = "root";
$password = '';	
	
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
				$saldo = getBalance ($verifica_usuario, $db);
			}
			else{
				die("Erro! Usuário Inexistente!");
			}
 }
 else{
	 die("Erro! Conexão Imprópria!");
 }
 
function getUser($database, $regnum){
	$user = $database->prepare("SELECT * FROM `usuario` WHERE `matricula_usuario` = ?");
						$user->bindValue(1, $regnum);
						$user->execute();
	$user = $user->fetchAll(\PDO::FETCH_ASSOC);
	$user = $user[0];
	return $user;
}
			
			
			
function getBalance ($user, $database){
	     $SQL="SELECT `saldo` FROM `carteira_usuario` WHERE `id_usuario` = ?";
		 $id_usuario=$user['id_usuario'];
		 $balance = $database->prepare($SQL);
				  $balance->bindValue(1, $id_usuario);
				  $balance->execute();
		$balance = $balance->fetchAll(\PDO::FETCH_ASSOC);
		$balance = $balance[0];
		$balance = $balance['saldo'];			
		return $balance;
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
    <a  href="pagina-inicial.html"  class="btn-floating btn-large blue">
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
  <h5 class=" header blue-text"> <?php echo "$matricula"; ?></h5>
<br />
<br />
<br />
<br />
<br />
<div class=" container">
    <div class="row center">
      <h3 class="header blue-text"> <i class=" small material-icons">autorenew
</i>Conta RU</h3>
    </div>
  </div>
  <div class="darken-2 blue container">
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