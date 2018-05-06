<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require './vendor/autoload.php';
$app = new \Slim\App;


#metodo de teste 1
$app->get('/', function (Request $request, Response $response) use ($app) {
    $response->getBody()->write("Bebê de Microservice!");
    return $response;	
});

/*
#metodo de teste 2
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});
*/


#metodo para listar todos os usuarios
$app->get('/usuarios', function (Request $request, Response $response) {
 
    # Variável que irá ser o retorno (pacote JSON)...
   $retorno = array();
 
    # Abrir conexão com banco de dados
    $conexao = mysqli_connect("localhost","root","","papafilas_homolog");
 
    # Validar se houve conexão
    if(!$conexao){ echo "Não foi possível se conectar ao banco de dados"; exit;}
 
    # Selecionar todos os cadastros da tabela 'usuarios'
    $registros = mysqli_query($conexao,"select * from usuario");
 
    # Transformando resultset em array, caso ache registros
 if(mysqli_num_rows($registros)>0){
        while($usuario = mysqli_fetch_array($registros)) {
            $registro = array(
                        "ID_USUARIO"   		=> $usuario["id_usuario"],
						"MATRICULA"   		=> $usuario["matricula_usuario"],
                        "NOME_USUARIO"     	=> utf8_encode($usuario["nome_usuario"]),
                        "CPF" 				=> $usuario["cpf"],
                        "EMAIL"    			=> $usuario["email_usuario"],
						"ID_GRUPO"   		=> $usuario["id_grupo"],
						"ID_STATUS"			=> $usuario["id_status"],
                    );
            $retorno[] = $registro;
        }  
	}
 
    # Encerrar conexão
    mysqli_close($conexao);
	
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
		$pdo = new PDO("mysql:host=localhost;dbname=papafilas_homolog","root","");//P@p@filas2018bd
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
 
 	try{
		$pdo = new PDO("mysql:host=localhost;dbname=papafilas_homolog","root","");
	}catch(PDOException $e){
		#exibe a messagem de erro caso não consiga
		echo $e->getMessage();
	}
 
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
		try{
			$pdomw = new PDO("mysql:host=localhost;dbname=mw_homolog","root","");
		}catch(PDOException $e){
			#exibe a messagem de erro caso não consiga
			echo $e->getMessage();
		}
		
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
				$return = $response->withJson($registros)
				->withHeader('Content-type', 'application/json');
				#caso não encontre o usuario o retorno será 204
				$return = $response->withStatus(204);
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
		CURLOPT_POSTFIELDS => "email=moises.dandico23@gmail.com&token=93D0433C38974DD2B3001F53B30CEA45&currency=BRL&itemId1=0001&itemDescription1=Creditos RU&itemAmount1=$addCreditos->SALDO&itemQuantity1=1&referenceREF=REF1234&senderName=$addCreditos->NOME_USUARIO&senderEmail=$addCreditos->EMAIL&shippingAddressRequired=false",
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


/*
# (nao esta funcionando) 
### Metodo que recebe um codigo de notificação de mudanca de status do pagseguro, envia de volta
###	esse codigo para a api do pagseguro e recebe as informações da mudanca de status.
#passo 1 receber em uma url (tipo papafilasru/api/notificacoes) o codigo enviado pela api do pagseguro
#passo 2 salvar o valor da variável notificationCode, que é o codigo da notificacao
#passo 3 fazer uma requisicao (por meio de http.get??) à api do pagseguro com o notificationCode e receber a resposta em xml
#passo 4 com a resposta, chamar um metodo que insere historico e, por sua vez, atualiza o saldo
$app->get('/notificacoes', function (Request $request, Response $response,array $args) {
//

if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
    //se notificationType for true e = 'transactio',  continuamos
 
    $email = 'moises.dandico23@gmail.com';
    $token = '93D0433C38974DD2B3001F53B30CEA45';
 
    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
 
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction= curl_exec($curl);
    curl_close($curl);
 
    $transaction = simplexml_load_string($transaction);

    echo $transaction;
}
	echo "não funcionou o recebimento do id de transaction";
});



# (nao esta funcionando) metodo de teste: post na url /notificacoes pra testar o metodo acima.
# exemplo de notificação enviada pelo PagSeguro (as linhas foram quebradas para facilitar a leitura)

	#############################################################
	# POST http://lojamodelo.com.br/notificacao HTTP/1.1		#
	# Host:pagseguro.uol.com.br 								#
	# Content-Length:85											#
	# Content-Type:application/x-www-form-urlencoded			#
	# notificationCode=766B9C-AD4B044B04DA-77742F5FA653-E1AB24	#
	# notificationType=transaction	 							#
	#############################################################

$app->post('/notificacoes/teste', function (Request $request, Response $response, array $args) {
    $notificationCode = json_decode($request->getBody());
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "http://localhost/dashboard/papafilasRU/codigo/PapaFilasRu/api/notificacoes",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "notificationCode=766B9C-AD4B044B04DA-77742F5FA653-E1AB24",
		CURLOPT_HTTPHEADER => array("Content-Type:application/x-www-form-urlencoded"),
	));

	$resposta = curl_exec($curl);
	$erro = curl_error($curl);
	$tokenxml = simplexml_load_string($resposta);
	$addCreditos->URL_TOKEN	= 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code='.$tokenxml->code;

	curl_close($curl);

	if ($erro) {
		echo "cURL Error #:" . $erro;
	} else {
		$return = $response->withJson($addCreditos)
		->withHeader('Content-type', 'application/json');
		return $return;
	}
});
*/

//metodo /credito/insereHistorico
$app->post('/credito/insereHistorico', function (Request $request, Response $response,array $args) {

	
	//recebendo o json do post e salvando em array com posicao = parametro do json
	$json =  json_decode($request->getBody());	
	
	//pegando hora atual
	$hora_atual = date("Y-m-d H:i"); // tem que ver qual o formato certo ainda.

	//abrindo conexao com banco de dados
	try{
		$pdo = new PDO("mysql:host=localhost;dbname=papafilas_homolog","root","");
	}catch(PDOException $error){
		#exibe a messagem de erro caso não consiga
		echo $error->getMessage();
	}
 
	//faz a busca pelo id_usuario no bd
	$sql = "SELECT id_usuario FROM `usuario` WHERE matricula_usuario= :MATRICULA";
	
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

		
	$sql2="INSERT 	INTO historico_compra 	(codigo_status, data_compra, id_historico, id_usuario, saldo_inserido, valor_compra) 
					values 					(:CODIGO_STATUS, :DATA_COMPRA, NULL, :ID_USUARIO, :SALDO_INSERIDO, :VALOR_COMPRA) ";
		
	$codigo_status = 1;
	$saldo_inserido = 0;


	#prepara a insercao e executa no banco
	$stmt=$pdo->prepare($sql2);				
	$stmt->bindvalue(':CODIGO_STATUS', $codigo_status, PDO::PARAM_INT);
	$stmt->bindvalue(":DATA_COMPRA", $hora_atual, PDO::PARAM_STR_CHAR);
	$stmt->bindParam(":ID_USUARIO", $usuario->id_usuario);
	$stmt->bindvalue(":SALDO_INSERIDO", $saldo_inserido, PDO::PARAM_INT);
	$stmt->bindParam(":VALOR_COMPRA", $json->SALDO);
	$stmt->execute();	

	$usuario->id_historico = $pdo->lastInsertId();

	//id_historico//id_usuario//data_compra//valor_compra//saldo_inserido//codigo_status
	$resposta = array(	'id_historico' => $usuario->id_historico,
						'id_usuario' => $usuario->id_usuario,
						'data_compra' => $hora_atual,
						'valor_compra' => $json->SALDO,
						'saldo_inserido' => $saldo_inserido,
						'codigo_status' => $codigo_status,
						);

	$ret = $response->withJson($resposta)->withHeader('Content-type', 'application/json');
	return $ret;


});


// ^^^^^^^ nao apagar essa linha de jeito nenhum. e só codar daqui pra cima ^^^^^
$app->run(); 