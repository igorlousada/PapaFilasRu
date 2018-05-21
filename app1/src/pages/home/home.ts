import {Component} from "@angular/core";
import {NavController} from "ionic-angular";
import {CompraPage} from '../compra/compra';
import {ExtratoPage} from '../extrato/extrato';


@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {

  public myName = localStorage.getItem("nome");
  public mySaldo = localStorage.getItem("saldo");

  constructor(public nav: NavController) {
  }

   // login and go to home page
  docompra() {
    this.nav.setRoot(CompraPage);
    //console.log(this.myName);
  }

  doextrato(){
 	this.nav.setRoot(ExtratoPage);
  }

}
