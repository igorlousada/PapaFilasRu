import {NgModule} from "@angular/core";
import {IonicApp, IonicModule} from "ionic-angular";
import {BrowserModule} from '@angular/platform-browser';
import {HttpClientModule} from '@angular/common/http';
import {IonicStorageModule} from '@ionic/storage';

import {StatusBar} from '@ionic-native/status-bar';
import {SplashScreen} from '@ionic-native/splash-screen';
import {Keyboard} from '@ionic-native/keyboard';

import {ActivityService} from "../services/activity-service";
import {TripService} from "../services/trip-service";
import {WeatherProvider} from "../services/weather";

import {MyApp} from "./app.component";


import {HomePage} from '../pages/home/home';
import {LoginPage} from '../pages/login/login';
import {CompraPage} from '../pages/compra/compra';
import {ExtratoPage} from '../pages/extrato/extrato';
import {HttpModule} from '@angular/http';
import {StatusPage} from '../pages/status/status';
import {CardapioPage} from '../pages/cardapio/cardapio';
import { ConexaoProvider } from '../providers/conexao/conexao';


// import services
// end import services
// end import services

// import pages
// end import pages

@NgModule({
  declarations: [
    MyApp,
    HomePage,
    LoginPage,
    CompraPage,
    ExtratoPage,
    StatusPage,
    CardapioPage
  ],
  imports: [
    BrowserModule,
    HttpModule,
    HttpClientModule,
    IonicModule.forRoot(MyApp, {
      scrollPadding: false,
      scrollAssist: true,
      autoFocusAssist: false
    }),
    IonicStorageModule.forRoot({
      name: '__ionic3_start_theme',
        driverOrder: ['indexeddb', 'sqlite', 'websql']
    })
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    LoginPage,
    CompraPage,
    ExtratoPage,
    StatusPage,
    CardapioPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    Keyboard,
    ActivityService,
    TripService,
    WeatherProvider,
    ConexaoProvider
  ]
})

export class AppModule {
}
