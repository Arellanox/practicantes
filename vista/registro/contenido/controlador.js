// obtenerContenido o cambiar
obtenerContenido("registro.php");

function obtenerContenido(tabla) {
  $.post("contenido/" + tabla, function (html) {
    $("#body-js").html(html);
  }).done(function (html) {
    switch (tip) {
      case 'pie':
        $('#vista-botones').html('<button class="btn btn-lg" type="button" id="box2" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPaciente"><i class="bi bi-clipboard-heart"></i> Quiero generar mi cita</button>');
        // $('#detalle-registro').html('Asegúrese que toda su información esté correcta. <br/> Al guardar su información personal, se crea automaticamente su agenda para el servicio <br /> Utilice su <strong>CURP</strong> o <strong>PASAPORTE</strong> para futuros registros.');
        break;
      default:
        $('#vista-botones').html('<button class="btn btn-lg" type="button" id="box1" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPrueba"><i class="bi bi-clipboard-heart"></i> Quiero generar una cita</button>');
        break;
    }
  });
}