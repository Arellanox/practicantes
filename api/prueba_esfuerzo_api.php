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
$id_prueba = $_POST['id_prueba'];

switch ($api) {
    case 1:
        $dir = "../archivos/prueba_esfuerzo/";
        $r = $master->createDir($dir);
        if ($r == 1) {
            $paciente = $master->getByPatientNameByTurno($master, $turno_id);
            $inbody = $master->guardarFiles($_FILES, "capturas", $dir, "PRUEBA_" . $paciente . "_" . $hoy);
            $url = str_replace("../", $host, $id_prueba[0]['url']);
            $response = $master->insertByProcedure("sp_prueba_esfuerzo_resultados_g", [$id_prueba, $turno_id, $url, null, $_SESSION['id']]);
        } else {
            $response = "No se pudo crear el directorio.";
        }

        break;
    case 2:
        # buscar la captura
        $response = $master->getByProcedure("sp_prueba_esfuerzo_resultados_b", [$turno_id]);

        break;
    case 3:
        # Enviar el reporte de inbody por correo electronico

        $mail = new Correo();
        $attachment = $master->cleanAttachFilesImage($master, $turno_id, 18, 1);

        if (!empty($attachment[0])) {
            $mail = new Correo();
            if ($mail->sendEmail('resultados', '[bimo] RESULTADOS DE PRUEBA DE ESFUERZO', [$attachment[1]], null, $attachment[0], 1)) {
                $master->setLog("Correo enviado.", "Prueba de esfuerzo captura");
                $response = ["Correo enviado."];
                # cambiar el estado del campo enviado en la base de datos
                # para que se pinte el icono de correo en el menu principal
                $result = $master->updateByProcedure("sp_prueba_esfuerzo_correo_enviado", [$turno_id]);
            }
        } else {
            $response = "No hay archivos para adjuntar.";
        }
        break;
}

echo $master->returnApi($response);
