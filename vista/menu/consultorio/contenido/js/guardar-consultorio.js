function alertaConsultorio(btn) {

    alertMensajeConfirm({
        title: '¿Está seguro que relleno bien el o los campos?',
        text: 'No podrá modificarlo despues',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }, function () {
        guardarDatosConsultorio(btn)
    }, 1)
}


$(document).on('click', '#btn-guardar-nota-consulta', function (event) {
    event.preventDefault()
    alertaConsultorio('nota_consulta')
})
$(document).on('click', '#btn-agregar-exploracion-clinina', function (event) {
    event.preventDefault()
    alertaConsultorio('exploracion_fisica')
})
$(document).on('click', '#btn-guardar-Diagnostico', function (event) {
    event.preventDefault()
    alertaConsultorio('diagostico')
})
//aqui va solicitud de estudios


$(document).on('click', '#btn-guardar-Receta', function (event) {
    event.preventDefault()
    alertaConsultorio('receta')
})
$(document).on('click', '#btn-guardar-plan-tratamiento', function (event) {
    event.preventDefault()
    alertaConsultorio('plan_tratamiento')
})


//Insertar datos en consultorio
function guardarDatosConsultorio(btn) {

    switch (btn) {

        case 'nota_consulta':
            let dataJson_nota = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                notas_consulta: $('#nota-consulta-campo-consulta').val(),
            }
            ajaxAwait(dataJson_nota, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 1500)

            })
            break;

        case 'exploracion_fisica':
            let dataJson_fisica = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                exploracion_tipo_id: $("#select-exploracion-clinica").val(),
                exploracion: $("#text-exploracion-clinica").val()
            }
            ajaxAwait(dataJson_fisica, 'exploracion_clinica_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 1500)
            })
            break;

        case 'diagostico':
            dataJson_diagnostico = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                diagnostico: $("#diagnostico-campo-consulta-1").val(),
                diagnostico2: $("#diagnostico-campo-consulta-2").val()
            }
            ajaxAwait(dataJson_diagnostico, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 1500)
            })
            break;

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
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 1500)

                tablalistaRecetas.ajax.reload();
            })

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

        case 'plan_tratamiento':
            dataJson_tratatiento = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                plan_tratamiento: $("#plan-tratamiento-campo-consulta").val()
            }
            ajaxAwait(dataJson_tratatiento, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 1500)
            })
            break;

        default:
            alertToast()
            break;
    }
}

//Tabla de recetas
tablalistaRecetas = $("#tablaListaRecetas").DataTable({
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
            tablalistaRecetas.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        {data: 'COUNT'},
        {data: 'NOMBRE_GENERICO'},
        {data: 'NOMBRE_COMERCIAL'},
        {data: 'FORMA_FARMACEUTICA'},
        {data: 'DOSIS'},
        {data: 'PRESENTACION'},
        {data: 'FRECUENCIA'},
        {data: 'VIA_DE_ADMINISTRACION'},
        {data: 'DURACION_DEL_TRATAMIENTO'},
        {data: 'INDICACIONES_PARA_EL_USO'},
        {data: 'ID_RECETA', render: function(data){
            

            return `<i class="bi bi-trash eliminar-receta" data-id = "${data}" style = "cursor: pointer"
            onclick="desactivarTablaReceta.call(this)"></i>`;
            
        }}
        
    ],
    columnDefs: [
        {target: 0, title: '#', className: 'all'},
        {target: 1, title: 'Nombre generico', className: 'all' },
        {target: 2, title: 'Nombre comercial', className: 'none'},
        {target: 3, title: 'Forma Farmacéutica', className: 'none'},
        {target: 4, title: 'Dosis', className: 'none'},
        {target: 5, title: 'Presentación', className: 'none'},
        {target: 6, title: 'Frecuencia', className: 'none'},
        {target: 7, title: 'Vía de Administración', className: 'none'},
        {target: 8, title: 'Duración de tratamiento', className: 'none'},
        {target: 9, title: 'Indicaciones para el uso', className: 'none'},
        {target: 10, title: '<i class="bi bi-trash"></i>', className: 'all'}
    ]
})

inputBusquedaTable('tablaListaRecetas', tablaListaRecetas, [],[],'col-12')

function desactivarTablaReceta(){

    var id_receta = $(this).data("id");

    alertMensajeConfirm({
        title: '¿Está seguro que desea desactivar el registro?',
        text: 'No podrá modificarlo despues',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }, function(){

        dataJson_eliminar = {
            api: 4,
            id_receta: id_receta
        }

        ajaxAwait(dataJson_eliminar, 'consultorio_recetas_api', { callbackAfter: true }, false, function (data) {
            alertMensaje('success', 'Registro desactivado', 'Espere un momento...', null, null, 1500)

            tablalistaRecetas.ajax.reload();
        })
    }, 1)
}