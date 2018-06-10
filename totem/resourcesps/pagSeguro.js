//SE NÃO GERAR O ID DA SESSÃO E SETAR ESSE ID NO setSessionId NADA VAI FUNCIONAR
//DEVE-SE GERAR A IDENTIFICAÇÃO DO USUÁRIO TAMBÉM
//SE FOR CARTÃO DE CRÉDITO DEVE-SE GERAR O TOKEN DO CARTÃO

function buscacep(){
	 cepusuario = document.getElementById("cep").value;
        $.ajax({
            url :'../../api/creditos/buscacep',
            type : 'post',
			data : "CEP="+cepusuario,
            dataType : 'json',
            async : false,
            timeout: 20000,
            success: function(data){
				document.getElementById("cep").value = data.zipcode;
				document.getElementById("endereco").value = data.street;
				document.getElementById("bairro").value = data.neighborhood;
				document.getElementById("cidade").value = data.city;
				document.getElementById("uf").value = data.state;
            }
        });
}

function gerasessao(){
        $.ajax({
            url :'../../api/creditos/iniciaSessao',
            type : 'post',
            dataTyp : 'json',
            async : false,
            timeout: 20000,
            success: function(data){
                $(".retornoTeste").html(data);
                PagSeguroDirectPayment.setSessionId(data);			
            }
        });
}


function hashusuario(){
    identificador = PagSeguroDirectPayment.getSenderHash();
	document.getElementById("hashPagSeguro").value =identificador;
    $(".hashPagSeguro").val(identificador);
	
}

function hashcartao(){
	numCartao = document.getElementById("numCartao").value;
	cvvCartao = document.getElementById("cvv").value;
    expiracaoMes = document.getElementById("pagamentoMes").value;
    expiracaoAno = document.getElementById("pagamentoAno").value;
	bandeiraLista = document.getElementsByName("brand");	
	for(var i=0;i<bandeiraLista.length;i++)
		if(bandeiraLista[i].checked == true){
			var bandeira = bandeiraLista[i].value;
		}

    PagSeguroDirectPayment.createCardToken({
		cardNumber: numCartao,
		cvv: cvvCartao,
		brand: bandeira,
		expirationMonth: expiracaoMes,
		expirationYear: expiracaoAno,

		success: function(response){  
				$(".tokenPagamentoCartao").val(response['card']['token']);
				document.getElementById("tokencartao").value = response['card']['token'];
				console.log(response['card']['token']);
				},
		error: function(response){ console.log(response); }
    });
	console.log(bandeira);	
}

/* $("#cvv").keyup(function(){  //criar token

        numCartao = $("#numCartao").val();
        cvvCartao = $("#cvv").val();
        expiracaoMes = $("#pagamentoMes").val();
        expiracaoAno = $("#pagamentoAno").val();

        PagSeguroDirectPayment.createCardToken({
            cardNumber: numCartao,
            cvv: cvvCartao,
            expirationMonth: expiracaoMes,
            expirationYear: expiracaoAno,

            success: function(response){  $(".tokenPagamentoCartao").val(response['card']['token']);},
            error: function(response){ console.log(response); }
       });

    }); */


/* $("#sessaoCad").click(function(){ //recebe codigo da dessão e seta o sessão id

        $.ajax({
            url :'/creditos/iniciaSessao',
            type : 'post',
            dataTyp : 'json',
            async : false,
            timeout: 20000,
            success: function(data){
                $(".retornoTeste").html(data);
                PagSeguroDirectPayment.setSessionId(data);
            }
        });

    }); */
	
	
$("#cadCPF").focus(function(){ //gera identificação do usuário

          identificador = PagSeguroDirectPayment.getSenderHash();
          $(".hashPagSeguro").val(identificador);

    });

PagSeguroDirectPayment.getBrand( {
          cardBin: bin,
          success: function(response) {

            $(".retornoTeste").html(response['brand']['name']);

            bandeira = response['brand']['name'];

            if(bandeira === 'elo'){
              $('#img-elo').css("border","3px solid #5d9afc");
            } else{$('#img-elo').css("border","3px solid white");}

            if(bandeira === 'visa'){
              $('#img-visa').css("border","3px solid #5d9afc");
            } else{$('#img-visa').css("border","3px solid white");}

            if(bandeira === 'mastercard'){
              $('#img-mastercard').css("border","3px solid #5d9afc");
            } else{$('#img-mastercard').css("border","3px solid white");}

            if(bandeira === 'hipercard'){
              $('#img-hipercard').css("border","3px solid #5d9afc");
            } else{$('#img-hipercard').css("border","3px solid white");}

            if(bandeira === 'amex'){
              $('#img-amex').css("border","3px solid #5d9afc");
            } else{$('#img-amex').css("border","3px solid white");}

          },
          error: function(response) {

          }
      });
	  
$("#parcelamento").click(function(){

        PagSeguroDirectPayment.getInstallments({
            amount: 49,
            maxInstallmentNoInterest: 1,
            //brand: 'visa',

            success: function(response){ console.log(response);},
            error: function(response){ console.log(response); }
        });

});

$("#cvv").keyup(function(){  //criar token

        numCartao = $("#numCartao").val();
        cvvCartao = $("#cvv").val();
        expiracaoMes = $("#pagamentoMes").val();
        expiracaoAno = $("#pagamentoAno").val();

        PagSeguroDirectPayment.createCardToken({
            cardNumber: numCartao,
            cvv: cvvCartao,
            expirationMonth: expiracaoMes,
            expirationYear: expiracaoAno,

            success: function(response){  $(".tokenPagamentoCartao").val(response['card']['token']);},
            error: function(response){ console.log(response); }
       });

    });

$("#meios").click(function(){ //meios de pagamento disponíveis

          PagSeguroDirectPayment.getPaymentMethods({
          amount: 500,
          success: function(response){ console.log(response); },
          error: function(response){ console.log(response); }
          });

    });