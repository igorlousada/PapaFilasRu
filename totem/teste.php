<?php 

$matricula = 17000000;
$usuario = get_headers("http://35.199.101.182/api/usuarios/".$matricula);
$codigo = substr($usuario[0], 9, 3);
if ($codigo == 206){
	echo "Deu xabu!";
}
if ($codigo == 200){
	echo "Deu good!";
}

function getUser($regnum){
	$api_adress = 'http://35.199.101.182/api/usuarios/';
	$api_adress = $api_adress.$regnum; 
	$json_user = file_get_contents($api_adress);
	$user = json_decode($json_user, true);
	return $user;
}
?>
