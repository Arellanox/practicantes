tablaContenido = $('#TablaContenidoResultados').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: autoHeightDiv(0, 330),
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, dataListaPaciente);
        },
        method: 'POST',
        url: '../../../api/turnos_api.php',
        beforeSend: function () {
            loader("In"), limpiarCampos(), selectListaLab = null;

            //Para ocultar las columnas
            reloadSelectTable()

            estadoFormulario()
            // estadoFormulario(3)
        },
        complete: function () {
            loader("Out")
        },
        dataSrc: 'response.data'
    },
    createdRow: function (row, data, dataIndex) {
        switch (areaActiva) {
            case 3: if (data.CONFIRMADO_OFTAL == 1) $(row).addClass('bg-success text-white'); break;
            case 10:
                if (subtipo == 'ELECTROTOMA' && data.CONFIRMADO_ELECTROCAPTURAS == 1) {
                    $(row).addClass('bg-success text-white');
                } else if (subtipo != 'ELECTROTOMA' && data.CONFIRMADO_ELECTRO == 1) {
                    $(row).addClass('bg-success text-white');
                }
                break;
            case 5:
                if (data.CONFIRMADO_ESPIRO == 1) $(row).addClass('bg-success text-white');
                break;
            case 8:
                if (subtipo == 'RXTOMA' && data.CONFIRMADO_RXCAPTURAS == 1) {
                    $(row).addClass('bg-success text-white');
                } else if (subtipo != 'RXTOMA' && data.CONFIRMADO_RX == 1) {
                    $(row).addClass('bg-success text-white');
                }
                break;
            case 11:
                if (subtipo == 'ULTRATOMA' && data.CONFIRMADO_ULTRACAPTURAS == 1) {
                    $(row).addClass('bg-success text-white');
                } else if (subtipo != 'ULTRATOMA' && data.CONFIRMADO_ULTRASO == 1) {
                    $(row).addClass('bg-success text-white');
                }
                break;
            case 14:
                if (subtipo == 'NUTRITOMA' && data.CONFIRMADO_INBODY == 1) {
                    $(row).addClass('bg-success text-white');
                }
                // else if (subtipo != 'NUTRITOMA' && data.CONFIRMADO_NUTRICION_INTREPRETACION == 1) {
                // $(row).addClass('bg-success text-white');
                // }
                break;
            // if (data.CONFIRMADO_ULTRASO == 1) $(row).addClass('bg-success text-white'); break;

            default:
                break;
        }
    },
    columns: [
        { data: 'COUNT' },
        { data: 'NOMBRE_COMPLETO' },
        { data: 'PREFOLIO' },
        { data: 'CLIENTE' },
        { data: 'SEGMENTO' },
        { data: 'turno' },
        { data: 'GENERO' },
        { data: 'EXPEDIENTE' },
        // {defaultContent: 'En progreso...'}
    ],
    columnDefs: [
        { "width": "10px", "targets": 0 },
    ],

})

// $("#inputBuscarTableListaPacientes").keyup(function () {
//     tablaContenido.search($(this).val()).draw();
// });

inputBusquedaTable('TablaContenidoResultados', tablaContenido, [{
    msj: 'Una vez cargado o confirmado el reporte de un registro de esta area, aparecerán en verde',
    place: 'top'
}], [], 'col-12')

