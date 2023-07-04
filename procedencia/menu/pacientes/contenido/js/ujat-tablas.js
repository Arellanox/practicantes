TablaUjat = $('#TablaUjat').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    lengthChange: true,
    lengthMenu: [
        [15, 20, 25, 30, 35, 40, 45, 50, -1],
        [15, 20, 25, 30, 35, 40, 45, 50, "All"]
    ],
    info: true,
    paging: true,
    scrollY: autoHeightDiv(0, 284),
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: { api: 2 },
        method: 'POST',
        url: '../../../api/temperatura_api.php',
        beforeSend: function () {
            // loader("In", 'bottom'), array_selected = null
        },
        complete: function () {
            // loader("Out", 'bottom')
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
        { data: 'NOMBRE_COMPLETO' },
        { data: 'PROCEDENCIA' },
        { data: 'PREFOLIO' },
        //Laboratorio
        {
            data: 'LABORATORIO_CLINICO', render: function (data) {
                html = drawStatusMenuTable(data, { 0: 'muestra', 1: 'reporte', 2: 'correo' });
                return html;
            }
        },
        //Laboratorio
        {
            data: 'BIOMOLECULAR', render: function (data) {
                html = drawStatusMenuTable(data, { 0: 'muestra', 1: 'reporte', 2: 'correo' });
                return html;
            }
        },
        //Ultrasonido
        {
            data: 'ULTRASONIDO', render: function (data) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
            }
        },
        //Rayos X
        {
            data: 'RAYOS_X', render: function (data) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
            }
        },
        //Oftalmo
        {
            data: 'OFTALMOLOGIA', render: function (data) {
                return drawStatusMenuTable(data, { 0: 'reporte', 2: 'correo' });
            }
        },
        //HistoriaClinica
        {
            data: 'CONSULTORIO', render: function (data) {
                return drawStatusMenuTable(data, { 0: 'reporte', 2: 'correo' });
            }
        },
        //Electrocardiograma
        {
            data: 'ELECTROCARDIOGRAMA', render: function (data) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
            }
        },
        //Nutricion InBody
        {
            data: 'INBODY', render: function (data) {
                html = drawStatusMenuTable(data, { 0: 'capturas', 1: 'correo' });
                return html;
            }
        },
        //Espirometría
        {
            data: 'ESPIROMETRIA', render: function (data) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
            }
        },
        //Audiometria
        {
            data: 'AUDIOMETRIA', render: function (data) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
            }
        },
        //Menu
        {
            data: 'FECHA_RECEPCION',
            render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
            }
        },
        { data: 'TURNO' },
        {
            data: 'FECHA_AGENDA',
            render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
            }
        },
        {
            data: 'FECHA_REAGENDA',
            render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
            }
        },
        {
            data: 'ACTIVO',
            render: function (data) {
                return 'PENDIENTE';
            }
        },
        { data: 'GENERO' }
    ],
    columnDefs: [
        { width: "1%", targets: "col-number" },
        { width: "20%", targets: "col-20%" },
        { width: "5%", targets: "col-5%" },
        { width: "7%", targets: "col-icons" },
        { targets: "col-invisble-first", visible: false }
        // { visible: false, title: "AreaActual", targets: 20, searchable: false }
    ],

})


inputBusquedaTable("TablaUjat", TablaUjat,
    [
        {
            msj: 'Filtra la tabla con palabras u oraciones que coincidan',
            place: 'left'
        },
        {
            msj: 'Los iconos representan el estado del paciente a las areas',
            place: 'left'
        }
    ], "col-12 col-lg-6")


selectTable('#TablaUjat', TablaUjat, {
    ClickClass: {
        0: {
            class: 'GrupoInfoCreditoBtn',
            callback: function (data) {

            }
        },
        1: {
            class: 'GrupoInfoCreditoBtn',
            callback: function (data) {

            }
        }
    }
}, async function (select, data, callback) {
    if (select) {

    } else {

    }
})



function drawStatusMenuTable(array) {

}
