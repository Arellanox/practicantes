
$(document).on('click', '#terminar-proceso-cargo', function (event) {
    event.preventDefault();

    //Pregunta al usuario el tipo de factura
    alertMensajeConfirm({
        title: '¿El paciente requiere factura?', text: '', icon: '',
        confirmButtonText: 'Si',
        denyButtonText: `No`,
        showDenyButton: true,
        showCancelButton: false
    }, function () {
        //Si fue si, abrir el modal de factura
        configurarFactura(dataPaciente);
    }, 1, function () {
        //Si fue no, terminar el proceso con el tipo de pago contado...
        metodo();
    })

})


//Variable globales
var tipo_pago = false, tipo_factura = false;
var dataPaciente;
//Vista de estudios que se le hicieron al paciente
function configurarModal(data) {
    //Estatus en proceso
    tipo_pago = $('#contado-tipo-pago').val();
    tipo_factura = false
    dataPaciente = data;
    $('#nombre-paciente-contado').html(`${data['NOMBRE_COMPLETO']}`);
    //Mensaje de espera al usuario
    alertToast('Espere un momento', 'info', 4000);

    rellenarSelect('#contado-tipo-pago', 'formas_pago_api', '2', 'ID_PAGO', 'DESCRIPCION');

    ajaxAwait({
        api: 1,
        turnos_id: data['ID_TURNO'],
    }, 'cargos_turnos_api', { callbackAfter: true }, false, function (data) {
        //El arreglo debe contener tanto un arreglo de los estudios como el total de precio de los estudios
        //let row = data.response.data; // todos los datos

        data = data.response.data; //Todos los datos para el detalle;
        let row = data.response.data['estudios']; // <-- Listas de estudios en bruto

        for (const key in row) {
            if (Object.hasOwnProperty.call(row, key)) {
                const element = row[key];

                //Crea la fila de la tabla, Nombre del servicio, cantidad, y precio antes de iva
                let html = `<tr>
                                <th>${element['DESCRIPCION']}</th> 
                                <td>${element['CANTIDAD']}</td>
                                <td>${element['PRECIO_VENTA']}</td>
                            </tr>`

                //Adjunta a las tablas la area correspondiente
                if (element['AREA_ID'] == '11' || element['AREA_ID'] == '12' || element['AREA_ID'] == '6' || element['AREA_ID'] == '8') {
                    $(`#cargos-estudios-${element['AREA_ID']}`).append(html)
                    $(`#container-estudios-${element['AREA_ID']}`).fadeIn(0)
                } else {
                    $(`#cargos-estudios-0`).append(html);
                    $(`#container-estudios-0`).fadeIn(0)
                }

            }
        }


        //Lista de precio, total de estudios, detalle fuera
        $('#precio-total-cargo').html(`$${data['TOTAL_CARGO']}`)
        $('#precio-descuento').html(`$${data['DESCUENTO']}`)
        $('#precio-subtotal').html(`$${data['SUBTOTAL']}`)
        $('#precio-iva').html(`$${data['IVA']}`)
        $('#precio-total').html(`$${data['TOTAL']}`)
    })

    $('#modalEstudiosContado').modal('show');
}

//Vista de factura (faltan datos)
function configurarFactura(data) {
    tipo_factura = true;

    $('#nombre-paciente-contado').html(`${data['NOMBRE_COMPLETO']}`);

    //Mensaje de espera al usuario
    alertToast('Espere un momento', 'info', 4000);

    $('#modalFacturaPaciente').modal('show');

}

//Llamado como "metodo"
function metodo() {
    //Termina el proceso del paciente con las llamadas que hizo el usuario
    finalizarProcesoRecepcion(data);
}