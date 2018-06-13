<?php

session_start();

if(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true){
  if(array_key_exists('matricula', $_SESSION)){
    $matricula = $_SESSION['matricula'];
    $usuario = getUser($matricula);
    $AnoIngresso = substr($matricula, 0, 2);
    $semestreIngresso = substr($matricula, 2, 2)+1;
    $matriculaBarra = $AnoIngresso.'/'.substr($matricula, 2);
    $historicoCompras = getHistory($matricula);
    $historicoCompras = filterHistory($historicoCompras);
}
else{
    echo "<meta http-equiv=\"refresh\" content=\"0; url=erro.php\" />";
    exit();
  }
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
  <title>Página do Usuário</title>


  <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/sweetalert/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">

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
                        <li><a href="#"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                        </li>
                        <li><a href="#"><i class="mdi-content-add"></i>Add</a>
                        </li>
                    </ul>
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">John Doe<i class="mdi-navigation-arrow-drop-down right"></i></a>
                    <p class="user-roal">Administrator</p>
                </div>
            </div>
            </li>
            <!-- Aqui começa a navbar lateral-->

            <li class="bold"><a href="inicial.html" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Página Inicial</a>
            </li>

            <li class="bold"><a href="propaganda.html" class="waves-effect waves-cyan"><i class="mdi-action-visibility"></i>Propagandas</a>
            </li>

            <li class="bold"><a href="listas.html" class="waves-effect waves-cyan"><i class=" mdi-av-recent-actors"></i>Lista de acessos</a>
            </li>


            <li class="bold"><a href="listausuarios.html" class="waves-effect waves-cyan"><i class="mdi-action-face-unlock"></i>Lista de usuarios</a>
            </li>

            <li class="bold"><a href="usuario.html" class="waves-effect waves-cyan"><i class="mdi-action-info-outline"></i>Usuário</a>
            </li>

            <li class="bold"><a href="abrir.html" class="waves-effect waves-cyan"><i class="mdi-action-lock-outline"></i>Abrir/Fechar restaurante(s)</a>
            </li>

            <li class="bold"><a href="app-email.html" class="waves-effect waves-cyan"><i class="mdi-action-description"></i>Cardápio</a>
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
                <h4 class="breadcrumbs-title">Perfil</h4>
                <ol class="breadcrumbs">
                    <li><a href="inicial.html">Página Inicial</a></li>
                    <li class="active">Página do usuário</li>
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

                <ul id="profile-page-about-details" class="collection z-depth-1">
                  <li class="collection-item">
                    <div class="row">
                      <div class="col s5 grey-text darken-1"><i class="mdi-action-wallet-travel"></i> Nome</div>
                      <div class="col s7 grey-text text-darken-4 right-align"><?php echo $usuario['NOME_USUARIO'];?></div>
                    </div>
                  </li>
                  <li class="collection-item">
                    <div class="row">
                      <div class="col s5 grey-text darken-1"><i class="mdi-social-poll"></i>Tipo</div>
                      <div class="col s7 grey-text text-darken-4 right-align"><?php echo $usuario['ID_GRUPO']; ?></div>
                    </div>
                  </li>
                  <li class="collection-item">
                    <div class="row">
                      <div class="col s5 grey-text darken-1"><i class="mdi-social-domain"></i>Matrícula</div>
                      <div class="col s7 grey-text text-darken-4 right-align"><?php echo $matriculaBarra; ?></div>
                    </div>
                  </li>
                  <li class="collection-item">
                    <div class="row">
                      <div class="col s5 grey-text darken-1"><i class="mdi-social-cake"></i>Semestre</div>
                      <div class="col s7 grey-text text-darken-4 right-align"><?php echo $semestreIngresso.'/'.$AnoIngresso; ?></div>
                    </div>
                  </li>
                </ul>
              </div>


              <div class="row">
                  <div class="col s6 m6">
                      <!-- Div para gerar a onda de luz quando o botão é pressionado-->
                      <div class="card-move-up waves-effect waves-block waves-light">
                              <div class="card amber darken-2">
                                <div class="card-content white-text center-align">
                                  <p class="card-title"><i class="mdi-editor-attach-money"></i><?php echo $usuario['SALDO'];?></p>
                                  <p>Carteira</p>
                                </div>

                              </div>
                      </div>


                  </div>
                  <form action="/admin/inserir_creditos.php" method="post">
                  <input type="hidden" name="matricula" value="<?php echo $matricula;?>">
                  <a href="inserir_creditos.php">
                  <div class="col s6 m6">
                      <div class="card-move-up waves-effect waves-block waves-light">
                      <div class="card green">
                            <div class="card-content white-text center-align">
                              <p class="card-title"><i class="mdi-content-add"></i>Adicionar</p>
                              <p>Inserir créditos</p>
                            </div>
                      </div>
                  </div>
                </a>
              </div>
        </form>


          <!-- -->


            <div class="container">
                <div class="row">
               <div class="col s12 m12">
                 <div class="card-panel white">
                     <div id="borderless-table">
                       <h4 class="header">Lista de Transações do usuário</h4>
                       <div class="row">
                         <div class="col s12 m4 l3">
                           <p><?php echo $usuario['NOME_USUARIO'];?></p>
                          <p><?php echo $matriculaBarra; ?></p>
                         </div>
                         <div class="col s12 m8 l9">
                           <table>
                             <thead>
                               <tr>
                                 <th data-field="date">Data</th>
                                 <th data-field="hour">Hora</th>
                                 <th data-field="price">Valor da Compra</th>
                                <th data_field="status">Status da Compra</th>
                               </tr>
                             </thead>

                             <tbody>
                               <?php
                                  showHistory($historicoCompras);
                          /*
                               <tr>
                                 <td>12/05/2018</td>
                                 <td>R$: 2,50</td>
                                 <td>1</td>
                                <td>1</td>
                                <td>Totem 3</td>
                               </tr>
                               <tr>
                                 <td>16/05/2018</td>
                                 <td>R$: 10,00</td>
                                 <td>4</td>
                                <td>1</td>
                                <td>Aplicativo</td>
                               </tr><tr>
                                 <td>30/05/2018</td>
                                 <td>R$: 5,00</td>
                                 <td>2</td>
                                <td>0</td>
                                <td>Totem 1</td>
                               </tr>
                             </tbody>*/
                             ?>
                           </table>
                         </div>
                       </div>
                     </div>

            </div>


               </div>
             </div>
           </div>


        </div>







               <!-- ESCREVA AQUI SUAS DIVS-->


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
    <!--sweetalert -->
    <script type="text/javascript" src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="js/plugins.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="js/custom-script.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){
        "use strict";

        $('.btn-success').click(function(){
        	swal("Créditos adicionados com sucesso!", "", "success");
        });

        $('.card-warning-confirm').click(function(){
        	swal({
        		title: "Tem certeza?",
        		text: "Você irá perder todos os dados deste usuário!",
        		type: "warning",
        		showCancelButton: true,
        		confirmButtonColor: '#DD6B55',
        		confirmButtonText: 'remover!',
        		closeOnConfirm: false
        	},
        	function(){
        		swal("usuário removido!", "", "success");
        	});
        });

    });
    </script>

