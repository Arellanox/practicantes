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
        data: { api: 2 },
        method: 'POST',
        url: '../../../api/temperatura_api.php',
        beforeSend: function () {
            loader("In")
        },
        complete: function () {
            loader("Out")
            tablaTemperaturaFolio.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' },
        {
            data: 'FECHA_REGISTRO', render: function (data) {
                return formatoFecha2(data, [0, 1, 3, 0]).toUpperCase();
            }
        },
        { data: 'FOLIO' }
    ],
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
        $(".informacion-temperatura").fadeIn(0);
        DataFolio.folio = data['ID_FOLIOS_TEMPERATURA']
        tablaTemperatura.ajax.reload()
    } else {
        $(".informacion-temperatura").fadeOut(0);
    }
})

var DataFolio = {
    api: 3,
    folio: 0
};

tablaTemperatura = $('#TablaTemperatura').DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: autoHeightDiv(0, 284),
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, DataFolio);
        },
        method: 'POST',
        url: '../../../api/temperatura_api.php',
        beforeSend: function () {
            $("#TablaTemperaturaDia").fadeOut(0)
            $("#loaderDivtemperatura").fadeIn(0);
            $("#loader-temperatura").fadeIn(0);
        },
        complete: function () {
            $("#TablaTemperaturaDia").fadeIn(0)
            $("#loaderDivtemperatura").fadeOut(0);
            $("#loader-temperatura").fadeOut(0);
            tablaTemperatura.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' },
        { data: 'EQUIPO' },
        { data: 'TERMOMETRO' },
        {
            data: 'FECHA_REGISTRO', render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 1, 1, 1], null);
            }
        },
        {
            data: 'LECTURA', render: function (data) {
                return data + " " + "°C"
            }
        },
        { data: 'USUARIO' }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Enfriador', className: 'all' },
        { target: 2, title: 'Termometro', className: 'desktop' },
        { target: 3, title: 'Fecha', className: 'min-tablet' },
        { target: 4, title: 'Lectura', className: 'all' },
        { target: 5, title: 'Registrado', className: 'desktop' },

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

