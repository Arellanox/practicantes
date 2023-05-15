const modalRegistrarCargo = document.getElementById('modalRegistrarCargo')
modalRegistrarCargo.addEventListener('show.bs.modal', event => {
  TablaCargos.ajax.reload();
})

//Ajusta el ancho del encabezado cuando es dinamico
$('#modalRegistrarCargo').on('shown.bs.modal', function (e) {
  $.fn.dataTable
    .tables({
      visible: true,
      api: true
    })
    .columns.adjust();
})

//Formulario de registro de cargo
$("#formRegistrarCargo").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  var form = document.getElementById("formRegistrarCargo");
  var formData = new FormData(form);
  formData.set('api', 1);

  alertMensajeConfirm({
    title: '¿Está seguro que todos los datos están correctos?',
    text: "No podrá eliminar este cargo",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar"
  }, function () {
    $.ajax({
      data: formData,
      url: `${http}${servidor}/${appname}/api/cargos_api.php`,
      type: "POST",
      processData: false,
      contentType: false,
      success: function (data) {
        data = jQuery.parseJSON(data);
        if (mensajeAjax(data)) {
          Toast.fire({
            icon: 'success',
            title: '¡Cargo registrado!',
            timer: 2000
          });
          document.getElementById("formRegistrarMetodo").reset();
          TablaCargos.ajax.reload();
          cambiarFormMetodo(0);
          // selectMetodo()
        }
      },
    });
  })
  event.preventDefault();
});

//Formulario de actualizar cargo
$("#formEditarCargo").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  var form = document.getElementById("formEditarCargo");
  var formData = new FormData(form);
  formData.set('id_cargo', array_cargo['ID_CARGO'])
  formData.set('api', 1);

  alertMensajeConfirm({
    title: '¿Está seguro de cambiar la descripcion?',
    text: "¡Cuidado con esta accion!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar"
  }, function () {
    //$("#btn-registrarse").prop('disabled', true);
    // Esto va dentro del AJAX
    $.ajax({
      data: formData,
      url: `${http}${servidor}/${appname}/api/cargos_api.php`,
      type: "POST",
      processData: false,
      contentType: false,
      success: function (data) {
        data = jQuery.parseJSON(data);
        if (mensajeAjax(data)) {
          Toast.fire({
            icon: "success",
            title: "¡Método Actualizado!",
            timer: 2000,
          });
          document.getElementById("formEditarCargo").reset();
          TablaCargos.ajax.reload();
          cambiarFormMetodo(0);
          // selectMetodo()
        }
      },
    });
  })
  event.preventDefault();
});

// function selectMetodo() {
//   rellenarSelect("#select_cargos", "laboratorio_cargos_api", 2, 0, 1);
// }
// select2('#select_cargos', 'modalRegistrarCargo')



TablaCargos = $('#TablaCargos').DataTable({
  processing: true,
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    loadingRecords: '&nbsp;',
    processing: '<div class="spinner"></div>'
  },
  lengthMenu: [
    [5, 10, -1],
    [5, 10, "All"]
  ],
  autoWidth: false,
  searching: false,
  lengthChange: false,
  info: false,
  paging: false,
  scrollY: "30vh",
  scrollCollapse: true,
  ajax: {
    dataType: 'json',
    data: {
      api: 2
    },
    method: 'POST',
    url: '../../../api/cargos_api.php',
    beforeSend: function () {
      // loader("In")
      console.log(1)
    },
    complete: function () {
      // loader("Out")
      cambiarFormMetodo(0);
    },
    dataSrc: 'response.data'
  },
  columns: [
    { data: 'COUNT' },
    { data: 'DESCRIPCION' },
    {
      data: 'ACTIVO', render: function (data) {
        if (data == 1) {
          return '<i class="bi bi-check-circle"></i>';
        } else {
          return '<i class="bi bi-x-circle"></i>';
        }
      }
    },
  ],
  columnDefs: [{
    "width": "3px",
    "targets": 0
  },],

})
// $('#TablaCargos tbody').on('click', 'tr', function () {
//    if ($(this).hasClass('selected')) {
//        $(this).removeClass('selected');
//        array_selected = null;
//    } else {
//        TablaCargos.$('tr.selected').removeClass('selected');
//        $(this).addClass('selected');
//        array_selected = TablaCargos.row( this ).data();
//    }
// });


$('#TablaCargos tbody').on('dblclick', 'tr', function () {
  if ($(this).hasClass('selected')) {
    $(this).removeClass('selected');
    array_cargo = null;
    cambiarFormMetodo(0);
  } else {
    TablaCargos.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');
    array_cargo = TablaCargos.row(this).data();
    // console.log(array_cargo);
    document.getElementById("edit-cargo-descripcion").value = array_cargo[1];
    var data = TablaCargos.row(this).data();
    cambiarFormMetodo(1);
    // alert( 'You clicked on '+data[0]+'\'s row' );
  }
});

function cambiarFormMetodo(fade) {
  if (fade == 1) {
    $('#RegistrarMetodoCol').fadeOut();
    setTimeout(function () {
      $('#editarMetodoCol').fadeIn();
    }, 400);
  } else {
    document.getElementById("formEditarCargo").reset();
    $('#editarMetodoCol').fadeOut();
    setTimeout(function () {
      $('#RegistrarMetodoCol').fadeIn();
    }, 400);
  }
}


// $("#Buscarcargo").click(function () {
//   idMetodo = $('#select_cargos').val();
//   text = $("#select_cargos option:selected").text();
//   if (idMetodo != "") {
//     TablaCargos.$('tr.selected').removeClass('selected');
//     document.getElementById("edit-cargo-descripcion").value = text;
//     var tr = selectedTrTable(text, 1, 'TablaCargos')
//     array_cargo = TablaCargos.row(tr).data();
//     cambiarFormMetodo(1);
//   } else {
//     array_cargo = null;
//     cambiarFormMetodo(0);
//   }
// })

// $("#Limpiarcargo").click(function () {
//   TablaCargos.$('tr.selected').removeClass('selected');
//   array_cargo = null;
//   cambiarFormMetodo(0)
// })

$('#desactivar-cargo').click(function () {
  if (array_cargo != null) {
    Swal.fire({
      title: "¿Está seguro que desea desactivar este método?",
      text: "No podrán elegir este método",
      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#3085d6',
      confirmButtonColor: '#d33',
      confirmButtonText: 'Desactivar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          data: {
            id: array_cargo['ID_CARGO'],
            api: 4
          },
          url: "../../../api/cargos_api.php",
          type: "POST",
          success: function (data) {
            data = jQuery.parseJSON(data);
            if (mensajeAjax(data)) {
              Toast.fire({
                icon: 'success',
                title: '¡Cargo Eliminado!',
                timer: 2000
              });
              document.getElementById("formEditarCargo").reset();
              TablaCargos.ajax.reload();
              cambiarFormMetodo(0);
            }
          },
        });
      }
    })
  } else {
    alertSelectTable();
  }
})