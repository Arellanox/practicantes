// $('#TablaContados thead tr')
//     .clone(true)
//     .addClass('filters')
//     .appendTo('#TablaContados thead');

tablaContados = $('#TablaTemperatura').DataTable({
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
        { data: 'COUNT' }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' }

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





/* selectDatatable("TablaContados", tablaContados, 0, 0, 0, 0, async function (select, data) {
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
 */
