$('#formMotivoConsultaMedica').submit(function (e) {
    e.preventDefault();

    alertMensajeConfirm({
        title: '¿Deseas crear la consulta?',
        text: 'No podrás actualizar el motivo de consulta.',
        icon: 'warning'
    }, function () {
        ajaxAwaitFormData({
            api: 5,
            turno_id: pacienteActivo.array['ID_TURNO'],
            motivo_consulta: $('#motivo_consulta').val()
        },
            'consultorio2_api', 'formMotivoConsultaMedica', { callbackAfter: true }, false, (data) => {
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


