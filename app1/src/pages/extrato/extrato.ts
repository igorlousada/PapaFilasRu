import {Component} from "@angular/core";
import {NavController} from "ionic-angular";
import {CompraPage} from '../compra/compra';
import {HomePage} from '../home/home';


@Component({
  selector: 'page-extrato',
  templateUrl: 'extrato.html'
})
export class ExtratoPage {

  constructor(public nav: NavController) {
  }

   // login and go to home page
  docompra() {
    this.nav.setRoot(CompraPage);
  }

  dohome(){
 	this.nav.setRoot(HomePage);
  }


}
