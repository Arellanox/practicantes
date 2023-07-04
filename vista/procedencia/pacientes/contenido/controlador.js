

// if (validarVista('REGISTRO_TEMPERATURA')) {
//     hasLocation();
//     $(window).on("hashchange", function (e) {
//         hasLocation();
//     });
// }

hasLocation();
$(window).on("hashchange", function (e) {
    hasLocation();
});

// Variables globales

// obtenerContenido()
var datapacientes = { api: 1 }
function obtenerContenido() {
    obtenerTitulo('Menú principal'); //Aqui mandar el nombre de la area
    $.post("contenido/contenido.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/contenido-tablas.js");
        // Botones

        // Filtros
    });
}



function hasLocation() {
    var hash = window.location.hash.substring(1);
    $("a").removeClass("navlinkactive");
    $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
    switch (hash) {
        case "UJAT":
            obtenerContenido();
            break;
        default:
            // window.location.hash = '#UJAT';
            break;
    }
}