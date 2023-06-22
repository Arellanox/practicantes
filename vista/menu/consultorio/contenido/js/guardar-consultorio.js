//datos globales
var text
var id
var texto = ''
var title = ''



//Regresar a perfil de paciente
$('#btn-regresar-vista').click(function () {
    alertMensajeConfirm({
        title: "¿Está seguro de regresar?",
        text: "¡Asegurese de guardar los cambios!",
        icon: "warning",
    }, function () {
        obtenerContenidoAntecedentes(pacienteActivo.array)
    }, 1)
})

//alerta en general, sirve para todos los botons y btn se llama al switch y guardar consultorio
function alertaConsultorio(btn) {
    alertMensajeConfirm({
        title: title,
        text: texto,
        icon: 'warning',
        showCancelButton: true,
    }, function () {
        guardarDatosConsultorio(btn)
    }, 1)
}

//llamada de cada boton independientemente, se agrega un var globla para tener mensajes personalisados
$(document).on('click', '#btn-guardar-nota-consulta', function (event) {
    event.preventDefault()
    title = '¿Deseas guardarlo?';
    texto = 'Se reemplazará por el valor anterior';
    alertaConsultorio('nota_consulta', title, texto)
})
$(document).on('click', '#btn-agregar-exploracion-clinina', function (event) {
    event.preventDefault()
    title = '¿Deseas guardarlo?';
    texto = 'No podrá actualizarlo'
    alertaConsultorio('exploracion_fisica', title, texto)
})
$(document).on('click', '#btn-guardar-Diagnostico', function (event) {
    event.preventDefault()
    title = '¿Deseas guardarlo?';
    texto = 'Se reemplazará por el valor anterior';
    alertaConsultorio('diagostico', title, texto)
})
$(document).on('click', '#btn-agregar-Diagnostico', function (event) {
    event.preventDefault()
    title = '¿Deseas guardarlo?';
    texto = 'No podra actualizar el diagnostico'
    alertaConsultorio('diagostico_agregar', title, texto)
})
$(document).on('click', '#btn-agregar-estudio', function (event) {
    event.preventDefault();
    title = '¿Deseas guardarlo?';
    texto = 'No podrá actualizarlo'
    alertaConsultorio('estudio', title, texto)
})
$(document).on('click', '#btn-guardar-Receta', function (event) {
    event.preventDefault()
    title = '¿Deseas guardarlo?';
    texto = 'No podrá actualizarlo'
    alertaConsultorio('receta', title, texto)
})
$(document).on('click', '#btn-guardar-plan-tratamiento', function (event) {
    event.preventDefault()
    title = '¿Deseas guardarlo?';
    texto = 'Se reemplazará por el valor anterior'
    alertaConsultorio('plan_tratamiento', title, texto)
})

//Boton para terminar consulta
$(document).on('click', '#btn-consulta-terminar', function (event) {
    event.preventDefault()
    title = '¿Deseas concluir la consulta médica?';
    texto = 'Confirmarás y enviarás el resultado y no podrás volver a modificarlo.'
    alertaConsultorio('terminar_consulta', title, texto)
})

