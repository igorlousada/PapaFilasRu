<?php

 $statusRestaurante = getRestaurantStatus();
 $statusRefeitorios = splitCafeterias($statusRestaurante);
 $corRefeitorios = getCafeteriasPrintColor($statusRefeitorios);
  ?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <title>filas</title>

<!-- Importando google icons-->

   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- importando arquivos CSS-->
<link rel="stylesheet" href="css/materialize.min.css" />
<link rel="stylesheet" href="css/custom.css" />


</head>

<body>

<!--Botão para voltar á pagina inicial -->
<div class="container">

  <div class="fixed-action-btn">
    <a  href="index.php"  class="btn-floating btn-large blue darken-4">
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
<h1 class="header blue-text text-darken-4">Tempo de fila</h1>
<h3 class="blue-text text-darken-4"> Quanto tempo vou esperar?</h3>
  </div>
</div>

<div class="container">

  <!-- Linha 1, card 1, rest 1-->
  <?php
  for ($i=0; $i<count($statusRefeitorios); $i++){?>
  <div class="row">
      <div class="col s12 m12">
        <div class="card-panel <?php echo $corRefeitorios[$i];?>">
		<a href="cardapio.php">
          <span class="white-text">
            <h4 class="white-text"> Restaurante <?php echo $i+1;?></h4>
            <p class="white-text">
              Tempo de Espera: <?php echo $statusRefeitorios[$i]['tempo_espera']; ?> minutos <br>
              Ocupação: <?php echo $statusRefeitorios[$i]['lotacao'];?> /200<br>
            </p>
          </span>
		  <a/>
        </div>
      </div>
<?php
    }
?>

<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript">


</script>
</body>






</html>
<?php
function getRestaurantStatus(){
  $status_api_adress = 'http://35.199.101.182/api/filas/status';
  $status = file_get_contents($status_api_adress);
  $status = json_decode($status, true);
  return $status;
}

function splitCafeterias($restaurantStatus){
  $cafeteriaStatus = array();
  $statusWithNumericalIndexes = array_values($restaurantStatus);
  for($i=0; $i<count($statusWithNumericalIndexes); $i=$i+2){
    $cafeteriaOccupancy = $statusWithNumericalIndexes[$i];
    $cafeteriaWaitTime =  $statusWithNumericalIndexes[$i+1];
    $cafeteriaArray = array('lotacao' => $cafeteriaOccupancy,
                            'tempo_espera' => $cafeteriaWaitTime);
    array_push($cafeteriaStatus, $cafeteriaArray);
  }
  return $cafeteriaStatus;
}

function getCafeteriasPrintColor($cafeteriaStatus){
  $cafeteriasPrintColor = array();
  for ($i=0; $i<count($cafeteriaStatus); $i++){
    if($cafeteriaStatus[$i]['tempo_espera']<=40){
      $cafeteriasPrintColor[$i]='green';
    }
    else if($cafeteriaStatus[$i]['tempo_espera']<=80){
      $cafeteriasPrintColor[$i]='green darken-3';
    }
    else if($cafeteriaStatus[$i]['tempo_espera']<=120){
      $cafeteriasPrintColor[$i]='yellow darken-3';
    }
    else if($cafeteriaStatus[$i]['tempo_espera']<=160){
      $cafeteriasPrintColor[$i]='orange';
    }
    else{
      $cafeteriasPrintColor[$i]='red';
    }
  }
  return $cafeteriasPrintColor;
}
  ?>
