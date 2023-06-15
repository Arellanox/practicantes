<?php
session_start();
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
$id_nota = $_POST['id_nota'];
$id_turno = $_POST['id_turno'];
$id_paciente = $_POST['id_paciente'];

#insertar  
$notas = $_POST['notas'];
$usuario = $_SESSION['id'];

$parametros = array(
    $id_nota,
    $id_turno,
    $notas,
    $usuario
);
 
$response="";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_notas_historia_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_notas_historia_b", [$id_nota,$id_turno,$id_paciente]);
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_notas_historia_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_notas_historia_e", [$id_nota]);
        break;

    default:
    $response = "api no reconocida";
        break;
}
echo $master->returnApi($response);