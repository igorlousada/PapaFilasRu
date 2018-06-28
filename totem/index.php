<?php
$propagandas = getAdvertising();
?>


<!DOCTYPE html>
<html lang="pt-br">


<head>
  <meta charset="utf-8" />
  <title>Pagina Inicial</title>

<!-- Importando google icons-->

   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- importando arquivos CSS-->
<link rel="stylesheet" href="css/materialize.min.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" href="css/style.css" />


</head>

<body>

<!-- Barra de navegação -->
<nav class="grad" role="navigation">
<div class="nav-wrapper container">
  <a id="logo-container " class="brand-logo">TotemRU</a>
</div>

</nav>


<!--Banner propagandas -->


  <div class="slider">
    <ul class="slides">
      <li>
        <img src="ru2.jpg">
        <div class="caption center-align">
          <h2>Seja Bem-vindo!</h2>
          <h5 class="light grey-text text-lighten-3">compre créditos RU</h5>
        </div>
      </li>
      <li>
        <img src="ru3.jpg">
        <div class="caption left-align">
          <h2>Cardápio da semana atualizado</h2>
          <h5 class="light grey-text text-lighten-3">Tudo em um lugar só!</h5>
        </div>
      </li>
      <?php
        for ($i=0; $i<count($propagandas); $i++){
          $anuncio = $propagandas[$i];
          $URL = $anuncio['URL'];
          echo "<li><img src=\"$URL\"></li>";
        }
        ?>
    </ul>
  </div>

	<br />
	<br />
	<br />
	<br />
	<br />





<!--Section destinada aos botoẽs -->

<div class="container">
  <div class="section">


  <!-- -->
  <!-- Linha 1, card 1, rest 1-->
  <div class="row">
      <div class="col s12 m12">
        <div class="card-panel box">
		<a href="comprar.php">
          <span class="white-text">
			<h2 class="white-text" style="text-align: center"> Comprar</h2>
          </span>
		 <a/>
        </div>
      </div>



  <!-- -->
  <!-- Linha 1, card 1, rest 1-->
  <div class="row">
      <div class="col s12 m12">
        <div class="card-panel box">
		<a href="saldo.html">
          <span class="white-text">
			<h2 class="white-text" style="text-align: center"> Saldo</h2>
          </span>
		 <a/>
        </div>
      </div>



  <!-- -->
  <!-- Linha 1, card 1, rest 1-->
  <div class="row">
      <div class="col s12 m12">
        <div class="card-panel box">
		<a href="filas.php">
          <span class="white-text">
			<h2 class="white-text" style="text-align: center"> Filas</h2>
          </span>
		 <a/>
        </div>
      </div>



  <!-- -->
  <!-- Linha 1, card 1, rest 1-->
  <div class="row">
      <div class="col s12 m12">
        <div class="card-panel box">
		<a href="cardapio.php">
          <span class="white-text">
			<h2 class="white-text" style="text-align: center"> Cardápio</h2>
          </span>
		 <a/>
        </div>
      </div>



<!-- Importando arquivos Jquery e JS-->
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script src="js/materialize.js"></script>
<script  type="text/javascript" src="js/materialize.min.js"></script>
<script>
$(document).ready(function(){
  $('.slider').slider();
});

</script>
</script>
</body>






</html>
<?php
function getAdvertising(){
  $api_adress = 'http://35.199.101.182/api/propaganda/lista';
  $request = file_get_contents($api_adress);
  $response = json_decode($request, true);
  return $response;
}
?>
