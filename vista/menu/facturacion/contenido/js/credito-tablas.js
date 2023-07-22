TablaGrupos = $('#TablaGrupos').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: autoHeightDiv(0, 284),
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: { api: 2 },
        method: 'POST',
        url: '../../../api/admon_grupos_api.php',
        beforeSend: function () {
            loader("In")
            // fadeRegistro('Out')

        },
        complete: function () {
            loader("Out")
            //Para ocultar segunda columna
            reloadSelectTable()

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    /*  createdRow: function (row, data, dataIndex) {
         if (data.FACTURADO == 1) {
             $(row).addClass('bg-success text-white');
         }
     } */
    columns: [
        { data: 'COUNT' },
        {
            data: 'FOLIO', render: function (data) {
                let html = `<div class="d-flex justify-content-center GrupoInfoCreditoBtn" style="width: 40px">  ${ifnull(data, '')}  </div>`
                return html
            }
        },
        { data: 'PROCEDENCIA' },
        {
            data: 'FECHA_CREACION', render: function (data) {
                return formatoFecha2(data, [0, 1, 3, 1]);
            }
        },
        {
            data: 'FECHA_FACTURA', render: function (data) {
                return formatoFecha2(data, [0, 1, 3, 1]);
            }
        },
        { data: 'FACTURA' }
        // {defaultContent: 'En progreso...'}
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all', width: '1%' },
        { target: 1, title: 'Folio', className: 'all', width: '20px' },
        { target: 2, title: 'Procedencia', className: 'desktop' },
        { target: 3, title: 'Creacion', className: 'none' },
        { target: 4, title: 'Fecha de Factura', className: 'none' },
        { target: 5, title: 'Factura', className: 'none' }
    ],

})


inputBusquedaTable("TablaGrupos", TablaGrupos, [], {
    msj: "Filtre los resultados por el folio o por la empresa",
    place: 'top'
}, "col-12")



selectTable('#TablaGrupos', TablaGrupos, {
    unSelect: true, reload: ['col-xl-9'],
    OnlyData: true,
    ClickClass: [
        {
            class: 'GrupoInfoCreditoBtn',
            callback: function (data) {

                $("#ModalInformacionGruposCredito_title").html(`Información Grupos de Crédito - (${ifnull(data['ID_GRUPO'])})`)
                $('#procedencia_grupos_credito').html(ifnull(data['PROCEDENCIA']));
                $('#domicilio-fiscal').html(ifnull(data['DIRECCION']));
                $('#fecha-factura').html(ifnull(formatoFecha2(data['FECHA_FACTURA'], [0, 1, 3, 1])));
                $('#factura').html(ifnull(data['FACTURA']));
                $('#rfc').html(ifnull(data['RFC']));


                $('#ModalInformacionGruposCredito').modal('show');
            },
            selected: true
        },
    ]
}, function (select, data, callback) {
    // fadeRegistro('Out')
    if (select) {
        // $(".informacion-creditos").fadeIn(0)
        DataGrupo.id_grupo = data['ID_GRUPO']
        SelectedGruposCredito = data
        TablaGrupoDetalle.ajax.reload()
        //Muestra las columnas
        callback('In')
    } else {
        callback('Out')
    }
})

var DataGrupo = {
    api: 3,
    id_grupo: 0
};


