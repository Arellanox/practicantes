$('#formFacturarPaciente').submit(function (event) {
    event.preventDefault();

    if (selectCuenta) {
        alertMensajeConfirm({
            title: '¿Esta seguro de guardar la factura?',
            text: 'Guardará/Actualizará la factura de este paciente',
            icon: 'info'
        }, () => {
            ajaxAwaitFormData({
                api: 1,
                id_turno: selectCuenta.array['id']
            }, 'cargos_turnos_api', 'formFacturarPaciente', { callbefore: true, resetForm: true }, false, (data) => {
                $('#modalFacturarCuenta').modal('hide');
                tablaContados.ajax.reload()
                alertToast('Paciente facturado', 'success', 4000)
            })
        }, 1)
    } else {
        alertToast('Debe seleccionar un registro', 'warning', 4000)
    }

})

const modalFacturarCuenta = document.getElementById('modalFacturarCuenta')
modalFacturarCuenta.addEventListener('show.bs.modal', event => {
    $('#formFacturarPaciente input').val(selectCuenta.array.data['FACTURA'] != 0 ? selectCuenta.array.data['FACTURA'] : '')
})