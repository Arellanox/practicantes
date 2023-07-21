$.post("modals/m_soporteTi.php", function (html, data) {
    $("#modals-js").html(html);

    $.getScript('modals/js/modal-atencion.js')

  });
  