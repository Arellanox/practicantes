
var estatus = 0;
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
    lengthMenu: false,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, dataJson);
        },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/servicios_api.php`,

        before: function () {
            estatus = 0
        },
        complete: function () {
            estatus = 1
        },
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
        { width: "80%", targets: 1, title: 'Servicio' },
        { width: "10%", targets: 2, title: '<i class="bi bi-trash"></i>' },
    ],

});

inputBusquedaTable('TablaLLenarGrupo', tablaLLenarGrupo, [], [], 'col-12')

selectTable('#TablaFiltradaCredito', tFillPaciCredito, { unSelect: true, multipleSelect: true }, (select, dataRow, callback) => {
    SelectPaciFiltrada = dataRow
})

tablaLLenarGrupo.on('row-reorder', function (e, diff, edit) {

    tablaLLenarGrupo.rows().nodes().to$().removeClass('selected'); // Elimina la clase de todas las filas1
    for (let i = 0; i < diff.length; i++) {
        let newData = tablaLLenarGrupo.row(diff[i].node).data();
        newData.ORDEN = diff[i].newPosition + 1; // +1 para que comience desde 1
        tablaLLenarGrupo.row(diff[i].node).data(newData);

        // Agrega la clase solo a la fila en movimiento
        $(diff[i].node).addClass('selected');
    }

});



function firstDataModal() {
    console.log(estatus)
    if (estatus == 0) {

        setTimeout(function () {
            firstDataModal()
        }, 500)
    } else if (estatus == 1) {
        // swal.close()V
        dataJson['id_grupo'] = array_selected['ID_SERVICIO']
        tablaLLenarGrupo.clear().draw()
        tablaLLenarGrupo.ajax.reload();


        $('#modalRellenarGrupos').modal('show');

        setTimeout(() => {
            $.fn.dataTable
                .tables({
                    visible: true,
                    api: true
                })
                .columns.adjust();
        }, 250);
    }
}

$(document).on('click', '#btn-guardar-grupo', function () {

    alertMensajeConfirm({
        icon: 'info',
        title: '¿Estas seguro de realizar esta acción?',
        text: 'No podra revertir esta acción',
        showCancelButton: true
    }, function () {
        // Llamar a esta función para obtener los datos tratados
        let arrayTratado = getTratadosDataFromTable();
        console.log(arrayTratado);

        console.log(array_selected['ID_SERVICIO'])
        ajaxAwait({
            api: 4,
            id_grupo: array_selected['ID_SERVICIO'],
            servicios: arrayTratado
        }, 'laboratorio_servicios_api', { callbackAfter: true }, false, function (data) {
            alertToast('Cambios realizado correctamente..', 'success', 2000)
            tablaLLenarGrupo.ajax.reload();
        })
    })


})

// Recupera los datos tratados de la tabla
function getTratadosDataFromTable() {
    let tratadosData = [];

    tablaLLenarGrupo.rows().every(function () {
        let data = this.data();
        tratadosData.push({
            ID_SERVICIO: data.ID_SERVICIO,
            ORDEN: data.ORDEN,
            DESCRIPCION: data.DESCRIPCION
            // Agrega más propiedades si es necesario
        });
    });

    return tratadosData;
}


