//Menu predeterminado
$.post("modals/a_modals.php", function (html) {
    $("#modals-js").html(html);
    //$.getScript('modals/js/p_rechazar.js');
    // Modal para rechazar
    // $.getScript('modals/js/subir-perfil.js');
}).done(function () {
    // Modal para Actualizar Cliente
    $.getScript('modals/js/facturar-contado.js');

    $.getScript('modals/js/cl_editar_cliente.js');
    $.getScript('modals/js/c_credito_ticket.js');
});