<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/Pdf.php";
include "../clases/correo_class.php";


$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    # $tokenVerification->logout();
    # exit;
}

#api
$api = $_POST['api'];

#diagnostico
$id = $_POST['id'];
$bestMatchText = $_POST['bestMatch'];
$title = $_POST['title'];
$iNo = $_POST['iNo'];
$uri = $_POST['uri'];

#paciente
$id_turno = $_POST['id_turno'];
$paciente_id = $_POST['paciente_id'];

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_consulta_cie", $parametros);
        break;

    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
