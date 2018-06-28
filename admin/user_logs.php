<?php

session_start();
if(!(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true)){
    echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\" />";
    exit();
  }
if(!empty($_POST['DIA']) and !empty($_POST['MES']) and !empty($_POST['ANO'])){
$data = setDate($_POST['DIA'], $_POST['MES'], $_POST['ANO']);
$HistoricoAcessos = getDailyHistory($data);
}
else{
  echo "<meta http-equiv=\"refresh\" content=\"0; url=access_list.php\" />";
  exit();
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
  <title>Lista De Acessos</title>

  <!-- Favicons-->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  <!-- For Windows Phone -->


  <!-- CORE CSS-->

  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">




  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link rel="stylesheet" type="text/css" href="js\plugins\sweetalert\sweetalert.css">
  <script type="text/javascript" src="js\plugins\sweetalert\sweetalert.min.js"></script>
</head>

<body>
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START HEADER -->

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
  <!-- END HEADER -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

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

      <!-- //////////////////////////////////////////////////////////////////////////// -->

      <!-- START CONTENT -->
      <section id="content">

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <div class="header-search-wrapper grey hide-on-large-only">
                <i class="mdi-action-search active"></i>
                <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
            </div>
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Lista Usuários</h5>
                <ol class="breadcrumbs">
                    <li><a href="index.html">Página Inicial</a></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container">
          <div class="section">


            <div class="divider"></div>

            <!--DataTables example-->
            <div id="table-datatables">
              <h4 class="header">Lista Usuários</h4>
              <div class="row">

                <div class="col s12">
                  <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Histórico</th>
                            <th>ID Usuário</th>
                            <th>Matrícula</th>
                            <th>Refeitório</th>
                            <th>Refeição</th>
                            <th>Hora de Entrada</th>
                            <th>ID do Grupo</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                          <th>ID Histórico</th>
                          <th>ID Usuário</th>
                          <th>Matrícula</th>
                          <th>Refeitório</th>
                          <th>Refeição</th>
                          <th>Hora de Entrada</th>
                          <th>ID do Grupo</th>

                        </tr>
                    </tfoot>

                    <tbody>
                      <?php
                      for ($i=0; $i<count($HistoricoAcessos); $i++){
                        $Acesso = $HistoricoAcessos[$i];
                        switch($Acesso['id_refeicao']){
                          case 1:
                            $Acesso['refeicao']="Desjejum";
                            break;
                          case 2:
                            $Acesso['refeicao']="Almoço";
                            break;
                          default:
                            $Acesso['refeicao']="Jantar";
                        }
                        echo "<tr>";
                        echo "<th>".$Acesso['id_historico']."</th>";
                        echo "<th>".$Acesso['id_usuario']."</th>";
                        echo "<th>".$Acesso['matricula']."</th>";
                        echo "<th>".$Acesso['id_refeitorio']."</th>";
                        echo "<th>".$Acesso['refeicao']."</th>";
                        echo "<th>".$Acesso['hora_entrada']."</th>";
                        echo "<th>".$Acesso['id_grupo']."</th>";
                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <br>
            <div class="divider"></div>

          </div>

        </div>
        <!--end container-->

      </section>
      <!-- END CONTENT -->

      <!-- //////////////////////////////////////////////////////////////////////////// -->


    </div>
    <!-- END WRAPPER -->

  </div>
  <!-- END MAIN -->



  <!-- //////////////////////////////////////////////////////////////////////////// -->





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
    <!-- data-tables -->
    <script type="text/javascript" src="js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/data-tables/data-tables-script.js"></script>
    <!-- chartist -->
    <script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="js/plugins.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="js/custom-script.js"></script>
    <script type="text/javascript">
        /*Show entries on click hide*/
        $(document).ready(function(){
            $(".dropdown-content.select-dropdown li").on( "click", function() {
                var that = this;
                setTimeout(function(){
                if($(that).parent().hasClass('active')){
                        $(that).parent().removeClass('active');
                        $(that).parent().hide();
                }
                },100);
            });
        });
    </script>
</body>

</html>
<?php
function getDailyHistory($date){
  $api_adress = "http://35.199.101.182/api/admin/ListaAcesso/";
  $api_date_adress = $api_adress.$date;
  $request = file_get_contents($api_date_adress);
  $response = json_decode($request, true);
  $responseCode = substr($http_response_header[0], 9, 3);
  if($responseCode==206){
    echo "<meta http-equiv=\"refresh\" content=\"0; url=log_error.php\" />";
    exit();
  }
  else{
    return $response;
  }

}

function setDate($day, $month, $year){
  $date=$year.'-'.$month.'-'.$day;
  return $date;
}
?>
