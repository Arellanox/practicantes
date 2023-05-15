<?php
include "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();
#api case
$api = $_POST['api'];

#buscar y eliminar
$id = $_POST['id'];
$activo = isset($_POST['ACTIVO']) ? null : 1;

#insertar
$id_titulo = $_POST['ID_U_TITULO'];
$descripcion = $_POST['descripcion'];

$parametros = array(
    $id_titulo,
    $descripcion
);



switch ($api) {
    case 1:
        #insertar y actualizar
        $response = $master->insertByProcedure("sp_u_titulos_g", [$id_titulo, $descripcion]);
        break;
    case 2:
        #buscar
        $response = $master->getByProcedure("sp_u_titulos_b", [$id, $activo]);
        break;
    case 4:
        # desactivar o activar
        $response = $master->deleteByProcedure("sp_u_titulos_e", [$id, $activo]);
        break;

    default:
        $response = "API no definida";
        break;
}

echo $response = $master->returnApi($response);
