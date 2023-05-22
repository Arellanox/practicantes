
const ModalSubirCapturas = document.getElementById('ModalSubirCapturas')
ModalSubirCapturas.addEventListener('show.bs.modal', event => {
  // console.log(selectListaLab)
  $('#Area-estudio').html('Cargar capturas <strong id="Area-estudio"  style = "color:white !important" >' + servicio_nombre + ' (' + hash + ')</strong >')
  document.getElementById("formSubirCapturas").reset();
  // alert(selectEstudio.selectID)
  //Modals
  $('#nombre-paciente-capturas').val(dataSelect.array['nombre_paciente'])
})

$('#inputFilesCapturasArea').on('change', function () {
  // var fileList = $(this)[0].files || [] //registra todos los archivos
  // let aviso = 0;
  // for (file of fileList) { //una iteración de toda la vida
  //   ext = file.name.split('.').pop()
  //   console.log('>ARCHIVO: ', file.name)
  //   switch (ext) {
  //     case 'png': case 'jpg': case 'jpeg': case 'pdf':
  //       console.log('>>TIPO DE ARCHIVO CORRECTO: ')
  //       break;
  //     default:
  //       aviso = 1;
  //       console.log('>>TIPO DE ARCHIVO INCORRECTO', ext)
  //       break;
  //   }
  // }
  // if (aviso == 1) {
  //   $(this).val('')
  //   alertMensaje('error', 'Archivo incorrecto', 'Algunos archivos no son correctos')
  // }
});

//Formulario Para Subir Interpretacion
$("#formSubirCapturas").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  var form = document.getElementById("formSubirCapturas");
  var formData = new FormData(form);
  formData.set('turno_id', dataSelect.array['turno'])
  formData.set('servicio_id', selectEstudio.selectID)
  formData.set('nombre_servicio', servicio_nombre)
  formData.set('api', api_capturas);
  Swal.fire({
    title: "¿Está seguro de cargar las capturas correctas?",
    text: "¡No podrá cambiar esto!",
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
        url: `${http}${servidor}/${appname}/api/${url_api}.php`,
        type: "POST",
        processData: false,
        contentType: false,
        beforeSend: function () {
          $("#formSubirCapturas:submit").prop('disabled', true)
          alertMensaje('info', 'Subiendo capturas', 'Por favor espere un momento')
        },
        success: function (data) {
          data = jQuery.parseJSON(data);
          if (mensajeAjax(data)) {
            alertMensaje('success', '¡Capturas guardadas!', 'Las capturas han sido guardadas, podrás visualizarlo en los detalle del paciente')
            // tablaContenido.ajax.reload()
            document.getElementById("formSubirCapturas").reset();
            $("#ModalSubirCapturas").modal("hide");
            obtenerServicios(areaActiva, dataSelect.array['turno'])
            // $("#formSubirCapturas:submit").prop('disabled', false)
            // limpiarCampos()
            // tablaContacto.ajax.reload();
          }
        },
        complete: function () {
          $("#formSubirCapturas:submit").prop('disabled', false)
        }
      });
    }
  });
  event.preventDefault();
});
