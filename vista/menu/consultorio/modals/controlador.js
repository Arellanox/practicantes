$.post("modals/a_modals.php", function (html) {
  $("#modals-js").html(html);


  // $.getScript('modals/js/modal_consulta.js')
  // Modal para crear consulta
  $.getScript('modals/js/motivo-consulta.js');

  // Modal para crear consulta medica
  $.getScript('modals/js/motivo-consulta-medica.js');
});
