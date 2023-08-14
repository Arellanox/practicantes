select2('#select-operador-referencia', 'modalReferencia')
rellenarSelect("#select-operador-referencia", "valores_referencia_api", 2, "ID_OPERADORES_LOGICOS", "DESCRIPCION");


// Variables que solo se usan una vez, no tocar
var DataReferencia = {
    api : 3
}   

// Tabla de valores de referencia
TablaValoresReferencia = $('#TablaValoresReferencia').DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
    lengthChange: false,
    info: true,
    paging: false,
    scrollY: '75vh',
    scrollCollapse: true,
    ajax: {
        dataType: 'json',
        data: function (d) {
            return $.extend(d, DataReferencia);
        },
        method: 'POST',
        url: '../../../api/valores_referencia_api.php',
        beforeSend: function () {
        },
        complete: function () {
            console.log(1)
            TablaValoresReferencia.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(2)
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' }  ,
        { data: 'SERVICIO'},
        { data: 'SEXO'},
        {data: 'EDAD_MINIMA', render:function(data){

            return ifnull(data) ? ifnull(data) : 'N/A';
        }},
        {data: 'EDAD_MAXIMA', render:function(data){

            return ifnull(data) ? ifnull(data) : 'N/A';
        }},
        {data: 'VALOR_MINIMO', render:function(data){

            return ifnull(data) ? ifnull(data) : 'N/A';
        }},
        {data: 'VALOR_MAXIMO', render:function(data){

            return ifnull(data) ? ifnull(data) : 'N/A';
        }},
        {
            data: 'PRESENTACION'
        },{
            data:'CODIGO', render:function(data){
                return ifnull(data) ? ifnull(data) : 'N/A';

            }
        },{
            data : 'VALOR_REFERENCIA', render:function(data){
                return ifnull(data) ? ifnull(data) : 'N/A';

            }
        }
        ],
    columnDefs: [
        { target: 0, title: '#', className: 'all'},
        { target: 1, title:'Servicio', className:'all'},
        { target: 2, title:'Dirigido', className: 'all'},
        { target: 3, title:'Edad Minima', className: 'all'},
        { target: 4, title:'Edad Maxima', className: 'all'},
        { target: 5, title:'Valor Minimo', className: 'all'},
        { target: 6, title:'Valor Maximo', className: 'all'},
        { target: 7, title:'Presentación', className: 'all'},
        { target: 8, title:'Operador Lógico', className: 'all'},
        { target: 9, title:'Referencia', className: 'all'}

        ]   
})

inputBusquedaTable("TablaValoresReferencia", TablaValoresReferencia, [], [], "col-12")

// Detecta si lo que esta escribiendo es negativo si es asi lo manda a la verga
$(document).ready(function () {
    $(document).on('keydown', '#edad-minima-referencia, #edad-maxima-referencia', function (event) {
        if (event.key === '-' || event.key === 'e') {
            event.preventDefault();
        }
    });
});

//Desactiva los imput de maximo y minimo de edad
$('#SinEdad').on('click', function (e) {
    var minimaReferencia = $('#edad-minima-referencia');
    var maximaReferencia = $('#edad-maxima-referencia');

    if ($(this).prop('checked')) {
        minimaReferencia.addClass('disable-element');
        maximaReferencia.addClass('disable-element');

        limpiarInputs('SinEdad', true)
    } else {
        minimaReferencia.removeClass('disable-element');
        maximaReferencia.removeClass('disable-element');
    }
})

$(document).on('change, keyup, click', '#cambioReferencia', function () {


    if ($(this).is(':checked')) {
        $('#resultado-select-rango').fadeIn(1);
        $('#cambio-rango-referencia').fadeOut(1);


        limpiarInputs('cambioReferencia', true)
    } else {
        $('#resultado-select-rango').fadeOut(1);
        $('#cambio-rango-referencia').fadeIn(1);

        limpiarInputs('cambioReferencia', false)
    }
})

$(document).on('click', '#btn-guardar-referencia', function (e) {
    e.preventDefault();
    alertMensajeConfirm({
        title: '¿Esta seguro de guardar los valores de referencia?',
        text: 'No podra modificarlo',
        icon: 'info',
        showCancelButton: true,
    }, function () {
        ajaxAwaitFormData({
            api: 1,
            servicio_id: array_selected['ID_SERVICIO']
        }, 'valores_referencia_api', 'formGuardarReferencia', { callbackAfter: true }, false, function (data) {
            alertToast(text, 'success', 4000)
        })
    }, 1)

})

function limpiarInputs(elementID, isChecked) {
    switch (elementID) {
    case 'SinEdad':
        if (isChecked) {
            $('#edad-maxima-referencia').val('')
            $('#edad-minima-referencia').val('')
        }
        break;
    case 'cambioReferencia':
        if (isChecked) {
            $('#valor_minimo').val('')
            $('#valor_maximo').val('')
        } else {
            $('#valor_referencia').val('')
        }
        break;
    }
}



const myModal = document.getElementById('modalReferencia')

myModal.addEventListener('shown.bs.modal', () => {
  setTimeout(function(){
    $.fn.dataTable
    .tables({
      visible: true,
      api: true
  })
    .columns.adjust();

},250)


})
