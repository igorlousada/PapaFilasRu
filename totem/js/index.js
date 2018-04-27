// Imprimira en el panel los colores
function setPrintDisplayColorsDashboard(data, i) {
  if(urlPath === '/') {
    $('#tbodyListColorsDashBoard')
      .append(`<div id="cdb-${data.id}" class="col s4 colorDashboar" style="background-color: ${data.color};" onclick="setColorSelectDashboard('${data.id}')">
      <input type="radio" id="dbProd-${data.id}" name="selectProductDB" />
      <label for="dbProd-${data.id}"></label>
    </div>`);
  }
}

// Cambiara la seleccion de radio color
function setColorSelectDashboard(data){
  console.log('Se ha seleccionado el color '+ data);
  $(`#dbProd-${data}`).prop('checked', 'true');
}
 
function setNumbersSelectDashboard(data){
  console.log('Se ha seleccionado el Numero '+ data);
  var inp = $('input[name=NumberLote]');
  if(data === "Clear") {
    console.log('Limpiar')
    inp.val('');
  } 
  if(data !== 'none') {
    var ant = inp.val();
    var newN = data;
    inp.val(`${ant}${newN}`);
    console.log(data +' '+n)
  }
}