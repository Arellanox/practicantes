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
        fechaInicio = $("#FechaInicio").val();
        fechaFinal = $("#FechaFinal").val();
        if (fechaInicio > fechaFinal) {
            alertToast('El rango de fechas seleccionado es incorrecto', 'error', 2000)
        } else {
            ajaxAwaitFormData({
                api: 5,
                Enfriador: id_equipos,
                Termometro: Termometro
            }, 'temperatura_api', 'liberarDiaTemperaturaForm', { callbackAfter: true }, false, function (data) {
                alertTemperatura("Dias liberado");
                $("#Tabla-termometro").html('')
                $("#Tabla-equipos").html('')
                // console.log(data)
            })
        }


    }, 1)
})





function alertTemperatura(text) {
    alertMensaje('success', text, 'Se ha liberado el dia correctamente');

    $("#LiberalDiaTemperaturaModal").modal("hide");

    // tablaTemperatura.ajax.reload()
    tablaTemperaturaFolio.ajax.reload()
}