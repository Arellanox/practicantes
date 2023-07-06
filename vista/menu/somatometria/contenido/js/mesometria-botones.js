$('#form-resultados-somatometria').submit(function (event) {
    event.preventDefault();
    var form = document.getElementById("form-resultados-somatometria");
    var formData = new FormData(form);
    formData.set('id_turno', turno)
    formData.set('api', 3);

    Swal.fire({
      title: "¿Está seguro que todos los datos están correctos?",
      text: "¡No podrá cambiar estos datos!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Aceptar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          data: formData,
          url: "../../../api/somatometria_api.php",
          type: "POST",
          processData: false,
          contentType: false,
          success: function (data) {
            data = jQuery.parseJSON(data);
            if (mensajeAjax(data)) {
              Toast.fire({
                icon: "success",
                title: "¡Signos vitales guardados!",
                timer: 2000,
              });
              document.getElementById("form-resultados-somatometria").reset();
              // $("#ModalRegistrarEquipo").modal("hide");
              // tablaEquipo.ajax.reload();
              // Aqui iniciar el siguiente turno y preguntar si lo desea liberar
            }
          },
        });

      }
    });
})

$('#omitir-paciente').click(function() {
  console.log(pacienteActual.array)
  pasarPacienteTurno(pacienteActual.array['ID_TURNO'], 2, 0, function() {
    console.log('EXITO')
  })
})