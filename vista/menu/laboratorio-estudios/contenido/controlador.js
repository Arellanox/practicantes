
if (validarVista('ESTUDIOS_LABORATORIO')) {
  //Menu predeterminado
  hasLocation();
  $(window).on("hashchange", function (e) {
    hasLocation();
  });
}

// Variable de seleccion de metodo
var array_metodo, numberContenedor = 0, numberContenedorEdit = 0, numberContenedorGrupo = 0, numberContenedorGrupoEdit = 0;
var idMetodo = null;
var modalEdit, formEstudios;
var infoServicioEdit = false;



function obtenerContenidoEstudios(titulo) {
  obtenerTitulo(titulo); //Aqui mandar el nombre de la area
  $.post("contenido/estudios.php", function (html) {
    var idrow;
    $("#body-js").html(html);
    // Datatable
    $.getScript("contenido/js/estudio-tabla.js");

  });
}

function obtenerContenidoGrupos(titulo) {
  obtenerTitulo(titulo); //Aqui mandar el nombre de la area
  $.post("contenido/grupos.php", function (html) {
    var idrow;
    $("#body-js").html(html);
    // Datatable
    $.getScript("contenido/js/grupos-tabla.js");

    // Botones
    $.getScript("contenido/js/grupos-botones.js");
  });
}

//Get scripts
// Botones
$.getScript("contenido/js/estudio-botones.js");




//Consultar Controlador modals
// // Datatable Metodo
// $.getScript("contenido/js/metodo-tabla.js");
// // Metodo botones
// $.getScript("contenido/js/metodo-botones.js");


function agregarContenedorMuestra(div, numeroSelect, tipo) {
  let startRow = '<div class="row">';
  let startDivSelect = '<div class="col-5 col-md-5">';
  let startDivButton = '<div class="col-2 d-flex justify-content-start align-items-center">';
  let endDiv = '</div>';
  numeroSelect = getRandomInt(10000000000000)

  // <label for="contenedores[contenedor-uno[]]" class="form-label">Contenedor</label>
  // <select name="contenedores[contenedor-uno[]]" id="registrar-contenedor1-estudio" required></select>

  html = startRow + startDivSelect + '<label for="contenedores[' + numeroSelect + '][contenedor]" class="form-label select-contenedor">Contenedor</label>' +
    '<select name="contenedores[' + numeroSelect + '][contenedor]" id="registrar-contenedor' + numeroSelect + '-estudio" class="input-form" required>' +
    '<option value="1">Frasco</option><option value="2">Tubo azul</option><option value="3">Tubo lila</option><option value="4">Tubo rojo</option>' +
    '<option value="5">Tubo negro</option><option value="6">Tubo verde</option><option value="7">Transcult</option>' +
    '</select>' + endDiv + startDivSelect +
    '<label for="contenedores[' + numeroSelect + '][muestra]" class="form-label select-contenedor">Tipo o muestra</label>' +
    '<select name="contenedores[' + numeroSelect + '][muestra]"  id="registrar-muestraCont' + numeroSelect + '-estudio" class="input-form" required placeholder="Seleccione un contenedor">' +
    '<option value="1">EXPECTORACIÓN</option>' +
    '<option value="2">EXUDADO</option>' +
    '<option value="3">HECES</option>' +
    '<option value="4">LÍQUIDO</option>' +
    '<option value="5">ORINA</option>' +
    '<option value="6">SANGRE</option>' +
    '<option value="7">SEMEN</option>' +
    '<option value="8">UÑAS</option>' +
    '</select>' + endDiv +
    startDivButton + '<button type="button" class="btn btn-hover eliminarContenerMuestra' + tipo + '" data-bs-contenedor="' + numeroSelect + '" style="margin-top: 20px;"><i class="bi bi-trash"></i></button>' + endDiv + endDiv;
  $(div).append(html);
  recargarSelects()
  return {
    0: `${'contenedores[' + numeroSelect + '][contenedor]'}`,
    1: `contenedores[${numeroSelect}][muestra]`
  };
}

