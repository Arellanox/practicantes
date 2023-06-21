//Recupera todos los datos requeridos y los muestra del paciente
function mostrarInformacionPaciente(idconsulta) {
  return new Promise(resolve => {


    ajaxAwait({ api: 2, id_consultorio2: idconsulta }, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
      //motivo-consulta
      let row = data.response.data[0];

      $('#motivo-consulta').html(row['MOTIVO_CONSULTA'])
      $('#fechaConsulta-consulta').html(formatoFecha2(row['FECHA_CONSULTA'], [0, 1, 2, 2, 0, 0, 0]))

      $('#nombre-paciente-consulta').html(pacienteActivo.array['NOMBRE_COMPLETO'])
      $('#nacimiento-paciente-consulta').html(pacienteActivo.array['NACIMIENTO'])
      $('#edad-paciente-consulta').html(pacienteActivo.array['EDAD'] + ' años')
      $('#genero-paciente-consulta').html(pacienteActivo.array['GENERO'])
      // console.log(pacienteActivo);

    })

    resolve(1);
  })
}

//Recupera y muestra todos los campos de consulta
function recuperarDatosCampos(idconsulta) {
  return new Promise(resolve => {

    ajaxAwait({ api: 2, id_consultorio2: idconsulta }, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
      let row = data.response.data[0]
      // console.log(row['CONSULTA_TERMINADA'])

      if(row['CONSULTA_TERMINADA'] == 1){
        $('#body-js').find('button, textarea, input, select').prop('disabled', true);      
        
        // console.log("Los campos han sido desactivados")
        $('#nota-consulta-campo-consulta').val(row['NOTAS_CONSULTA'])
        $('#diagnostico-campo-consulta-1').val(row['DIAGNOSTICO'])
        $('#plan-tratamiento-campo-consulta').val(row['PLAN_TRATAMIENTO'])

      }else{
        $('#nota-consulta-campo-consulta').val(row['NOTAS_CONSULTA'])
        $('#diagnostico-campo-consulta-1').val(row['DIAGNOSTICO'])
        $('#plan-tratamiento-campo-consulta').val(row['PLAN_TRATAMIENTO'])
      }

    })


    resolve(1)


  })
}

//recupera los registros de exploracion fisica en consultorio
function recuperarExploracionFisicaConsulta2(id_turno) {
  return new Promise(resolve => {

    ajaxAwait({ api: 2, turno_id: id_turno }, 'exploracion_clinica_api', { callbackAfter: true }, false, (data) => {
      let row = data.response.data;
      for (let i = 0; i < row.length; i++) {
        agregarNotaConsulta(row[i]['DESCRIPCION'], null, row[i]['EXPLORACION'], '#notas-historial-consultorio', row[i]['ID_EXPLORACION_2_CLINICA'], 'eliminarExploracion')
      }
      // console.log(row)

    })

    resolve(1)
  })
}

//Desactiva los elementos seleccionados en exploracion fisica en consultorio
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
    ajaxAwait({ api: 5, id_exploracion_2_clinica: id }, 'exploracion_clinica_api', { callbackAfter: true }, false, function (data) {

      var parent_element = $(comentario).closest("div[class = 'card mt-3']");
      console.log(parent_element)
      $(parent_element).remove();

      alertToast('Exploración eliminada!', 'success', 4000)
    })
  })
});


// //Recupera los datos de diagnostico en consultorio
// function recuperarDiagnosticosConsulta2(id_turno) {
//   return new Promise(resolve => {
//     ajaxAwait({ api: 6, turno_id: id_turno }, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
//       let row = data.response.data

//       for (let i = 0; i < row.length; i++) {
//         agregarNotaConsulta(row[i]['DESCRIPCION'], null, null, '#lista-diagnosticos-consultorio', row[i]['FECHA_CREACION'], 'eliminarDiagnostico')
//       }
//       console.log(row)
//     })

//     resolve(1)
//   })

// }
