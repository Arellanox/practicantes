tablaPacientes = $('#tablaPacientes').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    scrollY: function () {
        return autoHeightDiv(0, 263)
    },
    scrollCollapse: true,
    // paging: false,
    deferRender: true,
    lengthMenu: [
        [15, 20, 25, 30, 35, 40, 45, 50, -1],
        [15, 20, 25, 30, 35, 40, 45, 50, "All"]
    ],
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, datapacientes);
        },
        method: 'POST',
        url: '../../../api/externo_api.php',
        beforeSend: function () {
            // loader("In", 'bottom'), array_selected = null
        },
        complete: function () {
            // loader("Out", 'bottom')
        },
        dataSrc: 'response.data'
    },
    /*  createdRow: function (row, data, dataIndex) {
         if (data.FACTURADO == 1) {
             $(row).addClass('bg-success text-white');
         }
     } */
    columns: [
        { data: 'COUNT' },
        { data: 'NOMBRE_COMPLETO' },
        // { data: 'PROCEDENCIA' },
        { data: 'PREFOLIO' },
        // //Laboratorio
        // {
        //     data: 'LABORATORIO_CLINICO', render: function (data) {
        //         html = drawStatusMenuTable(data, { 0: 'muestra', 1: 'reporte', 2: 'correo' });
        //         return html;
        //     }
        // },
        // //Laboratorio
        // {
        //     data: 'BIOMOLECULAR', render: function (data) {
        //         html = drawStatusMenuTable(data, { 0: 'muestra', 1: 'reporte', 2: 'correo' });
        //         return html;
        //     }
        // },
        // //Ultrasonido
        // {
        //     data: 'ULTRASONIDO', render: function (data) {
        //         return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
        //     }
        // },
        // //Rayos X
        // {
        //     data: 'RAYOS_X', render: function (data) {
        //         return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
        //     }
        // },
        // //Oftalmo
        // {
        //     data: 'OFTALMOLOGIA', render: function (data) {
        //         return drawStatusMenuTable(data, { 0: 'reporte', 2: 'correo' });
        //     }
        // },
        // //HistoriaClinica
        // {
        //     data: 'CONSULTORIO', render: function (data) {
        //         return drawStatusMenuTable(data, { 0: 'reporte', 2: 'correo' });
        //     }
        // },
        // //Electrocardiograma
        // {
        //     data: 'ELECTROCARDIOGRAMA', render: function (data) {
        //         return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
        //     }
        // },
        // //Nutricion InBody
        // {
        //     data: 'INBODY', render: function (data) {
        //         html = drawStatusMenuTable(data, { 0: 'capturas', 1: 'correo' });
        //         return html;
        //     }
        // },
        // //Espirometría
        // {
        //     data: 'ESPIROMETRIA', render: function (data) {
        //         return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
        //     }
        // },
        // //Audiometria
        // {
        //     data: 'AUDIOMETRIA', render: function (data) {
        //         return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte', 2: 'correo' });
        //     }
        // },
        //Menu

        { data: 'ETIQUETA_TURNO' },
        {
            data: 'FECHA_AGENDA',
            render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
            }
        },
        {
            data: 'FECHA_REAGENDA',
            render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
            }
        },
        {
            data: 'turno',
            render: function (data) {
                return 'PENDIENTE';
            }
        },
        { data: 'GENERO' },
        {
            data: null, render: function () {
                return '<i class="bi bi-info-circle-fill btn_offcanva pantone-7408-color" style="zoom:170%; cursor:pointer"></i>'
            }
        }
    ],
    columnDefs: [
        { width: "1%", targets: "col-number" },
        { width: "20%", targets: "col-20%" },
        { width: "5%", targets: "col-5%" },
        { width: "7%", targets: "col-icons" },
        { width: "1%", targets: 'tools' },
        { targets: "col-invisble-first", visible: false }
        // { visible: false, title: "AreaActual", targets: 20, searchable: false }
    ],

})


inputBusquedaTable("tablaPacientes", tablaPacientes,
    [
        {
            msj: 'Filtra la tabla con palabras u oraciones que coincidan',
            place: 'left'
        },
        {
            msj: 'Los iconos representan el estado del paciente a las areas',
            place: 'left'
        }
    ], "col-12 col-lg-6")


