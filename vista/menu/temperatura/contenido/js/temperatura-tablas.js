
enfriadorData = {};

setTimeout(function () {
    loaderDiv("Out", null, "#loader-muestras", '#loaderDivmuestras');
}, 1000)


rellenarSelect("#Equipo", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 5 })

//Tabla de temperaturas por mes
/* tablaTemperaturaFolio = $("#TablaTemperaturasFolio").DataTable({
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
            selectTableFolio = false
            fadeRegistro('Out')
            $(".informacion-temperatura").fadeOut(0);
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
 */

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
        selectTableFolio = true
        $(".informacion-temperatura").fadeIn(0);
        DataFolio.folio = data['ID_FOLIOS_TEMPERATURA']
        tablaTemperatura.ajax.reload()
        SelectedFoliosData = data;
    } else {
        selectTableFolio = false;
        fadeRegistro('Out')
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
    info: true,
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
            fadeRegistro('Out')
        },
        complete: function () {
            fadeRegistro('In')
            tablaTemperatura.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },

    createdRow: function (row, data, dataIndex) {
        if (data.ESTATUS == 0) {
            $(row).addClass('bg-warning text-black');
        } else if (data.MODIFICADO == 1) {

        }

    },
    columns: [
        { data: 'COUNT' },
        { data: 'EQUIPO' },
        { data: 'TERMOMETRO' },
        {
            data: 'FECHA_REGISTRO', render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 1, 1, 1]);
            }
        },

        {
            data: 'LECTURA', render: function (data) {
                return ifnull(data, 0) + " " + "°C"
            }
        },
        { data: 'USUARIO' },
        { data: 'OBSERVACIONES' },
        { data: 'OBSERVACIONES_SUPERVISOR' },
        {
            data: 'ESTATUS', render: function (data) {

                let html = `<div class="row">`

                if (data == 0) {
                    html += ` <div class="col-4" style="max-width: max-content; padding: 0px; padding-left: 3px; padding-right: 3px;">
                                <i class="bi bi-pencil-square btn-editar" style="cursor: pointer; font-size:18px;"></i>
                                </div> `;
                    // return html
                } else {
                    if (validarPermiso("SupTemp")) {
                        html += `<div class="col-4" style="max-width: max-content; padding: 0px; padding-left: 3px; padding-right: 3px;">
                                <i class="bi bi-pencil-square btn-editar" style="cursor: pointer; font-size:18px;"></i>
                                </div>
                                <div class="col-4" style="max-width: max-content; padding: 0px; padding-left: 3px; padding-right: 3px;">
                                <i class="bi bi-box-arrow-up btn-liberar" style="cursor: pointer; font-size:18px;"></i>
                                </div>
                                `;
                    }
                    // return ""
                }

                html += `</div>`;
                return html
            }
        }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Enfriador', className: 'all' },
        { target: 2, title: 'Termometro', className: 'desktop' },
        { target: 3, title: 'Fecha', className: 'min-tablet' },
        { target: 4, title: 'Lectura', className: 'all' },
        { target: 5, title: 'Registrado', className: 'desktop' },
        { target: 6, title: 'Observaciones', className: 'none' },
        { target: 7, title: 'Observaciones del supervisor', className: 'none' },
        { target: 8, title: '', className: 'all', width: "20px" }

    ]
})



selectDatatable("TablaTemperatura", tablaTemperatura, 0, 0, 0, 0, async function (select, data) {
    selectRegistro = data
    if (select) {

        /*  if (data.ESTATUS == 1) {
             alert("Seleccion")
         } */

    } else {

    }
})


inputBusquedaTable('TablaTemperatura', tablaTemperatura, [
    {
        msj: 'Dale click a un registro para ver la información de la captura de Temperatura de un equipo.',
        place: 'top'
    }
])

function fadeRegistro(tipe) {
    if (tipe == 'Out') {
        $("#TablaTemperaturaDia").fadeOut(0)
        $("#loaderDivtemperatura").fadeIn(0);
        $("#loader-temperatura").fadeIn(0);
    } else if (tipe == 'In') {
        $("#TablaTemperaturaDia").fadeIn(0)
        $("#loaderDivtemperatura").fadeOut(0);
        $("#loader-temperatura").fadeOut(0);
    }
}