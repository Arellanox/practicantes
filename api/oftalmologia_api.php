<?php
session_start();
include_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/Pdf.php";
include "../clases/correo_class.php";


$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
// if (!$tokenValido) {
//     $tokenVerification->logout();
//     exit;
// }


$master = new Master();
$api = $_POST['api'];

#variables
$id_oftalmo = $_POST['id_oftalmo'];
$turno_id = $_POST['turno_id'];
$antecedentes_personales = $_POST['antecedentes_personales'];
$antecedentes_oftalmologicos = $_POST['antecedentes_oftalmologicos'];
$pacedimiento_actual = $_POST['padecimiento_actual'];
$agudeza_visual = $_POST['agudeza_visual'];
$od = $_POST['od'];
$oi = $_POST['oi'];
$jaeger = $_POST['jaeger'];
$refraccion = $_POST['refraccion'];
$prueba = $_POST['prueba'];
$exploracion_oftalmologica = $_POST['exploracion_oftalmologica'];
$forias = $_POST['forias'];
$campimetria = $_POST['campimetria'];
$presion_intraocular_od = $_POST['presion_intraocular_od'];
$presion_intraocular_oi = $_POST['presion_intraocular_oi'];
$diagnostico = $_POST['diagnostico'];
$plan = $_POST['plan'];
$observaciones = $_POST['observaciones'];
$confirmado = $_POST['confirmado'];
$con_agudeza_visual = $_POST['agudeza_visual_con'];
$con_oi = $_POST['oi_con'];
$con_od = $_POST['od_con'];
$con_jaeger = $_POST['jaeger_con'];
#creacion de array.
$params = array(
    $id_oftalmo,
    $turno_id,
    $antecedentes_personales,
    $antecedentes_oftalmologicos,
    $pacedimiento_actual,
    $agudeza_visual,
    $od,
    $oi,
    $jaeger,
    $refraccion,
    $prueba,
    $exploracion_oftalmologica,
    $forias,
    $campimetria,
    $presion_intraocular_od,
    $presion_intraocular_oi,
    $diagnostico,
    $plan,
    $_SESSION['id'], # id del usuario que esta subiendo la informacion,
    null, # esta es la ruta del reporte, que posteriormente se tiene que actualizar
    $observaciones,
    $confirmado,
    $con_agudeza_visual,
    $con_oi,
    $con_od,
    $con_jaeger
    #creacion de array.
);

