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

#buscar y eliminar
$id = $_POST['id'];

#insertar
$id_cargo = $_POST['ID_CARGO'];
$descripcion = $_POST['descripcion'];
$activo = isset($_POST['ACTIVO']) ? null : 1;

$parametros = array(
    $id_cargo,
    $descripcion
);

$response = "";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_cargos_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_cargos_b", [$id, $activo]);
        break;
        // case 3:
        //     # actualizar
        //     $response = $master->updateByProcedure("sp_cargos_g", $parametros);
        //     break;
    case 4:
        # desactivar o activar
        $response = $master->deleteByProcedure("sp_cargos_e", [$id, $activo]);
        break;

    default:
        $response = "api no reconocida";
        break;
}
echo $master->returnApi($response);