dataTurnero = null;
selectTable('#TablaContenidoResultados', tablaContenido, { movil: true, reload: ['col-xl-8'] }, async function (selectTR, array, callback) {
    // selectDatatable('TablaContenidoResultados', tablaContenido, 0, 0, 0, 0, function (selectTR = null, array = null) {
    let datalist = array;
    dataTurnero = array;
    if (selectTR == 1) {
        dataSelect = new GuardarArreglo({
            select: true,
            nombre_paciente: datalist['NOMBRE_COMPLETO'],
            turno: datalist['ID_TURNO']
        })
        // getPanel('.informacion-paciente', '#loader-paciente', '#loaderDivPaciente', datalist, 'In', async function (divClass) {
        await obtenerPanelInformacion(datalist['ID_TURNO'], 'pacientes_api', 'paciente', '#panel-informacion', '_lab', areaActiva)
        // await obtenerPanelInformacion(1, null, 'resultados-areas', '#panel-resultadosMaster')
        await obtenerServicios(areaActiva, datalist['ID_TURNO'])

        //Obtener resultado de cada area 
        estadoFormulario(0) //Activa el formulario
        switch (areaActiva) {
            case 3: //Oftalmo
                // await obtenerPanelInformacion(1, null, 'resultados-areas', '#panel-resultadosMaster', '_version2')
                $('#btn-inter-oftal').fadeIn(0);
                document.getElementById(formulario).reset()
                if (datalist.CONFIRMADO_OFTAL == 1 || selectEstudio.getguardado() == 2) estadoFormulario(1)
                if (selectEstudio.array.length)
                    await obtenerResultadosOftalmo(selectEstudio.array)
                break;
            case 4:
                $('#btn-inter-areas').fadeIn(0);
                if (datalist.CONFIRMADO == 1) estadoFormulario(1)
                break;
            case 5:
                $('#btn-inter-areas').fadeIn(0);
                document.getElementById(formulario).reset()
                $(`#${formulario}`).html('');
                $(`#${formulario}`).html(formEspiroHTML)
                $('#sintomasPaciente').html('');
                $('#sintomasPaciente').fadeOut();

                if (selectEstudio.array.length) {
                    //console.log(selectEstudio.array[0]['PREGUNTAS'])
                    recuperarDatosEspiro(selectEstudio.array[0]['PREGUNTAS'])
                }

                if (datalist.CONFIRMADO_ESPIRO == 1 || selectEstudio.getguardado() == 2) estadoFormulario(1)

                break;
            case 8: //Rayos X
                $('#btn-inter-areas').fadeIn(0);
                if (formulario == 1) {
                    await GenerarListaCapturasImagenologia(selectEstudio.array);
                    // console.log("lista");
                } else {
                    await GeenerarReporteImagenologia(selectEstudio.array);
                    if (datalist.CONFIRMADO_RX == 1 || selectEstudio.getguardado() == 2) estadoFormulario(1)
                }
                break;
            case 11: //Ultrasonido
                $('#btn-inter-areas').fadeIn(0);
                if (formulario == 1) {
                    await GenerarListaCapturasImagenologia(selectEstudio.array);
                    // console.log("lista");
                } else {
                    await GeenerarReporteImagenologia(selectEstudio.array);
                    if (datalist.CONFIRMADO_ULTRASO == 1 || selectEstudio.getguardado() == 2) estadoFormulario(1)
                }
                break;
            case 10: //Electrocardiograma
                $('#btn-inter-areas').fadeIn(0);
                if (formulario != 1) {
                    document.getElementById(formulario).reset()
                    $('#capturaElectro').html('')
                    if (datalist.CONFIRMADO_ELECTRO == 1 || selectEstudio.getguardado() == 2) estadoFormulario(1)

                    if (selectEstudio.array.length) {
                        await obtenerResultadosElectro(selectEstudio.array)
                        if (ifnull(selectEstudio.array[0].ELECTRO_PDF))
                            await mostrarElectroInterpretacion(selectEstudio.array[0].ELECTRO_PDF)
                    }
                } else {
                    botonElectroCaptura(0);

                    if (selectEstudio.array.length)
                        if (selectEstudio.array[0].ELECTRO_PDF)
                            botonElectroCaptura(1)
                }
                break;
            case 14: //Nutricion
                $('#btn-inter-areas').fadeIn(0);
                if (formulario != 1) {
                    // document.getElementById(formulario).reset()
                    // $('#capturaElectro').html('')
                    // if (datalist.CONFIRMADO_ELECTRO == 1 || selectEstudio.getguardado() == 2) estadoFormulario(1)

                    // if (selectEstudio.array.length) {
                    //     await obtenerResultadosElectro(selectEstudio.array)
                    //     if (ifnull(selectEstudio.array[0].ELECTRO_PDF))
                    //         await mostrarElectroInterpretacion(selectEstudio.array[0].ELECTRO_PDF)
                    // }
                    alert('Interpretacion de nutrición aun esta en mantenimiento')
                } else {
                    btnNutricionInbody(1);

                    if (selectEstudio.array.length)
                        if (selectEstudio.array[0].INBODY_PDF)
                            btnNutricionInbody(0)
                }
                break;
            default:
                botonesResultados('activar');
                break;
        }


        if (selectEstudio.getguardado() == 1)
            estadoFormulario(2)
        // if (selectEstudio.getguardado() == 1 || selectEstudio.getguardado() == 2)
        //     a = ''
        // estadoFormulario(2)
        // bugGetPanel('.informacion-paciente', '#loader-paciente', '#loaderDivPaciente')
        // estatusTable('#TablaContenidoResultados')
        // })



        callback('In')
    } else {
        callback('Out')

        dataTurnero = null;
        dataSelect = new GuardarArreglo({
            select: false,
            nombre_paciente: 'Sin paciente',
            turno: 0
        })
        $('#btnResultados').fadeOut('100');
    }


    // let dataajax;
    // let url;
    // botonesResultados('desactivar')
    // datalist = array;
    // console.log(datalist)
    // if (selectTR == 1) {
    //     obtenerPanelInformacion(datalist['ID_PACIENTE'], 'pacientes_api', 'paciente')
    //     if (areaActiva == 3) {
    //         url = 'oftalmologia_api';
    //         data = {
    //             turno_id: datalist['ID_TURNO'],
    //             api: 3
    //         }
    //     } else {
    //         data = {
    //             api: 11,
    //             id_turno: datalist['ID_TURNO'],
    //             id_area: areaActiva
    //         }
    //         url = 'servicios_api'
    //     }
    //     $.ajax({
    //         url: http + servidor + "/nuevo_checkup/api/" + url + ".php",
    //         data: data,
    //         type: "POST",
    //         datatype: 'json',
    //         success: function (data) {
    //             data = jQuery.parseJSON(data)
    //             console.log(data);
    //             selectEstudio = new GuardarArreglo(data.response.data);
    //             panelResultadoPaciente(data.response.data);
    //             botonesResultados('activar', areaActiva)
    //         },
    //         complete: function () {

    //         }
    //     })
    // } else {
    //     limpiarCampos()
    // }
})



//Panel turnos, mandar id fisica al  principio
obtenerPanelInformacion(control_turnos, null, "turnos_panel", '#turnos_panel')



function limpiarCampos() {
    selectEstudio = new GuardarArreglo();
    botonesResultados('desactivar')
    obtenerPanelInformacion(0, 0, 'paciente')
    obtenerPanelInformacion(0, null, 'resultados-areaMaster', '#panel-resultadosMaster')
    $('#TablaContenidoResultados').removeClass('selected');
}

