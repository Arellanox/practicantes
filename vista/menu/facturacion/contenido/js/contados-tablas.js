tablaContados = $('#TablaContados').DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    scrollY: autoHeightDiv(0, 374),
    scrollCollapse: true,
    deferRender: true,
    lengthMenu: [
        [10, 15, 20, 25, 30, 35, 40, 45, 50, -1],
        [10, 15, 20, 25, 30, 35, 40, 45, 50, "All"]
    ],
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
        { data: 'FECHA_RECEPCION' },
        {
            data: 'FACTURA', render: function (data) {
                return data == 1 ? '<p class="fw-bold text-success" style="letter-spacing: normal !important;">Finalizado</p>' : '<p class="fw-bold text-warning" style="letter-spacing: normal !important;">En proceso</p>';
        } },
        { data: 'TURNO' },
        { data: 'GENERO' }
        // {defaultContent: 'En progreso...'}
    ],
    columnDefs: [
        { target: 0, title: "#" },
        { target: 1, title: "NOMBRE" },
        { target: 2, title: "PREFOLIO" },
        { target: 3, title: "FECHA " },
        { target: 4, title: "FACTURA" },
        { target: 5, title: "TURNO" },
        {target: 6, title: "GENERO"}
        /* { width: "5px", targets: 0 },
        { target: [1, 3], width: '20%' },
        { target: [4], width: '13%' }, */
        // { width: "30px", targets: 7 }

    ],

})

selectDatatable("TablaContados", tablaContados, 0, 0, 0, 0, async function (select, data) {
    if (select) {
        obtenerPanelInformacion(data['ID_TURNO'], 'tickets_api', 'PanelTickets', '#InformacionTickets')
        obtenerPanelInformacion(data['ID_TURNO'], 'tickets_api', 'PanelFactura','#InformacionFactura')
    }
})

