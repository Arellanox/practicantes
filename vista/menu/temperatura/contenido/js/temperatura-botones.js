// $(document).on("click", ".btn-editar", function (e) {
//     e.stopPropagation()

//     editRegistro = true
//     if (selectRegistro && !(validarPermiso('SupTemp') ? false : parseInt(selectRegistro['ESTATUS']))) {
//         firstSelect(true)
//     } else {
//         alertToast("No ha seleccionado ningun registro", "info", 4000)
//     }
// })



$(document).on('click', '.btn-liberar', function (event) {
    event.stopPropagation();

})


// $(document).on('click', '#ModalFirmaTemperatura', function (e) {
//     e.preventDefault();
//     e.stopPropagation()
//     console.log("estas en firma modal")
//     resetFirma(firma_guardar.ctx, firma_guardar.canvas)
//     $('#TemperaturaModalFirma').modal('show');
// })

ListaEnfriadoresActiva = false;
$("#EquiposTemperaturasForm").on("submit", function (e) {
    e.preventDefault();



    console.log($("#Equipos").val())
    id_equipos = $("#Equipos").val()
    selectedText = $("#Equipos option:selected").text();
    DataEquipo = {
        api: 2,
        Enfriador: id_equipos,
        Descripcion: selectedText
    }


    LoadTermometros(id_equipos);


    tablaTemperaturaFolio.ajax.reload()


    $('#Enfriador').val(id_equipos)
    $('#lista-meses-temperatura').fadeToggle(0)
    $('#LibererDiaTemperatura').fadeIn(0);
    $('#formCapturarTemperatura').removeClass('disable-element')
    $('#Equipos').addClass('disable-element')
    $('#btn-equipo-temperatura').addClass('disable-element')
    $('#btn-desbloquear-equipos').fadeIn(0)
    // $("#SupervisorConfiguracion").fadeIn(0)


    $('#btn-lock').removeClass('bi bi-lock-fill')
    $('#btn-lock').addClass('bi bi-unlock-fill')
    $('#btn-desbloquear-equipos').removeClass('disable-element')

    $("#formCapturarTemperatura").trigger("reset")

    setTimeout(() => {
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
    }, 100);

    ListaEnfriadoresActiva = true;
})

function LoadTermometros(id_equipos) {
    $("#Termometro").html("")

    ajaxAwait({
        api: 1,
        id_equipo: id_equipos,
        id_tipos_equipos: 5
    }, 'equipos_api', { callbackAfter: true }, false, (data) => {
        selectedEquipos = data.response.data;

        selectedEquipos.forEach(e => {
            $("#Termometro").html(`
        <option value='${e['TERMOMETRO_ID']}' selected>${e['TERMOMETRO']}</option>
        `)

        });
    })

}

$('#btn-desbloquear-equipos').on('click', function (e) {
    ListaEnfriadoresActiva = false;
    $("#Termometro").html("")
    e.preventDefault()
    $('#Equipos').removeClass('disable-element')
    $('#LibererDiaTemperatura').fadeOut(0);


    $('#btn-lock').removeClass('bi bi-unlock-fill')
    $('#btn-lock').addClass('bi bi-lock-fill')

    $('#btn-equipo-temperatura').removeClass('disable-element')
    $('#formCapturarTemperatura').addClass('disable-element')
    $("#lista-meses-temperatura").fadeOut(0);
    $(".grafica-temperatura").fadeOut(0);
    $('#btn-desbloquear-equipos').addClass('disable-element')
    // $("#SupervisorConfiguracion").fadeOut(0)

    $("#formCapturarTemperatura").trigger("reset")

})

// $(document).on("click", ".reset_firma", function (e) {
//     e.preventDefault();
//     e.stopPropagation()

//     let tipo = $(this).attr("data_tipo");

//     switch (tipo) {
//         case "actualizar":
//             resetFirma(firma_actualizar.ctx, firma_actualizar.canvas);
//             break;
//         case "guardar":
//             resetFirma(firma_guardar.ctx, firma_guardar.canvas);
//             break;
//         default:
//             break;
//     }

// })

