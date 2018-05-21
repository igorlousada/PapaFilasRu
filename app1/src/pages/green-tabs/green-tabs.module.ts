import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { GreenTabsPage } from './green-tabs';

@NgModule({
  declarations: [
    GreenTabsPage,
  ],
  imports: [
    IonicPageModule.forChild(GreenTabsPage),
  ]
})
export class GreenTabsPageModule {}
