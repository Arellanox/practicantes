


if (validarVista('FACTURACIÓN')) {
    hasLocation();
    $(window).on("hashchange", function (e) {
        hasLocation();
    });
}



function obtenerPacientesCredito() {
    obtenerTitulo('Pacientes a credito'); //Aqui mandar el nombre de la area
    $.post("contenido/credito.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/recepcion-tabla.js");
    });
}



function hasLocation() {
    var hash = window.location.hash.substring(1);
    $("a").removeClass("navlinkactive");
    $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
    switch (hash) {
        case "CREDITO":
            obtenerPacientesCredito();
            break;
        default:
            window.location.hash = '#';
            break;
    }
}