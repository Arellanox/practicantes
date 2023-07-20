
//Vista de la tabla de soporte TI
TablaVistaSoporteTi = $("#TablaVistaSoporteTi").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '65vh',
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: { api: 2 },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/asistencia_ti_bot_api.php`,
        beforeSend: function () {
        },
        complete: function () {
            TablaVistaSoporteTi.columns.adjust().draw()

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' },
        //trae el nombre y el numero de telefono concatenado
        {
            data: null, render: function (meta, data) {
                return `${meta.NOMBRE_USUARIO} (${meta.NUMERO_USUARIO})`
            }
        },
        //trae la fecha de creacion formateada
        { data: 'FECHA_CREACION', render: function (data) {
            return formatoFecha2(data,[3, 1, 4, 2,1,1,1])
        }},
        { data: 'TICKET' },
        { data: 'MSJ' },
        { data: 'ATENDIDO_POR_US' },
        { data: 'INCIO_ATENCION', render: function(data){
            return formatoFecha2(data,[3, 1, 4, 2,1,1,1])
        } },
        { data: 'TERMINO_ATENCION', render: function(data){
            return formatoFecha2(data,[3, 1, 4, 2,1,1,1])
        } },
        {
            data: null, render: function (meta, data) {
                let html = `<div class = "estatusUsuariosTabla">`
                //cambia el estatus dependiendo en el estado que se encuentre de igual forma junto al icono
                switch (meta.ID_ESTATUS) {
                    case '1':
                        html += `<i class="bi bi-check-circle-fill text-success"></i> ${meta.DESCRIPCION}`;
                        break;

                    case '2':
                        html += `<i class="bi bi-exclamation-circle-fill text-warning"></i> ${meta.DESCRIPCION}`;
                        break;
                    case '3':
                        html += `<i class="bi bi-arrow-right-circle-fill text-primary"></i><span class="clickable-text" data-bs-toggle="modal" data-bs-target="#modalPendienteSoporte">${meta.DESCRIPCION}</span>`;
                        break;
                    case '4':
                        html += `<i class="bi bi-x-circle-fill text-danger"></i> ${meta.DESCRIPCION}`;
                        break;

                    default:
                        alertToast('A ocurrido un error', 'error', 4000)
                        break;
                }
                html += '</div>'
                return html
            }
        },
        { data: 'MOTIVO_CANCELACION' },
        { data: 'METODO_SOLUCION' },
        { data: 'COMENTARIO_SOLUCION' },

    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Nombre (#)', className: 'all' },
        { target: 2, title: 'Fecha', className: 'min-tablet' },
        { target: 3, title: 'Ticket', className: 'all' },
        { target: 4, title: 'Mensaje', className: 'none' },
        { target: 5, title: 'Atendido por', className: 'desktop' },
        { target: 6, title: 'Inicio', className: 'desktop' },
        { target: 7, title: 'Fin', className: 'all' },
        { target: 8, title: 'Estatus', className: 'min-tablet' },
        { target: 9, title: 'Motivo de cancelacion', className: 'none' },
        { target: 10, title: 'Metodo de solucion', className: 'none' },
        { target: 11, title: 'Solucion', className: 'none' },
        
    ]
})

inputBusquedaTable('TablaVistaSoporteTi', TablaVistaSoporteTi, [], [], 'col-12')

//Funcion para cambiar el estatus (funcion global)
selectTable('#TablaVistaSoporteTi', TablaVistaSoporteTi, {
    unSelect: true, reload: ['col-xl-9'],
    OnlyDate: true,
    ClickClass: [
        {
            class: 'estatusUsuariosTabla',
            callback: function (data) {
                ticket = data

                switch (data['ESTATUS_ID']) {

                    //Este usuario ya fue atendido
                    case '1':
                        alertToast('Este usuario ya fue atendido', 'success', 4000)
                        break;

                    //Este usuario esta pendiente
                    case '2':
                            alertMensajeConfirm({
                                title: '¿Deseas atender a este Usuario?',
                                text: 'Se cambiara el estado de este ticket a En atención',
                                icon: 'info',
                            }, function () {
                                dataJson_tomarPaciente = {
                                    api : 3,
                                    estatus_id: data['ESTATUS_ID'],
                                    ticket: data['TICKET']
                                }
                                ajaxAwait(dataJson_tomarPaciente, 'asistencia_ti_bot_api', { callbackAfter: true }, false, function (data) {
                                    alertToast('Este usuario esta siendo atendido!', 'success', 4000)
                
                                    TablaVistaSoporteTi.ajax.reload();
                                })
                            }, 1)
                        break;
                    
                    //Este usuario esta siendo atendido  
                    //variable session_start  
                    case '3':
                        $(document).on('click', "#modalPendienteSoporte", function(e) {
                            $(document).on('submit', '#btn-guardar-solucion-problema', function (e) {
                                // e.preventDefault()
                                alertMensajeConfirm({
                                    title: '¿Deseas atender a este Usuario?',
                                    text: 'Se cambiara el estado de este ticket a En atención',
                                    icon: 'info',
                                }, function () {

                                    let dataJson_solucionProblema = {
                                        api: 3,
                                        estatus_id: ticket['ESTATUS_ID'],
                                        ticket: ticket['TICKET'],
                                        //para ver el if de una linea
                                        metodo_solucion: $("#buscar-metodo-solucion").val(),
                                        comentario_solucion: $("#comentarioSoluciuon").val()
                                    }    
        
                                    ajaxAwait(dataJson_solucionProblema, 'asistencia_ti_bot_api', {callbackAfter : true}, false, function(data){
                                    alertToast('Este usuario ya fue atendido!', 'success', 4000)
                                    TablaVistaSoporteTi.ajax.reload();
                                    })

                                }, 1)


                            })
                        })
                    
                        // ajaxAwait(dataJson_recetas, 'consultorio_recetas_api', { callbackAfter: true }, false, function (data) {
                        //     alertToast('Receta guardada!', 'success', 4000)
                        //     tablaListaRecetas.ajax.reload();
                        // })
                        // //Limpiar los datos del formulario
                        // $("#nombre_generico").val("")

                        // alertMensajeConfirm({
                        //     title: '¿Deseas terminar la atencion?',
                        //     text: 'Se cambiara el estado de este ticket a Terminado',
                        //     icon: 'info',
                        // }, function () {

                        //     dataJson_tomarPaciente = {
                        //         api : 3,
                        //         estatus_id: data['ESTATUS_ID'],
                        //         ticket: data['TICKET']
                        //     }

                        //     ajaxAwait(dataJson_tomarPaciente, 'asistencia_ti_bot_api', { callbackAfter: true }, false, function (data) {
                        //         alertToast('Este usuario esta siendo atendido!', 'success', 4000)
            
                        //         TablaVistaSoporteTi.ajax.reload();
                        //     })
                        // }, 1)

                        break;

                    //Este usuario cancelo su solicitud  
                    case '4':
                        alertToast('Este usuario ya esta cancelado', 'error', 4000)
                        break;

                    default:
                        alertToast('A ocurrido un error', 'error', 4000)
                        break;
                }
            }

        },
    ]
})