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
            fadeRegistro('Out')
            $(".informacion-creditos").fadeOut(0);
        },
        complete: function () {
            // loader("Out")
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
                let html = `<div class="noClicked" id="GrupoInfoCreditoBtn">
                ${data}
                </div>`
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
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Folio', className: 'all' },
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

loaderDiv("Out", null, "#loader-muestras", '#loaderDivmuestras');

// selectDatatable("TablaGrupos", TablaGrupos, 0, 0, 0, 0, function (select, data) {

//     if (select) {
//         $(".informacion-creditos").fadeIn(0)
//         DataGrupo.id_grupo = data['ID_GRUPO']
//         SelectedGruposCredito = data

//         TablaGrupoDetalle.ajax.reload()
//     } else {
//         $(".informacion-creditos").fadeOut(0);
//         fadeRegistro('Out')
//         $("#FacturarGruposCredito").fadeOut(0);
//     }
// })


selectTable('#TablaGrupos', TablaGrupos, { unSelect: true, movil: false, reload: ['col-xl-9'] }, async function (select, data, callback) {

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
            fadeRegistro('Out')
        },
        complete: function () {
            fadeRegistro('In')
            TablaGrupoDetalle.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' },
        { data: 'PX' },
        { data: 'PREFOLIO' },
        {
            data: 'CLIENTE_ID', render: function (data) {
                let html = `<div class="" id="ticketDataButton">
                ${data}
                </div>`
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
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'PACIENTE', className: 'all' },
        { target: 2, title: 'PREFOLIO', className: 'all' },
        { target: 3, title: 'CUENTA', className: 'all' },
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
            id: 'FacturarGruposCredito',
            className: 'btn btn-turquesa',
            action: function (data) {
                if (SelectedGruposCredito['FACTURADO'] == 1) {
                    alertMensaje('info', 'Grupo Facturado', `Este grupo ese ya ha sido facturado previamente (${SelectedGruposCredito['FACTURA']})`)

                    return false
                }
                alertMensajeConfirm({
                    title: 'Requiere Factura?',
                    text: '',
                    icon: 'info',
                    confirmButtonText: "Si, Requiero Factura"
                }, () => {
                    factura = true;
                    $("#ModalTicketCreditoFacturado").modal('show');
                }, 1)
            }

        }]
})


selectTable('#TablaGrupoDetalle', TablaGrupoDetalle, { OnlyData: true }, async function (select, data) {
    SelectedPacienteCredito = data
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