// $(document).on('click', '#ticketDataButton', function (event) {
//     event.preventDefault();
//     event.stopPropagation();






// })

// $(document).on('click', '#GrupoInfoCreditoBtn', function (event) {
//     event.preventDefault();
//     event.stopPropagation();


// })

$("#FacturarGruposCredito").on('click', function (e) {
    e.preventDefault();
    alertMensajeConfirm({
        title: 'Requiere Factura?',
        text: '',
        icon: 'info',
        confirmButtonText: "Si, Requiero Factura"
    }, () => {
        factura = true;
        $("#ModalTicketCreditoFacturado").modal('show');
    }, 1)

})


function FacturarGruposCredito(facturado = null, id_grupo = null) {

    let config = {
        api: 1,
        num_factura: "",
        id_grupo: id_grupo,
        facturado: 1
    }

    if (facturado) {
        config.num_factura = facturado;
    }

    ajaxAwait(config, 'admon_grupos_api', { callbackAfter: true }, false, function (response) {
        $("#ModalTicketCreditoFacturado").modal('hide');

        console.log(response)

        alertToast("Factura guardada con exito", "success", 3000)

        TablaGrupos.ajax.reload();



    })




}




