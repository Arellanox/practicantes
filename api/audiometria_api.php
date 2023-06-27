<?php

require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/Pdf.php";
//include_once "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();

#OBTENEMOS LA API POR MEDIO DEL POST
$api = $_POST['api'];

$archivo = $_POST['resultado_audio[]'];
$id_turno = $_POST['id_turno'];
$turno_id = $_POST['turno_id'];

$usuario_id = $_SESSION['id'];
$host = $_SERVER['SERVER_NAME'] == "localhost" ? "http://localhost/practicantes/" : "https://bimo-lab.com/nuevo_checkup/";




switch($api){

    case 1:

        # GUARDAMOS EL PDF DEL REPORTE DE AUDIOMETRIA

        $destination = "../reportes/modulo/audiometria/$id_turno/";
        $r = $master->createDir($destination);

        #LE AÑADIMOS UN NOMBRE A NUESTRO ARCHIVO
        $name = $master->getByPatientNameByTurno($master, $id_turno);

        // Verificar si el archivo existe
        if (file_exists($destination . "AUDIO_$id_turno" . "_" . "$name")) {

            // Eliminar el archivo existente
            unlink($destination . "AUDIO_$id_turno" . "_" . "$name");
        }

        $interpretacion = $master->guardarFiles($_FILES, "resultado_audio", $destination, "AUDIO_$id_turno" . "_" . "$name");

        $ruta_archivo = str_replace("../", $host, $interpretacion[0]['url']);

        #guardarmos la direccion de espirometria
        $audio = $host . "reportes/modulo/audiometria/$id_turno/" . basename($ruta_archivo);
        $response = $master->insertByProcedure("sp_audio_ruta_reporte_g", [$audio, $id_turno, $usuario_id]);

        break;

    case 2:

        $response = $master->getByProcedure('sp_audio_ruta_b', [$turno_id]);

        break;

    default:
        $response = "Api no definida";
}

echo $master->returnApi($response);



?>