//Comprueba el evento submit del formulario, si dan click al button se manda el formulario, se recupera la informacion de los input y se guarda y setea en un formData para enviarlo a la api y capturarlos en la base de datos
$("#formCapturarTemperatura").on("submit", function (e) {
    e.preventDefault();

    editRegistro = false;
    // if (firmaExist == false) {
    //     if (validarFormulario(firma_guardar.canvas, firma_guardar.ctx, firma_guardar.firma) == false) {
    //         return false;
    //     }
    // }

    CargarTemperatura()

})


function CargarTemperatura() {

    alertMensajeConfirm({
        title: "¿Está seguro de su captura?",
        text: "Recuerde usar el simbolo - si es necesario",
        icon: "info"
    }, function () {

        // data = new FormData(document.getElementById('formCapturarTemperatura'));
        // console.log(data);

        let dataJson = {
            api: 1,
            Enfriador: DataEquipo['Enfriador']
        }

        form = ""
        text = ""
        switch (editRegistro) {
            case true:
                console.log("esta actualizando nueva temperatura")
                dataJson["id_registro_temperatura"] = selectRegistro['ID_REGISTRO_TEMPERATURA']
                form = "formActualizarTemperatura"
                text = "Registro actualizado correctamente"

                break;
            case false:
                console.log("esta registrando una nueva temperatura")
                form = "formCapturarTemperatura"
                text = "Registro realizado correctamente"
                break;
            default:
                console.log("no esta ni registrando ni actualizando")
                return false;
                break;
        }

        ajaxAwaitFormData(dataJson, 'temperatura_api', form, { callbackAfter: true }, false, function (data) {
            alertToast(text, 'success', 4000)
            $("#grafica").html("");
            CrearTablaPuntos(DataMes['FOLIO']);


            $('#formCapturarTemperatura').trigger("reset");
            $('#formActualizarTemperatura').trigger("reset");
            $("#formActualizarTemperatura").addClass('disable-element');
            // resetFirma(firma_actualizar.ctx, firma_actualizar.canvas);
            // resetFirma(firma_guardar.ctx, firma_guardar.canvas);
            // firmaExist = false
            if (selectTableFolio) {
                console.log('si entro')
                tablaTemperatura.ajax.reload()
            } else {
                console.log('No')
                tablaTemperaturaFolio.ajax.reload()
            }

            editRegistro == true ? $('#detallesTemperaturaModal').modal('hide') : null
        })
    }, 1)
}


id_registro_dor = false
$(document).on('click', '.td-hover', async function (event) {
    event.preventDefault();
    event.stopPropagation();

    session.permisos.SupTemp == 0 ? $("#formAgregarComentario").addClass("disable-element") : $("#formAgregarComentario").removeClass("disable-element")


    let dot = $(this)
    id_registro_dor = dot.attr('data_id')

    $("#formAgregarComentario").trigger("reset")

    alertToast('Cargando comentarios, espere un momento', 'success', 4000)

    await mostrarComentariosDiaTemperatura()
    //Abre el modal
    $('#modalComentariosRegistro').modal('show')

})

$(document).on('submit', '#formAgregarComentario', (event) => {
    event.preventDefault();
    alertMensajeConfirm({
        title: '¿Está seguro de agregar este comentario?',
        text: 'No podrás actualizarlo',
        icon: 'info'
    }, function () {
        ajaxAwaitFormData({
            api: 8,
            id_registro_temperatura: id_registro_dor
        }, 'temperatura_api', 'formAgregarComentario', { callbackAfter: true }, false, (data) => {
            agregarNota({
                CREADO_POR: '',
                ID_REGISTRO_TEMPERATURA: 1,
                COMENTARIO: '',
                FECHA: '',
            }, '#content-comentarios-registros')
            alertToast('Comentario Agregado', 'success', 4000)
            mostrarComentariosDiaTemperatura();
            $("#formAgregarComentario").trigger("reset")
        })
    }, 1)
})

$(document).on("click", ".comentario-eliminar", function (event) {
    event.preventDefault();

    let dot = $(this)
    id_comentario = dot.attr('data-cm-id')


    alertMensajeConfirm({
        title: '¿Está seguro de eliminar este comentario?',
        text: 'No podrás revertirlo',
        icon: 'info'
    }, function () {
        ajaxAwait({
            api: 10,
            id_comentario: id_comentario
        }, 'temperatura_api', { callbackAfter: true }, false, (response) => {
            alertToast('Comentario Eliminado', 'success', 4000)
            mostrarComentariosDiaTemperatura();
        })

    }, 1)

})

