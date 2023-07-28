<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

#api
$api = $_POST['api'];

#buscar
$id = $_POST['id'];

#insertar
$id_equipo = $_POST['id_equipo'];
$cve_inventario = $_POST['cve_inventario'];
$uso = $_POST['uso'];
$numero_serie = $_POST['numero_serie'];
$frecuencia_mantenimiento = $_POST['frecuencia_mantenimiento'];
$numero_pruebas = $_POST['numero_pruebas'];
$calibracion = $_POST['calibracion'];
$numero_pruebas_calibracion = $_POST['numero_pruebas_calibracion'];
$fecha_ingreso_equipo = $_POST['fecha_ingreso_equipo'];
$fecha_inicio_uso = $_POST['fecha_inicio_uso'];
$valor_del_equipo = $_POST['valor_del_equipo'];
$descripcion = $_POST['descripcion'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$foto = $_POST['foto'];
$status = $_POST['status'];

$parametros = array(
    $id_equipo,
    $cve_inventario,
    $uso,
    $numero_serie,
    $frecuencia_mantenimiento,
    $numero_pruebas,
    $calibracion,
    $numero_pruebas_calibracion,
    $fecha_ingreso_equipo,
    $fecha_inicio_uso,
    $valor_del_equipo,
    $descripcion,
    $marca,
    $modelo,
    $foto,
    $status
);

$response = "";

$master = new Master();
switch ($api) {
    case 1:
        # insertar
        $dir = $master->urlComodin.$master->urlEquiposLaboratorio.$descripcion."/";
        $r = $master->createDir($dir);

        if($r==1){
            #si se cre correctamente el directorio, 
            #movemos el archivo a la caperta indicada
            if(empty($_FILES)){    
                $response = $master->insertByProcedure("sp_laboratorio_equipos_g", $parametros);
            } else {
                $return = $master->guardarFiles($_FILES,'foto',$dir,$descripcion);
                
                if(!empty($return)){
                    # si el arreglo que regresa el subir los archivos no esta vacio,
                    # insertarmos el registro en la base de datos

                    #convertirmos el arreglo que regresa la funcion guardarFiles a json,
                    #para poder enviarlo a la base de datos
                    $fotos = json_encode($return);
                    $parametros[14] = $fotos;
                    
                    $response = $master->insertByProcedure("sp_laboratorio_equipos_g", $parametros);
                } else {
                    $response = "No se puedieron mover los archivos.";
                }
            }
        } else {
            $response = "No se pudo crear el directorio.";
        }

      
        
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_laboratorio_equipos_b", [$id]);
        break;

    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_laboratorio_equipos_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_laboratorio_equipos_e", [$id]);
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
