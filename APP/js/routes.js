angular.module('app.routes', [])

.config(function($stateProvider, $urlRouterProvider) {

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider
    

  .state('tabsController', {
    url: '/inicio',
    templateUrl: 'templates/tabsController.html',
    abstract:true
  })

  .state('menuinicial', {
    url: '/menuinicial',
    templateUrl: 'templates/menuinicial.html',
    controller: 'loginCtrl'
  })

  .state('inicio', {
    url: '/inicio',
    templateUrl: 'templates/inicio.html',
    controller: 'inicioCtrl'
  })

  .state('menu', {
    url: '/menu',
    templateUrl: 'templates/menu.php',
    controller: 'menuCtrl'
  })

  .state('cardapio', {
    url: '/cardapio',
    templateUrl: 'templates/cardapio.html',
    controller: 'cardapioCtrl'
  })

  .state('status', {
    url: '/status',
    templateUrl: 'templates/status.html',
    controller: 'statusCtrl'
  })

  .state('extrato', {
    url: '/extrato',
    templateUrl: 'templates/extrato.html',
    controller: 'extratoCtrl'
  })

  .state('pagseguro', {
    url: '/pagseguro',
    templateUrl: 'templates/pagseguro.html',
    controller: 'pagseguroCtrl'
  })

$urlRouterProvider.otherwise('/inicio')


});