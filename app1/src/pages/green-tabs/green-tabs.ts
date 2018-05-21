import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';


@IonicPage()
@Component({
  selector: 'page-green-tabs',
  templateUrl: 'green-tabs.html'
})
export class GreenTabsPage {

  statusRoot = 'StatusPage'
  homeRoot = 'HomePage'
  cardapioRoot = 'CardapioPage'


  constructor(public navCtrl: NavController) {}

}
