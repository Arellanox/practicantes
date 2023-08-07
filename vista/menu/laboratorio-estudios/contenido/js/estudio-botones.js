
// $("#btn-estudio-editar").click(function () {
// if (array_selected != null) {
//   getDataFirst(1, array_selected['ID_SERVICIO'])
// } else {
//   alertSelectTable();
// }
// esperaAbrirEdit(function () {

// })
// })

$(document).on('click', '#btn-estudio-editar', function (event) {
  if (array_selected != null) {
    getDataFirst(1, array_selected['ID_SERVICIO'])
  } else {
    alertSelectTable();
  }
})


$("#btn-estudio-editar-info").click(function () {
  // getatrribute
  // if (infoServicioEdit == false) {
  //   alertMensaje('info', '')
  // } else {
  getDataFirst(1, 1)

  // }
})


// $('#btn-agregar-estudio').click(function () {

// })

$(document).on('click', '#btn-agregar-estudio', function (event) {
  event.preventDefault();
  modalEdit = false;
  getDataFirst();
})



// function esperaAbrirEdit(callBack = function () { }) {

//   if (!isJson(infoServicioEdit)) {
//     callBack();
//     alertMensaje('info', 'Datos no cargados', '')
//   }
// }