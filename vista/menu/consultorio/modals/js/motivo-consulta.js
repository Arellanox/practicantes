const modalMotivoConsulta = document.getElementById("modalMotivoConsulta");
modalMotivoConsulta.addEventListener("show.bs.modal", (event) => {

  rellenarSelect('#select-cita-subsecuente', 'consulta_api', 2, 'ID_CONSULTA', 'MOTIVO_CONSULTA', {
    id_paciente: pacienteActivo.array['ID_PACIENTE']
  }, function (array) {
    if (array.length == 0) {
      $('#select-cita-subsecuente').removeAttr('required');
      $('#select-cita-subsecuente').prop('disabled', true);
      $('#checkCitaSubsecuente').prop('checked', true);
    }
  })
});

select2('#select-cita-subsecuente', 'modalMotivoConsulta')

$('#formMotivoConsulta').submit(function (event) {
  event.preventDefault();
  var form = document.getElementById("formMotivoConsulta");
  var formData = new FormData(form);
  formData.set('turno_id', pacienteActivo.array['ID_TURNO'])
  formData.set('api', 1)
  Swal.fire({
    title: "¿Está seguro de continuar?",
    text: "¡No podrá cambiar la consulta!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
  }).then((result) => {
    if (result.isConfirmed) {
      // $('#submit-registrarEstudio').prop('disabled', true);
      // Esto va dentro del AJAX
      $.ajax({
        data: formData,
        url: "../../../api/consulta_api.php",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (data) {
          console.log(data);

          // Llamar la vista de consulta
          obtenerContenidoConsulta(pacienteActivo.array, data['response']['data'])
          document.getElementById("formMotivoConsulta").reset();
          $("#modalMotivoConsulta").modal("hide");

          $('#select-cita-subsecuente').prop('required', true);
          $('#select-cita-subsecuente').prop('disabled', false);
          $('#checkCitaSubsecuente').prop('checked', false);
        },
      });
    }
  });
})

$('#checkCitaSubsecuente').change(function () {
  if ($(this).is(":checked")) {
    $('#select-cita-subsecuente').removeAttr('required');
    $('#select-cita-subsecuente').prop('disabled', true);
  } else {
    $('#select-cita-subsecuente').prop('required', true);
    $('#select-cita-subsecuente').prop('disabled', false);
    $('#select-cita-subsecuente').focus();
  }
})