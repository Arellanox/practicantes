$("#GenerarPDFTemperatura").on("click", function (e) {
    e.preventDefault();

    $.ajax('http://localhost/practicantes/vista/menu/temperatura/modals/t_generarPDF.php', { folio: SelectedFoliosData['FOLIO'] });

    $("#GenerarTemperaturaModal").modal("show");
})