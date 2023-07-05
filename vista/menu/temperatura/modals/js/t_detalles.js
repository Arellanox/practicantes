
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
            $('.btn-liberar').fadeOut(0)
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
            data: 'FECHA_MODIFICADO', render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 1, 1, 1]);
            }
        },

        {
            data: 'LECTURA', render: function (data) {
                return ifnull(data) ? ifnull(data) + " " + "°C" : '';
            }
        },
        { data: 'USUARIO' },
        { data: 'OBSERVACIONES' },
        { data: 'OBSERVACIONES_SUPERVISOR' },
        {

            data: 'FECHA_REGISTRO', render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 1, 1, 1]);
            }
        }

    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Enfriador', className: 'all' },
        { target: 2, title: 'Termometro', className: 'desktop' },
        { target: 3, title: 'Fecha Captura', className: 'min-tablet' },
        { target: 4, title: 'Lectura', className: 'all' },
        { target: 5, title: 'Registrado', className: 'desktop' },
        { target: 6, title: 'Observaciones', className: 'none' },
        { target: 7, title: 'Observaciones del supervisor', className: 'none' },
        { target: 8, title: 'Fecha de registro', className: 'none' }

    ],
    dom: 'Bfrtip',
    buttons: [
        {
            text: ' <i class="bi bi-box-arrow-up " style="cursor: pointer; font-size:18px;"></i>',
            className: 'btn btn-warning btn-liberar',
            action: function () {

                alertMensajeConfirm({
                    title: '¿Desea liberar este registro?',
                    text: 'Cualquier usuario que pueda registrar temperatura podrá actualizar el registro',
                    icon: 'warning',
                    confirmButtonText: 'Si, estoy seguro',
                    cancelButtonText: 'No'
                }, () => {
                    ajaxAwait({
                        api: 6,
                        id_registro_temperatura: selectRegistro['ID_REGISTRO_TEMPERATURA'],
                        estatus: 0
                    }, 'temperatura_api', { callbackAfter: true }, false, () => {
                        // alertMensaje('success', '')
                        alertToast('Registro liberado', 'success', 4000)
                        $("#grafica").html("");
                        CrearTablaPuntos(DataMes['FOLIO']);
                        tablaTemperatura.ajax.reload()
                        // if (selectTableFolio) {
                        //     console.log('si entro')

                        // } else {
                        //     console.log('No')
                        //     tablaTemperaturaFolio.ajax.reload()
                        // }
                    })
                }, 1)
            }
        },
    ]
})


inputBusquedaTable('TablaTemperatura', tablaTemperatura, [
    {
        msj: 'Dale click a un registro para ver la información de la captura de Temperatura de un equipo.',
        place: 'top'
    }
], [], 'col-12')



rellenarSelect("#TermSometro_actualizar", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 })
selectTable('#TablaTemperatura', tablaTemperatura, { unSelect: true, dblClick: true, noColumns: true }, async function (select, data, callback) {

    selectRegistro = data
    if (select) {
        $("#Termometro_actualizar").val("")
        $("#lectura_actualizar").val("")
        $("#observaciones_actualizar").val("")
        // resetFirma(firma_actualizar.ctx, firma_actualizar.canvas);
        if (data['ESTATUS'] == 0) {
            editRegistro = true
            $('.btn-liberar').fadeOut(0)
            console.log("el estatus esta en 0")
            $("#formActualizarTemperatura").removeClass('disable-element');
            // $("#img-firma").hide()
            // $("#canvas_actualizar").show()
            firmaExist = true
        } else {
            editRegistro = false
            console.log("el estatus esta en 1")

            validarPermiso("SupTemp") ? $('.btn-liberar').fadeIn(0) : $('.btn-liberar').fadeOut(0)

            // $("#canvas_actualizar").hide()
            // $("#img-firma").attr("src", data['FIRMA_TEMPERATURA'])
            // $("#img-firma").show()
            $("#formActualizarTemperatura").addClass('disable-element');
        }


        $('#ActualizarTemperatura_title').html("Actualiza su registro")
        $("#Termometro_actualizar").val(data['TERMOMETRO_ID'])
        $("#lectura_actualizar").val(data['LECTURA'])
        $("#observaciones_actualizar").val(data['OBSERVACIONES'])

    } else {
        $('#ActualizarTemperatura_title').html("")
        $("#Termometro_actualizar").val("")
        $("#lectura_actualizar").val("")
        $("#observaciones_actualizar").val("")
        $('.btn-liberar').fadeOut(0)
        $("#formActualizarTemperatura").addClass('disable-element');
        // resetFirma(firma_actualizar.ctx, firma_actualizar.canvas);
    }
})


$("#formActualizarTemperatura").on("submit", function (e) {
    e.preventDefault();
    editRegistro = true;
    // if (validarFormulario(firma_actualizar.canvas, firma_actualizar.ctx, firma_actualizar.firma) == false) {
    //     return false;
    // }

    CargarTemperatura()

})



const detallesTemperaturaModal = document.getElementById('detallesTemperaturaModal')
detallesTemperaturaModal.addEventListener('show.bs.modal', event => {
    setTimeout(() => {
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
    }, 200);

})