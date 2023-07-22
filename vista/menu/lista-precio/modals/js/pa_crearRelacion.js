// const ModalCrearRelacion = document.getElementById("ModalCrearRelacion");
// ModalCrearRelacion.addEventListener("show.bs.modal", (event) => {
//
//
//
//     rellenarSelect('#relacion-paquete','paquetes_api', 5,0,'DESCRIPCION');
//
// });
//
// select2("#relacion-cliente", 'ModalCrearRelacion' )
// select2("#relacion-paquete", 'ModalCrearRelacion' )
//
//
//
//
//
// //Formulario de Preregistro
// $("#formCrearRelacion").submit(function (event) {
//   event.preventDefault();
//   /*DATOS Y VALIDACION DEL REGISTRO*/
//   var form = document.getElementById("formCrearRelacion");
//   var formData = new FormData(form);
//     formData.set('api', 1);
//   Swal.fire({
//     title: "¿Está seguro que Realizar esta Relacion?",
//     text: "¡Verifique Las Selecciones Realizadas Antes de Continuar!",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "Aceptar",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       // $('#submit-registrarEstudio').prop('disabled', true);
//       // Esto va dentro del AJAX
//
//       $.ajax({
//         data: formData,
//         url: "../../../api/paquetes_api.php",
//         type: "POST",
//         processData: false,
//         contentType: false,
//         success: function (data) {
//           data = jQuery.parseJSON(data);
//           if (mensajeAjax(data)) {
//             Toast.fire({
//               icon: "success",
//               title: "Relacion Creada !",
//               timer: 2000,
//             });
//             document.getElementById("formCrearRelacion").reset();
//             $("#ModalCrearRelacion").modal("hide");
//             // tablaEquipo.ajax.reload();
//           }
//         },
//       });
//     }
//   });
//   event.preventDefault();
// });
