<?php
include "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();

$api = $_POST['api'];
$equipo =  $_POST['Enfriador'];
$termometro = isset($_POST['Termometro']) ? $_POST['Termometro'] : null;
$usuario = $_SESSION['id'];
$lectura = isset($_POST['lectura']) ? $_POST['lectura'] : null;
$observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : null;
$id_registro_temperatura = $_POST['id_registro_temperatura'];
$turno = $_POST['turno'];

/* 

die();
$firma = str_replace('data:image/png;base64,', '', $firma);
$firma = str_replace(' ', '+', $firma);
$firma = base64_decode($firma); */


#Datos para actualizar la configuracion del area de temperatura
$matutino_inicio = $_POST['matutino_inicio'];
$matutino_final = $_POST['matutino_final'];
$vespertino_inicio = $_POST['vespertino_inicio'];
$vespertino_final = $_POST['vespertino_final'];
$domingos = $_POST['domingos'];


$anho = $_POST['anho'];
$folio = $_POST['folio'];


#datos que manda el supervisor para liberar un dia
$fecha_inicial = $_POST['FechaInicio'];
$fecha_final = $_POST['FechaFinal'];
#datos que manda el supervisor para liberar un dia 2.0
$estatus = $_POST['estatus'];


#comentario que mandara el supervisor a los registros
$comentario = $_POST['comentario'];

#ID de comentario para elimanr un comentario
$id_comentario = $_POST['id_comentario'];

#Variables para insertar o actualizar los termometros de los equipos 
$id_temperaturas_equipos  = isset($_POST['id_temperaturas_equipos']) ? $_POST['id_temperaturas_equipos'] : null;
$factor_correcion = isset($_POST['factor_correcion']) ? $_POST['factor_correcion'] : null;


#checkFactorCorrecion para checar si necesita aplicar el factor de correccion que tiene el termometro
$checkFactorCorrecion = $_POST['checkFactorCorrecion'];

// Obtener la imagen en base64 desde la solicitud, estas son las 3 capas de imagenes de la tabla de temperatura, Tabla, Dots, Canva
$UrlImg = $_POST['UrlImg'];
$NameImg = $_POST['NameImg'];

$parametros =  array(
    $equipo,
    $termometro,
    $usuario,
    $lectura,
    $observaciones,
    $id_registro_temperatura,
    $checkFactorCorrecion
);





$parametros_g = array(
    $fecha_inicial,
    $fecha_final,
    $observaciones,
    $usuario,
    $equipo,
    $turno,
    $termometro
);

$parametros_a = array(
    $id_registro_temperatura,
    $estatus,
    $usuario
);

$comentarios = array(
    $comentario,
    $usuario,
    $id_registro_temperatura
);

$comentarios_delete = array(
    $id_comentario,
    $usuario
);

$configuracion = array(
    $matutino_inicio,
    $matutino_final,
    $vespertino_inicio,
    $vespertino_final,
    $domingos,
    $usuario
);

$equipos_termometros = array(
    $equipo,
    $termometro,
    $usuario,
    $id_temperaturas_equipos,
    $factor_correcion
);



