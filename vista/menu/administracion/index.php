<?php
//Variables dinamicas;

session_start();
include "../../variables.php";
$menu = "Usuarios";
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
  <?php include "../../include/head.php"; ?>
  <title>Administración | Bimo</title>
</head>

<body class="" id="body-controlador"> </body>
<script type="text/javascript">
  vista('<?php echo $menu; ?>', '<?php echo $https . $url . '/' . $appname . '/vista/menu/controlador/controlador.php'; ?>')


  function vista(menu, url) {
    $.post(url, {
      menu: menu,
      tipoUrl: 2
    }, function(html) {
      $("#body-controlador").html(html);
    });
  }
</script>

</html>