switch ($api) {
    case 1:
        #insertar
        // print_r($params);
        # en el procedure se insertar el folio consecutivo de los resultados activos.
        if (!isset($confirmado)) {
            $response = $master->insertByProcedure('sp_oftalmo_resultados_g', $params);
        } else {
            #$id_oftalmo = $master->updateByProcedure('sp_oftalmo_resultados_g', $params);
            // $url = crearReporteOftalmologia($turno_id);
            # actualizar la url del reporte

            $response = $master->updateByProcedure("sp_oftalmo_resultados_g", [null, $turno_id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $_SESSION['id'], null, null, $confirmado, NULL, NULL, NULL, NULL]);

            $url = $master->reportador($master, $turno_id, 3, 'oftalmologia', 'url');

            $response = $master->updateByProcedure("sp_oftalmo_resultados_g", [null, $turno_id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $_SESSION['id'], $url, null, $confirmado, NULL, NULL, NULL, NULL]);

            //enviamos correo
            $attachment = $master->cleanAttachFilesImage($master, $turno_id, 3, 1);

            if (!empty($attachment[0])) {
                $mail = new Correo();
                if ($mail->sendEmail('resultados', '[bimo] Resultados de oftalmología', [$attachment[1]], null, $attachment[0], 1)) {
                    $master->setLog("Correo enviado.", "Oftalmología");
                }
            }
        }



        # recuperamos el encabezado del paciente.
        // $responsePac = $master->getByProcedure("sp_informacion_paciente", [$turno_id]);
        # pie de pagina
        // $fecha_resultado = $responsePac[0]['FECHA_RESULTADO_OFTALMO'];
        // $nombre_paciente = $responsePac[0]['NOMBRE'];
        // $nombre = str_replace(" ", "_", $nombre_paciente);

        // $ruta_saved = "reportes/modulo/oftalmo/$fecha_resultado/" . $turno_id . "/";
        // # Crear el directorio si no existe
        // $r = $master->createDir("../" . $ruta_saved);

        // if ($r != 1) {
        //     $response = "No se puedo crear el directorio.";
        //     break;
        // }
        // $archivo = array("ruta" => $ruta_saved, "nombre_archivo" => $nombre . "-" . $responsePac[0]['TURNO'] . '-' . $fecha_resultado);

        // $clave = $master->getByProcedure("sp_generar_clave", []);
        // $pie_pagina = array("clave" => $clave[0]['TOKEN'], "folio" => $responsePac[0]['FOLIO_OFTALMO'], "modulo" => 3);

        # con el arreglo superior, creamos el pdf para conseguir la ruta antes de insertar en la tabla de mysql
        // $pdf = new Reporte(json_encode($params), json_encode($responsePac[0]), $pie_pagina, $archivo, 'resultados', 'url');

        // #actualizamos la url del reporte.
        // $response = $master->updateByProcedure("sp_oftalmo_resultados_g", [$last_id, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, $pdf->build(), null]);

        // crearReporteOftalmologia($turno_id, $ruta_saved);

        break;
    case 2:
        # buscar
        # si ambas variables se le envian en null, recupera todo la informacion de la tabla, de todos los turnos.
        $response = $master->getByProcedure('sp_oftalmo_resultados_b', [$id_oftalmo, $turno_id]);
        if (count($response))
            $response[0]['CAPTURAS'] = [];
        break;

    case 3:
        $infoPaciente = $master->getByProcedure('sp_informacion_paciente', [$turno_id]);


        // print_r($infoPaciente);
        #recuperar la informacion del Reporte de interpretacion de Oftalmología
        $response = array();
        # recuperar los resultados de oftalmología
        $area_id = 3; # 3 es el id para oftalmología
        $response1 = $master->getByProcedure('sp_oftalmo_resultados_b', [$id_oftalmo, $turno_id]);
        #print_r($response1);
        $arrayoftalmo = [];

        for ($i = 0; $i < count($response1); $i++) {
            $antecedentes_personales = $response1[$i]['ANTECEDENTES_PERSONALES'];
            $antecedentes_oftalmologicos = $response1[$i]['ANTECEDENTES_OFTALMOLOGICOS'];
            $pacedimiento_actual = $response1[$i]['PADECIMIENTO_ACTUAL'];
            $agudeza_visual = $response1[$i]['AGUDEZA_VISUAL_SIN_CORRECCION'];
            $od = $response1[$i]['OD'];
            $oi = $response1[$i]['OI'];
            $jaeger = $response1[$i]['JAEGER'];
            $refraccion = $response1[$i]['REFRACCION'];
            $prueba = $response1[$i]['PRUEBA'];
            $exploracion_oftalmologica = $response1[$i]['EXPLORACION_OFTALMOLOGICA'];
            $forias = $response1[$i]['FORIAS'];
            $campimetria = $response1[$i]['CAMPIMETRIA'];
            $presion_intraocular_od = $response1[$i]['PRESION_INTRAOCULAR_OD'];
            $presion_intraocular_oi = $response1[$i]['PRESION_INTRAOCULAR_OI'];
            $diagnostico = $response1[$i]['DIAGNOSTICO'];
            $plan = $response1[$i]['PLAN'];
            $observaciones = $response1[$i]['OBSERVACIONES'];
            $array1 = array(
                "ANTECEDENTES_PERSONALES" => $antecedentes_personales,
                "ANTECEDENTE_OFTALMOLOGICOS" => $antecedentes_oftalmologicos,
                "PADECIMIENTO_ACTUAL" => $pacedimiento_actual,
                "AGUDEZA_VISUAL" => $agudeza_visual,
                "OD" => $od,
                "OI" => $oi,
                "JAEGER" => $jaeger,
                "REFRACCION" =>  $refraccion,
                "PRUEBA" => $prueba,
                "EXPLORACION_OFTALMOLOGICA" => $exploracion_oftalmologica,
                "FORIAS" => $forias,
                "CAMPIMETRIA" => $campimetria,
                "PRESION_INTRAOCULAR_OD" => $presion_intraocular_od,
                "PRESION_INTRAOCULAR_OI" => $presion_intraocular_oi,
                "DIAGNOSTICO" => $diagnostico,
                "PLAN" => $plan,
                "OBSERVACIONES" => $observaciones

            );
            array_push($arrayoftalmo, $array1);
        }
        #print_r($arrayoftalmo);
        $arregloPaciente = array(
            'NOMBRE' => $infoPaciente[0]['NOMBRE'],
            "EDAD" => $infoPaciente[0]['EDAD'],
            'SEXO' => $infoPaciente[0]['SEXO'],
            'FECHA_RESULTADO' => $infoPaciente[0]['FECHA_RESULTADO_OFTALMO'],
            'ESTUDIOS' => $arrayoftalmo
        );
        print_r($arregloPaciente);
        $response = $arregloPaciente;

        break;
    default:
        # code...
        break;
}
echo $master->returnApi($response);

// function crearReporteOftalmologia($turno_id, $viz = 'url')
// {
//     $master = new Master();
//     #Recuperar info paciente
//     $infoPaciente = $master->getByProcedure('sp_informacion_paciente', [$turno_id]);
//     $infoPaciente = [$infoPaciente[count($infoPaciente) - 1]];
//     $infoPaciente[0]['TITULO'] = 'OFTALMOLOGIA';
//     $infoPaciente[0]['SUBTITULO'] = 'OFTALMOLOGIA';

//     #recuperar la informacion del Reporte de interpretacion de oftalmología
//     # recuperar los resultados de oftalmología
//     $response1 = $master->getByProcedure('sp_oftalmo_resultados_b', [null, $turno_id]);

//     $arrayoftalmo = [];

//     for ($i = 0; $i < count($response1[1]); $i++) {

