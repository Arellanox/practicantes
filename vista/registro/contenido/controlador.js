// obtenerContenido o cambiar
obtenerContenido("registro.php");

function obtenerContenido(tabla) {
  $.post("contenido/" + tabla, async function (html) {
    $("#body-js").html(html);
    await obtenerTitulo(`${traducir('Pre-registro', language)}`);
  }).done(function (html) {
    switch (tip) {
      case 'pie':
        $('#vista-botones').html(`<button class="btn btn-lg" type="button" id="box2" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPaciente"><i class="bi bi-clipboard-heart"></i>${traducir('Quiero generar mi cita', language)}</button>`);
        // $('#detalle-registro').html('Asegúrese que toda su información esté correcta. <br/> Al guardar su información personal, se crea automaticamente su agenda para el servicio <br /> Utilice su <strong>CURP</strong> o <strong>PASAPORTE</strong> para futuros registros.');
        break;
      default:
        $('#vista-botones').html(`<button class="btn btn-lg" type="button" id="box1" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPrueba"><i class="bi bi-clipboard-heart"></i> ${traducir('Quiero generar mi cita', language)}</button>`);
        break;
    }
  });
}