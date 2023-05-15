
let tableQR = $('#TablaQRClientes').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    // searching: false,
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: autoHeightDiv(0, 300),
    scrollCollapse: true,

    ajax: {
        dataType: "json",
        data: { api: 2 },
        method: "POST",
        url: "../../../api/clientes_api.php",
        dataSrc: "response.data",
    },
    columns: [
        { data: "COUNT" },
        { data: "NOMBRE_COMERCIAL" },
        // {defaultContent: 'En progreso...'}
    ],
    columnDefs: [{ width: "3px", targets: 0 }],
});

const modalQRClientes = document.getElementById('modalQRClientes')
modalQRClientes.addEventListener('show.bs.modal', event => {
    tableQR.ajax.reload();
    setTimeout(() => {
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
    }, 200);
})

selectDatatable('TablaQRClientes', tableQR, 0, 0, 0, 0, async function (select, dataClick) {
    if (select) {
        let data = await ajaxAwait({
            api: 5, id_cliente: dataClick['ID_CLIENTE']
        }, 'clientes_api', { response: false })

        if (data) {
            fileName = 'códigoQR_' + dataClick['NOMBRE_COMERCIAL'];
            Swal.fire({
                html: `<div><div class="d-flex justify-content-center"><img src="` + data.url + `" alt="" style="width:100%"></div>` +
                    `<a href="${data.url_qr}" target="_blank">${data.url_qr}</a>
                    <div class="d-flex justify-content-center"> 
                    <button type="button" class="btn btn-borrar" name="button" style="width: 50%" onClick="DownloadFromUrl('` + data.url + `', '` + fileName + `')"> <i class="bi bi-image"></i> Descargar</button>` +
                    '</div></div>',
                showCloseButton: true,
                showConfirmButton: false,
            })
        }
    }
})


inputBusquedaTable('TablaQRClientes', tableQR, [
    {
        msj: 'Un click a un registro para obtener el QR',
        place: 'left'
    },
], {}, 'col-12', 'col-12')

