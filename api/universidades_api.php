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
#api case
$api = $_POST['api'];

#buscar y eliminar
$id = $_POST['id'];
$activo = isset($_POST['ACTIVO']) ? null : 1;

#insertar
$id_universidad = $_POST['ID_UNIVERSIDAD'];
$descripcion = $_POST['descripcion'];

$parametros = array(
    $id_universidad,
    $descripcion
);

switch ($api) {
    case 1:
        #inserta y actualiza cuando le envias el id de la universidad.
        $response = $master->insertByProcedure("sp_universidades_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_universidades_b", [$id, $activo]);
        break;
    case 4:
        # desactivar o activar
        $response = $master->deleteByProcedure("sp_universidades_e", [$id, $activo]);

    default:
        $response = "API no definida.";
        break;
}

echo $master->returnApi($response);
