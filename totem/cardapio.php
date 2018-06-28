<?php

date_default_timezone_set('America/Sao_Paulo');

$day = date("Ymd");
$cardapio = getMenu($day);
$refeicoes = splitMeals($cardapio);

?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" /><script type="text/javascript">window.NREUM||(NREUM={}),__nr_require=function(e,t,n){function r(n){if(!t[n]){var o=t[n]={exports:{}};e[n][0].call(o.exports,function(t){var o=e[n][1][t];return r(o||t)},o,o.exports)}return t[n].exports}if("function"==typeof __nr_require)return __nr_require;for(var o=0;o<n.length;o++)r(n[o]);return r}({1:[function(e,t,n){function r(){}function o(e,t,n){return function(){return i(e,[f.now()].concat(u(arguments)),t?null:this,n),t?void 0:this}}var i=e("handle"),a=e(2),u=e(3),c=e("ee").get("tracer"),f=e("loader"),s=NREUM;"undefined"==typeof window.newrelic&&(newrelic=s);var p=["setPageViewName","setCustomAttribute","setErrorHandler","finished","addToTrace","inlineHit","addRelease"],d="api-",l=d+"ixn-";a(p,function(e,t){s[t]=o(d+t,!0,"api")}),s.addPageAction=o(d+"addPageAction",!0),s.setCurrentRouteName=o(d+"routeName",!0),t.exports=newrelic,s.interaction=function(){return(new r).get()};var m=r.prototype={createTracer:function(e,t){var n={},r=this,o="function"==typeof t;return i(l+"tracer",[f.now(),e,n],r),function(){if(c.emit((o?"":"no-")+"fn-start",[f.now(),r,o],n),o)try{return t.apply(this,arguments)}catch(e){throw c.emit("fn-err",[arguments,this,e],n),e}finally{c.emit("fn-end",[f.now()],n)}}}};a("setName,setAttribute,save,ignore,onEnd,getContext,end,get".split(","),function(e,t){m[t]=o(l+t)}),newrelic.noticeError=function(e){"string"==typeof e&&(e=new Error(e)),i("err",[e,f.now()])}},{}],2:[function(e,t,n){function r(e,t){var n=[],r="",i=0;for(r in e)o.call(e,r)&&(n[i]=t(r,e[r]),i+=1);return n}var o=Object.prototype.hasOwnProperty;t.exports=r},{}],3:[function(e,t,n){function r(e,t,n){t||(t=0),"undefined"==typeof n&&(n=e?e.length:0);for(var r=-1,o=n-t||0,i=Array(o<0?0:o);++r<o;)i[r]=e[t+r];return i}t.exports=r},{}],4:[function(e,t,n){t.exports={exists:"undefined"!=typeof window.performance&&window.performance.timing&&"undefined"!=typeof window.performance.timing.navigationStart}},{}],ee:[function(e,t,n){function r(){}function o(e){function t(e){return e&&e instanceof r?e:e?c(e,u,i):i()}function n(n,r,o,i){if(!d.aborted||i){e&&e(n,r,o);for(var a=t(o),u=m(n),c=u.length,f=0;f<c;f++)u[f].apply(a,r);var p=s[y[n]];return p&&p.push([b,n,r,a]),a}}function l(e,t){v[e]=m(e).concat(t)}function m(e){return v[e]||[]}function w(e){return p[e]=p[e]||o(n)}function g(e,t){f(e,function(e,n){t=t||"feature",y[n]=t,t in s||(s[t]=[])})}var v={},y={},b={on:l,emit:n,get:w,listeners:m,context:t,buffer:g,abort:a,aborted:!1};return b}function i(){return new r}function a(){(s.api||s.feature)&&(d.aborted=!0,s=d.backlog={})}var u="nr@context",c=e("gos"),f=e(2),s={},p={},d=t.exports=o();d.backlog=s},{}],gos:[function(e,t,n){function r(e,t,n){if(o.call(e,t))return e[t];var r=n();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(e,t,{value:r,writable:!0,enumerable:!1}),r}catch(i){}return e[t]=r,r}var o=Object.prototype.hasOwnProperty;t.exports=r},{}],handle:[function(e,t,n){function r(e,t,n,r){o.buffer([e],r),o.emit(e,t,n)}var o=e("ee").get("handle");t.exports=r,r.ee=o},{}],id:[function(e,t,n){function r(e){var t=typeof e;return!e||"object"!==t&&"function"!==t?-1:e===window?0:a(e,i,function(){return o++})}var o=1,i="nr@id",a=e("gos");t.exports=r},{}],loader:[function(e,t,n){function r(){if(!x++){var e=h.info=NREUM.info,t=d.getElementsByTagName("script")[0];if(setTimeout(s.abort,3e4),!(e&&e.licenseKey&&e.applicationID&&t))return s.abort();f(y,function(t,n){e[t]||(e[t]=n)}),c("mark",["onload",a()+h.offset],null,"api");var n=d.createElement("script");n.src="https://"+e.agent,t.parentNode.insertBefore(n,t)}}function o(){"complete"===d.readyState&&i()}function i(){c("mark",["domContent",a()+h.offset],null,"api")}function a(){return E.exists&&performance.now?Math.round(performance.now()):(u=Math.max((new Date).getTime(),u))-h.offset}var u=(new Date).getTime(),c=e("handle"),f=e(2),s=e("ee"),p=window,d=p.document,l="addEventListener",m="attachEvent",w=p.XMLHttpRequest,g=w&&w.prototype;NREUM.o={ST:setTimeout,SI:p.setImmediate,CT:clearTimeout,XHR:w,REQ:p.Request,EV:p.Event,PR:p.Promise,MO:p.MutationObserver};var v=""+location,y={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-1071.min.js"},b=w&&g&&g[l]&&!/CriOS/.test(navigator.userAgent),h=t.exports={offset:u,now:a,origin:v,features:{},xhrWrappable:b};e(1),d[l]?(d[l]("DOMContentLoaded",i,!1),p[l]("load",r,!1)):(d[m]("onreadystatechange",o),p[m]("onload",r)),c("mark",["firstbyte",u],null,"api");var x=0,E=e(4)},{}]},{},["loader"]);</script>
  <title>cardapio</title>

