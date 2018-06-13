<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require './vendor/autoload.php';
$app = new \Slim\App;

#arquivo com funcao db_connect() que retorna uma conexao dbo com o BD
require 'conectadb.php';

//require '../cep/vendor/autoload.php';
//use JansenFelipe\CepGratis\CepGratis;


#metodo de teste 1
$app->get('/', function (Request $request, Response $response) use ($app) {
    $response->getBody()->write("Bebê de Microservice!");
    return $response;	
});


#metodo de teste 2
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});


#metodo para listar todos os usuarios
$app->get('/usuarios', function (Request $request, Response $response) {
 
    # Variável que irá ser o retorno (pacote JSON)...
   $retorno = array();
   
	$pdo = db_connect();
	$sql = "SELECT * FROM usuario";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	if($stmt->rowCount()>0){		
		while($resultado = $stmt->fetch(PDO::FETCH_ASSOC)){
		    $registro = array(
                        "ID_USUARIO"   		=> $resultado["id_usuario"],
						"MATRICULA"   		=> $resultado["matricula_usuario"],
                        "NOME_USUARIO"     	=> utf8_encode($resultado["nome_usuario"]),
                        "CPF" 				=> $resultado["cpf"],
                        "EMAIL"    			=> $resultado["email_usuario"],
						"ID_GRUPO"   		=> $resultado["id_grupo"],
						"ID_STATUS"			=> $resultado["id_status"],
                    );					
			$retorno[] = $registro;
		}
	}
	#exibindo resultados
	$return = $response->withJson($retorno);
	return $return;
});


#metodo retorna usuario e saldo
$app->get('/usuarios/{matricula}', function (Request $request, Response $response,array $args) {
	$matricula = $args['matricula'];
	$pdo = db_connect();
 
	$sql="SELECT usu.*, round(cart.saldo,2) as saldo FROM usuario as usu inner join carteira_usuario as cart ON usu.id_usuario= cart.id_usuario where matricula_usuario= :matricula";
	$stmt=$pdo->prepare($sql);
	$stmt->bindParam(":matricula", $matricula);
	$stmt->execute();


	if($stmt->rowCount()>0){
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
		            $registro = array(
                        "ID_USUARIO"   		=> $resultado["id_usuario"],
						"MATRICULA"   		=> $resultado["matricula_usuario"],
                        "NOME_USUARIO"     	=> utf8_encode($resultado["nome_usuario"]),
                        "CPF" 				=> $resultado["cpf"],
                        "EMAIL"    			=> $resultado["email_usuario"],
						"ID_GRUPO"   		=> $resultado["id_grupo"],
						"ID_STATUS"			=> $resultado["id_status"],
						"SALDO"				=> $resultado["saldo"],
                    );
		
		$return = $response->withJson($registro)->withHeader('Content-type', 'application/json');

		return $return;
		
	#se o usuario não for localizado no sistema PAPAFILAS procura no MW
	}else{
		//função do arquivo conectadb.php para abrir conexão pdo com o banco de dados do MW
		$pdomw = db_connectMW();
		
		$sql2="SELECT matricula,nome,cpf,email,id_status,id_grupo FROM mw_aluno where matricula= :matricula";
		$stmtmw=$pdomw->prepare($sql2);
		$stmtmw->bindParam(":matricula", $matricula);
		$stmtmw->execute();
		#SE LOCALIZAR NO MW CADASTRA NO PAPAFILAS
		if($stmtmw->rowCount()>0){
			$resultado = $stmtmw->fetch(PDO::FETCH_OBJ);
			$stmt->closeCursor();
			$sql3="INSERT INTO usuario (matricula_usuario,nome_usuario,cpf,email_usuario,id_grupo,id_status) 
				values (:MATRICULA,:NOME_USUARIO,:CPF,:EMAIL,:ID_GRUPO,:ID_STATUS) ";
				
			#prepara a insercao e executa no banco
			$stmt=$pdo->prepare($sql3);				
			$stmt->bindParam(":MATRICULA", $resultado->matricula);
			$stmt->bindParam(":NOME_USUARIO", $resultado->nome);
			$stmt->bindParam(":CPF", $resultado->cpf);
			$stmt->bindParam(":EMAIL", $resultado->email);
			$stmt->bindParam(":ID_GRUPO", $resultado->id_grupo);
			$stmt->bindParam(":ID_STATUS", $resultado->id_status);					
			$stmt->execute();
						
			
			$resultado->id_usuario = $pdo->lastInsertId();
			#retorna um saldo inicial 0.00 quando o usuario está sendo cadastrado no sistema
			$saldoinicial='0.00';
			$registro = array(
					"ID_USUARIO"   		=> $resultado->id_usuario,
					"MATRICULA"   		=> $resultado->matricula,
					"NOME_USUARIO"     	=> utf8_encode($resultado->nome),
					"CPF" 				=> $resultado->cpf,
					"EMAIL"    			=> $resultado->email,
					"ID_GRUPO"   		=> $resultado->id_grupo,
					"ID_STATUS"			=> $resultado->id_status,
					"SALDO"				=> $saldoinicial,
			);
			$return = $response->withJson($registro)->withHeader('Content-type', 'application/json');
			return $return;
			
		#SE NÃO ENCONTRAR NO MW RETORNA STATUS 206
		}else{
			$mensagem = new \stdClass();
			$mensagem->mensagem = "Usuário não encontrado.Verifique a matricula informada";
			$return = $response->withJson($mensagem)
			->withStatus(206);
			#caso não encontre o usuario o retorno será 204
			//$return->withStatus(204);
			return $return;
		}	
	}
	
});


