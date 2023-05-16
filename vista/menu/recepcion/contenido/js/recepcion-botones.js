// $("#btn-aceptar").click(function () {
$(document).on('click', '#btn-aceptar', function () {
  swal.close()
  if (array_selected != null) {
    $("#modalPacienteAceptar").modal('show');
  } else {
    alertSelectTable();
  }
})

$(document).on('click', '#btn-rechazar', function () {
  // $("#btn-rechazar").click(function () {
  swal.close()
  if (array_selected != null) {
    $("#modalPacienteRechazar").modal('show');
  } else {
    alertSelectTable();
  }
})


$(document).on('click', '#btn-espera-estatus', function () {
  alertMsj({
    icon: '',
    title: 'Elige una opción',
    html: `
        <button type="button" class="btn btn-pantone-7408 me-2" style="margin-bottom:4px" id="btn-aceptar"
          data-bs-toggle="tooltip" data-bs-placement="top" title="Carga una solicitud de estudios">
          <i class="bi bi-check"></i> Aceptar paciente
        </button>
        <button type="button" class="btn btn-borrar me-2" style="margin-bottom:4px" id="btn-rechazar"
          data-bs-toggle="tooltip" data-bs-placement="top" title="Rechaza/Elimina este registro">
          <i class="bi bi-x"></i> Rechazar paciente
        </button> 
    `,
    showCancelButton: false,
    showConfirmButton: false,
    allowOutsideClick: true,
  })
})


$(document).on('click', '#btn-opciones-paciente', function (e) {
  let html = '';
  // if (session['vista']['RECEPCIÓN CAMBIO DE ESTUDIOS'] == 1)
  if (validarVista('RECEPCIÓN CAMBIO DE ESTUDIOS', false))
    html += `<button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-agregar_eliminar-estudios"
          data-bs-toggle="tooltip" data-bs-placement="top" title="Elimine/Agregue estudios al paciente">
          <i class="bi bi-plus-slash-minus"></i> Actualizar Estudios
        </button> `

  if (array_selected) {
    alertMsj({
      icon: '',
      title: 'Elige una opción',
      html: html,
      showCancelButton: false,
      showConfirmButton: false,
      allowOutsideClick: true,
    })
  } else {
    alertSelectTable();
  }
})

//Agregar o eliminar estudios
$(document).on('click', '#btn-agregar_eliminar-estudios', function (e) {
  // swal.close()
  if (array_selected) {
    getDataEstudiosFirst()
  } else {
    alertSelectTable();
  }
  // $('#modalCambiarEstudios').modal('show');
  // x

})

$(document).on('click', '#btn-concluir-paciente', function (e) {
  if (array_selected) {
    alertMensajeConfirm({
      title: '¿Estás seguro de finalizar el proceso de recepción del paciente?',
      text: `El paciente, ${array_selected['NOMBRE_COMPLETO']}, ya no se podrán hacer mas modificaciones.`,
      icon: 'warning'
    }, function () {

      if (array_selected['CLIENTE_ID'] == 1) {
        alertMensajeConfirm({
          title: '¿Como será el pago del paciente?',
          icon: 'info',
          text: `Elege el tipo de pago para el paciente ${array_selected['NOMBRE_COMPLETO']}`,
          denyButtonText: `Credito`,
          confirmButtonText: 'Contado',
          showDenyButton: true,
          showCancelButton: false
        }, function () {
          configurarModal(array_selected);
        }, 1, function () {
          finalizarProcesoRecepcion(data, false, 'Credito');
        })
      } else {
        finalizarProcesoRecepcion(data);
      }

    }, 1)
  } else {
    alertSelectTable();
  }

});

function finalizarProcesoRecepcion(paciente, factura = false, pago = false) {
  let data = ajaxAwait({
    api: 19, // <-- desmarcar o marcar
    turno_completado: 1,
    id_turno: paciente['ID_TURNO'],
    factura: factura, // <-- si  o no
    pago: pago, // <-- si o no
  }, 'turnos_api')

  if (data) {
    // let row = data.response.data;
    alertMsj({
      title: '¡Paciente finalizado!',
      text: `El paciente: ${paciente['NOMBRE_COMPLETO']}, ha sido cerrado, ya no podrás crear modificaciones al paciente...`,
      footer: 'Cargando nuevamente las tablas...',
      icon: 'success',
      showCancelButton: false,
    })
    try { tablaRecepcionPacientesIngrersados.ajax.reload() } catch (error) { }
    // try { tablaRecepcionPacientes.ajax.reload() } catch (error) { }
  }
}



$(document).on('click', '.btn-eliminar-estudio', function (event) {
  if (!validarPermiso('RepEstElim'))
    return false
  event.preventDefault();
  let name = $(this).closest('tr')
  name = name.find('td[class="sorting_1 dtr-control"]').html();

  let id = $(this).attr('data-bd-id');
  statusEstudiosPaciente(id, 17, 'eliminar', name)
})

$(document).on('click', '.btn-agregar-estudio', function (event) {
  event.preventDefault();
  let name = $(this).closest('tr')
  name = name.find('td[class="sorting_1 dtr-control"]').html();

  let id = $(this).attr('data-bd-id');
  statusEstudiosPaciente(id, 18, 'agregar', name)

})

