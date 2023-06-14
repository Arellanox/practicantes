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

                totalServicio = (parseInt(element['CANTIDAD']) * parseFloat(element['COSTO'])).toFixed(2)


                let html = `
                 <tr>
                                        <td>${element['SERVICIOS']}</td>
                                        <td>E48 -Unidad de
                                            servicio
                                        </td>
                                        <td>${element['COSTO']}</td>
                                        <td>${element['CANTIDAD']}</td>
                                        <td>$${totalServicio}</td>
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

$(document).on('click', '#GrupoInfoCreditoBtn', function (event) {
    event.preventDefault();
    event.stopPropagation();

    //Reinicia todos los datos a vacios antes de abrir el modal
    $('#procedencia_grupos_credito').html("");
    $('#domicilio-fiscal').html("");
    $('#fecha-factura').html("");
    $('#factura').html("");
    $('#telefono').html("");
    $('#rfc').html("");


    $("#ModalInformacionGruposCredito_title").html(`Informacion Grupos de Crédito - (${SelectedGruposCredito['ID_GRUPO']})`)
    $('#procedencia_grupos_credito').html(SelectedGruposCredito['PROCEDENCIA']);
    $('#domicilio-fiscal').html(SelectedGruposCredito['DIRECCION']);
    $('#fecha-factura').html(formatoFecha2(SelectedGruposCredito['FECHA_FACTURA'], [0, 1, 3, 1]));
    $('#factura').html(SelectedGruposCredito['FACTURA']);
    $('#rfc').html(SelectedGruposCredito['RFC']);


    $('#ModalInformacionGruposCredito').modal('show');
})

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
        id_grupo: id_grupo
    }

    if (facturado) {
        config.num_factura = facturado;
    }

    ajaxAwait(config, 'admon_grupos_api', { callbackAfter: true }, false, function (response) {
        $("#ModalTicketCreditoFacturado").modal('hide');

        console.log(response)

        alertToast("Factura guardada con exito", "success", 3000)
    })




}

