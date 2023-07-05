tablaPacientes = $('#tablaPacientes').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    scrollY: function () {
        return autoHeightDiv(0, 263)
        $(window).resize(function () {
            return autoHeightDiv(0, 263)
        })
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
            loader("In", 'bottom'), array_selected = null
        },
        complete: function () {
            loader("Out", 'bottom')
        },
        dataSrc: 'response.data'
    },
    createdRow: function (row, data, dataIndex) {
        if (data.REAGENDADO == 1) {
            $(row).addClass('bg-info');
        }

        // $('td', row).addClass('bg-info');
    },
    columns: [
        { data: 'COUNT' },
        { data: 'NOMBRE_COMPLETO' },
        // { data: 'PROCEDENCIA' },
        {
            data: 'FECHA_AGENDA',
            render: function (data) {
                return formatoFecha2(data, [3, 1, 5, 2, 0, 0, 0], null);
            }
        },
        { data: 'PREFOLIO' },

        //Laboratorio
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 6, type);
            }
        },
        //Laboratorio bio
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 12, type);
            }
        },
        //Ultrasonido
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 11, type);
            }
        },
        //Rayos x
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 8, type);
            }
        },
        //Oftalmo
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 3, type);
            }
        },

        //HistoriaClinica
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 1, type);
            }
        },
        //Electrocardiograma
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 10, type);
            }
        },
        //Nutricion InBody
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 14, type);
            }
        },
        //Espirometría
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 5, type);
            }
        },
        // //Audiometria
        {
            data: 'ESTUDIOS', render: function (data, type) {
                return drawStatusMenuTable(data, { 0: 'capturas', 1: 'reporte' }, 4, type);
            }
        },

        //Menu
        { data: 'ETIQUETA_TURNO' },
        {
            data: 'FECHA_REAGENDA',
            render: function (data) {
                return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
            }
        },

        // { data: 'DESCRIPCION_SEGMENTO' },
        {
            data: 'COUNT',
            render: function (data) {
                return 'PENDIENTE';
            }
        },
        { data: 'GENERO' },
        {
            data: null, render: function (data, type) {
                switch (type) {
                    case 'display': return '<i class="bi bi-info-circle-fill btn_offcanva pantone-7408-color" style="zoom:170%; cursor:pointer"></i>';
                    default: return data;
                }
            }
        }
        // {defaultContent: 'En progreso...'}
    ],
    columnDefs: [
        { width: "1%", targets: "col-number" },
        { width: "20%", targets: "col-20%" },
        { width: "8%", targets: "col-8%" },
        { width: "7%", targets: "col-icons" },
        { width: "1%", targets: 'tools' },
        { targets: "col-invisble-first", visible: false }
        // { visible: false, title: "AreaActual", targets: 20, searchable: false }
    ],

})


