import {Component} from "@angular/core";
import {NavController, AlertController, ToastController, MenuController, NavParams} from "ionic-angular";
import {HomePage} from "../home/home";
import {StatusPage} from '../status/status';
import {CardapioPage} from '../cardapio/cardapio';
import {ConexaoProvider} from "../../providers/conexao/conexao";

@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
  providers:
  [
    ConexaoProvider
  ]
})
export class LoginPage {

  constructor(
    public nav: NavController, 
    public forgotCtrl: AlertController, 
    public menu: MenuController, 
    public toastCtrl: ToastController,
    private conexaoProvider: ConexaoProvider,
    public navCtrl: NavController,
    public navParams: NavParams
  ) {
    this.menu.swipeEnable(false);
  }
  
  private myMatricula;
  public nomeUsuario;
  public saldoUsuario;

  // login and go to home page
  login() 
  {
    //this.nav.setRoot(HomePage);
    console.log(this.myMatricula);
    this.conexaoProvider.getMatricula(this.myMatricula).subscribe
      (
        data=>{
          //console.log(data);
          const response = (data as any);
          const objeto_retorno = JSON.parse(response._body);
          console.log(objeto_retorno);
          if (data.status == 200)
          {
            console.log("Entrou no if");
            this.nomeUsuario = objeto_retorno.NOME_USUARIO;
            this.saldoUsuario = objeto_retorno.SALDO;
            localStorage.setItem("nome",this.nomeUsuario);
            localStorage.setItem("saldo",this.saldoUsuario);
            //console.log();
            this.navCtrl.push(HomePage);
          }
          else if(data.status == 206)
          {
            console.log("Entrou no else");
          }
        },
        error=>{
          console.log(error);
        }
      )
    {

    }
  }

  docardapio(){
  	this.nav.setRoot(CardapioPage);
  }

  dostatus(){
	this.nav.setRoot(StatusPage);
  }


}
