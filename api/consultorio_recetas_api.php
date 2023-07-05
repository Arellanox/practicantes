<?php
include_once "../clases/master_class.php";

$master = new Master();
$api = $_POST['api'];

$id_receta = $_POST['id_receta'];
$turno_id = $_POST['turno_id'];
$nombre_generico = $_POST['nombre_generico'];
$nombre_comercial = $_POST['nombre_comercial'];
$forma_farmaceutica = $_POST['forma_farmaceutica'];
$dosis = $_POST['dosis'];
$presentacion = $_POST['presentacion'];
$frecuencia = $_POST['frecuencia'];
$via_de_administracion = $_POST['via_de_administracion'];
$duracion_de_tratamiento = $_POST['duracion_de_tratamiento'];
$indicaciones_de_uso = $_POST['indicaciones_de_uso'];
$folio = $_POST['folio'];
$activo = isset($_POST['ACTIVO']) ? null : 1;

$parametros = $master->setToNull(array(
    $id_receta,
    $turno_id,
    $nombre_generico,
    $nombre_comercial,
    $forma_farmaceutica,
    $dosis,
    $presentacion,
    $frecuencia,
    $via_de_administracion,
    $duracion_de_tratamiento,
    $indicaciones_de_uso
));

switch($api){
    //Insertar datos en la tabla consultorio_recetas
    case 1:
        $response = $master->insertByProcedure("sp_consultorio_recetas_g", $parametros);
        break;

    //buscar datos en la tabla consultorio recetas
    case 2:
        $response = $master->getByProcedure("sp_consultorio_recetas_b", [$turno_id]);
        break;

    case 3:
        break;    
        
    //Desactivar registros de recetas
    case 4:
        $response = $master->deleteByProcedure("sp_consultorio_recetas_e", [$id_receta]);
        break;    

    default:
    $response = "API no definida";
        break;    
}

echo $master->returnApi($response);