$(document).on('click', '#ticketDataButton', function (event) {
    event.preventDefault();
    event.stopPropagation();


    $("#paciente").html("")
    $('#PacienteCreditoColumn').html("");
    $("#total").html("")
    $("#subtotal").html("")
    $("#Iva").html("")


    ajaxAwait({
        api: 1,
        turno_id: SelectedPacienteCredito['ID_TURNO']
    }, "cargos_turnos_api", { callbackAfter: true }, false, function (data) {
        $("#paciente").html(SelectedPacienteCredito['PX'])
        dataServicios = data.response.data.estudios

        let subtotal = 0;


        for (const data in dataServicios) {
            if (Object.hasOwnProperty.call(dataServicios, data)) {
                const element = dataServicios[data];


                subtotal += parseFloat(element['COSTO']);

                // iva = (element['COSTO'] * 0.16)
                // total = iva + element['COSTO']
                // total = parseFloat(total).toFixed(2)


                let html = `
                 <tr>
                                        <td>${element['SERVICIOS']}</td>
                                        <td>E48 -Unidad de
                                            servicio
                                        </td>
                                        <td>${element['COSTO']}</td>
                                        <td>${element['CANTIDAD']}</td>
                                        <td>5.00%</td>
                                        <td>$0.00</td>
                 </tr>
                `;

                $('#PacienteCreditoColumn').append(html);



            }
        }

        let subtotalconiva = parseFloat(subtotal * 0.16).toFixed(2);
        total = parseFloat(subtotal) + parseFloat(subtotalconiva)

        $("#subtotal").html(`$${subtotal.toFixed(2)}`)
        $("#Iva").html(`$${subtotalconiva}`)
        $("#total").html(`$${total.toFixed(2)}`)

        $("#ModalTicketCredito").modal('show');
    })




})


$("#FacturarGruposCredito").on('click', function (e) {
    e.preventDefault();
    alertMensajeConfirm({
        title: 'Requiere Factura?',
        text: '',
        icon: 'info',
        confirmButtonText: "Si, Requiero Factura",
        showDenyButton: true
    }, () => {
        factura = true;
        $("#ModalTicketCreditoFacturado").modal('show');
    }, 1, function () {
        factura = false;
        id_grupo = SelectedGruposCredito['ID_GRUPO']
        FacturarGruposCredito(null, id_grupo)
    })

})


function FacturarGruposCredito(facturado = null, id_grupo = null) {

    let config = {
        api: 1,
        num_factura: "",
        id_grupo: id_grupo
    }

    if (facturado) {
        config.num_factura = facturado;
    }

    console.log(config);

    ajaxAwait(config, 'admon_grupos_api', { callbackAfter: true }, false, function (response) {
        $("#ModalTicketCreditoFacturado").modal('hide');

        console.log(response)

        alertToast("Factura guardada con exito", "success", 3000)
    })




}

