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

$id_turno = $_POST['id_turno'];
$id_paciente = $_POST['id_paciente'];
$id_area = $_POST['id_area'];
$fecha_agenda = $_POST['fecha_agenda'];

#insertar
// $id_turno = $_POST['id_turno'];
// $parametros = array(
//     $id_turno
// );
$response="";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->getByProcedure("sp_toma_de_muestra_lista_de_trabajo", [$fecha_agenda,$id_area]);
        break;
    case 2:
        # buscar_servicios de toma de muestra
        $response = $master->getByProcedure("sp_toma_de_muestra_servicios_b", [$id_paciente,$id_area,$id_turno]);
        break;
    case 3:
        # actualizar toma de muestra
        # indicar que la muestra ya ha sido tomada.
        $response = $master->updateByProcedure("sp_toma_de_muestra_servicios_g", [$id_turno]);
        $_SESSION['turnero'] = null;
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
