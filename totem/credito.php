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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/virtual-key.js"></script>
<link rel="stylesheet" type="text/css" href="css/virtual-key.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">



    <!-- Style que força o espaçamento entre as tabelas e as bordas arredondadas -->
    <style>
    #table_s
    {
        border-collapse: separate;
        border-spacing: 5px;
    }
    </style>

    <!--  Style que força a centralização dos elementos que preenchem as células das tabelas-->
    <style>

    #alinhado
    {
        text-align: center;
        align-content: center;
    }

    </style>


</head>

<body>


<!--Botão para voltar á pagina inicial -->
<div class="container">

  <div class="fixed-action-btn">
    <a  href="comprar.php"  class="btn-floating btn-large blue darken-4">
      <iclass="large material-icons" class="material-icons"><i class="material-icons">keyboard_backspace</i>
    </a>
  </div>

</div>


<!-- Mensagem inicial-->
<div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <br/>
  <br/>
<h4 class="header red-text"><?php echo $mensagem;?></h4>
<h1 class="header blue-text text-darken-4">Quantidade de créditos</h1>
<h3 class="header blue-text text-darken-4">Digite a quantidade de créditos que deseja comprar:</h3>
  </div>


</div>

<!-- Input text-->
<div class="container">
  <div class="section">
    <br />
    <br />
<!-- joijojij -->
<!-- Titulo + imput text créditos-->
<div class="row center">
  <div class="col s12 10">
          <div class="row">
              <form action="credito.php" method="POST">
                  <input style="font-size: 40px" type="text" step="0.50" readonly id="campo" placeholder="Créditos Desejados (R$)" class="teclado_text" name="NumberLote">
</section>

<table id="table_s" class="table_teclado">
  <tr style="width:70%; height: 150px; background-color: white">
    <td id="alinhado">1</td>
    <td id="alinhado">2</td>
    <td id="alinhado">3</td>
    <td id="alinhado">4</td>
  </tr>
  <tr style="width:70%; height: 150px">
    <td id="alinhado">5</td>
    <td id="alinhado">6</td>
    <td id="alinhado">7</td>
    <td id="alinhado">8</td>

  </tr>
  <tr style="width:70%; height: 150px">
    <td id="alinhado">9</td>
    <td id="alinhado">0</td>
    <td id="alinhado">.</td>
    <td id="alinhado"><span><i class="fa fa-arrow-left"></i></span></td>
  </tr>
</table>
  </div>
</div>

  </div>

  <div class="row">
    <div class="col s12 m12 l12">
    </div>
      <a href="verifica_dados.php">
      <button type="submit" class="round btn waves-effect box" style="width:98%; height: 150px; font-size:40px" name="action">Enviar</button>
      </a>
    </div>
  </form>

</div>
<?php
 if (!empty($_POST['NumberLote'])){
	 if ($_POST['NumberLote']<=$limite){
		 $_SESSION['creditos']=$_POST['NumberLote'];
     if(isset($_SESSION['Forbidden'])){
		unset($_SESSION['Forbidden']);
     }
		 echo "<META http-equiv=\"refresh\" content=\"0;URL=verifica_dados.php\">";
     exit();
	 }
	else{
    $_SESSION['Forbidden']=true;
	  echo "<META http-equiv=\"refresh\" content=\"0;URL=credito.php\">";
    exit();
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
