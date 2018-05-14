import {Component} from "@angular/core";
import {NavController, AlertController, ToastController, MenuController} from "ionic-angular";
import {HomePage} from "../home/home";
import {StatusPage} from '../status/status';
import {CardapioPage} from '../cardapio/cardapio';

@Component({
  selector: 'page-login',
  templateUrl: 'login.html'
})
export class LoginPage {

  constructor(public nav: NavController, public forgotCtrl: AlertController, public menu: MenuController, public toastCtrl: ToastController) {
    this.menu.swipeEnable(false);
  }

  // login and go to home page
  login() {
    this.nav.setRoot(HomePage);
  }

  docardapio(){
  	this.nav.setRoot(CardapioPage);
  }

  dostatus(){
	this.nav.setRoot(StatusPage);
  }


}
