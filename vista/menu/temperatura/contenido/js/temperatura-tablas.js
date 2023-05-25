setTimeout(function () {
    loaderDiv("Out", null, "#loader-muestras", '#loaderDivmuestras');
}, 1000)


//Tabla de temperaturas por mes
tablaTemperaturaFolio = $("#TablaTemperaturasFolio").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: autoHeightDiv(0, 284),
    scrollCollapse: true,
    ajax: {
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
    }/* ,
    columns: [
        { data: 'COUNT' },
        { data: 'Descripcion' },
        { data: 'Folio' }
    ] */,
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Descripcion', className: 'all' },
        { target: 2, title: 'Folio', className: 'all' }

    ]
})


inputBusquedaTable("TablaTemperaturasFolio", tablaTemperaturaFolio, [{
    msj: 'Tabla de registro de temperatura mensual',
    place: 'top'
}], {
    msj: "Filtre los resultados por el folio que escriba",
    place: 'top'
}, "col-12")

loaderDiv("Out", null, "#loader-temperatura", '#loaderDivtemperatura');
selectDatatable("TablaTemperaturasFolio", tablaTemperaturaFolio, 0, 0, 0, 0, function (select, data) {
    if (select) {
        console.log("si entro en el select de temperaturas folio")
        getPanel(".informacion-temperatura", "#loader-temperatura", "#loaderDivtemperatura", null, "In", function (divClass) {
            console.log(divClass);
            $(divClass).fadeIn(100);
        })
    } else {
        console.log("entro en la condicion donde no selecciono nada ")
        getPanel(".informacion-temperatura", "#loader-temperatura", "#loaderDivtemperatura", null, "Out")
    }
})

tablaTemperatura = $('#TablaTemperatura').DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: autoHeightDiv(0, 284),
    scrollCollapse: true,
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