//Activa o desactiva una columna
$('a.toggle-vis').on('click', function (e) {
    e.preventDefault();
    // Get the column API object
    var column = tablaPacientes.column($(this).attr('data-column'));

    // Toggle the visibility
    column.visible(!column.visible());
    // tablaPacientes.ajax.reload();
    $.fn.dataTable
        .tables({
            visible: true,
            api: true
        })
        .columns.adjust();

    $(this).removeClass('span-info');
    if (column.visible())
        $(this).addClass('span-info');
});
$('a.toggle-vis').each(function () {
    var column = tablaPacientes.column($(this).attr('data-column'));
    if (column.visible())
        $(this).addClass('span-info');
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
            class: 'btn-get-capturas',
            callback: function (row, clicked) {
                let btn = $(clicked);

                $('#NombrePacienteCapturas').html(row['NOMBRE_COMPLETO']);
                // let rowImg = selectEstudio.array[0]['IMAGENES'], htmlImg = '', htmlPdf = '';
                let html = '', htmlPDF = '', htmlimg = '', pdf, img;

                let capturas = row['ESTUDIOS'][0];
                capturas = capturas.filter(capturas => capturas['area'] == btn.attr('data-id'))
                capturas = capturas[0]['capturas']


                for (const key in capturas) {
                    if (Object.hasOwnProperty.call(capturas, key)) {
                        const element = capturas[key];
                        switch (element['tipo']) {
                            case 'pdf':
                                pdf = 1;
                                console.log(pdf);
                                htmlPDF += `<div class="col-auto">
                                    <a type="button"a target="_blank" class="btn btn-borrar me-2" href="${element['url']}" style="margin-bottom:4px">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </div>`;
                                break;

                            // case 'png': case 'jpg': case 'jpeg':
                            default:
                                img = 1;
                                htmlimg += `<div class="col-12 d-flex justify-content-center">
                                    <img src="${element['url']}" class="img-thumbnail" alt="">
                                </div>`;
                                break;
                        }
                    }
                }

                if (pdf == 1) {
                    html += `<div class="col-12 d-flex justify-content-left row">
                        <div class="col-3 align-items-center">
                            <p>Capturas por documento pdf: </p>
                        </div>
                        <div class="col-9 d-flex justify-content-start">${htmlPDF}</div> 
                    </div>`;
                }
                if (img == 1) {
                    html += htmlimg;
                    html += '<hr class="dropdown-divider">';
                }

                $('#capturasIMG').html(html)

                $('#CapturasdeArea').modal('show');
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



function drawStatusMenuTable(data, iconObject = { 0: 'muestra', 1: 'reporte', 2: 'correo', 3: 'captura' }, area, type) {
    switch (type) {
        case 'display':
            data = data[0].filter(data => data['area'] == area);
            //Icons
            html = '';
            // console.log(data)
            data = data[0]
            if (data) {
                for (const key in iconObject) {
                    if (iconObject.hasOwnProperty.call(iconObject, key)) {
                        const val = iconObject[key];
                        // if (data[val])
                        html += analizarIconStatus(data[val], val, area);
                    }
                }
            }
            return html;
            break;
        default: return data;
    }



};

function analizarIconStatus(data, tipo, area) {

    icons = {
        reporte: {
            'PENDIENTE': 'reporte_sin',
            'N/A': 'N/A',
        },
        capturas: {
            0: 'captura_sin_tomar',
            'null': 'captura_tomada',
            'N/A': 'N/A',
        },
        result: { reporte: 'reportado', capturas: 'captura_tomada' }
    }

    let type = icons[tipo];
    type = type.hasOwnProperty(data) ? type[data] : icons['result'][tipo];

    return elegirIconStatus(type, area, data)
}

function elegirIconStatus(type, area, url = '') {
    if (type) {
        // console.log(key, tipo[key])
        switch (type) {
            // case 'muestra_sin_tomar': return '<i class="bi bi-droplet text-secondary" style="zoom:170%;"></i>';
            // case 'muestra_tomada': return '<i class="bi bi-droplet-fill" style="zoom:170%; color: rgb(162 0 0)"></i>'; // zoom: 170%; color: rgb(255 255 255); border - radius: 50 %; padding: 0px 2px 0px 2px; background - color: rgb(162, 0, 0); background: linear-gradient(to bottom right, rgb(161 0 0), rgb(162 0 0));
            case 'captura_sin_tomar': return `<i class="bi bi-card-image text-secondary" style="zoom:170%;"></i>`;
            case 'captura_tomada': return `<i class="btn-get-capturas bi bi-image-fill" style="zoom:170%; color: rgb(162 0 0); cursor:pointer" data-id="${area}"></i>`;
            case 'reporte_sin': return `<i class="bi bi-clipboard-x text-secondary" style="zoom:170%;"></i>`;
            case 'reportado': return `<a href="${url}" target="_blank"><i class="btn-get-pdf bi bi-clipboard2-check-fill" style="zoom:170%; color: rgb(247, 190, 0)" data-id="${area}"></i></a>`;
            // case 'correo_sin': return '<i class="bi bi-send-x text-secondary" style="zoom:170%;"></i>';
            // case 'correo_enviado': return '<i class="bi bi-send-check-fill" style="zoom:170%; color: rgb(000, 175, 170)"></i>';
            case 'N/A': return '';
        }
        // console.log('vacio')
        return '';
    }
}
