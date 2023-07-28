select2('#seleccionar-cliente', 'divSeleccionCliente', 'Cargando lista de clientes...')
rellenarSelect('#seleccionar-cliente', 'clientes_api', 2, 0, 'NOMBRE_SISTEMA.NOMBRE_COMERCIAL');



// Rellenan la tabla dependiendo de las opciones
$('#seleccionar-cliente').change(function () {
  switch ($('input[type=radio][name=selectTipLista]:checked').val()) {
    case '3': //Solo paquetes
      obtenertablaListaPrecios(columnsDefinidas, columnasData, 'paquetes_api', { api: 2, cliente_id: $(this).val() }, 'response.data')
      break;
    default:
      $('input[type=radio][name=selectChecko]').prop('checked', false)
      tablaPrecio.destroy();
      $('#TablaListaPrecios').empty();
      tablaPrecio = $("#TablaListaPrecios").DataTable({
        language: {
          url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        info: false,
        paging: false,
        columnDefs: columnsDefinidas
      });
  }
})

$('input[type=radio][name=selectChecko]').change(function () {

  $('#vistaPreviaExel').prop('disabled', false);
  switch ($('input[type=radio][name=selectTipLista]:checked').val()) {
    case '1': //Solo Concepto
      if ($(this).val() != 0) {
        obtenertablaListaPrecios(columnsDefinidas, columnasData, 'servicios_api', { api: 2, id_area: $(this).val() })
      } else {
        obtenertablaListaPrecios(columnsDefinidas, columnasData, 'servicios_api', { api: 2, otros_servicios: 1 })
      }

      break;
    case '2': //Lista de precios para clientes
      if ($('#seleccionar-cliente').val() != null || $('#seleccionar-cliente').val() != 0) {
        if ($(this).val() != 1) {
          obtenertablaListaPrecios(columnsDefinidas, columnasData, 'precios_api', { api: 9, cliente_id: $('#seleccionar-cliente').val(), area_id: $(this).val() }, 'response.data')
        } else {
          obtenertablaListaPrecios(columnsDefinidas, columnasData, 'precios_api', { api: 9, cliente_id: $('#seleccionar-cliente').val(), area_id: 0 }, 'response.data')
        }
      } else {
        alertSelectTable('Seleccione un cliente')
      }
      break;


  }



})

$('#vistaPreviaExel').on('click', function () {

  $('#vistaPreviaExelModal').modal('show')

});

menu = $('input[type=radio][name=selectTipLista]:checked').val()
function obtenerDatosMostrar(menu) {
  
  switch (menu) {
    case 1:
      column = [

        { data: 'COUNT' },
        { data: 'ABREVIATURA' },
        { data: 'DESCRIPCION' },
        { data: 'COSTO' },

      ]

      columnDefs = [
        { target: 0, title: '#', className: 'all', 'visible': true },
        { target: 1, title: 'AB', className: 'all' },
        { target: 2, title: 'Nombre', className: 'all' },
        { target: 3, title: 'Costo', 'className': 'all' }

      ]

      return [columns, columnDefs]

      break;

    case 2:
      return column = [

        { data: 'COUNT' },
        { data: 'ABREVIATURA' },
        { data: 'DESCRIPCION' },
        { data: 'COSTO' },
        { data: 'UTILIDAD' },
        { data: 'PRECIO_VENTA' },

      ]

      break;

    case 3:


      break;
  }
}

select2('#seleccion-paquete', 'vista_paquetes-precios', 'Cargando lista de paquetes...')
rellenarSelect('#seleccion-paquete', 'paquetes_api', 2, 0, 'DESCRIPCION', { cliente_id: 1 });


//Obsoleto
$('#btn-precios-guardar').click(function () {
  $('#btn-precios-guardar').prop('disabled', true)
  let tablaPrecios = new Array();
  let url, api, id;
  tablaPrecio.search('').draw();
  setTimeout(function () {
    // var form_data  = tablaPrecio.rows().data();
    var costo = tablaPrecio.$("input[name='costo']").serialize();
    var margen = tablaPrecio.$("input[name='margen']").serialize();

    costo2 = costo.slice(6);
    // console.log(costo2);

    let arraycosto = costo2.split('&costo=');

    margen2 = margen.slice(7);
    // console.log(margen2);

    let arraymargen = margen2.split('&margen=');

    // console.log(arraymargen);
    var tableData = tablaPrecio.rows().data().toArray();
    // console.log(tableData);
    for (var i = 0; i < tableData.length; i++) {
      total = parseFloat(arraycosto[i]) + (parseFloat(arraycosto[i]) * parseFloat(arraymargen[i]) / 100);
      if ($('input[type=radio][name=selectChecko]:last').is(':checked')) {
        id = tableData[i]['ID_PAQUETE']
      } else {
        id = tableData[i]['ID_SERVICIO']
      }
      const arrayFor = [id, parseFloat(arraycosto[i]), parseFloat(arraymargen[i]), total];
      tablaPrecios.push(arrayFor);
    }
    if (tablaPrecios.length > 0) {
      if ($('input[type=radio][name=selectChecko]:last').is(':checked')) {
        api = 7; url = 'paquetes_api';
        // alert('Paquete')
        aviso = "Estudios actualizados"
      } else {
        api = 1; url = 'precios_api';
        aviso = "Paquetes actualizados";
        // alert('Estudios')
        // console.log($('#check-paquetes'))
        // console.log($('input[type=radio][name=selectChecko]'))
      }

      // console.log(tablaPrecios)
      //
      $.ajax({
        url: `${http}${servidor}/${appname}/api/${url}.php`,
        data: { api: api, contenedorListaPrecios: tablaPrecios },
        type: "POST",
        datatype: 'json',
        beforeSend: function () {
          alertMensaje('info', 'Espere un momento', 'El sistema esta guardando los datos...')
        },
        success: function (data) {
          data = jQuery.parseJSON(data);
          if (mensajeAjax(data)) {
            alertSelectTable(aviso, icon = 'success', timer = 2000)
          }
          $('#btn-precios-guardar').prop('disabled', false)
        },
        complete: function () {
          $('#btn-precios-guardar').prop('disabled', false)
        }
      })

      // console.log()

      // console.log(tablaPrecios);
    } else {
      alertSelectTable('No hay información en la tabla', 'error')
      $('#btn-precios-guardar').prop('disabled', false)
    }

    return false;
  }, 50)
});
//


//Guarda toda la tabla (Manda a ajax)
$('#btn-guardar-lista').click(function () {
  //Alerta de verificacion de contraseña
  Swal.fire({
    title: '¿Está seguro de guardar está lista?',
    text: 'Use su contraseña para confirmar',
    showCancelButton: true,
    confirmButtonText: 'Confirmar',
    cancelButtonText: 'Cancelar',
    showLoaderOnConfirm: true,
    // inputAttributes: {
    //   autocomplete: false
    // },
    // input: 'password',
    html: '<form autocomplete="off" onsubmit="formpassword(); return false;"><input type="password" id="password-confirmar" class="form-control input-color" autocomplete="off" placeholder=""></form>',
    // confirmButtonText: 'Sign in',
    focusConfirm: false,
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
      if (result.value.status == 1) { //Confirma que todo este bien y obtengo todo los datos por cada apartado
        let listaConcepto;
        switch ($('input[type=radio][name=selectTipLista]:checked').val()) {
          case '1': //Concepto
            console.log(getListaConcepto());
            listaConcepto = getListaConcepto();
            ajaxMandarLista({ api: 1, contenedorListaPrecios: listaConcepto }, 'precios_api');
            break;
          case '2': //Precios
            console.log(getListaPrecios('ID_SERVICIO'))
            listaConcepto = getListaPrecios('ID_SERVICIO');
            ajaxMandarLista({ api: 6, servicios: listaConcepto, cliente_id: $('#seleccionar-cliente').val() }, 'precios_api');
            break;
          case '3': //Paquetes
            console.log(getListaPrecios('ID_PAQUETE'))
            listaConcepto = getListaPrecios('ID_PAQUETE');
            ajaxMandarLista({ api: 7, contenedorPaquetes: listaConcepto, cliente_id: $('#seleccionar-cliente').val() }, 'paquetes_api');
            break;
          default:
            alert('No a seleccionado ninguna opcion')

        }
      } else {
        alertSelectTable('¡Contraseña incorrecta!', 'error')
      }
    }
  })

})

