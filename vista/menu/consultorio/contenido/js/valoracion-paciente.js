//Obtiene la consulta como las notas y diagnostico
function obtenerInformacionConsulta(id) {
    return new Promise(resolve => {
        $.ajax({
            url: `${http}${servidor}/${appname}/api/consulta_api.php`,
            type: "POST",
            dataType: "json",
            data: {
                id_consulta: id,
                api: 2
            },
            success: function (data) {
                if (mensajeAjax(data)) {
                    let row = data.response.data[0]
                    console.log(row)
                    $('#motivo-consulta').html(row.MOTIVO_CONSULTA)
                    $('#fechaConsulta-consulta').html(formatoFecha2(row.FECHA_CONSULTA, [0, 1, 2, 2, 0, 0, 0]))
                    if (row.NOTAS_PADECIMIENTO) $('#nota-notas-padecimiento').val(row.NOTAS_PADECIMIENTO);
                    if (row.DIAGNOSTICO) $('#diagnostico-campo-consulta').val(row.DIAGNOSTICO);
                    if (row.COMPLETADO == 1) CerrarConsultorio(1)
                }
            },
            complete: function () {
                resolve(1);
            }
        })
    });
}



//Obtiene la informacion basica del paciente
function obtenerInformacionPaciente(data) {
    return new Promise(resolve => {
        $('#nombre-paciente-consulta').html(data.NOMBRE_COMPLETO);
        $('#nacimiento-paciente-consulta').html(formatoFecha2(data.NACIMIENTO, [3, 1, 2, 2, 0, 0, 0]))
        $("#edad-paciente-consulta").html(data.EDAD)
        $('#genero-paciente-consulta').html(data.GENERO)
        $('#correo-paciente-consulta').html(data.CORREO)
        $('#curp-paciente-consulta').html(data.CURP)
        resolve(1)
    });
}

function obtenerNutricion(turno) {
    return new Promise(resolve => {
        $.ajax({
            url: `${http}${servidor}/${appname}/api/consulta_api.php`,
            method: 'POST',
            dataType: 'json',
            data: {
                api: 13,
                turno_id: turno
            },
            success: function (data) {
                if (mensajeAjax(data)) {
                    // console.log(data)
                    let row = data.response.data[0];
                    console.log(row)
                    if (row) {
                        $('#input-pesosPerdido').val(row.PESO_PERDIDO)
                        $('#input-grasa').val(row.GRASA)
                        $('#input-cintura').val(row.CINTURA)
                        $('#input-agua').val(row.AGUA)
                        $('#input-musculo').val(row.MUSCULO)
                        $('#input-abdomen').val(row.ABDOMEN)
                    }
                }
            },
            complete: function () {
                resolve(1);
            }
        })
    });
}

function obtenerExploracion(turno) {
    return new Promise(resolve => {
        $.ajax({
            url: `${http}${servidor}/${appname}/api/consulta_api.php`,
            method: 'POST',
            dataType: 'json',
            data: {
                api: 12,
                turno_id: turno
            },
            success: function (data) {
                if (mensajeAjax(data)) {
                    let row = data.response.data;
                    for (let i = 0; i < row.length; i++) {
                        agregarNotaConsulta(row[i]['EXPLORACION_TIPO'], null, row[i]['EXPLORACION'], '#notas-historial-consultorio', row[i]['ID_EXPLORACION_CLINICA'], 'eliminarExploracion')
                    }
                }
            },
            complete: function () {
                resolve(1);
            }
        })
    });
}

