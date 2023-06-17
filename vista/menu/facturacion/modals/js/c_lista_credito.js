// Obtener la fecha del primer día del mes anterior
var fechaInicial = new Date();
fechaInicial.setMonth(fechaInicial.getMonth() - 1);
fechaInicial.setDate(1);

// Obtener la fecha del último día del mes anterior
var fechaFinal = new Date();
fechaFinal.setDate(0);

// Formatear las fechas en el formato deseado (por ejemplo, yyyy-mm-dd)
var fechaInicialFormatted = fechaInicial.toISOString().split('T')[0];
var fechaFinalFormatted = fechaFinal.toISOString().split('T')[0];

// Establecer los valores de los campos de fecha
let fecha_inicial = $('#fecha_inicial_fill')
let fecha_final = $('#fecha_final_fill')
let cliente = $('#cliente_fill');

fecha_inicial.val(fechaInicialFormatted);
fecha_final.val(fechaFinalFormatted);

// rellenarSelect('#cliente', 'clientes_api',)
rellenarSelect('#cliente_fill', 'clientes_api', 2, 'ID_CLIENTE', 'NOMBRE_COMERCIAL')


const modalFiltroPacientesFacturacion = document.getElementById('modalFiltroPacientesFacturacion')
modalFiltroPacientesFacturacion.addEventListener('show.bs.modal', event => {
    setTimeout(() => {
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();

    }, 200);
})



dataFill = { api: 4, fecha_inicial: null, fecha_final: null, cliente_id: null }
tFillPaciCredito = $('#TablaFiltradaCredito').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    lengthChange: false,
    info: true,
    paging: false,
    scrollY: "43vh",
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, dataFill);
        },
        method: 'POST',
        url: '../../../api/admon_grupos_api.php',
        beforeSend: function () { loader("In"); tFillPaciCredito.clear().draw(); },
        complete: function () {
            // loader("Out", 'bottom')


            //Para ocultar segunda columna
            // reloadSelectTable()
        },
        dataSrc: 'response.data'
    },
    columns: [
        {
            data: 'ID_TURNO', render: function (data) {
                return '';
            }
        },
        { data: 'PACIENTE' },
        { data: 'NUM_ESTADO_CUENTA' },
        { data: 'PREFOLIO' },
        // { data: 'PROCEDENCIA' },
        { data: 'FECHA_RECEPCION' }
        // {defaultContent: 'En progreso...'}
    ],

    columnDefs: [
        { width: "0px", targets: 0, className: 'all', title: '#' },
        { targets: 1, className: 'all', title: 'Paciente', width: '100%' },
        { targets: 2, className: 'none', title: 'Cuenta' },
        { targets: 3, className: 'none', title: 'Prefolio' },
        { targets: 4, className: 'none', title: 'Recepción' }
    ],

})

inputBusquedaTable('TablaFiltradaCredito', tFillPaciCredito, [], [], 'col-12')

let SelectPaciFiltrada = [];
selectTable('#TablaFiltradaCredito', tFillPaciCredito, { unSelect: true, multipleSelect: true }, (select, dataRow, callback) => {
    SelectPaciFiltrada = dataRow
})

tListPaciGrupo = $('#TablaPacientesNewGrupo').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    lengthChange: false,
    info: true,
    paging: false,
    scrollY: "43vh",
    scrollCollapse: true,
    columns: [
        {
            data: 'ID_TURNO', render: function (data) {
                return '';
            }
        },
        { data: 'PACIENTE' },
        { data: 'NUM_ESTADO_CUENTA' },
        { data: 'PREFOLIO' },
        // { data: 'PROCEDENCIA' },
        { data: 'FECHA_RECEPCION' }
        // {defaultContent: 'En progreso...'}
    ],

    columnDefs: [
        { width: "0px", targets: 0, className: 'all', title: '#' },
        { targets: 1, className: 'all', title: 'Paciente', width: '100%' },
        { targets: 2, className: 'none', title: 'Cuenta' },
        { targets: 3, className: 'none', title: 'Prefolio' },
        { targets: 4, className: 'none', title: 'Recepción' }
    ],
})

inputBusquedaTable('TablaPacientesNewGrupo', tListPaciGrupo, [], [], 'col-12')

let SelectPaciNewGrupo
selectTable('#TablaPacientesNewGrupo', tListPaciGrupo, { unSelect: true, multipleSelect: true }, (select, dataRow, callback) => {
    SelectPaciNewGrupo = dataRow
})


$(document).on('click', '#AgregarPacientesGrupo', function () {
    if (SelectPaciFiltrada.length) {
        removerFilasSeleccionadas(tFillPaciCredito)
        insertarDatosEnTabla(SelectPaciFiltrada, tListPaciGrupo)
        SelectPaciFiltrada = []
    } else {
        alertToast('No ha seleccionado ningún registro.', 'info', 4000)
    }
})

$(document).on('click', '#QuitarPacientesGrupo', function () {
    if (SelectPaciNewGrupo.length) {
        removerFilasSeleccionadas(tListPaciGrupo)
        insertarDatosEnTabla(SelectPaciNewGrupo, tFillPaciCredito)
        SelectPaciNewGrupo = []
    }
})



