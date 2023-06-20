$('#formMotivoConsultaMedica').submit(function (e) {
    e.preventDefault();

    alertMensajeConfirm({
        title: '¿Desea iniciar el motivo de consulta?',
        text: '¡No podrás actualizarlo!',
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

select2('#select-cita-subsecuente-consulta', 'modalMotivoConsulta')



$('#checkCitaSubsecuente-consulta').change(function () {
    if ($(this).is(":checked")) {
        $('#select-cita-subsecuente-consulta').removeAttr('required');
        $('#select-cita-subsecuente-consulta').prop('disabled', true);
    } else {
        $('#select-cita-subsecuente-consulta').prop('required', true);
        $('#select-cita-subsecuente-consulta').prop('disabled', false);
        $('#select-cita-subsecuente-consulta').focus();
    }
})




const modalMotivoConsulta = document.getElementById("modalMotivoConsulta");
modalMotivoConsulta.addEventListener("show.bs.modal", (event) => {

    rellenarSelect('#select-cita-subsecuente', 'consulta2_api', 2, 'ID_CONSULTA', 'MOTIVO_CONSULTA', {
        id_paciente: pacienteActivo.array['ID_PACIENTE']
    }, function (array) {
        if (array.length == 0) {
            $('#select-cita-subsecuente-consulta').removeAttr('required');
            $('#select-cita-subsecuente-consulta').prop('disabled', true);
            $('#checkCitaSubsecuente-consulta').prop('checked', true);
        }
    })
});
