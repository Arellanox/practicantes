// Obtener datos del paciente seleccionado
const modalPacientePerfil = document.getElementById('modalPacientePerfil')
modalPacientePerfil.addEventListener('show.bs.modal', event => {
  // document.getElementById("title-paciente_perfil_imagen").innerHTML = ;
  $('#title-paciente_perfil_imagen').html("Imagen de perfil al paciente: <br />" + array_selected['NOMBRE_COMPLETO']);

})

//Rechazados
$("#formPerfilPaciente").submit(async function (event) {
  event.preventDefault();

  let dataAjax = await ajaxAwaitFormData({
    turno_id: array_selected['ID_TURNO'],
    api: 10
  }, 'recepcion_api', 'formPerfilPaciente')

  if (dataAjax) {
    alertToast('Avatar cargado', 'success', 4000)
  }

  $('#modalPacientePerfil').modal('hide');

  event.preventDefault();
});



