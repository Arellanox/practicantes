$("#LibererDiaTemperatura").on("click", function (e) {
    e.preventDefault();
    $("#liberarDiaTemperaturaForm").trigger("reset")
    alertToast('Espere un momento', 'info', 3000)

    $("#LiberalDiaTemperaturaModal").modal("show");
})


$("#liberarDiaTemperaturaForm").on("submit", function (e) {
    e.preventDefault();
    // data = new FormData(document.getElementById("liberarDiaTemperaturaForm"))
    // console.log(data)

    alertMensajeConfirm({
        title: "Estas seguro de su captura?",
        text: "Ya no podras modificar este registro",
        icon: "info"
    }, function () {

        ajaxAwaitFormData({
            api: 5,
            Enfriador: id_equipos
        }, 'temperatura_api', 'liberarDiaTemperaturaForm', { callbackAfter: true }, false, function (data) {
            alertTemperatura("Dias liberado");
            console.log(data)
        })
    }, 1)
})





function alertTemperatura(text) {
    alertMensaje('success', text, 'Se ha liberado el dia correctamente');

    $("#LiberalDiaTemperaturaModal").modal("hide");

    // tablaTemperatura.ajax.reload()
    tablaTemperaturaFolio.ajax.reload()
}