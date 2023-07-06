$('#btn-consulta-terminar').click(function () {
  let button = $(this)
  alertMensajeConfirm({
    title: "¿Está seguro de terminar la consulta?",
    text: "Ya no podrá hacer cambios con la consulta",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }, function () {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/consulta_api.php`,
      method: 'POST',
      dataType: 'json',
      beforeSend: function () {
        button.prop('disabled', true)
      },
      data: {
        api: 11,
        id_consulta: pacienteActivo.selectID
      },
      success: function (data) {
        if (mensajeAjax(data)) {
          button.prop('disabled', false)
          alertMensaje('info', 'La consulta ha sido cerrada', 'Podrá consultar la información del paciente desde el menú :)')
          obtenerContenidoAntecedentes(pacienteActivo.array)
        }
      },
      complete: function () {

      }

    })
  })
})

$('#btn-ver-reporte').click(function () {
  area_nombre = 'consultorio'

  api = encodeURIComponent(window.btoa(area_nombre));
  turno = encodeURIComponent(window.btoa(pacienteActivo.array['ID_TURNO']));
  area = encodeURIComponent(window.btoa(1));


  window.open(`${http}${servidor}/${appname}/visualizar_reporte/?api=${api}&turno=${turno}&area=${area}`, "_blank");
})



//Regresar a perfil de paciente
$('#btn-regresar-vista').click(function () {
  alertMensajeConfirm({
    title: "¿Está seguro de regresar?",
    text: "¡Asegurese de guardar los cambios!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }, function () {
    obtenerContenidoAntecedentes(pacienteActivo.array)
  })
})


// Exploracion clinica
$('#btn-agregar-exploracion-clinina').on('click', function () {
  let titulo = $('#select-exploracion-clinica option').filter(':selected').text();
  $.ajax({
    data: {
      turno_id: pacienteActivo.array['ID_TURNO'],
      exploracion_tipo_id: $('#select-exploracion-clinica').val(),
      exploracion: $('#text-exploracion-clinica').val(),
      api: 6
    },
    url: "../../../api/consulta_api.php",
    type: "POST",
    dataType: "json",
    success: function (data) {
      // alert("antes de la nota")
      agregarNotaConsulta(titulo, null, $('#text-exploracion-clinica').val(), '#notas-historial-consultorio', data.response.data, 'eliminarExploracion')
      $('#text-exploracion-clinica').val('')
      // alert("despues de la nota")
    },
  });
})
//Eliminar los comentario 
$(document).on('click', '.eliminarExploracion', function () {
  let id = $(this).attr('data-bs-id');
  let comentario = $(this);

  alertMensajeConfirm({
    title: "¿Está seguro de eliminar este registro?",
    text: "¡No podrá revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    cancelButtonColor: "#3085d6",
    confirmButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }, function () {
    $.ajax({
      data: {
        id_exploracion_clinica: id,
        api: 7
      },
      url: "../../../api/consulta_api.php",
      type: "POST",
      success: function (data) {
        // alert("antes de la nota")
        // if (mensajeAjax(data)) {
        var parent_element = $(comentario).closest("div[class='card mt-3']");
        console.log(parent_element)
        $(parent_element).remove()
        // }

        // alert("despues de la nota")
      },
    });
  })
  // eliminarElementoArray(id);
  // console.log(id);
});




// Odontograma
$('#formAgregarOdontograma').submit(function (event) {
  event.preventDefault();
  let button = $('#btn-guardar-Receta')
  button.prop('disabled', true)
  let form = document.getElementById("formAgregarOdontograma");
  let formData = new FormData(form)
  formData.set('turno_id', pacienteActivo.array['ID_TURNO'])
  formData.set('api', 18)
  console.log(formData)
  $.ajax({
    data: formData,
    dataType: 'json',
    processData: false,
    type: "POST",
    contentType: false,
    url: `${http}${servidor}/${appname}/api/consulta_api.php`,
    success: function (data) {
      // alert("antes de la nota")
      console.log(data);
      document.getElementById("formAgregarOdontograma").reset();
      button.prop('disabled', false)
      tablaOdontograma.ajax.reload()
      // alert("despues de la nota")
    },
  });
})
//Eliminar odontograma
$(document).on('click', '.eliminarOdontograma', function () {
  // alert(1);
  // event.stopPropagation();
  // event.stopImmediatePropagation();
  let id = $(this).attr('data-bs-id');
  let button = $(this);
  // alert(id);
  alertMensajeConfirm({
    title: "¿Está seguro de eliminar este registro?",
    text: "¡No podrá regresar los cambios!",
    icon: "warning",
    showCancelButton: true,
    cancelButtonColor: "#3085d6",
    confirmButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
  }, function () {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/consulta_api.php`,
      method: 'POST',
      dataType: 'json',
      data: {
        api: 20,
        id_odontograma: id
      },
      beforeSend: function () {
        button.prop('disabled', true)
      },
      success: function (data) {
        if (mensajeAjax(data)) {
          button.prop('disabled', false)

          // alertMensaje('info', 'Eliminado', 'ELIMINADO')
          alertToast('Odontograma elimando', 'success')
          tablaOdontograma.ajax.reload()
        }
      }

    })
  })
})








