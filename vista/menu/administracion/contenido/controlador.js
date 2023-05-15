
//Menu predeterminado
hasLocation();
$(window).on("hashchange", function (e) {
  hasLocation();
});



selectFormUsuario = 0;
// ObtenerTabla o cambiar
function obtenerContenidoUsuarios() {
  obtenerTitulo("Usuarios"); //Aqui mandar el nombre de la area
  $.post("contenido/usuarios.php", function (html) {
    var idrow;
    $("#body-js").html(html);
    // Datatable
    $.getScript("contenido/js/usuario-tabla.js");
    // Botones
    $.getScript("contenido/js/usuario-botones.js");
  });
}

// function obtenerContenidoServicios(tabla, titulo){
//   obtenerTitulo(titulo); //Aqui mandar el nombre de la area
//   $.post("contenido/servicios.php", function (html) {
//     var idrow;
//     $("#body-js").html(html);
//     // Datatable
//     $.getScript("contenido/js/servicios-tabla.js");
//     $.getScript("contenido/js/precios-tabla.js");
//     // Botones
//     $.getScript("contenido/js/servicios-botones.js");
//   });
// }

// function obtenerContenidoSegmentos(titulo) {
//   obtenerTitulo(titulo); //Aqui mandar el nombre de la area
//   $.post("contenido/segmentos.php", function (html) {
//     var idrow;
//     $("#body-js").html(html);
//     // Datatable
//     $.getScript("contenido/js/segmentos-tabla.js");
//     // Botones
//     $.getScript("contenido/js/botones-segmento.js");
//   });
// }




function hasLocation() {
  if (validarVista('ADMINISTRACIÓN')) {
    var hash = window.location.hash.substring(1);
    $("a").removeClass("navlinkactive");
    $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
    switch (hash) {
      case "USUARIOS":
        obtenerContenidoUsuarios("usuario.php", "Usuarios");
        break;
      // case "Servicios":
      //   obtenerContenidoServicios("servicios.php", "Servicios");
      //   break;
      // case "Segmentos":
      //   obtenerContenidoSegmentos("Segmentos");
      //   break;
      default:
        obtenerContenidoUsuarios("usuario.php", "Usuarios");
        break;
    }
  }
}
