
function ajaxMandarLista(array, url){
  // console.log(array);

  $.ajax({
    data: array,
    url: "../../../api/"+url+".php",
    type: "POST",
    success: function (data) {
      data = jQuery.parseJSON(data);
      if (data['response']['code'] == 1) {
        Toast.fire({
          icon: "success",
          title: "¡Precios actualizados!",
          timer: 2000,
        });
      }
    },
  });
}


function getListaConcepto(){
  let costo = 0;
  let listaCosto = new Array();
  $('#TablaListaPrecios tbody tr').each(function() {
      var arregloEstudios = new Array();
      let costo = $(this).find("input[name='costoConcepto']").val();
      tabledata = tablaPrecio.row( this ).data();


      arregloEstudios = {
        0: tabledata['ID_SERVICIO'],
        1: costo,
      }

      listaCosto.push(arregloEstudios)
  });
  return listaCosto
}

//Genera el arreglo para obtener los precios de la lista de precios o paquetes
function getListaPrecios(id){ //Enviar ID_SERVICIO o ID_PAQUETE
  let listaPrecios = new Array();
  $('#TablaListaPrecios tbody tr').each(function() {
      let costo = 0, utilidad = 0, total = 0;
      var arregloPrecios = new Array();
      let calculo = calcularFilaPrecios($(this));
      if (calculo) {
        tabledata = tablaPrecio.row( this ).data();

        arregloPrecios = {
          'id': tabledata[id],
          'costo': calculo[0],
          'utilidad': calculo[1],
          'total': calculo[2],
        }

        listaPrecios.push(arregloPrecios)
      }
  });
  return listaPrecios;
}

function calcularFilaPrecios(parent_element){
  let costo = parseFloat($(parent_element).find("div[class='costo text-center']").text().slice(1));
  let utilidad = parseFloat($(parent_element).find("input[name='utilidad']").val());
  let total = parseFloat($(parent_element).find("input[name='total']").val());
  return data = [costo, utilidad, total];
  // if (costo > 0 && utilidad != 0 && total != 0) {
  //     return data = [costo, utilidad, total];
  // }else{
  //   return false;
  // }

}


function obtenerColumnasTabla(tipo){
  switch (tipo) {
    case "1.1": //Regresa columna definidas de concepto
      return value = [
        { width: "5%", title: "#", targets: 0 },
        { width: "8%", title: "AB", targets: 1 },
        { width: "42%", title: "Nombre", targets: 2 },
        { width: "20%", title: "Costo", targets: 3, orderable: false },
      ]
    break;
    case "1.2": //Regresa columnas datos de concepto
      return value = [
          {data: 'COUNT'},
          {data: 'ABREVIATURA'},
          {data: 'DESCRIPCION'},
          {
            data: 'COSTO',
            render: function (data, type, full, meta) {
                if (data == null || data == 0) {
                  value = 0;
                }else{
                  value = data;
                }
                rturn = '<div class="input-group"><span class="input-span">$</span><input type="number" class="form-control input-form costoConcepto" name="costoConcepto" placeholder="" value="'+value+'"></div>';

                return rturn;
            },
          },
      ]
    break;
    case "2.1": //Regresa columna definidas de precios
      return value = [
        { width: "5%", title: "#", targets: 0 },
        { width: "8%", title: "AB", targets: 1 },
        { width: "38%", title: "Nombre", targets: 2 },
        { title: "Costo", targets: 3 },
        { width: "20%",title: "Utilidad", targets: 4, orderable: false },
        { width: "20%",title: "Precio Venta", targets: 5, orderable: false }
      ]
    break;
    case "2.2": //Regresa columnas data de precios
      return value = [
        {data: 'COUNT'},
        {data: 'ABREVIATURA'},
        {data: 'SERVICIO'},
        {
          data: 'COSTO',
          render: function (data, type, full, meta) {
              if (data == null || data == 0) {
                value = 0;
              }else{
                value = data;
              }
              numero = getRandomInt(300);
              rturn = '<label class="form-check-label" for="costo'+numero+'"> <div class="form-check"> <div class="costo text-center">$'+value+'<input class="form-check-input" type="checkbox" value="" id="costo'+numero+'" checked></div> </div> </label>';

              return rturn;
            },
        },
        {
          data: 'UTILIDAD',
          render: function (data, type, full, meta) {
              if (data == null || data == 0) {
                value = 0;
              }else{
                value = data;
              }
              rturn = '<div class="input-group"><input type="number" class="form-control input-form utilidad" name="utilidad" placeholder="" value="'+value+'"><span class="input-span">%</span></div>';

              return rturn;
            },
        },
        {
          data: 'PRECIO_VENTA',
          render: function (data, type, full, meta) {
            if (data == null || data == 0) {
              value = 0;
            }else{
              value = data;
            }
            rturn = '<div class="input-group"><span class="input-span">$</span><input type="number" class="form-control input-form total" name="total" placeholder="" value="'+value+'"></div>';

            return rturn;
          },
        },
      ]
    break;
    case "3.1": //Regresa columnas definidas de paquetes
      return value = [
        { width: "5%", title: "#", targets: 0 },
        { title: "Paquete", targets: 1 },
        { width: "10%",title: "Costo", targets: 2 },
        { width: "18%",title: "Utilidad", targets: 3, orderable: false },
        { width: "18%",title: "Precio Venta", targets: 4, orderable: false }
      ]
    break;
    case "3.2": //Regresa columnas data de paquetes
      return value = [
          {data: 'COUNT'},
          {data: 'DESCRIPCION'},
          {
            data: 'COSTO',
            render: function (data, type, full, meta) {
                if (data == null || data == 0) {
                  value = 0;
                }else{
                  value = data;
                }
                rturn = '<div class="costo text-center">$'+value+'</div>';

                return rturn;
              },
          },
          {
            data: 'UTILIDAD',
            render: function (data, type, full, meta) {
                if (data == null || data == 0) {
                  value = 0;
                }else{
                  value = data;
                }
                rturn = '<div class="input-group"><input type="number" class="form-control input-form utilidad" name="utilidad" placeholder="" value="'+value+'"><span class="input-span">%</span></div>';

                return rturn;
              },
          },
          {
            data: 'PRECIO_VENTA',
            render: function (data, type, full, meta) {
              if (data == null || data == 0) {
                value = 0;
              }else{
                value = data;
              }
              rturn = '<div class="input-group"><span class="input-span">$</span><input type="number" class="form-control input-form total" name="total" placeholder="" value="'+value+'"></div>';

              return rturn;
            },
          }
        ]
    break;
    default:

  }
}