//Insertar datos en consultorio
function guardarDatosConsultorio(btn) {
    switch (btn) {

        //agregar valor en el campo nota consulta
        case 'nota_consulta':
            let dataJson_nota = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                notas_consulta: $('#nota-consulta-campo-consulta').val(),
            }
            ajaxAwait(dataJson_nota, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertToast('Nota guardada!', 'success', 4000)

            })
            break;

        //agregar valor en el select de exploracion fisica    
        case 'exploracion_fisica':
            let dataJson_fisica = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                exploracion_tipo_id: $("#select-exploracion-clinica").val(),
                exploracion: $("#text-exploracion-clinica").val()
            }
            ajaxAwait(dataJson_fisica, 'exploracion_clinica_api', { callbackAfter: true }, false, function (data) {
                let titulo = $('#select-exploracion-clinica option:selected').text();
                alertToast('Exploración cargada!', 'success', 4000)
                agregarNotaConsulta(titulo, null, $("#text-exploracion-clinica").val(), '#notas-historial-consultorio', data.response.data, 'eliminarExploracion')
                $("#text-exploracion-clinica").val('')
            })
            break;

        //agregar valores en los campos de diagnostico    
        case 'diagostico':
            dataJson_diagnostico = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                diagnostico: $("#diagnostico-campo-consulta-1").val()
            }
            ajaxAwait(dataJson_diagnostico, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertToast('Diagnostico guardado!', 'success', 4000)
            })
            break;

        //Agrega diagnosticos secundarios    
        case 'diagostico_agregar':
            dataJson_diagnostico_agregar = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                diagnostico2: $('#diagnostico-campo-consulta-2').val()
            }
            ajaxAwait(dataJson_diagnostico_agregar, 'consultorio2_api', { callbackAfter: true }, false, function (data) {

                alertToast('Diagnostico agregado!', 'success', 4000)
                $('#diagnostico-campo-consulta-2').val('')

                TablaListaDiagnosticos.ajax.reload();

            })
            break;

        //agregar valor en el select en solicitud de estudios    
        case 'estudio':
            dataJason_estudio = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                servicio_id: id
            }

            ajaxAwait(dataJason_estudio, 'consultorio_2_solicitudes_api', { callbackAfter: true }, false, function (data) {
                alertToast('Estudio cargado!', 'success', 4000)
                TablaListaEstudios.ajax.reload();
            })
            break;

        //agregar valores en receta
        case 'receta':
            let dataJson_recetas = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                nombre_generico: $("#nombre_generico").val(),
                nombre_comercial: $("#nombre_comercial").val(),
                forma_farmaceutica: $("#forma_farmaceuticaval").val(),
                dosis: $("#dosis").val(),
                presentacion: $("#presentacion").val(),
                frecuencia: $("#frecuencia").val(),
                via_de_administracion: $("#via_de_administracion").val(),
                duracion_de_tratamiento: $("#duracion_de_tratamiento").val(),
                indicaciones_de_uso: $("#indicaciones_de_uso").val()
            }
            ajaxAwait(dataJson_recetas, 'consultorio_recetas_api', { callbackAfter: true }, false, function (data) {
                alertToast('Receta guardada!', 'success', 4000)
                tablaListaRecetas.ajax.reload();
            })
            //Limpiar los datos del formulario
            $("#nombre_generico").val(""),
                $("#nombre_comercial").val(""),
                $("#forma_farmaceuticaval").val(""),
                $("#dosis").val(""),
                $("#presentacion").val(""),
                $("#frecuencia").val(""),
                $("#via_de_administracion").val(""),
                $("#duracion_de_tratamiento").val(""),
                $("#indicaciones_de_uso").val("")
            break;

        //agregar valor en plan de tratamiento    
        case 'plan_tratamiento':
            dataJson_tratatiento = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                plan_tratamiento: $("#plan-tratamiento-campo-consulta").val()
            }
            ajaxAwait(dataJson_tratatiento, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertToast('Dato guardado!', 'success', 4000)
            })
            break;

        //terminar consulta, pasar del valor 0 al 1    
        case 'terminar_consulta':
            ajaxAwait({ api: 1, turno_id: pacienteActivo.array['ID_TURNO'], consulta_terminada: 1 }, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertToast('Consulta Finalizada!', 'success', 4000)

                obtenerContenidoAntecedentes(pacienteActivo.array)
            })
            break;

        default:
            alertToast('No selecciono ninguno de los campos', 'info', 1500)
            break;
    }
}

