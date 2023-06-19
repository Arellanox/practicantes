$(document).on("click", ".btn-editar", function (e) {
    e.stopPropagation()

    editRegistro = true
    if (selectRegistro && !(validarPermiso('SupTemp') ? false : parseInt(selectRegistro['ESTATUS']))) {
        firstSelect(true)
    } else {
        alertToast("No ha seleccionado ningun registro", "info", 4000)
    }
})

$(document).on('click', '.btn-liberar', function (event) {
    event.stopPropagation();

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
            if (selectTableFolio) {
                console.log('si entro')
                tablaTemperatura.ajax.reload()
            } else {
                console.log('No')
                tablaTemperaturaFolio.ajax.reload()
            }
        })
    }, 1)
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


    if (firmaExist == false) {
        if (validarFormulario(firma_guardar.canvas, firma_guardar.ctx, firma_guardar.firma) == false) {
            return false;
        }
    }

    CargarTemperatura()

})


function CargarTemperatura() {

    alertMensajeConfirm({
        title: "¿Estás seguro de su captura?",
        text: "Ya no podrás modificar este registro",
        icon: "info"
    }, function () {

        // data = new FormData(document.getElementById('formCapturarTemperatura'));
        // console.log(data);

        let dataJson = {
            api: 1
        }

        if (editRegistro)
            dataJson["id_registro_temperatura"] = selectRegistro['ID_REGISTRO_TEMPERATURA']


        switch (editRegistro) {
            case true:
                console.log("esta actualizando nueva temperatura")
                break; $("#formActualizarTemperatura").removeClass('disable-element');
            case false:
                console.log("esta registrando una nueva temperatura")
                break;
            default:
                console.log("no esta ni registrando ni actualizando")
                break;
        }

        // ajaxAwaitFormData(dataJson, 'temperatura_api', 'formCapturarTemperatura', { callbackAfter: true }, false, function (data) {
        //     alertToast('Registro realizado correctamente', 'success', 4000)
        //     $("#grafica").html("");
        //     CrearTablaPuntos(DataMes['FOLIO']);


        //     $('#formCapturarTemperatura').trigger("reset");
        //     resetFirma()

        //     if (selectTableFolio) {
        //         console.log('si entro')
        //         tablaTemperatura.ajax.reload()
        //     } else {
        //         console.log('No')
        //         tablaTemperaturaFolio.ajax.reload()
        //     }
        // })
    }, 1)
}


