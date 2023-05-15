// $('#TablaEstatusTurnos tfoot th').each(function () {
//     var title = $(this).text();
//     switch (title) {
//         case '#': return;
//         case 'Recepción': return;
//     }
//     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
// });;

tablaMenuPrincipal = $('#TablaEstatusTurnos').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    scrollY: autoHeightDiv(0, 263),
    scrollCollapse: true,
    // paging: false,
    lengthMenu: [
        [15, 20, 25, 30, 35, 40, 45, 50, -1],
        [15, 20, 25, 30, 35, 40, 45, 50, "All"]
    ],
    ajax: {
        dataType: 'json',
        data: { api: 5 },
        method: 'POST',
        url: '../../../api/turnero_api.php',
        beforeSend: function () {
            array_selected = null, carga = false;
        },
        complete: function () {
            carga = true
        },
        dataSrc: 'response.data'
    },
    createdRow: function (row, data, dataIndex) {
        if (data.REAGENDADO == 1) {
            $(row).addClass('bg-info');
        }

        // $('td', row).addClass('bg-info');
    },
    columns: [
        {
            data: 'AREA_FISICA_ID', render: function () {
                return '';
            }
        },
        { data: 'PACIENTE' },
        {
            data: 'ETIQUETA_TURNO', render: function (data) {
                return `<p class="fw-bold" style="letter-spacing: normal !important;">${data}</p>`;
            }
        },
        {
            data: 'MODULO', render: function (data) {
                switch (data) {
                    case 'EN ESPERA':
                        return `<p class="fw-bold" style="letter-spacing: normal !important;color:#E74C3C;">${data}</p>`;
                    default:
                        return `<p class="fw-bold pantone-3165-color" style="letter-spacing: normal !important;">${data}</p>`;
                }
            }
        },


        // {defaultContent: 'En progreso...'}
    ],
    columnDefs: [
        { width: "5px", targets: 0 },
        // { visible: false, title: "AreaActual", targets: 20, searchable: false }
    ],

})


// AREA_FISICA_ID
// :
// null
// MODULO
// :
// "EN ESPERA"
// PACIENTE
// :
// "CUEVAS GONZÁLEZ LUIS GERARDO"
// TURNO_ID
// :
// "291"

// tablaMenuPrincipal.columns().every(function () {
//     var that = this;

//     $('input', this.footer()).on('keyup change', function () {
//         if (that.search() !== this.value) {
//             that
//                 .search(this.value)
//                 .draw();
//         }
//     });
// });



//Activa o desactiva una columna
$('a.toggle-vis').on('click', function (e) {
    e.preventDefault();
    // Get the column API object
    var column = tablaMenuPrincipal.column($(this).attr('data-column'));

    // Toggle the visibility
    column.visible(!column.visible());
    tablaMenuPrincipal.ajax.reload();
    $.fn.dataTable
        .tables({
            visible: true,
            api: true
        })
        .columns.adjust();

    $(this).removeClass('span-info');
    if (column.visible())
        $(this).addClass('span-info');
});
$('a.toggle-vis').each(function () {
    var column = tablaMenuPrincipal.column($(this).attr('data-column'));
    if (column.visible())
        $(this).addClass('span-info');
})

selectDatatabledblclick(async function (select, data) {
    let dataInfo = data;
    if (select) {
        await obtenerPanelInformacion(1, 'toma_de_muestra_api', 'estudios_muestras', '#panel-muestras-estudios')
        var myOffcanvas = document.getElementById('offcanvasInfoPrincipal')
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
        bsOffcanvas.show()

    }
}, '#TablaEstatusTurnos', tablaMenuPrincipal)





setTimeout(() => {
    $('#TablaEstatusTurnos_filter').html(
        '<div class="text-center mt-2">' +
        '<div class="input-group flex-nowrap">' +
        '<span class="input-group-text" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="left"' +
        'title="Filtra la tabla con palabras u oraciones que coincidan">' +
        '<i class="bi bi-info-circle"></i>' +
        '</span>' +
        '<span class="input-group-text" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="left"' +
        'title="Existe un delay de 4 segundos para visualizar algun cambio de estatus">' +
        '<i class="bi bi-info-circle"></i>' +
        '</span>' +
        '<input type="search" class="form-control input-color" aria-controls="TablaEstatusTurnos" style="display: unset !important; margin-left: 0px !important"' +
        'name="inputBuscarTableListaNuevos" placeholder="Filtrar coincidencias" id="BuscarTablaListaTurnos"' +
        'data-bs-toggle="tooltip" data-bs-placement="top" title="Filtra la lista por coincidencias">' +

        '</div>' +
        '</div>'
    )

    //Zoom table
    $('#TablaEstatusTurnos_wrapper').children('div [class="row"]').eq(1).css('zoom', '90%')

    //Diseño de registros
    $('#TablaEstatusTurnos_wrapper').children('div [class="row"]').eq(0).addClass('d-flex align-items-end')


    $("#BuscarTablaListaTurnos").keyup(function () {
        tablaMenuPrincipal.search($(this).val()).draw();
    });

}, 200);



var carga = false;
cargarTabla();
function cargarTabla() {
    setTimeout(() => {
        if (carga) {
            tablaMenuPrincipal.ajax.reload()
            carga = false
        }

        cargarTabla()
        return 1;

    }, 4000);
}

$('#recargarTabla').click(function () {
    tablaMenuPrincipal.ajax.reload()
    carga = false
})