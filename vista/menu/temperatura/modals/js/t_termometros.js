




DataEquiposTermometros = {
    api: 13
}

TablaTermometrosDataTable = $("#TablaTermometros").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '75vh',
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, DataEquiposTermometros);
        },
        method: 'POST',
        url: '../../../api/temperatura_api.php',
        beforeSend: function () {
            console.log(DataEquiposTermometros)
            // fadeRegistro('Out')
        },
        complete: function () {
            // fadeRegistro('In')

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
        {
            data: 'TERMOMETRO', render: function (data) {
                return ifnull(data) ? ifnull(data) : 'N/A';
            }
        },
        {
            data: 'FACTOR_DE_CORRECCION', render: function (data) {

                return ifnull(data) ? ifnull(data) : 'N/A';
            }
        }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Equipo', className: 'all' },
        { target: 2, title: 'Termometro', className: 'all' },
        { target: 3, title: 'Factor de correcion', className: 'all' }
    ]
})

inputBusquedaTable("TablaTermometros", TablaTermometrosDataTable, [], {
    msj: "Filtre los resultados por el folio o por la empresa",
    place: 'top'
}, "col-12")

rellenarSelect("#Termometros_Equipos", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 });

selectTable('#TablaTermometros', TablaTermometrosDataTable, { unSelect: true, dblClick: true, noColumns: true }, async function (select, data, callback) {

    if (select) {
        $('#activarFactorCorrecion').prop('checked', false)
        $('#factor_correcion').val('');
        selectedEquiposTemperaturas = data;
        session.permisos.SupTemp == 1 ? $("#TermometrosTemperaturasForm").removeClass('disable-element') : $("#TermometrosTemperaturasForm").addClass('disable-element');
        $("#TermometrosTemperaturasForm").removeClass('disable-element');
        $("#Termometros_Equipos").val(selectedEquiposTemperaturas['TERMOMETRO_ID']);

        switchState = $('#activarFactorCorrecion').is(':checked');
        // Escuchar los cambios en el switch

        if (switchState) {
            $('#factor_correcion').collapse('show');
        } else {
            $('#factor_correcion').collapse('hide');
        }


        $("#btn-equipos-termometros-temperatura").fadeIn(0);


    } else {
        $('#activarFactorCorrecion').prop('checked', false)
        $('#factor_correcion').val('');
        $("#TermometrosTemperaturasForm").addClass('disable-element');
        $("#Termometros_Equipos").val("");

        $("#btn-equipos-termometros-temperatura").fadeOut(0);

    }
})

$('#activarFactorCorrecion').on('change', function () {
    var switchState = $(this).is(':checked');
    $('#factor_correcion').val('');
    if (switchState) {
        $('#factor_correcion').collapse('show');
    } else {
        $('#factor_correcion').collapse('hide');
    }
});


const TurnosTemperaturasModal = document.getElementById('TurnosTemperaturasModal')
TurnosTemperaturasModal.addEventListener('show.bs.modal', event => {
    $.fn.dataTable
        .tables({
            visible: true,
            api: true
        })
        .columns.adjust();
})


