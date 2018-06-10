<?php

session_start();

if(!(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true)){
   echo "<meta http-equiv=\"refresh\" content=\"0; url=/admin/erro.php\" />";
  exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
  <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
  <title>Página Inicial</title>


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
                        <li><a href="#"><i class="mdi-content-add"></i>Add</a>
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

            <li class="bold"><a href="propaganda.html" class="waves-effect waves-cyan"><i class="mdi-action-visibility"></i>Propagandas</a>
            </li>

            <li class="bold"><a href="listas.html" class="waves-effect waves-cyan"><i class=" mdi-av-recent-actors"></i>Lista de acessos</a>
            </li>


            <li class="bold"><a href="listausuarios.html" class="waves-effect waves-cyan"><i class="mdi-action-face-unlock"></i>Lista de usuarios</a>
            </li>

            <li class="bold"><a href="usuario.php" class="waves-effect waves-cyan"><i class="mdi-action-info-outline"></i>Usuário</a>
            </li>

            <li class="bold"><a href="abrir.html" class="waves-effect waves-cyan"><i class="mdi-action-lock-outline"></i>Abrir/Fechar restaurante(s)</a>
            </li>

            <li class="bold"><a href="cardapio.html" class="waves-effect waves-cyan"><i class="mdi-action-description"></i>Cardápio</a>
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
                <h4 class="breadcrumbs-title">Seja Bem-Vindo!</h4>
                <ol class="breadcrumbs">
                    <li><a href="inicial.html">Página Inicial</a></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container">
          <div class="section">
            <div>
              <!-- ESCREVA AQUI SUAS DIVS-->


                  <!--Cards iniciais -->
                  <div class="row">
                  <div class="col s12 m4">
                    <div class="card small">
                      <div class="card-image">
                        <img src="images/cadeado.png">
                      </div>
                      <div class="card-content black-text">
                      <p class="black-text">Acesse a página para abrir/fechar restaurantes</p>
                    </div>
                      <div class="card-action">
                        <a href="abrir.html">Abrir/Fechar restaurante</a>
                      </div>
                    </div>
                  </div>

                  <div class="col s12 m4">
                    <div class="card small">
                      <div class="card-image">
                        <img src="images/olho.png">
                      </div>
                      <div class="card-content black-text">
                      <p class="black-text">Acesse o gerenciamento de propagandas</p>
                    </div>
                      <div class="card-action">
                        <a href="propaganda.html">Gerenciar propagandas</a>
                      </div>
                    </div>
                  </div>

                  <div class="col s12 m4">
                    <div class="card small">
                      <div class="card-image">
                        <img src="images/lista.png">
                      </div>
                      <div class="card-content black-text">
                      <p class="black-text">Acesse as listas</p>
                    </div>
                      <div class="card-action">
                        <a href="listausuarios.html">Usuários</a>
                        <a href="usuario.html">Transações</a>
                        <a href="listas.html">Acessos</a>
                      </div>
                    </div>
                  </div>
                </div>




              <!-- Cards iniciais-->
              <!--Card tempo de fila  -->

              <!-- Card tempo de fila-->


              <!-- Card estatística-->
              <div id="chart-dashboard">
                  <div class="row">
                      <div class="col s12 m12 l12">
                          <div class="card">
                              <div class="card-move-up waves-effect waves-block waves-light">
                                  <div class="move-up cyan darken-1">
                                      <div>
                                          <span class="chart-title white-text">Revenue</span>
                                          <div class="chart-revenue cyan darken-2 white-text">
                                              <p class="chart-revenue-total">$4,500.85</p>
                                              <p class="chart-revenue-per"><i class="mdi-navigation-arrow-drop-up"></i> 21.80 %</p>
                                          </div>
                                          <div class="switch chart-revenue-switch right">
                                              <label class="cyan-text text-lighten-5">
                                                Month
                                                <input type="checkbox">
                                                <span class="lever"></span> Year
                                              </label>
                                          </div>
                                      </div>
                                      <div class="trending-line-chart-wrapper">
                                          <canvas id="trending-line-chart" height="70"></canvas>
                                      </div>
                                  </div>
                              </div>
                              <div class="card-content">
                                  <a class="btn-floating btn-move-up waves-effect waves-light darken-2 right"><i class="mdi-content-add activator"></i></a>
                                  <div class="col s12 m3 l3">
                                      <div id="doughnut-chart-wrapper">
                                          <canvas id="doughnut-chart" height="200"></canvas>
                                          <div class="doughnut-chart-status">4500
                                              <p class="ultra-small center-align">Sold</p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col s12 m2 l2">
                                      <ul class="doughnut-chart-legend">
                                          <li class="mobile ultra-small"><span class="legend-color"></span>Mobile</li>
                                          <li class="kitchen ultra-small"><span class="legend-color"></span> Kitchen</li>
                                          <li class="home ultra-small"><span class="legend-color"></span> Home</li>
                                      </ul>
                                  </div>
                                  <div class="col s12 m5 l6">
                                      <div class="trending-bar-chart-wrapper">
                                          <canvas id="trending-bar-chart" height="90"></canvas>
                                      </div>
                                  </div>
                              </div>

                              <div class="card-reveal">
                                  <span class="card-title grey-text text-darken-4">Revenue by Month <i class="mdi-navigation-close right"></i></span>
                                  <table class="responsive-table">
                                      <thead>
                                          <tr>
                                              <th data-field="id">ID</th>
                                              <th data-field="month">Month</th>
                                              <th data-field="item-sold">Item Sold</th>
                                              <th data-field="item-price">Item Price</th>
                                              <th data-field="total-profit">Total Profit</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>1</td>
                                              <td>January</td>
                                              <td>10000</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>2</td>
                                              <td>February</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>3</td>
                                              <td>March</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>4</td>
                                              <td>April</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>5</td>
                                              <td>May</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>6</td>
                                              <td>June</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>7</td>
                                              <td>July</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>8</td>
                                              <td>August</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>9</td>
                                              <td>Septmber</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>10</td>
                                              <td>Octomber</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>11</td>
                                              <td>November</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                          <tr>
                                              <td>12</td>
                                              <td>December</td>
                                              <td>122</td>
                                              <td>100</td>
                                              <td>$122,00.00</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>


                          </div>
                      </div>
             <!-- Card estatística-->
            </div>
          </div>
        </div>
        <!--end container-->
      </section>
      <!-- END CONTENT -->
    </div>
  </div>




  <!-- //////////////////////////////////////////////////////////////////////////// -->



    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
    <!-- jQuery Library -->
    <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>


    <!-- chartist -->
    <script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>

    <!-- chartjs -->
    <script type="text/javascript" src="js/plugins/chartjs/chart.min.js"></script>
    <script type="text/javascript" src="js/plugins/chartjs/chart-script.js"></script>

    <!-- sparkline -->
    <script type="text/javascript" src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/plugins/sparkline/sparkline-script.js"></script>

    <!-- google map api -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAZnaZBXLqNBRXjd-82km_NO7GUItyKek"></script>

    <!--jvectormap-->
    <script type="text/javascript" src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script type="text/javascript" src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script type="text/javascript" src="js/plugins/jvectormap/vectormap-script.js"></script>

    <!--google map-->
    <script type="text/javascript" src="js/plugins/google-map/google-map-script.js"></script>


    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="js/plugins.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="js/custom-script.js"></script>

    </script>

</body>

</html>
