
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
                        html += `<i class="bi bi-arrow-right-circle-fill text-primary"></i> ${meta.DESCRIPCION}`;
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

    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Nombre (#)', className: 'all' },
        { target: 2, title: 'Fecha', className: 'min-tablet' },
        { target: 3, title: 'Tikect', className: 'all' },
        { target: 4, title: 'Mensaje', className: 'none' },
        { target: 5, title: 'Atendido por', className: 'desktop' },
        { target: 6, title: 'Inicio', className: 'desktop' },
        { target: 7, title: 'Fin', className: 'all' },
        { target: 8, title: 'Estatus', className: 'min-tablet' },
        { target: 9, title: 'Motivo de cancelacion', className: 'none' },
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

                switch (data['ESTATUS_ID']) {

                    //Este usuario ya fuie atendido
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
                                estatus_id: '3',
                                ticket: data['TICKET']
                            }

                            ajaxAwait(dataJson_tomarPaciente, 'asistencia_ti_bot_api', { callbackAfter: true }, false, function (data) {
                                alertToast('Este usuario esta siendo atendido!', 'success', 4000)
                                
                                TablaVistaSoporteTi.ajax.reload();
                            })
                        }, 1)
                        break;
                    
                    //Este usuario esta siendo atendido    
                    case '3':
                        alertToast('Este usuario esta siendo atendido', 'info', 4000)
                        break;

                    //Este usuario cancelo su solicitud  
                    case '4':
                        alertMensajeConfirm({
                            title: '¿Deseas atender a este Usuario?',
                            text: 'Se cambiara el estado de este ticket a En atención',
                            icon: 'info',
                        }, function () {

                            dataJson_cacelarUsuario = {
                                api : 3,
                                estatus_id: '4',
                                ticket: data['TICKET']
                            }

                            ajaxAwait(dataJson_cacelarUsuario, 'asistencia_ti_bot_api', { callbackAfter: true }, false, function (data) {
                                alertToast('Este usuario hizo una cancelacion', 'error', 4000)
                                
                                TablaVistaSoporteTi.ajax.reload();
                            })
                        }, 1)
                        break;

                    default:
                        alertToast('A ocurrido un error', 'error', 4000)
                        break;
                }
            }

        },
    ]
})