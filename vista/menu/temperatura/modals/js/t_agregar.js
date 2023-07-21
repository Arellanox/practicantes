$("#CapturarTemperaturabtn").on('click', function (e) {
    e.preventDefault();

    $("#lectura").val("");
    $("#observaciones").val("")

    $("#CapturarTemperaturaModal").modal('show');
})

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