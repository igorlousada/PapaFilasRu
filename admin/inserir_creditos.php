<?php

session_start();

if (array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true){
  if(array_key_exists('ID_TRANSACAO', $_POST) and !empty($_POST['ID_TRANSACAO'])){
    if(CheckAndCorrectPurchase($_POST['ID_TRANSACAO'])){
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal({
      title: "Transação Corrida com Sucesso!",
      text: "Créditos inseridos com sucesso.",
      type: "success"
    },
    function(){
        window.location.href = \'inicial.php\';
});';
      echo '}, 1000);</script>';
    }
    else{
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Erro!","Impossível inserir créditos! Os Créditos dessa Transação já foram inseridos");';
      echo '}, 1000);</script>';
    }

  }
}
else{
  echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\" />";
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<!--================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 3.1
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
================================================================================ -->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
  <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
  <title>Quantidade de Créditos</title>


  <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link rel="stylesheet" type="text/css" href="js\plugins\sweetalert\sweetalert.css">
  <script type="text/javascript" src="js\plugins\sweetalert\sweetalert.min.js"></script>

</head>
<body>

    <header id="header" class="page-topbar">
          <!--NavBar-->
          <div class="navbar-fixed">
              <nav>
              <div class="nav-wrapper blue darken-4">
                  <h4 class="brand-logo">Administrador</h4>
              </div>
            </nav>
          </div>
          <!--NavBar-->
    </header>

    <!-- START MAIN -->
    <div id="main">
      <!-- START WRAPPER -->
      <div class="wrapper">

        <!-- START LEFT SIDEBAR NAV-->
        <aside id="left-sidebar-nav">
          <ul id="slide-out" class="side-nav fixed leftside-navigation">
              <li class="user-details cyan darken-2">
              <div class="row">
                  <div class="col col s4 m4 l4">
                      <img src="" alt="" class="circle responsive-img valign profile-image">
                  </div>
                  <div class="col col s8 m8 l8">
                      <ul id="profile-dropdown" class="dropdown-content">
                          <li><a href="logout.php"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                          </li>
                          <li><a href="user-register.php"><i class="mdi-content-add"></i>Add</a>
                          </li>
                      </ul>
                      <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $_SESSION['username']; ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                      <p class="user-roal">Administrator</p>
                  </div>
              </div>
              </li>
              <!-- Aqui começa a navbar lateral-->
              <li class="bold"><a href="inicial.php" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Página Inicial</a>
              </li>

              <li class="bold"><a href="propaganda.php" class="waves-effect waves-cyan"><i class="mdi-action-visibility"></i>Propagandas</a>
              </li>

              <li class="bold"><a href="access_list.php" class="waves-effect waves-cyan"><i class=" mdi-av-recent-actors"></i>Lista de acessos</a>
              </li>
              <li class="bold"><a href="user_list.php" class="waves-effect waves-cyan"><i class="mdi-action-face-unlock"></i>Lista de usuarios</a>
              </li>

              <li class="bold"><a href="usuario.php" class="waves-effect waves-cyan"><i class="mdi-action-info-outline"></i>Usuário</a>
              </li>

              <li class="bold"><a href="cardapio.php" class="waves-effect waves-cyan"><i class="mdi-action-description"></i>Cardápio</a>
              </li>
              </ul>
              </div>


                      <!-- acaba aqui por enquanto-->
              </aside>
        <!-- END LEFT SIDEBAR NAV-->

      <!-- START CONTENT -->
      <section id="content">

        <!--breadcrumbs start-->

        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container">
           <div class="section">
            <?php
            if(!empty($mensagem)){
                echo "<h4><p style=\"color: Red\">$mensagem</h4></p>";
                echo "<br>";
            }
            ?>
            <p class="caption">Digite o ID da Transação a ser corrigida</p>
            <div class="divider"></div>
          </div>
		  <div class="row">
             <form class="col s12" action="#" method="POST">
          <div class="row">

          <div class="input-field col s6">
             <input id="ID_TRANSACAO" type="number" class="validate" name="ID_TRANSACAO">

             <label for="ID_TRANSACAO">ID da Transação</label>
         </div>
          </div>
      </div>
	   <div class="row">
          <button type="submit" formmethod="post" class="waves-effect waves-light btn-large blue darken-4">Enviar</button>
  </div>
         </form>

        </div>
        <!--end container-->
      </section>

    </div>


  </div>



    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--prism
    <script type="text/javascript" src="js/prism/prism.js"></script>-->
    <!--scrollbar-->
    <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!-- chartist -->
    <script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="js/plugins.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="js/custom-script.js"></script>

</body>

</html>

<?php
function CheckAndCorrectPurchase($transactionID){
  $api_adress = 'http://35.199.101.182/api/admin/CorrigeTransacao/';
  $user_api_adress = $api_adress.$transactionID;
  $user = json_decode(file_get_contents($user_api_adress), true);
  $responseCode = substr($http_response_header[0], 9, 3);
   if ($responseCode==206){
    return false;
  }
  else{
    return true;
  }
}
