
var estatus = 0, modificado = 0;
let dataJson = {
    api: 16,
    id_grupo: 1,
}
tablaLLenarGrupo = $('#TablaLLenarGrupo').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    rowReorder: {
        selector: 'td.dtr-control',
    },
    scrollY: '60vh', //347px  scrollCollapse: true,
    scrollCollapse: true,
    // lengthMenu: [[15, 20, 25, 30, 35, 40, 45, 50, -1], [15, 20, 25, 30, 35, 40, 45, 50, "All"]],
    paging: false,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, dataJson);
        },
        method: 'POST',
        url: `${http}${servidor}/${appname}/api/servicios_api.php`,

        before: function () {
            estatus = 0
        },
        complete: function () {
            estatus = 1
        },
        dataSrc: function (json) {
            let counter = 1;
            json.response.data.forEach(item => {
                item.ORDEN = counter++;
            });
            return json.response.data;
        }
    },
    columns: [
        { data: 'ORDEN', },
        { data: 'DESCRIPCION' },
        {
            data: 'ID_SERVICIO', render: function (data) {
                let html = `<div class="row">
                                <div class="col-12" style="max-width: max-content; padding: 0px;">
                                <i class="bi bi-trash detele-estudio" style="cursor: pointer; font-size:18px;padding: 2px 5px;"></i>
                            </div></div>`

                return html;
            }
        },
    ],
    columnDefs: [
        { width: "10%", targets: 0, title: 'Orden' },
        { width: "80%", targets: 1, title: 'Servicio' },
        { width: "10%", targets: 2, title: '<i class="bi bi-trash"></i>' },
    ],

});

inputBusquedaTable('TablaLLenarGrupo', tablaLLenarGrupo, [], [], 'col-12')

selectTable('#TablaLLenarGrupo', tablaLLenarGrupo, {
    ClickClass: [
        {
            class: "detele-estudio",
            callback: function (data, elementClicked, tr) {
                // let id = data['ID_SERVICIO']
                // console.log(id)
                // Proceso para eliminar el estudio
                // Creo que puedes eliminar el TR asi:
                // table.row(tr).remove(); <-- Investiga, agregué el TR apenas, si necesitas algo avisame -- Ger

                // tablaLLenarGrupo.row(tr).remove();
                // tablaLLenarGrupo.draw();
                modificado = 1
                var filaEliminar = tablaLLenarGrupo.row(tr);

                // Eliminar la fila seleccionada y redibujar la tabla
                filaEliminar.remove().draw();

                // Recorrer las filas restantes y actualizar el valor de ORDEN
                tablaLLenarGrupo.rows().every(function (rowIdx, tableLoop, rowLoop) {
                    var filaActual = this;
                    var nuevoOrden = rowLoop + 1;

                    // Actualizar el valor de la columna ORDEN
                    filaActual.cell({ row: rowIdx, column: 0 }).data(nuevoOrden);

                    // Redibujar la tabla para reflejar los cambios
                    tablaLLenarGrupo.draw();
                });
            }
        }
    ], OnlyData: true
})

tablaLLenarGrupo.on('row-reorder', function (e, diff, edit) {
    console.log(diff)
    tablaLLenarGrupo.rows().nodes().to$().removeClass('selected'); // Elimina la clase de todas las filas1
    modificado = 1
    for (let i = 0; i < diff.length; i++) {
        let newData = tablaLLenarGrupo.row(diff[i].node).data();
        newData.ORDEN = diff[i].newPosition + 1; // +1 para que comience desde 1
        tablaLLenarGrupo.row(diff[i].node).data(newData);

        // Agrega la clase solo a la fila en movimiento
        $(diff[i].node).closest('tr').addClass('selected');
    }

});



async function firstDataModal() {
    console.log(estatus)
    if (estatus == 0) {

        setTimeout(function () {
            firstDataModal()
        }, 500)
    } else if (estatus == 1) {
        // swal.close()V
        dataJson['id_grupo'] = array_selected['ID_SERVICIO']
        tablaLLenarGrupo.clear().draw()
        tablaLLenarGrupo.ajax.reload();

        await rellenarSelect("#estudios", "servicios_api", 2, "ID_SERVICIO", "DESCRIPCION", { id_area: 6, tipgrupo: 0 })
        select2('#estudios', 'modalRellenarGrupos')

        $('#title-grupo-estudios').html(`Rellenar grupo: (<b>${array_selected['DESCRIPCION']}</b>)`);

        modificado = 0
        $('#modalRellenarGrupos').modal('show');

        setTimeout(() => {
            $.fn.dataTable
                .tables({
                    visible: true,
                    api: true
                })
                .columns.adjust();
        }, 250);
    }
}

