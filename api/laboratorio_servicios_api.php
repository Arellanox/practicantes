<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

$master = new Master();
$api = $_POST['api'];

$Grupo = $_POST['grupoExamen'];
$contenedores = $_POST['contenedores'];
$Equipo = $_POST['Equipo'];
$Método = $_POST['Método'];
$id_servicio = $_POST['id_servicio'];
$descripcion = $_POST['descripcion'];
$abreviatura = $_POST['abreviatura'];
$clasificacion_id = $_POST['clasificacion_id'];
$medida_id = $_POST['medida_id'];
$dias_entrega = $_POST['dias_entrega'];
$codigo_sat_id = $_POST['codigo_sat_id'];
$indicaciones = $_POST['indicaciones'];
$es_para = $_POST['es_para'];
$muestra_valores = $_POST['muestra_valor'];
$local = $_POST['local'];
$maquila_lab_id = $_POST['maquila_lab_id'];
$grupo = $_POST['grupoExamen']; # array
$metodo = $_POST['Método']; # array
$contenedores = $_POST['contenedores']; # array
$equipo = $_POST['Equipo']; # array
$valor_minimo = $_POST['valor_minimo'];
$valor_maximo = $_POST['valor_maximo'];
$sexo = $_POST['sexo_enum'];
$edad_inicial = $_POST['edad_inicial'];
$edad_final = $_POST['edad_final'];
$es_grupo = $_POST['grupos'];
$es_producto = $_POST['producto'];
$area_id = $_POST['area'];
$seleccionable = $_POST['selecionable'];
$es_para = $_POST['para'];
$costos = $_POST['costos'];

$parametros = array(
    $descripcion,
    $abreviatura,
    // $area,
    $clasificacion_id,
    // $metodo_id,
    $medida_id,
    $dias_entrega,
    $codigo_sat_id,
    $indicaciones,
    $muestra_valores,
    $local,
    $es_grupo,
    $es_producto,
    $seleccionable,
    $es_para,
    $costo,
    $utilidad,
    $precio_venta
);

switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_servicio_laboratorio_g", [
            $id_servicio,
            $descripcion,
            $abreviatura,
            $clasificacion_id,
            $medida_id,
            $dias_entrega,
            $codigo_sat_id,
            $indicaciones,
            $muestra_valores,
            $local,
            $maquila_lab_id,
            json_encode($master->getFormValues($grupo)),
            json_encode($master->getFormValues($metodo)),
            json_encode($master->getFormValues($contenedores)),
            json_encode($master->getFormValues($equipo)),
            $valor_minimo,
            strlen($valor_maximo) > 0 ? $valor_maximo : null,
            $sexo,
            $edad_inicial,
            $edad_final,
            $es_grupo,
            $es_producto,
            $area_id,
            $seleccionable,
            $es_para,
            $costos,
            $_SESSION['id']
        ]);
        break;
    case 2:
        $response = $master->getByProcedure('sp_servicio_laboratorio_b', [$id_servicio]);
        $arrayGrupo = [];
        $arrayGrupoOrden = [];
        $arrayOrden = [];
        $arrayEquipo = [];
        $arrayMetodo = [];
        $arrayContenedores = [];
        $arrayMuestras = [];
        $arrayContenedoryMuestra = [];



        for ($i = 0; $i < count($response); $i++) {

            if (!in_array($response[$i]['GRUPO_ID'], $arrayGrupo) || !in_array($response[$i]['ORDEN'], $arrayOrden)) {
                $grupo = $response[$i]['GRUPO_ID'];
                $orden = $response[$i]['ORDEN'];
                array_push($arrayGrupo, $grupo);
                array_push($arrayOrden, $orden);
                array_push($arrayGrupoOrden, array("GRUPO" => $grupo, "ORDEN" => $orden));
            }

            if (!in_array($response[$i]['EQUIPO_ID'], $arrayEquipo)) {
                $equipo = $response[$i]['EQUIPO_ID'];
                array_push($arrayEquipo, $equipo);
            }
            if (!in_array($response[$i]['METODO_ID'], $arrayMetodo)) {
                $metodo = $response[$i]['METODO_ID'];
                array_push($arrayMetodo, $metodo);
            }
            if (!in_array($response[$i]['CONTENEDOR_ID'], $arrayContenedores) || !in_array($response[$i]['MUESTRA_ID'], $arrayMuestras)) {
                $contenedores = $response[$i]['CONTENEDOR_ID'];
                $muestras = $response[$i]['MUESTRA_ID'];
                array_push($arrayContenedores, $contenedores);
                array_push($arrayMuestras, $muestras);
                array_push($arrayContenedoryMuestra, array('CONTENEDOR_ID' => $contenedores, 'MUESTRA_ID' =>  $muestras));
            }
            //     if(!in_array($response[$i]['MUESTRA_ID'], $arrayMuestras)){
            //         $muestras = $response[$i]['MUESTRA_ID'];
            //         array_push($arrayMuestras, $muestras);
            //     }
        }

        $response = array(
            "DESCRIPCION" => $response[0]['DESCRIPCION'],
            "ABREVIATURA" => $response[0]['ABREVIATURA'],
            "CLASIFICACION_ID" => $response[0]['CLASIFICACION_ID'],
            "MEDIDA_ID" => $response[0]['MEDIDA_ID'],
            "DIAS_DE_ENTREGA" => $response[0]['DIAS_DE_ENTREGA'],
            "CODIGO_SAT_ID" => $response[0]['CODIGO_SAT_ID'],
            "INDICACIONES" => $response[0]['INDICACIONES'],
            "SEXO_SERVICIO" => $response[0]['ES_PARA'],
            "GRUPOS" => empty($master->checkArray($arrayGrupoOrden)) ? null : array("GRUPO_ID" => $arrayGrupoOrden),
            "EQUIPO_ID" => empty($arrayEquipo) ? null : $arrayEquipo,
            "METODO_ID" => empty($arrayMetodo) ? null : $arrayMetodo,
            "CONTENEDORES" => empty($master->checkArray($arrayContenedoryMuestra)) ? null : array("CONTENEDOR_ID" => $arrayContenedoryMuestra),
            "LOCAL" => $response[0]['LOCAL'],
            "ES_GRUPO" =>    $response[0]['ES_GRUPO'],
            "ES_PRODUCTO" => $response[0]['ES_PRODUCTO'],
            "SELECCIONABLE" => $response[0]['SELECCIONABLE'],
            "MUESTRA_VALORES_REFERENCIA" => $response[0]['MUESTRA_VALORES_REFERENCIA'],
            "REGISTRADO_POR" => $response[0]['REGISTRADO_POR'],
            "VALOR_MINIMO" => $response[0]['VALOR_MINIMO'],
            "VALOR_MAXIMO" => $response[0]['VALOR_MAXIMO'],
            "SEXO_REFERENCIA" => $response[0]['SEXO'],
            "EDAD_INICIAL" => $response[0]['EDAD_INICIAL'],
            "EDAD_FINAL" => $response[0]['EDAD_FINAL'],
            "MAQUILA_ID" => $response[0]['MAQUILA_ID'],
            "LABORATORIO_MAQUILA" => $response[0]['LABORATORIO_MAQUILA']
        );
        break;
    case 3:
        #obtener lista de estudios por id_grupo
        $grupo_id = $_POST['grupo_id'];

        $response = $master->getByProcedure('sp_servicios_por_grupo_b', [$grupo_id, $servicio_id]); #<-- Falta obtener grupos por servicio 
        break;
    default:

        $response = "Api no definida.";
        break;
}

echo $master->returnApi($response);
