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
$cliente = $_POST['id_cliente'];

#insertar
$id_contacto = $_POST['id_contacto'];
$id_cliente = $_POST['id_cliente'];
$nombre = $_POST['nombre_contacto'];
$apellidos = $_POST['apellidos_contacto'];
$telefono1 = $_POST['telefono1_contacto'];
$telefono2 = $_POST['telefono2_contacto'];
$email = $_POST['email_contacto'];
$tipo_contacto = $_POST['tipo_contacto'];

$parametros = array(
    $id_contacto,
    $id_cliente,
    $tipo_contacto,
    $nombre,
    $apellidos,
    $telefono1,
    $telefono2,
    $email
);

$response=""; 
$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_contactos_g", $parametros); 
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_contactos_b", [$id, $cliente]); 
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_contactos_g", $parametros); 
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_contactos_e", [$id]); 
        break;

    default:
    $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);