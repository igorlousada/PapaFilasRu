<?php
#metodo retorna cardapio do dia
$app->get('/cardapio/{anomesdia}', function (Request $request, Response $response,array $args) {
	$anomesdia = $args['anomesdia'];
	$pdo = db_connect();
 
	$sql1=" SELECT * FROM `cardapio_desjejum` 	WHERE data_refeicao = :anomesdia";
	$sql2=" SELECT * FROM `cardapio_almoco` 	WHERE data_refeicao = :anomesdia";
	$sql3=" SELECT * FROM `cardapio_jantar` 	WHERE data_refeicao = :anomesdia";

	//statment 1: desjejum
	$stmt1=$pdo->prepare($sql1);
	$stmt1->bindParam(":anomesdia", $anomesdia);
	$stmt1->execute();
	//statment 2: almoco
	$stmt2=$pdo->prepare($sql2);
	$stmt2->bindParam(":anomesdia", $anomesdia);
	$stmt2->execute();
	//statment 3: jantar
	$stmt3=$pdo->prepare($sql3);
	$stmt3->bindParam(":anomesdia", $anomesdia);
	$stmt3->execute();


	if(($stmt1->rowCount()>0)AND($stmt2->rowCount()>0)AND($stmt3->rowCount()>0)){
		$desjejum 	= $stmt1->fetch(PDO::FETCH_ASSOC);
		$almoco 	= $stmt2->fetch(PDO::FETCH_ASSOC);
		$jantar 	= $stmt3->fetch(PDO::FETCH_ASSOC);

		            $registro = array(
                       /* "ID_USUARIO"   		=> $resultado["id_usuario"],
						"MATRICULA"   		=> $resultado["matricula_usuario"],
                        "NOME_USUARIO"     	=> utf8_encode($resultado["nome_usuario"]),
                        "CPF" 				=> $resultado["cpf"],
                        "EMAIL"    			=> $resultado["email_usuario"],
						"ID_GRUPO"   		=> $resultado["id_grupo"],
						"ID_STATUS"			=> $resultado["id_status"],
						"SALDO"				=> $resultado["saldo"],*/
                    );
		
		//$return = $response->withJson($registro)->withHeader('Content-type', 'application/json');
		//return $return;			
	
	}else{ //Se nao retornar desultado do BD, retorne erro 206
			//$mensagem = new \stdClass();
			//$mensagem->mensagem = "Usuário não encontrado.Verifique a matricula informada";
			//$return = $response->withJson($mensagem)
			//->withStatus(206);
			#caso não encontre o usuario o retorno será 204
			//$return->withStatus(204);
			//return $return;
		}	
	}
	
});
