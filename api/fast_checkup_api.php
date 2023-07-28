<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$api = $_POST['api'];

$master = new Master();

$turno_id = $_POST['turno_id'];
$cuestionario = $_POST['quest-riesgo'];

# para confirmar el reporte de fast checkup.
$confirmado = $_POST['confirmado']; # si se envia 1 se guarda y envia el reporte, si se envia 0 solo se guarda.
$tipo_riesgo = $_POST['tipo_riesgo']; # variable que reune el score final y el tipo de riesgo.
$score_final = $_POST['score_final'];
$prefolio = $_POST['prefolio'];
$suma_ponderacion = $_POST['ponderacion'];



switch ($api) {
    case 1:
        # insertar cuestionario de riesgo que se encuentra en el prerregistro.
        $ids = array();
        $respuestas = array();

        foreach ($cuestionario as $key => $value) {
            if (!empty($value['valor'])) {
                # guardamos las ids separadas para poder enviarlas como json al sp.
                $ids[] = $key;

                # guardamos las respuestas que incluyen la respuesta como texto y la ponderacion como entero.
                $respuestas[] = array("respuesta" => $value['valor'], "ponderacion" => $value['ponderacion']);
            }
        }

        $response = $master->insertByProcedure("sp_fastck_cuestionario_g", [json_encode($ids), json_encode($respuestas), $prefolio, $suma_ponderacion]);
        break;

    case 2:
        # recuperar los valores de las pruebas para el cuestionario complemento que se ve en el modulo de consultorio.
        $response = $master->getByProcedure("sp_fastck_b", [$turno_id]);

        break;
    case 3:
        # confirmar el resultado del turno y enviar los reportes (todos los que tenga ese turno) por correo.
        // // foreach ($resultado as $res) {
        // $tipo_riesgo = $res['TIPO_RIESGO'];
        // $score_final = $res['SCORE_FINAL'];
        // // }
           
        if ($confirmado == 1) {
            # guardamos datos, creamos el reporte y enviamoso por correo.

            # Guardamos si hay algun cambio final.
            $response = $master->updateByProcedure("sp_fastck_resultados_g", [$score_final, $_SESSION['id'], $tipo_riesgo, $confirmado, $turno_id]);
        
            # Creamos el reporte
            $url = $master->reportador($master,$turno_id,17,'fast_checkup', 'url', 0);
          

            # actualizar la ruta del reporte en la tabla.
            $res = $master->updateByProcedure("sp_reportes_actualizar_ruta", ["fastck_resultados", "RUTA_REPORTE", $url,$turno_id, null]);
     
            # 
            $nombre_paciente = $master->getByPatientNameByTurno($master,$turno_id);
            #enviamos todos sus reportes por correo (laboratorio, signos vitales, fast checkup).
            $attachment = $master->cleanAttachFilesImage($master, $turno_id,null,19);

           
            if (!empty($attachment[0])) {
                $mail = new Correo();
                if ($mail->sendEmail('fastck', '[bimo] Fast Checkup', [$attachment[1]], null, $attachment[0], 1, $nombre_paciente)) {
                    $master->setLog("Correo enviado.", "fast - checkup");
                }
            }

        } else {
            # solo guardamos los datos
            $response = $master->getByProcedure("sp_fastck_resultados_g", [$score_final, $_SESSION['id'], $tipo_riesgo, $confirmado, $turno_id]);
        }

        break;

        //No usable
    case 0:

        // echo var_dump($_POST['quest-riesgo']);

        foreach ($_POST['quest-riesgo'] as $key => $value) {
            # code...
            $id = $key;
            $respuesta = $value['valor'];
            $ponderacion_respuesta = $value['ponderacion'];

            if (!empty($respuesta)) {
                echo "Pregunta $key: $id, $respuesta, $ponderacion_respuesta </br>";
            }
        }

        exit;
        break;
}

echo $master->returnApi($response);
