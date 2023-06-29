<?php

require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/Pdf.php";
include_once "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();

#OBTENEMOS LA API POR MEDIO DEL POST
$api = $_POST['api'];

$curp = $_POST['curp'];
$turno_id = $_POST['turno_id'];
$archivo = $_POST['resultado_espiro[]'];
$area_id = $_POST['id_area'];
$id_turno = $_POST['id_turno'];
$preguntasRespuestas = $_POST['respuestas'];
$confirmado = isset($_POST['confirmado']) ? $_POST['confirmado'] : 0;

$usuario_id = $_SESSION['id'];
$host = $_SERVER['SERVER_NAME'] == "localhost" ? "http://localhost/practicantes/" : "https://bimo-lab.com/nuevo_checkup/";


//declaramos nuestras variables de almacenamineto para guardar nuestras preguntas y respuestas
$preguntas = [];
$respuestas = [];


switch ($api) {

        #GUARDAMOS LOS DATOS
    case 1:

        $principal = [];
        $secundario = [];
        $posicion = 0;

        foreach ($preguntasRespuestas as $key => $value) {

            $principal[$posicion] = ['preguntaID' => $key];
            $valor = null;
            $comentario = null;

            if (COUNT($preguntasRespuestas[$key]) > 1) {



                foreach ($value as $item) {
                    $secundario[] = ['respuestaID' => $master->setToNull([$item['valor']])[0] ? $item['valor'] : $valor, 'comentario' => $master->setToNull([$item['comentario']])[0] ? $item['comentario'] : $comentario];
                }
            } else {

                $secundario = ['respuestaID' => isset($value[array_key_first($value)]['valor']) ? $value[array_key_first($value)]['valor'] : $valor, 'comentario' => isset($value[array_key_first($value)]['comentario']) ? $value[array_key_first($value)]['comentario'] : $comentario];
            }
            $principal[$posicion]['respuestaID'] = $secundario;
            $secundario = [];

            $posicion++;
        }


        
        $response = $master->insertByProcedure("sp_espiro_cuestionario_g", [json_encode($principal), $id_turno, $area_id, $usuario_id, 0]);

        if ($confirmado == 1) {

            //Mandamnos a llamar el siguinete procedure para ver si existe el reporte de espiro (EASYONE)
            $response = $master->getByProcedure("sp_espiro_ruta_reporte_b", [$id_turno]);

            if (isset($response[0]['RUTA_REPORTES_ESPIRO'])) {

                $response = $master->insertByProcedure("sp_espiro_cuestionario_g", [json_encode($principal), $id_turno, $area_id, $usuario_id, $confirmado]);

                //Si confirma el cuestionario lo crea en pdf y lo guarda
                $url = $master->reportador($master, $id_turno, 5, "espirometria", 'url', 0);
                $response = $master->updateByProcedure('sp_espiro_ruta_reporte_g', [$id_turno, $url]);

                //Verificamos la ruta de los reportes para unirlos
                $reportes = $master->getByProcedure("sp_recuperar_reportes_confirmados", [$id_turno, 5, null, null, null]);

                $arreglo = array();


                foreach ($reportes as $reporte) {

                    $reporte_bimo = explode("practicantes", $reporte['RUTA']);
                    $arreglo[] = ".." . $reporte_bimo[1];
                }


                //Si existe unimos el reporte con el cuestionario
                $reporte_final = $master->joinPdf(array_filter($arreglo, function ($item) {
                    return $item !== "..";
                }));



                $fh = fopen("../" . $master->getRutaReporte() . "ESPIROMETRIA_" . basename($url), 'a');
                fwrite($fh, $reporte_final);
                fclose($fh);


                $espiro = $host . $master->getRutaReporte() . "ESPIROMETRIA_" . basename($url);
                $response = $master->updateByProcedure("sp_reportes_actualizar_ruta", ['espiro_resultados', 'RUTA_REPORTE_FINAL', $espiro, $id_turno, null]);

                //Enviamos correo
                $attachment = $master->cleanAttachFilesImage($master, $id_turno, 5, 1);


                if (!empty($attachment[0])) {
                    $mail = new Correo();
                    if ($mail->sendEmail('resultados', '[bimo] Resultados de espirometria', [$attachment[1]], null, [$espiro], 1)) {
                        $master->setLog("Correo enviado.", "Espirometria resultados");
                    }
                }
            } else {
                $response = "Es necesario cargar el estudio del EASYONE para poder confirmar";
            }
        }

        break;

    case 2:
        #RECUPERAMOS TODOS LOS DATOS DEL FORMULARIO (PREGUNTAS, RESPUESTAS Y COMENTARIOS)
        if(isset($curp)){

            $response = $master->getByProcedure("sp_recuperar_ultimo_cuestionario_espiro_b", [$curp]);

        }else{

            $resultados = $master->getByNext("sp_espiro_cuestionario_b", [$turno_id]);
            $resultados[1][0]['PREGUNTAS'] = $resultados[0];
            $response = $resultados[1];

        }
       



        break;
    case 3:
        # GUARDAMOS EL PDF DEL REPORTE DEL SOFTWARE

        // solo guardamos la informacion del reporte. Sin confirmar
        //$response = $master->getByProcedure("sp_espiro_ruta_reporte_b", [$id_turno]);

        // if (isset($response[0]['RUTA_REPORTES_ESPIRO'])) {
        //     $response = "Ya existe un estudio para este paciente.";
        //     break;
        // }

        $destination = "../reportes/modulo/espirometria/$id_turno/";
        $r = $master->createDir($destination);
        
        #LE AÑADIMOS UN NOMBRE A NUESTRO ARCHIVO
        $name = $master->getByPatientNameByTurno($master, $id_turno);

        // Verificar si el archivo existe
        if (file_exists($destination. "EASYONE_$id_turno" . "_" . "$name")) {
            
            // Eliminar el archivo existente
            unlink($destination . "EASYONE_$id_turno" . "_" . "$name");
        }
        

        $interpretacion = $master->guardarFiles($_FILES, "resultado_espiro", $destination, "EASYONE_$id_turno" . "_" . "$name");

        $ruta_archivo = str_replace("../", $host, $interpretacion[0]['url']);

        #guardarmos la direccion de espirometria
        $espiro = $host . "reportes/modulo/espirometria/$id_turno/" . basename($ruta_archivo);
        $response = $master->updateByProcedure("sp_reportes_actualizar_ruta", ['espiro_resultados', 'RUTA_REPORTES_ESPIRO', $espiro, $id_turno, null]);



        break;
    case 0:
        # json para el reporte de espirometria.
        $respuestas = $master->getByProcedure("sp_espiro_cuestionario_b", [$turno_id]);

        # declaramos el arreglo que guardara el id de la pregunta
        $preguntas = array();

        # llenamos el arreglo
        foreach ($respuestas as $current) {
            $preguntas[] = $current['ID_P'];
        }

        # eliminamos las duplicidades
        $preguntas = array_unique($preguntas);

        # Declaramos un arreglo que guarde el cuestionario del paciente.
        $cuestionario = array();

        # llenamos el cuestionario, preparando el arreglo para el json.
        foreach ($preguntas as $pregunta) {

            #filtramos las respuestas de cada pregunta del arreglo origina, el que viene de la base de datos.
            $res_pregunta = array_filter($respuestas, function ($array) use ($pregunta) {
                return $array['ID_P'] == $pregunta;
            });

            # formamos el arreglo para el json.
            $cuestionario[] = array(
                "pregunta" => $res_pregunta[array_key_first($res_pregunta)]['PREGUNTA'],
                "respuestas" => $master->getFormValues(array_map(function ($item) {
                    return array("respuesta"  => $item['RESPUESTA'], "comentario" => $item['COMENTARIO']);
                }, $res_pregunta))
            );
        }

        echo json_encode($cuestionario);
        break;

    default:

        $response = "Api no definida";
}

echo $master->returnApi($response);
