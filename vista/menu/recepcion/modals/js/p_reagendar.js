// Obtener datos del paciente seleccionado
const modalPacienteReagendar = document.getElementById('modalPacienteReagendar')
modalPacienteReagendar.addEventListener('show.bs.modal', event => {
  document.getElementById("title-paciente_agendar").innerHTML = "Re-agendar al paciente:<br />" + array_selected['NOMBRE_COMPLETO'];

})

//Rechazados
$("#formReagendarPaciente").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  Swal.fire({
    title: '¿Está seguro que desea cambiar agendar el paciente a otro dia?',
    text: "Se agenderá a la fecha indicada",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      // Esto va dentro del AJAX
      $.ajax({
        data: {
          api: 3,
          fecha_reagenda: $('#fecha-reagenda').val(),
          id_turno: array_selected['ID_TURNO']
        },
        url: "../../../api/recepcion_api.php",
        type: "POST",
        beforeSend: function () {
          document.getElementById("btn-agendar-paciente").disabled = true;
        },
        success: function (data) {
          data = jQuery.parseJSON(data);
          if (mensajeAjax(data)) {
            alertMensaje('info', '¡Paciente re-agendado!', 'Se ha modificado la fecha de su cita.');
            document.getElementById("btn-agendar-paciente").disabled = false;
            $("#modalPacienteReagendar").modal("hide");
            tablaRecepcionPacientesIngrersados.ajax.reload();
          }
        }
      });
    }
  })
  event.preventDefault();
});