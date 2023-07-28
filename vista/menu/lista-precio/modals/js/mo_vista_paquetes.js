// Vista tabla de paquetes

dataVistaPq = { api: 9, id_paquete: $('#seleccion-paquete').val() }
var filename, title

TablaVistaListaPaquetes = $("#TablaVistaListaPaquetes").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '64vh',
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
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            className: 'btn btn-success',
            titleAttr: 'Excel',
            filename: filename,
            title: title,
            
            // customizeData: function (data) {
            //   console.log(data)
            //   let tabla = tablaContenidoPaquete
            //   for (var i = data.header.length - 1; i >= 0; i--) {
            //     if (!tabla.column(i).visible()) {
            //       data.header.splice(i, 1);
            //       for (var j = 0; j < data.body.length; j++) {
            //         data.body[j].splice(i, 1)
            //       }
            //     }
            //   }
            // }
        },
        // {
        //   text: '<i class="bi bi-save2"></i> Guardar',
        //   className: 'btn btn-pantone-7408',
        //   attr: {
        //     id: 'guardar-contenido-paquete'
        //   }
        // }
    ]
})

inputBusquedaTable('TablaVistaListaPaquetes', TablaVistaListaPaquetes, [], [], 'col-12')



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

    filename= $('#seleccion-paquete:selected').text().split(' - ')[0]
    title= $('#seleccion-paquete option:selected').text()


    TablaVistaListaPaquetes.clear().draw();
    TablaVistaListaPaquetes.ajax.reload()
});


//excel
$('#btn-mostrar-excel-paquetes').on('click', function () {

})