<!-- Importando google icons-->

 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- importando arquivos CSS-->
<link rel="stylesheet" href="css/materialize.min.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
</head>

<body>

<!--Botão para voltar á pagina inicial -->
<div class="container">

  <div class="fixed-action-btn">
    <a  href="index.php"  class="btn-floating btn-large blue darken-4">
      <iclass="large material-icons" class="material-icons"><i class="material-icons">keyboard_backspace</i>
    </a>
  </div>


<!-- Mensagem inicial-->
<div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <br/>
  <br/>
<h1 class="header blue-text text-darken-4">Cardápio</h1>
<h3 class="header blue-text text-darken-4">Deslize para visualizar todos os cardápios do dia:</h3>
  </div>


</div>

<br><br>



    <div class="col s12 m12 l12">
        <div class="carousel carousel-slider center center-align" style="height: 650px;">
        <!--Div da primeira tabela -->
       <div class="carousel-item deep-purple lighten-4 black-text" href="#one!">
         <h2>Café da manhã</h2>
         <div class="container">
             <!-- Div da tabela-->
             <div id="table">
                   <table class="responsive-table">
                     <thead>
                       <tr>
                         <th data-field="id">Pratos</th>
                         <th data-field="name">Opções</th>
                       </tr>
                     </thead>
                     <?php $cafe = $refeicoes['cafe'];?>
                     <tbody>
                       <tr>
                         <td>Bebida quente</td>
                         <td><?php echo $cafe['BEBIDAS_Q_1'];?></td>
                       </tr>
                       <tr>
                         <td>Bebida quente vegetariana</td>
                         <td><?php echo $cafe['BEBIDAS_Q_VEG_1'];?></td>
                       </tr>
                       <tr>
                         <td>Achocolatado</td>
                         <td><?php echo $cafe['ACHOCOLATADO_1'];?></td>
                       </tr>
                       <tr>
                         <td>Pão</td>
                         <td><?php echo $cafe['PAO_1'];?></td>
                       </tr>
                       <tr>
                         <td>Proteína</td>
                         <td><?php echo $cafe['PROTEINA_1'];?></td>
                       </tr>
                       <tr>
                         <td>Proteína Vegetariana</td>
                         <td><?php echo $cafe['PROTEINA_VEG_1'];?></td>
                       </tr>
                       <tr>
                         <td>Complemento</td>
                         <td><?php echo $cafe['COMPLEMENTO_1'];?></td>
                       </tr>
                       <tr>
                         <td>Frutas</td>
                         <td><?php echo $cafe['FRUTA_1'];?></td>
                       </tr>
                     </tbody>
                   </table>
                 </div>
                 <!-- Div da tabela-->

         </div>

       </div>
       <!-- Div da primeira tabela-->
       <!-- Div da segunda tabela-->
       <div class="carousel-item green lighten-3 black-text" href="#two!">
           <?php $almoco = $refeicoes['almoco'];?>
         <h2>Almoço</h2>
         <div class="container">
             <!-- Div da tabela-->
             <div id="table">
                   <table class="responsive-table">
                     <thead>
                       <tr>
                         <th data-field="id">Prato</th>
                         <th data-field="name">Opções</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <td>Prato Principal</td>
                         <td><?php echo $almoco['PRATO_PRINCIPAL_2'];?></td>
                       </tr>
                       <tr>
                         <td>Prato Vegetariano</td>
                         <td><?php echo $almoco['PRATO_VEG_2'];?></td>
                       </tr>
                       <tr>
                         <td>Guarnição</td>
                         <td><?php echo $almoco['GUARNICAO_2'];?></td>
                       </tr>
                       <tr>
                         <td>Acompanhamentos</td>
                         <td><?php echo $almoco['ACOMPANHAMENTOS_2'];?></td>
                       </tr>
                       <tr>
                         <td>Saladas</td>
                         <td><?php echo $almoco['SALADA_2'];?></td>
                       </tr>
                       <tr>
                         <td>Molho</td>
                         <td><?php echo $almoco['MOLHO_2'];?></td>
                       </tr>
                       <tr>
                         <td>Sobremesa</td>
                         <td><?php echo $almoco['SOBREMESA_2'];?></td>
                       </tr>
                       <tr>
                         <td>Refresco</td>
                         <td><?php echo $almoco['REFRESCO_2'];?></td>
                       </tr>
                     </tbody>
                   </table>
                 </div>
                 <!-- Div da tabela-->

         </div>

       </div>
       <!-- Div da segunda tabela-->
       <!-- Div da terceira tabela-->
       <div class="carousel-item  yellow lighten-2 black-text" href="#three!">
         <h2>Jantar</h2>
         <div class="container">
             <!-- Div da tabela-->
             <?php $jantar = $refeicoes['jantar'];?>
             <div id="table">
                   <table class="responsive-table">
                     <thead>
                       <tr>
                         <th data-field="id">Prato</th>
                         <th data-field="name">Opções</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <td>Prato Principal</td>
                         <td><?php echo $jantar['PRATO_PRINCIPAL_3'];?></td>
                       </tr>
                       <tr>
                         <td>Prato Vegetariano</td>
                         <td><?php echo $jantar['PRATO_VEG_3'];?></td>
                       </tr>
                       <tr>
                         <td>Complementos</td>
                         <td><?php echo $jantar['COMPLEMENTOS_3'];?></td>
                       </tr>
                       <tr>
                         <td>Salada</td>
                         <td><?php echo $jantar['SALADA_3'];?></td>
                       </tr>
                       <tr>
                         <td>Pão</td>
                         <td><?php echo $jantar['PAO_3'];?></td>
                       </tr>
                       <tr>
                         <td>Sopa</td>
                         <td><?php echo $jantar['SOPA_3'];?></td>
                       </tr>
                       <tr>
                         <td>Molho</td>
                         <td><?php echo $jantar['MOLHO_3'];?></td>
                       </tr>
                       <tr>
                         <td>Sobremesa</td>
                         <td><?php echo $jantar['SOBREMESA_3'];?></td>
                       </tr>
                       <tr>
                         <td>Refresco</td>
                         <td><?php echo $jantar['REFRESCO_3'];?></td>
                       </tr>
                     </tbody>
                   </table>
                 </div>
                 <!-- Div da tabela-->

         </div>
       </div>
       <!-- Div da terceira tabela-->
     </div>
        <!--div do carousel-->

        <br>


        <!--Indicativo para rolagem  -->
        <div class="row">
            <div class="container center-align">
                     <img src="Imagens/gesto.png" class="animated slideInLeft">
            </div>

        </div>




        <!--Indicativo para rolagem  -->

    </div>



    <!--Div do carousel -->