//Obtiene los forms de anamnesis por aparatos
function obtenerAnamnesisApartados(turno) {
    return new Promise(resolve => {
        $.post(`${http}${servidor}/${appname}/vista/include/acordion/anamnesis-aparatos.html`, function (html) {
            $('#divANAMNESISAPARATOS').html(html);
        }).done(async function () {
            await obtenerAntecedentesPaciente(turno, null, 2)
            resolve(1);
            // let arrayDivs = new Array();
            // var divsisteCardio = $('#collapse-sub-sisteCardio-Target').find("div[class='row']")
            // var divAparaRespiratorio = $('#collapse-sub-AparaRespiratorio-Target').find("div[class='row']")
            // var divaparatoDigestivo = $('#collapse-sub-aparatoDigestivo-Target').find("div[class='row']")
            // var divaparatoGenitourina = $('#collapse-sub-aparatoGenitourina-Target').find("div[class='row']")
            // var divsistemNervios = $('#collapse-sub-sistemNervios-Target').find("div[class='row']")
            // var divEndrocrinoloMetabolism = $('#collapse-sub-EndrocrinoloMetabolism-Target').find("div[class='row']")
            // var divaparatoLocomot = $('#collapse-sub-aparatoLocomot-Target').find("div[class='row']")
            // var divTermoregulacin = $('#collapse-sub-Termoregulacin-Target').find("div[class='row']")
            // var divpiel = $('#collapse-sub-piel-Target').find("div[class='row']")
            // arrayDivs.push(divsisteCardio,
            //     divAparaRespiratorio,
            //     divaparatoDigestivo,
            //     divaparatoGenitourina,
            //     divsistemNervios,
            //     divEndrocrinoloMetabolism,
            //     divaparatoLocomot,
            //     divTermoregulacin,
            //     divpiel)

            // $.ajax({
            //     url: http + servidor + "/nuevo_checkup/api/consulta_api.php",
            //     method: 'POST',
            //     dataType: 'json',
            //     data: {
            //         api: 15,
            //         turno_id: turno
            //     },
            //     success: function (data) {
            //         checkbox = data;
            //         console.log(data);
            //     },
            //     complete: function () {
            //         resolve(1);
            //     }
            // })
        });
    });
}

function CerrarConsultorio(activo) {
    if (activo == 1) {
        $('#btn-consulta-terminar').prop('disabled', true);
        $('.guardarAnt').prop('disabled', true);
        $('.guardarAnamn').prop('disabled', true);
        $('#btn-agregar-exploracion-clinina').prop('disabled', true);
        $('.eliminarExploracion').prop('disabled', true);
        $('button[type="submit"][form="formAgregarOdontograma"]').prop('disabled', true);
        $('#btn-guardar-Nutricion').prop('disabled', true);
        $('#btn-guardar-Diagnostico').prop('disabled', true);
        $('#btn-guardar-notaPadecimiento').prop('disabled', true);
        $('button[type="submit"][form="formNuevaReceta"]').prop('disabled', true);
        $('input').prop('disabled', true);
    } else {
        $('#btn-consulta-terminar').prop('disabled', false);
        $('.guardarAnt').prop('disabled', false);
        $('.guardarAnamn').prop('disabled', false);
        $('#btn-agregar-exploracion-clinina').prop('disabled', false);
        $('.eliminarExploracion').prop('disabled', false);
        $('button[type="submit"][form="formAgregarOdontograma"]').prop('disabled', false);
        $('#btn-guardar-Nutricion').prop('disabled', false);
        $('#btn-guardar-Diagnostico').prop('disabled', false);
        $('#btn-guardar-notaPadecimiento').prop('disabled', false);
        $('button[type="submit"][form="formNuevaReceta"]').prop('disabled', false);
        $('input').prop('disabled', false);
        // $('#btn-consulta-terminar').prop('disabled', false);
        // $('input').prop('disabled', false);
    }
}


//Seccion para anamnesis por aparatos
$(document).on("change ,  keyup", "input[type='radio']", function () {
    var parent_element = $(this).closest("div[class='row']");
    if (this.value == true) {
        var collapID = $(parent_element).children("div[class='collapse']").attr("id");
        $('#' + collapID).collapse("show")
        $('#' + collapID).find(':input').prop('required', true);
    } else {
        var collapID = $(parent_element).children("div[class='collapse show']").attr("id");
        $('#' + collapID).collapse("hide")
        $('#' + collapID).find(':input').val('')
        $('#' + collapID).find(':input').prop('required', false);
    }
});


