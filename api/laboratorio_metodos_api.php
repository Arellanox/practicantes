 
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
$api = isset($_POST['api']) ?  $_POST['api'] : (isset($_GET['api']) ? $_GET['api'] : 2);

#buscar
$id = $_POST['id'];
$activo = isset($_POST['ACTIVO']) ? null : 1;

#insertar 
$id_metodo = $_POST['ID_METODO'];
$descripcion = $_POST['descripcion'];

$parametros = array(
    $id_metodo,
    $descripcion
);

$response = "";

$master = new Master();
switch ($api) {
    case 1:
        # insertar
        $response = $master->insertByProcedure("sp_laboratorio_metodos_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_laboratorio_metodos_b", [$id, $activo]);
        break;

    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_laboratorio_metodos_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_laboratorio_metodos_e", [$id]);
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