switch ($api) {

    case 1:
        # Insertar un nuevo registro de temperatura
        $response = $master->insertByProcedure("sp_temperatura_g", $parametros);
        break;
    case 2:
        #buscar resultados de los registros de temperatura
        $response = $master->getByProcedure("sp_temperaturas_resultados_b", [$equipo]);
        break;
    case 3:
        $response = $master->getByProcedure("sp_temperatura_detalle_b", [$folio]);
        break;
    case 4:
        #Actualizar temperatura
        break;
    case 5:
        #Supervisor Liberar un  dia
        $response = $master->insertByProcedure("sp_temperatura_supervisor_g", $parametros_g);
        break;

    case 6:
        #Liberar un registro
        $response = $master->insertByProcedure("sp_temperatura_supervisor_a", $parametros_a);
        break;
    case 7:
        #Llenar tabla del formato PDF, pasar ID del FOLIO
        $response = $master->getByNext('sp_temperatura_formato_b', [$folio]);

        $result = array();
        $i = 1;
        foreach ($response[0] as $key => $e) {
            $dia = $e['DIA'];
            $turno = $e['TURNO'];
            $valor = $e['valor'];
            $hora = $e['HORA'];
            $anho = $e['ANHO'];
            $mes = $e['MES'];
            $observaciones = $e['OBSERVACIONES'];
            $color = $e['MODIFICADO'] == 0 ?  "blue" : "mostaza";
            $id_registro = $e['ID_REGISTRO_TEMPERATURA'];
            $url_tabla = $e['RUTA_TABLA'];
            if (!isset($result[$dia])) {
                $result[$dia] = array();
            }

            // if ($i === 3) {
            //     $i = 1;
            // }

            if ($turno === "MATUTINO") {
                $i = 1;
            } else {
                $i = 2;
            }

            $result[$dia][$i] = array("valor" => $valor, "color" => $color, "id" => $id_registro, "hora" => $hora);
            $i++;
        }


        foreach ($response[1] as $key => $e) {
            # code...
            $intervalo_min = $e['INTERVALO_MIN'];
            $intervalo_max = $e['INTERVALO_MAX'];
            $equipo = $e['ENFRIADOR'];
            $equipo_marca = $e['ENFRIADOR_MARCA'];
            $equipo_modelo = $e['ENFRIADOR_MODELO'];
            $equipo_numero_serie = $e['ENFRIADOR_NUMERO_SERIE'];
            $termometro_marca = $e['TERMOMETRO_MARCA'];
            $termometro_id = $e['TERMOMETRO_ID'];
            $termometro_factor_correcion = $e['FACTOR_DE_CORRECCION'];
        }

        foreach ($response[2] as $key => $e) {
            # code...
            $termometro_marca = $e['TERMOMETRO_MARCA'];
            $termometro_id = $e['TERMOMETRO_ID'];
            $termometro_factor_correcion = $e['FACTOR_DE_CORRECCION'];
        }


        $localizacion = null;
        $response = [];
        $response['EQUIPO']['OBSERVACIONES'] = $observaciones;
        $response['EQUIPO']['ANHO'] = $anho;
        $response['EQUIPO']['MES'] = $mes;
        $response['EQUIPO']['FOLIO'] = $folio;
        $response['EQUIPO']['LOCALIZACION'] = is_null($localizacion) ? 'N/A' : $localizacion;
        $response['EQUIPO']['INTERVALO_MIN'] = is_null($intervalo_min) ? 'N/A' : $intervalo_min;
        $response['EQUIPO']['INTERVALO_MAX'] = is_null($intervalo_max) ? 'N/A' : $intervalo_max;
        $response['EQUIPO']['URL_TABLA'] = is_null($url_tabla) ? 'N/A' : $url_tabla;
        $response['EQUIPO']['EQUIPO_NOMBRE'] = is_null($equipo) ? 'N/A' : $equipo;
        $response['EQUIPO']['EQUIPO_MARCA'] = is_null($equipo_marca) ? 'N/A' : $equipo_marca;
        $response['EQUIPO']['EQUIPO_MODELO'] =  is_null($equipo_modelo) ? 'N/A' : $equipo_modelo;
        $response['EQUIPO']['EQUIPO_NUMERO_SERIE'] = is_null($equipo_numero_serie) ? 'N/A' : $equipo_numero_serie;
        $response['EQUIPO']['TERMOMETRO_MARCA'] = is_null($termometro_marca) ? 'N/A' : $termometro_marca;
        $response['EQUIPO']['TERMOMETRO_ID'] = is_null($termometro_id) ? 'N/A' : $termometro_id;
        $response['EQUIPO']['FACTOR_CORRECCION'] = is_null($termometro_factor_correcion) ? 'N/A' : $termometro_factor_correcion;


        $response['DIAS'] = $result;


        break;
    case 8:
        #Agregar Comentarios Superivisor 
        $response = $master->insertByProcedure('sp_temperaturas_comentarios_g', $comentarios);
        break;
    case 9:
        #Buscar comentarios por el ID de registro de la temperatura
        $response = $master->getByProcedure("sp_temperaturas_comentarios_b", [$id_registro_temperatura]);
        break;
    case 10:
        #Eliminar un comentario hecho por el supervisor
        $response = $master->insertByProcedure('sp_temperaturas_comentarios_e', $comentarios_delete);
        break;
    case 11:
        #Obtener toda la configuracion del area de temperaturas
        $response = $master->getByProcedure('sp_temperaturas_configuracion_b', []);
        break;
    case 12:
        #Actualizar la configuracion del area de temperaturas
        $response = $master->insertByProcedure('sp_temperaturas_configuracion_a', $configuracion);
        break;
    case 13:
        $response = $master->getByProcedure('sp_temperaturas_equipos_termometros_b', [$equipo]);
        break;
    case 14:
        $response = $master->insertByProcedure('sp_temperaturas_equipos_termometros_g', $equipos_termometros);
        break;
    case 15:
        if ($UrlImg !== null) {

            // Eliminar el encabezado de base64 para obtener solo los datos de la imagen
            $base64Data = str_replace('data:image/png;base64,', '', $UrlImg,);

            // Generar un nombre único para la imagen
            $imageName = $NameImg . '.png';

            // Guardar la imagen en la carpeta deseada
            $path = '../archivos/sistema/capas_temperaturas/' . $imageName;
            file_put_contents($path, base64_decode($base64Data));

            $path = 'http://localhost/practicantes/archivos/sistema/capas_temperaturas/' . $imageName;

            $SubirFormato = array(
                $folio,
                $usuario,
                $termometro,
                $path,
                $observaciones
            );

            // Enviar una respuesta indicando que la imagen se ha guardado correctamente
            $response = $master->insertByProcedure('sp_temperatura_formato_g', $SubirFormato);
        } else {
            $response = "No se inserto la imagen por que no llego";
        }
        break;
    case 16:
        $response = $master->getByProcedure('sp_temperaturas_termometros_usados_b', [$folio]);
        break;
    case 17:
        //Funcion para registrar temperaturas desde el QR
        $response = loginTemperaturas($_POST['user'], $_POST['pass'], $equipo, $termometro, $lectura, $observaciones, null, $checkFactorCorrecion);
        break;
    case 18:
        $tipo = "EquiposTemperatura";
        $equipoID = $equipo;
        $codeContents = "http://localhost/practicantes/vista/movil/temperatura/?equipo=$equipoID";
        $nombre = 'Equipo-' . $equipoID;
        $response = ["qr" => $master->generarQRURL($tipo, $codeContents, $nombre), "url" => $codeContents, "fileName" => $nombre];
        break;
    default:
        $response = "Api no definida.";
}


function loginTemperaturas($user, $password, $equipo, $termometro, $lectura, $observaciones, $id_registro_temperatura, $checkFactorCorrecion)
{
    $master = new Master();
    $activo = 1;
    $bloqueado = 0;
    $parametros = [$user, $activo, $bloqueado];
    $result = $master->getByProcedure("sp_usuarios_login_b", $parametros);

    if (count($result) > 0) {
        if (password_verify($password, $result[0]['CONTRASENIA'])) {
            $parametros_movil =  array(
                $equipo,
                $termometro,
                $result[0]['ID_USUARIO'],
                $lectura,
                $observaciones,
                $id_registro_temperatura,
                $checkFactorCorrecion
            );

            $response = $master->insertByProcedure("sp_temperatura_g", $parametros_movil);
        } else {
            $response =  "Contrasena Incorrecta";
        }
    } else {
        $response = "Usuario Incorrecto";
    }

    return $response;
}

echo $master->returnApi($response);
