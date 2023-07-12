$.post("modals/registro.php", { language: language }, function (html) {
  $("#modals-js").html(html);
}).done(function () {
  // Script de información
  $.getScript(http + servidor + "/nuevo_checkup/vista/include/modal/js/registrar-paciente.js");
  // Script de pruebas
  $.getScript(http + servidor + "/nuevo_checkup/vista/include/modal/js/registrar-agenda.js");
  // $.getScript('modals/js/consultar-prueba.js')


  switch (tip) {
    case 'pie':
      // $('#vista-botones').html('<button class="btn btn-lg" type="button" id="box2" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPaciente"><i class="bi bi-clipboard-heart"></i> Quiero generar mi cita</button>');
      $('#detalle-registro').html('Asegúrese que toda su información esté correcta. <br/> Al guardar su información personal, se crea automaticamente su agenda para el servicio <br /> Utilice su <strong>CURP</strong> o <strong>PASAPORTE</strong> para futuros registros.');
      break;
    default:
      // $('#vista-botones').html('<button class="btn btn-lg" type="button" id="box1" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPrueba"><i class="bi bi-clipboard-heart"></i> Quiero generar una cita</button>');
      break;
  }
});

