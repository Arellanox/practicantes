

var tablaEstatusTurnos;


obtenerContenidoPrincipal()

function obtenerContenidoPrincipal() {
    obtenerTitulo('Menú bimo Checkup'); //Nombre cambiante, no usar botones
    $.post("contenido/turnos_dia.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/estatus-tabla.js");

    });
}







// hasLocation()
// $(window).on("hashchange", function (e) {
//     hasLocation();
// });

// function hasLocation() {
//     var hash = window.location.hash.substring(1);
//     $("a").removeClass("navlinkactive");
//     $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
//     switch (hash) {
//         case "rechazados":
//             obtenerContenidoRechazados();
//             break;
//         case "ingresados":
//             obtenerContenidoAceptados();
//             break;
//         case "pendientes":
//             obtenerContenidoEspera();
//             dataRecepcion = { api: 1 };
//             break;
//         default:
//             window.location.hash = 'pendientes';
//             break;
//     }
// }
