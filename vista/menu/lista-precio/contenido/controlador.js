// if (validarVista('LISTA DE PRECIOS')) {
//   hasLocation();
// }

hasLocation()
$(window).on("hashchange", function (e) {
  hasLocation();
});

let idsEstudios, data = {
  api: 2,
  id_area: 7
},
  apiurl = 'servicios_api',
  tablaPrecio, tablaPaquete, tablaContenidoPaquete;
let dataSet = new Array();
let iva, total, subtotalPrecioventa, subtotalCosto;
let dataEliminados = new Array(); //Lista para cuando eliminen un servicio

// Arreglos para la tabla dinamica, para solo costos
let columnsDefinidas;
let columnasData;
//

//Personalizar la tabla de excel de cotizaciones y paquetes
var dataVistaPq = {};
var VistaExcelurl = '';
var row2

//Cambia la vista a la lista de precios
function obtenerContenidoPrecios() {
  obtenerTitulo("Lista de precios"); //Aqui mandar el nombre de la area
  $.post("contenido/listaprecios.php", function (html) {
    $("#body-js").html(html);
  }).done(function () {
    $('#vista_paquetes-precios').fadeOut(0)
    $('#divSeleccionCliente').fadeOut(0)
    $.getScript('contenido/js/funciones-listaprecios.js').done(function () {
      columnsDefinidas = obtenerColumnasTabla('1.1')
      columnasData = obtenerColumnasTabla('1.2')
      // Datatable
      tablaPrecio = $("#TablaListaPrecios").DataTable({
        language: {
          url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        info: false,
        paging: false,
        columnDefs: columnsDefinidas,
      });

      inputBusquedaTable('TablaListaPrecios', tablaPrecio, [], [], 'col-12')

      // obtenertablaListaPrecios(columnsDefinidas, columnasData, apiurl, data)
      $.getScript("contenido/js/precios-tabla.js");
      // Calcula las tablas
      $.getScript("contenido/js/calculos-listaprecios.js");
      // Botones
      $.getScript("contenido/js/precio-botones.js");
    })

  });
}

// rellena la tabla con el servicio que se envie
function obtenertablaListaPrecios(columnDefs, columnsData, urlApi, dataAjax = {
  api: 7,
  id_area: 7
}, response = null) {
  // console.log(columnDefs);
  // console.log(columnsData)
  dataEliminados = new Array()
  tablaPrecio.destroy();
  $('#TablaListaPrecios').empty();
  tablaPrecio = $("#TablaListaPrecios").DataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: "63vh",
    scrollCollapse: true,
    columnDefs: columnDefs,
    ajax: {
      dataType: 'json',
      data: dataAjax,
      method: 'POST',
      url: '../../../api/' + urlApi + '.php',
      // beforeSend: function () {
      //   loaderDiv("In", "#contenido-lista-precios", "#loader-tabla-precios");
      // },
      // complete: function () {
      //   loaderDiv("Out",  "#contenido-lista-precios", "#loader-tabla-precios");
      // },
      dataSrc: response
    },
    columns: columnsData
  });
  inputBusquedaTable('TablaListaPrecios', tablaPrecio, [], [], 'col-12')

}

var tablePaquetesHTML;
//Cambia la vista para paquetes
function obtenerContenidoPaquetes(tabla) {
  obtenerTitulo("Paquetes de clientes"); //Aqui mandar el nombre de la area
  // Funciones js
  $.post("contenido/paquetes.php", function (html) {
    $("#body-js").html(html);

  }).done(function () {

    dataVistaPq = { api: 9, id_paquete: $('#seleccion-paquete').val() }
    VistaExcelurl = `${http}${servidor}/${appname}/api/paquetes_api.php`

    tablePaquetesHTML = $("#TablaListaPaquetes")
    $.getScript("contenido/js/funciones-paquetes.js").done(function () {
      tablaContenidoPaquete = $("#TablaListaPaquetes").DataTable()
      contenidoPaquete(1)
      // Datatable
      $.getScript("contenido/js/paquete-tabla.js");
      // Botones
      $.getScript("contenido/js/paquete-botones.js");
    })

  });

}