async function obtenerServicios(area, turno) {
    return new Promise(resolve => {
        if (area == 3 || area == 10 || area == 14 || area == 5 || area == 4) {
            // url = 'oftalmologia_api';
            data = {
                turno_id: turno,
                api: 2
            }
        } else {
            data = {
                api: 3,
                id_turno: turno,
            }
            // url = 'servicios_api'
        }
        $.ajax({
            url: `${http}${servidor}/${appname}/api/${url_api}.php`,
            data: data,
            type: "POST",
            dataType: 'json',
            success: function (data) {
                if (mensajeAjax(data)) {
                    selectEstudio = new GuardarArreglo(data.response.data);
                    let row = [data.response.data];

                    //Saber si tiene resultados
                    trueResultados = 0;
                    // for (const key in row[0]) {
                    //     console.log(key, row[0][key])
                    //     if (row[0][key]['GUARDADO'] == 1)
                    //         trueResultados = 1
                    //     if (row[0][key]['CONFIRMADO'] == 1)
                    //         trueResultados = 2
                    // }

                    // for (const key in object) {
                    //     if (Object.hasOwnProperty.call(object, key)) {
                    //         const element = object[key];
                    //         console.log(element)

                    //     }
                    // }
                    // console.log(selectEstudio)
                    for (const key in row[0]) {
                        if (Object.hasOwnProperty.call(row[0], key)) {
                            // console.log(key, row[0][key]['GUARDADO'], row[0][key]['CONFIRMADO'])
                            if (row[0][key]['GUARDADO'] == 1)
                                trueResultados = 1
                            if (row[0][key]['CONFIRMADO'] == 1)
                                trueResultados = 2

                        }
                    }


                    if (trueResultados)
                        selectEstudio.setguardado(trueResultados)
                    //
                    // console.log(selectEstudio)

                    if (row.length)
                        panelResultadoPaciente(row, area);


                    // if (area == 10) {
                    //     vistaPDF()
                    // }
                    botonesResultados('activar', area)
                } else {
                    selectEstudio = new GuardarArreglo({ 0: {} });
                }
            },
            complete: function () {
                resolve(1)
            }
        })
    });
}
async function panelResultadoPaciente(row, area) {

    let html = '';
    let itemStart = '<div class="accordion-item bg-acordion">';
    let itemEnd = '</div>';

    let bodyStart = '<div class="accordion-body"> <div class="row">';
    let bodyEnd = '</div>  </div>';
    html += '';
    let truehtml = false;
    $('#resultadosServicios-areas').html(html);

    $('#mostrarResultado').fadeOut()

    switch (area) {
        case 3: case 10: case 13: case 5: case 4:
            if (row[0].length) {
                // console.log(row[0])
                for (const i in row) {

                    // console.log(row[i]);
                    html += itemStart;
                    html += '<h2 class="accordion-header" id="collap-historial-estudios' + i + '">' +
                        '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-estudio' + i + '-Target" aria-expanded="false" aria-controls="accordionEstudios">' +
                        '<div class="row">' +
                        '<div class="col-12">' +
                        '<i class="bi bi-box-seam"></i> &nbsp;&nbsp;&nbsp; Cargado: <strong>' + ifnull(row[i][0]['CARGADO_POR']) + '</strong>' +
                        '</div>' +
                        '<div class="col-12">' +
                        '<i class="bi bi-calendar3"></i> &nbsp;&nbsp;&nbsp; Fecha: <strong>' + formatoFecha2(row[i][0]['FECHA_RESULTADO'], [3, 1, 2, 2, 1, 1, 1]) + '</strong> ' + //<strong>12:00 '+i+'</strong>
                        '</div>' +
                        '</div>' +
                        '</button>' +
                        '</h2>' +
                        //Dentro del acordion
                        '<div id="collapse-estudio' + i + '-Target" class="accordion-collapse collapse " aria-labelledby="collap-historial-estudios' + i + '" > '; //overflow-auto style="max-height: 70vh"

                    html += bodyStart;

                    //Boton de interpretacion
                    if (row[i][0]['PDF']) {
                        html += '<div class="col-12 d-flex justify-content-center">' +
                            '<a type="button" target="_blank" class="btn btn-borrar me-2" href="' + row[i][0]['PDF'] + '" style="margin-bottom:4px">' +
                            '<i class="bi bi-file-earmark-pdf"></i> Interpretación' +
                            '</a>' +
                            '</div>';
                        //Busca si existe interpretación o imagen
                        truehtml = true;
                    } else if (row[i][0]['CONFIRMADO'] == 0 && row[i][0]['GUARDADO'] == 1) {
                        truehtml = true;
                        html += '<div class="col-12 d-flex justify-content-center">' +
                            '<div class="alert alert-danger" role="alert"> Reporte sin confirmar </div>' +
                            '</div>';
                    }


                    let img = false;
                    for (const im in row[i]) {
                        // console.log(row[i][im]['CAPTURAS'])
                        try {
                            if (row[i][im]['CAPTURAS'].length) img = true;
                        } catch (error) {
                            console.log(error);
                        }
                    }
                    if (img) {
                        html += '<div class="col-12 d-flex justify-content-center">' +
                            '<a type="button" class="btn btn-option me-2" data-bs-toggle="modal" data-bs-target="#CapturasdeArea" style="margin-bottom:4px">' +
                            '<i class="bi bi-images"></i> Capturas' +
                            '</a>' +
                            '</div>';
                        //Busca si existe interpretación o imagen
                        truehtml = true;
                    }

                    if (ifnull(row[i][0]['ELECTRO_PDF'])) {
                        html += '<div class="col-12 d-flex justify-content-center">' +
                            '<a type="button" target="_blank" href="' + row[i][0]['ELECTRO_PDF'] + '" class="btn btn-option me-2" style="margin-bottom:4px">' +
                            '<i class="bi bi-images"></i> Capturas' +
                            '</a>' +
                            '</div>';
                        //Busca si existe interpretación o imagen
                        truehtml = true;
                    }


                    if (area === 5) {

                        if (row[i][0]['RUTA_REPORTES_ESPIRO']) {
                            html += '<div class="col-12 d-flex justify-content-center">' +
                                '<a type="button" target="_blank" class="btn btn-borrar me-2" href="' + row[i][0]['RUTA_REPORTES_ESPIRO'] + '" style="margin-bottom:4px">' +
                                '<i class="bi bi-file-earmark-pdf"></i> Espirometría' +
                                '</a>' +
                                '</div>';
                            //Busca si existe interpretación o imagen
                            truehtml = true;
                        }

                    }


                    html += bodyEnd + '</div>';
                    html += itemEnd;
                }

                if (truehtml) {
                    $('#spamResultado').html('')
                    $('#resultadosServicios-areas').html(html)
                    $('#mostrarResultado').fadeIn()
                } else {
                    $('#spamResultado').html('<div class="alert alert-info" role="alert">Reporte del paciente sin cargar</div > ')
                }
            } else {
                $('#spamResultado').html('<div class="alert alert-info" role="alert">Interpretación del paciente sin cargar</div>')
            }
            break;
        case 14:
            // Nada
            break;

        default:
            for (const i in row) {
                // console.log(row[i]);
                html += itemStart;
                html += '<h2 class="accordion-header" id="collap-historial-estudios' + i + '">' +
                    '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-estudio' + i + '-Target" aria-expanded="false" aria-controls="accordionEstudios">' +
                    '<div class="row">' +
                    '<div class="col-12">' +
                    '<i class="bi bi-box-seam"></i> &nbsp;&nbsp;&nbsp; Cargado: <strong>' + ifnull(row[i][0]['CARGADO_POR']) + '</strong>' +
                    '</div>' +
                    '<div class="col-12">' +
                    '<i class="bi bi-calendar3"></i> &nbsp;&nbsp;&nbsp; Fecha: <strong>' + formatoFecha2(row[i][0]['FECHA_RESULTADO'], [3, 1, 2, 2, 1, 1, 1]) + '</strong> ' + //<strong>12:00 '+i+'</strong>
                    '</div>' +
                    '</div>' +
                    '</button>' +
                    '</h2>' +
                    //Dentro del acordion
                    '<div id="collapse-estudio' + i + '-Target" class="accordion-collapse collapse " aria-labelledby="collap-historial-estudios' + i + '" > '; //overflow-auto style="max-height: 70vh"

                html += bodyStart;
                //Campos existentes
                // html += '<p class="none-p"> <strong>Observaciones: </strong>' +
                //     ifnull(row[i]['OBSERVACIONES']) +
                //     '</p>';
                //
                //Boton de interpretacion
                if (row[i][0]['INTERPRETACION']) {
                    html += '<div class="col-12 d-flex justify-content-center">' +
                        '<a type="button" target="_blank" class="btn btn-borrar me-2" href="' + row[i][0]['INTERPRETACION'] + '" style="margin-bottom:4px">' +
                        '<i class="bi bi-file-earmark-pdf"></i> Interpretación generado' +
                        '</a>' +
                        '</div>';
                    //Busca si existe interpretación o imagen
                    truehtml = true;
                } else if (row[i][0]['CONFIRMADO'] == 0 && row[i][0]['GUARDADO'] == 1) {
                    truehtml = true;
                    html += '<div class="col-12 d-flex justify-content-center">' +
                        '<div class="alert alert-danger" role="alert"> Reporte sin confirmar </div>' +
                        '</div>';
                }


                if (row[i][0]['RUTA_REPORTE']) {
                    html += '<div class="col-12 d-flex justify-content-center">' +
                        '<a type="button" target="_blank" class="btn btn-borrar me-2" href="' + row[i][0]['RUTA_REPORTE'] + '" style="margin-bottom:4px">' +
                        '<i class="bi bi-file-earmark-pdf"></i> Interpretación bimo' +
                        '</a>' +
                        '</div>';
                    //Busca si existe interpretación o imagen
                    truehtml = true;
                }
                //Boton de capturas
                // console.log(row[i]['CAPTURAS'])
                // if (row[i]['CAPTURAS'].legnth) {
                //     html += '<div class="col-5 d-flex justify-content-center">' +
                //         '<a type="button" class="btn btn-option me-2" data-bs-toggle="modal" data-bs-target="#CapturasdeArea" style="margin-bottom:4px">' +
                //         '<i class="bi bi-images"></i> Capturas' +
                //         '</a>' +
                //         '</div>';
                // }


                let img = false;
                for (const im in row[i]) {
                    // console.log(row[i][im]['CAPTURAS'])
                    try {
                        if (row[i][im]['CAPTURAS'].length) img = true;
                    } catch (error) {
                        console.log(error);
                    }
                }
                if (img) {
                    html += '<div class="col-12 d-flex justify-content-center">' +
                        '<a type="button" class="btn btn-option me-2" data-bs-toggle="modal" data-bs-target="#CapturasdeArea" style="margin-bottom:4px">' +
                        '<i class="bi bi-images"></i> Capturas' +
                        '</a>' +
                        '</div>';
                    //Busca si existe interpretación o imagen
                    truehtml = true;
                }

                // console.log(truehtml);
                html += bodyEnd + '</div>';
                html += itemEnd;
            }
            if (truehtml) {
                $('#spamResultado').html('')
                $('#resultadosServicios-areas').html(html)
                $('#mostrarResultado').fadeIn()
            } else {
                $('#spamResultado').html('<div class="alert alert-info" role="alert">Imágenes o reportes del paciente sin cargar</div > ')
            }
            break;
    }

    // '<div class="row"><div class="col-12"><i class="bi bi-box-seam"></i> &nbsp;&nbsp;&nbsp; Cargado: <strong>Aurora  </strong></div><div class="col-12"><i class="bi bi-calendar3"></i> &nbsp;&nbsp;&nbsp; Fecha: <strong>jueves, 29 de dic de 2022 6:15 p.&nbsp;m.</strong> </div></div>'

    // if (row['area_id'] == 3) {
    //     let html = '<hr> <div class="row" style="padding-left: 15px;padding-right: 15px;">' + +
    //         '<p style="padding-bottom: 10px">Of:</p>' + //'+row[i]['SERVICIO']+'
    //         '<div class="col-12 d-flex justify-content-center">' +
    //         '<a type="button"a target="_blank" class="btn btn-borrar me-2" href="' + row['url'] + '" style="margin-bottom:4px" id="btn-analisis-pdf">' +
    //         '<i class="bi bi-file-earmark-pdf"></i> Interpretación' +
    //         '</a>' +
    //         '</div>' +
    //         '</div> <hr>';
    //     $('#resultadosServicios-areas').append(html);
    // } else {
    //     for (var i = 0; i < row.length; i++) {
    //         console.log(row)
    //         if (row[i]['INTERPRETACION']) {
    //             let html = '<hr> <div class="row" style="padding-left: 15px;padding-right: 15px;">' +
    //                 '<p style="padding-bottom: 10px">' + row[i]['SERVICIO'] + ':</p>' +
    //                 '<p class="none-p">(' + formatoFecha2(row[i]['FECHA_INTERPRETACION']) + '):<br> ' + row[i]['COMENTARIOS'] + '</p>' +
    //                 '<div class="col-7 d-flex justify-content-center">' +
    //                 '<a type="button"a target="_blank" class="btn btn-borrar me-2" href="' + row[i]['INTERPRETACION'] + '" style="margin-bottom:4px">' +
    //                 '<i class="bi bi-file-earmark-pdf"></i> Interpretación' +
    //                 '</a>' +
    //                 '</div>';
    //             if (row[i]['IMAGENES'].length > 0) {
    //                 html += '<div class="col-5 d-flex justify-content-center">' +
    //                     '<button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#CapturasdeArea" style="margin-bottom:4px">' +
    //                     '<i class="bi bi-images"></i> Capturas' +
    //                     '</button>' +
    //                     '</div>';
    //             }
    //             html += '</div> <hr>';
    //             $('#resultadosServicios-areas').append(html);
    //         }
    //     }
    // }

}


