angular.module('app.controllers', [])
  
.controller('bemVindoAAoIRuCtrl', ['$scope', '$stateParams', // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams) {


}])
   
.controller('loginCtrl', ['$scope','$http','$stateParams','$state',function ($scope,$http,$stateParams,$state){ // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
	$scope.login = function ()
		{
			var matricula = document.getElementById('Matricula').value;
			var cpf = document.getElementById('CPF').value
			//var User = [matricula,cpf];
			//console.log(User);
			//var UserLogin = JSON.stringify({type:'User',Matricula:matricula,CPF:cpf});
			//var UserLogin = JSON.stringify({type:'User',Matricula:matricula,CPF:cpf});
			//console.log(UserLogin);
			$http.get('http://35.199.101.182/api/usuarios/'+matricula)
			.then(data =>
			{
				//console.log(data.status);
				//console.log(data.headers);
				//console.log(data.data);
				if(data.status == 200)
				{
					$scope.CPF = data.data.CPF;
					$scope.MATRICULA = data.data.MATRICULA;
					$scope.GRUPO = data.data.ID_GRUPO;
					$scope.EMAIL = data.data.EMAIL;
					$scope.NAME = data.data.NOME_USUARIO;
					$scope.SALDO = data.data.SALDO;
					//console.log($scope.CPF);
					//console.log($scope.MATRICULA);
					//console.log($scope.GRUPO);
					//console.log($scope.EMAIL);
					//console.log($scope.NAME);
					localStorage.setItem("matricula",$scope.MATRICULA);
					localStorage.setItem("cpf",$scope.CPF);
					localStorage.setItem("email",$scope.EMAIL);
					localStorage.setItem("name",$scope.NAME);
					localStorage.setItem("grupo",$scope.GRUPO);
					localStorage.setItem("saldo",$scope.SALDO);
					$state.go("menu");
				}
				else if(data.status == 204)
					{
						console.log("Matricula ou senha inválida");
					}
			})
			.catch(error => 
			{
				alert("Matricula ou senha inválida");
				console.log(error.status);
				console.log(error.error);
				console.log(error.headers);
			});
			/*sucess(function(data,status,headers,config)
			{
				if(data == true)
				{
					$scope.matricula = matricula;
					$scope.cpf = cpf;
					localStorage.setItem("matricula",$scope.matricula);
					localStorage.setItem("cpf",$scope.cpf);
					$state.go("menu");
				}
				else
				{
					if(data == false)
					{
						alert("Matricula ou CPF inválidos");
					}
				}
			}).
			error(function(data,status,headers,config)
				{
					console.log("Erro na conexão ao servidor");
				});
		}*/}
}])
   
.controller('inicioCtrl', ['$scope', '$stateParams', // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams) {


}])
   
.controller('menuCtrl', function ($scope,$stateParams,$http) { // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
$scope.matricula = localStorage.getItem("matricula");
$scope.meuNome = localStorage.getItem("name");
$scope.meuSaldo = localStorage.getItem("saldo");

})

.controller('cardapioCtrl', ['$scope', '$stateParams', // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams) {

}]) 

.controller('statusCtrl', ['$scope', '$stateParams', // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams) {


}])

.controller('extratoCtrl', ['$scope', '$stateParams', // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams) {


}])

.controller('pagseguroCtrl', ['$scope','$http','$stateParams','$state',function ($scope,$http,$stateParams,$state){ // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
	$scope.compra = function ()
		{
			console.log("Oi");
		}
}])