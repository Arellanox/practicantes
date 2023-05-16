
$(document).on('click', '#terminar-proceso-cargo', function (event) {
    event.preventDefault();

    alertMensajeConfirm({
        title: '¿El paciente requiere factura?', text: '', icon: '',
        confirmButtonText: 'Si',
        denyButtonText: `No`,
        showDenyButton: true,
        showCancelButton: false
    }, function () {
        configurarFactura();
    }, 1, function () {
        metodo();
    })

})

var tipo_pago = false, tipo_factura = false;

function configurarModal(data) {
    tipo_pago = 'Contado';
    tipo_factura = false

    $('#nombre-paciente-contado').html(`${data['NOMBRE_COMPLETO']}`);
    ajaxAwait({
        api: 1,
        turnos_id: data['ID_TURNO'],
    }, 'cargos_turnos_api', { callbackAfter: true }, false, function (data) {
        //El arreglo debe contener tanto un arreglo de los estudios como el total de precio de los estudios
        let row = data.response.data; // arreglo de estudios (en bruto)

        for (const key in row) {
            if (Object.hasOwnProperty.call(row, key)) {
                const element = row[key];

                let html = `<tr>
                                <th>${element['DESCRIPCION']}</th>
                                <td>${element['CANTIDAD']}</td>
                                <td>${element['PRECIO_VENTA']}</td>
                            </tr>`

                if (element['AREA_ID'] == '11' || element['AREA_ID'] == '12' || element['AREA_ID'] == '6' || element['AREA_ID'] == '8') {
                    $(`#cargos-estudios-${element['AREA_ID']}`).append(html)
                    $(`#container-estudios-${element['AREA_ID']}`).fadeIn(0)
                } else {
                    $(`#cargos-estudios-0`).append(html);
                    $(`#container-estudios-0`).fadeIn(0)
                }

            }
        }


        //Lista de precio, total de estudios
        $('#precio-total-cargo').html(`$${row['TOTAL_CARGO']}`)
        $('#precio-descuento').html(`$${row['DESCUENTO']}`)
        $('#precio-subtotal').html(`$${row['SUBTOTAL']}`)
        $('#precio-iva').html(`$${row['IVA']}`)
        $('#precio-total').html(`$${row['TOTAL']}`)
    })


    $('#modalEstudiosContado').modal('show');
}

function configurarFactura() {
    tipo_factura = true;

}


function metodo() {
    finalizarProcesoRecepcion(data, tipo_pago, tipo_factura);
}