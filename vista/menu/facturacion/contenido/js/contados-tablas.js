// $('#TablaContados thead tr')
//     .clone(true)
//     .addClass('filters')
//     .appendTo('#TablaContados thead');

tablaContados = $('#TablaContados').DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    scrollY: autoHeightDiv(0, 374),
    scrollCollapse: true,
    deferRender: true,
    ajax: {
        dataType: 'json',
        data: { api: 2, estado: 1 },
        method: 'POST',
        url: '../../../api/tickets_api.php',
        beforeSend: function () {
            loader("In")
        },
        complete: function () {
            loader("Out")
            tablaContados.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        //NUMERO,  NOMBRE DEL PACIENTE, PREFOLIO, FECHA DE RECEPCION QUE FUE ACEPTADO O TERMMINADO, FACTURA SI O NO, GENERO, TURNO 
        { data: 'COUNT' },
        { data: 'NOMBRE_COMPLETO' },
        { data: 'PREFOLIO' },
        {
            data: 'FECHA_IMPRESION', render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
            }
        },
        {
            data: 'FACTURA', render: function (data) {
                // return data == 1 ? '<p class="fw-bold text-success" style="letter-spacing: normal !important;">Facturado</p>' : '<p class="fw-bold text-warning" style="letter-spacing: normal !important;">No facturado</p>';
                return data != 0 ? data : '<p class="fw-bold text-warning" style="letter-spacing: normal !important;">Sin Facturar</p>';
            }
        },
        {
            data: 'FECHA_FACTURA', render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0]);
            }
        },
        { data: 'TURNO' },
        { data: 'GENERO' },
        {
            data: 'FACTURA', render: function (data) {
                return data != 0 ? 'Facturado' : 'Sin Facturar'; // <-- Buscable
            }
        }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Nombre', className: 'all' },
        { target: 2, title: 'Prefolio', className: 'all' },
        { target: 3, title: 'Finalizado', className: 'all' },
        { target: 4, title: 'Factura', className: 'all' },
        { target: 5, title: 'Fecha', className: 'all' },
        { target: 6, title: 'Turno', className: 'none' },
        { target: 7, title: 'Genero', className: 'none' },
        { target: 8, visible: false, searchable: true }, // <-- ocultarlo pero buscable para los facturados

    ],

    // dom: 'Bfrtip',
    // buttons: [
    //     {
    //         extend: 'copyHtml5',
    //         text: '<i class="fa fa-files-o"></i>',
    //         titleAttr: 'Copy'
    //     },
    //     {
    //         extend: 'excelHtml5',
    //         text: '<i class="fa fa-file-excel-o"></i>',
    //         titleAttr: 'Excel'
    //     },
    //     {
    //         extend: 'csvHtml5',
    //         text: '<i class="fa fa-file-text-o"></i>',
    //         titleAttr: 'CSV'
    //     },
    //     {
    //         extend: 'pdfHtml5',
    //         text: '<i class="fa fa-file-pdf-o"></i>',
    //         titleAttr: 'PDF'
    //     }
    // ]

    //UNA IDEA de funcion
    // initComplete: function () {
    //     var api = this.api();

    //     // For each column
    //     api
    //         .columns()
    //         .eq(0)
    //         .each(function (colIdx) {
    //             // Set the header cell to contain the input element
    //             var cell = $('.filters th').eq(
    //                 $(api.column(colIdx).header()).index()
    //             );
    //             var title = $(cell).text();
    //             $(cell).html('<input type="text" style="width: 100%" placeholder="' + title + '" />');

    //             // On every keypress in this input
    //             $(
    //                 'input',
    //                 $('.filters th').eq($(api.column(colIdx).header()).index())
    //             )
    //                 .off('keyup change')
    //                 .on('change', function (e) {
    //                     // Get the search value
    //                     $(this).attr('title', $(this).val());
    //                     var regexr = '({search})'; //$(this).parents('th').find('select').val();

    //                     var cursorPosition = this.selectionStart;
    //                     // Search the column for that value
    //                     api
    //                         .column(colIdx)
    //                         .search(
    //                             this.value != ''
    //                                 ? regexr.replace('{search}', '(((' + this.value + ')))')
    //                                 : '',
    //                             this.value != '',
    //                             this.value == ''
    //                         )
    //                         .draw();
    //                 })
    //                 .on('keyup', function (e) {
    //                     e.stopPropagation();

    //                     $(this).trigger('change');
    //                     $(this)
    //                         .focus()[0]
    //                         .setSelectionRange(cursorPosition, cursorPosition);
    //                 });
    //         });
    // },
})





selectDatatable("TablaContados", tablaContados, 0, 0, 0, 0, async function (select, data) {
    if (select) {
        await obtenerPanelInformacion(data['TURNO_ID'], 'tickets_api', 'PanelTickets', '#InformacionTickets')
    } else {
        await obtenerPanelInformacion(0, 'tickets_api', 'PanelTickets', '#InformacionTickets')
    }
})


inputBusquedaTable('TablaContados', tablaContados, [
    {
        msj: 'Dale click a un registro para ver la información de ticket y/o factura.',
        place: 'top'
    }
])

