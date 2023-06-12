
$("#formFacturarGrupoCredito").on('submit', function (e) {
    e.preventDefault();

    facturado = ($("#NumeroFactura").val())

    if (facturado == "") {
        alertToast("Rellene el campo requerido", "error", 3000)
        return false;
    }


    id_grupo = SelectedGruposCredito['ID_GRUPO']
    FacturarGruposCredito(facturado, id_grupo)
})