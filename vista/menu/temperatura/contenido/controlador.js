

if (validarVista('REGISTRO_TEMPERATURA')) {
    hasLocation();
    $(window).on("hashchange", function (e) {
        hasLocation();
    });
}

// Variables globales
var selectRegistro, selectedEquipos, editRegistro = false, id_equipos = null, btnequipos = false, Termometro = null;
var Domingos, dataConfig = {}, selectedEquiposTemperaturas = {}, SelectedFoliosData = {};
var DataEquipo;
var selectTableFolio = false
async function obtenerTemperaturas() {
    await obtenerTitulo('Registros de Temperatura'); //Aqui mandar el nombre de la area
    $.post("contenido/temperatura.php", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/temperatura-tablas.js");
        // Botones
        $.getScript("contenido/js/temperatura-botones.js");

        // Filtros
        // $.getScript("contenido/js/filtro-temperatura.js");
    });
}

function obtenerPrueba() {
    obtenerTitulo('Registros de Temperatura'); //Aqui mandar el nombre de la area
    $.post("contenido/temperatura2.php", function (html) {
        $("#body-js").html(html);
    }).done(function () {
        // Datatable
        $.getScript("contenido/js/temperatura-tablas.js");
        // Botones
        $.getScript("contenido/js/temperatura-botones.js");

        // Filtros
        // $.getScript("contenido/js/filtro-temperatura.js");
    });
}



function hasLocation() {
    var hash = window.location.hash.substring(1);
    $("a").removeClass("navlinkactive");
    $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
    switch (hash) {
        case "TEMPERATURA":
            obtenerPrueba();
            break;
        default:
            window.location.hash = '#TEMPERATURA';
            break;
    }
}