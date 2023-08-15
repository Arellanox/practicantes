$.post("modals/m_recepcion.php", function (html) {
  $("#modals-js").html(html);
}).done(function () {
  // Modal para aceptar
  $.getScript('modals/js/p_aceptar.js').done(function () {
    //  //Modal para vista de servicios
    $.getScript(`modals/js/vista-servicios.js`);
  });
  // Modal para rechazar
  $.getScript('modals/js/p_rechazar.js');
  // Modal para reagendar
  $.getScript('modals/js/p_reagendar.js');
  // Modal para subir avatar
  $.getScript('modals/js/subir-perfil.js');
  // Modal para cargar ine
  $.getScript('modals/js/cargar-ine_paciente.js');
  // Modal para cargar ordenes medicas
  $.getScript('modals/js/carga-ordenes-medicas.js');
  // Modal para solicitud
  $.getScript('modals/js/p_solicitud.js');
  // // Modal para registar una agenda
  $.getScript('modals/js/p_registro.js');
  $.getScript(`${http}${servidor}/${appname}/vista/include/modal/js/registrar-agenda.js`);
  $.getScript(`${http}${servidor}/${appname}/vista/include/modal/js/registrar-paciente.js`);
  $.getScript(`${http}${servidor}/${appname}/vista/include/modal/js/editar-paciente.js`);

  $.getScript(`${http}${servidor}/${appname}/vista/include/funciones/facturacion-pacientes/js/estudios-contado.js`);


  $.getScript(`modals/js/ujat-beneficiarios.js`)

  $.getScript(`modals/js/p_actualizar_estudios.js`);

  $.getScript(`modals/js/qr-clientes.js`);
});