//Activa o desactiva los botones de capturas
function botonesResultados(estilo) {
    switch (estilo) {
        case 'desactivar':
            // $('#btn-analisis-pdf').prop('disabled', true)
            $('#btn-capturas-pdf').prop('disabled', true)
            break;
        case 'activar':
            // $('#btn-analisis-pdf').prop('disabled', false)
            $('#btn-capturas-pdf').prop('disabled', false)
            break;
        default:

    }
}

//Desactiva o activa el formulario si ya tiene resultado o si ya ha sido cargada
function estadoFormulario(estado) {
    switch (estado) {
        case 1:
            confirmado = 1
            $('#btn-ver-reporte').fadeIn()
            $('#btn-confirmar-reporte').fadeIn()
            if (session.permisos['ActuaReportIm'] != 1) {

                $('button[type="submit"][form="' + formulario + '"]').prop('disabled', true)
                $('#btn-confirmar-reporte').prop('disabled', true);
                $('#' + formulario + '').find('textarea').prop('disabled', true)
                $('#' + formulario + '').find('input').prop('disabled', true)
            }
            break;
        case 2:
            $('#btn-ver-reporte').fadeIn()
            $('#btn-confirmar-reporte').fadeIn()
            // console.log('si')
            break;
        case 3:

            break;

        default:
            $('#btn-ver-reporte').fadeOut()
            $('#btn-confirmar-reporte').fadeOut()
            confirmado = 0;
            $('#btn-confirmar-reporte').prop('disabled', false);
            $('button[type="submit"][form="' + formulario + '"]').prop('disabled', false)
            $('#' + formulario + '').find('textarea').prop('disabled', false)
            $('#' + formulario + '').find('input').prop('disabled', false)
            break;
    }

}


