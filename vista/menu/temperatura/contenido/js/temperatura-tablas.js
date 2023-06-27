
enfriadorData = {}
var DataMes = {};

rellenarSelect("#Equipos", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 5 })
rellenarSelect("#Termometro", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 })

//Tabla de temperaturas por mes
tablaTemperaturaFolio = $("#TablaTemperaturasFolio").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '75vh',
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
            $("#lista-meses-temperatura").fadeOut(0);
            loader("In")
            selectTableFolio = false
            // fadeRegistro('Out')

        },
        complete: function () {
            loader("Out", 'bottom')
            //Para ocultar segunda columna
            reloadSelectTable()
            $("#lista-meses-temperatura").fadeIn(0);
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

// selectDatatable("TablaTemperaturasFolio", tablaTemperaturaFolio, 0, 0, 0, 0, function (select, data) {

//     if (select) {
//         $("#grafica").html("");
//         CrearTablaPuntos(data['FOLIO']);
//         selectTableFolio = true
//         $(".informacion-temperatura").fadeIn(0);
//         DataFolio.folio = data['ID_FOLIOS_TEMPERATURA']
//         tablaTemperatura.ajax.reload()
//         SelectedFoliosData = data;
//     } else {
//         selectTableFolio = false;
//         fadeRegistro('Out')
//         $(".informacion-temperatura").fadeOut(0);
//     }
// })


selectTable('#TablaTemperaturasFolio', tablaTemperaturaFolio, {
    unSelect: true, dblClick: true, reload: ['col-xl-9']
}, async function (select, data, callback) {
    if (select) {
        $("#grafica").html("");
        CrearTablaPuntos(data['FOLIO']);
        selectTableFolio = true
        DataFolio.folio = data['FOLIO']
        DataMes = data
        tablaTemperatura.ajax.reload()
        SelectedFoliosData = data;
        $("#GenerarPDFTemperatura").fadeIn(0)
        callback('In')
    } else {
        selectTableFolio = false;
        $("#GenerarPDFTemperatura").fadeOut(0)
        callback('Out')
    }
}, async function (select, data, callback) {

    // $("#formularioActualizarTemperatura").fadeOut(0);
    // $('#FormularioActualizarTemperatura_container').fadeOut(0)
    $('.detallesTemperaturatitle').html("");
    rellenarSelect("#Termometro_actualizar", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 })

    $('.detallesTemperaturatitle').html(`Detalles de las temperaturas del equipo (${DataEquipo.Descripcion}) - ${formatoFecha2(DataMes['FECHA_REGISTRO'], [0, 1, 3, 0]).toUpperCase()}`)
    $("#formActualizarTemperatura").addClass('disable-element');
    // Abre un modal del detalle
    $('#detallesTemperaturaModal').modal('show');
    tablaTemperatura.ajax.reload()
    $.fn.dataTable
        .tables({
            visible: true,
            api: true
        })
        .columns.adjust();


})

var DataFolio = {
    api: 3,
    folio: 0
};


// selectDatatable("TablaTemperatura", tablaTemperatura, 0, 0, 0, 0, async function (select, data) {
//     selectRegistro = data
//     if (select) {
//         $("#formularioActualizarTemperatura").fadeIn(0);

//         /*  if (data.ESTATUS == 1) {
//              alert("Seleccion")
//          } */

//     } else {

//     }
// })


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
    $.post(`${http}${servidor}/${appname}/vista/include/funciones/TablaDePuntos_Temperatura/tabla.php`, { folio: id_grupo }, function (html) {
        $("#grafica").html(html);
    }).done(

        function () {


            setTimeout(function () {

                var canvas = document.getElementById('canvas');
                var ctx = canvas.getContext('2d');
                var dots = document.getElementsByClassName('dot');

                function connectDots(dot1, dot2) {
                    var rect1 = dot1.getBoundingClientRect();
                    var rect2 = dot2.getBoundingClientRect();
                    var x1 = (rect1.left + rect1.width / 2 - canvas.getBoundingClientRect().left) - 1.3;
                    var y1 = (rect1.top + rect1.height / 2 - canvas.getBoundingClientRect().top) + 6.3;
                    var x2 = (rect2.left + rect2.width / 2 - canvas.getBoundingClientRect().left) - 1.3;
                    var y2 = (rect2.top + rect2.height / 2 - canvas.getBoundingClientRect().top) + 6.3;


                    ctx.beginPath();
                    ctx.moveTo(x1, y1);
                    ctx.lineTo(x2, y2);
                    ctx.lineWidth = 3;
                    ctx.strokeStyle = "blue";
                    ctx.stroke();
                }

                // function getDotCenter(dot) {
                //     var rect = dot.getBoundingClientRect();
                //     var x = rect.left + rect.width / 2 - canvas.getBoundingClientRect().left;
                //     var y = rect.top + rect.height / 2 - canvas.getBoundingClientRect().top;

                //     return {
                //         x: x,
                //         y: y
                //     };
                // }

                // function connectDots(dot1, dot2) {
                //     var dot1Center = getDotCenter(dot1);
                //     var dot2Center = getDotCenter(dot2);

                //     var x1 = dot1Center.x;
                //     var y1 = dot1Center.y;
                //     var x2 = dot2Center.x;
                //     var y2 = dot2Center.y;

                //     var controlX = (x1 + x2) / 2;
                //     var controlY = (y1 + y2) / 2 - Math.abs(x1 - x2) / 4;

                //     ctx.beginPath();
                //     ctx.moveTo(x1, y1);
                //     ctx.quadraticCurveTo(controlX, controlY, x2, y2);
                //     ctx.strokeStyle = "blue "; // Cambiar el color de la línea a rojo
                //     ctx.lineWidth = 3; // Ajustar el ancho de línea
                //     ctx.stroke();
                // }


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
                        console.log(x, y);
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


            }, 500)


        })
}