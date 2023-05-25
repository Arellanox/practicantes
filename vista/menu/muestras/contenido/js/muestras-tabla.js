tablaMuestras = $('#TablaMuestras').DataTable({
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
  },
  lengthChange: false,
  info: false,
  paging: false,
  scrollY: autoHeightDiv(0, 284),
  scrollCollapse: true,
  ajax: {
    dataType: 'json',
    data: function (d) {
      return $.extend(d, dataListaPaciente);
    },
    method: 'POST',
    url: '../../../api/toma_de_muestra_api.php',
    beforeSend: function () { loader("In") },
    complete: function () {
      loader("Out", 'bottom')
      loaderDiv("Out", null, "#loader-muestras", '#loaderDivmuestras', 0);
      $('.informacion-muestras').fadeOut()
    },
    dataSrc: 'response.data'
  },
  createdRow: function (row, data, dataIndex) {
    if (data.MUESTRA_TOMADA == 1) {
      $(row).addClass('bg-success text-white');
    }
  },
  columns: [
    {
      data: 'ID_PACIENTE', render: function (data) {
        return '';
      }
    },
    { data: 'NOMBRE_COMPLETO' },
    { data: 'PREFOLIO' },
    { data: 'EDAD' },
    { data: 'EDAD' },
    // {defaultContent: 'En progreso...'}
  ],
  columnDefs: [
    { "width": "10px", "targets": 0 },
  ],

})

loaderDiv("Out", null, "#loader-muestras", '#loaderDivmuestras');
selectDatatable('TablaMuestras', tablaMuestras, 0, 0, 0, 0, function (selectTR = null, array = null) {
  selectListaMuestras = array;
  // console.log(selectListaMuestras)
  if (selectTR == 1) {
    if (selectListaMuestras.MUESTRA_TOMADA == 1) {
      $('#muestra-tomado').prop('disabled', true)
      // $('#omitir-paciente').prop('disabled', true)
    } else {
      $('#muestra-tomado').prop('disabled', false)
      // $('#omitir-paciente').prop('disabled', false)
    }
    getPanel('.informacion-muestras', '#loader-muestras', '#loaderDivmuestras', selectListaMuestras, 'In', async function (divClass) {
      await obtenerPanelInformacion(selectListaMuestras['ID_TURNO'], 'pacientes_api', 'paciente', '#panel-informacion', '_lab')
      await obtenerListaEstudiosContenedores(selectListaMuestras['ID_TURNO'])
      // console.log(divClass)
      $(divClass).fadeIn(100);
    });
  } else {
    selectListaMuestras = null;
    getPanel('.informacion-muestras', '#loader-muestras', '#loaderDivmuestras', selectListaMuestras, 'Out')
  }
})

$("#BuscarTablaListaMuestras").keyup(function () {
  tablaMuestras.search($(this).val()).draw();
});

function obtenerListaEstudiosContenedores(idturno = null) {
  return new Promise(resolve => {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/toma_de_muestra_api.php`,
      type: "POST",
      dataType: 'json',
      data: { api: 2, id_turno: idturno },
      success: function (data) {
        let row = data.response.data



        let html = '';
        for (var i = 0; i < row.length; i++) {
          // console.log(row[i]);
          html += '<li class="list-group-item">';
          html += row[i]['GRUPO'];
          html += '<i class="bi bi-arrow-right-short"></i><strong>' + row[i]['MUESTRA'] + '</strong> - <strong>' + row[i]['CONTENEDOR'] + '</strong></li>';

        }
        $('#lista-estudios-paciente').html(html);




      },
      complete: function () {
        loaderDiv("Out", null, "#loader-muestras", '#loaderDivmuestras');
        resolve(1);
      }
    });
  });
}


//Panel turnos, mandar id fisica al  principio
obtenerPanelInformacion(7, null, "turnos_panel", '#turnos_panel')