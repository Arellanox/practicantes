//Menu predeterminado
$.post("modals/p_modals.php", function (html) {
    $("#modals-js").html(html);
    //$.getScript('modals/js/p_rechazar.js');
    // Modal para rechazar
    // $.getScript('modals/js/subir-perfil.js');
}).done(function () {
    // Modal para Actualizar Cliente
    $.getScript('modals/js/p_filtro.js');
});
