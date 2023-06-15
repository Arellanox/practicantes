
enfriadorData = {};

rellenarSelect("#Equipo", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 5 })


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
        data: function (d) {
            return $.extend(d, DataEquipo);
        },
        // data: { api: 2, equipo: id_equipos },
        method: 'POST',
        url: '../../../api/temperatura_api.php',
        beforeSend: function () {
            $(".informacion-temperatura").fadeOut(0);
            $("#lista-meses-temperatura").fadeOut(0);
            loader("In")
            selectTableFolio = false
            // fadeRegistro('Out')

        },
        complete: function () {
            loader("Out")
            // $("#lista-meses-temperatura").fadeIn(0);
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
loaderDiv("Out", null, "#loader-temperatura2", '#loaderDivtemperatura2');

selectDatatable("TablaTemperaturasFolio", tablaTemperaturaFolio, 0, 0, 0, 0, function (select, data) {

    if (select) {
        $("#grafica").html("");
        CrearTablaPuntos(data['FOLIO']);
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


function CrearTablaPuntos(id_grupo) {
    $.post("http://localhost/practicantes/vista/include/funciones/TablaDePuntos_Temperatura/tabla.php", { folio: id_grupo }, function (html) {
        $("#grafica").html(html);
    }).done(function () {

        var canvas = document.getElementById('canvas');
        var ctx = canvas.getContext('2d');
        var dots = document.getElementsByClassName('dot');

        function connectDots(dot1, dot2) {
            var rect1 = dot1.getBoundingClientRect();
            var rect2 = dot2.getBoundingClientRect();
            var x1 = rect1.left + rect1.width / 2 - canvas.getBoundingClientRect().left;
            var y1 = rect1.top + rect1.height / 2 - canvas.getBoundingClientRect().top;
            var x2 = rect2.left + rect2.width / 2 - canvas.getBoundingClientRect().left;
            var y2 = rect2.top + rect2.height / 2 - canvas.getBoundingClientRect().top;


            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.lineWidth = 2;
            ctx.strokeStyle = "blue";
            ctx.stroke();
        }

        /* function getDotCenter(dot) {
            var rect = dot.getBoundingClientRect();
            var x = rect.left + rect.width / 2 - canvas.getBoundingClientRect().left;
            var y = rect.top + rect.height / 2 - canvas.getBoundingClientRect().top;

            return {
                x: x,
                y: y
            };
        }

        function connectDots(dot1, dot2) {
            var dot1Center = getDotCenter(dot1);
            var dot2Center = getDotCenter(dot2);

            var x1 = dot1Center.x;
            var y1 = dot1Center.y;
            var x2 = dot2Center.x;
            var y2 = dot2Center.y;

            var controlX = (x1 + x2) / 2;
            var controlY = (y1 + y2) / 2 - Math.abs(x1 - x2) / 4;

            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.quadraticCurveTo(controlX, controlY, x2, y2);
            ctx.strokeStyle = "blue "; // Cambiar el color de la línea a rojo
            ctx.lineWidth = 3; // Ajustar el ancho de línea
            ctx.stroke();
        } */


        function positionDots() {
            var dotCount = dots.length;
            var containerWidth = dots[0].closest('table').offsetWidth;

            // Ajustar el tamaño del canvas al ancho del contenedor
            canvas.width = containerWidth;
            canvas.height = dots[0].closest('table').offsetHeight;


            for (var i = 0; i < dotCount; i++) {
                var dot = dots[i];
                var rect = dot.getBoundingClientRect();
                var x = rect.left + rect.width / 2 - canvas.getBoundingClientRect().left;
                var y = rect.top + rect.height / 2 - canvas.getBoundingClientRect().top;

                dot.dataset.x = x; // Guardar la posición x en un atributo de datos
                dot.dataset.y = y; // Guardar la posición y en un atributo de datos
            }
        }

        function drawLines() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            var prevDot;



            for (var i = dotInicial; typeof (prevDot) != "object"; i++) {
                for (var j = 1; j <= 2; j++) {
                    prevDot = document.getElementById('dot-' + i + '-' + j);

                    if (typeof (prevDot) == "object") {
                        prevDot = document.getElementById('dot-' + i + '-' + j)
                        j = 3
                    }

                }
            }

            for (var i = dotInicial; i <= dotLast; i++) {
                for (var j = 1; j < 3; j++) {
                    var currentDotId = 'dot-' + i + '-' + j;
                    var currentDot = document.getElementById(currentDotId);


                    if (currentDot == null) {
                        prevDot = prevDot
                    } else {
                        if (currentDot) {
                            connectDots(prevDot, currentDot);
                            prevDot = currentDot;
                        } else {
                            break;
                        }

                    }



                }
            }
        }

        positionDots();
        drawLines();
    })
}