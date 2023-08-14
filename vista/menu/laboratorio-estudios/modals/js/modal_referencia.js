select2('#select-operador-referencia', 'modalReferencia')
rellenarSelect("#select-operador-referencia", "valores_referencia_api", 2, "ID_OPERADORES_LOGICOS", "DESCRIPCION");


// Detecta si lo que esta escribiendo es negativo si es asi lo manda a la verga
$(document).ready(function () {
    $(document).on('keydown', '#edad-minima-referencia, #edad-maxima-referencia', function (event) {
        if (event.key === '-' || event.key === 'e') {
            event.preventDefault();
        }
    });
});

//Desactiva los imput de maximo y minimo de edad
$('#SinEdad').on('click', function (e) {
    var minimaReferencia = $('#edad-minima-referencia');
    var maximaReferencia = $('#edad-maxima-referencia');

    if ($(this).prop('checked')) {
        minimaReferencia.addClass('disable-element');
        maximaReferencia.addClass('disable-element');

        limpiarInputs('SinEdad', true)
    } else {
        minimaReferencia.removeClass('disable-element');
        maximaReferencia.removeClass('disable-element');
    }
})

$(document).on('change, keyup, click', '#cambioReferencia', function () {


    if ($(this).is(':checked')) {
        $('#resultado-select-rango').fadeIn(1);
        $('#cambio-rango-referencia').fadeOut(1);


        limpiarInputs('cambioReferencia', true)
    } else {
        $('#resultado-select-rango').fadeOut(1);
        $('#cambio-rango-referencia').fadeIn(1);

        limpiarInputs('cambioReferencia', false)
    }
})

$(document).on('click', '#btn-guardar-referencia', function (e) {
    e.preventDefault();
    alertMensajeConfirm({
        title: '¿Esta seguro de guardar los valores de referencia?',
        text: 'No podra modificarlo',
        icon: 'info',
        showCancelButton: true,
    }, function () {
        ajaxAwaitFormData({
            api: 1,
            servicio_id: array_selected['ID_SERVICIO']
        }, 'valores_referencia_api', 'formGuardarReferencia', { callbackAfter: true }, false, function (data) {
            alertToast(text, 'success', 4000)
        })
    }, 1)

})

function limpiarInputs(elementID, isChecked) {
    switch (elementID) {
        case 'SinEdad':
            if (isChecked) {
                $('#edad-maxima-referencia').val('')
                $('#edad-minima-referencia').val('')
            }
            break;
        case 'cambioReferencia':
            if (isChecked) {
                $('#valor_minimo').val('')
                $('#valor_maximo').val('')
            } else {
                $('#valor_referencia').val('')
            }
            break;
    }
}