#método para solicitar token pagseguro
$app->post('/creditos/', function (Request $request, Response $response, array $args) {
    $addCreditos = json_decode($request->getBody());
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "email=moises.dandico23@gmail.com&token=93D0433C38974DD2B3001F53B30CEA45&currency=BRL&itemId1=0001&itemDescription1=Creditos RU&itemAmount1=$addCreditos->SALDO&itemQuantity1=1&reference=$addCreditos->ID_HISTORICO&senderName=$addCreditos->NOME_USUARIO&senderEmail=$addCreditos->EMAIL&shippingAddressRequired=false",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded; charset=ISO-8859-1"
		),
	));

	$resposta = curl_exec($curl);
	$err = curl_error($curl);
	$tokenxml = simplexml_load_string($resposta);
	$addCreditos->URL_TOKEN	= 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code='.$tokenxml->code;



	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$return = $response->withJson($addCreditos)
		->withHeader('Content-type', 'application/json');
		return $return;
	}
});


#método para inserir historico de compra para o usuário
$app->post('/creditos/insereHistorico', function (Request $request, Response $response) {
	
	//recebendo o json do post e salvando em array com posicao = parametro do json
	$json =  json_decode($request->getBody());	
	
	//pegando hora atual
	$hora_atual = date("Y-m-d H:i:s");
	//abrindo conexao com banco de dados

	$pdo = db_connect();
 
	//faz a busca pelo id_usuario no bd
	$sql = "SELECT id_usuario, matricula_usuario FROM `usuario` WHERE matricula_usuario= :MATRICULA";
	
	//prepara o comando sql acima
	$stmt=$pdo->prepare($sql);
	//passa o parametro da matricula pra busca do pdo
	$stmt->bindParam(":MATRICULA", $json->MATRICULA);
	$stmt->execute();
	$usuario = $stmt->fetch(PDO::FETCH_OBJ);
	
	//se o usuario nao existir no bd, retornara null e entrará no if de erro.
	$existe = $usuario->id_usuario;
	if (($existe==NULL)){
		$mensagem = new \stdClass();
		$mensagem->mensagem = "Usuário não encontrado.Verifique a matricula informada";
		$return = $response->withJson($mensagem)
		->withStatus(206);
		return $return;
	}
	//fecha o cursor do pdo
	$stmt->closecursor();
		
	$sql2="INSERT 	INTO historico_compra 	(codigo_status, data_compra, id_historico, id_usuario, matricula_usuario, saldo_inserido, valor_compra) 
					values 					(:CODIGO_STATUS, :DATA_COMPRA, NULL, :ID_USUARIO,:MATRICULA_USUARIO, :SALDO_INSERIDO, :VALOR_COMPRA) ";
		
	$codigo_status = 1;
	$saldo_inserido = 0;
	#prepara a insercao e executa no banco
	$stmt=$pdo->prepare($sql2);				
	$stmt->bindvalue(':CODIGO_STATUS', $codigo_status, PDO::PARAM_INT);
	$stmt->bindvalue(":DATA_COMPRA", $hora_atual);
	$stmt->bindParam(":ID_USUARIO", $usuario->id_usuario);
	$stmt->bindParam(":MATRICULA_USUARIO", $usuario->matricula_usuario);
	$stmt->bindvalue(":SALDO_INSERIDO", $saldo_inserido, PDO::PARAM_INT);
	$stmt->bindParam(":VALOR_COMPRA", $json->SALDO);
	$stmt->execute();	

	$json->ID_HISTORICO = $pdo->lastInsertId();

	$ret = $response->withJson($json)->withHeader('Content-type', 'application/json');
	return $ret;
});


