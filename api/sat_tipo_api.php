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
$id_sat_tipo = $_POST['id_sat_tipo'];
$descripcion = $_POST['descripcion'];

$parametros = array(
    $id_sat_tipo,
    $descripcion
);
$response="";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_sat_tipos_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_sat_tipos_b", [$id]);
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_sat_tipos_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_sat_tipos_e", [$id]);
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
