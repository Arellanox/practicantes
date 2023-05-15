<?php 
include_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

$api = $_POST['api'];
$master = new Master();

#para la tabla modulos
$id_modulo = $_POST['id_modulo'];
$area_id = $_POST['area_id'];
$descripcion = $_POST['descripcion'];

# para la tablade usuarios_modulos
$usuario = $_POST['usuario_id'];

$params = array(
    $id_modulo,
    $area_id,
    $descripcion
);

switch($api){
    case 1:
        #insertar modulos
        $response = $master->insertByProcedure('sp_modulos_g',$params);
        break;
    case 2:
        #buscar todos o por id
        $response = $master->getByProcedure('sp_modulos_b',[$id_modulo,$area_id]);
        break;
    case 3:
        # actualizar 
        $response = $master->updateByProcedure("sp_modulos_g",$params);
        break;
    case 4:
        # eliminar
        $response = $master->deleteByProcedure('sp_modulos_e',[$id_modulo]);
        break;
    case 5:
        #insertar relacion modulos usuarios
        
        $response = $master->insertByProcedure('sp_usuarios_modulos_g',[$id_modulo,$usuario]);
        break;
    case 6:
        #eliminar una relacion usuario modulo
        $response = $master->deleteByProcedure('sp_usuarios_modulos_e',[$id_modulo,$usuario]);
        break;
    case 7:
        #recuperear los modulos de un usuarios
        $response = $master->getByProcedure('sp_usuarios_modulos_b',array($usuario));
        break;
    default:
        break;
}

echo $master->returnApi($response);
?>