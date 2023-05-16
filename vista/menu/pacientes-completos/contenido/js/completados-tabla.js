tablaCompletados = $('#TablaRecepcionPacientes-Ingresados').DataTable({
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
  },
  scrollY: autoHeightDiv(0, 332), //347px
  scrollCollapse: true,
  lengthMenu: [
    [20, 25, 30, 35, 40, 45, 50, -1],
    [20, 25, 30, 35, 40, 45, 50, "All"]
  ],
  ajax: {
    dataType: 'json',
    data: function (d) {
      return $.extend(d, dataRecepcion);
    },
    method: 'POST',
    url: '../../../api/turnos_api.php',
    beforeSend: function () {
      loader("In", 'bottom'), array_selected = null
    },
    complete: function () {
      loader("Out", 'bottom')
      obtenerPanelInformacion(0, 'paciente_api', 'paciente')
      obtenerPanelInformacion(0, 'consulta_api', 'listado_resultados', '#panel-resultados')
      obtenerPanelInformacion(0, false, 'Estudios_Estatus', '#estudios_concluir_paciente')
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alertErrorAJAX(jqXHR, textStatus, errorThrown);
    },
    dataSrc: 'response.data'
  },
  createdRow: function (row, data, dataIndex) {
    if (data.REAGENDADO == 1) {
      $(row).addClass('bg-info');
    }
  },
  columns: [
    { data: 'COUNT' },
    { data: 'NOMBRE_COMPLETO' },
    { data: 'PREFOLIO', },
    {
      data: 'NOMBRE_COMERCIAL',
      render: function (data) {
        switch (data) {
          case 'Particular': case 'PARTICULAR':
            return `<p class="fw-bold" style="letter-spacing: normal !important;">${data}</p>`;
          default:
            return data;
        }
      }
    },
    { data: 'DESCRIPCION_SEGMENTO' },
    { data: 'TURNO' },
    {
      data: 'ID_PACIENTE',
      render: function (data) {
        return 'PENDIENTE';
      }
    },
    // {
    //   data: 'ESTADO_ANALISIS',
    //   render: function (data) {
    //     switch (data) {
    //       case 'Terminado':
    //         return '<p class="text-primary fw-bold" style="letter-spacing: normal !important;">' + data + '</p>';
    //       case 'En proceso':
    //         return '<p class="text-warning fw-bold" style="letter-spacing: normal !important;">' + data + '</p>';
    //       default:
    //         return '';
    //     }
    //   }
    // },
    // {
    //   data: 'ESTADO_MUESTRA',
    //   render: function (data) {
    //     switch (data) {
    //       case 'Tomada':
    //         return '<p class="text-success fw-bold" style="letter-spacing: normal !important;">' + data + '</p>';
    //       case 'Sin tomar':
    //         return '<p class="text-warning fw-bold" style="letter-spacing: normal !important;">' + data + '</p>';
    //       default:
    //         return '';
    //     }
    //   }
    // },
    {
      data: 'FECHA_RECEPCION',
      render: function (data) {
        return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
      }
    },
    {
      data: 'FECHA_AGENDA',
      render: function (data) {
        return formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null);
      }
    },
    {
      data: 'FECHA_REAGENDA',
      render: function (data) {
        return '<p class="text-primary fw-bold" style="letter-spacing: normal !important;">' + formatoFecha2(data, [0, 1, 5, 2, 0, 0, 0], null) + '</p>';

      }
    },
    { data: 'GENERO' },
    {
      data: 'COMPLETADO', render: function (data) {
        if (servidor == 'drjb.com.mx' && data == 1)
          return '<p class="fw-bold text-success" style="letter-spacing: normal !important;">Finalizade</p>'

        return data == 1 ? '<p class="fw-bold text-success" style="letter-spacing: normal !important;">Finalizados</p>' : '<p class="fw-bold text-warning" style="letter-spacing: normal !important;">En proceso</p>';
      }
    },
    {
      data: 'COUNT', render: function () {
        let html = `
          <div class="row">
            <div class="col-4" style="max-width: max-content; padding: 0px; padding-left: 3px; padding-right: 3px;">
              <i class="bi bi-pencil-square btn-editar" style="cursor: pointer; font-size:18px;"></i>
            </div>
        `;

        html += `</div>`;
        return html
      }
    },
    // {defaultContent: 'En progreso...'}
  ],
  columnDefs: [
    { width: "5px", targets: 0 },
    { visible: false, title: "AreaActual", targets: 6, searchable: false },
    { target: 11, width: 'auto' },
    { target: 12, width: "5px" }

  ],

})

inputBusquedaTable('TablaRecepcionPacientes-Ingresados', tablaCompletados, [])

selectDatatable("TablaRecepcionPacientes-Ingresados", tablaCompletados, 1, 0, 0, 0, async function (select, data) {
  if (select) {

    obtenerPanelInformacion(data['ID_TURNO'], 'paciente_api', 'paciente')
    obtenerPanelInformacion(data['ID_TURNO'], 'consulta_api', 'listado_resultados', '#panel-resultados')
    await obtenerPanelInformacion(1, false, 'Estudios_Estatus', '#estudios_concluir_paciente')

    if (data['COMPLETADO'] == 1) {
      $('#contenedor-btn-cerrar-paciente').html(`
        <button type="button" class="btn btn-pantone-325 me-2" style="margin-bottom:4px" id="btn-concluir-paciente" data-concluir="0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Abra el proceso del paciente para agregar mas pruebas">
            <i class="bi bi-person-check"></i> Abrir proceso
        </button>
    `)
      $('#btn-agregar_eliminar-estudios').prop('disabled', true)
    } else {
      $('#contenedor-btn-cerrar-paciente').html(`
        <button type="button" class="btn btn-pantone-325 me-2" style="margin-bottom:4px" id="btn-concluir-paciente"
            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Finaliza el proceso del paciente">
            <i class="bi bi-person-check"></i> Finalizar Paciente
        </button>
    `)
      $('#btn-agregar_eliminar-estudios').prop('disabled', false)
    }

    if (array_selected['CLIENTE_ID'] == 18) {
      $('#buttonBeneficiario').fadeIn(200)
    } else {
      $('#buttonBeneficiario').fadeOut(200);
    }
  } else {
    obtenerPanelInformacion(0, 'paciente_api', 'paciente')
    obtenerPanelInformacion(0, 'consulta_api', 'listado_resultados', '#panel-resultados')
    await obtenerPanelInformacion(0, false, 'Estudios_Estatus', '#estudios_concluir_paciente')
  }
}, async function (data) {
  alertToast('Obteniendo datos...', 'info', 4000);
  await obtenerPanelInformacion(data['ID_TURNO'], 'documentos_api', 'lista-documentos-paciente', '#panel-documentos-paciente')
  await obtenerPanelInformacion(data['ID_TURNO'], 'toma_de_muestra_api', 'estudios_muestras', '#panel-muestras-estudios')

  var myOffcanvas = document.getElementById('offcanvasInfoPaciente')
  var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
  bsOffcanvas.show()

})

autoHeightDiv('#panel-informacion-pacientesTurnos', 188)