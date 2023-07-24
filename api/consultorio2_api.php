<?php
include_once "../clases/master_class.php";
include_once "../clases/token_auth.php";
$master = new Master();
$api = $_POST['api'];

#insertar en consultorio
$id_consultorio2 = $_POST['id_consultorio2'];
$turno_id = $_POST['turno_id'];
$notas_consulta = $_POST['notas_consulta'];
$diagnostico = $_POST['diagnostico'];
$plan_tratamiento = $_POST['plan_tratamiento'];
$activo = isset($_POST['ACTIVO']) ? null : 1;
$consulta_terminada = $_POST['consulta_terminada'];
$folio = $_POST['folio'];

#Insertar en Iniciar consulta medica
$motivo_consulta = $_POST['motivo_consulta'];
$creado_por=$_SESSION['id'];

#Insertar en tabla consultorio2_diagnostico
$diagnostico2 = $_POST['diagnostico2'];

#Desactivar en la tabla consultorio2_diagnostico
$fecha_creacion = $_POST['fecha_creacion'];

$parametros_motivo = $master->setTonull(array(
    $turno_id,
    $motivo_consulta,
    $creado_por
));

//guarda todos los datos de consultorio incluyendo la tabla de consultorio2_diagnosticos
$parametros = $master->setToNull(array(
    $id_consultorio2,
    $turno_id,
    $notas_consulta,
    $diagnostico,
    $diagnostico2,
    $plan_tratamiento,
    $consulta_terminada
));



switch ($api) {
        #insertar datos en la tabla consultorio2_consulta
    case 1:
        $response = $master->insertByProcedure("sp_consultorio2_consulta_g", $parametros);

        //crear la ruta para los pdf
        if($consulta_terminada == 1){
            $url_reporte = $master->reportador($master, $turno_id, 19, "consultorio2", "url", 0, 0, 0);
            $url_recetas = $master->reportador($master, $turno_id, -2, "receta", "url", 0, 0, 0);
            $url_solicitud_estudios = $master->reportador($master, $turno_id, -3, "solicitud_estudios", "url", 0, 0, 0);

            $rutas = ["RUTA_REPORTE"=> $url_reporte, "RUTA_RECETAS"=> $url_recetas, "RUTA_SOLICITUDES" => $url_solicitud_estudios];
            foreach ($rutas as $key => $valor){
                $a = $master->updateByProcedure("sp_reportes_actualizar_ruta", array("consultorio2_consulta", $key, $valor, $turno_id, null));
            }
        }
        break;


    #Recuperar datos en la tabla consultorio2_consulta 
    case 2:
        $response = $master->getByProcedure("sp_consultorio2_consulta_b", [$turno_id, $id_consultorio2]);
        break;


        #Guarda el motivo de consulta <--Listo
        #recupera los mismos datos
    case 5:
        $response = $master->insertByProcedure("sp_consultorio2_motivo_g", $parametros_motivo);
        break;

    //Recupera los datos de la tabla consultorio2_diagnostico    
    case 6:
        $response = $master->getByProcedure("sp_consultorio2_diagnosticos_b", [$turno_id]);
        break;
    
    //Descativa los diagnosticos seleccionados    
    case 7:
        $response = $master->deleteByProcedure("sp_consultorio2_diagnosticos_e", [$fecha_creacion]);
        break;    

    default:
        $response = "API no definida";
        break;
}

echo $master->returnApi($response);
