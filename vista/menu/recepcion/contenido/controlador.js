

// ObtenerTabla o cambiar
// obtenerContenidoRecepcion();
var tablaRecepcionPacientes, dataRecepcion = { api: 1 };

var estudiosLab = [], estudiosLabBio = [], estudiosRX = [], estudiosUltra = [], estudiosOtros = []

if (validarVista('RECEPCIÓN')) {
  hasLocation()
  $(window).on("hashchange", function (e) {
    hasLocation();
  });
}

// Botones
$.getScript("contenido/js/recepcion-botones.js");

function obtenerContenidoEspera() {
  obtenerTitulo('Recepción | Espera'); //Aqui mandar el nombre de la area
  $.post("contenido/recepcion.html", function (html) {
    $("#body-js").html(html);
    // Datatable
    $.getScript("contenido/js/recepcion-tabla.js");

  });
}

function obtenerContenidoAceptados() {
  obtenerTitulo('Recepción | Aceptados'); //Aqui mandar el nombre de la area
  $.post("contenido/recepcion-ingresados.html", function (html) {
    $("#body-js").html(html);
    dataRecepcion = { api: 1, estado: 1 };
    // Datatable
    $.getScript("contenido/js/recepcion-aceptados-tabla.js");
  });
}

function obtenerContenidoRechazados() {
  obtenerTitulo('Recepción | Rechazados'); //Aqui mandar el nombre de la area
  $.post("contenido/recepcion-rechazados.html", function (html) {
    $("#body-js").html(html);
    dataRecepcion = { api: 1, estado: 0 };
    // Datatable
    $.getScript("contenido/js/recepcion-tabla.js");
  });
}



function hasLocation() {
  var hash = window.location.hash.substring(1);
  $("a").removeClass("navlinkactive");
  $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
  switch (hash) {
    case "rechazados":
      obtenerContenidoRechazados();
      break;
    case "ingresados":
      obtenerContenidoAceptados();
      break;
    case "pendientes":
      obtenerContenidoEspera();
      dataRecepcion = { api: 1 };
      break;
    default:
      window.location.hash = 'pendientes';
      break;
  }
}

function recepciónPaciente(estatus, id) {
  Swal.fire({
    title: '¿Estás seguro de ' + estatus + ' este paciente?',
    text: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      switch (estatus) {
        case 'aceptar':
          Swal.fire({
            icon: 'success',
            title: 'Aceptado!',
            text: 'El pase del paciente se está generando...'
          })
          // Ajax para generar TURNO y generar pase
          break;
        case 'rechazar':
          Swal.fire(
            'Rechazado!',
            'El paciente a sido rechazado.',
            'error'
          )
          // Ajax para cancelar registro del paciente
          break;
        default:

      }
    }
  })
}

obtenerPanelInformacion(0, 0, 0)
