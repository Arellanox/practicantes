var arregloResultado = {}

async function metodoConsultaRapida(data) {
    await obtenerInformacionPaciente(data)
    await obtenerPanelInformacion(data['ID_TURNO'], "signos-vitales_api", 'signos-vitales', '#signos-vitales', '_col3');
    await obtenerContenidoConsultaRapida(data)

    loader("Out", 'bottom')
}


//Obtiene la informacion basica del paciente
function obtenerInformacionPaciente(data) {
    return new Promise(resolve => {
        $('#nombre-paciente-consulta').html(data.NOMBRE_COMPLETO);
        $('#nacimiento-paciente-consulta').html(formatoFecha2(data.NACIMIENTO, [3, 1, 2, 2, 0, 0, 0]))
        $("#edad-paciente-consulta").html(`data.EDAD años`)
        $('#genero-paciente-consulta').html(data.GENERO)
        $('#correo-paciente-consulta').html(data.CORREO)
        $('#curp-paciente-consulta').html(data.CURP)
        resolve(1)
    });
}


async function obtenerContenidoConsultaRapida(data) {
    return new Promise(async resolve => {
        await ajaxAwait({
            api: 2,
            turno_id: data.ID_TURNO
        }, 'fast_checkup_api', { callbackAfter: true }, false, (data) => {
            // console.log(data)

            let row = data.response.data[0];

            $('#resultado-html-riesgo').html('')

            let puntuacion = parseInt(row['RIESGO_SCORE'])
            let tipoRiesgo = puntuacion <= 10 ? 'Leve' : puntuacion <= 21 ? 'Moderado' : 'Alto';
            let claseAlerta = puntuacion <= 10 ? 'alert-success' : puntuacion <= 21 ? 'alert-warning' : 'alert-danger';

            let divAlerta = $('<div>', { class: 'alert ' + claseAlerta, role: 'alert' }).html('Riesgo <strong>' + tipoRiesgo + '</strong> con una puntuación de: <strong>' + puntuacion + '</strong>');

            $('#resultado-html-riesgo').append(divAlerta);


            $('#card-resultado-tabla').addClass('border-success')

            $('#resultado-hbA1c').html(`${row.HEMOGLOBINA} %`)
            $('#resultado-tension').html(`${row.SISTOLICA}/${row.DIASTOLICA} mmHg`)
            $('#resultado-imc').html(`${row.INDICE_MASA} %`)


            var puntuacionHemoglobina = getPuntuacionHemoglobina(row.HEMOGLOBINA);
            // var puntuacionTension = getPuntuacionTension(row.SISTOLICA, row.DIASTOLICA);
            var puntuacionIMC = getPuntuacionIMC(row.INDICE_MASA);
            let nivel = ""
            let claseCSS = "";

            if (puntuacionHemoglobina != 'NA' && puntuacionIMC != 'NA') {
                var resultadoFinal = puntuacionHemoglobina + puntuacionIMC;
                console.log(resultadoFinal);

                if (resultadoFinal < 7) {
                    nivel = "leve";
                } else {
                    nivel = "alto";
                }

                if (nivel === "leve") {
                    claseCSS = "border-success";
                } else {
                    claseCSS = "border-danger";
                }

            } else {
                claseCSS = '';
                resultadoFinal = 'Pendiente';
            }
            $("#card-resultado-tabla").addClass(claseCSS);
            $('#resultado-ponderacion').html(resultadoFinal)

            arregloResultado = {
                resultadoFinal: resultadoFinal,
                nivel: nivel
            };

            //Ponderacion completa:


            // console.log(arregloResultado);




            resolve(1);
        })
    });
}

function getPuntuacionHemoglobina(valor) {
    var num = parseFloat(valor);
    if (isNaN(num)) {
        return 'NA'
    }

    if (num < 5.7) {
        return 0;
    } else if (num >= 5.7 && num <= 6.4) {
        return 2;
    } else {
        return 4;
    }
}