//Cambiar vista de tabla
$('input[type=radio][name=selectTipLista]').change(function () {
  switch ($(this).val()) {
    case '1':
      columnsDefinidas = obtenerColumnasTabla('1.1')
      columnasData = obtenerColumnasTabla('1.2')
      $('.vista_estudios-precios').fadeIn(100)
      $('#divSeleccionCliente').fadeOut(100)
      break;
    case '2':
      columnsDefinidas = obtenerColumnasTabla('2.1')
      columnasData = obtenerColumnasTabla('2.2')
      $('.vista_estudios-precios').fadeIn(100)
      $('#divSeleccionCliente').fadeIn(100)
      break;
    case '3':
      columnsDefinidas = obtenerColumnasTabla('3.1')
      columnasData = obtenerColumnasTabla('3.2')
      $('.vista_estudios-precios').fadeOut(100)
      $('#divSeleccionCliente').fadeIn(100)
      obtenertablaListaPrecios(columnsDefinidas, columnasData, 'paquetes_api', { api: 2, cliente_id: $('#seleccionar-cliente').val() }, 'response.data')
      return 1;
      break;
    default:
      confirm('Esta opcion no deberia verser, recargue la pagina y eliga una opción')
  }
  tablaPrecio.destroy();
  $('#TablaListaPrecios').empty();
  tablaPrecio = $("#TablaListaPrecios").DataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    lengthChange: false,
    info: false,
    paging: false,
    columnDefs: columnsDefinidas
  });
  $('input[type=radio][name=selectChecko]:checked').prop('checked', false);
  // obtenertablaListaPrecios(columnsDefinidas, columnasData, apiurl)
})


opciones = obtenerDatosMostrar(menu)

listaPreciosExelModal = $('#listaPreciosExel').DataTable({
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
  },
  lengthChange: false,
  info: false,
  paging: false,
  scrollY: "63vh",
  scrollCollapse: true,
  data: [],
  columns: opciones[0],
  columnDefs: opciones[1],
  dom: 'Bfrtip',
  buttons: [
    {
      extend: 'excelHtml5',
      text: '<i class="bi bi-box-arrow-down"></i> Descargar Exel',
      className: 'btn btn-success',
      titleAttr: 'Excel',
      filename: 'HOLA',
      title: 'HOLA',
      exportOptions: {
        columns: [0, 1, 2, 3] // Índices de las columnas a exportar
      },
    },
  ]

});

const listaPreciosExel = document.getElementById('vistaPreviaExelModal')
listaPreciosExel.addEventListener('show.bs.modal', event => {
  setTimeout(() => {
    $.fn.dataTable
      .tables({
        visible: true,
        api: true
      })
      .columns.adjust();
  }, 350);
  listaPreciosExelModal.rows.add(tablaPrecio.data()).draw();




})

listaPreciosExel.addEventListener('hidden.bs.modal', event => {
  listaPreciosExelModal.clear().draw();
})

