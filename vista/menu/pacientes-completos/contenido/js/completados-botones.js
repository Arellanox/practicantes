$(document).on('click', '.btn-editar, #btn-editar', function () {
    if (array_selected != null) {
        $("#ModalEditarPaciente").modal('show');
    } else {
        alertSelectTable();
    }
})




$(document).on('click', '#btn-concluir-paciente', function (e) {
    if (array_selected) {
        let btn = $(this)
        let concluido = btn.attr('data-concluir');
        if (concluido == 0) {
            title = 'abrir'
            text = 'se abrirá el proceso para hacer modificaciones'
            text_2 = 'se ha abierto su proceso para hacer modificaciones'
        } else {
            title = 'finalizar'
            text = 'ya no se podrán hacer mas modificaciones.'
            text_2 = 'ha sido cerrado, ya no podrás crear modificaciones al paciente...'
        }

        alertMensajeConfirm({
            title: `¿Estás seguro de ${title} el proceso de recepción del paciente?`,
            text: `El paciente, ${array_selected['NOMBRE_COMPLETO']}, ${text}`,
            icon: 'warning'
        }, function () {
            let data = ajaxAwait({
                api: 19, // <-- desmarcar o marcar
                turno_completado: concluido ? 0 : 1,
                id_turno: array_selected['ID_TURNO']
            }, 'turnos_api')

            if (data) {
                // let row = data.response.data;
                alertMsj({
                    title: '¡Listo!',
                    text: `El paciente: ${array_selected['NOMBRE_COMPLETO']}, ${text_2}`,
                    footer: 'Cargando nuevamente las tablas...',
                    icon: 'success',
                    showCancelButton: false,
                })
                try { tablaCompletados.ajax.reload() } catch (error) { }
                // try { tablaRecepcionPacientes.ajax.reload() } catch (error) { }
            }

        }, 1)
    } else {
        alertSelectTable();
    }

});