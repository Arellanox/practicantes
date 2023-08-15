//Enviar solicitud
$("#formEnviarCorreoIngreso").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  Swal.fire({
    title: '¿Está seguro de enviar crear la solicitud de ingreso a este correo?',
    text: "No se podrán deshacer cambios",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, colocarlo en espera',
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      // Esto va dentro del AJAX
      ajaxAwaitFormData({
        api: 1
      }, 'preregistro_correo_token_api', 'formEnviarCorreoIngreso', { callbackAfter: true, resetForm: true }, false, (data) => {

        alertMensaje('info', '¡Solicitud enviada!', 'Se ha enviado el token de acceso para registrarse.');
        $("#modalSolicitudIngresoParticulares").modal("hide");

        $('#btn-correo-enviar').prop('disabled', false);


      })
      // $.ajax({
      //   data: {
      //     api: 1, //Prueba
      //     correo: $('#inputURLSolicitudCorreo').val(),
      //     cuestionario : hola
      //   },
      //   url: "../../../api/preregistro_correo_token_api.php", //URL prueba
      //   type: "POST",
      //   beforeSend: function () {
      //     document.getElementById("btn-rechazar-paciente").disabled = true;
      //   },
      //   success: function (data) {
      //     data = jQuery.parseJSON(data);
      //     if (mensajeAjax(data)) {
      //       alertMensaje('info', '¡Solicitud enviada!', 'Se ha enviado el token de acceso para registrarse.');
      //       document.getElementById("btn-rechazar-paciente").disabled = false;
      //       $("#modalSolicitudIngresoParticulares").modal("hide");
      //       tablaRecepcionPacientesIngrersados.ajax.reload();
      //     }
      //   }
      // });
    }
  })
  event.preventDefault();
});


//FUNCION PARA MOSTRAR TODOS LOS CUESTIONARIOS
$(document).on('click', '#solicitudIngresoParticulares', function () {
  ajaxAwait({
    api: 12,
  }, 'recepcion_api', { callbackAfter: true, returnData: false }, false, function (data) {


    let row = data.response.data;
    let htmlContent = ''
    for (const key in row) {
      if (Object.hasOwnProperty.call(row, key)) {
        const element = row[key];

        htmlContent += ` 
          <div>
            <input class="form-check-input" type="checkbox" value="${element.ID_CUESTIONARIO}"
              id="${element.DESCRIPCION}${element.ID_CUESTIONARIO}" name="cuestionario[]">
            <label class="form-check-label" for="${element.DESCRIPCION}${element.ID_CUESTIONARIO}">${element.DESCRIPCION}</label>
          </div>
        `;

        $('#lista_cuestionarios').html(htmlContent);

      }
    }
  })
})