//Nueva version
async function GeenerarReporteImagenologia(data) {
    return new Promise(resolve => {
        $('#formulario-estudios').html('')
        let endDiv = '</div>';

        let html = '';

        for (const k in data) {
            // console.log(data[k]);
            let row = data[k];

            html += '<div class="col-12 col-md-6 col-xxl-6"><div class="row card p-3 m-1">' +
                '<h4>' + row['SERVICIO'] + '</h4>';
            html += textAreaIMG('Técnica', row['ID_SERVICIO'], 'tecnica', row['TECNICA'], 1);
            html += textAreaIMG('Hallazgos', row['ID_SERVICIO'], 'hallazgo', row['HALLAZGO'], 2);
            html += textAreaIMG('Diagnóstico', row['ID_SERVICIO'], 'interpretacion', row['INTERPRETACION_DETALLE'], 1);
            html += textAreaIMG('Comentario', row['ID_SERVICIO'], 'comentario', row['COMENTARIO'], 1);

            html += endDiv + endDiv;
            console.log(row);

            try {
                capturas = row['CAPTURAS'][0]['CAPTURAS'][0];
                capturasID = row['CAPTURAS'][0]['ID_CAPTURA'];

                //Carrusel
                html += '<div class="col-md-6 col-xxl-6 d-none d-lg-block d-md-block d-xl-block d-xxl-block">' +
                    '<div id="CapturasImagen' + capturasID + '" class="carousel slide">' +
                    '<div class="carousel-indicators">';

                let current = '';
                for (const key in capturas) {
                    if (Object.hasOwnProperty.call(capturas, key)) {
                        const element = capturas[key];
                        if (key == 0) {
                            current = 'class="active" aria-current="true"';
                        } else {
                            current = '';
                        }
                        html += `<button type="button" data-bs-target="#CapturasImagen${capturasID}" data-bs-slide-to="${key}" ${current} aria-label="Slide ${(key) + 1}"></button>`;
                    }
                }
                html += '</div>' +
                    '<div class="carousel-inner">';
                let active = '';

                for (const key in capturas) {
                    if (Object.hasOwnProperty.call(capturas, key)) {
                        const element = capturas[key];
                        if (key == 0) {
                            active = 'active';
                        } else {
                            active = '';
                        }
                        html += `<div class="carousel-item ${active}"><img src="${element['url']}" class="d-block w-100" alt="img" data-enlargable></div>`;
                    }
                }


                html += '</div>' +
                    '<button class="carousel-control-prev" type="button" data-bs-target="#CapturasImagen' + capturasID + '" data-bs-slide="prev">' +
                    '<span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
                    '<span class="visually-hidden">Previous</span>' +
                    '</button>' +
                    '<button class="carousel-control-next" type="button" data-bs-target="#CapturasImagen' + capturasID + '" data-bs-slide="next">' +
                    '<span class="carousel-control-next-icon" aria-hidden="true"></span>' +
                    '<span class="visually-hidden">Next</span>' +
                    '</button>' +
                    '</div> </div>';
            } catch (error) {
                console.log(error);
            }
        }

        $('#formulario-estudios').html(html)
        autosize(document.querySelectorAll('textarea'))
        resolve(1)
    });
}

