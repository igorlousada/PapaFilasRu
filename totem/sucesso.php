<?php
define ('UNEXPECTED_ERROR_OCURRED', 6);
session_start();

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
<h1 class="header blue-text text-darken-4">Sua compra foi concluída com sucesso!</h1>
<br />
<i class="material-icons large left">sentiment_very_satisfied
</i><h4 class="header blue-text text-darken-4">Volte Sempre</h4>
<br />
<br />
<br />
<br />
<br />
  </div>


</div>

<div class="container">
   <div class="row center">
     <div class="col s12 m12">
       <div class="card-panel box">
     <a href="index.php">
         <span class="white-text">
       <h2 class="white-text" style="text-align: center"> Retornar</h2>
         </span>
     <a/>
       </div>
     </div>
</div>


</script>
</body>

<meta http-equiv="refresh" content="30; url=index.php" />

</html>