tablaRecetas = $('#tablaListaRecetas').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: "100%",
    scrollCollapse: true,
    lengthMenu: [
        [10, 15, 20, 25, 30, 35, 40, 45, 50, -1],
        [10, 15, 20, 25, 30, 35, 40, 45, 50, "All"]
    ],
    ajax: {
        dataType: 'json',
        data: {
            api: 14,
            turno_id: pacienteActivo.array['ID_TURNO']
        },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/consulta_api.php`,
        // beforeSend: function() {  },
        // complete: function(){  },
        dataSrc: 'response.data'
    },
    columns: [{
        data: 'NOMBRE_GENERICO'
    },
    {
        data: 'FORMA_FARMACEUTICA'
    },
    {
        data: 'DOSIS'
    },
    {
        data: 'PRESENTACION'
    },
    {
        data: 'FRECUENCIA'
    },
    {
        data: 'VIA_DE_ADMINISTRACION'
    },
    {
        data: 'FORMA_FARMACEUTICA'
    },
    {
        data: 'INDICACIONES_PARA_EL_USO'
    },
    {
        data: 'ID_RECETA',
        render: function (data) {
            return '<div class=" d-flex justify-content-center m-2"> <button type="button" class="btn btn-hover eliminarRecetaTabla" style="margin: -15px;" data-bs-id ="' + data + '"> <i class="bi bi-trash"></i> </button> </div>';
        }
    }
    ],
    columnDefs: [{
        "width": "5px",
        "targets": 8
    },],
})

tablaOdontograma = $('#tablaOdontograma').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: "100%",
    scrollCollapse: true,
    ajax: {
        dataType: "json",
        data: {
            api: 19,
            turno_id: pacienteActivo.array['ID_TURNO']
        },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/consulta_api.php`,
        // beforeSend: function() {  },
        // complete: function(){  },
        dataSrc: 'response.data'
    },

    columns: [{
        data: 'DIAGNOSTICO'
    },
    {
        data: 'TRATAMIENTO'
    },
    {
        data: 'PIEZA_DENTAL'
    },
    {
        data: 'CARA'
    },
    {
        data: 'COMENTARIOS'
    },
    {
        data: 'ID_ODONTOGRAMA',
        render: function (data) {
            return '<div class=" d-flex justify-content-center m-2"> <button type="button" class="btn btn-hover eliminarOdontograma" style="margin: -15px;" data-bs-id ="' + data + '"> <i class="bi bi-trash"></i> </button> </div>';
        }
    }



    ],
    columnDefs: [{
        "width": "10%",
        "target": 3
    },
    {
        "width": "10%",
        "target": 4
    }
    ]
})

select2('#select-exploracion-clinica', 'card-exploracion-clinica')
select2('#select-odontograma-piezaDental', 'card-odontograma')
select2('#select-odontograma-cara', 'card-odontograma')
select2('#select-odontograma-tratamiento', 'card-odontograma')


// //Agrega nuevo campo para medicamento
// function nuevoMedicamentoReceta(div) {
//     html = '<div class="col-12 d-flex justify-content-end">' +
//         '<div class="card m-3">' +
//         '<div class="row m-2">' +
//         '<div class="col-4"><label for="estado" class="form-label">Nombre</label>                   <input type="text" class="form-control input-form" name="medicamentos[]" placeholder=""> </div>' +
//         '<div class="col-2"><label for="estado" class="form-label">Forma farmacéutica</label>       <input type="text" class="form-control input-form" name="medicamentos[]" placeholder=""> </div>' +
//         '<div class="col-2"><label for="estado" class="form-label">Dosis</label>                    <input type="text" class="form-control input-form" name="medicamentos[]" placeholder="" ></div>' +
//         '<div class="col-4"><label for="estado" class="form-label">Presentación</label>             <input type="text" class="form-control input-form" name="medicamentos[]" placeholder="" ></div>' +
//         '<div class="col-4"><label for="estado" class="form-label">Frecuencia</label>               <input type="text" class="form-control input-form" name="medicamentos[]" placeholder="" ></div>' +
//         '<div class="col-2"><label for="estado" class="form-label">Vía de administración</label>    <input type="text" class="form-control input-form" name="medicamentos[]" placeholder="" ></div>' +
//         '<div class="col-2"><label for="estado" class="form-label">Duración de tratamiento</label>  <input type="text" class="form-control input-form" name="medicamentos[]" placeholder="" ></div>' +
//         '<div class="col-4"><label for="estado" class="form-label">Indicaciones</label>             <input type="text" class="form-control input-form" name="medicamentos[]" placeholder="" ></div>' +
//         '</div> <div class=" d-flex justify-content-start m-2"> </button> <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-guardar-Receta"> <i class="bi bi-paperclip"></i> Guardar </button> <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-guardar-Receta"> <i class="bi bi-trash"></i>  </div> </div> </div>';
//     $(div).append(html);
// }