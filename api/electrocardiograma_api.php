<?php
session_start();
require_once "../clases/token_auth.php";
include_once '../clases/master_class.php';
include_once "../clases/Pdf.php";
include "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

$master = new Master();
$api = $_POST['api'];

# Datos para la interpretacion
$turno_id = isset($_POST['turno_id']) ? $_POST['turno_id'] : $_POST['id_turno'];
$id_electro = $_POST['id_electro'];
$comentario = $_POST['comentario'];
$tecnica = $_POST['tecnica'];
$hallazgo = $_POST['hallazgo'];
$interpretacion = $_POST['interpretacion'];
$usuario = $_SESSION['id'];
$confirmado = $_POST['confirmado'];
$archivo = $_POST['electro_pdf'];

# Datos para el sistema
$host = $_SERVER['SERVER_NAME'] == "localhost" ? "http://localhost/nuevo_checkup/" : "https://bimo-lab.com/nuevo_checkup/";
$date = date("dmY_His");

switch ($api) {
    case 1:
        # insertar la interpretacion
        if (isset($confirmado)) {
            // confirmamos y creamos el reporte.
            $url = $master->reportador($master, $turno_id, 10, "electro", "url", 0, 0, 0);
            # combinar el reporte de bimo con el pdf del electro y guardarlo en la misma ruta
            $electro_search = $master->getByProcedure("sp_electro_resultados_b", [null, $turno_id, null]);
            $img_electro = $electro_search[array_key_first($electro_search)]['ELECTRO_PDF'];

            $reporte_bimo = explode("nuevo_checkup", $url);
            $img_electro = explode("nuevo_checkup", $img_electro);

            $reporte_final = $master->joinPdf([".." . $reporte_bimo[1], ".." . $img_electro[1]]);

            $fh = fopen("../" . $master->getRutaReporte() . basename($url), 'a');
            fwrite($fh, $reporte_final);
            fclose($fh);

            // #eliminamos el archivo de electro
            // unlink("../reportes/modulo/electro/$turno_id/".basename($img_electro[1]));
            // # eliminamos la carpeta
            // rmdir("../reportes/modulo/electro/$turno_id");

            $response = $master->updateByProcedure("sp_electro_resultados_g", [$id_electro, $turno_id, null, $usuario, null, null, null, null, $url, $confirmado, null]);

            //Enviamos correo
            $attachment = $master->cleanAttachFilesImage($master, $turno_id, 10, 1);

            if (!empty($attachment[0])) {
                $mail = new Correo();
                if ($mail->sendEmail('resultados', '[bimo] Resultados de electrocardiograma', [$attachment[1]], null, $attachment[0], 1)) {
                    $master->setLog("Correo enviado.", "Electrocardiograma");
                }
            }
        } else {
            // solo guardamos la informacion del reporte. Sin confirmar          
            #guardarmos
            $response = $master->insertByProcedure("sp_electro_resultados_g", [$id_electro, $turno_id, null, $usuario, $comentario, $interpretacion, $tecnica, $hallazgo, null, null, null]);
        }
        break;
    case 5:
        # captutas electro
        // solo guardamos la informacion del reporte. Sin confirmar
        $response = $master->getByProcedure("sp_electro_resultados_b", [null, $turno_id, null]);

        if (isset($response[0]['ELECTRO_PDF']) && $_SESSION['permisos']["ActuaCap"] == 0) {
            $response = "Ya existe un electrocardiograma para este paciente.";
            break;
        }

        //mover el archivo con la imagen de electro a la caperta del turno.
        if (isset($archivo)) {
            $destination = "../reportes/modulo/electro/$turno_id/";
            $r = $master->createDir($destination);
            $dir = explode("nuevo_checkup", $archivo);

            $folder = $master->scanDirectory($destination);

            //borrar el archivo anterior, si existe
            if (!empty($folder)) {
                foreach ($folder as $file) {
                    unlink($file);
                }
            }

            if (copy(".." . $dir[1], $destination . basename($archivo))) {
                # si se copia correctamente, borramos el archivo de la carpeta generica.
                unlink('..' . $dir[1]);

                #guardarmos la direccion del electro.
                $electro = $host . "reportes/modulo/electro/$turno_id/" . basename($archivo);
                $response = $master->insertByProcedure("sp_electro_resultados_g", [$id_electro, $turno_id, $electro, null, null, null, null, null, null, null, $usuario]);
            }
            
            # enviar solo la captura del electrocardiograma
            # se enviaria solo la captura si no se ha reportado la interpretacion y confirmado.
            # si ya tiene el reporte confirmado, se enviarian ambos (el reporte y la captura de electro);
            # si no tiene el reporte confirmado, solo se envia la captura de electro.

            //Enviamos correo
            $attachment = $master->cleanAttachFilesImage($master, $turno_id, 10, 1);

            if (!empty($attachment[0])) {
                $mail = new Correo();
                if ($mail->sendEmail('resultados', '[bimo] Resultados de electrocardiograma', [$attachment[1]], null, $attachment[0], 1)) {
                    $master->setLog("Correo enviado.", "Electrocardiograma captura");
                }
            }
    
        } else {
            $response = "No se recibió archivo.";
        }

        break;
    case 2:
        #buscar
        $response = $master->getByProcedure("sp_electro_resultados_b", [null, $turno_id, null]);
        if (!empty($response)) {
            foreach ($response as $key => $item) {
                // $response[$key]['GUARDADO'] = 1;
                $response[$key]['CAPTURAS'] = array();
            }
        }
        break;
    case 3:
        # recuperar los electros de la carpeta global
        $folder = "../electro_img/";

        $electros = scandir($folder);

        $files = [];
        for ($i = 0; $i < count($electros); $i++) {
            if ($i > 1) {
                $path = $host . "electro_img/" . $electros[$i];
                $files[] = [$path, $electros[$i]];
            }
        }
        $response = $files;
        break;
    case 4:
        # eliminar
        $response = $master->deleteByProcedure("sp_electro_resultados_e", [$turno_id]);
        break;

    default:
        $response = "Api no definida.";
        break;
}
echo $master->returnApi($response);