//Muestra los comentarios
function mostrarComentariosDiaTemperatura() {
    return new Promise(function (resolve, reject) {
        //Recupera los comentarios
        ajaxAwait({
            api: 9,
            id_registro_temperatura: id_registro_dor
        }, 'temperatura_api', { callbackAfter: true, WithoutResponseData: true }, false, (row) => {
            let div = $('#content-comentarios-registros')
            div.html('');
            for (const key in row) {
                if (Object.hasOwnProperty.call(row, key)) {
                    const element = row[key];
                    // formatoFecha2(element['FECHA'], [0, 1, 3, 0]).toUpperCase();
                    // formatoFecha2(element['FECHA'], [0, 1, 5, 2, 1, 1, 1])
                    $("#fecha_comentario").html(formatoFecha2(element['FECHA'], [3, 1, 3, 1, 1, 1, 1]).toUpperCase())
                    agregarNota(element, '#content-comentarios-registros')
                }
            }

            resolve(1);
        })

    })


}


function agregarNota(element = [], div) {
    if (element['COMENTARIO'] == null) {
        html = ""
    } else {
        html = `<div class="card m-3 p-3">
                    <div class="row">
                     <p>${formatoFecha2(element['FECHA_COMENTARIO'], [0, 1, 5, 2, 1, 1, 1])}</p>
                        <div class="col-10">
                            <h5>${element['CREADO_POR']}</h5>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-hover comentario-eliminar" data-cm-id="${element['ID_TEMPERATURA_COMENTARIOS']}" data-bs-id="${element['ID_REGISTRO_TEMPERATURA']}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    <p>${element['COMENTARIO']}</p>
                </div>
                    `;

    }


    $(div).append(html);
}


$("#ConfiguracionTemperaturasbtn").on("click", async function () {
    alertToast('Cargando Configuracion...', 'info', 2000)
    await CargarConfiguracionTemperaturas()



    $('#offcanvasConfiguracionTemperaturas').offcanvas('show');
})

$("#btn-configuracion-temperatura").on("click", function (e) {
    e.preventDefault();

    switchState = $('#Domingos').is(':checked');

    console.log(domingos)
    data = new FormData(document.getElementById('ConfiguracionTemperaturaForm'));



    ajaxAwaitFormData({
        api: 12,
        domingos: domingos
    }, 'temperatura_api', 'ConfiguracionTemperaturaForm', { callbackAfter: true }, false, (data) => {
        alertToast('Configuracion Actualizada', 'success', 1000)

        $('#offcanvasConfiguracionTemperaturas').offcanvas('hide');
    })

})


var domingos;
// Escuchar los cambios en el switch
$('#Domingos').on('change', function () {
    var switchState = $(this).is(':checked');
    if (switchState) {
        domingos = 1
        // $('#factor_coreccion').collapse('show');
    } else {
        domingos = 0
        // $('#factor_coreccion').collapse('hide');
    }
});


// $("#SupervisorConfiguracion").on("click", function (e) {
//     e.preventDefault();
//     $('#Si').prop('checked', false)
//     $('#No').prop('checked', false)
//     $('#flexSwitchCheckChecked').prop('checked', false)
//     $('#factor_coreccion').collapse('hide');
//     $('#factor_coreccion').val('');
//     rellenarSelect("#Termometro_configuracion", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 })

//     ajaxAwait({
//         api: 11,
//     }, 'temperatura_api', { callbackAfter: true, WithoutResponseData: true }, false, (row) => {
//         for (const key in row) {
//             if (Object.hasOwnProperty.call(row, key)) {
//                 const element = row[key];
//                 $("#MATUTINO").val(element['MATUTINO_INICIO'])
//                 $("#VESPERTINO").val(element['VESPERTINO_INICIO'])

//                 if (element['DOMINGOS'] == 0) {
//                     $('#No').prop('checked', true)
//                 } else {
//                     $('#Si').prop('checked', true)
//                 }
//             }
//         }

//     })



//     $("#ConfiguracionModal").modal('show');
// })


