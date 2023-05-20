<?php
$menu = $_POST['menu'];
$tipoUrl = isset($_POST['tipoUrl']) ?  $_POST['tipoUrl'] : 1;
$tip = $_POST['tip'];
date_default_timezone_set('America/Mexico_City');
session_start();
include "../../variables.php";
?>

<!-- HTML -->
<header id="header-js"></header>
<div id="titulo-js"></div>
<div class="container-fluid " id="body-js">
  <div class="col-12 loader" id="loader">
    <div class="preloader" id="preloader"> </div>
  </div>
</div>
<div class="" id="modals-js"> <!-- Aqui podrán incluir los modals --> </div>


<!-- HTML -->



<script type="text/javascript">
  //Variable global para datatable
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
  const appname = 'practicantes';
  var http = "http://";
  var servidor = "localhost";

  miStorage = window.localStorage;
  miStorage.setItem("Olakace", "HOLA MUNDO XD");
  // <!-- Aqui controlar e incluir las modals -->
  obtenerHeader('<?php echo $menu ?>', '<?php echo $tip ?>');

  function obtenerHeader(menu, tip) {
    $.post("<?php echo $https . $url . '/' . $appname . '/vista/include/header/header.php'; ?>", {
      menu: menu,
      tip: tip
    }, function(html) {
      $("#header-js").html(html);
    });
  }

  function obtenerTitulo(menu, tipo = null) { //Usar async await para no tener problemas con inputs de fecha
    return new Promise(resolve => {
      $.post("<?php echo $https . $url . '/' . $appname . '/vista/include/header/titulo.php'; ?>", {
        menu: menu,
        tipo: tipo
      }, function(html) {
        $("#titulo-js").html(html);
      }).done(function() {
        resolve(1);
      });
    });
  }

  function obtenerAreaActiva() {
    if (typeof areaActual === 'undefined') {
      return areaActiva; //Funciona para la area master, y probablemente para otras...
    }
    return areaActual; // Area actual es para areas independientes coloquen la ID donde pertenecen
  }


  // Carga la vista para entrar a los servicios
  function cargarVistaServiciosPorArea(hash) {
    event.preventDefault()
    subarea = obtenerAreaActiva()
    // Si existe la variable
    // var base64 = new Base64();
    // areaActual = base64.decode(areaActual);
    // $area = isset($_GET['var'])? $_GET['var']: 0;
    switch (subarea) {
      case 6:
        cargarVistaServiciosPorAreaURL(hash, 'laboratorio-servicios');
        break;
      case 3:
      case 4:
      case 5:
      case 7:
      case 8:
      case 9:
        let base64 = new Base64();
        var s = base64.encode(subarea); // BJlgLS
        // var n = base64.decode('BJlgLS'); 
        cargarVistaServiciosPorAreaURL(hash, 'area-servicios', '?var=' + s);
        break;
      default:
        break;
    }
  }

  function cargarVistaServiciosPorAreaURL(hash, ubicacion, variables = '') {
    switch (hash) {
      case 'Estudios':
        window.location.href = `${http}${servidor}/${appname}/vista/menu/${ubicacion}/${variables}#Estudios`;
        break;
      case 'Grupos':
        window.location.href = `${http}${servidor}/${appname}/vista/menu/${ubicacion}/${variables}#Grupos`;
        break;
    }
  }

  let array_selected;
  let array_user;
  var validar;
  const session = <?php echo json_encode($_SESSION); ?>;
  // session['id'] = '';
  session['token'] = '';

  // ontooltip(); // <-- Ejecutar los tooltip en todo momento
  // function ontooltip() {
  var delay = 100,
    setTimeoutConst;
  $(document).on({
    mouseenter: function(e) {
      tool = this;
      setTimeotConst = setTimeout(function() {
        return new bootstrap.Tooltip(tool).show();
      }, delay)
    },
    mouseleave: function(e) {
      clearTimeout(setTimeotConst)
      $('[role="tooltip"]').fadeOut(100, function() {
        $(this).remove();
      });
    },
  }, '[data-bs-toggle="tooltip"]')


  // }



  $.getScript("<?php echo $https . $url . '/' . $appname . '/vista/menu/controlador/class.js'; ?>").done(function() {
    $.getScript("<?php echo $https . $url . '/' . $appname . '/vista/menu/controlador/funciones.js'; ?>").done(function() {
      loggin(function(val) {
        if (val) {
          $(function() {
            // console.log(session)
            // <!-- Aqui controlar e incluir las modals -->
            $.getScript('contenido/controlador.js').done(function(data) {
              console.log(validar);
              if (validar == true) {
                // <!-- Aqui controlar e incluir los tablas -->
                $.getScript('modals/controlador.js').done(function() {}); // !!Algunos modals de algunas areas no usan la calse GuardarArreglo.!!
              }
            });
          })
        }
      }, <?php echo $tipoUrl; ?>)
    });
  });
</script>