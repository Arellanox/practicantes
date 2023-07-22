DataEquiposTermometros = {
    api: 13
}

$("#TermometrosbtnTemperaturas").on("click", async function (e) {
    TablaTermometrosDataTable.ajax.reload();
    $('#activarFactorCorrecion').prop('checked', false)
    $('#factor_correcion').val('');
    $("#Termometros_Equipos").val("");
    FadeTermometro('Out')
    SwitchFactorCorrecion()


    $("#TermometrosTemperaturasModal").modal("show");
})

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
            // console.log(DataEquiposTermometros)
            // fadeRegistro('Out')
        },
        complete: function () {
            // fadeRegistro('In')
            $.fn.dataTable
                .tables({
                    visible: true,
                    api: true
                })
                .columns.adjust();
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
    ],
    dom: 'Bfrtip',
    buttons: [
        {
            text: '<i class="bi bi-qr-code"  style="cursor: pointer; font-size:18px;"></i> QR',
            className: 'btn btn-success btn-equipos-qr ',
            titleAttr: 'Generar QR para los equipos',
            action: function (data) {
                if (SelectedEquiposTermometrosQR) {
                    // alertToast('Si lo selecciono ', 'success', 500)
                    // console.log(selectedEquiposTemperaturas)
                    EQUIPO_ID = selectedEquiposTemperaturas['EQUIPO_ID'];

                    ajaxAwait({
                        api: 18,
                        Enfriador: EQUIPO_ID
                    }, 'temperatura_api', { callbackAfter: true }, false, (data) => {
                        data = data.response.data
                        Swal.fire({
                            html: `<div><div class="d-flex justify-content-center"><img src="` + data.qr + `" alt="" style="width:100%"></div>` +
                                `<a href="${data.url}" target="_blank">${data.url}</a>
                    <div class="d-flex justify-content-center"> 
                    <button type="button" class="btn btn-borrar" name="button" style="width: 50%" onClick="DownloadFromUrl('` + data.qr + `', '` + data.fileName + `')"> <i class="bi bi-image"></i> Descargar</button>` +
                                '</div></div>',
                            showCloseButton: true,
                            showConfirmButton: false,
                        })

                    })

                } else {
                    alertToast('Seleccione un equipo para generar el QR', 'info', 2000)
                }

            }
        },
    ]
})

inputBusquedaTable("TablaTermometros", TablaTermometrosDataTable, [{
    msj: 'Eliga un termometro para cada equipo, tomando en cuenta que al momento de asignarle un factor de correcion a un termometro este se le aplicara a todos los equipos que tengan asignado dicho termometro',
    place: 'left'
}], {
    msj: "Filtre los resultados por el nombre del equipo",
    place: 'top'
}, "col-12")

rellenarSelect("#Termometros_Equipos", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 });

var SelectedEquiposTermometrosQR;
selectTable('#TablaTermometros', TablaTermometrosDataTable, { unSelect: true, dblClick: true, noColumns: true }, async function (select, data, callback) {

    if (select) {
        $('#activarFactorCorrecion').prop('checked', false)
        $('#factor_correcion').val('');
        selectedEquiposTemperaturas = data;
        session.permisos.SupTemp == 1 ? $("#TermometrosTemperaturasForm").removeClass('disable-element') : $("#TermometrosTemperaturasForm").addClass('disable-element');
        $("#TermometrosTemperaturasForm").removeClass('disable-element');
        $("#Termometros_Equipos").val(selectedEquiposTemperaturas['TERMOMETRO_ID']);
        SwitchFactorCorrecion()
        SelectedEquiposTermometrosQR = true;
        FadeTermometro('In')
    } else {
        $('#activarFactorCorrecion').prop('checked', false)
        $('#factor_correcion').val('');
        $("#Termometros_Equipos").val("");
        SelectedEquiposTermometrosQR = false;
        FadeTermometro('Out')
    }
})

$('#activarFactorCorrecion').on('change', function () {
    SwitchFactorCorrecion()
});


$("#TermometrosTemperaturasForm").on("submit", function (e) {
    e.preventDefault();
    e.stopPropagation();

    $("#btn-equipos-termometros-temperatura").fadeOut(0);


    dataJsonTermometrosTemperaturas = {
        api: 14,
        Enfriador: selectedEquiposTemperaturas['ID_EQUIPO']
    };

    if (selectedEquiposTemperaturas['ID_TEMPERATURAS_EQUIPOS'] != null) {
        dataJsonTermometrosTemperaturas.id_temperaturas_equipos = selectedEquiposTemperaturas['ID_TEMPERATURAS_EQUIPOS'];
    }


    alertMensajeConfirm({
        title: "¿Está seguro de cambiarle el termometro al equipo?",
        text: '',
        icon: "info"
    }, function () {
        ajaxAwaitFormData(dataJsonTermometrosTemperaturas, 'temperatura_api', 'TermometrosTemperaturasForm', { callbackAfter: true }, false, function (data) {
            alertToast('Termometro cambiado con exito', 'success', 2000);
            $('#activarFactorCorrecion').prop('checked', false)
            $('#factor_correcion').val('');
            $("#Termometros_Equipos").val("");
            $("#TermometrosTemperaturasForm").addClass('disable-element');
            TablaTermometrosDataTable.ajax.reload();

            if (ListaEnfriadoresActiva) {
                LoadTermometros(DataEquipo.Enfriador, 'Termometro');
            }
        })
    }, 1)
})

function SwitchFactorCorrecion() {
    switchState = $('#activarFactorCorrecion').is(':checked');
    // Escuchar los cambios en el switch

    if (switchState) {
        $('#factor_correcion').collapse('show');
    } else {
        $('#factor_correcion').collapse('hide');
    }
}

function FadeTermometro(type) {
    if (type == 'Out') {
        $("#TermometrosTemperaturasForm").addClass('disable-element');
        $("#btn-equipos-termometros-temperatura").fadeOut(0);
    } else if (type == 'In') {
        $("#btn-equipos-termometros-temperatura").fadeIn(0);
        $("#TermometrosTemperaturasForm").removeClass('disable-element');
    }
}
