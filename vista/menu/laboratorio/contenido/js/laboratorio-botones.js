$('#formAnalisisLaboratorio').submit(function (event) {
  event.preventDefault();

  if (selectListaLab['CONFIRMADO'] == 0) {
    let confirmar = 0;
    var form = document.getElementById("formAnalisisLaboratorio");
    var formData = new FormData(form);
    formData.set('id_turno', selectListaLab['ID_TURNO']);
    formData.set('id_area', areaActiva)
    formData.set('api', 9);
    // console.log(formData);
    if ($('.subir-resultado-lab:focus').attr('data-attribute') == 'confirmar') {
      formData.set('confirmar', true);
      title = "¿Está seguro de confirmar los resultados?";
      text = "¡No podrá revertir esta acción!";
      alertmeensj = 'Cerrando y generando formato de laboratorio';
      alertoas = '¡Resultados listos!';
      confirmar = 1;
    } else {
      title = "¿Estás seguro de guardar los resultados?";
      text = "Use su contraseña de su sesión para guardar/actualizar los resultados";
      alertmeensj = 'Guardando resultado de laboratorio';
      alertoas = '¡Resultados guardados!'
      confirmar = 0;

    }

    Swal.fire({
      title: title,
      text: text,
      showCancelButton: true,
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      // inputAttributes: {
      //   autocomplete: false
      // },
      // input: 'password',
      html: '<form autocomplete="off" onsubmit="formpassword(); return false;"><input type="password" id="password-confirmar" class="form-control input-color" autocomplete="off" placeholder=""></form>',
      // confirmButtonText: 'Sign in',
      focusConfirm: false,
      preConfirm: () => {
        const password = Swal.getPopup().querySelector('#password-confirmar').value;
        return fetch(`${http}${servidor}/${appname}/api/usuarios_api.php?api=9&password=${password}`)
          .then(response => {
            if (!response.ok) {
              throw new Error(response.statusText)
            }
            return response.json()
          })
          .catch(error => {
            Swal.showValidationMessage(
              `Request failed: ${error}`
            )
          });
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        if (result.value.status == 1) {
          $.ajax({
            data: formData,
            url: "../../../api/turnos_api.php",
            type: "POST",
            processData: false,
            contentType: false,
            beforeSend: function () {
              alertMensaje('info', 'Espere un momento', alertmeensj)
            },
            success: function (data) {
              data = jQuery.parseJSON(data);
              if (mensajeAjax(data)) {
                alertSelectTable(alertoas, 'success')
                // dataListaPaciente = {api:5, fecha_busqueda: $('#fechaListadoLaboratorio').val(), area_id: 6}
                if (confirmar) {
                  tablaListaPaciente.ajax.reload();
                  getPanel('.informacion-labo', '#loader-Lab', '#loaderDivLab', selectListaLab, 'Out')
                }
              }
            },
          });
        } else {
          alertSelectTable('¡Contraseña incorrecta!', 'error')
        }
      }
    })
  }
})

$('.subir-resultado-lab').click(function () {
  if ($('.subir-resultado-lab:focus').attr('data-attribute') == 'confirmar') {
    $('.inputFormRequired').prop('required', true);
  } else {
    $('.inputFormRequired').prop('required', false);
  }
  $("#btnConfirmarResultados").click();
})

$('#btn-confirmar-formulario').click(function (e) {

})

// $('#btn-guardar-resultados').click(function(){
//   alert("button guardar")
//   console.log($(this))
//   $('#formAnalisisLaboratorio').submit()
//
// })

// $('#btn-confirmar-resultados').click(function(){
//   alert("button confirmar")
//   console.log($(this))
//   // enviarInformacion(1)
//   $('#formAnalisisLaboratorio').submit()
// })
//
//
// $('#formAnalisisLaboratorio').on('submit')

function enviarInformacion(tip) {

}




function formpassword() {
  //No submit form with enter
}

// cambiar fecha de la Lista
$('#fechaListadoLaboratorio').change(function () {
  recargarVistaLab();
})

$('#checkDiaAnalisis').click(function () {
  if ($(this).is(':checked')) {
    recargarVistaLab(0)
    $('#fechaListadoLaboratorio').prop('disabled', true)
  } else {
    recargarVistaLab();
    $('#fechaListadoLaboratorio').prop('disabled', false)
  }
})

function recargarVistaLab(fecha = 1) {
  dataListaPaciente = {
    api: 5,
    area_id: areaActiva
  }
  if (fecha) dataListaPaciente['fecha_busqueda'] = $('#fechaListadoLaboratorio').val();

  tablaListaPaciente.ajax.reload();
  getPanel('.informacion-labo', '#loader-Lab', '#loaderDivLab', selectListaLab, 'Out')
}

// obtenerPDF
$(document).on('click', '.obtenerPDF', function (event) {
  // alert('si')
  event.stopPropagation();
  event.stopImmediatePropagation();
  let id = $(this).attr('data-bs-id');
  $.ajax({
    url: `${http}${servidor}/${appname}/api/servicios_api.php`,
    type: "POST",
    // dataType: 'json',
    data: {
      id_turno: id,
      api: 13
    },
    beforeSend: function () {
      alertMensaje('info', 'Espere un momento', 'Generando')
    },
    success: function (data) {
      console.log(data);
      alertMensaje(null, null, null, null,
        `<div class="d-flex justify-content-center"> <a href="` + data + `" class="btn btn-borrar" target="_blank" style="width: 50%"> <i class="bi bi-image"></i> Descargar</a></div></div>`
      )

    }
  })
})