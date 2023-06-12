//Enviar solicitud
$("#formEnviarCorreoIngreso").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  Swal.fire({
    title: '¿Está seguro de enviar la solicitud de pre-registro a este correo?',
    text: "No se podrán deshacer cambios",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, colocarlo en espera',
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {

      //Desabilitamos el boton despues de confirmar la solicitud de pre-registro  
      $('#btn-correo-enviar').prop('disabled', true);

      // Esto va dentro del AJAX
      ajaxAwaitFormData({
        api: 1
      }, 'preregistro_correo_token_api', 'formEnviarCorreoIngreso', { callbackAfter: true, resetForm: true }, false, (data) => {

        alertMensaje('info', '¡Solicitud enviada!', 'Se ha enviado el token de acceso para registrarse.');
        $("#modalSolicitudIngresoParticulares").modal("hide");

        $('#btn-correo-enviar').prop('disabled', false);


      })
    }
  })
  event.preventDefault();
});


//FUNCION PARA MOSTRAR TODOS LOS CUESTIONARIOS
$('#solicitudIngresoParticulares').click(function () {
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
              id="${element.DESCRIPCION}${element.ID_CUESTIONARIO}" name="cuestionarios[]">
            <label class="form-check-label" for="${element.DESCRIPCION}${element.ID_CUESTIONARIO}">${element.DESCRIPCION}</label>
          </div>
        `;

        $('#lista_cuestionarios').html(htmlContent);

      }
    }
  })
})
