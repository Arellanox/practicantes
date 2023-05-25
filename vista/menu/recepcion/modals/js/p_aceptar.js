// Obtener datos del paciente seleccionado
var url_paciente = null,
  validarEstudiosLab = 0,
  validarEstudiosRX = 0,
  validarEstudiosImg = 0,
  validarEstudiosOtros = 0;
var estudiosEnviar = new Array();
const modalPacienteAceptar = document.getElementById('modalPacienteAceptar')
modalPacienteAceptar.addEventListener('show.bs.modal', event => {
  document.getElementById("title-paciente_aceptar").innerHTML = array_selected[1];
  // document.getElementById("btn-confirmar-paciente").disabled = true;

  // if (array_selected['CLIENTE_ID'] == 18) {
  //   $('#contenedor-pase-ujat').fadeIn(100);
  // } else {
  //   $('#pase-ujat').val(null)
  //   $('#contenedor-pase-ujat').fadeOut(100);
  // }
  array_selected['ALERGIAS'] ? $('#alergias-aceptar-paciente').val(array_selected['ALERGIAS']) : $('#alergias-aceptar-paciente').val('');
  array_selected['DIAGNOSTICO_TURNO'] ? $('#diagnostico-aceptar-paciente').val(array_selected['DIAGNOSTICO_TURNO']) : $('#diagnostico-aceptar-paciente').val('');


  rellenarSelect('#select-paquetes', 'paquetes_api', 2, 'ID_PAQUETE', 'DESCRIPCION', {
    'cliente_id': array_selected['CLIENTE_ID']
  })

  rellenarSelect('#select-segmento-aceptar', 'segmentos_api', 2, 0, 'DESCRIPCION', {
    cliente_id: array_selected['CLIENTE_ID']
  }, function (data) {
    array_selected['ID_SEGMENTO'] ? $('#select-segmento-aceptar').val(array_selected['ID_SEGMENTO']).trigger('change') : false;
  });

  //Pruebas
  rellenarSelect("#select-lab", "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
    id_area: 6,
    cliente_id: array_selected['CLIENTE_ID']
  }, function (data){
    const button = document.querySelector('#select2-select-lab-container');
    const tooltip = document.querySelector('#tooltip');
    popperHover(button, tooltip, function(event){
      if(event){
dataJSON = {
  api: 15
}
        let id = $('#select-lab').prop('selectedIndex');
data[id]['ES_GRUPO'] ? dataJSON['ID_SERVICIO'] : dataJSON['ID_GRUPO'];

        ajaxAwait(dataJSON, "servicios_api",{callbackAfter: true},false,function(data){
          
        })
      }
    })
  });
  rellenarSelect("#select-labbio", "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
    id_area: 12,
    cliente_id: array_selected['CLIENTE_ID']
  });
  rellenarSelect('#select-us', "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
    id_area: 11,
    cliente_id: array_selected['CLIENTE_ID']
  });
  rellenarSelect('#select-rx', "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
    id_area: 8,
    cliente_id: array_selected['CLIENTE_ID']
  });
  rellenarSelect('#select-otros', "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
    id_area: 0,
    cliente_id: array_selected['CLIENTE_ID'],
  });


  // rellenarSelect("#select-lab", "servicios_api", 7, 'ID_SERVICIO', 'ABREVIATURA.SERVICIO', {
  //   'area_id': 6,
  //   cliente_id: array_selected['CLIENTE_ID']
  // });
  // rellenarSelect('#select-us', "precios_api", 7, 'ID_SERVICIO', 'ABREVIATURA.SERVICIO', {
  //   'area_id': 7,
  //   cliente_id: array_selected['CLIENTE_ID']
  // });
  // rellenarSelect('#select-rx', "precios_api", 7, 'ID_SERVICIO', 'ABREVIATURA.SERVICIO', {
  //   'area_id': 8,
  //   cliente_id: array_selected['CLIENTE_ID']
  // });
  // rellenarSelect('#select-otros', "precios_api", 7, 'ID_SERVICIO', 'ABREVIATURA.SERVICIO', {
  //   area_id: 0,
  //   cliente_id: array_selected['CLIENTE_ID']
  // });

  // "#seleccion-estudio", "precios_api", 7, 0, 'ABREVIATURA.SERVICIO', {area_id : this.value, paquete_id: $('#seleccion-paquete').val()}
})

