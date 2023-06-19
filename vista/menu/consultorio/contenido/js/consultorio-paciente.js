// Metodos para rellenar el DOM
function obtenerAntecedentes(div) { //Sin usar
  return new Promise(resolve => {
    $.post(`${http}${servidor}/${appname}/vista/include/acordion/antecedentes-paciente.php`, function (html) {
      $(div).html(html);
    }).done(function () {
      // alert("Done post")
      resolve(1);
    });

  });
}

function obtenerNotasHistorial(id) {
  return new Promise(resolve => {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/notas_historia_api.php`,
      type: "POST",
      dataType: "json",
      data: {
        id_paciente: id,
        api: 2
      },
      success: function (data) {
        if (mensajeAjax(data)) {
          // console.log(data);
          var event = new Date();
          var options = {
            hours: 'numeric',
            minutes: 'numeric',
            weekday: 'long',
            year: 'numeric',
            month: 'short',
            day: 'numeric'
          };
          // ACTIVO: "1"
          // ID_NOTA: "2"
          // NOTAS: "nota historial Luisa"
          // TURNO_ID: "59"
          let row = data.response.data;
          for (let i = 0; i < row.length; i++) {
            agregarNotaConsulta(row[i]['NOMBRE_USUARIO'], formatoFecha2(row[i]['FECHA_CREACION'], [3, 1, 2, 2, 0, 0, 0]), row[i]['NOTAS'], '#notas-historial', row[i]['ID_NOTA'], 'eliminarNota')
          }
        }
      },
      complete: function () {
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    });
  });

}

//Consultar si existe o no la valoracion medica
function consultarConsulta(id) {
  return new Promise(resolve => {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/consulta_api.php`,
      type: "POST",
      data: {
        turno_id: id,
        api: 2
      },
      dataType: "json",
      success: function (data) {
        if (mensajeAjax(data)) {
          let row = data.response.data
          console.log(row)
          if (row.length) {
            // for (let i = 0; i < row.length; i++) {
            try{
              if (row[0]['COMPLETADO'] == 0) {
              $('#btn-ir-consulta').html(`<button type="button" onclick="obtenerContenidoConsulta(pacienteActivo.array, ${row[0]['ID_CONSULTA']})" 
                class="btn btn-warning me-2" style="margin: 15px 60px 10px 60px !important;font-size: 21px;">
                 <i class="bi bi-clipboard-heart"></i> Continuar Historia Clínica
                </button>`)
            } else if (row[0]['COMPLETADO'] == 1) {
              $('#btn-ir-consulta').html(`<button type="button" onclick="obtenerContenidoConsulta(pacienteActivo.array, ${row[0]['ID_CONSULTA']})" 
              class="btn btn-success me-2" style="margin: 15px 60px 10px 60px !important;font-size: 21px;" data-bs-toggle="tooltip" data-bs-placement="top" title="¿Consultar la historia Clínica?">
              <i class="bi bi-clipboard-heart"></i> Historia Clínica Terminada </button>`)
            }
            } catch {
              $('#btn-ir-consulta').html(`
                <button type="button" class="btn btn-hover me-2" style="margin: 15px 60px 10px 60px !important;font-size: 21px;"
                data-bs-toggle="modal" data-bs-target="#modalMotivoConsulta">
                    <i class="bi bi-person-plus-fill"></i> Iniciar Historia Clínica
                </button>`)
            }

            // }
          }
        }
      },
      complete: function () {
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    });
  });
}

//Consultar si existe o no la consulta medica
function consultarConsultaMedica(id) {
  return new Promise(resolve => {
  ajaxAwait({ api: 2, turno_id: id }, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
    let row = data.response.data[0];

   try{ 
    if (row['CONSULTA_TERMINADA'] == 0) {
      $('#btn-ir-consulta-medica').html(`
        <button type="button" onclick="obtenerConsultorioConsultaMedica(pacienteActivo.array, ${row['ID_CONSULTA2']} )" 
        class="btn btn-warning me-2" style="margin: 15px 60px 10px 60px !important;font-size: 21px;"> 
          <i class="bi bi-clipboard-heart"></i> Continuar Consulta Médica
        </button>`);
    } else if (row['CONSULTA_TERMINADA'] == 1) {
      $('#btn-ir-consulta-medica').html(`<button type="button" onclick="obtenerContenidoConsulta(pacienteActivo.array, ${row['ID_CONSULTA2']})" 
          class="btn btn-success me-2" style="margin: 15px 60px 10px 60px !important;font-size: 21px;" data-bs-toggle="tooltip" data-bs-placement="top" title="¿Consultar la historia Clínica?">
          <i class="bi bi-clipboard-heart"></i> Consulta Médica Terminada
            </button>`)
    }
  }catch(error){
    $('#btn-ir-consulta-medica').html(`
    <button type="button" class="btn btn-hover me-2" style="margin: 15px 60px 10px 60px !important;font-size: 21px;"
    data-bs-toggle="modal" data-bs-target="#modalMotivoConsulta">
      <i class="bi bi-person-plus-fill"></i> Iniciar Consulta Médica
    </button>`)
  }


    
    resolve(1);
  })
});
}

function obtenerHistorialConsultas(id) {
  return new Promise(resolve => {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/consulta_api.php`,
      type: "POST",
      dataType: "json",
      data: {
        id_paciente: id,
        api: 2
      },
      success: function (data) {
        if (mensajeAjax(data)) {
          // console.log(data);
          $('#historial-consultas-paciente').html('')

          let row = data.response.data

          for (var i = 0; i < row.length; i++) {
            if (row[i]['COMPLETADO'] == 1) {
              let fecha = formatoFecha2(row[i]['FECHA_CONSULTA'], [0, 1, 2, 2, 0, 0, 0]);
              let nombre = row[i]['MEDICO'];
              let motivo = row[i]['MOTIVO_CONSULTA'];
              $('#historial-consultas-paciente').append('<div class="row line-top" style="margin:0px">' +
                '<div class="col-3 line-right">' + fecha + '</div>' +
                '<div class="col-9"><p>' + nombre + '</p> <p class="none-p">' + motivo + '</p>' +
                '</div> </div>')
            }
          }



        }
      },
      complete: function () {
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    });
  });
}

function obtenerConsultaRapida() {

}