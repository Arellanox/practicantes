$.post("modals/m_temperatura.php", function (html) {
    $("#modals-js").html(html);
}).done(function () {
    // Modal para aceptar
    $.getScript('modals/js/t_agregar.js');
    // Modal para liberar dia

    $.getScript('modals/js/t_liberar.js');

    $.getScript('modals/js/t_generarPDF.js');


});