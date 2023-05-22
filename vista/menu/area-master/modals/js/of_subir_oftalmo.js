// const ModalSubirInterpretacionOftalmologia = document.getElementById('ModalSubirInterpretacionOftalmologia')
// ModalSubirInterpretacionOftalmologia.addEventListener('show.bs.modal', event => {
//   // console.log(selectListaLab)
//   $('#Area-estudio').html(hash)
//   $('#nombre-paciente-interpretacion').val(selectPacienteArea['NOMBRE_COMPLETO'])
// })

//Formulario Para Subir Interpretacion
$("#formSubirInterpretacionOftalmo").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  var form = document.getElementById("formSubirInterpretacionOftalmo");
  var formData = new FormData(form);
  formData.set('turno_id', dataSelect.array['turno'])
  formData.set('api', 1);
  alertMensajeConfirm({
    title: "¿Está seguro guardar la interpretación?",
    text: "Una vez guardado, podrá visualizar el reporte",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
  }, function () {
    // $('#submit-registrarEstudio').prop('disabled', true);
    // Esto va dentro del AJAX
    $.ajax({
      data: formData,
      url: `${http}${servidor}/${appname}/api/oftalmologia_api.php`,
      type: "POST",
      processData: false,
      contentType: false,
      beforeSend: function () {
        $("#formSubirInterpretacion:submit").prop('disabled', true)
        alertMensaje('info', 'Subiendo información', 'Espere un momento mientras se guarda la información')
      },
      success: function (data) {
        data = jQuery.parseJSON(data);
        if (mensajeAjax(data)) {
          alertMensaje('success', 'Interpretación guardada', 'Ya puede visualizar el reporte', 'Es necesario confirmar la interpretación');
          estadoFormulario(2)
          obtenerServicios(3)
        }
      },
    });
  })
  event.preventDefault();
});


//Confirmacion de reporte
$('#btn-confirmar-reporte').click(function (event) {
  // alert(areaActiva)
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  if (confirmado != 1 || session.permisos['Actualizar reportes'] == 1) {

    alertMensajeConfirm({
      title: "¿Está seguro de confirmar este reporte?",
      text: "¡No podrá actualizar los datos de reporte!",
      icon: "warning",
    }, function () {
      $.ajax({
        data: {
          id_area: areaActiva,
          api: api_interpretacion,
          turno_id: dataSelect.array['turno'],
          confirmado: 1
        },
        url: `${http}${servidor}/${appname}/api/oftalmologia_api.php`,
        type: "POST",
        beforeSend: function () {
          $("#formSubirInterpretacion:submit").prop('disabled', true)
          alertMensaje('info', 'Confirmando reporte', 'Espere un momento mientras se genera el reporte en el sistema');
        },
        success: function (data) {
          data = jQuery.parseJSON(data);
          if (mensajeAjax(data)) {
            alertMensaje('success', '¡Interpretación confirmada!', 'El formulario ha sido cerrado');
            $('#modalSubirInterpretacion').modal('hide')
            estadoFormulario(1)
            obtenerServicios(areaActiva, dataSelect.array['turno'])
          }
        },
        complete: function () {
          $("#formSubirInterpretacion:submit").prop('disabled', false)
        }
      });
    }, 1)
  } else {
    alertMensaje('info', 'EL resultado ya ha sido guardado', 'No puede cargar mas resultados a este paciente');
  }
  event.preventDefault();
})