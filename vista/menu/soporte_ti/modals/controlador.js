$.post("modals/m_soporteTi.php", function (html, ticket) {
    $("#modals-js").html(html);
  ajaxAwait({ api: 2 }, 'asistencia_ti_bot_api', { callbackAfter: true }, false, function (data) {
    row = data.response.data['0']

    $.getScript('modals/js/modal-atencion.js')
    // console.log(row);
  })


  });
  