#metodo método para atualizar o saldo do usuário a partir da página de retorno da compra
$app->put('/creditos/atualizasaldo', function (Request $request, Response $response,array $args) { // LINHA ALTEARADA 14/05/2018  AS 5H33
	$objeto_put = json_decode($request->getBody());

	//$id_transacao = "50188C5FB4B8432CA13AB9D6863EB5A0"; 

	#busca informações da transação no pagseguro
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/'.$objeto_put->ID_TRANSACAO.'?email=moises.dandico23@gmail.com&token=93D0433C38974DD2B3001F53B30CEA45',  // alterado para versão 2 as 5h47
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_POSTFIELDS => "",
		CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded; charset=ISO-8859-1"),
	));
	$resposta = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	#trata a resposta recebida do pagseguro
	$resposta = simplexml_load_string($resposta);
	$status = $resposta->status;
	$ID_HISTORICO= $resposta->reference;


	#busca as informações da transação no banco de dados do papafilas
	$pdo = db_connect();
	$sql = "SELECT * FROM `historico_compra` WHERE id_historico= :HISTORICO";
	$stmt=$pdo->prepare($sql);	
	$stmt->bindParam(":HISTORICO", $ID_HISTORICO);
	$stmt->execute();
	$usuario= $stmt->fetch(PDO::FETCH_OBJ);
	
	
	#Se a transação está com status pago e o saldo ainda não foi inserido
	if(($status == 3 || $status == 4)  && $usuario->saldo_inserido == 0){
		
		#libera a conexão pdo para nova utilização
		$stmt->closecursor();
		
		$sql2="UPDATE carteira_usuario SET  saldo=saldo+'$resposta->grossAmount' WHERE id_usuario= :USUARIO;
			UPDATE historico_compra SET  saldo_inserido=1,codigo_status='$status' WHERE id_historico= :HISTORICO";

		$stmt=$pdo->prepare($sql2);
		$stmt->bindParam(":USUARIO", $usuario->id_usuario);
		$stmt->bindParam(":HISTORICO", $ID_HISTORICO);
		$stmt->execute();
	}
	
	if(($status == 3 || $status == 4) && $usuario->saldo_inserido == 1){
				$mensagem = new \stdClass();
				$mensagem->mensagem = "Os créditos dessa compra já foram inseridos em sua conta.";
				$return = $response->withJson($mensagem)
				->withStatus(206);
				echo "$usuario->saldo_inserido";
				return $return;
	}
	if($status == 1 || $status == 2){
				$mensagem = new \stdClass();
				$mensagem->mensagem = "Sua compra está sendo processada. Assim que aprovada seus créditos serão inseridos";
				$return = $response->withJson($mensagem)
				->withStatus(206);
				return $return;
	}
	if($status == 7){
				$mensagem = new \stdClass();
				$mensagem->mensagem = "Desculpe mas seu pagamento não foi aprovado pela operadora. Tente novamente ou verifique os dados inseridos";
				$return = $response->withJson($mensagem)
				->withStatus(206);
				return $return;
	}
    
});


