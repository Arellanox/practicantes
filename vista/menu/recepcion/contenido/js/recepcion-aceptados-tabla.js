tablaRecepcionPacientesIngrersados = $('#TablaRecepcionPacientes-Ingresados').DataTable({
  language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
  scrollY: '56vh', //347px
  scrollCollapse: true,
  deferRender: true,
  lengthMenu: [[15, 20, 25, 30, 35, 40, 45, 50, -1], [15, 20, 25, 30, 35, 40, 45, 50, "All"]],
  ajax: {
    dataType: 'json',
    data: function (d) { return $.extend(d, dataRecepcion); },
    method: 'POST',
    url: '../../../api/recepcion_api.php',
    beforeSend: function () {
      loader("In")
      array_selected = null
      tablaRecepcionPacientesIngrersados.columns.adjust().draw()
    },
    complete: function () {
      loader("Out")

      //Para ocultar segunda columna
      // reloadSelectTable()

      obtenerPanelInformacion(0, 'paciente_api', 'paciente')
      obtenerPanelInformacion(0, 'consulta_api', 'listado_resultados', '#panel-resultados')
      obtenerPanelInformacion(0, false, 'Estudios_Estatus', '#estudios_concluir_paciente')
      obtenerPanelInformacion(0, false, 'area_faltantes', '#panel-areas-faltantes')
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
    // {
    //   data: 'ID_PACIENTE',
    //   render: function (data) {
    //     return 'PENDIENTE';
    //   }
    // },
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

        const formattedDate = formatoFecha2(data, [0, 1, 5, 2, 2, 2, 0], null); // Tu función existente

        // Separar la fecha y la hora basado en la coma
        const parts = formattedDate.split(', ');
        const datePart = parts[0];
        const timePart = parts[1];

        // Retornar la fecha y la hora envueltas en spans con las clases correspondientes
        return `
            <span class="d-block">${datePart}</span>
            <span class="d-block">${timePart}</span>
        `;
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

        return data == 1 ? '<p class="fw-bold text-success" style="letter-spacing: normal !important;">Finalizado</p>' : '<p class="fw-bold text-warning" style="letter-spacing: normal !important;">En proceso</p>';
      }
    },
    { data: null },
    // {defaultContent: 'En progreso...'}
  ],
  columnDefs: [
    { targets: 0, title: '#', className: 'all', width: '1%' },
    { targets: 1, title: 'Nombre', className: 'all nombre', width: '30%' },
    { targets: 2, title: 'Prefolio', className: 'none' },
    { targets: 3, title: 'Procedencia', className: 'min-tablet', width: '15%' },
    { targets: 4, title: 'Segmento', className: 'desktop', width: '15%' },
    { targets: 5, title: 'Turno', className: 'none' },
    { targets: 6, title: 'Recepción', className: 'all', width: '8%' },
    { targets: 7, title: 'Agenda', className: 'min-tablet', width: '8%' },
    { targets: 8, title: 'Re-agenda', className: 'none' },
    { targets: 9, title: 'Sexo', className: 'none' },
    { targets: 10, title: 'Recepción', className: 'desktop', width: '8%' },
    {
      targets: 11,
      title: '#',
      className: 'all actions',
      width: '1%',
      data: null,
      defaultContent: `
        <div class="d-flex d-lg-block align-items-center" style="max-width: max-content; padding: 0px;">
            <div class="d-flex flex-wrap flex-lg-nowrap align-items-center">
                <i class="bi bi-pencil-square btn-editar d-block" style="cursor: pointer; font-size:16px;padding: 2px 4px;"></i>
                <i class="bi bi-card-heading btn-cargar-documentos d-block" style="cursor: pointer; font-size:16px;padding: 2px 4px;"></i>
                <i class="bi bi-info-circle btn-offcanva d-block" style="cursor: pointer; font-size:16px;padding: 2px 4px;"></i>
            </div>
        </div>
    `
    }
  ],
  dom: 'Bl<"dataTables_toolbar">frtip',
  buttons: [
    // {
    //   text: '<i class="bi bi-receipt-cutoff"></i> Ticket',
    //   className: 'btn btn-secondary',
    //   action: function () {
    //     if (array_selected) {
    //       alertMensaje('info', 'Generando Ticket', 'Podrás visualizar el ticket en una nueva ventana', 'Si la ventana no fue abierta, usted tiene bloqueada las ventanas emergentes')

    //       api = encodeURIComponent(window.btoa('ticket'));
    //       turno = encodeURIComponent(window.btoa(array_selected['ID_TURNO']));
    //       area = encodeURIComponent(window.btoa(16));


    //       window.open(`${http}${servidor}/${appname}/visualizar_reporte/?api=${api}&turno=${turno}&area=${area}`, "_blank");


    //     } else {
    //       alertToast('Por favor, seleccione un paciente', 'info', 4000)
    //     }
    //   }
    // },
    {
      text: '<i class="bi bi-calendar2-event"></i> Re-agendar paciente',
      className: 'btn btn-pantone-325',
      attr: {
        'data-bs-toggle': "tooltip",
        'data-bs-placement': "top",
        title: "Cambie la fecha de agenda del paciente si es necesario"
      },
      action: function () {
        setTimeout(() => {
          if (array_selected != null) {
            $("#modalPacienteReagendar").modal('show');
          } else {
            alertSelectTable('No ha seleccionado ningún paciente', 'error')
          }
        }, 300);
      }
    },
    {
      text: '<i class="bi bi-person-lines-fill"></i> Deshacer ingreso',
      className: 'btn btn-option',
      attr: {
        'data-bs-toggle': "tooltip",
        'data-bs-placement': "top",
        title: "Mande en espera al paciente y elimina la carga de estudios"
      },
      action: function () {
        setTimeout(() => {
          if (array_selected) {
            alertMensajeConfirm({
              title: '¿Está Seguro de regresar al paciente en espera?',
              text: "¡Sus estudios anteriores no se cargarán!",
              icon: 'warning', confirmButtonText: 'Si, colocarlo en espera',
            }, () => {
              ajaxAwait({
                id_turno: array_selected['ID_TURNO'], api: 2,// estado: null
              }, 'recepcion_api', { callbackAfter: true }, false, () => {
                alertMensaje('info', '¡Paciente en espera!', 'El paciente se cargó en espera.');
                try { tablaRecepcionPacientes.ajax.reload(); } catch (e) { }
                try { tablaRecepcionPacientesIngrersados.ajax.reload(); } catch (e) { }
              })
            }, 1)
          } else { alertSelectTable('No ha seleccionado ningún paciente', 'error') }
        }, 300);
      }
    },
    {
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel-o"></i> Excel',
      className: 'btn btn-success',
      titleAttr: 'Excel',
      attr: {
        'data-bs-toggle': "tooltip",
        'data-bs-placement': "top",
        title: "Genere el formato por toda la tabla de pacientes o filtrado (Filtrado por: Fecha, Procedencia...)"
      },
      exportOptions: {
        // Especifica las columnas que deseas exportar
        columns: [1, 2, 3, 4, 6, 7, 9, 10]
      }

    },
    {
      text: '<i class="bi bi-save"></i> Beneficiario',
      className: 'btn btn-success',
      attr: {
        'data-bs-toggle': "modal",
        'data-bs-target': "#ModalBeneficiario",
        id: "buttonBeneficiario",
        disabled: true
      },
    },
  ],

})

