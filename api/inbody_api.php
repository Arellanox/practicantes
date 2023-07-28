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
$id_inbody = $_POST['id_inbody'];

switch($api){
    case 1:
        # subir la imagen del inbody
        $dir = "../archivos/inbodies/";
        $r = $master->createDir($dir);
        if($r==1){
            $paciente = $master->getByPatientNameByTurno($master,$turno_id);
            $inbody = $master->guardarFiles($_FILES,"inbody",$dir,"INBODY_" . $paciente . "_" . $hoy);
            $url = str_replace("../", $host, $inbody[0]['url']);
            $response = $master->insertByProcedure("sp_inbody_resultados_g", [$id_inbody, $turno_id, $url, null, $_SESSION['id']]);

        } else {
            $response = "No se pudo crear el directorio.";
        }
        
        break;
    case 2:
        # buscar la captura
        $response = $master->getByProcedure("sp_inbody_resultados_b", [ $turno_id ]);
        
        break;
    case 3:
        # Enviar el reporte de inbody por correo electronico

        $mail = new Correo();
        $attachment = $master->cleanAttachFilesImage($master, $turno_id, 14, 1);
        
        if (!empty($attachment[0])) {
            $mail = new Correo();
            if ($mail->sendEmail('resultados', '[bimo] ESTUDIO DE COMPOSICION CORPORAL (InBody)', [$attachment[1]], null, $attachment[0], 1)) {
                $master->setLog("Correo enviado.", "Inbody");
                $response = ["Correo enviado."];
                # cambiar el estado del campo enviado en la base de datos
                # para que se pinte el icono de correo en el menu principal
                $result = $master->updateByProcedure("sp_inbody_correo_enviado", [$turno_id]);
            }
        } else {
            $response = "No hay archivos para adjuntar.";
        }
        break;
    
}

echo $master->returnApi($response);
?>