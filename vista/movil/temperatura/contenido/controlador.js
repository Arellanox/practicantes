// if (validarVista('REGISTRO_TEMPERATURA')) {
//     hasLocation();
//     $(window).on("hashchange", function (e) {
//         hasLocation();
//     });
// }
$(window).on("hashchange", function (e) {
    hasLocation();
});
hasLocation();

async function ObtenerContenido() {
    await obtenerTitulo('Agregar Temperaturas'); //Aqui mandar el nombre de la area
    $.post("contenido/contenido.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/temperaturas_movil.js");
    });
}



function hasLocation() {
    var hash = window.location.hash.substring(1);
    $("a").removeClass("navlinkactive");
    $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
    switch (hash) {
        case "AgregarTemperatura":
            ObtenerContenido();
            break;
        default:
            window.location.hash = '#AgregarTemperatura';
            break;
    }
}