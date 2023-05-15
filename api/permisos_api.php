<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

#api
$api = $_POST['api'];
#buscar

$id = $_POST['id'];
#insertar
$id_permiso = $_POST['id_permiso'];
$permiso = $_POST['permiso'];
$descripcion = $_POST['descripcion'];


$parametros = array(
    $id_permiso,
    $permiso,
    $descripcion
);
$response="";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_permisos_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_permisos_b", [$id]);
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_permisos_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_permisos_e", [$id]);
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
