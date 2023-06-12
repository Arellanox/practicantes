/* TablaTicketCreditoModal = $('#TablaTicketCredito').DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: "40vh",
    scrollCollapse: true,
    columnDefs: [
        { targets: 'colum-5', width: '5%' }
    ]
}) */

inputBusquedaTable('TablaTicketCredito', TablaTicketCreditoModal, [], {
    msj: "Filtre los resultados por coincidencia",
    place: 'top'
})

