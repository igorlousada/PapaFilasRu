<?php
require_once '../../cep/vendor/autoload.php';
use JansenFelipe\CepGratis\CepGratis;

define('UNEXPECTED_ERROR_OCCURRED', 6);
define('WAITING_FOR_PAYMENT_CONFIRMATION', 7);
define('PAYMENT_DECLINED_CONTACT_YOUR_BANK', 8);

session_start();

$errors = false;

if(isset($_POST)){
	$usuario = $_SESSION['usuario'];
	$precoCompra = $_SESSION['creditos'];
	$informacoesComprador = $_POST;
	$usuario['SALDO']=number_format($precoCompra, 2); //No JSON, o campo saldo recebe o saldo a ser inserido, que nas páginas de compra fica armazenado em créditos.
	// Dessa forma, é necessário substituir o saldo atual pela quantidade de créditos que deseja ser adquirida.
	$usuario['ID_HISTORICO']=$_SESSION['ID_HISTORICO']; // Registra o ID da transação como um atributo do usuário

if (isset($_POST['HASH_CARTAO']) && isset($_POST['HASH_USUARIO'])){
	print_r($_POST);
	$paymentOrder = processPayment($informacoesComprador, $usuario);
	isPaymentOk($paymentOrder);
	}
}
else{
	echo "ERRO! Post não setado";
	$_SESSION['ERROR']=UNEXPECTED_ERROR_OCCURRED;
	$errors = true;
	// echo "<META http-equiv=\"refresh\" content=\"0;URL=/PapaFilasRU/totem/erro.php\">";
}

function processPayment($buyersInformation, $userInformation){

$PurchaseInfo = array_merge($buyersInformation, $userInformation);

$encodedPurchaseInfo = json_encode($PurchaseInfo);

$requestPurchase =  stream_context_create(array(
        'http' => array(
        'method' => 'POST',
        'header' => "Content-Type: application/json; charset=utf-8 \r\n",
        'content' => $encodedPurchaseInfo
    )
));


$request = file_get_contents("http://35.199.101.182/api/creditos/pagamento", false, $requestPurchase);
$response = json_decode($request, true);
$responseCode = substr($http_response_header[0], 9, 3);

$response = array("body" => $response, "code" => $responseCode);
print_r($response);
return $response;
}

function isPaymentOk($paymentStatus){
	$http_code = $paymentStatus['code'];
	$paymentInformation = $paymentStatus['body'];
	if ($http_code!=200){
	  $_SESSION['ERROR']=$paymentInformation;
	  $errors = true;
		echo "ERRO! Código diferente de 200. O Código Obtido foi $http_code";
	  // echo "<META http-equiv=\"refresh\" content=\"1;URL=/PapaFilasRU/totem/erro.php\">";
	}
	else {
		if(isset($paymentInformation['STATUS_COMPRA'])){
				switch($paymentInformation['STATUS_COMPRA']){
						case 1:
							$_SESSION['ERROR']=WAITING_FOR_PAYMENT_CONFIRMATION;
							$errors = true;
							echo "ERRO! Esperando pela confirmação do pagamento";
			//				echo "<META http-equiv=\"refresh\" content=\"0;URL=/PapaFilasRU/totem/erro.php\">";
							break;
				 		case 2:
							echo "<META http-equiv=\"refresh\" content=\"0;URL=/PapaFilasRU/totem/sucesso.php\">";
							break;
						case 3:
					    echo "ERRO! Pagamento negado";
							$_SESSION['ERROR']=PAYMENT_DECLINED_CONTACT_YOUR_BANK;
							$errors = true;
					//		echo "<META http-equiv=\"refresh\" content=\"0;URL=/PapaFilasRU/totem/erro.php\">";
							break;
						default:
						  echo "ERRO! O Status_Compra foi diferente de 1, 2 ou 3!";
							$_SESSION['ERROR']=UNEXPECTED_ERROR_OCCURRED;
							$errors = true;
						//	echo "<META http-equiv=\"refresh\" content=\"0;URL=/PapaFilasRU/totem/erro.php\">";
						}
				}
		else{
				echo "Não há status_compra";
				$_SESSION['ERROR']=UNEXPECTED_ERROR_OCCURRED;
				$errors = true;
			//	echo "<META http-equiv=\"refresh\" content=\"0;URL=/PapaFilasRU/totem/erro.php\">";
		}
	}
}

