<?php
include "../clases/master_class.php";
require_once "../clases/token_auth.php";
require_once "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

$master = new Master();
$hoy = date("Ymd");
$host = $master->selectHost($_SERVER['SERVER_NAME']);
$api = $_POST['api'];
$turno_id = $_POST['turno_id'];
$id_eco = $_POST['id_eco'];

switch ($api) {
    case 1:
        # subir el reporte del ecocardiograma.
        $dir  = "../archivos/ecocardiogramas/";
        $r = $master->createDir($dir);
        if($r==1){
            $paciente = $master->getByPatientNameByTurno($master,$turno_id);
            $eco = $master->guardarFiles($_FILES,"capturas",$dir,"ECO_" . $paciente . "_" . $hoy);
            $url = str_replace("../", $host, $eco[0]['url']);
            $response = $master->insertByProcedure("sp_ecocardiograma_g", [$id_eco, $turno_id, $url, null, $_SESSION['id']]);

        } else {
            $response = "No se pudo crear el directorio.";
        }
        break;
    case 2:
        # buscar los reportes del ecocardiograma.
        $response = $master->getByProcedure("sp_ecocardiograma_resultados_b",[$turno_id]);
        break;
    
    default:
        # code...
        break;
}


echo $master->returnApi($response);