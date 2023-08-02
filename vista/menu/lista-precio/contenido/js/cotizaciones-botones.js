select2('#seleccion-paquete', 'form-select-paquetes')
select2('#seleccion-estudio', 'form-select-paquetes')
select2('#select-presupuestos', 'form-select-paquetes')

//Declarar variable para la clase
var selectEstudio, SelectedFolio;
var datosUsuarioCotizacion = $('#datosUsuarioCotizacion');

console.log()

$('#agregar-estudio-paquete').click(function () {
  // console.log(selectEstudio.array)
  // console.log($("#seleccion-estudio").prop('selectedIndex'))
  // console.log(selectData)
  selectData = selectEstudio.array[$("#seleccion-estudio").prop('selectedIndex')]

  meterDato(selectData['SERVICIO'], selectData['ABREVIATURA'], selectData['COSTO'], selectData['PRECIO_VENTA'], 1, null, selectData['ID_SERVICIO'], selectData['ABREVIATURA'], tablaContenidoPaquete);
})


// $('#agregar-estudio-paquete').click(function() {
//   $.ajax({
//     url: http + servidor + "/"+appname+"/api/servicios_api.php",
//     type: "POST",
//       dataType: 'json',
//       data: { id: $('#seleccion-estudio').val(), api: 3},
//       success: function (data) {
//             data = data.response.data[0];
//             meterDato(data.SERVICIO, data.ABREVIATURA, data.COSTO, data.PRECIO_VENTA, data.ID_SERVICIO, data.ABREVIATURA, tablaPaquete);
//         }
//       }
//     );
// })

// Controlar el formulario
$("#formPaqueteBotonesArea").addClass("disable-element");
$("#formPaqueteSelectEstudio").addClass("disable-element");
$("#informacionPaquete").addClass("disable-element");

// $(document).on("click", '')

function lpad(value, length, padChar) {
  value = value.toString();

  while (value.length < length) {
    value = padChar + value;
  }

  return value;
}

$('#UsarPaquete').on('click', function () {




  if ($('input[type=radio][name=selectPaquete]:checked').val() == 2) {
    if (!$('#select-presupuestos').val()) {
      alertToast('Necesitas seleccionar un presupuesto de este cliente', 'error', '5000')
      return false;
    } else {
      SelectedFolio = $('#select-presupuestos').val()
      SelectedFolio = lpad(SelectedFolio, 4, '0')
    }
  }

  let id_cotizacion = $('#select-presupuestos').val();

  // $('#select-presupuestos').prop('disabled', true);
  $("#selectDisabled").addClass("disable-element");
  // $('.formContenidoPaquete').prop('disabled', false);
  $("#formPaqueteBotonesArea").removeClass("disable-element");
  $("#formPaqueteSelectEstudio").removeClass("disable-element");
  $("#informacionPaquete").removeClass("disable-element");

  calcularFilasTR()


  switch ($('input[type=radio][name=selectPaquete]:checked').val()) {
    case '2': //Lista de precios para clientes
      tablaContenido(true);
      ajaxAwait({
        id_cotizacion: id_cotizacion,
        api: 2
      }, 'cotizaciones_api', { callbackAfter: true }, false, (data) => {

        row = data.response.data[0]['DETALLE']
        row2 = data.response.data[0]
        // var datosUsuarioCotizacion = $('#datosUsuarioCotizacion')
        if (row) {
          datosUsuarioCotizacion.html(`<div class="col-6">
                  <p>Nombre: </p>
                  <span>${row2['CREADO_POR']}</span>

              </div>
              <div class="col-6">
                  <p>Correo: </p>
                  <span>${row2['CORREO']}</span>
              </div>`)


          $('#descuento-paquete').val(row2['PORCENTAJE_DESCUENTO'])


          for (const key in row) {
            if (Object.hasOwnProperty.call(row, key)) {
              const element = row[key];
              meterDato(row[key]['PRODUCTO'], row[key]['ABREVIATURA'], row[key]['COSTO_BASE'], row[key]['SUBTOTAL_BASE'], row[key]['CANTIDAD'], row[key]['DESCUENTO_PORCENTAJE'], row[key]['ID_SERVICIO'], null, tablaContenidoPaquete)

            }
          }

          calcularFilasTR()

        };

        // for (var i = 0; i < row.length; i++) {
        //   meterDato(row[i]['SERVICIO'], row[i]['ABREVIATURA'], row[i]['COSTO_UNITARIO'], row[i]['COSTO_TOTAL'], row[i]['CANTIDAD'], row[i]['ID_SERVICIO'], row[i]['ABREVIATURA'], tablaContenidoPaquete)
        // }
      })

      break;
  }
})
//
$('#CambiarPaquete').on('click', function () {
  //borrar el div para que se vuelva a abrir
  datosUsuarioCotizacion.empty()

  $('#seleccion-paquete').prop('disabled', false);
  $("#selectDisabled").removeClass("disable-element");
  $("#formPaqueteBotonesArea").addClass("disable-element");
  $("#formPaqueteSelectEstudio").addClass("disable-element");
  $("#informacionPaquete").addClass("disable-element");

  $('input[type=radio][name=selectChecko]:checked').prop('checked', false);
  $("#seleccion-estudio").find('option').remove().end()
  tablaContenido(true)
  // $('.formContenidoPaquete').prop('disabled', true);
})
// 

