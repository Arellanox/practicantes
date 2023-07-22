select2('#seleccion-paquete', 'form-select-paquetes')
select2('#seleccion-estudio', 'form-select-paquetes')
select2('#select-presupuestos', 'form-select-paquetes')

//Declarar variable para la clase
var selectEstudio;

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

$('#UsarPaquete').on('click', function () {

  if ($('input[type=radio][name=selectPaquete]:checked').val() == 2) {
    if (!$('#select-presupuestos').val()) {
      alertToast('Necesitas seleccionar un presupuesto de este cliente', 'error', '5000')
      return false;
    }
  }

  let id_cotizacion = $('#select-presupuestos').val();

  $('#select-presupuestos').prop('disabled', true);
  $("#selectDisabled").addClass("disable-element");
  // $('.formContenidoPaquete').prop('disabled', false);
  $("#formPaqueteBotonesArea").removeClass("disable-element");
  $("#formPaqueteSelectEstudio").removeClass("disable-element");
  $("#informacionPaquete").removeClass("disable-element");




  switch ($('input[type=radio][name=selectPaquete]:checked').val()) {
    case '2': //Lista de precios para clientes
      tablaContenido(true);
      $.ajax({
        url: `${http}${servidor}/${appname}/api/cotizaciones_api.php`,
        type: "POST",
        dataType: 'json',
        data: {
          id_cotizacion: id_cotizacion,
          api: 2
        },
        success: function (data) {
          // console.log(data);
          row = data.response.data;
          for (var i = 0; i < row.length; i++) {
            meterDato(row[i]['SERVICIO'], row[i].ABREVIATURA, row[i].COSTO_UNITARIO, row[i].COSTO_TOTAL, row[i].CANTIDAD, null, row[i].ID_SERVICIO, row[i].ABREVIATURA, tablaContenidoPaquete)
          }
        }
      })
      break;
  }
})
//
$('#CambiarPaquete').on('click', function () {
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

$('#guardar-contenido-paquete').on('click', function () {
  let data = calcularFilasTR();
  // console.log(data);
  let dataAjax = data[0];
  let dataAjaxDetalleCotizacion = data[1];
  let tableData = tablaContenidoPaquete.rows().data().toArray();
  if (tableData.length > 0) {
    alertMensajeFormConfirm({
      title: 'Ingrese su contraseña para guardar la lista',
      text: 'Use su contraseña para confirmar',
      showCancelButton: true,
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
    }, 'usuarios_api', 9, 'password', async function () {
      let data = await ajaxAwait({
        api: 1,
        detalle: dataAjax,
        total: dataAjaxDetalleCotizacion['total'].toFixed(2),
        subtotal: dataAjaxDetalleCotizacion['subtotal'].toFixed(2),
        iva: dataAjaxDetalleCotizacion['iva'].toFixed(2),
        descuento: dataAjaxDetalleCotizacion['descuento'],
        descuento_porcentaje: dataAjaxDetalleCotizacion['descuento_porcentaje'],
        cliente_id: dataAjaxDetalleCotizacion['cliente_id'],
        atencion: $('#input-atencion-cortizaciones').val(),
        correo: $('#input-correo-cortizaciones').val(),
        observaciones: $('#input-observaciones-cortizaciones').val()
      }, 'cotizaciones_api')

      if (data) {
        tablaContenidoPaquete.clear().draw();
        dataEliminados = new Array()
        alertMensaje('success', 'Contenido registrado', 'El contenido se a registrado correctamente :)')
      }
    }, 1)
  } else {
    alertMensaje('error', '¡Faltan datos!', 'Necesita rellenar la tabla de estudios para continuar')
  }
})

function formpassword() {
  //No submit form with enter
}

$(document).on("change ,  keyup", "input[name='cantidad-paquete'], input[name='descuento-paquete'], #descuento-paquete", function () {
  calcularFilasTR()

  if ($(this).attr('id') == 'descuento-paquete') {
    if ($(this).val() > 0) {
      $('#precios-con-descuento').fadeIn();
    } else {
      $('#precios-con-descuento').fadeOut();
    }
  }
});

$(document).on('change', '#seleccion-paquete', async function (e) {
  await rellenarSelect("#select-presupuestos", 'cotizaciones_api', 4, 'ID_COTIZACION', 'FOLIO_COTIZACIONES.CLIENTE', {
    cliente_id: $('#seleccion-paquete').val()
  });

})