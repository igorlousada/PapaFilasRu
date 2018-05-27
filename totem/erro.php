<?php

session_start();
if (isset($_SESSION['ERROR'])){
  $codigo = $_SESSION['ERROR'];
  switch($codigo){
    case 1:
      $mensagem = "Não foi possível proceder com a compra. A matrícula informada não foi encontrada.";
      break;
    case 2:
      $mensagem = "Não foi possível proceder com a compra. A matrícula informada está trancada.";
      break;
    case 3:
      $mensagem = "Não foi possível proceder com a compra. A matrícula informada já atingiu o limite máximo de créditos permitidos. ";
      break;
    case 4:
      $mensagem = "Não foi possível proceder com a compra. Erro na conexão com o PagSeguro.";
      break;
    case 5:
      $mensagem = "Não foi possível realizar a consulta de saldo. A matrícula informada não foi encontrada.";
      break;
    case 6:
      $mensagem = "Não foi possível proceder com a compra. Um erro inesperado aconteceu. <br> Tente Novamente.";
      break;
    default:
      $mensagem = $codigo;
      break;
  }
}
else{
      $mensagem = "Não foi possível proceder com a compra. Um erro inesperado aconteceu. <br> Tente Novamente.";
}

$_SESSION = array();
session_destroy();
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


<!-- Mensagem inicial-->
<div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <br/>
  <br/>
<h1 class="header red-text">OPS! Algo deu errado na sua compra</h1>

<h4 class="header blue-text text-darken-4"><?php echo $mensagem; ?></h4>
<br />
<br />
<i class="material-icons large left">sentiment_very_dissatisfied
</i><h5 class=" header blue-text text-darken-4"> Para o caso de combranças indevidas mande um email para xxxxxx@gmail.com</h5>
<br />
<br />
<br />
<br />
<br />
  </div>


</div>

<div class="container">
    <div class="row">

      <div class="col s12 m12">
        <div class="card-panel blue darken-4 z-depth-2">
      <a href="pagina-inicial.html">
          <span class="white-text">
      <h2 class="white-text" style="text-align: center"> Retornar</h2>
          </span>
      <a/>
        </div>
      </div>





    </div>
  </div>


</div>
</div>

<meta http-equiv="refresh" content="30; url=pagina-inicial.html">


</script>
</body>

</html>