$('input[type="radio"][name="selectPaquete"]').change(function () {
  switch ($(this).val()) {
    case '1':
      contenidoPaquete();
      break;
    case '2':
      mantenimientoPaquete();
      break;

  }
});


$('input[type=radio][name=selectChecko]').change(function () {

  if ($(this).val() != 0) {
    // selectData = null;
    rellenarSelect("#seleccion-estudio", "precios_api", 7, 'ID_SERVICIO', 'ABREVIATURA.SERVICIO', {
      area_id: this.value,
      cliente_id: $('#seleccion-paquete').val()
    }, function (listaEstudios) {
      selectEstudio = new GuardarArreglo(listaEstudios);
    }); //Mandar cliente para lista personalizada
  } else {
    rellenarSelect("#seleccion-estudio", "precios_api", 7, 'ID_SERVICIO', 'ABREVIATURA.SERVICIO', {
      area_id: this.value,
      cliente_id: $('#seleccion-paquete').val()
    }, function (listaEstudios) {
      selectEstudio = new GuardarArreglo(listaEstudios);
    });
  }
});
//mosotrar datos ya registrados
$('#btn-info-detaelle-cotizacion').click(function () {
  // console.log(row2) OBSERVACIONES CREADO_POR CORREO
  $('#input-atencion-cortizaciones').val(row2['CREADO_POR'])
  $('#input-correo-cortizaciones').val(row2['CORREO'])
  $('#input-observaciones-cortizaciones').val(row2['OBSERVACIONES'])
})

$('#guardar-contenido-paquete').on('click', function () {

  let data = calcularFilasTR();
  // console.log(data);
  let dataAjax = data[0];
  let dataAjaxDetalleCotizacion = data[1];
  let tableData = tablaContenidoPaquete.rows().data().toArray();
  if (tableData.length > 0) {
    alertPassConfirm({
      title: 'Ingrese su contraseña para guardar la lista',
      text: 'Use su contraseña para confirmar',
      showCancelButton: true,
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
    }, async function () {
      let datajson = {
        api: 1,
        detalle: dataAjax,
        total: dataAjaxDetalleCotizacion['total'].toFixed(2),
        subtotal: dataAjaxDetalleCotizacion['subtotal'].toFixed(2),
        subtotal_sin_descuento: dataAjaxDetalleCotizacion['subtotal_sin_descuento'],
        iva: dataAjaxDetalleCotizacion['iva'].toFixed(2),
        descuento: dataAjaxDetalleCotizacion['descuento'],
        descuento_porcentaje: dataAjaxDetalleCotizacion['descuento_porcentaje'],
        cliente_id: dataAjaxDetalleCotizacion['cliente_id'],
        atencion: $('#input-atencion-cortizaciones').val(),
        correo: $('#input-correo-cortizaciones').val(),
        observaciones: $('#input-observaciones-cortizaciones').val()
      }

      if ($('input[type=radio][name=selectPaquete]:checked').val() == 2) {
        datajson['id_cotizacion'] = SelectedFolio;
      }

      let data = await ajaxAwait(datajson, 'cotizaciones_api')

      if (data) {
        tablaContenidoPaquete.clear().draw();
        dataEliminados = new Array();
        alertMsj({
          //${data.response.data}
          title: 'Cotización guardada',
          text: `Tu nuevo cotización ha sido guardada con el siguiente folio: ${data.response.data === '1' ? SelectedFolio : data.response.data}`,
          icon: 'success', showCancelButton: false, confirmButtonText: 'Confirmar', confirmButtonColor: 'green'
        })

        //borrar el div para que se vuelva a abrir
        datosUsuarioCotizacion.empty()

        // alertMensaje('success', 'Contenido registrado', 'El contenido se a registrado correctamente :)')
        $('#modalInfoDetalleCotizacion').modal('hide');
      }
    })
  } else {
    alertMensaje('error', '¡Faltan datos!', 'Necesita rellenar la tabla de estudios para continuar')
  }
})

