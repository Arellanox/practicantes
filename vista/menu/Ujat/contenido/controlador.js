

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


function obtenerContenido() {
    obtenerTitulo('Menú ujat'); //Aqui mandar el nombre de la area
    $.post("contenido/contenido.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/ujat-tablas.js");
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
            window.location.hash = '#UJAT';
            break;
    }
}