$("#btn-obtenerID").click(function () {
  var folder = "identificacion/";
  $.ajax({
    url: "../../../api/archivos/imagen_paciente.php",
    type: "POST",
    data: {
      api: 1
    },
    success: function (data) {
      data = jQuery.parseJSON(data);
      img = "identificacion/" + data[2];
      $("#image-perfil").attr("src", img);
      url_paciente = `https:bimo-lab.com/\${appname}/vista/menu/recepcion/identificacion/${data[2]}`;
      url_paciente = data;
      // document.getElementById("btn-confirmar-paciente").disabled = false;
    }
  });
})

$('#formAceptarPacienteRecepcion').submit(function (event) {

  event.preventDefault();

  var form = document.getElementById("formAceptarPacienteRecepcion");
  var formData = new FormData(form);
  formData.set('api', 2);
  formData.set('url', url_paciente);
  formData.set('id_turno', array_selected['ID_TURNO']);
  formData.set('estado', 1);
  formData.set('comentario_rechazo', $('#Observaciones-aceptar').val());
  formData.set('alergias', $('#alergias-aceptar-paciente').val());
  formData.set('diagnostico', $('#diagnostico-aceptar-paciente').val());
  formData.set('segmento_id', $('#select-segmento-aceptar').val())
  //Medico tratante
  formData.set('medico_tratante', $('#medico-aceptar-paciente').val());
  formData.set('medico_correo', $('#medico-correo-aceptar').val())


  formData.set('servicios', estudiosEnviar);


  if (!$('#checkPaqueteAceptar').is(":checked")) {
    formData.set('id_paquete', $('#select-paquetes').val());
  }

  // console.log(estudiosEnviar);
  // document.getElementById("btn-confirmar-paciente").disabled = true;
  $.ajax({
    url: "../../../api/recepcion_api.php",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function () {
      alertMensaje('info', 'Aceptando paciente', 'Espere un momento mientras el sistema carga al paciente')
    },
    success: function (data) {
      data = jQuery.parseJSON(data);
      console.log(data);
      if (true) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Turno: ' + data.response.data[1]['TURNO'],
          text: '¡Paciente aceptado! Recuerda generar sus documentos.',
          showCloseButton: false,
        })
        limpiarFormAceptar();
        $("#modalPacienteAceptar").modal("hide");
        tablaRecepcionPacientes.ajax.reload();
      }
    },
  });
  event.preventDefault();
})


function filtrarArray() {

}


$('#btn-AgregarEstudioLab').on('click', function () {
  let text = $("#select-lab option:selected").text();
  let id = $("#select-lab").val();
  validarEstudiosLab = 1;
  agregarFilaDiv('#list-estudios-laboratorio', text, id)
})
// Create an observer instance.
var Obserlab = new MutationObserver(function (mutations) {
  if ($('#list-estudios-laboratorio').children().length == 0 || array_selected['CLIENTE_ID'] != 1) {
    validarEstudiosLab = 0;
    // $('#file-laboratorio').prop('required', false);
  } else {
    // $('#file-laboratorio').prop('required', true);
  }
});
// Pass in the target node, as well as the observer options.
Obserlab.observe(document.querySelector('#list-estudios-laboratorio'), {
  attributes: true,
  childList: true,
  characterData: true
});



$('#btn-agregarEstudioRX').on('click', function () {
  let text = $("#select-rx option:selected").text();
  let id = $("#select-rx").val();
  agregarFilaDiv('#list-estudios-rx', text, id)
})
// Create an observer instance.
var ObserRX = new MutationObserver(function (mutations) {
  if ($('#list-estudios-rx').children().length == 0 || array_selected['CLIENTE_ID'] != 1) {
    validarEstudiosRX = 0;
    // $('#file-r-x').prop('required', false);
  } else {
    // $('#file-r-x').prop('required', true);
  }
});
// Pass in the target node, as well as the observer options.
ObserRX.observe(document.querySelector('#list-estudios-rx'), {
  attributes: true,
  childList: true,
  characterData: true
});