if($errors == false) {
?>

<!DOCTYPE html>

<html>
	<head>
		<title>Confirmação</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jqbtk.css">
		<link rel="stylesheet" href="css/materialize.min.css" />
        <link rel="stylesheet" href="css/style.css" />
		<script	src="js/limitador.js" type="text/javascript"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
			<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
			<script type="text/javascript" src="resourcesps/pagSeguro.js"></script>
	</head>

	<script>
			window.onload=gerasessao();
	</script>

	<body class="container">
		<div class="row">
			<form action="/PapaFilasRU/totem/checkout.php" method="POST">
			<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

				<h2 style="color:#0d47a1">Informações do Cartão</h2>
                <br>
				<h4 style="color:#0d47a1">Nome do Titular do Cartão</h4>

				<p><input type="text" class="keyboard form-control" name="NOME_TITULAR" id="nome"></p>

                <h4 style="color:#0d47a1">Número do Cartão</h4>
				<input type="text" class="keyboard form-control keyboard-numpad" id="numCartao" maxlength="16" onfocus="limiteCartao()">

				<h4  style="color:#0d47a1">Data de Validade</h4>
				<div class="input-field col s3">
				<h5 style="color:#0d47a1">Mês (MM)</h5>
				<input type="tel" class="keyboard form-control keyboard-numpad" id="pagamentoMes"  maxlength = "2" onfocus="limiteCartao()">
                </div>

				<div class="input-field col s3">
				<h5 style="color:#0d47a1">Ano (AAAA)</h5>
				<input type="tel" class="keyboard form-control keyboard-numpad"  id="pagamentoAno" maxlength = "4" onfocus="limiteCartao()">
                </div>

				<div class="input-field col s3">
				<h5 style="color:#0d47a1">CVV</h5>
				<input type="password" class="keyboard form-control keyboard-numpad" id="cvv" onkeyup="hashcartao()" size="1">
				</div>

				</div>

				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<h4 style="color:#0d47a1">CPF do Titular do Cartão</h4>
				<input type="tel" name="CPF_TITULAR" class="keyboard form-control" id="cpf" onfocus="hashusuario()" size="10">

				</div>

				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<h4 style="color:#0d47a1">Telefone/Celular</h4>
				<div class="input-field col s2">
				<h5 style="color:#0d47a1">DDD</h5>
				<input type="tel" name="CODIGO_AREA" class="keyboard form-control" id="telephone">
				</div>
				<div class="input-field col s6">
				<h5 style="color:#0d47a1">Número</h5>
				<input type="tel" name="TELEFONE" class="keyboard form-control" id="numtel">
				</div>
                </div>
				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

				<h4 style="color:#0d47a1">CEP</h4>
				<input type="tel" name="CEP" class="keyboard form-control" id="cep" onfocusout="buscacep()" size="8">
				</div>

				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

				<div class="input-field col s5">
				<h4 style="color:#0d47a1">Endereço</h4>
				<input type="text" name="ENDERECO" id="endereco" placeholder="Endereço" class="keyboard form-control" readonly="readonly">
			  </div>

			<div class="input-field col s3">
			<h4 style="color:#0d47a1"> Bairro</h4>
			<input type="text" name="BAIRRO" id="bairro" placeholder="Bairro" class="keyboard form-control" readonly="readonly">
		  </div>

		  <div class="input-field col s3">
		  <h4 style="color:#0d47a1">Cidade</h4>
		  <input type="text" name="CIDADE" id="cidade" placeholder="Cidade" class="keyboard form-control" readonly="readonly">
   	  </div>

	  	<div class="input-field col s1">
			<h4 style="color:#0d47a1">UF</h4>
			<input type="text" name="UF" id="uf" placeholder="UF" class="keyboard form-control" readonly="readonly">
		 </div>
	   </div>

				<p><div class="col-sm-10 col-sm-offset-1 col-md-2 col-md-offset-2"></p>
				<h5 style="color:#0d47a1">Número</h5>
				<input type="tel" name="NUMERO_CASA" class="keyboard form-control" id="numend">

					<input type="hidden" name="HASH_CARTAO"  id="tokencartao" size="30">
					<input type="hidden" id="country" value="Brasil">
					<input type="hidden" name="HASH_USUARIO" id="hashPagSeguro" size="63">

				</div>
	</div>

				<br>
				 <div class="row">
                   <div class="col s12 m12 l12">
                 </div>
                 <a href="\PapaFilasRU\totem\sucesso.php">
                 <button type="submit" class="btn waves-effect blue darken-4" style="width:98%; height: 150px; font-size:40px">Enviar</button>
                  </a>
                </div>
                </div>


		</div>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="js/jqbtk.js"></script>
		<script>
			$(function(){
				$('#default').keyboard();
				$('#default1').keyboard();
				$('#number').keyboard();
				$('#telephone').keyboard();
				$('#pagamentoMes').keyboard({   //Teclado da Data de Validade
					layout: [
						[['1', '1'], ['2', '2'], ['3', '3']],
						[['4', '4'], ['5', '5'], ['6', '6']],
						[['7', '7'], ['8', '8'], ['9', '9']],
						[['0', '0'], ['', ''], ['del', 'del']]

					]

				});

				$('#cvv').keyboard({
					layout: [
						[['1', '1'], ['2', '2'], ['3', '3']],
						[['4', '4'], ['5', '5'], ['6', '6']],
						[['7', '7'], ['8', '8'], ['9', '9']],
						[['0', '0'], ['', ''], ['del', 'del']]

					]
				});

				$('#cpf').keyboard({
					layout: [
						[['1', '1'], ['2', '2'], ['3', '3']],
						[['4', '4'], ['5', '5'], ['6', '6']],
						[['7', '7'], ['8', '8'], ['9', '9']],
						[['0', '0'], ['', ''], ['del', 'del']]

					]
				});

				$('#pagamentoAno').keyboard({
					layout: [
						[['1', '1'], ['2', '2'], ['3', '3']],
						[['4', '4'], ['5', '5'], ['6', '6']],
						[['7', '7'], ['8', '8'], ['9', '9']],
						[['0', '0'], ['', ''], ['del', 'del']]

					]
				});

				$('#cep').keyboard({
					layout: [
						[['1', '1'], ['2', '2'], ['3', '3']],
						[['4', '4'], ['5', '5'], ['6', '6']],
						[['7', '7'], ['8', '8'], ['9', '9']],
						[['0', '0'], ['', ''], ['del', 'del']]

					]
				});

				$('#nome').keyboard({
					layout: [
						[['Q', 'Q'], ['W', 'W'], ['E', 'E'],['R', 'R'], ['T', 'T'], ['Y', 'Y'], ['U', 'U'], ['I', 'I'], ['O', 'O'], ['P', 'P']],
						[['A', 'A'], ['S', 'S'], ['D', 'D'],['F', 'F'], ['G', 'G'], ['H', 'H'], ['J', 'J'], ['K', 'K'], ['L', 'L'], ['Ç', 'Ç']],
						[['Z', 'Z'], ['X', 'X'], ['C', 'C'],['V', 'V'], ['B', 'B'], ['N', 'N'], ['M', 'M'], ['.', '.']]

					]
				});

				$('#numtel').keyboard({
					layout: [
						[['1', '1'], ['2', '2'], ['3', '3']],
						[['4', '4'], ['5', '5'], ['6', '6']],
						[['7', '7'], ['8', '8'], ['9', '9']],
						[['0', '0'], ['', ''], ['del', 'del']]

					]
				});

				$('#numCartao').keyboard({
					layout: [
						[['1', '1'], ['2', '2'], ['3', '3']],
						[['4', '4'], ['5', '5'], ['6', '6']],
						[['7', '7'], ['8', '8'], ['9', '9']],
						[['0', '0'], ['', ''], ['del', 'del']]

					]
				});

				$('#numend').keyboard({
					layout: [
						[['1', '1'], ['2', '2'], ['3', '3']],
						[['4', '4'], ['5', '5'], ['6', '6']],
						[['7', '7'], ['8', '8'], ['9', '9']],
						[['0', '0'], ['', ''], ['del', 'del']]

					]

				});

				$('#inline').keyboard();
				$('#password').keyboard();
				$('#initcaps').keyboard({initCaps: true});
				$('#addInputBtn').click(function() {
					$(this).parent().append($('<input>').attr('type', 'text').addClass('form-control').addClass('keyboard'));
					$(this).siblings('.keyboard').keyboard();
				});
				$('#removeInputBtn').click(function() {
					$(this).siblings('.keyboard').last().remove();
				});
				$('#placement').keyboard({placement: 'top'});
				$('#customWithEnter').keyboard({
					layout: [
						[['d', 'D'], ['b', 'B'], ['c', 'C'], ['del', 'del']],
						[['shift', 'shift'], ['space', 'space'], ['enter', 'enter']]
					]
				});
			});



		</script>





	</body>
</html>
<?php
}
?>
