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
$encargado_id = $_POST['encargado_id'];

#insertar
$id_area = $_POST['id'];
$encargado_id = $_POST['encargado_id'];
$descripcion = $_POST['descripcion'];
$esta_libre = $_POST['esta_libre'];
$prioridad = $_POST['prioridad'];

$id_area_fisica = $_POST['id_area_fisica'];

$parametros = array(
    $id_area,
    $encargado_id,
    $descripcion,
    $esta_libre,
    $prioridad
);
$response="";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_areas_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_areas_b", [$id,$encargado_id]);
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_areas_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_areas_e", [$id]);
        break;
    case 5:
        # recuperar las areas fisicas o salas
        $response = $master->getByProcedure("sp_areas_fisicas_b", [$id_area_fisica]);
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
