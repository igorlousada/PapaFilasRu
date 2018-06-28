<?php

session_start();
if(!(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true)){
   echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\" />";
  exit();
}

require '../api/conectadb.php';

 //recebe as variaveis do formulario por POST
$data      			= utf8_decode($_POST['data']);
$bebidas_q_1     	= utf8_decode($_POST['bebidas_q_1']);
$bebidas_q_veg_1    = utf8_decode($_POST['bebidas_q_1']);
$pao_1      		= utf8_decode($_POST['pao_1']);
$pao_veg_1     		= utf8_decode($_POST['pao_veg_1']);
$achocolatado_1    	= utf8_decode($_POST['achocolatado_1']);
$complemento_1    	= utf8_decode($_POST['complemento_1']);
$complemento_veg_1  = utf8_decode($_POST['complemento_veg_1']);
$proteina_1     	= utf8_decode($_POST['proteina_1']);
$proteina_veg_1    	= utf8_decode($_POST['proteina_veg_1']);
$fruta_1      		= utf8_decode($_POST['fruta_1']);
$salada_2     		= utf8_decode($_POST['salada_2']);
$molho_2      		= utf8_decode($_POST['molho_2']);
$prato_principal_2  = utf8_decode($_POST['prato_principal_2']);
$guarnicao_2     	= utf8_decode($_POST['guarnicao_2']);
$prato_veg_2     	= utf8_decode($_POST['prato_veg_2']);
$acompanhamentos_2  = utf8_decode($_POST['acompanhamentos_2']);
$sobremesa_2     	= utf8_decode($_POST['sobremesa_2']);
$refresco_2     	= utf8_decode($_POST['refresco_2']);
$salada_3     		= utf8_decode($_POST['salada_3']);
$molho_3      		= utf8_decode($_POST['molho_3']);
$sopa_3      		= utf8_decode($_POST['sopa_3']);
$pao_3      		= utf8_decode($_POST['pao_3']);
$prato_principal_3  = utf8_decode($_POST['prato_principal_3']);
$guarnicao_3     	= utf8_decode($_POST['guarnicao_3']);
$prato_veg_3     	= utf8_decode($_POST['prato_veg_3']);
$complementos_3    	= utf8_decode($_POST['complementos_3']);
$sobremesa_3     	= utf8_decode($_POST['sobremesa_3']);
$refresco_3     	= utf8_decode($_POST['refresco_3']);


$sql1 = "INSERT INTO `cardapio_desjejum`(`id_refeicao`,`data_refeicao`, `bebidas_q`, `bebidas_q_veg`, `achocolatado`, `pao`, `pao_veg`, `complemento`, `complemento_veg`, `proteina`, `proteina_veg`, `fruta`) VALUES ('1','$data', '$bebidas_q_1', '$bebidas_q_veg_1', '$pao_1', '$pao_veg_1', '$achocolatado_1', '$complemento_1', '$complemento_veg_1', '$proteina_1', '$proteina_veg_1', '$fruta_1')";

$sql2 = "INSERT INTO `cardapio_almoco`(`id_refeicao`,`data_refeicao`, `salada`, `molho`, `prato_principal`, `guarnicao`, `prato_veg`, `acompanhamentos`, `sobremesa`, `refresco`) VALUES ('2','$data', '$salada_2', '$molho_2', '$prato_principal_2', '$guarnicao_2', '$prato_veg_2', '$acompanhamentos_2', '$sobremesa_2', '$refresco_2')";

$sql3 = "INSERT INTO `cardapio_jantar`(`id_refeicao`,`data_refeicao`, `salada`, `molho`, `sopa`, `pao`, `prato_principal`, `prato_veg`, `complementos`, `sobremesa`, `refresco`) VALUES ('3','$data', '$salada_3', '$molho_3', '$sopa_3', '$pao_3', '$prato_principal_3', '$prato_veg_3', '$complementos_3', '$sobremesa_3', '$refresco_3')";


$pdo = db_connect();
$stmt1=$pdo->prepare($sql1);
$stmt1->execute();
$stmt2=$pdo->prepare($sql2);
$stmt2->execute();
$stmt3=$pdo->prepare($sql3);
$stmt3->execute();

$retorno_get= "sucesso_insert=1&";
header('Location: cardapio.php?'.$retorno_get);
die();
?>
