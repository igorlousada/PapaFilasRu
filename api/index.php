<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require './vendor/autoload.php';
$app = new \Slim\App;

#arquivo com funcao db_connect() que retorna uma conexao dbo com o BD
require 'conectadb.php';



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

#método para inserir usuario por metodo post ====MÉTODO NÃO ESTÁ SENDO UTILIZADO====
#=======MANTIDO NO ARQUIVO COMO MEIO DE REFERENCIA==================================
$app->post('/usuarios', function (Request $request, Response $response) use ($app) {
	$criaUsuario = json_decode($request->getBody());


	#tenta faze a conexao via PDO
	try{
		$pdo = new PDO("mysql:host=localhost;dbname=papafilas_homolog","root","P@p@filas2018bd");
	}catch(PDOException $e){
		#exibe a messagem de erro caso não consiga
		echo $e->getMessage();
	}
		#cria a variavel sql com o comando sql.
	$sql = "INSERT INTO usuario (matricula_usuario,nome_usuario,cpf,email_usuario,id_grupo,id_status) 
	values (:MATRICULA,:NOME_USUARIO,:CPF,:EMAIL,:ID_GRUPO,:ID_STATUS) ";
	
		#prepara o comando sql
	$stmt = $pdo->prepare($sql);
	
		#atribui os valores de forma segura
	$stmt->bindParam(":MATRICULA", $criaUsuario->MATRICULA);
	$stmt->bindParam(":NOME_USUARIO", $criaUsuario->NOME_USUARIO);
	$stmt->bindParam(":CPF", $criaUsuario->CPF);
	$stmt->bindParam(":EMAIL", $criaUsuario->EMAIL);
	$stmt->bindParam(":ID_GRUPO", $criaUsuario->ID_GRUPO);
	$stmt->bindParam(":ID_STATUS", $criaUsuario->ID_STATUS);
	
	#executa o comando e adiciona o usuario ao banco de dados
	$stmt->execute();
	
	#busca o id do usuario inserido
	$criaUsuario->id_usuario = $pdo->lastInsertId();
	#retorna os dados do usuario em formato JSON
	echo json_encode($criaUsuario);
	
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
				
			#SE NÃO ENCONTRAR NO MW RETORNA STATUS 204
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
		$return = $response->withStatus(204);
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
	
		#se o usuario não for localizado no sistema PAPAFILAS, retorna erro 204
	}else{
		$mensagem = new \stdClass();
		$mensagem->mensagem = "Usuário não encontrado. Verifique a matricula informada";
		$return = $response->withJson($mensagem)
		->withStatus(206);
		return $return;
	}
	
});

$app->post('/creditos/notificacaops', function (Request $request, Response $response) {
	parse_str($request->getBody());

		#busca informações da transação no pagseguro
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/'.$notificationCode.'?email=moises.dandico23@gmail.com&token=93D0433C38974DD2B3001F53B30CEA45',  // alterado para versão 2 as 5h47
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


// ^^^^^^^ nao apagar essa linha de jeito nenhum. e só codar daqui pra cima ^^^^^
$app->run();