//Filtrar la primera tabla
$('#formFiltroListaCredito').submit(function (event) {
    event.preventDefault();



    cliente_id = cliente.val()
    let cliente_exist = false;

    if (tFillPaciCredito.rows().count() > 0)

        tFillPaciCredito.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (rowData.ID_CLIENTE !== cliente_id) {
                cliente_exist = true;
                return false; // Detiene el bucle si la ID no existe en un registro
            }
        });


    if (cliente_exist) {
        //El cliente no existe en la  tabla

        alertMensajeConfirm({
            title: '¿Está seguro de filtrar otro cliente?',
            text: '¡Todos los pacientes seleccionados se perderán!',
            icon: 'warning',
            confirmButtonText: 'Si, aceptar',
            cancelButtonText: 'Cancelar'
        }, () => {

            dataFill['fecha_inicial'] = fecha_inicial.val()
            dataFill['fecha_final'] = fecha_final.val();
            dataFill['cliente_id'] = cliente.val()
            tFillPaciCredito.ajax.reload();

            tListPaciGrupo.clear().draw();
        }, 1)


        console.log("La ID no está presente en todos los registros de la tabla2");
    } else {
        //El cliente existe en la tabla

        dataFill['fecha_inicial'] = fecha_inicial.val()
        dataFill['fecha_final'] = fecha_final.val();
        dataFill['cliente_id'] = cliente.val()

        tFillPaciCredito.ajax.reload();

        console.log("La ID está presente en todos los registros de la tabla2");
    }




    // ajaxAwaitFormData({ api: 4 }, 'admon_grupos_api', 'formFiltroListaCredito', { callbackAfter: true }, false, () => {

    // })
})


//Guardar grupo filtrado

$(document).on('click', '#btn-facturar-grupo', function (event) {
    event.preventDefault();

    let grupo = obtenerGrupoFiltrado(tListPaciGrupo)
    if (grupo.length == 0) {
        alertToast('No ha seleccionado ningún registro', 'info', 4000)
        return false
    }
    Swal.fire({
        title: '¿Desea crear el grupo con los pacientes seleccionados?',
        // text: 'Se creará el grupo con los pacientes seleccionados, ¡No podrás revertir los cambios',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        // inputAttributes: {
        //   autocomplete: false
        // },
        // input: 'password',
        html: '<form autocomplete="off" onsubmit="formpassword(); return false;"><input type="password" id="password-confirmar" class="form-control input-color" autocomplete="off" placeholder="Ingrese su contraseña para confirmar"></form>',
        // confirmButtonText: 'Sign in',
        focusConfirm: false,
        didOpen: () => {
            const passwordField = document.getElementById('password-confirmar');
            passwordField.setAttribute('autocomplete', 'new-password');
        },
        preConfirm: () => {
            const password = Swal.getPopup().querySelector('#password-confirmar').value;
            return fetch(`${http}${servidor}/${appname}/api/usuarios_api.php?api=9&password=${password}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed: ${error}`
                    )
                });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.status == 1) {

                console.log(grupo)

                ajaxAwait({
                    api: 1,
                    detalle_grupo: grupo,
                    descripcion: $('#descripcion-grupo-factura').val(),
                    cliente_id: cliente.val(),
                }, 'admon_grupos_api', { callbackAfter: true }, false, (data) => {
                    alertToast('¡Grupo Creado!', 'success', 4000);


                })

            } else {
                alertSelectTable('¡Contraseña incorrecta!', 'error')
            }
        }


    })




})


function obtenerGrupoFiltrado(dataTable) {
    var valoresIDTurno = [];

    // Obtener los datos del DataTable sin importar si está filtrado
    var datos = dataTable.rows({ search: "applied" }).data();

    // Iterar sobre los datos y obtener los valores de la columna "ID_TURNO"
    datos.each(function (row) {
        var idTurno = row.ID_TURNO; // Reemplaza "ID_TURNO" con el nombre de la columna correspondiente en tu DataTable
        valoresIDTurno.push(idTurno);
    });

    return valoresIDTurno;
}



function insertarDatosEnTabla(datosArray, table) {
    // Insertar cada conjunto de datos en la tabla
    // Obtener los datos existentes en la tabla de destino
    let existingData = table.rows().data().toArray();

    // Filtrar los nuevos datos para eliminar duplicados
    let uniqueData = datosArray.filter(function (newData) {
        return !existingData.some(function (existingRow) {
            return JSON.stringify(existingRow) === JSON.stringify(newData);
        });
    });

    // Agregar los datos únicos a la tabla de destino
    table.rows.add(uniqueData).draw();


    // Obtener los datos omitidos
    let omittedData = datosArray.filter(function (newData) {
        return existingData.some(function (existingRow) {
            return JSON.stringify(existingRow) === JSON.stringify(newData);
        });
    });

    // Mostrar una alerta con la información de los datos omitidos
    if (omittedData.length > 0) {
        // alert('Se omitieron ' + omittedData.length + ' registros duplicados.')
        alertToast('Se omitieron algunos pacientes repetidos', 'info', 4000);
        console.log('Datos omitidos:', omittedData);
    }
}

function removerFilasSeleccionadas(table) {
    // Obtener las filas seleccionadas
    let filasSeleccionadas = table.rows('.selected').indexes();

    // Remover las filas seleccionadas de la tabla
    table.rows(filasSeleccionadas).remove().draw();
}