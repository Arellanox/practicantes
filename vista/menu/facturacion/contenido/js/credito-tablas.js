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
        data: function (d) {
            return $.extend(d, dataListaPaciente);
        },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/tickets_api.php`,
        beforeSend: function () { loader("In") },
        complete: function () { loader("Out") },
        dataSrc: 'response.data'
    },
    createdRow: function (row, data, dataIndex) {
        if (data.FACTURADO == 1) {
            $(row).addClass('bg-success text-white');
        }
    },
    columns: [
        {
            data: 'ID_PACIENTE', render: function (data) {
                return '';
            }
        },
        { data: 'NOMBRE_COMPLETO' },
        { data: 'PREFOLIO' },
        { data: 'EDAD' },
        { data: 'EDAD' },
        // {defaultContent: 'En progreso...'}
    ],
    columnDefs: [
        { "width": "10px", "targets": 0 },
    ],

})