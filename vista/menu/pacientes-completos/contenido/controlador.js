

// ObtenerTabla o cambiar
// obtenerContenidoRecepcion();
var tablaCompletados, dataRecepcion = { api: 1 };

if (validarVista('RECEPCIÓN')) {
  hasLocation()
  $(window).on("hashchange", function (e) {
    hasLocation();
  });
}

// Botones
$.getScript("contenido/js/completados-botones.js");


function obtenerContenidoCompletados() {
  obtenerTitulo('Pacientes | Concluidos'); //Aqui mandar el nombre de la area
  $.post("contenido/completados.html", function (html) {
    $("#body-js").html(html);
    dataRecepcion = { api: 20, turno_completado: 1 };
    // Datatable
    $.getScript("contenido/js/completados-tabla.js");
  });
}


function hasLocation() {
  var hash = window.location.hash.substring(1);
  $("a").removeClass("navlinkactive");
  $("nav li a[href='#" + hash + "']").addClass("navlinkactive");

  switch (hash) {
    case "COMPLETOS":
      obtenerContenidoCompletados();
      break;
    default:
      window.location.hash = 'COMPLETOS';
      break;
  }
}


