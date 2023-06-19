
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

            console.log(DataFolio)
            // fadeRegistro('Out')
        },
        complete: function () {
            // fadeRegistro('In')

            console.log(DataFolio)
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


inputBusquedaTable('TablaTemperatura', tablaTemperatura, [
    {
        msj: 'Dale click a un registro para ver la información de la captura de Temperatura de un equipo.',
        place: 'top'
    }
])




selectTable('#TablaTemperatura', tablaTemperatura, { unSelect: true, dblClick: true }, async function (select, data, callback) {
    selectRegistro = data
    if (select) {

        if (data['ESTATUS'] == 0) {
            editRegistro = true

            console.log("el estatus esta en 0")
            $("#formActualizarTemperatura").removeClass('disable-element');
        } else {

            editRegistro = false

            console.log("el estatus esta en 1")
            $("#formActualizarTemperatura").addClass('disable-element');
        }

        if (data['FIRMA_TEMPERATURA'] == null) {
            $("#img-firma_actualizar").hide()
            $("#firmaCanvas_actualizar").show()
        } else {
            $("#firmaCanvas_actualizar").hide()
            $("#img-firma_actualizar").attr("src", data['FIRMA_TEMPERATURA'])
            $("#img-firma_actualizar").show()
            firmaExist = true
        }


        $('#FormularioActualizarTemperatura_container').fadeIn(500)
        $("#formularioActualizarTemperatura").fadeIn(500);
        $('#ActualizarTemperatura_title').html("Actualiza su registro")
        $("#Termometro_actualizar").val(data['TERMOMETRO_ID'])
        $("#lectura_actualizar").val(data['LECTURA'])
        $("#observaciones_actualizar").val(data['OBSERVACIONES'])

    } else {
        $("#formularioActualizarTemperatura").fadeOut(500);
        $('#FormularioActualizarTemperatura_container').fadeOut(500)
        $("#formularioActualizarTemperatura").fadeIn(500);
        $('#ActualizarTemperatura_title').html("")
        $("#Termometro_actualizar").val("")
        $("#lectura_actualizar").val("")
        $("#observaciones_actualizar").val("")
    }
})


$("#formActualizarTemperatura").on("submit", function (e) {
    e.preventDefault();

    if (validarFormulario2() == false) {
        return false;
    }

    CargarTemperatura()

})