function formpassword() {
  //No submit form with enter
}

$(document).on("change", "input[name='cantidad-paquete'], input[name='descuento-paquete'], #descuento-paquete", function () {
  calcularFilasTR()

  if ($(this).attr('id') == 'descuento-paquete') {
    if ($(this).val() > 0) {
      $('#precios-con-descuento').fadeIn();
    } else {
      $('#precios-con-descuento').fadeOut();
    }
  }
});

$('#seleccion-paquete').on('change', async function (e) {
  await rellenarSelect("#select-presupuestos", 'cotizaciones_api', 4, 'ID_COTIZACION', 'FOLIO_FECHA', {
    cliente_id: $('#seleccion-paquete').val()
  });
})


// Función que se ejecuta cuando se realiza una acción para obtener un nuevo PDF
function getNewView(url, filename) {
  // Destruir la instancia existente de AdobeDC.View
  // Crear una instancia inicial de AdobeDC.View
  let adobeDCView = new AdobeDC.View({ clientId: "cd0a5ec82af74d85b589bbb7f1175ce3", divId: "adobe-dc-view" });

  var nuevaURL = url;

  // Agregar un parámetro único a la URL para evitar la caché del navegador
  nuevaURL += "?timestamp=" + Date.now();

  // Cargar y mostrar el nuevo PDF en el visor
  adobeDCView.previewFile({
    content: { location: { url: nuevaURL } },
    metaData: { fileName: filename }
  });
}

$('#btn-vistaPrevia-cotizacion').click(function () {
  // Obtén los parámetros necesarios
  var area_nombre = 'cotizacion';
  var api = encodeURIComponent(window.btoa(area_nombre));
  var area = encodeURIComponent(window.btoa(15));
  var id_cotizacion = encodeURIComponent(window.btoa(SelectedFolio));





  // window.open(`${http}${servidor}/${appname}/visualizar_reporte/?api=${api}&id_cotizacion=${id_cotizacion}&area=${area}`, "_blank");

  // console.log(SelectedFolio)
  // Construye la vista y se almacena en la variable url
  var url = `${http}${servidor}/${appname}/visualizar_reporte/?api=${api}&area=${area}&id_cotizacion=${id_cotizacion}`;
  //Se manda la url y se agrega un titulo donde se cargara la vista del pdf
  getNewView(url, 'Vista prevía cotización')

  // Muestra el modal
  $('#modal-cotizacion').modal('show');
});


$('#btn-enviarCorreo-cotizaciones').click(function (e) {

  // alertMensaje('info', '¿Esta seguro que desea enviarlo?', `Se enviara a este correo ${SelectedFolio}`)
  alertMensajeConfirm({
    title: "¿Esta seguro que desea enviarlo?",
    text: `Se enviara a este correo ${row2['CORREO']}`,
    icon: "info",
  }, function () {
    console.log('Hola')
  }, 1)

})