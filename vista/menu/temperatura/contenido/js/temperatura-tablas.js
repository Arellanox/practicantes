// $('#TablaContados thead tr')
//     .clone(true)
//     .addClass('filters')
//     .appendTo('#TablaContados thead');

tablaTemperatura = $('#TablaTemperatura').DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    scrollY: autoHeightDiv(0, 374),
    scrollCollapse: true,
    deferRender: true,
    /*  ajax: {
         dataType: 'json',
         data: { api: 2, estado: 1 },
         method: 'POST',
         url: '../../../api/tickets_api.php',
         beforeSend: function () {
             loader("In")
         },
         complete: function () {
             loader("Out")
             tablaContados.columns.adjust().draw()
         },
         error: function (jqXHR, textStatus, errorThrown) {
             alertErrorAJAX(jqXHR, textStatus, errorThrown);
         },
         dataSrc: 'response.data'
     }, */
    columns: [
        { data: 'COUNT' },
        { data: 'Enfriador' },
        { data: 'Termometro' },
        { data: 'Fecha' },
        { data: 'Lectura' },
        { data: ' Estatus' },
        { data: 'Registrado' }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Enfriador', className: 'all' },
        { target: 2, title: 'Termometro', className: 'all' },
        { target: 3, title: 'Fecha', className: 'all' },
        { target: 4, title: 'Lectura', className: 'all' },
        { target: 5, title: 'Estatus', className: 'all' },
        { target: 6, title: 'Registrado', className: 'all' },

    ]
})







selectDatatable("TablaTemperatura", tablaTemperatura, 0, 0, 0, 0, async function (select, data) {
    if (select) {
        await obtenerPanelInformacion(1, 1, 'PanelTemperaturas', '#InformacionTemperatura')
    } else {
        await obtenerPanelInformacion(1, 1, 'PanelTemperaturas', '#InformacionTemperatura')
    }
})


inputBusquedaTable('TablaTemperatura', tablaTemperatura, [
    {
        msj: 'Dale click a un registro para ver la información de la captura de Temperatura de un equipo.',
        place: 'top'
    }
])

