<?php

session_start();
if(!(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true)){
    echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\" />";
    exit();
  }?>




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
    <title>propaganda</title>

    <!-- CORE CSS-->
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--dropify-->
    <link href="js/plugins/dropify/css/dropify.min.css" type="text/css" rel="stylesheet" media="screen,projection">

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
                  <h4 class="breadcrumbs-title">Gerenciamento de propagandas</h4>
                  <ol class="breadcrumbs">
                      <li><a href="inicial.html">Página Inicial</a></li>
                      <li class="active">Gerenciamento de propagandas</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->



          <!--start container-->
          <div class="container">
            <!--file-upload-->
            <div id="file-upload" class="section">

               <!--TOTEM-->
  			 <h4 class="header">Totem</h4>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <p>Insira o link do anúncio que será exibido no totem </p>
                </div>

                  </div>

                  <div class="col s12 m12 l12">
                      <div class="card-panel white">
                          <form action="upload.php" method="post" enctype="multipart/form-data">
                          <div class="row section">
                            <div class="col s12 m12 l2">
                            </div>
                            <div class="col s12 m12 l12">
                              <p><b> URL da Imagem </b></p>
                              <input type="text" name="URL" placeholder="Insira a URL da Imagem">
                            </div>
                            <div class="col s6 m6 l6">
                              <br>
                              <p><b>Data de Início da Exibição</b></p>
                              <input type="date" name="DATA_INICIO"/>
                            </div>
                            <div class="col s12 m6 l6">
                              <br>
                              <p> <b>Data de Término da Exibição</b></p>
                              <input type="date" name="DATA_FIM"/>
                            </div>
                          </div>
                          <button type="submit" name="submit" class="btn waves-effect blue darken-4">Enviar</button>
                   </form>



                      </div>

                  </div>
              </div>

        </section>
        <!-- END CONTENT -->



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
      <!--angularjs-->
      <script type="text/javascript" src="js/plugins/angular.min.js"></script>
      <!--materialize js-->
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <!--prism -->
      <script type="text/javascript" src="js/plugins/prism/prism.js"></script>
      <!--scrollbar-->
      <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
      <!-- chartist -->
      <script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>
      <!-- dropify -->
      <script type="text/javascript" src="js/plugins/dropify/js/dropify.min.js"></script>
      <!--plugins.js - Some Specific JS codes for Plugin Settings-->
      <script type="text/javascript" src="js/plugins.min.js"></script>
      <!--custom-script.js - Add your own theme custom JS-->
      <script type="text/javascript" src="js/custom-script.js"></script>

      <script type="text/javascript">
          $(document).ready(function(){
              // Basic
              $('.dropify').dropify();

              // Translated
              $('.dropify-fr').dropify({
                  messages: {
                      default: 'Glissez-déposez un fichier ici ou cliquez',
                      replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                      remove:  'Supprimer',
                      error:   'Désolé, le fichier trop volumineux'
                  }
              });

              // Used events
              var drEvent = $('.dropify-event').dropify();

              drEvent.on('dropify.beforeClear', function(event, element){
                  return confirm("Do you really want to delete \"" + element.filename + "\" ?");
              });

              drEvent.on('dropify.afterClear', function(event, element){
                  alert('File deleted');
              });
          });
      </script>

  </body>

  </html>
