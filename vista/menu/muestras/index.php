<?php
//Variables dinamicas;

session_start();
include "../../variables.php";
$menu = "muestras";
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
  <?php include "../../include/head.php"; ?>
  <title>Toma de muestras | Bimo</title>
</head>

<body class="" id="body-controlador"> </body>
<script type="text/javascript">
  vista('<?php echo $menu; ?>', '<?php echo $https . $url . '/' . $appname . '/vista/menu/controlador/controlador.php'; ?>')

  function vista(menu, url) {
    $.post(url, {
      menu: menu
    }, function(html) {
      $("#body-controlador").html(html);
    });
  }
</script>

</html>