//         $antecedentes_personales = $response1[$i]['ANTECEDENTES_PERSONALES'];
//         $antecedentes_oftalmologicos = $response1[$i]['ANTECEDENTES_OFTALMOLOGICOS'];
//         $pacedimiento_actual = $response1[$i]['PADECIMIENTO_ACTUAL'];
//         $agudeza_visual = $response1[$i]['AGUDEZA_VISUAL_SIN_CORRECCION'];
//         $od = $response1[$i]['OD'];
//         $oi = $response1[$i]['OI'];
//         $jaeger = $response1[$i]['JAEGER'];
//         $refraccion = $response1[$i]['REFRACCION'];
//         $prueba = $response1[$i]['PRUEBA'];
//         $exploracion_oftalmologica = $response1[$i]['EXPLORACION_OFTALMOLOGICA'];
//         $forias = $response1[$i]['FORIAS'];
//         $campimetria = $response1[$i]['CAMPIMETRIA'];
//         $presion_intraocular_od = $response1[$i]['PRESION_INTRAOCULAR_OD'];
//         $presion_intraocular_oi = $response1[$i]['PRESION_INTRAOCULAR_OI'];
//         $diagnostico = $response1[$i]['DIAGNOSTICO'];
//         $plan = $response1[$i]['PLAN'];
//         $observaciones = $response1[$i]['OBSERVACIONES'];
//         $array1 = array(
//             "ANTECEDENTES_PERSONALES" => $antecedentes_personales,
//             "ANTECEDENTE_OFTALMOLOGICOS" => $antecedentes_oftalmologicos,
//             "PADECIMIENTO_ACTUAL" => $pacedimiento_actual,
//             "AGUDEZA_VISUAL" => $agudeza_visual,
//             "OD" => $od,
//             "OI" => $oi,
//             "JAEGER" => $jaeger,
//             "REFRACCION" =>  $refraccion,
//             "PRUEBA" => $prueba,
//             "EXPLORACION_OFTALMOLOGICA" => $exploracion_oftalmologica,
//             "FORIAS" => $forias,
//             "CAMPIMETRIA" => $campimetria,
//             "PRESION_INTRAOCULAR_OD" => $presion_intraocular_od,
//             "PRESION_INTRAOCULAR_OI" => $presion_intraocular_oi,
//             "DIAGNOSTICO" => $diagnostico,
//             "PLAN" => $plan,
//             "OBSERVACIONES" => $observaciones
//         );
//         array_push($arrayoftalmo, $array1);
//     }

//     $arregloPaciente = array(
//         'ESTUDIOS' => $arrayoftalmo
//     );

//     # pie de pagina
//     $fecha_resultado = $infoPaciente[0]['FECHA_RESULTADO_OFTALMO'];
//     $nombre_paciente = $infoPaciente[0]['NOMBRE'];
//     $nombre = str_replace(" ", "_", $nombre_paciente);

//     $ruta_saved = "reportes/modulo/oftalmo/$fecha_resultado/$turno_id/";

//     # Crear el directorio si no existe
//     $r = $master->createDir("../" . $ruta_saved);
//     $archivo = array("ruta" => $ruta_saved, "nombre_archivo" => $nombre . "-" . $infoPaciente[0]['ETIQUETA_TURNO'] . '-' . $fecha_resultado);

//     $pie_pagina = array("clave" => $infoPaciente[0]['CLAVE'], "folio" => $infoPaciente[0]['FOLIO_OFTALMO'], "modulo" => 8);
//     $pdf = new Reporte(json_encode($arregloPaciente), json_encode($infoPaciente[0]), $pie_pagina, $archivo, 'oftalmologia', $viz);
//     return $pdf->build();

//     print_r($arregloPaciente);
//     #return $arregloPaciente;
// }

/*
    #primero recuperamos la informacion del paciente en responsePac
    $responsePac = $master->getByProcedure("sp_informacion_paciente",[$turno_id]);

        
    # pie de pagina
    $fecha_resultado = $responsePac[0]['FECHA_FOLDER_OF'];
    $nombre_paciente = $responsePac[0]['NOMBRE'];
    $nombre = str_replace(" ","_",$nombre_paciente);

    $ruta_saved = "reportes/modulo/oftalmo/$fecha_resultado/$id_turno/";

    # Crear el directorio si no existe
    $r = $master->createDir("../".$ruta_saved);

    if($r!=1){
        $response = "No se puedo crear el directorio.";
        break;
    }
    $archivo = array("ruta"=>$ruta_saved,"nombre_archivo"=>$nombre."-".$responsePac[0]['TURNO'].'-'.$fecha_resultado);

    $clave = $master->getByProcedure("sp_generar_clave",[]);

    $pie_pagina = array("clave"=>$clave[0]['TOKEN'],"folio"=>$responsePac[0]['FOLIO'],"modulo"=>3);

    # con el arreglo superior, creamos el pdf para conseguir la ruta antes de insertar en la tabla de mysql
    $pdf = new Reporte(json_encode($params), json_encode($responsePac[0]), $pie_pagina, $archivo, 'resultados', 'url');
    */
