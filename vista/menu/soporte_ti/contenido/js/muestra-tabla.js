

TablaVistaSoporteTi = $("#TablaVistaSoporteTi").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '38vh',
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: { api: 2},
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/asistencia_ti_bot_api.php`,
        beforeSend: function () {
        },
        complete: function () {
            tablaListaRecetas.columns.adjust().draw()
            obtenerBTNRecetas();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        // { data: 'COUNT' },
        { data: 'NOMBRE_USUARIO . NUMERO_USUARIO' },
        { data: 'FECHA_CREACION' },
        { data: 'TICKET' },
        { data: 'MSJ' },
        { data: 'ATENDIDO_POR' },
        { data: 'INCIO_ATENCION' },
        { data: 'TERMINO_ATENCION' },
        { data: 'ESTATUS_ID' },
        { data: 'MOTIVO_CANCELACION' },
        // {
        //     data: 'ID_RECETA', render: function (data) {


        //         return `<i class="bi bi-trash eliminar-receta" data-id = "${data}" style = "cursor: pointer"
        //     onclick="desactivarTablaReceta.call(this)"></i>`;

        //     }
        // }

    ],
    columnDefs: [
        // { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Nombre (#)', className: 'all' },
        { target: 2, title: 'Fecha', className: 'none' },
        { target: 3, title: 'Tikect', className: 'none' },
        { target: 4, title: 'Mensaje', className: 'none' },
        { target: 5, title: 'Atendido por', className: 'none' },
        { target: 6, title: 'Inicio de atencion', className: 'none' },
        { target: 7, title: 'Fin de atencion', className: 'none' },
        { target: 8, title: 'Estatus', className: 'none' },
        { target: 9, title: 'Motivo de cancelacion', className: 'none' },
        // { target: 10, title: '<i class="bi bi-trash"></i>', className: 'all' }
    ]
})

inputBusquedaTable('TablaVistaSoporteTi', TablaVistaSoporteTi, [], [], 'col-12')