</body>

</html>

<?php
function getUser($regnum){
	$api_adress = 'http://35.199.101.182/api/usuarios/';
	$api_adress = $api_adress.$regnum;
	$json_user = file_get_contents($api_adress);
	$user = json_decode($json_user, true);
	return $user;
}

function getHistory($regnum){
  $api_adress = 'http://35.199.101.182/api/historico/';
	$api_adress = $api_adress.$regnum;
	$json_log = file_get_contents($api_adress);
	$history = json_decode($json_log, true);
	return $history;
}

function filterHistory($history){
  $transactionApproved = array();
  for($i=0; $i<count($history); $i++){
    $orderLog = $history[$i];
    if($orderLog['CODIGO_STATUS']==3 || $orderLog['CODIGO_STATUS']==4){
      $formattedLog = array();
      $splitTime = explode(' ', $orderLog['DATA_COMPRA']);
      $formattedLog['DATA']=$splitTime[0];
      $formattedLog['HORA']=$splitTime[1];
      $formattedLog['VALOR']=$orderLog['VALOR_COMPRA'];
      $formattedLog['CODIGO_STATUS']=$orderLog['CODIGO_STATUS'];
      array_push($transactionApproved, $formattedLog);
    }
  }
    return $transactionApproved;
}

function showHistory($historyClean){
  for($i=0; $i<count($historyClean); $i++){
    $register = $historyClean[$i];
    echo "<tr><td>".$register['DATA']."</td>";
    echo "<td>".$register['HORA']."</td>";
    echo "<td>".$register['VALOR']."</td>";
    echo "<td>".$register['DATA']."</td></tr>";
  }
  echo "</tbody>";
}
?>
