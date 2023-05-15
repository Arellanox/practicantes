var tablaUsuarios = $('#TablaUsuariosAdmin').DataTable({
  processing: true,
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    loadingRecords: '&nbsp;',
    processing: '<div class="spinner"></div>'
  },
  scrollY: "60vh",
  scrollCollapse: true,
  lengthMenu: [[10, 15, 20, 25, 30, 35, 40, 45, 50, -1], [10, 15, 20, 25, 30, 35, 40, 45, 50, "All"]],
  ajax: {
    dataType: 'json',
    data: { api: 2 },
    method: 'POST',
    url: '../../../api/usuarios_api.php',
    beforeSend: function () { loader("In") },
    complete: function () {
      completeTable()
    },
    dataSrc: 'response.data'
  },
  columns: [
    { data: 'count' },
    { data: 'nombrecompleto' },
    { data: 'USUARIO' },
    { data: 'cargo' },
    { data: 'tipo' },
    {
      data: 'ID_USUARIO', render: function (data) {
        return `<select name="area_fisica" class="input-form area_fisica-usuario" data-bs-id ="${data}"></select>`;
      }
    },
    { data: 'ACTIVO' },
    { data: 'PROFESION' },
    { data: 'CEDULA' },
    { data: 'TELEFONO' },
    { data: 'CORREO' },
    // {defaultContent: 'En progreso...'}
  ],
  columnDefs: [
    { width: "3px", targets: 0 },
    { width: "3px", targets: 6 },
    { width: "20%", targets: 1 },
    { width: "150px", targets: 5 }
  ],

})
selectDatatable("TablaUsuariosAdmin", tablaUsuarios)

async function completeTable() {
  await rellenarSelect('.area_fisica-usuario', 'tipos_usuarios_api', 2, 0, 1); // <-- Rellena los select de los usuarios
  loader("Out");
}