</div>


<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script src="js/materialize.js"></script>
<script  type="text/javascript" src="js/materialize.min.js"></script>
<script>

$('.carousel.carousel-slider').carousel({
   fullWidth: true
 });
</script>
<script type="text/javascript">window.NREUM||(NREUM={});NREUM.info={"beacon":"bam.nr-data.net","licenseKey":"aece2c08f5","applicationID":"8163328","transactionName":"ZgMBMkBYDRcCARVQC19JNhRbFhYXEU0SUQVDA0wUXUwNAAAXA1wJUA8PSUJMAQgKAT5REFwKTA9cXQYcTRIJSQ==","queueTime":0,"applicationTime":276,"atts":"SkQCRAhCHhk=","errorBeacon":"bam.nr-data.net","agent":""}</script></body>






</html>

<?php
function getMenu($day){
    $apiAdress = 'http://35.199.101.182/api/cardapio/';
    $encodedMenu = file_get_contents($apiAdress.$day);
    $menu = json_decode($encodedMenu);
    return $menu;
    }

function splitMeals($menu){
    $breakfast = array();
    $lunch = array();
    $dinner = array();
    foreach($menu as $key => $value){
        if (strpos($key, '_1')!=false){
            $breakfast[$key]=$value;
        }
        else if (strpos($key, '_2')!=false){
            $lunch[$key]=$value;
        }
        else if (strpos($key, '_3')!=false){
            $dinner[$key]=$value;
        }
    }
    $MealsSplitted = array('cafe' => $breakfast,
                            'almoco' => $lunch,
                            'jantar' => $dinner);
    return $MealsSplitted;
}

?>