function textAreaIMG(campo, id, campoAjax, texto, rows) {
    let htmlinnput = '';
    htmlinnput += '<div class="col-12">'
    htmlinnput += '<label for="diagnostico" class="form-label">' + campo + '</label>'
    htmlinnput += '<textarea type="text" class="form-control input-form inputFormRequired" name="servicios[' + id + '][' + campoAjax + ']" autocomplete="off" rows="' + rows + '" style="font-size: 20px;">' + ifnull(texto) + '</textarea>';
    htmlinnput += '</div>'
    return htmlinnput;
}
//


//Version anterior
async function ObtenerResultadosUltrsonido(data) {
    return new Promise(resolve => {
        $('#formulario-estudios').html('')
        let endDiv = '</div>';

        let html = '';

        for (const k in data) {
            // console.log(data[k]);
            let row = data[k];

            //   <a class="aign-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-facturacion'+k+'" aria-expanded="false">
            //     <i class="bi bi-calculator"></i> Facturación
            //   </a>
            //   <div class="collapse" id="board-facturacion'+k+'">
            //     
            //   </div>

            html += '<ul class = "list-group hover-list" style ="margin-top: 5px; margin-bottom: 5px">';
            html += '<a class="dropdown-a rounded collapsed" href="" onClick="return false;" data-bs-toggle="collapse" data-bs-target="#board-facturacion' + k + '" aria-expanded="false"> <div style = "display: block">' + //margin-bottom: 10px; 
                '<div style="border-radius: 8px;margin:0px;background: rgb(0 0 0 / 5%);width: 100%;padding: 10px 0px 10px 0px;text-align: center;"">' +
                '<h4 style="font-size: 20px !important;font-weight: 600 !important;padding: 0px;margin: 0px;">' + row['SERVICIO'] + '</h4> <!-- <p> </p> --> </div></div> </a>';

            html += '<div class="collapse" id="board-facturacion' + k + '">';
            //Cada textarea
            html += cargarForm('Técnica', row['ID_SERVICIO'], 'tecnica', row['TECNICA']);
            html += cargarForm('Hallazgos', row['ID_SERVICIO'], 'hallazgo', row['HALLAZGO']);
            html += cargarForm('Diagnóstico', row['ID_SERVICIO'], 'interpretacion', row['INTERPRETACION_DETALLE']);
            html += cargarForm('Comentario', row['ID_SERVICIO'], 'comentario', row['COMENTARIO']);
            // html += '<div class="d-flex justify-content-center"><div style="padding-top: 15px;">' +
            //     '<p style = "/* font-size: 18px; */" > Observaciones:</p>' +
            //     '<textarea name="observacionesServicios[ID_SERVICIO]" rows="2;" cols="90" class="input-form" value=""></textarea></div ></div > ';
            html += '</ul>';
            html += endDiv;
        }

        $('#formulario-estudios').html(html)
        // autosize(document.querySelectorAll('textarea'))
        resolve(1)
    })
}

