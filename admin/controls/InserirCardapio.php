<?php 

require '../../api/conectadb.php';


	//recebe as variaveis do formulario por POST
$data   			= $_POST['data'];
$bebidas_q_1   		= $_POST['bebidas_q_1'];
$bebidas_q_veg_1    = $_POST['bebidas_q_1'];
$pao_1   			= $_POST['pao_1'];
$pao_veg_1   		= $_POST['pao_veg_1'];
$achocolatado_1   	= $_POST['achocolatado_1'];
$complemento_1   	= $_POST['complemento_1'];
$complemento_veg_1 	= $_POST['complemento_veg_1'];
$proteina_1   		= $_POST['proteina_1'];
$proteina_veg_1   	= $_POST['proteina_veg_1'];
$fruta_1   			= $_POST['fruta_1'];
$salada_2   		= $_POST['salada_2'];
$molho_2   			= $_POST['molho_2'];
$prato_principal_2  = $_POST['prato_principal_2'];
$guarnicao_2   		= $_POST['guarnicao_2'];
$prato_veg_2   		= $_POST['prato_veg_2'];
$acompanhamentos_2  = $_POST['acompanhamentos_2'];
$sobremesa_2   		= $_POST['sobremesa_2'];
$refresco_2   		= $_POST['refresco_2'];
$salada_3   		= $_POST['salada_3'];
$molho_3   			= $_POST['molho_3'];
$sopa_3   			= $_POST['sopa_3'];
$pao_3   			= $_POST['pao_3'];
$prato_principal_3  = $_POST['prato_principal_3'];
$guarnicao_3   		= $_POST['guarnicao_3'];
$prato_veg_3   		= $_POST['prato_veg_3'];
$complementos_3   	= $_POST['complementos_3'];
$sobremesa_3   		= $_POST['sobremesa_3'];
$refresco_3   		= $_POST['refresco_3'];

$sql1 = "INSERT INTO `cardapio_desjejum`(`data_refeicao`, `bebidas_q`, `bebidas_q_veg`, `achocolatado`, `pao`, `pao_veg`, `complemento`, `complemento_veg`, `proteina`, `proteina_veg`, `fruta`) VALUES ('$data', '$bebidas_q_1', '$bebidas_q_veg_1', '$pao_1', '$pao_veg_1', '$achocolatado_1', '$complemento_1', '$complemento_veg_1', '$proteina_1', '$proteina_veg_1', '$fruta_1')";

$sql2 = "INSERT INTO `cardapio_almoco`(`data_refeicao`, `salada`, `molho`, `prato_principal`, `guarnicao`, `prato_veg`, `acompanhamentos`, `sobremesa`, `refresco`) VALUES ('$data', '$salada_2', '$molho_2', '$prato_principal_2', '$guarnicao_2', '$prato_veg_2', '$acompanhamentos_2', '$sobremesa_2', '$refresco_2')";

$sql3 = "INSERT INTO `cardapio_jantar`(`data_refeicao`, `salada`, `molho`, `sopa`, `pao`, `prato_principal`, `prato_veg`, `complementos`, `sobremesa`, `refresco`) VALUES ('$data', '$salada_3', '$molho_3', '$sopa_3', '$pao_3', '$prato_principal_3', '$prato_veg_3', '$complementos_3', '$sobremesa_3', '$refresco_3')";


$pdo = db_connect();
$stmt1=$pdo->prepare($sql1);
$stmt1->execute();
$stmt2=$pdo->prepare($sql2);
$stmt2->execute();
$stmt3=$pdo->prepare($sql3);
$stmt3->execute();

$retorno_get.= "sucesso_insert=1&";
header('Location: ../cardapio.html?'.$retorno_get);
die();
?>