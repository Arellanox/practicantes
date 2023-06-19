enfriadorData = {}, termometroData = {}, firmaExist = false, SelectedFoliosData = {};
// Obtener datos del paciente seleccionado
const capturarTemperaturaModal = document.getElementById('capturarTemperaturaModal')
capturarTemperaturaModal.addEventListener('show.bs.modal', event => {
    $("#usuarioQueCargar").html(`Capturando por:<strong>${session.nombre} ${session.apellidos}</strong>`)

})

$("#capturarTemperatura").on("click", function (e) {
    e.preventDefault();

    alertToast('Espere un momento', 'info', 3000)

    editRegistro = false
    firstSelect()

})


async function firstSelect(call = false) {
    alertMsj({
        title: "Espere un momento",
        text: "Cargando datos...",
        icon: "info",
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false
    })

    resetFirma()
    $("#formCapturarTemperatura").trigger("reset")

    // await rellenarSelect("#Enfriador", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 5 }, function (data) {
    //     enfriadorData = data
    //     $("#enfriadorMarca").val(ifnull(enfriadorData[$("#Enfriador").prop("selectedIndex")]['MARCA']))

    //     let intervalo = enfriadorData[$("#Enfriador").prop("selectedIndex")]['INTERVALO_MIN'] + " A " + enfriadorData[$("#Enfriador").prop("selectedIndex")]['INTERVALO_MAX'] + "°C"
    //     $("#intervalo").val(ifnull(intervalo))
    // })

    await rellenarSelect("#Termometro", "equipos_api", 1, "ID_EQUIPO", "DESCRIPCION", { id_tipos_equipos: 4 }, function (data) {
        termometroData = data
        $("#termometroMarca").val(ifnull(termometroData[$("#Termometro").prop("selectedIndex")]['MARCA']))
    })

    $("#firmaCanvas").show()
    $("#img-firma").hide()
    firmaExist = false
    if (call) {
        $("#temperaturaTitle").html(`Actualizar registro de temperatura ${formatoFecha2(selectRegistro['FECHA_REGISTRO'], [0, 1, 5, 2, 1, 1, 1])}`)


        $("#Enfriador").val(selectRegistro['EQUIPO_ID'])
        $("#Termometro").val(selectRegistro['TERMOMETRO_ID'])
        $("#enfriadorMarca").val(selectRegistro['MARCA_EQUIPO'])
        $("#termometroMarca").val(selectRegistro['MARCA_TERMOMETRO'])
        $("#intervalo").val(ifnull(selectRegistro['INTERVALO_MIN'], 0) + " A " + ifnull(selectRegistro['INTERVALO_MAX'], 0) + "°C")
        $("#lectura").val(selectRegistro['LECTURA'])
        $("#observaciones").val(selectRegistro['OBSERVACIONES'])

        if (selectRegistro['FIRMA_TEMPERATURA'] == null) {
            $("#img-firma").hide()
            $("#firmaCanvas").show()
        } else {
            $("#firmaCanvas").hide()
            $("#img-firma").attr("src", selectRegistro['FIRMA_TEMPERATURA'])
            $("#img-firma").show()
            firmaExist = true
        }

    }

    $("#capturarTemperaturaModal").modal("show");
    swal.close()
}

$("#Enfriador").on("change", function () {

    let Data = enfriadorData[$("#Enfriador").prop("selectedIndex")]
    let IntervaloOptimo = Data['INTERVALO_MIN'] + " A " + Data['INTERVALO_MAX'] + "°C"
    $("#enfriadorMarca").val(ifnull(Data['MARCA']))
    $("#intervalo").val(ifnull(IntervaloOptimo))
})


$("#Termometro").on("change", function () {
    let Data = termometroData[$("#Enfriador").prop("selectedIndex")]

    $("#termometroMarca").val(ifnull(Data['MARCA']))
})


