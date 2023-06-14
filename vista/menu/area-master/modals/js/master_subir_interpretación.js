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


function recuperarDatos() {

    ajaxAwait({
        api: 2,
        id_turno: dataSelect.array['turno']
    }, 'espirometria_api', { callbackAfter: true, returnData: false }, false, function (data) {


        //$('#1pr1').prop('checked', true)
        let row = data.response.data;

        for (const key in row) {
            if (Object.hasOwnProperty.call(row, key)) {
                const element = row[key];

                respuestas = element.ID_R;
                comentario = element.COMENTARIO

                switch (true) {

                    // PARA MOSTRAR AQUELLOS QUE SON INPUTS DE TIPO RADIO
                    case respuestas == 1 || respuestas == '1' || respuestas == 2 || respuestas == '2':

                        $(`input[name="respuestas[${element.ID_P}][${element.ID_R}][valor]"]`).prop('checked', true)
                        
                        break;


                    // PARA TODOS AQUELLOS INPUTS DE TIPO CHECKBOX QUE NO TIENEN UN COMENTARIO ANEXADO
                    case respuestas != 1 && respuestas != '1' && respuestas != 2 && respuestas != '2' && comentario == null:

                        $(`input[name="respuestas[${element.ID_P}][${element.ID_R}][valor]"]`).prop('checked', true);

                        break;
                    

                    // // PARA TODOS AQUELLOS QUE SON INPUTS DE TIPO TEXT  QUE NO TIENEN RESPUESTA Y PARA AQUELLOS INPUTS DE TIPO CHECKBOX QUE CONTIENEN UN COMENTARIO
                    case comentario != null:

                        $(`input[name="respuestas[${element.ID_P}][${element.ID_R}][valor]"]`).prop('checked', true);
                        $(`input[id="p${element.ID_P}"]`).val(comentario);

                        //INSERTAMOS LA RESPUESTAS DE AQUELLAS PREGUNTAS QUE NO TIENEN UN ID DE RESPUESTA
                        $(`input[name="respuestas[${element.ID_P}][0][comentario]"]`).val(comentario);

                        break;

                }

                //MOSTRAMOS LOS COLLAPSE DE TODAS AQUELLAS PREGUNTAS QUE LO CONTIENEN
                let parent = $('div[class="form-check form-check-inline col-12 mb-2"]');
                let children = $(parent).children(`div[id="p${element.ID_P}r${element.ID_R}"]`);
                children.collapse('show');

                $(`textarea[name="respuestas[${element.ID_P}][${element.ID_R}][comentario]"]`).val(comentario)
                
              
                let childrenCondiciones = $(parent).children(`div[id="pregunta${element.ID_P}"]`);
                childrenCondiciones.collapse('hide');
            }


        }

    })
}







//AQUI VOY A CONFIGURAR EL ENVIO DEL FORMULARIO DE ESPIROMETRIA
//Formulario Para Subir Interpretacion
$(`#${formulario}`).submit(function (event) {
    // alert(areaActiva)
    event.preventDefault();

    /*DATOS Y VALIDACION DEL REGISTRO*/
    if (confirmado != 1 || session.permisos['Actualizar reportes'] == 1) {

        // if (!validarCuestionarioEspiro()) {
        //     return false;
        //  }

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
    event.preventDefault();
})