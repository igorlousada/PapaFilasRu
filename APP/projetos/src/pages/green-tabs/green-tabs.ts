import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';

/**
 * Generated class for the GreenTabsPage tabs.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

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
