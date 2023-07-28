<?php
include "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

$master = new Master();
$api = $_POST['api'];

#datos
$id_laboratorio = $_POST['ID_LABORATORIO'];
$nombre = $_POST['descripcion'];

#buscar y eliminar
$id = $_POST['id'];
$activo = isset($_POST['ACTIVO']) ? null : 1;

switch ($api) {
    case 1:
        # insertar y actualizar por la id.
        $response = $master->insertByProcedure("sp_laboratorios_maquila_g", [$id_laboratorio, $nombre]);
        break;

    case 2:
        # buscar
        $response = $master->getByProcedure("sp_laboratorios_maquila_b", [$id, $activo]);
        break;
    case 4:
        # activar o desactivar
        $response = $master->deleteByProcedure("sp_laboratorios_maquila_e", [$id, $activo]);
        break;
    default:
        $response = "Api no definida.";
        break;
}

echo $master->returnApi($response);