#metodo retorna historico de compras de um usuario
$app->get('/historico/{matricula}', function (Request $request, Response $response,array $args) {
	$matricula = $args['matricula'];

	$pdo = db_connect();
 
	$sql = "SELECT * FROM `historico_compra` WHERE matricula_usuario= :matricula";
	$stmt=$pdo->prepare($sql);
	$stmt->bindParam(":matricula", $matricula);
	$stmt->execute();
	


	if($stmt->rowCount()>0){
		while($resultado = $stmt->fetch(PDO::FETCH_ASSOC)){
		            $registro = array(
                        "CODIGO_STATUS"   	=> $resultado["codigo_status"],
						"DATA_COMPRA"  		=> $resultado["data_compra"],
                        "ID_HISTORICO"     	=> $resultado["id_historico"],
                        "ID_USUARIO" 		=> $resultado["id_usuario"],
                        "MATRICULA_USUARIO" => $resultado["matricula_usuario"],
						"SALDO_INSERIDO"   	=> $resultado["saldo_inserido"],
						"VALOR_COMPRA"		=> $resultado["valor_compra"],
                    );
                    $vetor_registros[] = $registro; 
		 }
		
	$return = $response->withJson($vetor_registros)->withHeader('Content-type', 'application/json');
	return $return;
	
	}else{
		$mensagem = new \stdClass();
		$mensagem->mensagem = "Usuário não encontrado. Verifique a matricula informada";
		$return = $response->withJson($mensagem)
		->withStatus(206);
		return $return;
	}
	
});

 
 #método para gerar codigo de inicio de sessão Pagseguro Transparente
$app->post('/creditos/iniciaSessao', function (Request $request, Response $response, array $args) {
	
		$data['token'] ='93D0433C38974DD2B3001F53B30CEA45'; //token teste SANDBOX

				//$_SERVER['REMOTE_ADDR']
		$emailPagseguro = "moises.dandico23@gmail.com";

		$data = http_build_query($data);
		$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions';

		$curl = curl_init();

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
			);

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		//curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = curl_exec($curl);

		curl_close($curl);

		$xml= simplexml_load_string($xml);
		$idSessao = $xml -> id;
		echo $idSessao;
		exit;
		//return $codigoRedirecionamento;

});

$app->post('/creditos/buscacep', function (Request $request, Response $response, array $args) {
	parse_str($request->getBody());

    $dados = CepGratis::search($CEP);
	$return = $response->withJson($dados)->withHeader('Content-type', 'application/json');
    return $return;

});  