$('#btn-agregarEstudioImg').on('click', function () {
  let text = $("#select-us option:selected").text();
  let id = $("#select-us").val();
  agregarFilaDiv('#list-estudios-ultrasonido', text, id)
})
// Create an observer instance.
var ObserULTRSONIDO = new MutationObserver(function (mutations) {
  if ($('#list-estudios-ultrasonido').children().length == 0 || array_selected['CLIENTE_ID'] != 1) {
    validarEstudiosImg = 0;
    // $('#file-ultra-sonido').prop('required', false);
  } else {
    // $('#file-ultra-sonido').prop('required', true);
  }
});
// Pass in the target node, as well as the observer options.
ObserULTRSONIDO.observe(document.querySelector('#list-estudios-ultrasonido'), {
  attributes: true,
  childList: true,
  characterData: true
});



$('#btn-agregarEstudioOtros').on('click', function () {
  let text = $("#select-otros option:selected").text();
  let id = $("#select-otros").val();
  agregarFilaDiv('#list-estudios-otros', text, id)
})
// Create an observer instance.
var ObserOtros = new MutationObserver(function (mutations) {
  if ($('#list-estudios-otros').children().length == 0 || array_selected['CLIENTE_ID'] != 1) {
    validarEstudiosOtros = 0;
  }
});
// Pass in the target node, as well as the observer options.
ObserOtros.observe(document.querySelector('#list-estudios-otros'), {
  attributes: true,
  childList: true,
  characterData: true
});


$('#btn-AgregarEstudioLabBio').on('click', function () {
  let text = $("#select-labbio option:selected").text();
  let id = $("#select-labbio").val();
  agregarFilaDiv('#list-estudios-laboratorio-biomolecular', text, id)
})
// Create an observer instance.
var ObserOtros = new MutationObserver(function (mutations) {
  if ($('#list-estudios-laboratorio-biomolecular').children().length == 0 || array_selected['CLIENTE_ID'] != 1) {
    validarEstudiosOtros = 0;
  }
});
// Pass in the target node, as well as the observer options.
ObserOtros.observe(document.querySelector('#list-estudios-laboratorio-biomolecular'), {
  attributes: true,
  childList: true,
  characterData: true
});




function agregarFilaDiv(appendDiv, text, id) {
  estudiosEnviar.push(id)
  let html = '<li class="list-group-item">' +
    '<div class="row">' +
    '<div class="col-10 d-flex  align-items-center">' +
    text +
    '</div>' +
    '<div class="col-2">' +
    '<button type="button" class="btn btn-hover me-2 eliminarfilaEstudio" data-bs-id="' + id + '"> <i class="bi bi-trash"></i> </button>' +
    '</div>' +
    '</div>' +
    '</li>';
  $(appendDiv).append(html);
  // console.log(estudiosEnviar);
}

$(document).on('click', '.eliminarfilaEstudio', function () {
  let id = $(this).attr('data-bs-id');
  eliminarElementoArray(id);
  console.log(id);
  var parent_element = $(this).closest("li[class='list-group-item']");
  $(parent_element).remove()

});


function eliminarElementoArray(id) {
  estudiosEnviar = jQuery.grep(estudiosEnviar, function (value) {
    return value != id;
  });
  console.log(estudiosEnviar);
}



function limpiarFormAceptar() {
  $('#list-estudios-laboratorio').html('')
  $('#file-laboratorio').val('');
  validarEstudiosLab = 0;
  $('#list-estudios-rx').html('')
  $('#file-r-x').val('');
  validarEstudiosRX = 0;
  $('#list-estudios-ultrasonido').html('')
  $('#file-ultra-sonido').val('');
  validarEstudiosImg = 0;
  $('#list-estudios-otros').html('')
  validarEstudiosOtros = 0;
  $('#Observaciones-aceptar').val('')
  estudiosEnviar = [];
}




select2("#select-paquetes", "modalPacienteAceptar", 'Seleccione un paquete');
select2("#select-lab", "modalPacienteAceptar", 'Seleccione un estudio');
select2("#select-labbio", "modalPacienteAceptar", 'Seleccione un estudio');
select2("#select-rx", "modalPacienteAceptar", 'Seleccione un estudio');
select2("#select-us", "modalPacienteAceptar", 'Seleccione un estudio');
select2("#select-otros", "modalPacienteAceptar", 'Seleccione un estudio');
select2('#select-segmento-aceptar', "modalPacienteAceptar", 'Seleccione un segmento');