// $(document).on('click', "#modalPendienteSoporte", function() {
//     $('#formSolucionProblema').submit(function(e){
//         e.preventDefault();

//         alertMensajeConfirm({
//             title: '¿Deseas terminar la atencion del usuario?',
//             text: 'Se cambiara el estado de este ticket a En atención',
//             icon: 'info',
//         }, function () {
//             dataJon_solucionPendiente = {
//                 api : 3,
//                 estatus_id: '3',
//                 metodo_solucion : $("#buscar-metodo-solucion").val(),
//                 comentario_solucion : $("#comentarioSoluciuon").val()
//             }
//             ajaxAwait(dataJon_solucionPendiente, 'asistencia_ti_bot_api', { callbackAfter: true }, false, function (data) {
//                 alertToast('Atencion finalizada!', 'success', 4000)

//                 TablaVistaSoporteTi.ajax.reload();
//             })
//         }, 1)
//     })
// })

select2('#buscar-metodo-solucion', 'modalPendienteSoporte')




// let dataJson_recetas = {
//     api: 1,
//     turno_id: pacienteActivo.array['ID_TURNO'],
//     nombre_generico: $("#nombre_generico").val(),
//     nombre_comercial: $("#nombre_comercial").val(),
//     forma_farmaceutica: $("#forma_farmaceuticaval").val(),
//     dosis: $("#dosis").val(),
//     presentacion: $("#presentacion").val(),
//     frecuencia: $("#frecuencia").val(),
//     via_de_administracion: $("#via_de_administracion").val(),
//     duracion_de_tratamiento: $("#duracion_de_tratamiento").val(),
//     indicaciones_de_uso: $("#indicaciones_de_uso").val()
// }
// ajaxAwait(dataJson_recetas, 'consultorio_recetas_api', { callbackAfter: true }, false, function (data) {
//     alertToast('Receta guardada!', 'success', 4000)
//     tablaListaRecetas.ajax.reload();
// })
// //Limpiar los datos del formulario
// $("#nombre_generico").val(""),
//     $("#nombre_comercial").val(""),
//     $("#forma_farmaceuticaval").val(""),
//     $("#dosis").val(""),
//     $("#presentacion").val(""),
//     $("#frecuencia").val(""),
//     $("#via_de_administracion").val(""),
//     $("#duracion_de_tratamiento").val(""),
//     $("#indicaciones_de_uso").val("")