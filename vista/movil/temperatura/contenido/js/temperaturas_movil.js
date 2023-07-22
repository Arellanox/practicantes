var checkFactorCorrecion;
// Button para enviar el formulario de nuevo registro de temperaturas desde el QR
$("#formCapturarTemperatura").on('submit', function (e) {
    e.preventDefault();
    console.log(equipo_id)


    alertMensajeConfirm({
        title: "¿Está seguro de su captura?",
        text: "Recuerde usar el simbolo - si es necesario",
        icon: "info"
    }, () => {
        ajaxAwaitFormData({
            api: 17,
            Enfriador: equipo_id,
            checkFactorCorrecion: checkFactorCorrecion
        }, 'temperatura_api', 'formCapturarTemperatura', { callbackAfter: true }, false, function (data) {
            $("#formCapturarTemperatura").trigger("reset");
            alertMsj({
                title: 'Temperatura Capturada',
                text: 'Se ha capturado la temperatura con exito',
                icon: 'success',
                showCancelButton: false,
                timer: 2000,
            });
        })
    }, 1)
})


$(document).on('change', '#checkFactorCorrecion', function () {
    var switchState = $(this).is(':checked');
    if (switchState) {
        checkFactorCorrecion = 1;
    } else {
        checkFactorCorrecion = 0;
    }

});


