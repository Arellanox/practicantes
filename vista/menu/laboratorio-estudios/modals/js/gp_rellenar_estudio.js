

let dataJson = {
    api: 16,
    id_grupo: 1,
}
tablaLLenarGrupo = $('#TablaLLenarGrupo').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    rowReorder: {
        selector: 'tr',
    },
    scrollY: '60vh', //347px  scrollCollapse: true,
    scrollCollapse: true,
    // lengthMenu: [[15, 20, 25, 30, 35, 40, 45, 50, -1], [15, 20, 25, 30, 35, 40, 45, 50, "All"]],
    lengthChange: false,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, dataJson);
        },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/servicios_api.php`,
        complete: function () { },
        dataSrc: function (json) {
            let counter = 1;
            json.response.data.forEach(item => {
                item.ORDEN = counter++;
            });
            return json.response.data;
        }
    },
    columns: [
        { data: 'ORDEN', },
        { data: 'DESCRIPCION' },
        {
            data: 'ID_SERVICIO', render: function (data) {
                let html = `<div class="row">
                                <div class="col-12" style="max-width: max-content; padding: 0px;">
                                <i class="bibi-trash btn-delete" style="cursor: pointer; font-size:18px;padding: 2px 5px;"></i>
                            </div></div>`
                return html;
            }
        },
    ],
    columnDefs: [
        { width: "10%", targets: 0, title: 'Orden' },
        { width: "50%", targets: 1, title: 'Servicio' },
        { width: "30", targets: 2, title: '<i class="bi bi-trash"></i>' },
    ],

});


tablaLLenarGrupo.on('row-reorder', function (e, diff, edit) {
    let orderedData = tablaLLenarGrupo.rows({ order: 'current' }).data();
    let orderData = [];
    orderedData.each(function (value, index) {
        value.ORDEN = index + 1;
        orderData.push({
            ID_SERVICIO: value.ID_SERVICIO,
            ORDEN: value.ORDEN
        });
    });

    // Aquí puedes enviar "orderData" al servidor para actualizar los órdenes.
});



function firstDataModal() {
    dataJson['id_grupo'] = array_selected['ID_SERVICIO']
    tablaLLenarGrupo.ajax.reload();


    $('#modalRellenarGrupos').modal('show');
}

