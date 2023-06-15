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
        beforeSend: function () { loader("In") },
        complete: function () {
            loader("Out", 'bottom')

            //Para ocultar segunda columna
            reloadSelectTable()
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
        { targets: 1, className: 'all', title: 'Paciente' },
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
        { targets: 1, className: 'all', title: 'Paciente' },
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
    dataFill['fecha_inicial'] = fecha_inicial.val()
    dataFill['fecha_final'] = fecha_final.val();
    dataFill['cliente_id'] = cliente.val()

    tFillPaciCredito.ajax.reload();

    // ajaxAwaitFormData({ api: 4 }, 'admon_grupos_api', 'formFiltroListaCredito', { callbackAfter: true }, false, () => {

    // })
})


function insertarDatosEnTabla(datosArray, table) {
    // Insertar cada conjunto de datos en la tabla
    table.rows.add(datosArray).draw();
}

function removerFilasSeleccionadas(table) {
    // Obtener las filas seleccionadas
    let filasSeleccionadas = table.rows('.selected').indexes();

    // Remover las filas seleccionadas de la tabla
    table.rows(filasSeleccionadas).remove().draw();
}