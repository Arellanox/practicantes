function mostrarInformacionPaciente(idconsulta) {
    return new Promise(resolve => {
        
 
        ajaxAwait({api: 2, id_consultorio2: idconsulta}, 'consultorio2_api',{ callbackAfter: true }, false, function (data){
            //motivo-consulta
            let row = data.response.data[0];

            $('#motivo-consulta').html(row['MOTIVO_CONSULTA'])
            $('#fechaConsulta-consulta').html(formatoFecha2(row['FECHA_CONSULTA'],[0, 1, 2, 2, 0, 0, 0]))

            $('#nombre-paciente-consulta').html(pacienteActivo.array['NOMBRE_COMPLETO'])
            $('#nacimiento-paciente-consulta').html(pacienteActivo.array['NACIMIENTO'])
            $('#edad-paciente-consulta').html(pacienteActivo.array['EDAD']+ ' años')
            $('#genero-paciente-consulta').html(pacienteActivo.array['GENERO'])
            // console.log(pacienteActivo);

        })

        resolve(1);
    })
}

//id_consulta en realidad esta enviandolo indefinido
function recuperarDatosCampos(idconsulta) {
    return new Promise(resolve => {

        ajaxAwait({api: 2, id_consultorio2: idconsulta}, 'consultorio2_api', {callbackAfter: true}, false, function(data){
            let row = data.response.data[0]
            console.log(row)
            $('#nota-consulta-campo-consulta').val(row['NOTAS_CONSULTA'])
            $('#diagnostico-campo-consulta-1').val(row['DIAGNOSTICO'])
            $('#diagnostico-campo-consulta-2').val(row['DIAGNOSTICO2'])
        })
        

            resolve(1)


    })
}

//de varios
function recuperarExploracionFisicaConsulta2(id_turno) {
    return new Promise(resolve => {

        ajaxAwait({api: 2, turno_id: id_turno}, 'exploracion_clinica_api', { callbackAfter: true }, false, (data) => {


            let row = data.response.data;
            for (let i = 0; i < row.length; i++) {
                agregarNotaConsulta(row[i]['DESCRIPCION'], null, row[i]['EXPLORACION'], '#notas-historial-consultorio', row[i]['ID_EXPLORACION_2_CLINICA'], 'eliminarExploracion')
            }
            console.log(row)

        })
        
        resolve(1)
    })
}


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
      // $.ajax({
      //   data: {
      //     api: 5,
      //     id_exploracion_2_clinica: id
      //   },
      //   url: "../../../api/consulta_api.php",
      //   type: "POST",
      //   success: function (data) {
      //     // alert("antes de la nota")
      //     // if (mensajeAjax(data)) {
      //     var parent_element = $(comentario).closest("div[class='card mt-3']");
      //     console.log(parent_element)
      //     $(parent_element).remove()
      //     // }
  
      //     // alert("despues de la nota")
      //   },
      // });
      ajaxAwait({api: 5, id_exploracion_2_clinica: id}, 'exploracion_clinica_api',{ callbackAfter: true }, false, function (data){
        
        var parent_element = $(comentario).closest("div[class = 'card mt-3']");
        console.log(parent_element)
        $(parent_element).remove();

        alertToast('Exploración eliminada!', 'success', 4000)
      })
    })
  });
  