var checkFactorCorrecion;
BuildPage()

// Renderizar Contenido Principal:
async function BuildPage() {

    equipo_id == '' ? equipo_id = false : equipo_id = equipo_id;

    if (!equipo_id) {
        alertToast('No se encontro ningun equipo', 'error', 5000);
        return false;
    }


    await ajaxAwait({
        api: 1,
        id_equipo: equipo_id,
        id_tipos_equipos: 5
    }, 'equipos_api', { callbackAfter: true }, false, (data) => {
        selectedEquipos = data.response.data;

        selectedEquipos.forEach(e => {
            $("#agregartitle").html(`Agregar Temperaturas del equipo: ${e['DESCRIPCION']}`)
        });
    })

    loader('Out')
}

// Button para enviar el formulario de nuevo registro de temperaturas desde el QR
$("#formCapturarTemperatura").on('submit', function (e) {
    e.preventDefault();
    // console.log(equipo_id)


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

// Event onChange que setea la variable checkFactorCorrecion 
$(document).on('change', '#checkFactorCorrecion', function () {
    var switchState = $(this).is(':checked');
    if (switchState) {
        checkFactorCorrecion = 1;
    } else {
        checkFactorCorrecion = 0;
    }

});



