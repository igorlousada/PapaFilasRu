<?php

session_start();

$usuario = $_SESSION['usuario'];

$saldo_atual = $usuario['SALDO'];
$limite=number_format(100-$saldo_atual, 2);
$mensagem = "Você possui R$ " .$saldo_atual. " créditos e pode comprar mais R$ " .$limite. " em créditos";
if (isset($_SESSION['Forbidden'])){
  $mensagem = "Erro! Você tentou adquirir uma quantidade de créditos superior ao seu limite de aquisição. Você só pode adquirir mais R$ " .$limite. " em créditos";
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <title>comprar</title>

<!-- Importando google icons-->

   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- importando arquivos CSS-->
<link rel="stylesheet" href="css/materialize.min.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" href="css/style.css" />

</head>

<body>

<!--Botão para voltar á pagina inicial -->
<div class="container">

  <div class="fixed-action-btn">
    <a  href="comprar.html"  class="btn-floating btn-large blue">
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
  <br/>
  <br/>
<h4 class="header red-text"><?php echo $mensagem;?></h4>
<h1 class="header blue-text">Quantidade de créditos</h1>
  </div>


</div>

<!-- Input text-->
<div class="container">
  <div class="section">
    <br />
    <br />
<!-- joijojij -->
<!-- Titulo + imput text créditos-->
    <h5 class="header blue-text">Insira a quantidade de créditos que deseja comprar</h1>
      <p class="blue-text">
        Para concluir sua compra, digite a quantidade de créditos desejada:
      </p>
    <br />
    <br />

   <div class="row center">
<div class="col s12 10">
  <div class="card-panel">
    <div class="row">
      <section class="input-filts col s12">
	  
	<form action="credito.php" method="POST">
         <input type="Number" name="NumberLote" placeholder="Quantidade" class="center" style="font-size: 2rem;">
         <label for="NumberLote"></label>
      </section>
 
   
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(1)"><p>1</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(2)"><p>2</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(3)"><p>3</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(4)"><p>4</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(5)"><p>5</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(6)"><p>6</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(7)"><p>7</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(8)"><p>8</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(9)"><p>9</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard('none')"><p></p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(0)"><p>0</p></div>
        <div class="col s4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard('Clear')"><p>Clear</p></div>
      
    </div>
  </div>
</div>
  

  </div>
      <a href="verifica_dados.php">  <button class="btn waves-effect waves-light blue" type="submit" name="action" style="width: 150px; height: 100px">Enviar
    <i class="material-icons right">send</i>
  </button></a>
  </form>
        
</div>
<?php
 if (isset($_POST['NumberLote']) and count($_POST)>0){
	 if ($_POST['NumberLote']<=$limite){
		 $_SESSION['creditos']=$_POST['NumberLote'];
     if(isset($_SESSION['Forbidden'])){
      unset($_SESSION['Forbidden']);
     }
		 echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/verifica_dados.php\">";
	 }
	else{
    $_SESSION['Forbidden']=true;
	  echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/credito.php\">";	
	}
}
?>

<script src="js/index.js"></script>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script src="js/materialize.js"></script>
<script  type="text/javascript" src="js/materialize.min.js"></script>
<script>
$(document).ready(function() {
   $('input#input_text, textarea#textarea2').characterCounter();
 });

</script>
</body>

</html>