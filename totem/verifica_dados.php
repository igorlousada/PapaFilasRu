<?php
define('API_TO_PAYMENT_CONNECTION_FAILED', 4);

session_start();

$user = $_SESSION['usuario'];
$creditos = number_format($_SESSION['creditos'], 2);
$matricula = $user['MATRICULA'];
$nome = $user['NOME_USUARIO'];
$user['SALDO'] = $creditos;

$dadosTransacao = registerTransaction($user);
$_SESSION['ID_HISTORICO']=$dadosTransacao['ID_HISTORICO']; // Recebe o ID_HISTORICO da transação registrada
// $url = getToken($id_transaction);

function registerTransaction($user){

$json_info = json_encode($user);
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Content-Type: application/json \r\n",
        'content' => $json_info
    )
));
$insertHistory = file_get_contents("http://35.199.101.182/api/creditos/insereHistorico", false, $context);
if (count(json_decode($insertHistory, true)) == 0){
  $_SESSION['ERROR']=API_TO_PAYMENT_CONNECTION_FAILED;
   echo "<META http-equiv=\"refresh\" content=\"1;URL=erro.php\">";
}
$insertHistory=json_decode($insertHistory, true);
return $insertHistory;
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

<!--Botão para voltar á pagina inicial -->
<div class="container">

  <div class="container">

  <div class="fixed-action-btn">
    <a href="credito.php"  class="btn-floating btn-large blue darken-4">
      <iclass="large material-icons" class="material-icons"><i class="material-icons">keyboard_backspace</i>
    </a>
  </div>

</div>

</div>


<!-- Mensagem inicial-->
<div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <br/>
  <br/>
<h1 class="header blue-text text-darken-4 ">Detalhes da Compra</h1>
  </div>


</div>

<!-- Input text-->
<div class="container">
  <div class="section">
    <br />
    <br />
<!-- joijojij -->
<!-- Titulo + imput text matricula-->
     <h5 class="header blue-text text-darken-4"><i class="material-icons">assignment_ind</i>Nome:</h1>
	<?php echo "<h5 class=\"header green-text\"> $nome <h5>"; ?>
      <h5 class="header blue-text text-darken-4"><i class="material-icons">playlist_add_check</i>Matrícula:</h1>
		<?php echo "<h5 class=\"header green-text\"> $matricula <h5>"; ?>
          <h5 class="header blue-text text-darken-4"><i class="material-icons">attach_money</i>Total a pagar:<h5 class="header green-text">R<?php echo "$ $creditos"; ?>
        <p class="blue-text">
      </p>
    <br />
    <br />

     <div class="row">
    <div class="col s12 m12 l12">
    </div>
      <a href="checkout.php">
      <button type="button" class="round btn waves-effect box" style="width:98%; height: 150px; font-size:40px" name="button">Enviar</button>
      </a>
      </div>
    </div>

</div>




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
