

// if (validarVista('ADMINISTRACIÓN')) {
    contenidoSoporteTi()
// }


async function contenidoSoporteTi() {
    await obtenerTitulo("Soporte TI");
    $.post("contenido/vista_tabla_TI.html", function (html) {
      $("#body-js").html(html);
    }).done(function () {
      tablaSoporteTi = { api: 1, id_area: 6, fecha_agenda: $('#fechaListadoAreaMaster').val() };
      // DataTable
    //   $.getScript('contenido/js/muestras-tabla.js')
    })
  }
  
      // Botones
      $.getScript('contenido/js/muestras-botones.js')