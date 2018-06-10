function limiteCartao(){
	var valor = document.getElementById("numero").value;   //Declarando a variaveis usada no limitador do número do cartão
	var limite = 16;
	
	var valormes = document.getElementById("mes").value; //Declarando a variaveis usada no limitador do mes 
	var limitemes = 2;
	
	var valorano = document.getElementById("ano").value; //Declarando a variaveis usada no limitador do ano
	var limiteano = 4;
	
		if(valor.length>limite){
			valor = valor.substring(0, limite);                      //Condição do limitador do número
			document.getElementById("numero").value = valor;
		}
		
		
		if(valormes.length>limitemes){
			valormes = valormes.substring(0, limitemes);           
			document.getElementById("mes").value = valormes;      //Condição do limitador do mes
		}
		
		if(valorano.length>limiteano){
			valorano = valormes.substring(0, limiteano);           
			document.getElementById("ano").value = valorano;      //Condição do limitador do ano
		}
	
	
}
