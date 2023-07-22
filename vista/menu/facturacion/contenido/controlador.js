


if (validarVista('FACTURACIÓN')) {
    hasLocation();
    $(window).on("hashchange", function (e) {
        hasLocation();
    });
}


var selectCuenta = false;
function obtenerPacientesContado() {
    obtenerTitulo('Pacientes particulares (Contado)'); //Aqui mandar el nombre de la area
    $.post("contenido/contado.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/contados-tablas.js");
    });
}

//Globales

SelectedPacienteCredito = {}, SelectedGruposCredito = {}, factura = null;
var TablaGrupos = false;
function obtenerPacientesCredito() {
    obtenerTitulo('Pacientes (Crédito)'); //Aqui mandar el nombre de la area
    $.post("contenido/credito.html", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        TablaGrupos = false
        // Datatable
        $.getScript("contenido/js/credito-tablas.js");


    });
}


// Botones
$.getScript("contenido/js/contados-botones.js");

//Botones
$.getScript("contenido/js/credito-botones.js");

function hasLocation() {
    var hash = window.location.hash.substring(1);
    $("a").removeClass("navlinkactive");
    $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
    switch (hash) {
        case "CONTADO":
            obtenerPacientesContado();
            break;
        case "CREDITO":
            obtenerPacientesCredito();
            break;
        default:
            window.location.hash = '#';
            break;
    }
}