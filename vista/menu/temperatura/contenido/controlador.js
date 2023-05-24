
/* 
if (validarVista('REGISTRAR_TEMPERATURA')) {
    hasLocation();
    $(window).on("hashchange", function (e) {
        hasLocation();
    });
} */


hasLocation();
$(window).on("hashchange", function (e) {
    hasLocation();
});

function obtenerTemperaturas() {
    obtenerTitulo('Registros de Temperatura'); //Aqui mandar el nombre de la area
    $.post("contenido/contenido.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/temperatura-tablas.js");
        // Botones
        $.getScript("contenido/js/contados-botones.js");

        // Filtros
        $.getScript("contenido/js/filtro-temperatura.js");
    });
}



function hasLocation() {
    var hash = window.location.hash.substring(1);
    $("a").removeClass("navlinkactive");
    $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
    switch (hash) {
        case "TEMPERATURA":
            obtenerTemperaturas();
            break;
        default:
            window.location.hash = '#TEMPERATURA';
            break;
    }
}