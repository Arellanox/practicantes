
//Para iniciar el motivo consulta una vez iniciado...
$(document).on('submit', '#formMotivoConsultaMedica', function (e) {
    e.preventDefault();

    alertMensajeConfirm({
        title: '¿Desea iniciar el motivo de consulta?',
        text: '¡No podrás actualizarlo!',
        icon: 'warning'
    }, function () {
        ajaxAwaitFormData({
            api: 5,
            turno_id: pacienteActivo.array['ID_TURNO'],
        }, 'consultorio2_api', 'formMotivoConsultaMedica', { callbackAfter: true }, false, (data) => {
            data = data.response.data;

            //Se mandan a la funcion obtenerConsultorioConsultaMedica 
            obtenerConsultorioConsultaMedica(pacienteActivo.array, data);

            //Lo oculta una vez realizada la insercion
            $('#modalMotivoConsultaMedica').modal('hide')

        })
    }, 1)
})
