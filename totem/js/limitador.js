function limiteCartao(){
	var valor = document.getElementById("numCartao").value;   //Declarando a variaveis usada no limitador do número do cartão
	var limite = 16;
	
	var valormes = document.getElementById("pagamentoMes").value; //Declarando a variaveis usada no limitador do mes 
	var limitemes = 2;
	
	var valorano = document.getElementById("pagamentoAno").value; //Declarando a variaveis usada no limitador do ano
	var limiteano = 4;
	
		if(valor.length>limite){
			valor = valor.substring(0, limite);                      //Condição do limitador do número
			document.getElementById("numCartao").value = valor;
		}
		
		
		if(valormes.length>limitemes){
			valormes = valormes.substring(0, limitemes);           
			document.getElementById("pagamentoMes").value = valormes;      //Condição do limitador do mes
		}
		
		if(valorano.length>limiteano){
			valorano = valormes.substring(0, limiteano);           
			document.getElementById("pagamentoAno").value = valorano;      //Condição do limitador do ano
		}
	
	
}