function agregarHTMLSelectorInput(div, label, relleno, editID = null, cantidad = null) {
  let id = getRandomInt(1000000000)
  classSelect = `input-form select-contenedor-${label}`
  html = '<div class="row">' +
    '<div class="col-12 col-lg-12 col-xxl-6">' +
    '<label for="grupoExamen[' + id + '][grupo_id]" class="form-label">' + label + '</label>' +
    '<select name="grupoExamen[' + id + '][grupo_id]" class="' + classSelect + '" required="">';

  html += `${relleno}`;
  // console.log(cantidad, editID)
  let classInput = `form-control input-form`;
  html += '</select>' +
    '</div>' +
    '<div class="col-12 col-lg-8 col-xxl-4">' +
    '<label for="grupoExamen[' + id + '][orden]" class="form-label">Posicion del grupo</label>' +
    '<input type="text" placerholder="Orden del servicio para el grupo" name="grupoExamen[' + id + '][orden]" ' +
    'class="' + classInput + '" value="' + ifnull(cantidad, '') + '" required>' +
    '</div>' +
    '<div class="col-2 d-flex justify-content-start align-items-center">' +
    '<button type="button" class="btn btn-hover eliminarContenerMuestra1" data-bs-contenedor="2" style="margin-top: 20px;" >' +
    '<i class="bi bi-trash"></i>' +
    '</button>' +
    '</div>' +
    '</div>';
  $(div).append(html);
  recargarSelects()
  return 'grupoExamen[' + id + '][grupo_id]';
}

function agregarHTMLSelector(div, label, relleno) {

  let id = getRandomInt(1000000000)
  html = '<div class="row">' +
    '<div class="col-10 col-md-10">' +
    '<label for="' + label + '[' + id + ']" class="form-label">' + label + '</label>' +
    '<select name="' + label + '[' + id + ']" class="input-form select-contenedor-' + label + '" required="">';

  html += `${relleno}`;

  html += '</select>' +
    '</div>' +
    '<div class="col-2 d-flex justify-content-start align-items-center">' +
    '<button type="button" class="btn btn-hover eliminarContenerMuestra1" data-bs-contenedor="2" style="margin-top: 20px;">' +
    '<i class="bi bi-trash"></i>' +
    '</button>' +
    '</div>' +
    '</div>';
  $(div).append(html);
  recargarSelects();
  return `${label}[${id}]`;
}

function recargarSelects(grupo = false) {
  if (grupo) {
    rellenarSelect('.select-contenedor-Grupo', 'servicios_api', 7, 0, 'DESCRIPCION', { id_area: 6 }, function (data, o) {
      rellenoGrupoSelect = o
    })
  } select2("#registrar-clasificacion-estudio", "ModalRegistrarEstudio");

  select2("#registrar-medidas-estudio", "ModalRegistrarEstudio");
  select2("#registrar-concepto-facturacion", "ModalRegistrarEstudio");

  select2("#registrar-contenedor1-estudio", "ModalRegistrarEstudio");
  select2("#registrar-muestraCont1-estudio", "ModalRegistrarEstudio");

  select2('.select-contenedor-equipo', 'ModalRegistrarEstudio');
  select2('.select-contenedor-Método', 'ModalRegistrarEstudio');
  select2('.select-contenedor-Grupo', 'ModalRegistrarEstudio');

}



function hasLocation() {
  var hash = window.location.hash.substring(1);
  $("a").removeClass("navlinkactive");
  $("nav li a[href='#" + hash + "']").addClass("navlinkactive");
  switch (hash) {
    case "EstudiosLab":
      // if (validarVista('SERVICIOS (ESTUDIOS)')) {
      obtenerContenidoEstudios("Estudios - Laboratorio");
      // }
      break;
    case "GruposLab":
      // if (validarVista('SERVICIOS (GRUPOS)')) {
      obtenerContenidoGrupos("Grupos de estudios - Laboratorio");
      // }
      break;
    // case "Equipos":
    //   if (validarVista('SERVICIOS (EQUIPOS)')) {
    //     obtenerContenidoEquipos("Equipos");
    //   }
    //   break;
    default:
      window.location.hash = 'EstudiosLab';
      // obtenerContenidoEstudios("Estudios");
      break;
  }
}
