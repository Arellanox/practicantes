//Regresar a perfil de paciente
$('#btn-regresar-vista').click(function () {
    alertMensajeConfirm({
        title: "¿Está seguro de regresar?",
        text: "¡Asegurese de guardar los cambios!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    }, function () {
        obtenerContenidoAntecedentes(pacienteActivo.array)
    })
})