function cargarForm(campo, id, campoAjax, texto) {
    let colStart = '<div class="col-auto col-lg-12">';
    let colreStart = '<div class="col-auto col-lg-12 d-flex justify-content-end align-items-center">';
    let endDiv = '</div>';
    html = '';
    html += '<li class="list-group-item">';
    html += '<div class="row d-flex align-items-center">';

    html += colStart;
    html += '<p><i class="bi bi-box-arrow-in-right" style=""></i> ' + campo + ' </p>';
    html += endDiv;
    html += colreStart;
    html += '<div class="input-group">';
    html += '<textarea type="text" class="form-control input-form inputFormRequired" name="servicios[' + id + '][' + campoAjax + ']" autocomplete="off">' + ifnull(texto) + '</textarea>';
    html += '</div>';
    html += endDiv;

    html += endDiv;
    html += '</li>';
    return html;
}

//Lista de estudios imagen  
async function GenerarListaCapturasImagenologia(row) {
    return new Promise(resolve => {
        let html = '';
        // console.log(row);
        for (var i = 0; i < row.length; i++) {
            if (row[i]['CAPTURAS'].length == 0) {
                html += `<li class="list-group-item d-flex justify-content-between align-items-start d-flex align-items-center text-danger">` +
                    `<div class="ms-2 me-auto">` +
                    `<div class="fw-bold">` + row[i]['SERVICIO'] + `</div>` +
                    `` +
                    `</div>` +
                    `<span class="badge rounded-pill">` +
                    `<button type="button" onClick="estudioSeleccionado(` + row[i]['ID_SERVICIO'] + `, '#ModalSubirCapturas', '` + row[i]['SERVICIO'] + `')"  class="btn btn-primary me-2" style="margin-bottom:4px">` +
                    `<i class="bi bi-plus-lg"></i>` +
                    `</button>` +
                    `</span>` +
                    `</li>`;
            } else {
                html += `<li class="list-group-item d-flex justify-content-between align-items-start d-flex align-items-center">` +
                    `<div class="ms-2 me-auto">` +
                    `<div class="fw-bold">` + row[i]['SERVICIO'] + `</div>` +
                    `` +
                    `</div>` +
                    `<span class="badge rounded-pill">` +
                    '<a type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#CapturasdeArea" style="margin-bottom:4px">' +
                    '<i class="bi bi-images"></i>' +
                    '</a>' +
                    // `<button type="button" onClick="alertToast('Capturas cargadas', 'info')"  class="btn me-2" style="margin-bottom:4px">` +
                    //`<i class="bi bi-clipboard2-check"></i>` +
                    `</button>` +
                    `</span>` +
                    `</li>`;
            }

        }
        $('#vistaEstudiosImagenes').html(html);
        resolve(1);
    })
}

async function obtenerResultadosOftalmo(data) {
    document.getElementById(formulario).reset()
    let row = data[0]
    $('#antecedentes_personales').val(ifnull(row.ANTECEDENTES_PERSONALES));
    $('#antecedentes_oftalmologicos').val(ifnull(row.ANTECEDENTES_OFTALMOLOGICOS));
    $('#padecimiento_actual').val(ifnull(row.PADECIMIENTO_ACTUAL));
    // $('#agudeza_visual').val(ifnull(row.AGUDEZA_VISUAL_SIN_CORRECCION));
    $('#od').val(ifnull(row.OD));
    $('#oi').val(ifnull(row.OI));
    $('#jaeger').val(ifnull(row.JAEGER));

    $('#od_con').val(ifnull(row.CON_OD));
    $('#oi_con').val(ifnull(row.CON_OI));
    $('#jaeger_con').val(ifnull(row.CON_JAEGER));



    $('#refraccion').val(ifnull(row.REFRACCION));
    $('#prueba').val(ifnull(row.PRUEBA));
    $('#exploracion_oftalmologica').val(ifnull(row.EXPLORACION_OFTALMOLOGICA));
    $('#forias').val(ifnull(row.FORIAS));
    $('#campimetria').val(ifnull(row.CAMPIMETRIA));
    $('#presion_intraocular_od').val(ifnull(row.PRESION_INTRAOCULAR_OD));
    $('#presion_intraocular_oi').val(ifnull(row.PRESION_INTRAOCULAR_OI));
    $('#diagnostico').val(ifnull(row.DIAGNOSTICO));
    $('#plan').val(ifnull(row.PLAN));
    $('#observaciones').val(ifnull(row.OBSERVACIONES));
}

async function obtenerResultadosElectro(data) {
    document.getElementById(formulario).reset()
    let row = data[0]

    $('#tecnica_electro').val(ifnull(row.TECNICA))
    $('#hallazgo_electro').val(ifnull(row.HALLAZGO))
    $('#interpretacion_electro').val(ifnull(row.INTERPRETACION))
}