$app->post('/creditos/pagamento', function (Request $request, Response $response) {
	$dados = json_decode($request->getBody());
 	
	$data['token'] ='93D0433C38974DD2B3001F53B30CEA45'; //token sandbox ou produção
	$data['receiverEmail'] = 'moises.dandico23@gmail.com'; //email do vendedor
	$data['paymentMode'] = 'default';
	
	$data['senderHash'] = $dados->HASH_USUARIO; //hash do usuario
	$data['creditCardToken'] = $dados->HASH_CARTAO; //hash do cartao
	$data['paymentMethod'] = 'creditCard';

	$data['senderName'] = $dados->NOME_USUARIO; // ALTERARnome do usuário deve conter nome e sobrenome
	$data['senderAreaCode'] = $dados->CODIGO_AREA; //ddd do comprador
	$data['senderPhone'] = $dados->TELEFONE;		//telefone do comprador
	$data['senderEmail'] = $dados->EMAIL;		//ALTERARemail do comprador
	$data['senderCPF'] = $dados->CPF;			//ALTERAR
	
	$data['installmentQuantity'] = '1'; //Quantidade de parcelas
	$data['installmentValue'] = $dados->SALDO; //ALTERAR
	$data['creditCardHolderName'] = $dados->NOME_TITULAR; //nome do titular do cartao
	$data['creditCardHolderCPF'] = $dados->CPF_TITULAR;	//cpf titular do cartao
	$data['creditCardHolderAreaCode'] = $dados->CODIGO_AREA;	//ddd titular do cartao
	$data['creditCardHolderPhone'] = $dados->TELEFONE;		//telefone titular do cartao
	$data['billingAddressStreet'] = $dados->ENDERECO;			//endereco titular do cartao
	$data['billingAddressNumber'] = $dados->NUMERO_CASA;			// numero end titular do cartao
	$data['billingAddressDistrict'] = $dados->BAIRRO;
	$data['billingAddressPostalCode'] = $dados->CEP;
	$data['billingAddressCity'] = $dados->CIDADE;
	$data['billingAddressState'] = $dados->UF;
	$data['billingAddressCountry'] = 'Brasil';

	$data['currency'] = 'BRL';
	$data['itemId1'] = '01';
	$data['itemQuantity1'] = '1';
	$data['itemDescription1'] = 'Creditos RU';
	$data['reference'] = $dados->ID_HISTORICO; //ALTERAR
	$data['shippingAddressRequired'] = 'false';
	$data['itemAmount1'] = $dados->SALDO; //ALTERAR valor total da compra

			//$_SERVER['REMOTE_ADDR']
	$emailPagseguro = "moises.dandico23@gmail.com";

	$data = http_build_query($data);
	$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions'; //URL de teste


	$curl = curl_init();

	$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
		);

	curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	//curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$xml = curl_exec($curl);

	curl_close($curl);

	$xml= simplexml_load_string($xml);
	$status = $xml->status;
	$ID_HISTORICO= $xml->reference;


	if($status == '1' || $status == '2'){
		$dados->STATUS_COMPRA='1';
		$return = json_encode($dados);	
		return $return;
	}
	if($status == '3' || $status == '4'){
		$dados->STATUS_COMPRA='2';
		$return = json_encode($dados);	
		return $return;
	}

	if($status == '7'){
		$dados->STATUS_COMPRA='3';
		$return = json_encode($dados);	
		return $return;
	}

}); 

$app->post('/creditos/teste', function (Request $request, Response $response, array $args) {
	parse_str($request->getBody());
	
    echo $hashPagSeguro;
	echo $endereco;

});


