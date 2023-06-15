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


$("#ModalFirmaTemperatura").on('click', function (e) {
    e.preventDefault();
    console.log("estas en firma modal")

    $('#TemperaturaModalFirma').modal('show');
})

$("#EquiposTemperaturasForm").on("submit", function (e) {
    e.preventDefault();

    console.log($("#Equipo").val())
    id_equipos = $("#Equipo").val()

    DataEquipo = {
        api: 2,
        Enfriador: id_equipos
    }

    tablaTemperaturaFolio.ajax.reload()


    $('#lista-meses-temperatura').fadeToggle(0)
    $('#LibererDiaTemperatura').fadeIn(0);
})
