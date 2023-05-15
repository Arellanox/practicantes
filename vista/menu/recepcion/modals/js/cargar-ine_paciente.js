// Obtener datos del paciente seleccionado
const modalPacienteIne = document.getElementById('modalPacienteIne')
modalPacienteIne.addEventListener('show.bs.modal', event => {
    // document.getElementById("title-paciente_perfil_imagen").innerHTML = ;
    $('#title-paciente_ine').html("Cargar credencial de elector: <br />" + array_selected['NOMBRE_COMPLETO']);

})

//Rechazados
$("#formInePaciente").submit(async function (event) {
    event.preventDefault();

    let dataAjax = await ajaxAwaitFormData({
        turno_id: array_selected['ID_TURNO'],
        api: 10
    }, 'recepcion_api', 'formInePaciente')

    if (dataAjax) {
        alertToast('Credencial cargada', 'success', 4000)
    }

    $('#modalPacienteIne').modal('hide');

    event.preventDefault();
});