//Tabla de recetas
tablaListaRecetas = $("#tablaListaRecetas").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '38vh',
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: { api: 2, turno_id: pacienteActivo.array['ID_TURNO'] },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/consultorio_recetas_api.php`,
        beforeSend: function () {
        },
        complete: function () {
            tablaListaRecetas.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' },
        { data: 'NOMBRE_GENERICO' },
        { data: 'NOMBRE_COMERCIAL' },
        { data: 'FORMA_FARMACEUTICA' },
        { data: 'DOSIS' },
        { data: 'PRESENTACION' },
        { data: 'FRECUENCIA' },
        { data: 'VIA_DE_ADMINISTRACION' },
        { data: 'DURACION_DEL_TRATAMIENTO' },
        { data: 'INDICACIONES_PARA_EL_USO' },
        {
            data: 'ID_RECETA', render: function (data) {


                return `<i class="bi bi-trash eliminar-receta" data-id = "${data}" style = "cursor: pointer"
            onclick="desactivarTablaReceta.call(this)"></i>`;

            }
        }

    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Nombre generico', className: 'all' },
        { target: 2, title: 'Nombre comercial', className: 'none' },
        { target: 3, title: 'Forma Farmacéutica', className: 'none' },
        { target: 4, title: 'Dosis', className: 'none' },
        { target: 5, title: 'Presentación', className: 'none' },
        { target: 6, title: 'Frecuencia', className: 'none' },
        { target: 7, title: 'Vía de Administración', className: 'none' },
        { target: 8, title: 'Duración de tratamiento', className: 'none' },
        { target: 9, title: 'Indicaciones para el uso', className: 'none' },
        { target: 10, title: '<i class="bi bi-trash"></i>', className: 'all' }
    ]
})

inputBusquedaTable('tablaListaRecetas', tablaListaRecetas, [], [], 'col-12')

//Desactivar datos en la tabla de recetas
function desactivarTablaReceta() {

    var id_receta = $(this).data("id");

    alertMensajeConfirm({
        title: '¿Está seguro que desea desactivar el registro?',
        text: 'No podrá modificarlo despues',
        icon: 'warning',
    }, function () {

        dataJson_eliminar = {
            api: 4,
            id_receta: id_receta
        }

        ajaxAwait(dataJson_eliminar, 'consultorio_recetas_api', { callbackAfter: true }, false, function (data) {
            alertToast('Receta eliminada!', 'success', 4000)

            tablaListaRecetas.ajax.reload();
        })
    }, 1)
}


//Rellenador de estudios
select2('#buscar-estudios', null, 'Seleccione un estudio')
rellenarSelect('#buscar-estudios', 'servicios_api', 17, 'ID_SERVICIO', 'DESCRIPCION.ABREVIATURA')

//Seleccion de un estudio
$('#btn-agregar-estudio').on('click', function () {
    text = $("#buscar-estudios option:selected").text();
    id = $("#buscar-estudios").val();
})


//Tabla de solicitud de estudios
TablaListaEstudios = $("#TablaListaEstudios").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '38vh',
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: { api: 2, turno_id: pacienteActivo.array['ID_TURNO'] },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/consultorio_2_solicitudes_api.php`,
        beforeSend: function () {
        },
        complete: function () {
            TablaListaEstudios.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' },
        { data: 'DESCRIPCION' },
        { data: 'ABREVIATURA' },
        {
            data: 'SERVICIO_ID', render: function (data) {


                return `<i class="bi bi-trash eliminar-estudio" data-id = "${data}" style = "cursor: pointer"
            onclick="desactivarTablaEstudio.call(this)"></i>`;

            }
        }

    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Descripcion', className: 'all' },
        { target: 2, title: 'Abreviatura', className: 'all' }
    ]
})
inputBusquedaTable('TablaListaEstudios', TablaListaEstudios, [], [], 'col-18')

//Desactivar registro de solicitud de estudios
function desactivarTablaEstudio() {
    var id_estudios = $(this).data("id");

    alertMensajeConfirm({
        title: '¿Está seguro que desea desactivar el registro?',
        text: 'No podrá modificarlo despues',
        icon: 'warning',
    }, function () {

        dataJson_eliminarEstudios = {
            api: 4,
            servicio_id: id_estudios,
            turno_id: pacienteActivo.array['ID_TURNO']
        }

        ajaxAwait(dataJson_eliminarEstudios, 'consultorio_2_solicitudes_api', { callbackAfter: true }, false, function (data) {
            alertToast('Estudio eliminado!', 'success', 4000)

            TablaListaEstudios.ajax.reload();
        })
    }, 1)
}

//Tabla de Diagnosticos secundarios
TablaListaDiagnosticos = $("#TablaListaDiagnosticos").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: '38vh',
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: { api: 6, turno_id: pacienteActivo.array['ID_TURNO'] },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/consultorio2_api.php`,
        beforeSend: function () {
        },
        complete: function () {
            TablaListaDiagnosticos.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' },
        { data: 'DESCRIPCION' },
        {
            data: 'FECHA_CREACION', render: function (data) {


                return `<i class="bi bi-trash eliminar-receta" data-id = "${data}" style = "cursor: pointer"
                onclick="desactivarTablaDiagnosticos.call(this)"></i>`;

            }
        }

    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all', width: '5px' },
        { target: 1, title: 'Diagnóstico', className: 'all' },
        { target: 2, title: '<i class="bi bi-trash"></i>', className: 'all', width: '5px' }
    ]
})

inputBusquedaTable('TablaListaDiagnosticos', TablaListaDiagnosticos, [], [], 'col-12')

//Desactiva el campo seleccionado en la tabla de diagnosticos
function desactivarTablaDiagnosticos() {
    var fecha_diagnostico = $(this).data("id");

    alertMensajeConfirm({
        title: '¿Está seguro que desea desactivar el registro?',
        text: 'No podrá modificarlo despues',
        icon: 'warning',
    }, function () {

        dataJson_eliminarDiagnosticos = {
            api: 7,
            fecha_creacion: fecha_diagnostico
        }

        ajaxAwait(dataJson_eliminarDiagnosticos, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
            alertToast('Diagnostico eliminado!', 'success', 4000)

            TablaListaDiagnosticos.ajax.reload();
        })
    }, 1)
}