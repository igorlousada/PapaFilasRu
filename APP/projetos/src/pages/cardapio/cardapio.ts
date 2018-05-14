import {Component} from "@angular/core";
import {NavController} from "ionic-angular";
import {StatusPage} from '../status/status';
import {LoginPage} from '../login/login';

@Component({
  selector: 'page-cardapio',
  templateUrl: 'cardapio.html'
})
export class CardapioPage {

  constructor(public nav: NavController) {
  }

  dostatus(){
	this.nav.setRoot(StatusPage);
  }

  dologin(){
  	this.nav.setRoot(LoginPage);
  }


}
