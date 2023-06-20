<?php
include_once "../clases/master_class.php";

$master = new Master();
$api = $_POST['api'];

#insertar en consultorio
$id_consultorio2 = $_POST['id_consultorio2'];
$turno_id = $_POST['turno_id'];
$notas_consulta = $_POST['notas_consulta'];
$diagnostico = $_POST['diagnostico'];
$plan_tratamiento = $_POST['plan_tratamiento'];
$activo = isset($_POST['ACTIVO']) ? null : 1;

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
));



switch ($api) {
        #insertar datos en la tabla consultorio2_consulta
    case 1:
        $response = $master->insertByProcedure("sp_consultorio2_consulta_g", $parametros);
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
