$.post("modals/a_modals.php", function (html) {
  $("#modals-js").html(html);
}).done(function () {
  // Modal para agregar estudio
  $.getScript("modals/js/estu_agregar_estudio.js");
  $.getScript("modals/js/gp_rellenar_estudio.js");


  getAreaUnValor('metodos', 'metodo', 'laboratorio_metodos_api', 'ID_METODO', '#MODAL_METODOS_VISTA')

  getAreaUnValor('maquila', 'maquila', 'laboratorio_maquila_api', 'ID_LABORATORIO', '#MODAL_MAQUILA_VISTA')



  //METODOS
  // generarCatalogoModal(
  //   CONTENT = {
  //     divContenedor: '#MODAL_METODOS_VISTA',
  //     ID_CATALOGO: 'ID_METODO',
  //     titulos: {
  //       IDSDIVS: 'metodo',
  //       HeaderTitle: 'Catalogo de metodos',
  //       titulo: 'metodo',
  //       titulos: 'metodos'
  //     },
  //     formLabels: {
  //       DESCRIPCION: {
  //         LABEL: 'Nombre del metodo',
  //         STRING: 'DESCRIPCION',
  //         CLASS: {
  //           input: '',
  //           div: 'col-12'
  //         }
  //       }
  //     },
  //     tableContent: {
  //       COUNT: {
  //         HEADER: '#',
  //         ID: 'COUNT',
  //         CLASS: ''
  //       },
  //       DESCRIPCION: {
  //         HEADER: 'DESCRIPCION',
  //         ID: 'DESCRIPCION',
  //         CLASS: ''
  //       },
  //       ACTIVO: {
  //         HEADER: '<i class="bi bi-collection"></i>',
  //         ID: 'ACTIVO',
  //         CLASS: ''
  //       }
  //     },
  //     diseño: {
  //       MODALCLASS: 'modal-lg modal-dialog-centered modal-dialog-scrollable',
  //     },
  //   },
  //   ajax = {
  //     table: {
  //       data: {
  //         api: 2, ACTIVO: 1
  //       },
  //       api_url: 'laboratorio_metodos_api',
  //       dataSrc: 'response.data',
  //     },

  //     registrar: {
  //       data: {
  //         api: 1
  //       },
  //       api_url: 'laboratorio_metodos_api',
  //       dataSrc: 'response.data',
  //     },
  //     editar: {
  //       data: {
  //         api: 4
  //       },
  //       api_url: 'laboratorio_metodos_api',
  //       dataSrc: 'response.data',
  //     },
  //     desactivar: {
  //       data: {
  //         api: 5
  //       },
  //       api_url: 'laboratorio_metodos_api',
  //       dataSrc: 'response.data',
  //     }

  //   },
  // )
});
