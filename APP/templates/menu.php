<ion-view title="Menu" id="page11" style="">
<ion-content class="has-header" padding="true">
    <!--<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
<!-- Linhas adicionadas do pagseguro.html-->
  <!--<input type="hidden" name="itemCode" value="9F9FA85EFCFCF34EE478BF8DB1612947" />
  <input type="hidden" name="iot" value="button" />-->
   <div class="spacer" style="width: 290px; height: 10px;"></div>
   <ion-card>
  <h3 style="color:black; text-align: center">
    Olá {{meuNome}} 
    </h3>
  <h3 style="color:black; text-align: center">
    seu saldo atual é de: {{meuSaldo}} 
  </h3>
</ion-card>
  <div class="spacer" style="height: 30px;"></div>
    <a ui-sref="pagseguro" id="login-button1" class="button button-dark button-block">Comprar Refeições</a>
      <div class="spacer" style="height: 40px;"></div>
    <a ui-sref="extrato" id="login-button2" class="button button-dark button-block">Extrato de Compras</a>
  </ion-content>
</ion-view>
