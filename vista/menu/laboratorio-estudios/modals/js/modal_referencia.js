select2('#select-operador-referencia', 'modalReferencia')
rellenarSelect("#select-operador-referencia", "valores_referencia_api", 2, "ID_OPERADORES_LOGICOS", "DESCRIPCION");

var minimaReferencia = $('#edad-minima-referencia');
var maximaReferencia = $('#edad-maxima-referencia');

// Variables que solo se usan una vez, no tocar
var DataReferencia = {
    api: 3
}
var checkedCambiarReferencia, normalidad = 0;

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
            // console.log(1)
            TablaValoresReferencia.columns.adjust().draw()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // console.log(2)
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'response.data'
    },
    columns: [
        { data: 'COUNT' },
        { data: 'SERVICIO' },
        { data: 'DESCRIPCION_DIRIGIDO_A' },
        {
            data: null, render: function (meta) {
                // body...
                // return ifnull(data,)

                let presentacion;

                if (meta['PRESENTACION'] == null) {
                    presentacion = ValidarPresentacion(meta)
                } else {
                    presentacion = `${ifnull(meta, 'Indefinido', ['PRESENTACION'])} ${ifnull(meta, 'Indefinido', ['VALOR_MINIMO', 'CODIGO'])}-${ifnull(meta, 'Indefinido', ['VALOR_MAXIMO', 'VALOR_REFERENCIA'])}`
                }

                return insertarSaltosDeLinea(presentacion, 25);
            }
        },
        {
            data: null, render: function (meta) {


                return `${ifnull(meta, '0', ['EDAD_MINIMA'])} - ${ifnull(meta, '+100', ['EDAD_MAXIMA'])} AÑOS`
            }
        },
        {
            data: null, render: function (meta) {


                // Calcular si esta llegando el minmo y maximo, si no llega no es un rango es una referencia, operador logico y referencia juntos
                return `${ifnull(meta, 'Indefinido', ['VALOR_MINIMO', 'CODIGO'])}-${ifnull(meta, 'Indefinido', ['VALOR_MAXIMO', 'VALOR_REFERENCIA'])}`
            }
        },
        {
            data: null, render: function (meta) {

                if (meta.VALOR_NORMALIDAD == "1") {
                    html = `<i class="bi bi-check-circle-fill text-success"></i>`
                } else {
                    html = `<i class="bi bi-x-circle-fill text-danger"></i>`
                }


                return html
            }
        },
        {
            data: 'ID_VALORES_REFERENCIA', render: function (data) {


                return `<i class="bi bi-trash" data-id = "${data}" style = "cursor: pointer"
            onclick="desactivarTablaReferencia.call(this)"></i>`;

            }
        }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Servicio', className: 'desktop' },
        { target: 2, title: 'Dirigido', className: 'desktop' },
        // { target: 4, title: 'Edad Maxima', className: 'none' }, 
        { target: 3, title: 'Presentación', className: 'all' },
        { target: 4, title: 'Edad', className: 'all' },
        // { target: 6, title: 'Valor Minimo', className: 'none' },
        // { target: 7, title: 'Valor Maximo', className: 'none' },
        // { target: 8, title: 'Operador Lógico', className: 'none' },
        { target: 5, title: 'Referencia', className: 'min-tablet' },
        { target: 6, title: 'Val nor', className: 'min-tablet' },
        { target: 7, title: '<i class="bi bi-trash"></i>', className: 'all' }

    ],
    // dom: 'Blfrtip',
    // buttons: [
    // {
    //     text: '<i class="bi bi-file-earmark-pdf"></i> Visualizar PDF',
    //     className: 'btn btn-borrar',
    //     action: function () {

    //     }
    // }
    // ]
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
        checkedCambiarReferencia = 1

        limpiarInputs('cambioReferencia', true)
    } else {
        $('#resultado-select-rango').fadeOut(1);
        $('#cambio-rango-referencia').fadeIn(1);
        checkedCambiarReferencia = 0
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

        if ($('#valorBueno').is(':checked')) {
            normalidad = 1
        } else {
            normalidad = 0
        }
        ajaxAwaitFormData({
            api: 1,
            servicio_id: array_selected['ID_SERVICIO'],
            checkedCambiarReferencia: checkedCambiarReferencia,
            valores_normalidad: normalidad
        }, 'valores_referencia_api', 'formGuardarReferencia', { callbackAfter: true }, false, function (data) {
            alertToast('Su referencia se a guardado!', 'success', 4000)
            normalidad = 0;
            TablaValoresReferencia.ajax.reload()

            // $('#edad-minima-referencia').val('')
            // $('#edad-maxima-referencia').val('')
            // $('#presentacion').val('')
            // $('#valor_minimo').val('')
            // $('#valor_maximo').val('')
            // $('#valor_referencia').val('')

            $('#formGuardarReferencia').trigger("reset");
            $('#SinEdad').prop('checked', false);
            minimaReferencia.removeClass('disable-element');
            maximaReferencia.removeClass('disable-element');
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


// const myModal = document.getElementById('modalReferencia')

// myModal.addEventListener('shown.bs.modal', () => {
//     setTimeout(function () {
//         $.fn.dataTable
//             .tables({
//                 visible: true,
//                 api: true
//             })
//             .columns.adjust();

//     }, 250)
// })
const myModal = document.getElementById('modalReferencia');


myModal.addEventListener('shown.bs.modal', () => {
    setTimeout(function () {
        // Ajustar las columnas de la tabla DataTable después de mostrar el modal
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
        // Reiniciar el formulario con el ID formGuardarReferencia
        const formulario = document.getElementById('formGuardarReferencia');
        if (formulario) {
            console.log(1)
            formulario.reset();
        }
    }, 250);
});


function desactivarTablaReferencia() {

    var id_valores_referencia = $(this).data("id");

    alertMensajeConfirm({
        title: '¿Está seguro que desea desactivar el valor de referencia',
        text: 'No podrá modificarlo despues',
        icon: 'warning',
    }, function () {
        dataJson_eliminar = {
            api: 1,
            id_valores_referencia: id_valores_referencia
        }

        ajaxAwait(dataJson_eliminar, 'valores_referencia_api', { callbackAfter: true }, false, function (data) {
            alertToast('Referencia eliminada!', 'success', 4000)

            TablaValoresReferencia.ajax.reload()
        })
    }, 1)
}


let delayKeyup = false
$('#formGuardarReferencia').on('change keyup click', 'input, select, input[type="checkbox"]', function (event) {
    if (event.type === 'keyup') {
        clearTimeout(delayKeyup);  // Limpiamos el timeout anterior
        delayKeyup = setTimeout(mostrarResultadoFinal, 500);  // medio segundo de delay
    } else {
        mostrarResultadoFinal();
    }
});


function mostrarResultadoFinal() {
    // Lógica para calcular algo después de que se detecta un cambio
    console.log("FEMENINO....");
}



// $(document).on('click', '#btn-VisualizarPDFReferencia', function (e) {
//     e.preventDefault();

//     api = encodeURIComponent(window.btoa('laboratorio'));
//     area = encodeURIComponent(window.btoa(-1));
//     turno = encodeURIComponent(window.btoa(FolioMesEquipo));

//     var win = window.open(`http://localhost/practicantes/visualizar_reporte/?api=${api}&turno=${turno}&area=${area}`, '_blank')

//     win.focus();
// })

// Function para validar la presentación y como se vera en el front
function ValidarPresentacion(meta) {

    // Se declaran las variables a evaluar en el caso de sexo, si no viene se setea la variable a null en caso contrario guarda el genero en la variable sexo
    var res;
    var edad = null;
    var sexo = meta.DESCRIPCION_DIRIGIDO_A == null ? null : meta.DESCRIPCION_DIRIGIDO_A;

    // Validar si las edades vienen null, si es asi setear el valor de edad a null en caso contrario guardar las edades en la variables 
    if (meta.EDAD_MINIMA !== null && meta.EDAD_MAXIMA !== null)
        edad = {
            "EDAD_MINIMA": meta.EDAD_MINIMA,
            "EDAD_MAXIMA": meta.EDAD_MAXIMA
        }

    // Entra al case donde evalua cada opcion que tiene para mostrar la presentación
    if (sexo !== "AMBOS") {
        if (edad !== null) {
            res = `${ifnull(meta, 'null ', ['DESCRIPCION_DIRIGIDO_A'])} ${ifnull(meta, '0', ['EDAD_MINIMA'])} - ${ifnull(meta, '+100', ['EDAD_MAXIMA'])} AÑOS ${ifnull(meta, 'Indefinido', ['VALOR_MINIMO', 'CODIGO'])}-${ifnull(meta, 'Indefinido', ['VALOR_MAXIMO', 'VALOR_REFERENCIA'])}`
        } else {
            res = `${ifnull(meta, '', ['DESCRIPCION_DIRIGIDO_A'])} ${ifnull(meta, 'Indefinido', ['VALOR_MINIMO', 'CODIGO'])}-${ifnull(meta, 'Indefinido', ['VALOR_MAXIMO', 'VALOR_REFERENCIA'])}`
        }
    } else {
        if (edad !== null) {
            res = `${ifnull(meta, '0', ['EDAD_MINIMA'])} - ${ifnull(meta, '+100', ['EDAD_MAXIMA'])} AÑOS ${ifnull(meta, 'Indefinido', ['VALOR_MINIMO', 'CODIGO'])}-${ifnull(meta, 'Indefinido', ['VALOR_MAXIMO', 'VALOR_REFERENCIA'])}`
        } else {
            res = `${ifnull(meta, 'Indefinido', ['VALOR_MINIMO', 'CODIGO'])}-${ifnull(meta, 'Indefinido', ['VALOR_MAXIMO', 'VALOR_REFERENCIA'])}`
        }
    }

    return res;
}

function insertarSaltosDeLinea(texto, caracteresPorLinea) {
    let resultado = "";

    for (let i = 0; i < texto.length; i += caracteresPorLinea) {
        const segmento = texto.slice(i, i + caracteresPorLinea);
        resultado += segmento + "<br>";
    }

    return resultado;
}