TablaGrupoDetalle = $('#TablaGrupoDetalle').DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: true,
    paging: false,
    scrollY: autoHeightDiv(0, 284),
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, DataGrupo);
        },
        method: 'POST',
        url: '../../../api/admon_grupos_api.php',
        beforeSend: function () {
            // fadeRegistro('Out')
        },
        complete: function () {
            // fadeRegistro('In')
            TablaGrupoDetalle.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        {
            data: 'PX', render: function (data) {
                return '';
            }
        },
        { data: 'PX' },
        { data: 'PREFOLIO' },
        {
            data: 'CLIENTE_ID', render: function (data) {
                let html = `<div class="d-flex justify-content-center ticketDataButton" style="width: 40px"> ${ifnull(data, 'Error')} </div>`
                return html
            }
        },
        { data: 'DIAGNOSTICO' },
        {
            data: 'FECHA_RECEPCION', render: function (data) {
                return formatoFecha2(data, [0, 1, 3, 1]);
            }
        }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all', width: '1px' },
        { target: 1, title: 'PACIENTE', className: 'all' },
        { target: 2, title: 'PREFOLIO', className: 'all' },
        { target: 3, title: 'CUENTA', className: 'all', width: '30px' },
        { target: 4, title: 'DIAGNOSTICO', className: 'min-tablet' },
        { target: 5, title: 'RECEPCION' /*FECHA*/, className: 'min-tablet' }
    ],

    dom: 'Bfrtip',
    buttons: [
        // {
        //   extend: 'copyHtml5',
        //   text: '<i class="fa fa-files-o"></i>',
        //   titleAttr: 'Copy'
        // },
        {
            text: '<i class="bi bi-receipt-cutoff"></i>  Facturar',
            className: 'btn btn-turquesa',
            action: function () {
                $('#NumeroFactura').val('')
                if (SelectedGruposCredito['FACTURADO'] == 1) {
                    alertMensaje('info', 'Grupo Facturado', `Este grupo ese ya ha sido facturado previamente (${SelectedGruposCredito['FACTURA']})`)

                    return false
                }
                factura = true;
                $("#ModalTicketCreditoFacturado").modal('show');
            }

        },
        {
            text: '<i class="bi bi-box-seam"></i> Modificar',
            className: 'btn btn-success',
            action: () => {
                if (SelectedGruposCredito['FACTURADO'] == 1) {
                    alertMensaje('info', 'Oops!', 'Este grupo ha sido facturado, no puedes actualizar su detalle.');
                    return false;
                }

                //Para modificar el grupo
                $('#title-grupo-factura').html(`Grupo: ${SelectedGruposCredito['FOLIO']}, ${SelectedGruposCredito['PROCEDENCIA']}, ${SelectedGruposCredito['FECHA_CREACION']}`)
                //Activa a que puede modificar el grupo
                $('#modalFiltroPacientesFacturacion').modal('show');

            }
        }
    ]
})


selectTable('#TablaGrupoDetalle', TablaGrupoDetalle, {
    OnlyData: true,
    ClickClass: [
        {
            class: 'ticketDataButton',
            callback: function (data) {
                alertToast('Cargando, espere un momento', 'info', 3000)
                let px = data['PX']
                $('#PacienteCreditoColumn').html("");
                console.log(data)
                ajaxAwait({
                    api: 1,
                    turno_id: data['ID_TURNO']
                }, "cargos_turnos_api", { callbackAfter: true }, false, function (data) {
                    $("#paciente").html(px)
                    dataServicios = data.response.data.estudios

                    let subtotal = 0;
                    for (const data in dataServicios) {
                        if (Object.hasOwnProperty.call(dataServicios, data)) {
                            const element = dataServicios[data];

                            subtotal += ifnull(parseFloat(element['COSTO']), 0);
                            totalServicio = ifnull((parseInt(element['CANTIDAD']) * parseFloat(element['COSTO'])).toFixed(2), 0)

                            let html = `
                                    <tr>
                                        <td>${element['SERVICIOS']}</td>
                                        <td>E48 -Unidad de
                                            servicio
                                        </td>
                                        <td>${ifnull(element['COSTO'], 0)}</td>
                                        <td>${ifnull(element['CANTIDAD'], 1)}</td>
                                        <td>$${ifnull(totalServicio, 0)}</td>
                                    </tr>
                                    `;

                            $('#PacienteCreditoColumn').append(html);

                        }
                    }

                    let subtotalconiva = parseFloat(subtotal * 0.16).toFixed(2);
                    total = parseFloat(subtotal) + parseFloat(subtotalconiva)

                    $("#subtotal").html(`$${ifnull(subtotal.toFixed(2), 0)}`)
                    $("#Iva").html(`$${(ifnull(subtotalconiva, 0), 0)}`)
                    $("#total").html(`$${ifnull(total.toFixed(2), 0)}`)

                    $("#ModalTicketCredito").modal('show');
                })

            }
        }
    ]
})


inputBusquedaTable('TablaGrupoDetalle', TablaGrupoDetalle, [], {
    msj: "Filtre los resultados por coincidencia",
    place: 'top'
}, 'col-12')

function fadeRegistro(tipe) {
    if (tipe == 'Out') {
        $("#TablaGrupoDetalleCard").fadeOut(0)
        $("#loaderDivmuestras").fadeIn(0);
        $("#loader-muestras").fadeIn(0);
    } else if (tipe == 'In') {
        $("#TablaGrupoDetalleCard").fadeIn(0)
        $("#loaderDivmuestras").fadeOut(0);
        $("#loader-muestras").fadeOut(0);
    }
}