// setTimeout(() => {
//   $('div.dataTables_toolbar').html(`<div class="row">
//     <div class="col-auto d-flex align-items-center">
//       <label for="fechaListadoAreaMaster" class="form-label">Día de análisis</label>
//     </div>
//     <div class="col-auto d-flex align-items-center">
//       <input type="date" class="form-control input-form" name="fechaListadoAreaMaster" value="2023-08-11" required="" id="fechaListadoAreaMaster">
//     </div>
//     <div class="col-auto d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Visualiza todos los pacientes del area">
//       <input class="form-check-input" type="checkbox" value="" id="checkDiaAnalisis" style="margin: 5px">
//       <label class="form-check-label" for="checkDiaAnalisis">
//         Todos
//       </label>
//     </div>
//   </div>`)
// }, 200);

inputBusquedaTable('TablaRecepcionPacientes-Ingresados', tablaRecepcionPacientesIngrersados, [
  {
    msj: 'Filtra la tabla con palabras u oraciones que coincidan en el campo de busqueda',
    place: 'top'
  },
  {
    msj: `Dale click al icono de lapiz en la tabla para editar la información del paciente`,
    place: 'top'
  },
  {
    msj: 'Doble click a un paciente para obtener la información adicional',
    place: 'top'
  }
], [], 'col-12', 'col-12')