function mostrarElectroInterpretacion(url) {
    // console.log(url)
    $('#capturaElectro').html('<object data="' + url + '"' +
        'type="application/pdf" width="100%" style="height: 82vh;">' +
        '<iframe src="' + url + '"' +
        'width="100%" height="100%" style="border: none;">' +
        '<p>' +
        'Your browser does not support PDFs.' +
        '<a href="' + url + '">Download' +
        'the PDF</a>' +
        '.' +
        '</p>' +
        '</iframe>' +
        '</object>');

}

function botonElectroCaptura(e) {
    if (e) {
        $('#vistaCapturasAreas').html('<div class="row"> <div class="col-12 text-start" style="margin-top:4px;margin-bottom:5px;">' +
            '<button type="button" class="btn btn-primary me-2 btnResultados" style="margin-bottom:4px" disabled>' +
            '<i class="bi bi-plus-lg"></i> Captura cargada' +
            '</button> </div> </div>')
    } else {
        $('#vistaCapturasAreas').html('<div class="row"> <div class="col-12 text-start" style="margin-top:4px;margin-bottom:5px;">' +
            '<button type="button" class="btn btn-hover me-2 btnResultados" style="margin-bottom:4px" id="btn-capturas-pdf">' +
            '<i class="bi bi-plus-lg"></i> Capturar Electro' +
            '</button> </div> </div>')
    }

    $('#vistaCapturasAreas').fadeIn(0)
}

function btnNutricionInbody(e) {
    if (e) {
        $('#vistaCapturasAreas').html(`<div class="row"> <div class="col-12 text-start" style="margin-top:4px;margin-bottom:5px;">
            <button type="button" class="btn btn-hover me-2 btnResultados" style="margin-bottom:4px" id="btn-captura-inbody">
            <i class="bi bi-plus-lg"></i> Capturar InBody
            </button> </div> </div>`);
    } else {
        $('#vistaCapturasAreas').html(`<div class="row"> <div class="col-12 text-start" style="margin-top:4px;margin-bottom:5px;">
            <button type="button" class="btn btn-primary me-2 btnResultados" style="margin-bottom:4px" id="btn-modalView-nutricion">
                <i class="bi bi-check-circle"></i> Mostrar captura
            </button> </div> </div>`);
    }
}


function recuperarDatosEspiro(row) {

    let html = '';
    const respuestasIDR = [];

    for (const key in row) {
        if (Object.hasOwnProperty.call(row, key)) {
            const element = row[key];


            respuestas = element.ID_R;
            comentario = element.COMENTARIO

            switch (true) {

                // PARA MOSTRAR AQUELLOS QUE SON INPUTS DE TIPO RADIO
                case respuestas == 1 || respuestas == '1' || respuestas == 2 || respuestas == '2':
                    $(`input[id="p${element.ID_P}r${element.ID_R}"]`).prop('checked', true)
                    break;
                // PARA TODOS AQUELLOS INPUTS DE TIPO CHECKBOX QUE NO TIENEN UN COMENTARIO ANEXADO
                case respuestas != 1 && respuestas != '1' && respuestas != 2 && respuestas != '2' && comentario == null:
                    $(`input[id="p${element.ID_P}r${element.ID_R}"]`).prop('checked', true);
                    //para el caso de los botones de no_aplica1 y no_aplica2
                    $(`input[name="respuestas[${element.ID_P}][${element.ID_R}][valor]"]`).prop('checked', true);
                    break;

                // // PARA TDOS AQUELLOS QUE SON INPUTS DE TIPO TEXT  QUE NO TIENEN RESPUESTA Y PARA AQUELLOS INPUTS DE TIPO CHECKBOX QUE CONTIENEN UN COMENTARIO
                case comentario != null:
                    $(`input[id="p${element.ID_P}r${element.ID_R}"]`).prop('checked', true);
                    $(`input[id="p${element.ID_P}"]`).val(comentario);
                    //INSERTAMOS LA RESPUESTAS DE AQUELLAS PREGUNTAS QUE NO TIENEN UN ID DE RESPUESTA
                    $(`input[id="p${element.ID_P}"]`).val(comentario);
                    break;
            }

            //MOSTRAMOS LOS COLLAPSE DE TODAS AQUELLAS PREGUNTAS QUE LO CONTIENEN
            let parent = $('div[class="form-check form-check-inline col-12 mb-2"]');
            let children = $(parent).children(`div[id="p${element.ID_P}r${element.ID_R}"]`);
            children.collapse('show');
            $(`textarea[name="respuestas[${element.ID_P}][${element.ID_R}][comentario]"]`).val(comentario)
            let childrenCondiciones = $(parent).children(`div[id="pregunta${element.ID_P}"]`);
            childrenCondiciones.collapse('hide');


            //MOSTRAR RESPUESTAS ESPECIFICAS
            if (element.ID_R == 3 || element.ID_R == 4 || element.ID_R == 14) {
                respuestasIDR.push(element.RESPUESTA)
                $('#sintomasPaciente').fadeIn();

            }

        }
    }

    html += '<p>El paciente cuenta con las siguientes condiciones: </p><br>'
    respuestasIDR.forEach(respuesta => {
        html += `<li>${respuesta}</li>`;
    });
    $('#sintomasPaciente').html(html);



}
