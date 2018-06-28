<?php

session_start();

if(!(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true)){
   echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\" />";
  exit();
}
else{
  if (!empty($_POST['NOME_ADMIN']) and !empty($_POST['SENHA_ADMIN'] and !empty($_POST['SENHA_ADMIN_CONFIRMACAO']))){
    if($_POST['SENHA_ADMIN']!=$_POST['SENHA_ADMIN_CONFIRMACAO']){
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Erro!","As senhas digitadas não conferem");';
      echo '}, 1000);</script>';
    }
    else{
      if(insertAdmin($_POST['NOME_ADMIN'], $_POST['SENHA_ADMIN'])){
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal({
        title: "Sucesso!",
        text: "O novo Administrador foi criado com sucesso!",
        type: "success"
      },
      function(){
          window.location.href = \'inicial.php\';
});';
        echo '}, 1000);</script>';
      }
      else{
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Erro!","Nome de Administrador já cadastrado! ");';
        echo '}, 1000);</script>';

      }

    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
  <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
  <title>Registro</title>

  <!-- CORE CSS-->

  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link rel="stylesheet" type="text/css" href="js\plugins\sweetalert\sweetalert.css">
  <script type="text/javascript" src="js\plugins\sweetalert\sweetalert.min.js"></script>

</head>

<body class="blue darken-4">
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
      <form class="login-form">
        <div class="row">
          <div class="input-field col s12 center">
            <h4>Cadastre um Administrador</h4>
          </div>
        </div>
      <form class="register-form" action="#" method="POST">
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input id="username" name="NOME_ADMIN" type="text">
            <label for="username" class="center-align">Nome de Usuário</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password" name="SENHA_ADMIN" type="password">
            <label for="password">Senha</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password-again" name="SENHA_ADMIN_CONFIRMACAO" type="password">
            <label for="password-again">Senha novamente</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <button type="submit" formmethod="POST" class="btn waves-effect waves-light col s12 green">Cadastre agora</button>
          </div>
          <div class="input-field col s12">
            <p class="margin center medium-small sign-up">Deseja voltar para a página inicial?  <a href="inicial.php">Clique aqui</a></p>
          </div>
        </div>
      </form>
    </div>
  </div>



  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <!--prism-->
  <script type="text/javascript" src="js/plugins/prism/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

      <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="js/plugins.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="js/custom-script.js"></script>

</body>

</html>

<?php

function insertAdmin($username, $password){
  $adminData = array('NOME_ADMIN' => $username,
                     'SENHA_ADMIN' => $password);

  $encodedAdminInformation = json_encode($adminData);

  $requestCreation =  stream_context_create(array(
          'http' => array(
          'method' => 'POST',
          'header' => "Content-Type: application/json; charset=utf-8 \r\n",
          'content' => $encodedAdminInformation
      )
  ));


  $request = file_get_contents("http://35.199.101.182/api/webadmin/addadmin", false, $requestCreation);
  $response = json_decode($request, true);
  $responseCode = substr($http_response_header[0], 9, 3);
  if($responseCode==200){
    return true;
  }
  else{
    return false;
  }
}
?>
