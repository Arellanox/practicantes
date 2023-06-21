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


$(document).on('click', '#ModalFirmaTemperatura', function (e) {
    e.preventDefault();
    e.stopPropagation()
    console.log("estas en firma modal")
    resetFirma(firma_guardar.ctx, firma_guardar.canvas)
    $('#TemperaturaModalFirma').modal('show');
})

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


    tablaTemperaturaFolio.ajax.reload()


    $('#Enfriador').val(id_equipos)
    $('#lista-meses-temperatura').fadeToggle(0)
    $('#LibererDiaTemperatura').fadeIn(0);
    $('#formCapturarTemperatura').removeClass('disable-element')
    $('#Equipos').addClass('disable-element')
    $('#btn-equipo-temperatura').addClass('disable-element')
    $('#btn-desbloquear-equipos').fadeIn(0)


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

})

$('#btn-desbloquear-equipos').on('click', function (e) {
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


    $("#formCapturarTemperatura").trigger("reset")

})

$(document).on("click", ".reset_firma", function (e) {
    e.preventDefault();
    e.stopPropagation()

    let tipo = $(this).attr("data_tipo");

    switch (tipo) {
        case "actualizar":
            resetFirma(firma_actualizar.ctx, firma_actualizar.canvas);
            break;
        case "guardar":
            resetFirma(firma_guardar.ctx, firma_guardar.canvas);
            break;
        default:
            break;
    }

})

//Comprueba el evento submit del formulario, si dan click al button se manda el formulario, se recupera la informacion de los input y se guarda y setea en un formData para enviarlo a la api y capturarlos en la base de datos
$("#formCapturarTemperatura").on("submit", function (e) {
    e.preventDefault();

    editRegistro = false;
    if (firmaExist == false) {
        if (validarFormulario(firma_guardar.canvas, firma_guardar.ctx, firma_guardar.firma) == false) {
            return false;
        }
    }

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
        switch (editRegistro) {
            case true:
                console.log("esta actualizando nueva temperatura")
                dataJson["id_registro_temperatura"] = selectRegistro['ID_REGISTRO_TEMPERATURA']
                form = "formActualizarTemperatura"
                break;
            case false:
                console.log("esta registrando una nueva temperatura")
                form = "formCapturarTemperatura"
                break;
            default:
                console.log("no esta ni registrando ni actualizando")
                return false;
                break;
        }

        ajaxAwaitFormData(dataJson, 'temperatura_api', form, { callbackAfter: true }, false, function (data) {
            alertToast('Registro realizado correctamente', 'success', 4000)
            $("#grafica").html("");
            CrearTablaPuntos(DataMes['FOLIO']);


            $('#formCapturarTemperatura').trigger("reset");
            $('#formActualizarTemperatura').trigger("reset");
            $("#formActualizarTemperatura").addClass('disable-element');
            resetFirma(firma_actualizar.ctx, firma_actualizar.canvas);
            resetFirma(firma_guardar.ctx, firma_guardar.canvas);
            firmaExist = false
            if (selectTableFolio) {
                console.log('si entro')
                tablaTemperatura.ajax.reload()
            } else {
                console.log('No')
                tablaTemperaturaFolio.ajax.reload()
            }
        })
    }, 1)
}


id_registro_dor = false
$(document).on('click', '.td-hover', async function (event) {
    event.preventDefault();
    event.stopPropagation();

    session.permisos.SupTemp === 0 ? $("#formAgregarComentario").addClass("disable-element") : $("#formAgregarComentario").removeClass("disable-element")


    let dot = $(this)
    id_registro_dor = dot.attr('data_id')

    $("#formAgregarComentario").trigger("reset")

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
                    $("#fecha_comentario").html(formatoFecha2(element['FECHA'], [0, 1, 5, 2, 1, 1, 1]))
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