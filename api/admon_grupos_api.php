<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/Pdf.php";
include "../clases/correo_class.php";

$master = new Master();

$api = $_POST['api'];


# variables
$id_grupo = $_POST['id_grupo'];
$descripcion = $_POST['nombre_grupo'];
$cliente_id = $_POST['cliente_id'];
$usuario_id = $_SESSION['id'];
$facturado = $_POST['facturado']; # bit que marca si el grupo esta siendo facturado o creado;
$factura = $_POST['num_factura']; # numero de la factura que arroja alegra.
$detalle = $_POST['detalle_grupo']; # es un arreglo que incluye solo el id del turno. Ejemplo [45,46,46,48]
$fecha_creacion = $_POST['fecha_creacion']; # fecha de creacion del grupo

# recuperar pacientes
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];

switch ($api) {
    case 1:
        # Agregar un grupo y su detalle.
        # Agregar el numer de factura y mas detalle al grupo.
        $facturado = strlen($factura) > 0 ? 1 : 0;

        if ($facturado == 1) {
            # agregar datos de factura.
            $response = $master->insertByProcedure("sp_admon_grupos_g", [$id_grupo, $descripcion, $cliente_id, $usuario_id, $facturado, $usuario_id, $factura, $detalle]);
        } else {
            # agregar datos de creacion de grupo.
            $response = $master->insertByProcedure("sp_admon_grupos_g", [$id_grupo, $descripcion, $cliente_id, $usuario_id, $facturado, null, null, $detalle]);
        }

        break;
    case 2:
        # buscar grupos
        $response = $master->getByProcedure("sp_admon_grupos_b", [$cliente_id, $fecha_creacion]);
        break;
    case 3:
        # recuperar el detalle del grupo.
        $response = $master->getByProcedure("sp_admon_detalle_grupo", [$id_grupo]);
        break;
    case 4:
        # lista de pacientes a credito que no estan en grupos
        $response = $master->getByProcedure("sp_admn_pacientes_credito", [$cliente_id, $fecha_inicial, $fecha_final]);
        break;
    case 5:
        # lista de pacientes de contado que no han sido facturados aun.
        $response = $master->getByProcedure("sp_admon_pacientes_contado", [$fecha_inicial, $fecha_final]);
        break;
    default:
        $response = "API no definida";
}

echo $master->returnApi($response);
