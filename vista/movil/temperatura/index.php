<?php
//Variables dinamicas;
include "../../variables.php";
#Aqui se recibe el ID del equipo que llega por la URL 
$equipo_id = $_GET['equipo'];
$menu = "Temperatura_movil";
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <?php include "../../include/head.php"; ?>
    <title>Agregar Temperaturas | Bimo</title>
</head>

<body class="" id="body-controlador"> </body>
<script type="text/javascript">
    equipo_id = '<?php echo $equipo_id ?>';
    vista('<?php echo $menu; ?>', '<?php echo $https . $url . '/' . $appname . '/vista/menu/controlador/controlador.php'; ?>')

    function vista(menu, url) {
        $.post(url, {
            menu: menu,
            tipoUrl: 3
        }, function(html) {
            validar = true;
            $("#body-controlador").html(html);
        });
    }
</script>


</html>