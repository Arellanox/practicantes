

$('#btn-subir-certificado-medico').on('click', function () {
    ajaxAwaitFormData({
        turno_id: pacienteActivo.array['ID_TURNO'],
        api: 1
    }, 'certificado_medico_api', 'subirResultadosCertificadoMedico', { callbackAfter: true }, false, function () {
        
        alertToast('El certificado medico ya ha sido guardado', 'success', 4000);
    })
})


