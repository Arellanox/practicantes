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
        { data: 'FECHA_REGISTRO' },
        {
            data: 'OBSERVACIONES', render: function (data) {
                return `<a href="https://desarrolloweb.com/articulos/18.php" target="_blank">
                <i class="bi bi-receipt-cutoff btn-facturar"  style=" font-size:18px;"></i>
                </a>
                
                <a href="https://desarrolloweb.com/articulos/18.php" target="_blank">
                <i class="bi bi-receipt-cutoff btn-facturar"  style=" font-size:18px;"></i>
                </a>


                <a href="https://desarrolloweb.com/articulos/18.php" target="_blank">
                <i class="bi bi-receipt-cutoff btn-facturar"  style=" font-size:18px;"></i>
                </a>
                `;
                // return `<i class="bi bi-receipt-cutoff btn-facturar"  style="cursor: pointer; font-size:18px;"></i>`;
            }
        }
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
    {
        msj: 'Filtra la tabla con palabras u oraciones que coincidan',
        place: 'left'
    },
    {
        msj: 'Los iconos representan el estado del paciente a las areas',
        place: 'left'
    }, "col-12 col-lg-6")


selectTable('#TablaUjat', TablaUjat, { unSelect: true, dblClick: true, noColumns: true }, async function (select, data, callback) {
    if (select) {

    } else {

    }
})
