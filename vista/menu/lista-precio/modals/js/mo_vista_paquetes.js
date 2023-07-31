// Vista tabla de paquetes

// TablaVistaListaPaquetes.ajax.url(nuevaConfiguracion.url).load();
var filename, title

let costo_total = 0;
let precio_venta = 0;
let subtotal = 0;
TablaVistaListaPaquetes = $("#TablaVistaListaPaquetes").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '58vh',
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, dataVistaPq);
        },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/paquetes_api.php`,
        beforeSend: function () {
        },
        complete: function () {
            TablaVistaListaPaquetes.columns.adjust().draw()
            // obtenerBTNRecetas();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        // { data: 'COUNT' },
        { data: 'SERVICIO' },
        { data: 'ABREVIATURA' },
        { data: 'CANTIDAD' },
        {
            data: 'COSTO_UNITARIO', render: function (data) {
                return `$${parseFloat(data).toFixed(2)}`
            }
        },
        {
            data: 'COSTO_TOTAL', render: function (data) {
                return `$${parseFloat(data).toFixed(2)}`
            }
        },
        {
            data: null, render: function (meta) {
                var descuento = 'No aplica'
                if (typeof meta['DESCUENTO'] !== 'undefined')
                    descuento = meta['DESCUENTO']
                // try { descuento = meta['DESCUENTO'] } catch (error) { }
                return descuento
            }
        },
        {
            data: 'PRECIO_VENTA_UNITARIO', render: function (data) {
                return `$${parseFloat(data).toFixed(2)}`
            }
        },
        {
            data: 'SUBTOTAL', render: function (data) {
                return `$${parseFloat(data).toFixed(2)}`
            }
        },
        // data: 'TERMINO_ATENCION', render: function (data) {
        //     return formatoFecha2(data, [3, 1, 4, 2, 1, 1, 1])
        // }
    ],
    columnDefs: [
        // { target: 0, title: '#', className: 'all' },
        { target: 0, title: 'Descripción', className: 'all' },
        { target: 1, title: 'CVE', className: 'all' },
        { target: 2, title: 'Cantidad', className: 'all' },
        { target: 3, title: 'Costo', className: 'all' },
        { target: 4, title: 'Costo Total', className: 'all' },
        { target: 5, title: 'Descuento', className: 'all' },
        { target: 6, title: 'Precio Venta', className: 'all' },
        { target: 7, title: 'Subtotal', className: 'all' },
    ],
    footer: true,
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();

        //Costo de la pagina actual
        costo = api
            .column(3, { page: 'current' })
            .data()
            .reduce(function (a, b) {
                // Eliminar el símbolo "$" y los separadores de miles antes de sumar
                var num = parseFloat(b.replace(/[^0-9.-]+/g, ""));
                return a + num;
            }, 0);

        costo_total = api
            .column(4)
            .data()
            .reduce(function (a, b) {
                // Eliminar el símbolo "$" y los separadores de miles antes de sumar
                var num = parseFloat(b.replace(/[^0-9.-]+/g, ""));
                return a + num;
            }, 0);

        //Precio de venta
        precio_venta = api
            .column(6)
            .data()
            .reduce(function (a, b) {
                // Eliminar el símbolo "$" y los separadores de miles antes de sumar
                var num = parseFloat(b.replace(/[^0-9.-]+/g, ""));
                return a + num;
            }, 0);
        //Subtotal
        subtotal = api
            .column(7)
            .data()
            .reduce(function (a, b) {
                // Eliminar el símbolo "$" y los separadores de miles antes de sumar
                var num = parseFloat(b.replace(/[^0-9.-]+/g, ""));
                return a + num;
            }, 0);


        // Mostrar los totales en la fila de pie de página
        // $(api.column(3).footer()).html(`Costo: $${parseFloat(costo).toFixed(2)}`);
        $(api.column(2).footer()).html(`<p>Subtotal costo: </p>`);
        $(api.column(3).footer()).html(`$${parseFloat(costo_total).toFixed(2)}`);

        $(api.column(4).footer()).html(`<p>Subtotal: </p>`);
        $(api.column(5).footer()).html(`$${parseFloat(precio_venta).toFixed(2)}`);

        $(api.column(6).footer()).html(`<p>Total: </p>`);
        $(api.column(7).footer()).html(`$${parseFloat(subtotal).toFixed(2)}`);
    },
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            className: 'btn btn-success',
            titleAttr: 'Excel',
            filename: function () {
                return $('#seleccion-paquete option:selected').text()
            },
            title: function () {
                return $('#seleccion-paquete option:selected').text();
            },
            footer: true,

            // customize: function (xlsx) {

            // var sheet = xlsx.xl.worksheets['sheet1.xml'];

            // $('row:first c', sheet).attr('s', '42');

            // var row_title = $('row', sheet).length + 1; // Obtener el índice de la última fila

            // //agrega el encabezado de los calculos
            // var title_row = `<row r="${row_title}">
            // <c t="inlineStr" r="E${row_title}"><is><t>Subtotal costo: </t></is></c>
            // <c t="inlineStr" r="G${row_title}"><is><t>Subtotal: </t></is></c>
            // <c t="inlineStr" r="H${row_title}"><is><t>Total: </t></is></c>
            // </row>`;

            // $('sheetData', sheet).append(title_row);


            // }
        },
    ]
})

inputBusquedaTable('TablaVistaListaPaquetes', TablaVistaListaPaquetes, [{
    msj: 'Si filtras este listado, la exportación de excel será también filtrada',
    place: 'top'
}], [], 'col-12')



const ModalVistaPaquetes = document.getElementById("modalVistaPaquete");
ModalVistaPaquetes.addEventListener("show.bs.modal", (event) => {
    setTimeout(() => {
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
    }, 200);
    dataVistaPq = { api: 9, id_paquete: $('#seleccion-paquete').val() }

    filename = $('#seleccion-paquete:selected').text().split(' - ')[0]
    title = $('#seleccion-paquete option:selected').text()


    TablaVistaListaPaquetes.clear().draw();
    TablaVistaListaPaquetes.ajax.reload()
});


//excel
$('#btn-mostrar-excel-paquetes').on('click', function () {

})