#metodo retorna cardapio do dia
$app->get('/cardapio/{anomesdia}', function (Request $request, Response $response,array $args) {
  $anomesdia = $args['anomesdia'];
  $pdo = db_connect();
 
  $sql1=" SELECT * FROM `cardapio_desjejum`   WHERE data_refeicao = '$anomesdia'";
  $sql2=" SELECT * FROM `cardapio_almoco`   WHERE data_refeicao = '$anomesdia'";
  $sql3=" SELECT * FROM `cardapio_jantar`   WHERE data_refeicao = '$anomesdia'";

  //statment 1: desjejum
  $stmt1=$pdo->prepare($sql1);
  $stmt1->execute();
  $stmt2=$pdo->prepare($sql2);
  $stmt2->execute();
  $stmt3=$pdo->prepare($sql3);
  $stmt3->execute();


  if(($stmt1->rowCount()>0)AND($stmt2->rowCount()>0)AND($stmt3->rowCount()>0)){
    $desjejum   = $stmt1->fetch(PDO::FETCH_ASSOC);
    $almoco   = $stmt2->fetch(PDO::FETCH_ASSOC);
    $jantar   = $stmt3->fetch(PDO::FETCH_ASSOC);
    
    $cardapio = array (
       "ID_REFEICAO_1" 		=> 			   $desjejum["id_refeicao"],
       "DATA_REFEICAO_1" 	=> 			   $desjejum["data_refeicao"],
       "BEBIDAS_Q_1" 		=> utf8_encode($desjejum["bebidas_q"]),
       "BEBIDAS_Q_VEG_1" 	=> utf8_encode($desjejum["bebidas_q_veg"]),
       "ACHOCOLATADO_1"		=> utf8_encode($desjejum["achocolatado"]),
       "PAO_1" 				=> utf8_encode($desjejum["pao"]),
       "PAO_VEG_1" 			=> utf8_encode($desjejum["pao_veg"]),
       "COMPLEMENTO_1" 		=> utf8_encode($desjejum["complemento"]),
       "COMPLEMENTO_VEG_1" 	=> utf8_encode($desjejum["complemento_veg"]),
       "PROTEINA_1"			=> utf8_encode($desjejum["proteina"]),
       "PROTEINA_VEG_1" 	=> utf8_encode($desjejum["proteina_veg"]),
       "FRUTA_1" 			=> utf8_encode($desjejum["fruta"]),

       "ID_REFEICAO_2" 		=> 			   $almoco["id_refeicao"],
       "DATA_REFEICAO_2" 	=> 			   $almoco["data_refeicao"],
       "SALADA_2" 			=> utf8_encode($almoco["salada"]),
       "MOLHO_2" 			=> utf8_encode($almoco["molho"]),
       "PRATO_PRINCIPAL_2" 	=> utf8_encode($almoco["prato_principal"]),
       "GUARNICAO_2"		=> utf8_encode($almoco["guarnicao"]),
       "PRATO_VEG_2"		=> utf8_encode($almoco["prato_veg"]),
       "ACOMPANHAMENTOS_2"	=> utf8_encode($almoco["acompanhamentos"]),
       "SOBREMESA_2" 		=> utf8_encode($almoco["sobremesa"]),
       "REFRESCO_2" 		=> utf8_encode($almoco["refresco"]),

       "ID_REFEICAO_3" 		=> 			   $jantar["id_refeicao"],
       "DATA_REFEICAO_3" 	=> 			   $jantar["data_refeicao"],
       "SALADA_3" 			=> utf8_encode($jantar["salada"]),
       "MOLHO_3" 			=> utf8_encode($jantar["molho"]),
       "SOPA_3" 			=> utf8_encode($jantar["sopa"]),
       "PAO_3" 				=> utf8_encode($jantar["pao"]),
       "PRATO_PRINCIPAL_3" 	=> utf8_encode($jantar["prato_principal"]),
       "PRATO_VEG_3"		=> utf8_encode($jantar["prato_veg"]),
       "COMPLEMENTOS_3" 	=> utf8_encode($jantar["complementos"]),
       "SOBREMESA_3" 		=> utf8_encode($jantar["sobremesa"]),
       "REFRESCO_3" 		=> utf8_encode($jantar["refresco"]),
       );
     
    $resultado = $response->withJson($cardapio)->withHeader('Content-type', 'application/json');
	return $resultado;
  
  }else{ 
    $mensagem = new \stdClass();
    $mensagem->mensagem = "Cardápio não encontrado";
    $return = $response->withJson($mensagem)
    ->withStatus(206);
    return $return;
    }
});


#metodo retorna preço da refeicao
$app->get('/preco/{matricula}', function (Request $request, Response $response,array $args) {
  $matricula = $args['matricula'];
  $pdo = db_connect();
 
  $sql= "SELECT id_grupo FROM `usuario` WHERE matricula_usuario = '$matricula'";

  $stmt=$pdo->prepare($sql);
  $stmt->execute();
  
  if($stmt->rowCount()>0){
    $id_grupo   = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_grupo = $id_grupo['id_grupo'];
    if ($id_grupo == 1){
    	$preco_cafe 	= 0;
    	$preco_almoco 	= 0;
    	$preco_jantar 	= 0; 
    }
    elseif ($id_grupo == 2){
    	$preco_cafe 	= 1;
    	$preco_almoco	= 1;
    	$preco_jantar 	= 1;
    }
    elseif ($id_grupo == 3){
		$preco_cafe 	= 2.50;
    	$preco_almoco 	= 2.50;
    	$preco_jantar 	= 2.50;    	
    }
    elseif ($id_grupo == 4){
    	$preco_cafe 	= 7;
    	$preco_almoco 	= 13;
    	$preco_jantar 	= 13;
    }


    //grupo 1 nao paga
    //grupo 2 paga 1 real em todas as refeicoes
    //grupo 3 paga 2,50 em todas as refeicoes
    //grupo 4 paga 7 no cafe, 13 no almoco e jantar
    
    $preco = array ("preco_desjejum" => $preco_cafe,
    				"preco_almoco" => $preco_almoco,
    				"preco_jantar" => $preco_jantar);
     
    $resultado = $response->withJson($preco)->withHeader('Content-type', 'application/json');
	return $resultado;
  
  }else{ 
    $mensagem = new \stdClass();
    $mensagem->mensagem = "Precos nao encontrados";
    $return = $response->withJson($mensagem)
    ->withStatus(206);
    return $return;
    }
});

