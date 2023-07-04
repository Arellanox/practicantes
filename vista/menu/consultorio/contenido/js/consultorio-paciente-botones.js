$('#agregar-nota-historial').on('click', function () {
  var event = new Date();
  var options = {
    hours: 'numeric',
    minutes: 'numeric',
    weekday: 'long',
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  };

  $.ajax({
    url: `${http}${servidor}/${appname}/api/notas_historia_api.php`,
    type: "POST",
    dataType: "json",
    data: {
      api: 1,
      id_turno: pacienteActivo.array['ID_TURNO'],
      notas: $('#nota-historial-paciente').val()
    },
    success: function (data) {
      if (mensajeAjax(data)) {
        // console.log(data);
        agregarNotaConsulta(session.nombre + " " + session.apellidos, event.toLocaleDateString('es-ES', options), $('#nota-historial-paciente').val(), '#notas-historial', data.response.data, 'eliminarNota');
      }
    }
  });
})

$(document).on('click', '.eliminarNota', function () {
  let id = $(this).attr('data-bs-id');
  let button = $(this);
  button.prop('disabled', true);
  $.ajax({
    url: `${http}${servidor}/${appname}/api/notas_historia_api.php`,
    type: "POST",
    dataType: "json",
    data: {
      api: 4,
      id_nota: id,
    },
    success: function (data) {
      if (mensajeAjax(data)) {
        button.prop("disabled", false)
        $('#nota-historial-paciente').val('')
        var parent_element = button.closest("div");
        $(parent_element).remove()
      }
    }
  });
});

$('#btn-regresar-vista').click(function () {
  alertMensajeConfirm({
    title: "¿Está seguro de regresar?",
    text: "Asegurese de guardar los cambios",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }, function () {
    obtenerConsultorioMain();
  })
})


// $('.').on
$(document).on('click', '.guardarAnt ', function (event) {
  event.stopPropagation();
  event.stopImmediatePropagation();
  button = $(this)
  button.prop('disabled', true);
  var parent_element = button.closest("form").attr('id');
  // console.log(parent_element);
  let formData = new FormData(document.getElementById(parent_element));
  // console.log(formData);
  formData.set('api', 16);
  formData.set('turno_id', pacienteActivo.array['ID_TURNO']);

  $.ajax({
    data: formData,
    url: `${http}${servidor}/${appname}/api/consulta_api.php`,
    type: "POST",
    processData: false,
    contentType: false,
    dataType: 'json',
    beforeSend: function () {
      // alert('Enviando')
      alertToast('Guardando...', 'info')
    },
    success: function (data) {
      button.prop('disabled', false);
      alertToast('Guardado con exito', 'success');
    },
  });
  // eliminarElementoArray(id);
  // console.log(id);

});

//botones de pdf de vista previa
//vista previa de recetas
$('#btn-ver-receta-consultorio2').click(function () {
  area_nombre = 'receta'

  api = encodeURIComponent(window.btoa(area_nombre));
  turno = encodeURIComponent(window.btoa(pacienteActivo.array['ID_TURNO']));
  area = encodeURIComponent(window.btoa(-2));


  window.open(`${http}${servidor}/${appname}/visualizar_reporte/?api=${api}&turno=${turno}&area=${area}`, "_blank");
})



//
// <div id="notas-historial" class="mt-3">
//   <h4 class="m-3">INGLES: </h4>
//   <div style="margin: -1px 30px 20px 30px;">
//     <p class="none-p"><p>
//   </div>
// </div>
//
// <div id="notas-historial" class="card mt-3">
//   <h4 class="m-3">@Usuario actual <p style="font-size: 14px;margin-left: 5px;">xx:xx Septiembre dia, año</p></h4>
//   <div style="margin: -1px 30px 20px 30px;">
//     <p class="none-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
//   </div>
// </div>