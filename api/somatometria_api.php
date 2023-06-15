<?php
include_once "../clases/master_class.php";
include "../clases/correo_class.php";

$master = new Master();
$api = $_POST['api'];

$id_turno = $_POST['id_turno'];
$id_signo = $_POST['id_signo']; #para insertar, este debe quedar null
$tipo = $_POST['tipo_signo'];
$valor = $_POST['resultado']; # resultado de la medida

$medidas = $_POST['medidas'];


switch ($api) {
    case 1:
        # reservado para insertar
        foreach ($medidas as $key => $medida) {
            $id_metrica = $key + 1;
            $newRecord = array(
                $id_signo,
                $id_turno,
                $id_metrica,
                $medida
            );

            $response = $master->insertByProcedure("sp_mesometria_signos_vitales_g", $newRecord);
        }
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure('sp_mesometria_signos_vitales_b', [$id_turno]);
        if (is_array($response)) {
            foreach ($response as $key => $signo) {
                $array[$response[$key]['TIPO_SIGNO']] = $signo;
            }
            $array['FECHA_REGISTRO'] = $response[count($response) - 1]['FECHA_REGISTRO'];
            $array['RUTA_REPORTE'] = $response[0]['RUTA_REPORTE'];
            $response = $array;
        }
        break;
    case 3:
        # reservado para actualizarn #<-- Para insertar y actualizar 
        $ids = array();
        $valores = array();
        foreach ($medidas as $key => $value) {
            // array_push($ids,$key);
            // array_push($valores,$value);
            $ids[] = $key;
            $valores[] = $value;
        }
        $response = $master->insertByProcedure("sp_somatometria_signos_vitales_g", [$id_turno, json_encode($ids), json_encode($valores), null]);
        //print_r($response);

        #Generar el reporte de somatometria.
        # evaluar si el response es numerico, si es numerico es que si se guardo.
        # si se guardo, generar el reporte
        if (is_numeric($response)) {
            $url = $master->reportador($master, $id_turno, 2, "reporte_masometria", "url");
            $response = $master->insertByProcedure("sp_somatometria_signos_vitales_g", [$id_turno, null, null, $url]);
            $attachment = $master->cleanAttachFilesImage($master, $id_turno, 2, 1);
    
            if (!empty($attachment[0])) {
                $mail = new Correo();
                if ($mail->sendEmail('resultados', '[bimo] Resultados de somatometría', [$attachment[1]], null, $attachment[0], 1)) {
                    $master->setLog("Correo enviado.", "Somatometría");
                }
            }
        }

        break;
    case 4:
        # eliminar


    default:
        echo "Api no reconocida.";
        break;
}

echo $master->returnApi($response);
