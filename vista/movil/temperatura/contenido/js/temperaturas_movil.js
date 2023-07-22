// Button para enviar el formulario de nuevo registro de temperaturas desde el QR
$("#formCapturarTemperatura").on('submit', function (e) {
    e.preventDefault();

    alertToast('Temperatura Capturada', 'success', 4000);
    $("#formCapturarTemperatura").trigger("reset");


    // ajaxAwaitFormData({}, 'temperatura_api', 'formCapturarTemperatura', { callbackAfter: true }, false, function (data) {
    //     alertToast('Temperatura Capturada', 'success', 4000);
    // })
})


