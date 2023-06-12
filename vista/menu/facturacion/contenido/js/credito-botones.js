$(document).on('click', '#ticketDataButton', function (event) {
    event.preventDefault();
    event.stopPropagation();
    $('#PacienteCreditoColumn').html("");

    ajaxAwait({
        api: 1,
        turno_id: SelectedPacienteCredito['ID_TURNO']
    }, "cargos_turnos_api", { callbackAfter: true }, false, function (data) {

        dataServicios = data.response.data.estudios


        for (const data in dataServicios) {
            if (Object.hasOwnProperty.call(dataServicios, data)) {
                const element = dataServicios[data];

                let html = `
                 <tr>
                                        <td>${element['SERVICIOS']}</td>
                                        <td>E48 -Unidad de
                                            servicio
                                        </td>
                                        <td>${element['COSTO']}</td>
                                        <td>${element['CANTIDAD']}</td>
                                        <td>5.00%</td>
                                        <td>16%</td>
                                        <td>$105.00</td>
                 </tr>
                `;

                $('#PacienteCreditoColumn').append(html);


            }
        }

        $("#ModalTicketCredito").modal('show');
    })




})