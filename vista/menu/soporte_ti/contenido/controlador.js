

// if (validarVista('ADMINISTRACIÓN')) {
    contenidoSoporteTi()
// }

var ticket

async function contenidoSoporteTi(data) {
    await obtenerTitulo("Soporte TI");
    $.post("contenido/vista_tabla_TI.html", function (html) {
      $("#body-js").html(html);
    }).done(function () {
    //   tablaSoporteTi = { api: 2,  fecha_agenda: $('#fechaListadoAreaMaster').val() };
      ajaxAwait({ api: 2 }, 'asistencia_ti_bot_api', { callbackAfter: true }, false, function (data) {
        $.getScript('contenido/js/muestra-tabla.js')
      })
      // DataTable
    })
  }
      // Botones
    //   $.getScript('contenido/js/muestras-botones.js')