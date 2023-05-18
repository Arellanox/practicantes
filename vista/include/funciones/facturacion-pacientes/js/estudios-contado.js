//Variable globales
var tipo_pago = false, tipo_factura = false
var dataPaciente, dataPrecios = {};


$(document).on('click', '#terminar-proceso-cargo', function (event) {
    event.preventDefault()

    //Pregunta al usuario el tipo de factura
    alertMensajeConfirm({
        title: '¿El paciente requiere factura?', text: 'Verifique que el tipo de dato sea correcto', icon: '',
        confirmButtonText: 'Si',
        denyButtonText: `No`,
        denyButtonColor: 'gray',
        showDenyButton: true,
        cancelButtonText: 'Cancelar'
    }, function () {
        //Si fue si, abrir el modal de factura
        $('#modalEstudiosContado').modal('hide')
        configurarFactura(dataPaciente)
    }, 1, function () {
        //Si fue no, terminar el proceso con el tipo de pago contado...
        metodo()
    })

})

$(document).on('submit', '#formularioPacienteFactura', function (event) {
    event.preventDefault()

    alertMensajeConfirm({
        title: '¿Esta seguro que todos los datos están correctos',
        text: '¡No puedes cambiar estos datos después!',
        icon: 'warning',
        confirmButtonText: 'Si, estoy seguro'
    }, function () {
        //envio de datos (factura y tipo de pago_datos)
        ajaxAwaitFormData({
            api: 1, turno_id: dataPaciente['ID_TURNO'],
            descuento_porcentaje: dataPrecios['descuento_porcentaje'], descuento: 0, total_cargos: 0,
            subtotal: 0, iva: 0, total: 0, pago: $('#contado-tipo-pago').val(), referencia: $('#referencia-contado').val(), requiere_factura: 1
        }, 'tickets_api', 'formularioPacienteFactura', { callbackAfter: true }, false, function (data) {
            alertTicket(data, 'Factura y ticket guardado')
        })
    }, 1)

    event.preventDefault()
})


//Vista de estudios que se le hicieron al paciente
function configurarModal(data) {
    //Estatus en proceso
    tipo_pago = $('#contado-tipo-pago').val()
    tipo_factura = false
    dataPaciente = data
    $('#nombre-paciente-contado').html(`${data['NOMBRE_COMPLETO']}`)
    //Mensaje de espera al usuario
    alertToast('Espere un momento', 'info', 4000)

    rellenarSelect('#contado-tipo-pago', 'formas_pago_api', '2', 'ID_PAGO', 'DESCRIPCION')

    ajaxAwait({
        api: 1,
        turno_id: data['ID_TURNO'],
    }, 'cargos_turnos_api', { callbackAfter: true, returnData: false }, false, function (data) {
        //El arreglo debe contener tanto un arreglo de los estudios como el total de precio de los estudios
        //let row = data.response.data // todos los datos

        data = data.response.data //Todos los datos para el detalle


        dataPrecios = {
            descuento_porcentaje: data['DESCUENTO_PORCENTAJE']
        }

        let row = data['estudios'] // <-- Listas de estudios en bruto

        $('.contenido-estudios').html('')

        for (const key in row) {
            if (Object.hasOwnProperty.call(row, key)) {
                const element = row[key]

                //Crea la fila de la tabla, Nombre del servicio, cantidad, y precio antes de iva
                let html = `<tr>
                                <th>${element['servicios']}</th> 
                                <td>${ifnull(element['CANTIDAD'], 0)}</td>
                                <td>$${ifnull(element['PRECIO'], 0)}</td>
                            </tr>`

                //Adjunta a las tablas la area correspondiente
                if (element['AREA_ID'] == '11' || element['AREA_ID'] == '12' || element['AREA_ID'] == '6' || element['AREA_ID'] == '8') {
                    $(`#cargos-estudios-${element['AREA_ID']}`).append(html)
                    $(`#container-estudios-${element['AREA_ID']}`).fadeIn(0)
                } else {
                    $(`#cargos-estudios-0`).append(html)
                    $(`#container-estudios-0`).fadeIn(0)
                }

            }
        }


        //Lista de precio, total de estudios, detalle fuera
        $('#precio-total-cargo').html(`$${ifnull(data['TOTAL_CARGO'])}`)
        $('#precio-descuento').html(`$${ifnull(data['DESCUENTO'])}`)
        $('#precio-subtotal').html(`$${ifnull(data['SUBTOTAL'])}`)
        $('#precio-iva').html(`$${ifnull(data['IVA'])}`)
        $('#precio-total').html(`$${ifnull(data['TOTAL'])}`)

        $('#modalEstudiosContado').modal('show')

    })


}

//Vista de factura (faltan datos)
function configurarFactura(data) {
    tipo_factura = true

    $('#nombre-paciente-factura').html(`${data['NOMBRE_COMPLETO']}`)

    //Mensaje de espera al usuario
    alertToast('Espere un momento', 'info', 4000)

    rellenarSelect('#regimen_fiscal-factura', 'sat_regimen_api', 1, 'ID_REGIMEN', 'REGIMEN_FISCAL')
    rellenarSelect('#uso-factura', 'sat_catalogo_api', 2, 'SAT_ID_CODIGO', 'COMPLETO')

    $('#rfc-factura').val(data['RFC'])

    $('#modalFacturaPaciente').modal('show')

}

//No requiere factura o el mensaje de factura le dio que no
function metodo() {
    //Termina el proceso del paciente con las llamadas que hizo el usuario
    finalizarProcesoRecepcion(data)
    ajaxAwait({
        api: 1, turno_id: dataPaciente['ID_TURNO'],
        descuento_porcentaje: dataPrecios['descuento_porcentaje'], descuento: 0, total_cargos: 0,
        subtotal: 0, iva: 0, total: 0, pago: $('#contado-tipo-pago').val(), referencia: $('#referencia-contado').val(), requiere_factura: 0
    }, 'tickets_api', { callbackAfter: false }, function (data) {
        alertTicket(data, 'Ticket guardado')
    })
}

function alertTicket(data, textAlert) {
    data = data.response.data

    // alertMsj({
    //     title: textAlert,
    //     text: 'Se ha generado el ticket',
    //     icon: 'success',
    //     html: ` <p>Se ha generado el ticket, dale click aqui: </p>
    //     <a href="${data['url_ticket']}" type="button" class="btn btn-cancelar" target="_blank">
    //         <i class="bi bi-file-earmark-pdf"></i> Ticket
    //     </a>
    //     `
    // })

    alertMensaje('success', textAlert, 'Se ha generado el ticket');

    $('#modalEstudiosContado').modal('hide')

    $('#modalFacturaPaciente').modal('hide')
}


select2('#regimen_fiscal-factura', 'modalFacturaPaciente', 'Espere un momento')
select2('#uso-factura', 'modalFacturaPaciente', 'Espere un momento')