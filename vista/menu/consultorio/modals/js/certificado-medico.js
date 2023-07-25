

$('#btn-subir-certificado-medico').on('click', function () {
    alertMensajeConfirm({
        title: '¿Está seguro de guardar este certificado?',
        text: 'Solo hay un espacio para guardar los certificados, se guardará o reemplazará si hay uno anterior.',
        textButtonConfirm: 'Si, acepto',
        icon: 'warning',
    }, () => {
        ajaxAwaitFormData({
            turno_id: pacienteActivo.array['ID_TURNO'], api: 1
        }, 'certificado_medico_api', 'subirResultadosCertificadoMedico', { callbackAfter: true }, false, function () {
            alertToast('El certificado medico ya ha sido guardado', 'success', 4000);
            $('#modalCertificadoMedico').modal('hide');
        })
    }, 1)
})