//Guardar antecedentes
$(document).on('click', '.guardarAnamn ', function (event) {
  event.stopPropagation();
  event.stopImmediatePropagation();
  button = $(this)
  button.prop('disabled', true);
  var parent_element = button.closest("form").attr('id');
  console.log(parent_element);
  let formData = new FormData(document.getElementById(parent_element));
  // console.log(formData);
  formData.set('api', 8);
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


// //Agegar form para receta
// $('#btn-agregar-medicamento-receta').click(function () {
//   nuevoMedicamentoReceta("#recetas-medicamentos")
//     // $id_receta,
//   // $turno_id,
//   // $nombre_generico,
//   // $forma_farmaceutica,
//   // $dosis,
//   // $presentacion,
//   // $frecuencia,
//   // $via_de_administracion,
//   // $duracion_del_tratamiento,
//   // $indicaciones_para_el_uso
// })
//Eliminar los campos 
// $(document).on('click', '.eliminarRecetaActual', function () {
//   let id = $(this).attr('data-bs-id');


//   var parent_element = $(this).closest("div[class='col-12 d-flex justify-content-end']");
//   $(parent_element).remove()

// });

//Guardar receta 
$('#formNuevaReceta').submit(function (event) {
  event.preventDefault();
  let button = $('#btn-guardar-Receta')
  button.prop('disabled', true)
  let form = document.getElementById("formNuevaReceta");
  let formData = new FormData(form)
  formData.set('api', 9)
  formData.set('turno_id', pacienteActivo.array['ID_TURNO'])
  $.ajax({
    url: `${http}${servidor}/${appname}/api/consulta_api.php`,
    method: 'POST',
    dataType: 'json',
    processData: false,
    contentType: false,
    data: formData,
    success: function (data) {
      console.log(data);
      button.prop('disabled', false)
      document.getElementById("formNuevaReceta").reset();
      tablaRecetas.ajax.reload()
    }
  })
})
//Eliminar receta registro
$(document).on('click', '.eliminarRecetaTabla', function () {
  let id = $(this).attr('data-bs-id');
  let button = $(this);
  // alert(id);
  alertMensajeConfirm({
    title: "¿Está seguro de eliminar esta receta?",
    text: "¡No podrá regresar los cambios!",
    icon: "warning",
    showCancelButton: true,
    cancelButtonColor: "#3085d6",
    confirmButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
  }, function () {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/consulta_api.php`,
      method: 'POST',
      dataType: 'json',
      data: {
        api: 17,
        id_receta: id
      },
      beforeSend: function () {
        button.prop('disabled', true)
      },
      success: function (data) {
        if (mensajeAjax(data)) {
          button.prop('disabled', false)
          // alertMensaje('info', 'Eliminado', 'ELIMINADO')
          alertToast('Receta elimanda', 'success')
          tablaRecetas.ajax.reload()
        }
      }

    })
  })
  // $.ajax({
  //   url: http + servidor + "/nuevo_checkup/api/notas_historia_api.php",
  //   type: "POST",
  //   dataType: "json",
  //   data: {
  //     api: 4,
  //     id_nota: id,
  //   },
  //   success: function (data) {
  //     if (mensajeAjax(data)) {
  //       var parent_element = button.closest("div");
  //       $(parent_element).remove()
  //     }
  //   }
  // });
});


$('#btn-guardar-Nutricion').click(function () {
  let button = $(this)
  button.prop('disabled', true)
  guardarInformacion({
    api: 5,
    turno_id: pacienteActivo.array['ID_TURNO'],
    peso_perdido: $('#input-pesosPerdido').val(),
    grasa: $('#input-grasa').val(),
    cintura: $('#input-cintura').val(),
    agua: $('#input-agua').val(),
    musculo: $('#input-musculo').val(),
    abdomen: $('#input-abdomen').val()
  }, function () {
    button.prop('disabled', false)
    alertToast('Datos guardados...', 'success')
  })
})

$('#btn-guardar-notaPadecimiento').click(function () {
  $('#btn-guardar-notaPadecimiento').prop('disabled', true);
  guardarInformacion({
    api: 3,
    notas_padecimiento: $('#nota-notas-padecimiento').val(),
    id_consulta: pacienteActivo.selectID
  }, function () {
    $('#btn-guardar-notaPadecimiento').prop('disabled', false);
    alertToast('Nota guardarda', 'success')
  })
})

$('#btn-guardar-Diagnostico').click(function () {
  $('#btn-guardar-Diagnostico').prop('disabled', true);
  guardarInformacion({
    api: 3,
    diagnostico: $('#diagnostico-campo-consulta').val(),
    id_consulta: pacienteActivo.selectID
  }, function () {
    $('#btn-guardar-Diagnostico').prop('disabled', false);
    alertToast('Nota guardarda', 'success')
  })
})




function guardarInformacion(data, callback) {
  $.ajax({
    url: `${http}${servidor}/${appname}/api/consulta_api.php`,
    method: 'POST',
    dataType: 'json',
    data: data,
    success: function (data) {
      if (mensajeAjax(data)) {
        callback();
      }
    }
  })
}






