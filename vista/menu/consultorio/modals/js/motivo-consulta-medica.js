$('#formMotivoConsultaMedica').submit(function (e) {
    e.preventDefault();
    idConsultaMedica = 'ajax';
    obtenerConsultorioConsultaMedica(pacienteActivo.array, idConsultaMedica);
    //Meter ajax para guardar el motivo de motivo de consulta
})