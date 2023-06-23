$('#inputFilesInterpreArea').on('change', function () {
    var fileList = $(this)[0].files || [] //registra todos los archivos
    let aviso = 0;
    for (file of fileList) { //una iteración de toda la vida
        ext = file.name.split('.').pop()
        console.log('>ARCHIVO: ', file.name)
        switch (ext) {
            case 'pdf':
                // console.log('>>TIPO DE ARCHIVO CORRECTO: ')
                break;
            default:
                aviso = 1;
                // console.log('>>TIPO DE ARCHIVO INCORRECTO', ext
                break;
        }
    }
    if (aviso == 1) {
        $(this).val('')
        alertMensaje('error', 'Archivo incorrecto', 'Algunos archivos no son correctos')
    }
});

// const ModalSubirInterpretacion = document.getElementById('ModalSubirInterpretacion')
// ModalSubirInterpretacion.addEventListener('show.bs.modal', event => {
//     // console.log(selectPacienteArea)
//     $('#Area-estudio').html(hash)
//     // alert(selectEstudio.selectID)
//     document.getElementById("formSubirInterpretacion").reset();
//     $('#nombre-paciente-interpretacion').val(selectPacienteArea['NOMBRE_COMPLETO'])
// })


//Formulario Para Subir Interpretacion
$(`#${formulario}`).submit(function (event) {
    // alert(areaActiva)
    event.preventDefault();
    /*DATOS Y VALIDACION DEL REGISTRO*/

    if (confirmado != 1 || session.permisos['Actualizar reportes'] == 1) {

        if (validarCuestionarioEspiro()) {
            return false;
        }

        var form = document.getElementById(`${formulario}`);
        var formData = new FormData(form);
        formData.set('id_turno', dataSelect.array['turno'])
        // formData.set('id_servicio', selectEstudio.selectID)
        formData.set('id_area', areaActiva)
        // formData.set('confirmado', 0);
        // formData.set('tipo_archivo', 1)


        //Api y url sacada desde el controlador
        formData.set('api', api_interpretacion);
        alertMensajeConfirm({
            title: "¿Está seguro de subir la interpretación?",
            text: "Podrá visualizarlo una vez guardado...",
            icon: "warning",
        }, function () {
            $.ajax({
                data: formData,
                url: `${http}${servidor}/${appname}/api/${url_api}.php`,
                type: "POST",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("#formSubirInterpretacion:submit").prop('disabled', true)
                    alertMensaje('info', 'Cargando datos de interpretación', 'Espere un momento mientras el sistema registra todos los datos');
                },
                success: function (data) {
                    data = jQuery.parseJSON(data);
                    if (mensajeAjax(data)) {
                        alertMensaje('success', '¡Interpretación guardada!', 'Consulte o confirme el reporte despues de guardar');
                        estadoFormulario(2)
                        obtenerServicios(areaActiva, dataSelect.array['turno'])
                    }
                },
                complete: function () {
                    $("#formSubirInterpretacion:submit").prop('disabled', false)
                }
            });
        }, 1);


    } else {
        alertMensaje('info', 'EL resultado ya ha sido guardado', 'No puede cargar mas resultados a este paciente');
    }
    event.preventDefault();
});



$('#btn-confirmar-reporte').click(function (event) {
    // alert(areaActiva)
    event.preventDefault();
    /*DATOS Y VALIDACION DEL REGISTRO*/
    if (confirmado != 1 || session.permisos['Actualizar reportes'] == 1) {

        if (areaActiva == 5) {
            if (validarCuestionarioEspiro()) {
                return false;
            }
        }


        alertMensajeConfirm({
            title: "¿Está seguro de confirmar este reporte?",
            text: "¡No podrá actualizar los datos de reporte!",
            icon: "warning",
        }, function () {
            $.ajax({
                data: {
                    id_area: areaActiva,
                    api: api_interpretacion,
                    id_turno: dataSelect.array['turno'],
                    confirmado: 1
                },
                url: `${http}${servidor}/${appname}/api/${url_api}.php`,
                type: "POST",
                beforeSend: function () {
                    $("#formSubirInterpretacion:submit").prop('disabled', true)
                    alertMensaje('info', 'Confirmando reporte', 'Espere un momento mientras se genera el reporte en el sistema');
                },
                success: function (data) {
                    data = jQuery.parseJSON(data);
                    if (mensajeAjax(data)) {
                        alertMensaje('success', '¡Interpretación confirmada!', 'El formulario ha sido cerrado');
                        $('#modalSubirInterpretacion').modal('hide')
                        obtenerServicios(areaActiva, dataSelect.array['turno'])
                        estadoFormulario(1)
                    }
                },
                complete: function () {
                    $("#formSubirInterpretacion:submit").prop('disabled', false)
                }
            });
        }, 1)
    } else {
        alertMensaje('info', 'EL resultado ya ha sido guardado', 'No puede cargar mas resultados a este paciente');
    }
    event.preventDefault()
})

//Formulario Para Los Resultados de Espirometria
$("#btn-subir-resultados-espiro").click(async function (event) {
    event.preventDefault();

    Swal.fire({
        title: '¿¡Está seguro de subir este reporte de EASYONE!?',
        text: "¡Asegurece que sea el reporte correcto! : )",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',  
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, subir reporte',
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
    
            ajaxAwaitFormData({
                id_turno: dataSelect.array['turno'],
                api: 3
            }, 'espirometria_api', 'subirResultadosEspiro', { callbackAfter: true }, false, function () {
                alertToast('El reporte ya ha sido guardado', 'success', 4000);

                obtenerServicios(areaActiva, dataSelect.array['turno'])
            })

            $('#ModalSubirResultadosEspiro').modal('hide');

            event.preventDefault();
        }
    })
})




