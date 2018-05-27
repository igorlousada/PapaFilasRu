<?php
define ('UNEXPECTED_ERROR_OCURRED', 6);
session_start();



// print_r($_GET);

if(isset($_GET['id_transacao'])){
  $id_transacao = $_GET['id_transacao'];
  updateBalance($id_transacao);
}

else{
 $_SESSION['ERROR']=UNEXPECTED_ERROR_OCURRED;
        echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/erro.php\">";
         exit();
}


function updateBalance($id_transaction){
$json_info = array('ID_TRANSACAO' => $id_transaction);
$json_info = json_encode($json_info);
$context = stream_context_create(array(
    'http' => array(
        'method' => 'PUT',
        'header' => "Content-Type: application/json \r\n",
        'content' => $json_info
    )
));

$update = file_get_contents("http://35.199.101.182/api/creditos/atualizasaldo", false, $context);
$update = json_decode($update);

// echo "Todo o código de resposta retornado é: ";
// print_r($http_response_header);
// echo "<br>";

$http_response_code = substr($http_response_header[0], 9, 3);
// echo "O responde code é: ";
// print_r($http_response_code);
// echo "<br>";

if (substr($http_response_header[0], 9, 3)!=200){
	echo "Response Code Failed";
  $_SESSION['ERROR']=$update;
  // echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/erro.php\">";
  //  exit();
}
return $update;
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
       <div class="card-panel blue darken-4 z-depth-2">
     <a href="pagina-inicial.html">
         <span class="white-text">
       <h2 class="white-text" style="text-align: center"> Retornar</h2>
         </span>
     <a/>
       </div>
     </div>
</div>


</script>
</body>

<meta http-equiv="refresh" content="30; url=pagina-inicial.html" />

</html>