$(document).on('click', '#btn-guardar-grupo', function () {

    alertMensajeConfirm({
        icon: 'info',
        title: '¿Estas seguro de realizar esta acción?',
        text: 'No podra revertir esta acción',
        showCancelButton: true
    }, function () {
        // Llamar a esta función para obtener los datos tratados
        let arrayTratado = getTratadosDataFromTable();
        console.log(arrayTratado);
        console.log(array_selected['ID_SERVICIO'])

        ajaxAwait({
            api: 4,
            id_grupo: array_selected['ID_SERVICIO'],
            servicios: arrayTratado
        }, 'laboratorio_servicios_api', { callbackAfter: true }, false, function (data) {
            alertToast('Cambios realizado correctamente..', 'success', 2000)
            tablaLLenarGrupo.ajax.reload();
            modificado = 0
        })
    }, 1)


})

// Recupera los datos tratados de la tabla
function getTratadosDataFromTable() {
    let tratadosData = [];

    tablaLLenarGrupo.rows().every(function () {
        let data = this.data();
        tratadosData.push({
            ID_SERVICIO: data.ID_SERVICIO,
            ORDEN: data.ORDEN,
            DESCRIPCION: data.DESCRIPCION
            // Agrega más propiedades si es necesario
        });
    });

    return tratadosData;
}


$(document).on('click', '#btn-agregar-estudios', function (e) {
    e.preventDefault();

    var miSelect = document.getElementById('estudios')
    var SelectedOption = miSelect.options[miSelect.selectedIndex]
    var value = SelectedOption.value;
    var htmlContent = SelectedOption.innerHTML;

    console.log(value, htmlContent)

    rowDataAdd(tablaLLenarGrupo, {
        ID_SERVICIO: value,
        DESCRIPCION: htmlContent
        // Agrega más propiedades si es necesario
    });

})


function rowDataAdd(tabla, newRowData = {}) {
    // Verificar si la descripción ya existe en alguna fila
    var descripcionExistente = tablaLLenarGrupo.rows().data().toArray().some(function (row) {
        return row.DESCRIPCION === newRowData.DESCRIPCION;
    });

    if (descripcionExistente) {
        modificado = 0
        alertToast('La descripción ya existe en la tabla.', 'error', 1500);
        return; // No agregar la fila si la descripción ya existe
    }
    modificado = 1
    // Obtener la última fila para obtener el valor de "Orden"
    var ultimaFila = tablaLLenarGrupo.row(':last');
    var ultimoOrden = ultimaFila.data().ORDEN;

    // Calcular el siguiente número en la secuencia
    var nuevoOrden = ultimoOrden + 1;
    newRowData.ORDEN = nuevoOrden

    // Agregar una nueva fila con solo los valores de ID y Nombre visibles en la tabla
    tabla.row.add(newRowData).draw();

    // Obtener el índice de la última fila agregada
    var ultimaFilaIdx = tabla.rows().count() - 1;

    // Establecer los otros datos en la fila (puedes utilizar 'cell().data()' para cada celda)
    tabla.cell(ultimaFilaIdx, 2).data(datos.join(', ')); // Unir los valores de otrosDatos con coma y espacio

    // Redibujar la tabla para reflejar los cambios
    tabla.draw();

    // var newRowData = {
    //     ID_SERVICIO: id,
    //     ORDEN: nuevoOrden,
    //     DESCRIPCION: descripcion,
    // };
}

$(document).on('click', '#btn-cerrar-grupo', function (e) {
    e.preventDefault();

    if (modificado == 0) {
        $('#modalRellenarGrupos').modal('hide');
    } else if (modificado == 1) {
        alertMensajeConfirm({
            icon: 'info',
            title: '¿Estas seguro de cerrar esta ventana?',
            text: 'Los cambios realizados no se guardaran',
            showCancelButton: true
        }, function () {
            $('#modalRellenarGrupos').modal('hide');
        }, 1)
    }



})