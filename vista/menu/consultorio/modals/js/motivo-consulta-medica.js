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

            obtenerConsultorioConsultaMedica(pacienteActivo.array, data);

            $('#modalMotivoConsultaMedica').modal('hide')


        })
    }, 1)
    // Crear un ajax el  cual pueda crear  una consulta medica, y recuperar los datos del  mismo,  motivo de consulta,  fecha ...etc, y mandarlo como segundo parametro a la funcion
    // obtenerConsultorioConsultaMedica
    // Despues cerrar modal ($('#modalMotivoConsultaMedica').modal('hide'))<--Listo

    //Meter ajax para guardar el motivo de motivo de consulta
})