#metodo insere cardapio de desjejum
$app->post('/cardapio/inserirdesjejum/', function (Request $request, Response $response, array $args) {
    
    $desjejum = json_decode($request->getBody());
    
    $pdo = db_connect();
	$sql = "INSERT INTO `cardapio_desjejum` (`data_refeicao`, `bebidas_q`, `bebidas_q_veg`, `achocolatado`, `pao`, `pao_veg`, `complemento`, `complemento_veg`, `proteina`, `proteina_veg`, `fruta`) VALUES ('$desjejum->DATA_REFEICAO', '$desjejum->BEBIDAS_Q', '$desjejum->BEBIDAS_Q_VEG', '$desjejum->ACHOCOLATADO', '$desjejum->PAO', '$desjejum->PAO_VEG', '$desjejum->COMPLEMENTO', '$desjejum->COMPLEMENTO_VEG', '$desjejum->PROTEINA', '$desjejum->PROTEINA_VEG', '$desjejum->FRUTA')";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

});

#metodo insere cardapio de almoco
$app->post('/cardapio/inseriralmoco/', function (Request $request, Response $response, array $args) {
    
    $almoco = json_decode($request->getBody());
    
    $pdo = db_connect();
	$sql = "INSERT INTO `cardapio_almoco`(`data_refeicao`, `salada`, `molho`, `prato_principal`, `guarnicao`, `prato_veg`, `acompanhamentos`, `sobremesa`, `refresco`) 
			VALUES ('$almoco->DATA_REFEICAO', '$almoco->SALADA', '$almoco->MOLHO', '$almoco->PRATO_PRINCIPAL', '$almoco->GUARNICAO', '$almoco->PRATO_VEG', '$almoco->ACOMPANHAMENTOS', '$almoco->SOBREMESA', '$almoco->REFRESCO')";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	
});

#metodo insere cardapio de janta
$app->post('/cardapio/inserirjantar/', function (Request $request, Response $response, array $args) {
    
    $jantar = json_decode($request->getBody());
    
    $pdo = db_connect();
	$sql = "INSERT INTO `cardapio_jantar`(`data_refeicao`, `salada`, `molho`, `sopa`, `pao`, `prato_principal`, `prato_veg`, `complementos`, `sobremesa`, `refresco`) 
			VALUES ('$jantar->DATA_REFEICAO', '$jantar->SALADA', '$jantar->MOLHO', '$jantar->SOPA', '$jantar->PAO', '$jantar->PRATO_PRINCIPAL', '$jantar->PRATO_VEG', '$jantar->COMPLEMENTOS', '$jantar->SOBREMESA', '$jantar->REFRESCO')";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	
});


$app->get('/filas/status', function (Request $request, Response $response,array $args) {
	
	
	$dados = array( 'ocupacao_1' 		=> rand(0,200),
					'tempo_de_fila_1'	=> rand(0,200),
					'ocupacao_2'		=> rand(0,200),
					'tempo_de_fila_2'	=> rand(0,200),
					'ocupacao_3'		=> rand(0,200),
					'tempo_de_fila_3'	=> rand(0,200),
					'ocupacao_4'		=> rand(0,200),
					'tempo_de_fila_4'	=> rand(0,200),
					'ocupacao_5'		=> rand(0,200),
					'tempo_de_fila_5'	=> rand(0,200),
					'ocupacao_6'		=> rand(0,200),
					'tempo_de_fila_6'	=> rand(0,200));


	$return = $response->withJson($dados);
	return $return;
});

// ^^^^^^^ nao apagar essa linha de jeito nenhum. e só codar daqui pra cima ^^^^^
$app->run();