function getPuntuacionTension(sistolica, diastolica) {
    var sistolicaNum = parseInt(sistolica);
    var diastolicaNum = parseInt(diastolica);

    if (isNaN(sistolicaNum) || isNaN(diastolicaNum)) {
        return 'NA'
    }

    if (sistolicaNum < 120 && diastolicaNum < 80) {
        return 0;
    } else if (sistolicaNum >= 120 && sistolicaNum <= 139 && diastolicaNum >= 80 && diastolicaNum <= 89) {
        return 2;
    } else {
        return 4;
    }
}

function getPuntuacionIMC(valor) {
    var num = parseFloat(valor);
    if (isNaN(num)) {
        return 'NA'
    }

    if (num < 24.9) {
        return 0;
    } else if (num >= 25.0 && num <= 29.9) {
        return 2;
    } else {
        return 4;
    }
}


$('#puntos-tension').on('change', function (event) {
    event.preventDefault();
    let valor = parseInt($(this).val())

    $("#card-resultado-tabla").removeClass('border-success');
    $("#card-resultado-tabla").removeClass('border-danger');

    if (valor) {

        $('#resultado-ponderacion').html(arregloResultado.resultadoFinal + valor)
    } else {

        $('#resultado-ponderacion').html(arregloResultado.resultadoFinal)
    }

    let nivel = ""
    if (arregloResultado.resultadoFinal + valor < 7) {
        nivel = "leve";
    } else {
        nivel = "alto";
    }

    let claseCSS = "";

    if (nivel === "leve") {
        claseCSS = "border-success";
    } else {
        claseCSS = "border-danger";
    }

    $("#card-resultado-tabla").addClass(claseCSS);
    $('#resultado-ponderacion').html(resultadoFinal)
})




$('#btn-regresar-vista').click(function () {
    alertMensajeConfirm({
        title: "¿Está seguro de regresar?",
        text: "Asegurese de guardar los cambios",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    }, function () {
        obtenerConsultorioMain();
    })
})

$('#btn-ver-reporte').click(function () {
    area_nombre = 'fast_checkup'

    api = encodeURIComponent(window.btoa(area_nombre));
    turno = encodeURIComponent(window.btoa(pacienteActivo.array['ID_TURNO']));
    area = encodeURIComponent(window.btoa(1));


    window.open(`${http}${servidor}/${appname}/visualizar_reporte/?api=${api}&turno=${turno}&area=${area}`, "_blank");
})


$(document).on('click', '#btn-consulta-guardar, #btn-consulta-terminar', function () {

    if (arregloResultado.resultadoFinal == "Pendiente") {
        alertToast('No puedes guardar o confirmar el resultado si aun no están listos', 'info', 3000)
        return false;
    }

    if (!$('#puntos-tension').val()) {
        alertToast('No haz seleccionado un nivel para la tensión arterial del paciente', 'info', 3000)
        return false;
    }

    let valorPonderacion = arregloResultado.resultadoFinal + parseInt($('#puntos-tension').val())

    let confirmado = parseInt($(this).attr('data-bs'))
    accion = 'guardar'

    if (confirmado == 1) {
        text = 'Se confirmará y enviará todos los resultados del paciente.';
        accion = 'confirmar'
    } else {
        text = 'Se actualizarán los datos para la vista previa.';
        accion = 'guardar'
    }

    alertMensajeConfirm({
        title: `¿Estas seguro de ${accion} los datos?`,
        text: text,
        confirmButtonText: `Sí, ${accion}`,
        cancelButtonText: `No`
    }, () => {
        ajaxAwait({
            api: 3, tipo_riesgo: arregloResultado.nivel, score_final: valorPonderacion, confirmado: confirmado, turno_id: pacienteActivo.array['ID_TURNO']
        }, 'fast_checkup_api', { callbackAfter: true }, false, () => {
            if (confirmado) {
                alertMsj({
                    title: '¡Reporte listo!',
                    text: '¡Todos los reportes han sido enviados correctamente!',
                    showCancelButton: false
                })
            } else {
                alertToast('Calculo de reporte guardado', 'success', 4000)
            }
        })
    }, 1)
})