//Vacia la tabla, para el poder rellenar en paquetes
function tablaContenido(descuento = false) {
  tablaContenidoPaquete.destroy();
  $('#TablaListaPaquetes').empty();
  dataEliminados = new Array()
  tablaContenidoPaquete = $("#TablaListaPaquetes").DataTable({
    lengthChange: false,
    // info: false,
    paging: true,
    scrollY: "50vh",
    scrollCollapse: true,
    columnDefs: [
      { className: 'all', width: "213.266px", title: "Descripción", targets: 0 },
      { className: 'desktop', width: "80.75px", title: "CVE", targets: 1 },
      { className: 'min-tablet', width: "90.516px", title: "Cantidad", targets: 2, orderable: false },
      { className: 'all', width: "80.8438px", title: "Costo", targets: 3 },
      { className: 'desktop', width: "102.484px", title: "Costo Total", targets: 4 },
      { className: 'min-tablet', width: "90.516px", title: "Descuento", targets: 5, orderable: false, visible: descuento },
      { className: 'desktop', width: "99.344px", title: "Precio Venta", targets: 6 },
      { className: 'all', width: "64.75px", title: "Subtotal", targets: 7 },
      { visible: false, title: "?", targets: 8, searchable: false, },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    // 
  });

  // selectDatatabledblclick((selected, data, row) => {
  //   dataEliminados.push(data[7])
  //   console.log(dataEliminados);
  //   tablaContenidoPaquete.row($(row)).remove().draw();
  //   if (tablaContenidoPaquete.data().count()) {
  //     calcularFilasTR()
  //   }
  // }, tablePaquetesHTML, tablaContenidoPaquete)

  inputBusquedaTable('TablaListaPaquetes', tablaContenidoPaquete, [], [], 'col-12')
  loader("Out");
}

// //Tabla para cargar los servicios de un paquete y modificarlos
// function tablaMantenimiento(url = 'paquetes_api') {
//   tablaContenidoPaquete.destroy();
//   $('#TablaListaPaquetes').empty();
//   dataEliminados = new Array()
//   tablaContenidoPaquete = $("#TablaListaPaquetes").DataTable({
//     language: {
//       url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
//     },
//     lengthChange: false,
//     info: false,
//     paging: false,
//     scrollY: "63vh",
//     scrollCollapse: true,
//     columnDefs: [{
//       width: "213.266px",
//       title: "Descripción",
//       targets: 0
//     },
//     {
//       width: "80.75px",
//       title: "CVE",
//       targets: 1
//     },
//     {
//       width: "90.516px",
//       title: "Cantidad",
//       targets: 2,
//       orderable: false
//     },
//     {
//       width: "80.8438px",
//       title: "Costo",
//       targets: 3
//     },
//     {
//       width: "102.484px",
//       title: "Costo Total",
//       targets: 4
//     },
//     {
//       width: "99.344px",
//       title: "Precio Venta",
//       targets: 5
//     },
//     {
//       width: "64.75px",
//       title: "Subtotal",
//       targets: 6
//     },
//     {
//       visible: true,
//       title: "?",
//       targets: 7,
//       searchable: false,
//     },
//     ],
//     ajax: {
//       dataType: 'json',
//       data: {
//         id_paquete: $('#seleccion-paquete').val(),
//         api: 9
//       },
//       method: 'POST',
//       url: http + servidor + "/"+appname+"/api/" + url + ".php",
//       complete: function () {
//         loader("Out")
//       },
//       dataSrc: 'response.data'
//     },
//     columns: [{
//       data: 'SERVICIO'
//     },
//     {
//       data: 'ABREVIATURA'
//     },
//     {
//       data: 'CANTIDAD',
//       render: function (data, type, full, meta) {
//         rturn = '<input type="number" class="form-control input-form cantidad-paquete text-center" name="cantidad-paquete" placeholder="" value="' + data + '" style="margin: 0;padding: 0;height: 35px;">';
//         return rturn;
//       }
//     },
//     {
//       data: 'COSTO_UNITARIO',
//       render: function (data, type, full, meta) {
//         return '<div class="costo-paquete text-center">$' + data + '</div>'
//       }
//     },
//     {
//       data: 'COSTO_TOTAL',
//       render: function (data, type, full, meta) {
//         return '<div class="costototal-paquete text-center">$' + data + '</div>';
//       }
//     },
//     {
//       data: 'PRECIO_VENTA_UNITARIO',
//       render: function (data, type, full, meta) {
//         return '<div class="precioventa-paquete text-center">$' + data + '</div>'
//       }
//     },
//     {
//       data: 'SUBTOTAL',
//       render: function (data, type, full, meta) {
//         return '<div class="subtotal-paquete text-center">$' + data + '</div>'
//       }
//     },
//     {
//       data: 'ID_SERVICIO'
//     },
//       // {defaultContent: 'En progreso...'}
//     ],
//   });
// }



var cliente_id;
async function obtenerContenidoCotizaciones() {
  await obtenerTitulo("Cotizaciones de estudios"); //Aqui mandar el nombre de la area
  // Funciones js
  $.post("contenido/cotizaciones.php", function (html) {
    $("#body-js").html(html);
  }).done(function () {
    VistaExcelurl = `${http}${servidor}/${appname}/api/cotizaciones_api.php`
    dataVistaPq = { api: 9, id_paquete: $('#seleccion-paquete').val() }

    tablePaquetesHTML = $("#TablaListaPaquetes")
    $.getScript("contenido/js/funciones-cotizaciones.js").done(function () {
      tablaContenidoPaquete = $("#TablaListaPaquetes").DataTable()
      contenidoPaquete(1)
      // Datatable
      $.getScript("contenido/js/cotizaciones-tabla.js");
      // Botones
      $.getScript("contenido/js/cotizaciones-botones.js");
    })
  });
}







//Cambia la vista de la pagina
function hasLocation() {
  var hash = window.location.hash.substring(1);
  $("a").removeClass("navlinkactive");
  $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
  if (validarVista(hash)) {
    switch (hash) {
      case "LISTA_PRECIOS":
        obtenerContenidoPrecios();
        break;
      case "PAQUETES_ESTUDIOS":
        obtenerContenidoPaquetes();
        break;
      case "COTIZACIONES_ESTUDIOS":
        obtenerContenidoCotizaciones();
        break;
      default: avisoArea(); break;
    }

  }
}