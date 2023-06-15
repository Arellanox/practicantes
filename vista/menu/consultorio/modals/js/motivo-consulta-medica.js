$('#formMotivoConsultaMedica').submit(function (e) {
    e.preventDefault();


    alertMensajeConfirm({
        title: '¿Deseas crear la consulta?',
        text: 'No podrás actualizar el motivo de consulta.',
        icon: 'warning'
    }, function () {
        ajaxAwaitFormData({ api: 5, id_turno: pacienteActivo.array['ID_TURNO'] }, 'consultorio2_api', 'formMotivoConsultaMedica', { callbackAfter: true }, false, (data) => {
            let data = data.response.data;
            obtenerConsultorioConsultaMedica(pacienteActivo.array, data);
        })

    }, 1)

    // Crear un ajax el  cual pueda crear  una consulta medica, y recuperar los datos del  mismo,  motivo de consulta,  fecha ...etc, y mandarlo como segundo parametro a la funcion
    // obtenerConsultorioConsultaMedica
    // Despues cerrar modal ($('#modalMotivoConsultaMedica').modal('hide'))



    //Meter ajax para guardar el motivo de motivo de consulta
})