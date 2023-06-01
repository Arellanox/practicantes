enfriadorData = {}, termometroData = {}

/* $(document).ready(function () {

    $("#enfriadorMarca").val("")
    $("#termometroMarca").val("")
    $("#intervalo").val("")
    $("#lectura").val("")
    $("#observaciones").val("")


    rellenarSelect("#Enfriador", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 5 }, function (data) {
        enfriadorData = data
        $("#enfriadorMarca").val(ifnull(enfriadorData[$("#Enfriador").prop("selectedIndex")]['MARCA']))
    })

    rellenarSelect("#Termometro", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 }, function (data) {
        termometroData = data
        $("#termometroMarca").val(ifnull(termometroData[$("#Termometro").prop("selectedIndex")]['MARCA']))
    })

    $("#usuarioQueCargar").html(`Capturando por:<strong>${session.nombre} ${session.apellidos}</strong>`)
})
 */

$("#capturarTemperatura").on("click", function (e) {
    e.preventDefault();

    alertToast('Espere un momento', 'info', 3000)

    $("#enfriadorMarca").val("")
    $("#termometroMarca").val("")
    $("#intervalo").val("")
    $("#lectura").val("")
    $("#observaciones").val("")

    rellenarSelect("#Enfriador", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 5 }, function (data) {
        enfriadorData = data
        $("#enfriadorMarca").val(ifnull(enfriadorData[$("#Enfriador").prop("selectedIndex")]['MARCA']))
    })

    rellenarSelect("#Termometro", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 }, function (data) {
        termometroData = data
        $("#termometroMarca").val(ifnull(termometroData[$("#Termometro").prop("selectedIndex")]['MARCA']))
    })

    $("#capturarTemperaturaModal").modal("show");
    $("#usuarioQueCargar").html(`Capturando por:<strong>${session.nombre} ${session.apellidos}</strong>`)

})


$("#Enfriador").on("change", function () {

    let Data = enfriadorData[$("#Enfriador").prop("selectedIndex")]

    $("#enfriadorMarca").val(ifnull(Data['MARCA']))
})


$("#Termometro").on("change", function () {
    let Data = termometroData[$("#Enfriador").prop("selectedIndex")]

    $("#termometroMarca").val(ifnull(Data['MARCA']))
})



//Comprueba el evento submit del formulario, si dan click al button se manda el formulario, se recupera la informacion de los input y se guarda y setea en un formData para enviarlo a la api y capturarlos en la base de datos
$("#formCapturarTemperatura").on("submit", function (e) {
    e.preventDefault();

    alertMensajeConfirm({
        title: "Estas seguro de su captura?",
        text: "Ya no podras modificar este registro",
        icon: "info"
    }, function () {
        ajaxAwaitFormData({
            api: 1
        }, 'temperatura_api', 'formCapturarTemperatura', { callbackAfter: true }, false, function (data) {
            alertTemperatura("Temperatura capturada");
            console.log(data)
        })
    }, 1)
})




function cargarTemperatura(data) {
    alertToast('Espere un momento', 'info', 4000)
    /*  $("#capturarTemperaturaModal").modal("hide"); */
}


function alertTemperatura(text) {
    alertMensaje('success', text, 'Se ha guardado el registro correctamente');

    $("#capturarTemperaturaModal").modal("hide");

    tablaTemperatura.ajax.reload()
    tablaTemperaturaFolio.ajax.reload()
}