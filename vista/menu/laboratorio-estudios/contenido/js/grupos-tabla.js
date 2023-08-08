var tablaGrupos = $('#TablaGruposServicios').DataTable({
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
  },
  scrollY: autoHeightDiv(0, 345), //347px  scrollCollapse: true,
  scrollCollapse: true,
  lengthMenu: [[15, 20, 25, 30, 35, 40, 45, 50, -1], [15, 20, 25, 30, 35, 40, 45, 50, "All"]],
  ajax: {
    dataType: 'json',
    data: { api: 7 },
    method: 'POST',
    url: '../../../api/servicios_api.php',
    beforeSend: function () { loader("In") },
    complete: function () { loader("Out") },
    dataSrc: 'response.data'
  },
  columns: [
    { data: 'COUNT' },
    { data: 'DESCRIPCION' },
    { data: 'CLASIFICACION_EXAMEN' },
    { data: 'DESCRIPCION_AREA' },
    { data: 'ACTIVO' },
    // {defaultContent: 'En progreso...'}
  ],
  columnDefs: [
    { "width": "3px", "targets": [0, 4] },
  ],

  dom: 'Blfrtip',
  buttons: [
    {
      text: '<i class="bi bi-pencil-square"></i> Editar',
      className: 'btn btn-pantone-7408',
      action: function () {
        if (array_selected != null) {
          getDataFirst(1, array_selected['ID_SERVICIO'])
        } else {
          alertSelectTable();
        }
      }
    },
    {
      text: '<i class="bi bi-box-seam"></i> Rellenar Grupo',
      className: 'btn btn-pantone-7408',
      action: function () {
        if (array_selected != null) {
          firstDataModal();
        } else {
          alertSelectTable();
        }
      }
    },
  ],

})


selectDatatable("TablaGruposServicios", tablaGrupos, 1, 'servicios_api', 'estudio')
