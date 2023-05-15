// Obtener datos del paciente seleccionado
const modalPacienteRechazar = document.getElementById('modalPacienteRechazar')
modalPacienteRechazar.addEventListener('show.bs.modal', event => {
  document.getElementById("title-paciente_rechazar").innerHTML = "Rechazar al paciente:<br />" + array_selected['NOMBRE_COMPLETO'];

})


//Rechazados
$("#formRechazarPaciente").submit(function (event) {
  event.preventDefault();
  document.getElementById("btn-rechazar-paciente").disabled = true;
  /*DATOS Y VALIDACION DEL REGISTRO*/
  $.ajax({
    data: {
      api: 2,
      estado: 0,
      comentario_rechazo: $('#textarea-Comentario-rechazar').val(),
      id_turno: array_selected['ID_TURNO']
    },
    url: "../../../api/recepcion_api.php",
    type: "POST",
    success: function (data) {
      data = jQuery.parseJSON(data);
      if (mensajeAjax(data)) {
        alertMensaje('info', '¡Paciente rechazado!', 'El paciente está en la lista de rechazados.');
        document.getElementById("btn-rechazar-paciente").disabled = false;
        $("#modalPacienteRechazar").modal("hide");
        tablaRecepcionPacientes.ajax.reload();
      }
    }
  });
  event.preventDefault();
});