$("#DomingosbtnTemperaturas").on('click', function (e) {
    e.preventDefault();

    CargarConfiguracionTemperaturas()

    Domingos = parseInt(dataConfig['DOMINGOS']) == 0 ? true : false;




    var config = {
        title: null,
        text: null,
        text2: null,
        action: null
    }
    switch (Domingos) {
        case true:
            config = {
                title: '¿Desea deshabilitar los dias domingos?',
                text: 'Se deshabilitaran los dias domingos ',
                text2: 'Domingos deshabilitado',
                action: 0
            }
            break;
        case false:
            config = {
                title: '¿Desea activar los dias domingos?',
                text: 'Se activaran los dias domingos ',
                text2: 'Domingos habilitado',
                action: 1
            }
            break;
        default:
            title = title
            text = text
            break;
    }

    alertMensajeConfirm({
        title: config.title,
        text: config.text,
        icon: 'info',
        confirmButtonText: "Si"
        // denyButtonText: "No",
        // showDenyButton: true
    }, () => {
        ajaxAwait({
            api: 12,
            domingos: config.action
        }, 'temperatura_api', { callbackAfter: true }, false, () => {
            alertToast(config.text2, 'success', 4000)
        })

        // alertToast('Domingo deshabilitado', 'success ', 1000)
        console.log("le dio que si el we")
    }, 1)


})

$("#TurnosbtnTemperaturas").on("click", function (e) {

    $("#TurnosTemperaturasModal").modal("show");
})


$("#TermometrosbtnTemperaturas").on("click", function (e) {
    TablaTermometrosDataTable.ajax.reload();
    $("#TermometrosTemperaturasModal").modal("show");


})

async function CargarConfiguracionTemperaturas() {
    return await ajaxAwait({
        api: 11,
    }, 'temperatura_api', { callbackAfter: true, WithoutResponseData: true }, false, (row) => {
        for (const key in row) {
            if (Object.hasOwnProperty.call(row, key)) {
                const element = row[key];
                dataConfig = element

                Domingos_bit = parseInt(dataConfig['DOMINGOS'])
                domingos = Domingos_bit;

                if (Domingos_bit == 1) {
                    // true
                    $('#Domingos').prop('checked', true)
                } else {
                    // False    
                    $('#Domingos').prop('checked', false)
                }


                $("#matutino_inicio").val(dataConfig['MATUTINO_INICIO'].split(':')[0] + ':' + dataConfig['MATUTINO_INICIO'].split(':')[1])
                $("#matutino_final").val(dataConfig['MATUTINO_FINAL'].split(':')[0] + ':' + dataConfig['MATUTINO_FINAL'].split(':')[1])
                $("#vespertino_inicio").val(dataConfig['VESPERTINO_INICIO'].split(':')[0] + ':' + dataConfig['VESPERTINO_INICIO'].split(':')[1])
                $("#vespertino_final").val(dataConfig['VESPERTINO_FINAL'].split(':')[0] + ':' + dataConfig['VESPERTINO_FINAL'].split(':')[1])
            }
        }
    })
}

$("#TermometrosTemperaturasForm").on("submit", function (e) {
    e.preventDefault();




    dataJsonTermometrosTemperaturas = {
        api: 14,
        Enfriador: selectedEquiposTemperaturas['ID_EQUIPO']
    };

    if (selectedEquiposTemperaturas['ID_TEMPERATURAS_EQUIPOS'] != null) {
        dataJsonTermometrosTemperaturas.id_temperaturas_equipos = selectedEquiposTemperaturas['ID_TEMPERATURAS_EQUIPOS'];
    }


    alertMensajeConfirm({
        title: "¿Está seguro de su captura?",
        text: "Se asignara el termometro al equipo",
        icon: "info"
    }, function () {
        ajaxAwaitFormData(dataJsonTermometrosTemperaturas, 'temperatura_api', 'TermometrosTemperaturasForm', { callbackAfter: true }, false, function (data) {
            alertToast('Termometro asigando con exito', 'success', 2000);
            $('#activarFactorCorrecion').prop('checked', false)
            $('#factor_correcion').val('');
            $("#Termometros_Equipos").val("");
            $("#TermometrosTemperaturasForm").addClass('disable-element');
            TablaTermometrosDataTable.ajax.reload();

            if (ListaEnfriadoresActiva) {
                LoadTermometros(DataEquipo.Enfriador);
            }
        })
    }, 1)
})