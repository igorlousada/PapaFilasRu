 <?php

session_start();
if(!(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true)){
    echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\" />";
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
  <title>Listas de acesso</title>

  <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
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

                <ol class="breadcrumbs">
                    <li><a href="inicial.html">Página Inicial</a></li>
                    <li class="active">Listas de acessos</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container">
        <div class="section">
        <div class="row">

        <!-- Início do primeiro card-->

    <div class="col s12 m12 l12">
    <div class="card-panel white">
        <h5>Lista Diária</h5>
        <div class="divider"></div>
        <div class="container">
          <form action="user_logs.php" method="post">
              <select name="DIA" class="browser-default">
              <option value="" disabled selected>Dia</option>
               <option value="01">1</option>
                <option value="02">2</option>
                   <option value="03">3</option>
                    <option value="04">4</option>
                     <option value="05">5</option>
                      <option value="06">6</option>
                       <option value="07">7</option>
                        <option value="08">8</option>
                         <option value="09">9</option>
                          <option value="10">10</option>
                           <option value="11">11</option>
                            <option value="12">12</option>
                             <option value="13">13</option>
                              <option value="14">14</option>
                               <option value="15">15</option>
                                <option value="16">16</option>
                                 <option value="17">17</option>
                                  <option value="18">18</option>
                                   <option value="19">19</option>
                                    <option value="20">20</option>
                                     <option value="21">21</option>
                                      <option value="22">22</option>
                                       <option value="23">23</option>
                                        <option value="24">24</option>
                                         <option value="25">25</option>
                                          <option value="26">26</option>
                                           <option value="27">27</option>
                                            <option value="28">28</option>
                                             <option value="29">29</option>
                                              <option value="30">30</option>
                                               <option value="31">31</option>

               </select>
        </div>
        <br><br>
        <div class="container">
              <select name="MES" class="browser-default">
              <option value="" disabled selected>Mês</option>
               <option value="01">Janeiro</option>
                <option value="02">Fevereiro</option>
                   <option value="03">Março</option>
                    <option value="04">Abril</option>
                     <option value="05">Maio</option>
                      <option value="06">Junho</option>
                       <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                         <option value="09">Setembro</option>
                          <option  value="10">Outubro</option>
                           <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
               </select>
        </div>
        <br><br>
        <div class="container">
              <select name="ANO" class="browser-default">
              <option value="" disabled selected>Ano</option>
              <?php
              for ($i=0; $i<=15; $i++){
                $ano = 2018+$i;
                echo "<option name=\"ANO\" value=\"$ano\">$ano</option>";
              }
              ?>
               </select>
               <div class="row">
               <br>
               <button type="submit" formmethod="POST" class="waves-effect waves-light btn-large blue darken-4">Mostrar</button>




    </div>
    </div>
    </div>
    </div>
             </form>

    <!-- Fim do primeiro card-->
    <br><br>
    </div>
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
