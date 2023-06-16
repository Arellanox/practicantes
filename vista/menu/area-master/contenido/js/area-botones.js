$('#fechaListadoAreaMaster').change(function () {
  console.log(1)
  recargarVistaLab();
})

$('#checkDiaAnalisis').click(function () {
  console.log(1)
  if ($(this).is(':checked')) {
    recargarVistaLab(0)
    $('#fechaListadoAreaMaster').prop('disabled', true)
  } else {
    recargarVistaLab();
    $('#fechaListadoAreaMaster').prop('disabled', false)
  }
})

function recargarVistaLab(fecha = 1) {
  dataListaPaciente = {
    api: 5,
    // fecha_busqueda: $('#fechaListadoAreaMaster').val(),
    area_id: areaActiva
  }

  if (fecha) dataListaPaciente['fecha_busqueda'] = $('#fechaListadoAreaMaster').val();

  tablaContenido.ajax.reload()
}


$("#btn-analisis-pdf").click(function () {
  if (dataSelect.array['select']) {
    // $("#ModalSubirInterpretacion").modal("show");
    chooseEstudio(selectEstudio.array, '#ModalSubirInterpretacion', 1)
  } else {
    alertSelectTable();
  }
});

$(document).on('click', '#btn-captura-inbody', function (e) {
  if (dataSelect.array) {
    $('#ModalInterpretacionInbody').modal('show');
  } else {
    alertSelectTable();
  }
})

$(document).on('click', '#btn-modalView-nutricion', function (e) {
  if (dataSelect.array) {
    $('#ModalViewInbody').modal('show');
  } else {
    alertSelectTable();
  }
})


$(document).on('click', '#btn-capturas-pdf', function () {
  if (dataSelect.array['select']) {
    // $("#ModalSubirCapturas").modal("show");
    switch (areaActiva) {
      case 10:
        $('#MostrarCapturasElectro').modal('show');
        break;

      case 13:
        servicio_nombre = 'Citología'; // <--Nombrar la ventana
        $("#ModalSubirCapturas").modal("show");
        break;
      default:
        chooseEstudio(selectEstudio.array, '#ModalSubirCapturas', 2)
        break;
    }
  } else {
    alertSelectTable();
  }
})

// $('').click(function () {

// })

$('#btn-analisis-oftalmo').click(function () {
  if (dataSelect.array['select']) {

    $("#ModalSubirInterpretacionOftalmologia").modal("show");
  } else {
    alertSelectTable();
  }
})


$('#abrirModalResultados').click(function () {
  // alert('Si')
  autosize(document.querySelectorAll('textarea'))
  setTimeout(() => {
    autosize.update(document.querySelectorAll('textarea'));
  }, 200);
  

  $('#modalSubirInterpretacion').modal('show')
})

//BTN PARA SUBIR LOS DATOS DE ESPIROMETRIA 

$('#btn-resultados-espiro-pdf').click(function () { 

  $('#ModalSubirResultadosEspiro').modal('show');

})



$('#btn-ver-reporte').click(function () {
  switch (areaActiva) {
    case 3: case '3':
      area_nombre = 'oftalmo'
      break;
    case 8: case 11: case '8': case '11':
      area_nombre = 'imagenologia'
      break;
    case 10: case '10':
      area_nombre = 'electro'
      break;
    case 5: case '5':
      area_nombre = 'espiro'
      break;

    default:
      break;
  }

  api = encodeURIComponent(window.btoa(area_nombre));
  turno = encodeURIComponent(window.btoa(dataSelect.array['turno']));
  area = encodeURIComponent(window.btoa(areaActiva));


  window.open(`${http}${servidor}/${appname}/visualizar_reporte/?api=${api}&turno=${turno}&area=${area}`, "_blank");
})

function chooseEstudio(row, modal, tip) {
  let html = '';

  console.log(row)
  switch (tip) {
    case 1:
      return false
      for (var i = 0; i < row.length; i++) {
        if (row[i]['INTERPRETACION'] == null) {
          html += `<button class="btn btn-cancelar" onClick = "estudioSeleccionado(` + row[i]['ID_SERVICIO'] + `, '` + modal + `')" type="button">` + row[i]['SERVICIO'] + `</button>`;
        }
      }
      if (html) {
        Swal.fire({
          html: '<h4>Seleccione el estudio a guardar</h4>' +
            '<div class="d-grid gap-2">' + html + '</div>',
          showCloseButton: true,
          showConfirmButton: false,
        });
      } else {
        alertSelectTable('Se han guardado todas sus interpretaciones')
      }
      break;
    case 2:
      for (var i = 0; i < row.length; i++) {
        try {
          if (row[i]['CAPTURAS'].length == 0) {
            html += `<button class="btn btn-cancelar" onClick = "estudioSeleccionado(` + row[i]['ID_SERVICIO'] + `, '` + modal + `', '` + row[i]['SERVICIO'] + `')" type="button">` + row[i]['SERVICIO'] + `</button>`;
          }
        } catch (error) {
          // alertMensaje('error', 'Oops...', 'Hubo un error con las capturas, intentelo mas tarde', 'Reporte este mensaje a la area de TI : )')
        }
      }
      if (html) {
        Swal.fire({
          html: '<h4>Seleccione el estudio a capturar</h4>' +
            '<div class="d-grid gap-2">' + html + '</div>',
          showCloseButton: true,
          showConfirmButton: false,
        });
      } else {
        alertSelectTable('Se han guardado todas sus capturas', 'success')
      }
      break;
    default:

  }

}

function estudioSeleccionado(id, modal, serv) {
  selectEstudio.selectID = id;
  Swal.close();
  // console.log(selectEstudio.selectID)
  servicio_nombre = serv;
  $(modal).modal("show");
}