$(document).on('click', '.btn-agregar-estudios-admin', function (event) {
  event.preventDefault();
  let tipo = $(this).attr('data-bs-tipo');
  let id = $(`#${tipo}`).val()
  let name = $(`#${tipo} option: selected`).html()
  console.log(id)
  console.log(tipo)

  statusEstudiosPaciente(id, 18, 'agregar', name)

})




$(document).on('click', '#btn-perfil-paciente', function () {
  if (array_selected) {
    Swal.close();
    $('#modalPacientePerfil').modal('show');
  } else {
    alertSelectTable();
  }
})

$(document).on('click', '#btn-credencial-paciente', function () {
  if (array_selected) {
    Swal.close();
    $('#modalPacienteIne').modal('show');
  } else {
    alertSelectTable();
  }
})

$(document).on('click', '#btn-ordenes-paciente', function () {
  if (array_selected) {
    Swal.close();
    $('#modalOrdenesMedicas').modal('show');
  } else {
    alertSelectTable();
  }
})




$(document).on('click', '#btn-cargar-documentos', function () {
  alertMsj({
    icon: '',
    title: 'Documentación del paciente <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Cargue/Guarde la documentación del paciente"></i>',
    footer: 'Seleccione una opción.',
    html: `
      < button type = "button" class= "btn btn-hover me-2" style = "margin-bottom:4px" id = "btn-perfil-paciente" >
      <i class="bi bi-person-bounding-box"></i> Foto de Perfil
        </ >
        <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-credencial-paciente">
          <i class="bi bi-person-vcard-fill"></i> Credencial
        </button> 
        <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-ordenes-paciente">
          <i class="bi bi-files"></i> Ordenes médicas
        </button> 
    `,
    showCancelButton: false,
    showConfirmButton: false,
    allowOutsideClick: true,
  })
})

// $(document).on('click', '#btn-botones-captura-documentos', function () {
//   alertMsj({
//     icon: '',
//     title: 'Ventana de documentos',
//     html: `
//         <button type="button" class="btn btn-borrar me-2" style="margin-bottom:4px" id="btn-rechazar"
//           data-bs-toggle="tooltip" data-bs-placement="top" title="Rechaza/Elimina este registro">
//           <i class="bi bi-x"></i> Foto de perfil
//         </button> 
//     `,
//     showCancelButton: false,
//     showConfirmButton: false,
//     allowOutsideClick: true,
//   })
// })

// $("#btn-editar").click(function () {
$(document).on('click', '.btn-editar, #btn-editar', function () {
  if (array_selected != null) {
    $("#ModalEditarPaciente").modal('show');
  } else {
    alertSelectTable();
  }
})

$(document).on('click', "#btn-perfil", function () {
  if (array_selected != null) {
    $("#modalPacientePerfil").modal('show');
  } else {
    alertSelectTable();
  }
})

// if (!session['permiso']['RepIngPaci'] == 1)
if (!validarPermiso('RepIngPaci'))
  $('#btn-pendiente').fadeOut(0);

$(document).on('click', '#btn-pendiente', function () {

  if (array_selected != null) {
    // if (!session['permiso']['RepIngPaci'] == 1)
    if (!validarPermiso('RepIngPaci', 1))
      return false;

    Swal.fire({
      title: '¿Está Seguro de regresar al paciente en espera?',
      text: "¡Sus estudios anteriores no se cargarán!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, colocarlo en espera',
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        // Esto va dentro del AJAX
        $.ajax({
          data: {
            id_turno: array_selected['ID_TURNO'],
            api: 2,
            // estado: null
          },
          url: "../../../api/recepcion_api.php",
          type: "POST",
          success: function (data) {
            data = jQuery.parseJSON(data);
            if (mensajeAjax(data)) {
              alertMensaje('info', '¡Paciente en espera!', 'El paciente se cargó en espera.');
              try {
                tablaRecepcionPacientes.ajax.reload();
              } catch (e) {

              }
              try {
                tablaRecepcionPacientesIngrersados.ajax.reload();
              } catch (e) {

              }
            }
          }
        });
      }
    })
  } else {
    alertSelectTable('No ha seleccionado ningún paciente', 'error')
  }
})

$(document).on('click', "#btn-reagendar", function () {
  if (array_selected != null) {
    $("#modalPacienteReagendar").modal('show');
  } else {
    alertSelectTable('No ha seleccionado ningún paciente', 'error')
  }
})

$(document).on('click', '#btn-correo-particular', function () {
  if (array_selected != null) {
    Swal.fire({
      title: '¿Desea enviar todos sus resultados y capturas?',
      text: "¡Se usará el correo registro del paciente!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar y enviar',
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        // Esto va dentro del AJAX
        $.ajax({
          data: {
            id_turno: array_selected['ID_TURNO'],
            api: 4,
            // estado: null
          },
          url: "../../../api/recepcion_api.php",
          type: "POST",
          success: function (data) {
            data = jQuery.parseJSON(data);
            if (mensajeAjax(data)) {
              alertMensaje('info', '¡Correo enviado!', 'Si el correo es correcto le llegará.');
            }
          }
        });
      }
    })
  } else {
    alertSelectTable('No ha seleccionado ningún paciente', 'error')
  }
})




$(document).on('click', '#get-modal-qr-clientes', function () {
  $('#modalQRClientes').modal('show');
})