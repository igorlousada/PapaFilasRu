import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';

/*
  Generated class for the ConexaoProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class ConexaoProvider {

  private baseApiPath = 'http://35.199.101.182/api/usuarios/';
  constructor(public http: Http) {
    //console.log('Hello ConexaoProvider Provider');
  }

  getMatricula(matricula)
  {
    return this.http.get(this.baseApiPath + matricula);
  }

}
