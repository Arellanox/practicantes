$.post("modals/m_recepcion.php", function (html) {
  $("#modals-js").html(html);
}).done(function () {
  $.getScript(`${http}${servidor}/${appname}/vista/include/modal/js/editar-paciente.js`);
});