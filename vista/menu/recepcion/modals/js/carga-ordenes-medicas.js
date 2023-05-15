// Obtener datos del paciente seleccionado
const modalOrdenesMedicas = document.getElementById('modalOrdenesMedicas')
modalOrdenesMedicas.addEventListener('show.bs.modal', event => {
    // document.getElementById("title-paciente_perfil_imagen").innerHTML = ;
    $('#title-orden_medica').html("Cargar ordenes medicas: <br />" + array_selected['NOMBRE_COMPLETO']);

})

//Rechazados
$("#formOrdenesMedicasPaciente").submit(async function (event) {
    event.preventDefault();

    let dataAjax = await ajaxAwaitFormData({
        turno_id: array_selected['ID_TURNO'],
        api: 10
    }, 'recepcion_api', 'formOrdenesMedicasPaciente')

    if (dataAjax) {
        alertToast('Orden medicas cargada', 'success', 4000)
    }

    $('#modalOrdenesMedicas').modal('hide');

    event.preventDefault();
});



