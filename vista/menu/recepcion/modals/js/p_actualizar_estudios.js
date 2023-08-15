// Obtener datos del paciente seleccionado
const modalCambiarEstudios = document.getElementById('modalCambiarEstudios')
modalCambiarEstudios.addEventListener('show.bs.modal', event => {

    $('#title-paciente_actualizar_estudios').html(array_selected['NOMBRE_COMPLETO'])

    setTimeout(() => {
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
    }, 200);

})









async function getDataEstudiosFirst() {
    // alertMsj({
    //     title: 'Obteniendo datos reales...',
    //     text: 'Espera un momento mientras recuperamos y visualizamos todo correctamente.',
    //     footer: 'Es probable que tarde : )',
    //     showCancelButton: false,
    //     showConfirmButton: false,
    //     allowOutsideClick: true,
    // })

    alertToast('Obteniendo datos del servidor...', 'info', 4000)

    //Pruebas
    rellenarSelect("#select-edit-lab", "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
        id_area: 6,
        cliente_id: array_selected['CLIENTE_ID']
    });
    rellenarSelect("#select-edit-labbio", "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
        id_area: 12,
        cliente_id: array_selected['CLIENTE_ID']
    });
    rellenarSelect('#select-edit-us', "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
        id_area: 11,
        cliente_id: array_selected['CLIENTE_ID']
    });
    rellenarSelect('#select-edit-rx', "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
        id_area: 8,
        cliente_id: array_selected['CLIENTE_ID']
    });
    rellenarSelect('#select-edit-otros', "servicios_api", 2, 'ID_SERVICIO', 'ABREVIATURA.DESCRIPCION', {
        id_area: 0,
        cliente_id: array_selected['CLIENTE_ID']
    });

    await setTables();

    $('#modalCambiarEstudios').modal('show');
    // swal.close()
}

async function setTables() {
    return new Promise(async function (resolve, reject) {
        dataEstudiosActuales = { api: 6, id_turno: array_selected['ID_TURNO'] }
        tablaEstudiosActuales.ajax.reload();

        dataEstudiosEliminado = { api: 16, id_turno: array_selected['ID_TURNO'] }
        tablaEstudiosEliminados.ajax.reload();

        // await tablasEstudios('tablaEstudiosActuales', 'Actuales', , 'recepcion_api')


        // await tablasEstudios('tablaEstudiosEliminados', 'Eliminados', { api: 16, id_turno: array_selected['ID_TURNO'] }, 'turnos_api')
        resolve(1)
    })
}

dataEstudiosActuales = { api: 0 };

tablaEstudiosActuales = $(`#tablaEstudiosActuales`).DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    scrollY: autoHeightDiv(0, 374),
    scrollCollapse: true,
    lengthChange: false,
    info: false,
    paging: false,
    ajax: {
        dataType: 'json',
        data: function (d) { return $.extend(d, dataEstudiosActuales); },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/recepcion_api.php`,
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        // { data: 'AREA' },
        { data: 'GRUPO' },
        {
            data: 'GRUPO_ID', render: function (data) {
                return `
                    <div class="row">
                        <div class="col-4" style="max-width: max-content; padding: 0px; padding-left: 3px; padding-right: 3px;">
                            <i class="bi bi-trash btn-eliminar-estudio" data-bd-id="${data}" style="cursor: pointer; font-size:18px;"></i>
                        </div>          
                    </div>
                    `;
            }
        },
    ],
    columnDefs: [{ width: "5px", targets: 1, visible: validarPermiso('RepEstElim') ? true : false },],
})

inputBusquedaTable('tablaEstudiosActuales', tablaEstudiosActuales, [
    {
        msj: 'Los cambios de estudios de estudio al paciente son instantaneos',
        place: 'top',
    }
], {}, 'col-12')







dataEstudiosEliminado = { api: 0 };

if (!validarPermiso('RepTabEstElim')) {
    const contenedorPrincipal = $('#contenedor-tablas-estudios');
    $(`#contenido-estudios-eliminados`).remove();
    contenedorPrincipal.find('.col-4').removeClass('col-4').addClass('col-6');
}
try {
    tablaEstudiosEliminados = $(`#tablaEstudiosEliminados`).DataTable({
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
        scrollY: autoHeightDiv(0, 374),
        scrollCollapse: true,
        lengthChange: false,
        info: false,
        paging: false,
        ajax: {
            dataType: 'json',
            data: function (d) { return $.extend(d, dataEstudiosEliminado); },
            method: 'POST',
            url: `${http}${servidor}/${appname}/api/turnos_api.php`,
            error: function (jqXHR, textStatus, errorThrown) {
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'response.data'
        },
        createdRow: function (row) {
            $(row).addClass('bg-danger text-white');
        },
        columns: [
            // { data: 'AREA' },
            { data: 'ESTUDIO' },
            {
                data: 'ID_ESTUDIO', render: function (data) {
                    return `
                    <div class="row">
                        <div class="col-4" style="max-width: max-content; padding: 0px; padding-left: 3px; padding-right: 3px;">
                            <i class="bi bi-box-arrow-in-left btn-agregar-estudio" data-bd-id="${data}" style="cursor: pointer; font-size:18px;"></i>
                        </div>          
                    </div>
                    `;
                }
            },
        ],
        columnDefs: [{ width: "5px", targets: 1 },],
    })

    inputBusquedaTable('tablaEstudiosEliminados', tablaEstudiosEliminados, [
        {
            msj: 'Los cambios de estudios de estudio al paciente son instantaneos',
            place: 'top',
        }
    ], {}, 'col-12')
} catch (error) {

}



function statusEstudiosPaciente(id, api = 17, tipo = 'eliminar', estudio = 'no seleccionado') {
    alertMensajeConfirm({
        title: `¿Está seguro de ${tipo} el estudio ${estudio}?`,
        text: `Los cambios serán instantaneos para la vista del estudio.`,
    }, async function () {
        let data = await ajaxAwait({
            api: api,
            id_turno: array_selected['ID_TURNO'],
            servicio_id: id
        }, 'turnos_api')

        if (data) {
            switch (tipo) {
                case 'eliminar':
                    alertToast('¡Estudio eliminado!', 'info');
                    break;
                case 'agregar':
                    alertToast('¡Estudio agregado!', 'info');
                    break;
            }
            tablaEstudiosActuales.ajax.reload();
            tablaEstudiosEliminados.ajax.reload();
        }
    }, 1)
}


select2("#select-edit-lab", "modalCambiarEstudios", 'Seleccione un estudio', '308px');
select2("#select-edit-labbio", "modalCambiarEstudios", 'Seleccione un estudio', '308px');
select2("#select-edit-rx", "modalCambiarEstudios", 'Seleccione un estudio', '308px');
select2("#select-edit-us", "modalCambiarEstudios", 'Seleccione un estudio', '308px');
select2("#select-edit-otros", "modalCambiarEstudios", 'Seleccione un estudio', '308px');