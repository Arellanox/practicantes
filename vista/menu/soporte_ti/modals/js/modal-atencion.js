
// console.log(TablaVistaSoporteTi)


select2('#modal-buscar-metodo-solucion', 'modalPendienteSoporte')

const formSolucionProblema = document.getElementById("formSolucionProblema");
formSolucionProblema.addEventListener("submit", function (e) {
    // console.log(row['ID_SOPORTE_TI'])
    e.preventDefault();

    alertMensajeConfirm({
        title: '¿Deseas terminar la atencion del usuario?',
        text: 'Se cambiara el estado de este ticket a En atención',
        icon: 'info',
    }, function () {
        dataJon_solucionPendiente = {
            api: 3,
            estatus_id: row['ESTATUS_ID'],
            ticket: row['TICKET'],
            metodo_solucion: $("#modal-buscar-metodo-solucion").val(),
            comentario_solucion: $("#modal-comentario-Soluciuon").val()
        }
        ajaxAwait(dataJon_solucionPendiente, 'asistencia_ti_bot_api', { callbackAfter: true }, false, function (data) {
            alertToast('Atencion finalizada!', 'success', 4000)

            $('#modalPendienteSoporte').modal('hide');
            $('#modal-buscar-metodo-solucion').val('')
            $('#modal-comentario-Soluciuon').val(undefined)
        })
    }, 1)
});