$('#buttonBeneficiario').attr('disabled', false)
// selectDatatable("TablaRecepcionPacientes-Ingresados", tablaRecepcionPacientesIngrersados, 1, 0, 0, 0, async function (select, data) {
selectTable('#TablaRecepcionPacientes-Ingresados', tablaRecepcionPacientesIngrersados,
  {
    unSelect: true, dblClick: true, movil: true,
    tabs: [
      {
        title: 'Pacientes',
        element: '#tab-paciente',
        class: 'active',
      },
      {
        title: 'Información',
        element: '#tab-informacion',
        class: 'disabled tab-select'
      },
    ],
    ClickClass: [
      {
        class: 'btn-editar',
        callback: function (data) {
          if (array_selected != null) {
            $("#ModalEditarPaciente").modal('show');
          } else {
            alertSelectTable();
          }
        },
        selected: true,
      },
      {
        class: 'btn-cargar-documentos',
        callback: function (data) {
          alertMsj({
            icon: '',
            title: 'Documentación del paciente <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Cargue/Guarde la documentación del paciente"></i>',
            footer: 'Seleccione una opción.',
            html: `
                <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px;" id="btn-perfil-paciente">
                  <i class="bi bi-person-bounding-box"></i> Foto de Perfil
                </button>
                <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-credencial-paciente">
                  <i class="bi bi-person-vcard-fill"></i> Credencial
                </button> 
                <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-ordenes-paciente">
                  <i class="bi bi-files"></i> Ordenes médicas
                </button> 
            `,
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: true,
          })
        },
        selected: true,
      },
      {
        class: 'btn-offcanva',
        callback: function (data) {
          dobleClickSelectTableRecepcion(data);
        },
        selected: true,
      },
    ]
  },

  async function (select, data, callback) {
    if (select) {
      // return false;

      if (array_selected['CLIENTE_ID'] == 18) {
        $('#buttonBeneficiario').attr('disabled', false)
      } else {
        $('#buttonBeneficiario').attr('disabled', true);
      }

      obtenerPanelInformacion(data['ID_TURNO'], 'paciente_api', 'paciente')
      obtenerPanelInformacion(data['ID_TURNO'], 'consulta_api', 'listado_resultados', '#panel-resultados')
      obtenerPanelInformacion(data['ID_TURNO'], false, 'area_faltantes', '#panel-areas-faltantes')
      await obtenerPanelInformacion(1, false, 'Estudios_Estatus', '#estudios_concluir_paciente')

      if (data['COMPLETADO'] == 1) {
        $('#contenedor-btn-cerrar-paciente').html(`
        <button type="button" class="btn btn-pantone-325 me-2" style="margin-bottom:4px" disabled>
            <i class="bi bi-person-check"></i> Paciente Cerrado
        </button>
        `)
      } else {
        $('#contenedor-btn-cerrar-paciente').html(`
        <button type="button" class="btn btn-pantone-325 me-2" style="margin-bottom:4px" id="btn-concluir-paciente"
            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Finaliza el proceso del paciente">
            <i class="bi bi-person-check"></i> Finalizar Paciente
        </button>
    `)
      }

      callback('In')
    } else {
      callback('Out')
      $('#buttonBeneficiario').attr('disabled', true);
      obtenerPanelInformacion(0, 'paciente_api', 'paciente')
      obtenerPanelInformacion(0, 'consulta_api', 'listado_resultados', '#panel-resultados')
      obtenerPanelInformacion(0, false, 'Estudios_Estatus', '#estudios_concluir_paciente')
      obtenerPanelInformacion(0, false, 'area_faltantes', '#panel-areas-faltantes')
    }
  }, function (select, data) {
    dobleClickSelectTableRecepcion(data);
  }
)

async function dobleClickSelectTableRecepcion(data) {
  alertToast('Obteniendo datos...', 'info', 4000);
  await obtenerPanelInformacion(data['ID_TURNO'], 'documentos_api', 'lista-documentos-paciente', '#panel-documentos-paciente')
  await obtenerPanelInformacion(data['ID_TURNO'], 'toma_de_muestra_api', 'estudios_muestras', '#panel-muestras-estudios')

  var myOffcanvas = document.getElementById('offcanvasInfoPaciente')
  var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
  bsOffcanvas.show()
}

// selectDatatabledblclick(async function (select, data) {
//   // let dataInfo = data;
//   if (select) {
//     var myOffcanvas = document.getElementById('offcanvasInfoPaciente')
//     var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
//     bsOffcanvas.show()

//   }
// }, '#TablaRecepcionPacientes-Ingresados', tablaRecepcionPacientesIngrersados)


//



// $('')

// autoHeightDiv('#panel-informacion-pacientesTurnos', 188)