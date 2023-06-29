var areaActiva;
var tablaListaPaciente, dataListaPaciente;
var idsEstudiosa, selectListaLab;





async function obtenerContenidoLaboratorio(titulo) {
  await obtenerTitulo(titulo);
  $.post("contenido/laboratorio.php", function (html) {
    $("#body-js").html(html);
  }).done(function () {
    dataListaPaciente = { api: 5, fecha_busqueda: $('#fechaListadoLaboratorio').val(), area_id: areaActiva };
    // DataTable
    $.getScript('contenido/js/lista-tabla.js')
    // Botones
    $.getScript('contenido/js/laboratorio-botones.js')
  });
}


hasLocation()
$(window).on("hashchange", function (e) {
  hasLocation();
});
function hasLocation() {
  var hash = window.location.hash.substring(1);
  $("a").removeClass("navlinkactive");
  $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
  if (validarVista(hash)) {
    switch (hash) {
      case "LABORATORIO":
        areaActiva = 6;
        obtenerContenidoLaboratorio('Resultados de Laboratorio Clinico');
        break;
      case "LABORATORIO_MOLECULAR":
        areaActiva = 12;
        obtenerContenidoLaboratorio("Resultados de Laboratorio Biomolecular");
        break;
      default: avisoArea(); break;
    }
  }
}