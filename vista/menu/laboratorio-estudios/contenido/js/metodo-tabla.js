
var TablaMetodos = $('#TablaMetodos').DataTable({
  processing: true,
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    loadingRecords: '&nbsp;',
    processing: '<div class="spinner"></div>'
  },
  lengthMenu: [[5, 10, -1], [5, 10, "All"]],
  autoWidth: false,
  searching: false,
  lengthChange: false,
  info: false,
  paging: false,
  scrollY: "30vh",
  scrollCollapse: true,
  ajax: {
    dataType: 'json',
    data: { api: 2 },
    method: 'POST',
    url: '../../../api/laboratorio_metodos_api.php',
    beforeSend: function () { loader("In") },
    complete: function () { loader("Out") },
    dataSrc: 'response.data'
  },
  columns: [
    { data: 'COUNT' },
    { data: 'DESCRIPCION' },
    { data: 'ACTIVO' },
    // {defaultContent: 'En progreso...'}
  ],
  columnDefs: [
    { "width": "3px", "targets": 0 },
  ],

})

// $('#TablaMetodos tbody').on('click', 'tr', function () {
//    if ($(this).hasClass('selected')) {
//        $(this).removeClass('selected');
//        array_selected = null;
//    } else {
//        TablaMetodos.$('tr.selected').removeClass('selected');
//        $(this).addClass('selected');
//        array_selected = TablaMetodos.row( this ).data();
//    }
// });


$('#TablaMetodos tbody').on('dblclick', 'tr', function () {
  if ($(this).hasClass('selected')) {
    $(this).removeClass('selected');
    array_metodo = null;
    cambiarFormMetodo(0);
  } else {
    TablaMetodos.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');
    array_metodo = TablaMetodos.row(this).data();
    // console.log(array_metodo);
    document.getElementById("edit-metodo-descripcion").value = array_metodo[1];
    var data = TablaMetodos.row(this).data();
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
    document.getElementById("formEditarmetodo").reset();
    $('#editarMetodoCol').fadeOut();
    setTimeout(function () {
      $('#RegistrarMetodoCol').fadeIn();
    }, 400);
  }
}
