$("#capturarTemperatura").on("click", function (e) {
    e.preventDefault();

    rellenarSelect('#Enfriador', 'formas_pago_api', '2', 'ID_PAGO', 'DESCRIPCION');
    rellenarSelect('#Termometro', 'formas_pago_api', '2', 'ID_PAGO', 'DESCRIPCION');

    $("#capturarTemperaturaModal").modal("show");

    $("#usuarioQueCargar").html(`Capturando por:<strong></strong>`)


    $("#formCapturarTemperatura").on("submit", function (e) {
        e.preventDefault();
        console.log("Capturando...");
    })
})


function cargarTemperatura(data) {
    alertToast('Espere un momento', 'info', 4000)

    /*  $("#capturarTemperaturaModal").modal("hide"); */
}