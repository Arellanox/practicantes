$(document).on("click", ".btn-editar", function (e) {
    e.stopPropagation()

    editRegistro = true
    if (selectRegistro && !(validarPermiso('SupTemp') ? false : parseInt(selectRegistro['ESTATUS']))) {
        firstSelect(true)
    } else {
        alertToast("No ha seleccionado ningun registro", "info", 4000)
    }
})

$(document).on('click', '.btn-liberar', function (event) {
    event.stopPropagation();

    alertMensajeConfirm({
        title: '¿Desea liberar este registro?',
        text: 'Cualquier usuario que pueda registrar temperatura podrá actualizar el registro',
        icon: 'warning',
        confirmButtonText: 'Si, estoy seguro',
        cancelButtonText: 'No'
    }, () => {
        ajaxAwait({
            api: 6,
            id_registro_temperatura: selectRegistro['ID_REGISTRO_TEMPERATURA'],
            estatus: 0
        }, 'temperatura_api', { callbackAfter: true }, false, () => {
            // alertMensaje('success', '')
            alertToast('Registro liberado', 'success', 4000)
            if (selectTableFolio) {
                console.log('si entro')
                tablaTemperatura.ajax.reload()
            } else {
                console.log('No')
                tablaTemperaturaFolio.ajax.reload()
            }
        })
    }, 1)
})

$("#EquiposTemperaturasForm").on("submit", function (e) {
    e.preventDefault();

    let data = new FormData(document.getElementById("EquiposTemperaturasForm"));

    console.log(data)
})

ajaxAwaitFormData({
    api: 1
}, "temperaturas_api.php", "EquiposTemperaturasForm", { alertBefore: false }, false, function (response) {

})