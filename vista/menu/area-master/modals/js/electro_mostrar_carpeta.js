const MostrarCapturasElectro = document.getElementById('MostrarCapturasElectro')
MostrarCapturasElectro.addEventListener('show.bs.modal', event => {

    $('#divCapturasModalElectro').html('')
    $.ajax({
        url: `${http}${servidor}/${appname}/api/${url_api}.php`,
        data: {
            api: 3
        },
        type: "POST",
        dataType: 'json',
        success: function (data) {
            if (mensajeAjax(data)) {
                let row = data.response.data;
                for (const key in row) {
                    if (Object.hasOwnProperty.call(row, key)) {
                        const element = row[key];
                        console.log(element);
                        let html = '<div class="col-6">' +
                            '<div class="form-check">' +
                            '<input class="form-check-input" type="radio" name="RadioSelectElectro" id="RadioSelectElectro1' + key + '" data="' + element[0] + '">' +
                            '<label class="form-check-label" for="RadioSelectElectro1' + key + '">' +
                            'Seleccionar archivo: ' + element[1] +
                            '</label>' +
                            '</div>' +
                            '<object data="' + element[0] + '"' +
                            'type="application/pdf" width="100%" style="height: 82vh;">' +
                            '<iframe src="' + element[0] + '"' +
                            'width="100%" height="100%" style="border: none;">' +
                            '<p>' +
                            'Your browser does not support PDFs.' +
                            '<a href="' + element[0] + '">Download' +
                            'the PDF</a>' +
                            '.' +
                            '</p>' +
                            '</iframe>' +
                            '</object>' +
                            '</div>';
                        $('#divCapturasModalElectro').append(html)


                    }
                }
            }
        }
    })

})


$('#cargarElectroCaptura').click(function (e) {
    if (session['permisos']['CaptuElectro']) {
        if ($('input[type="radio"][name="RadioSelectElectro"]').is(':checked')) {
            alertMensajeConfirm({
                tittle: '¿Está seguro de cargar el electrocardiograma seleccionado?',
                text: '¡No podrás revertir los cambios!',
                icon: 'info'
            }, function () {
                $.ajax({
                    url: `${http}${servidor}/${appname}/api/${url_api}.php`,
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        api: api_capturas,
                        id_turno: dataSelect.array['turno'],
                        electro_pdf: $('input[type="radio"][name="RadioSelectElectro"]:checked').attr('data')
                    },
                    beforeSend: function () {
                        $("#cargarElectroCaptura").prop('disabled', true)
                        alertMensaje('info', 'Cargando electro', 'Espere un momento');
                    },
                    success: async function (data) {
                        if (mensajeAjax(data)) {
                            alertMensaje('success', '¡Electro cargado!', 'Podrás consultar el documento cargado en la ventana de resultados');
                            $('#MostrarCapturasElectro').modal('hide')
                            await obtenerServicios(areaActiva, dataSelect.array['turno'])
                            await mostrarElectroInterpretacion(selectEstudio.array[0].ELECTRO_PDF)

                            $("#cargarElectroCaptura").prop('disabled', false)
                            // estadoFormulario(1)

                        }
                    },

                })
            }, 1)
        } else {
            alertToast('Por favor seleccione una opción')
        }
    } else {
        alertMensaje('info', 'Oops...', 'No tienes permiso para realizar esta acción')
    }
})