selectTable('#tablaPacientes', tablaPacientes, {
    ClickClass: [
        {
            class: 'GrupoInfoCreditoBtn',
            callback: function (data) {
                // $('#capturasIMG').html('')
                $('#NombrePacienteCapturas').html(dataSelect.array['nombre_paciente']);
                // let rowImg = selectEstudio.array[0]['IMAGENES'], htmlImg = '', htmlPdf = '';
                console.log(selectEstudio.array);
                let html = '';
                for (const i in selectEstudio.array) {
                    let row = selectEstudio.array[i]
                    if (row.CAPTURAS.length) {
                        html += '<h4>' + row.SERVICIO + '</h4>';
                        console.log(row);
                        let rowInf = row.CAPTURAS[0]
                        let rowImg = row.CAPTURAS[0].CAPTURAS[0]
                        let htmlPDF = '';
                        let htmlimg = '';
                        console.log(rowImg)
                        let pdf = 0;
                        let img = 0;

                        html += '<div class="row">' +
                            //Nombre quien cargó
                            '<div class="row col-12 col-lg-6">' +
                            '<div class="col-6 text-end info-detalle">' +
                            '<p>Captura cargada por:</p>' +
                            '</div>' +
                            '<div class="col-6" id="info-paci-procedencia"> ' + rowInf['CARGADO_POR_CAP'] + '</div>' +
                            '</div>' +

                            //fecha de cargado
                            '<div class="row col-12 col-lg-6">' +
                            '<div class="col-6 text-end info-detalle">' +
                            '<p>Fecha de subida:</p>' +
                            '</div>' +
                            '<div class="col-6" id="info-paci-procedencia"> ' + formatoFecha2(rowInf['FECHA_RESULTADO_CAP'], [0, 1, 2, 2, 1, 1, 1]) + '</div>' +
                            '</div>' +

                            //Profesion del usuario
                            '<div class="row col-12 col-lg-6">' +
                            '<div class="col-6 text-end info-detalle">' +
                            '<p>Profesión:</p>' +
                            '</div>' +
                            '<div class="col-6" id="info-paci-procedencia"> ' + rowInf['PROFESION'] + '</div>' +
                            '</div>' +

                            '</div>';

                        for (const im in rowImg) {
                            switch (rowImg[im]['tipo']) {
                                case 'pdf':
                                    pdf = 1;
                                    htmlPDF += '<div class="col-auto">' +
                                        '<a type="button"a target="_blank" class="btn btn-borrar me-2" href="' + rowImg[im]['url'] + '" style="margin-bottom:4px">' +
                                        '<i class="bi bi-file-earmark-pdf"></i>' +
                                        '</a>' +
                                        '</div>';
                                    break;

                                // case 'png': case 'jpg': case 'jpeg':
                                default:
                                    img = 1;
                                    htmlimg += '<div class="col-12 d-flex justify-content-center"><img src="' + rowImg[im]['url'] + '" class="img-thumbnail" alt=""></div>';
                                    break;
                            }
                        }

                        if (pdf == 1) {
                            html += '<div class="col-12 d-flex justify-content-left row"> <div class="col-3 align-items-center"><p>Capturas por documento pdf: </p></div> <div class="col-9 d-flex justify-content-start">' +
                                htmlPDF +
                                '</div > </div >';
                        }
                        if (img == 1) {
                            html += htmlimg;
                            html += '<hr class="dropdown-divider">';
                        }
                    }

                }
                $('#capturasIMG').html(html)

            }
        },
        {
            class: 'GrupoInfoCreditoBtn',
            callback: function (data) {

            }
        },
        {
            class: 'btn_offcanva',
            callback: async (data) => {
                alertToast('Cargando datos', 'info', 2500)
                await obtenerPanelInformacion(1, 'toma_de_muestra_api', 'estudios_muestras', '#panel-muestras-estudios')
                var myOffcanvas = document.getElementById('offcanvasInfoPrincipal')
                var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
                bsOffcanvas.show()
                // swal.close();
            }
        }
    ],
    OnlyData: true,
}, async function (select, data, callback) {
    if (select) {

    } else {

    }
})



function drawStatusMenuTable(array) {

}
