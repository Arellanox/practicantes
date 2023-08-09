var tablaServicio = $('#TablaEstudioServicio').DataTable({
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
  },
  scrollY: autoHeightDiv(0, 330), //347px  scrollCollapse: true,
  lengthMenu: [[15, 20, 25, 30, 35, 40, 45, 50, -1], [15, 20, 25, 30, 35, 40, 45, 50, "All"]],
  ajax: {
    dataType: 'json',
    data: { api: 2, id_area: 6, tipgrupo: 0 },
    method: 'POST',
    url: '../../../api/servicios_api.php',
    beforeSend: function () { loader("In") },
    complete: function () { loader("Out") },
    dataSrc: ''
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
    // { width: '100%' },
    { "width": "3px", "targets": [0, 4] },
  ],

})

selectDatatable("TablaEstudioServicio", tablaServicio, 1, 'servicios_api', 'estudio', '#panel-informacion', function (select, selectData) {

  if (select) {
    obtenerPanelInformacion(1, 'servicios_api', 'estudio');

    //   console.log(select);
    //   infoServicioEdit = getInfoServicioLab(select['ID_SERVICIO']);
    //   console.log(infoServicioEdit)
    //   // obtenerPanelInformacion(1, infoServicioEdit, 'signos-vitales', '#signos-vitales'); //<-- en la opcion 2 mando arreglo, pero deberia estar la api donde ira, pero el case necesita la info, no busca en ajax
  } else {

    //   infoServicioEdit = false;
    //   // obtenerPanelInformacion(0, null, 'signos-vitales', '#signos-vitales'); //<-- en la opcion 2 mando arreglo, pero deberia estar la api donde ira, pero el case necesita la info, no busca en ajax

  }

})

selectDatatable("TablaEstudioServicio", tablaServicio, 1, 'servicios_api', 'estudio')

inputBusquedaTable('TablaEstudioServicio', tablaServicio, false)

