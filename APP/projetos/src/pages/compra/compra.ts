import {Component} from "@angular/core";
import {NavController} from "ionic-angular";
import {ExtratoPage} from '../extrato/extrato';
import {HomePage} from '../home/home';

@Component({
  selector: 'page-compra',
  templateUrl: 'compra.html'
})
export class CompraPage {

  constructor(public nav: NavController) {
  }

 // login and go to home page
  doextrato() {
    this.nav.setRoot(ExtratoPage);
  }

  dohome(){
 	this.nav.setRoot(HomePage);
  }

}
