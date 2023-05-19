


if (validarVista('FACTURACIÓN')) {
    hasLocation();
    $(window).on("hashchange", function (e) {
        hasLocation();
    });
}



function obtenerPacientesContado() {
    obtenerTitulo('Pacientes a contados'); //Aqui mandar el nombre de la area
    $.post("contenido/contado.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/contados-tablas.js");
    });
}



function hasLocation() {
    var hash = window.location.hash.substring(1);
    $("a").removeClass("navlinkactive");
    $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
    switch (hash) {
        case "CONTADO":
            obtenerPacientesContado();
            break;
        default:
            window.location.hash = '#';
            break;
    }
}