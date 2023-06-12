<?php
#include "../interfaces/iMetodos.php";
include "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/Pdf.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    //exit;
}

$master = new Master();
$api = $_POST['api'];
$id_area = $_POST['id_area'];
$otros_servicios = $_POST['otros_servicios']; #activar con valor 1
$abreviatura = $_POST['abreviatura']; #activar con valor 1
$confirmar = $_POST['confirmar'];
$id_turno = $_POST['id_turno'];
$id_servicio = $_POST['id_servicio'];
$id_grupo = $_POST['id_grupo'];
$comentario = $_POST['comentario'];
$tipo = $_POST['tipo_archivo'];
$comentario_capturas = $_POST['comentario_capturas'];
$id_paciente_detalle = $_POST['id_paciente_detalle'];

# para buscar servicios con precios establecidos al cliente
$paquete_id = $_POST['paquete_id'];
$cliente_id = $_POST['cliente_id'];

#filtrar servicios y grupos 
$tipgrupo = isset($_POST['tipgrupo']) ? $_POST['tipgrupo'] : null;

$id_servicio = $_POST['id_servicio'];
$descripcion = $_POST['descripcion'];
$abreviatura = $_POST['abreviatura'];
$area = $_POST['area'];
$clasificacion_id = $_POST['clasificacion_id'];
$metodo_id = $_POST['metodo_id'];
$medida_id = $_POST['medida_id'];

$dias_entrega = $_POST['dias_entrega'];
$codigo_sat_id = $_POST['codigo_sat_id'];
$indicaciones = $_POST['indicaciones'];
$muestra_valores = $_POST['muestra_valores'];
$local = $_POST['local'];

$es_grupo = $_POST['es_grupo'];
$es_producto = $_POST['es_producto'];
$seleccionable = $_POST['seleccionable'];
$es_para = $_POST['es_para'];
$costo = $_POST['costo'];
$utilidad = $_POST['utilidad'];
$precio_venta = $_POST['precio_venta'];
$duracion = $_POST['duracion']; # duracion del estudio, medido en minutos.

$parametros = array(
    $id_servicio,
    $descripcion,
    $abreviatura,
    $area,
    $clasificacion_id,
    $metodo_id,
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
    $precio_venta,
    $duracion
);

// print_r($_POST['contenedores']);

// foreach ($_POST['contenedores'] as $key => $value) {
//     echo $key;
//     echo "</br>";
//     print_r($value);
//     echo "</br>";
// }

// print_r($_POST);
// return false;

switch ($api) {
    case 1:
        #insert
        $response = $master->insertByProcedure("sp_servicios_g", $parametros);
        if (is_numeric($response)) {
            echo json_encode(array(
                'response' => array(
                    'code' => 1,
                    'lastId' => $response
                )
            ));
        } else {
            echo json_encode(array(
                'response' => array(
                    'code' => 2,
                    'msj' => $response
                )
            ));
        }
        break;
    case 2:
        #getall

        $response = $master->getByProcedure('sp_servicios_b', array(null, $tipgrupo, $id_area, $otros_servicios, $abreviatura));

        if (is_array($response)) {
            $newResponse = array();
            // foreach($response as $test){
            //     $groups = $master->getByProcedure('sp_detalle_grupo_b',array(null,$test['ID_SERVICIO']));
            //
            //     if(count($groups)>0){
            //         $test['DETALLE_GRUPOS'] = $groups;
            //     } else {
            //         $test['DETALLE_GRUPOS'] = 'NO PERTENECE A NINGUN GRUPO';
            //     }
            //
            //     $newResponse[] = $test;
            // }

            echo json_encode($response);
        } else {
            echo json_encode(array(
                'response' => array(
                    'code' => 2,
                    'msj' => $response
                )
            ));
        }
        break;
    case 3:
        #getbyid
        $id = $_POST['id'];
        $response = $master->getByProcedure('sp_servicios_b', array($id, null, $id_area, $otros_servicios, $abreviatura));
        if (is_array($response)) {
            echo json_encode(array(
                'response' => array(
                    'code' => 1,
                    'data' => $response
                )
            ));
        } else {
            echo json_encode(array(
                'response' => array(
                    'code' => 2,
                    'msj' => $response
                )
            ));
        }
        break;

    case 4:
        #update
        $array_slice = array_slice($_POST, 0, 20);
        $values = $master->mis->getFormValues($array_slice);
        $response = $master->updateByProcedure('sp_servicios_g', $values);
        if (is_numeric($response)) {
            echo json_encode(array(
                'response' => array(
                    'code' => 1,
                    'affected' => $response
                )
            ));
        } else {
            echo json_encode(array(
                'response' => array(
                    'code' => 2,
                    'msj' => $response
                )
            ));
        }
        break;
    case 5:
        #delete
        $response = $master->deleteByProcedure('sp_servicios_e', array($id));
        if (is_numeric($response)) {
            echo json_encode(array(
                'response' => array(
                    'code' => 1,
                    'affected' => $response
                )
            ));
        } else {
            echo json_encode(array(
                'response' => array(
                    'code' => 2,
                    'msj' => $response
                )
            ));
        }
        break;
    case 6:
        #recuperar todos los hijos de un padre
        $padre = $master->mis->getFormValues(array_slice($_POST, 0, 1));
        $response = $master->getByProcedure('sp_servicios_b', array($id, $padre, $id_area, $otros_servicios, $abreviatura));

        if (is_array($response)) {
            echo json_encode(array(
                'response' => array(
                    'code' => 1,
                    'data' => $response
                )
            ));
        } else {
            echo json_encode(array(
                'response' => array(
                    'code' => 2,
                    'msj' => $response
                )
            ));
        }
        break;
    case 7:
        #recuperar todos los servicicos que sean grupos
        $response = $master->getByProcedure('sp_servicios_b', array(null, 1, $id_area, $otros_servicios, $abreviatura));

        if (is_array($response)) {
            $newResponse = array();
            // foreach ($response as $group) {
            //     $tests = $master->getByProcedure('sp_detalle_grupo_b',array($group['ID_SERVICIO'],null));
            //     if (sizeof($tests)>0) {
            //         $group['DETALLE_ESTUDIOS'] = $tests;
            //     } else {
            //         $group['DETALLE_ESTUDIOS'] = 'NO TIENE ESTUDIOS ASOCIADOS';
            //     }

            //     $newResponse[] = $group;
            // }
            echo json_encode(array(
                'response' => array(
                    'code' => 1,
                    'data' => $response
                )
            ));
        } else {
            echo json_encode(array(
                'response' => array(
                    'code' => 1,
                    'data' => $response
                )
            ));
        }
        break;
    case 8:

        $response = $master->getByProcedure('sp_servicios_b', array(null, null, $id_area, $otros_servicios, $abreviatura));
        echo $master->mis->returnApi($response);
        break;

    case 9:
        # recuperar solo los servicios que sean grupos,
        # los estudios que no tengan hijos y
        # los estudios que pertenezcan a la lista de precios del cliente seleccionado
        $response = $master->getByProcedure('sp_servicios_padres_b', [$id_area, $paquete_id, $cliente_id]);
        echo $master->returnApi($response);
        break;
    case 10:
        #Cargar los resultados (reportes) de las distintas areas

        # carpeta de destino para los reportes
        $destination = "/archivos/reportes/";
        $destinatio_sql = "http://localhost/nuevo_checkup";

        # obtener el nombre del area para crear la carpeta
        $area_result = $master->getByProcedure('sp_areas_b', [$id_area, null]);
        $area_label = $area_result[0]['DESCRIPCION'];

        $dir = ".." . $destination . $area_label . '/' . $id_turno . "/";
        $dir_base = $destination . $area_label . '/' . $id_turno . "/";

        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                echo "no pudo crear el directorio. $dir";
                exit;
            }
        }
        // $urlJSON = $master -> guardarFiles($_FILES, $dir, ['1', '2'], $id_turno.$id_servicio);
        // print_r ($urlJSON);

        if (!empty($_FILES['reportes']['name'])) {
            $next = 0;
            foreach ($_FILES['reportes']['name'] as $key => $value) {
                $extension = pathinfo($_FILES['reportes']['name'][$key], PATHINFO_EXTENSION);

                # obtenemos la ruta temporal del archivo
                ## $tmp_name = $_FILES['reportes']['tmp_name'][$key];
                $tmp_name = $_FILES['reportes']['tmp_name'][$key];

                $tipo_label = "INTERPRETACION";

                if ($tipo == 2) {
                    $tipo_label = "CAPTURA";
                }

                $url = "$destinatio_sql$dir_base$id_turno" . "_$id_servicio" . "_$tipo_label" . "_$next." . $extension;

                if ($tipo == 2) {
                    $imagenes = array('URL' => $url, 'EXTENSION' => $extension);
                }

                #insertamos el registro en la tabla de resultados reportes
                $response = $master->insertByProcedure('sp_resultados_reportes_g', [$id_turno, $id_servicio, $url, $comentario, $tipo, json_encode($imagenes), $comentario_capturas]);

                if (is_numeric($response)) {
                    #cambiamos de lugar el archivo
                    try {
                        move_uploaded_file($tmp_name, $dir . $id_turno . "_$id_servicio" . "_$tipo_label" . "_$next." . $extension);
                    } catch (\Throwable $th) {
                        # si no se puede subir el archivo, desactivamos el resultado que se guardo en la base de datos
                        $e = $master->deleteByProcedure('sp_resultados_reportes_e', [$response[0]['LAST_ID']]);
                    }
                }
                $next++;
            }
            echo $master->returnApi($response);
        } else {
            echo "No hay archivos.";
        }

        break;
    case 11:
        # recupera todos los servicios que suben reportes o imagenes como resultado
        # de un turno.

        $response = array();
        $response1 = $master->getByNext('sp_detalle_turno_b', [$id_turno, $id_area]);

        for ($i = 0; $i < count($response1[0]); $i++) {
            # en response[0] llegan la interpretacion o las interpretacion (en caso de que no se le haya mandando algun filtro).
            $turno = $response1[0][$i]['ID_TURNO'];
            $area = $response1[0][$i]['AREA_ID'];

            #filtramos solo las capturas para ese turno y esa area.
            $subconjunto_imagen = array_filter($response1[1], function ($obj) use ($turno, $area) {
                $r = $obj['AREA_ID'] == $area && $obj['TURNO_ID'] == $turno;
                return $r;
            });

            # convertir en arreglo las capturas.
            $capturas = array();
            foreach ($subconjunto_imagen as $current) {
                $current['CAPTURAS'] = json_decode($current['CAPTURAS'], true);
                $capturas[] = $current;
            }

            # agregamos un espacio para en el arreglo de las interpretacion para guardar las imagenes.
            $response1[0][$i]['IMAGENES'] = $capturas;
        }


        // for ($i = 0; $i < count($response); $i++) {
        //     $newImg = array();
        //     $response[$i]['IMAGENES'] = json_decode($response[$i]['IMAGENES'], true);

        //     for ($j = 0; $j < count($response[$i]['IMAGENES']['data']); $j++) {
        //         $newImg[] = json_decode($response[$i]['IMAGENES']['data'][$j], true);
        //     }

        //     $response[$i]['IMAGENES'] = $newImg;

        // $response['INTERPRETACION'] = $response1[0][0];     
        // $response['CAPTURAS'] = $capturas;
        // $response = array();

        $response = $response1[0];
        echo $master->returnApi($response);
        break;
    case 12:

        if (!empty($_FILES['reportes']['name'])) {
            $cont = 0;
            foreach ($_FILES['reportes']['name'] as $key => $value) {
                $extension = pathinfo($_FILES['reportes']['name'][$key], PATHINFO_EXTENSION);
                switch (strtolower($explode[1])) {
                    case 'pdf':
                    case 'docx':
                    case 'xlsx':
                    case 'pptx':
                    case 'doc':
                        $tipo = 1; # identificacion que es un archivo.
                        break;
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'bmp':
                    case 'webp':
                        $tipo = 2; # identifica que es una imagen.
                        break;

                    default:
                        $tipo = null;
                        break;
                }
            }
            echo $master->returnApi($response);
        } else {
            echo "vacio";
        }
        break;
    case 13: #NO USAR
        # para crear los reportes de LABORATORIO

        # informacion general del paciente
        $infoPaciente = $master->getByProcedure("sp_informacion_paciente", [$id_turno]);

        #Estudios solicitados por el paciente
        $clasificaciones = $master->getByProcedure('sp_laboratorio_clasificacion_examen_b', [null, 6]);
        $response = $master->getByProcedure("sp_cargar_estudios", [$id_turno, 6]);
        $responsePac = $master->getByProcedure("sp_informacion_paciente", [$id_turno]);
        $arrayGlobal = array(
            'areas' => array()
        );

        # filtramos el arreglo principal y obtenemos aquellos estudios
        # que tienen valor absoluto.
        $serv_var_abs_obj = array_filter($response, function ($obj) {
            $return = $obj['TIENE_VALOR_ABSOLUTO'] == 1;
            return $return;
        });

        $serv_var_abs = ordenarResultados($serv_var_abs_obj, "VALORES ABSOLUTOS");
        $valores_absolutos = $serv_var_abs['estudios'][0]['analitos'];

        for ($i = 0; $i < count($clasificaciones); $i++) {
            $clasificacion_id = $clasificaciones[$i]['ID_CLASIFICACION'];
            # sacamos arrays individuales por clasificacion de examen
            $servicios = array_filter($response, function ($obj) use ($clasificacion_id) {
                $return = $obj['CLASIFICACION_ID'] == $clasificacion_id;
                return $return;
            });

            # como no estamos seguros que de que se encuentren todas las clasificaciones 
            # en un paciente, evaluamos que el array no este vacio.
            #print_r($servicios);

            if (!empty($servicios)) {

                $aux = ordenar($servicios, $clasificaciones[$i]['DESCRIPCION'], $id_turno);

                $arrayGlobal['areas'][] = $aux;
            }
        }
        // echo "================================================================";
        // echo "<br>";


        # habra estudios que no tengan clasificacion, esos el servidor las regresa con id 0
        # como el id 0 no existe dentro de la tabla de clasificaciones, el algoritmo de arriba los ignora
        # por tanto se tiene que realizar un algoritmo similar pero con el filtro en 0.
        $servicios = array_filter($response, function ($obj) {
            $return = $obj['CLASIFICACION_ID'] == 0;
            return $return;
        });

        if (!empty($servicios)) {
            // $aux = ordenarResultados($servicios,"OTROS ESTUDIOS");
            $aux = ordenar($servicios, "NINGUNA", $id_turno);
            // $arrayGlobal['areas'][]= $aux;
        }

        // print_r($arrayGlobal);
        // print_r($responsePac);

        //JSON para etiquetas (toma de muestra servicios)
        $res_toma_muestra_serv = $master->getByProcedure('sp_toma_de_muestra_servicios_b', [$id_paciente_detalle, $id_area, $id_turno]);
        $respuesta = array(json_encode($res_toma_muestra_serv));
        echo json_encode($respuesta);

        $array = array(
            "nombre" => "JOSUE DE LA CRUZ ARELLANO",
            "fecha_hora_toma" => "fecha",
            "folio" => "1",
            "edad" => "1",
            "sexo" => "binario",
            "contenedores" => array(
                array(
                    "contenedor" => "tubo rojo",
                    "tipo_muestra" => "sangre",
                    "estudios" => array(
                        array(
                            "clave" => "ES6",
                        ),
                        array(
                            "clave" => "QS4",
                        )
                    )
                ),
                array(
                    "contenedor" => "frasco",
                    "tipo_muestra" => "orina",
                    "estudios" => array(
                        array(
                            "clave" => "ego"
                        )
                    )
                )
            )
        );
        #Case incompleto
        $pdf = new Reporte(json_encode($arrayGlobal), json_encode($responsePac[0]), null, null, 'resultados', 'url');
        $pdf->build();

        break;

    case 14:
        # generar las etiquetas de laboratorio
        $infoPaciente = $master->getByProcedure('sp_informacion_paciente', [$id_turno]);


        $infoEtiqueta = $master->getByProcedure('sp_toma_de_muestra_servicios_b', [null, 6, $id_turno]);

        $arrayEtiqueta = [];
        $arrayEtiquetaEstudios = [];
        $content = "";
        $muestra = "";
        for ($i = 0; $i < count($infoEtiqueta); $i++) {

            for ($e = 0; $e < count($infoEtiqueta); $e++) {

                if ($infoEtiqueta[$i]['CONTENEDOR'] == $infoEtiqueta[$e]['CONTENEDOR'] && $infoEtiqueta[$i]['MUESTRA'] == $infoEtiqueta[$e]['MUESTRA']) {
                    $arregloEtiqueta = array('ABREVIATURA' => $infoEtiqueta[$e]['ABR']);
                    array_push($arrayEtiquetaEstudios, $arregloEtiqueta);
                }
            }


            if ($content !== $infoEtiqueta[$i]['CONTENEDOR']) {
                $content = $infoEtiqueta[$i]['CONTENEDOR'];
                $muestra = $infoEtiqueta[$i]['MUESTRA'];
                $array1 = array(
                    'CONTENEDOR' => $infoEtiqueta[$i]['CONTENEDOR'],
                    'MUESTRA' => $infoEtiqueta[$i]['MUESTRA'],
                    'ESTUDIOS' => $arrayEtiquetaEstudios,
                );
                array_push($arrayEtiqueta, $array1);
                $arrayEtiquetaEstudios = [];
            } else if ($muestra !== $infoEtiqueta[$i]['MUESTRA']) {
                $content = $infoEtiqueta[$i]['CONTENEDOR'];
                $muestra = $infoEtiqueta[$i]['MUESTRA'];
                $array1 = array(
                    'CONTENEDOR' => $infoEtiqueta[$i]['CONTENEDOR'],
                    'MUESTRA' => $infoEtiqueta[$i]['MUESTRA'],
                    'ESTUDIOS' => $arrayEtiquetaEstudios,
                );
                array_push($arrayEtiqueta, $array1);
                $arrayEtiquetaEstudios = [];
            }
        }

        $arregloPaciente = array(
            'NOMBRE' => $infoPaciente[0]['NOMBRE'],
            'FECHA_TOMA' => $infoPaciente[0]['FECHA_TOMA'],
            "FOLIO" => $infoPaciente[0]['FOLIO'],
            "EDAD" => $infoPaciente[0]['EDAD'],
            'SEXO' => $infoPaciente[0]['SEXO'],
            'BARRAS' => $infoPaciente[0]['CODIGO_BARRAS'],
            'CONTENEDORES' => $arrayEtiqueta
        );

        $arrayPacienteEtiqueta = array($arregloPaciente);

        // print_r($arrayPacienteEtiqueta);
        // print_r($arrayPacienteEtiqueta);

        $pdf = new Reporte(json_encode($arrayPacienteEtiqueta[0]), null, null, null, 'etiquetas', 'url');
        $pdf->build();
        break;
    case 15:
        #getall
        $response = $master->getByProcedure('sp_servicios_seleccionable', array(null, $tipgrupo, $id_area, $otros_servicios, $abreviatura));

        if (is_array($response)) {
            $newResponse = array();
            echo json_encode($response);
        } else {
            echo json_encode(array(
                'response' => array(
                    'code' => 2,
                    'msj' => $response
                )
            ));
        }
        break;

    case 16:
        #Recupera el detalle de un servicio (Grupo o servicio);
        $response = $master->getByProcedure('sp_detalle_grupo_b', [$id_grupo, $id_servicio]);
        echo $master->returnApi($response);
        exit;
        break;
    default:
        echo "Api no reconocida.";
        break;

     case 17:
        $response = $master->getByProcedure('sp_consultorio_servicios_b', [$id_servicio, $descripcion, $abreviatura]);
        echo $master->returnApi($response);
        exit;
        break;   
}

#$servicios (conjunto de datos clasificados), $clasificacion (nombre de la clasificacion)
function ordenar($servicios, $clasificacion, $turno)
{
    #obtener los valores absolutos
    $absoluto_array = array();
    $in_array = 0;
    #estamos buscandor el id 1 que corresponde a la biometria hematica
    foreach ($servicios as $current) {
        if (in_array(1, $current)) {
            $in_array++;
        }
    }
    foreach ($servicios as $current) {
        if (in_array(1, $current)) {
            $in_array++;
        }
    }

    #si existe la biometria hematica, obtenemos los valores absolutos y creamos un array
    if ($in_array > 0) {
        #si existe la biometria hematica, obtenemos los valores absolutos y creamos un array
        if ($in_array > 0) {
            $bh = array_filter($servicios, function ($obj) {
                $r = $obj['GRUPO_ID'] == 1;
                return $r;
            });

            $abs = array_filter($bh, function ($obj) {
                $r = $obj['TIENE_VALOR_ABSOLUTO'] == 1;
                return $r;
            });

            foreach ($abs as $current) {
                $absoluto_array[] = array(
                    "analito" => $current['DESCRIPCION_SERVICIO'],
                    "valor_abosluto" => $current['VALOR_ABSOLUTO'],
                    "referencia" => null,
                    "unidad" => null
                );
            }
        }

        $master = new Master();
        $grupos = $master->getByProcedure('sp_cargar_grupos', [$turno, 6]);
        $estudios = array();
        $analitos = array();
        for ($i = 0; $i < count($grupos); $i++) {
            $nombre_grupo = $grupos[$i]['GRUPO'];
            $contenido_grupo = array_filter($servicios, function ($obj) use ($nombre_grupo) {
                $r = $obj['GRUPO'] == $nombre_grupo;
                return $r;
            });

            if (!empty($contenido_grupo)) {



                # llenado de los analitos del grupo
                foreach ($contenido_grupo as $current) {
                    $nombre_grupo = $current['GRUPO'];
                    $observacionnes_generales = $current['OBSERVACIONES'];
                    $id_grupo = $current['GRUPO_ID'];

                    $item = array(
                        "nombre"            => $current['DESCRIPCION_SERVICIO'],
                        "unidad"            => $current['MEDIDA'],
                        "resultado"         => $current['RESULTADO'],
                        "referencia"        => $current['VALOR_DE_REFERENCIA'],
                        "observaciones"     => isset($id_grupo) ? null : $current['OBSERVACIONES']
                    );

                    $analitos[] = $item;
                }

                if ($id_grupo == 1) {
                    $last_position = count($analitos) - 1;
                    $aux = $analitos[$last_position];
                    $analitos[$last_position] = $absoluto_array;
                    $analitos[] = $aux;
                }

                # llenar arreglo estudios
                $estudios[] = array(
                    "estudio"        => $nombre_grupo,
                    "analitos"       => $analitos,
                    "metodo"         => "",
                    "equipo"         => "",
                    "observaciones"  => $observacionnes_generales
                );
                $analitos = array();
            }
        }

        # ARREGLO DE AREAS

        $response = array(
            "area" => $clasificacion,
            "estudios" => $estudios
        );

        return $response;
    }

    function ordenarResultados($servicios, $clasificacion)
    {
        $group = array();
        $grupo_array = array();

        $absoluto_array = array();

        $first_key = array_key_first($servicios);
        $grupo = $servicios[$first_key]['GRUPO'];

        $in_array = 0;

        #estamos buscandor el id 1 que corresponde a la biometria hematica
        foreach ($servicios as $current) {
            if (in_array(1, $current)) {
                $in_array++;
            }
        }

        #si existe la biometria hematica, obtenemos los valores absolutos y creamos un array
        if ($in_array > 0) {
            $bh = array_filter($servicios, function ($obj) {
                $r = $obj['GRUPO_ID'] == 1;
                return $r;
            });

            $abs = array_filter($bh, function ($obj) {
                $r = $obj['TIENE_VALOR_ABSOLUTO'] == 1;
                return $r;
            });

            foreach ($abs as $current) {
                $absoluto_array[] = array(
                    "analito" => $current['DESCRIPCION_SERVICIO'],
                    "valor_abosluto" => $current['VALOR_ABSOLUTO']
                );
            }
        }


        $observaciones = "";

        for ($j = $first_key, $x = 0, $k = 0; $x < count($servicios); $j++, $x++) {
            if ($servicios[$j]['GRUPO'] == $grupo) {
                if (isset($servicios[$j]['GRUPO_ID'])) {
                    # si viene de un grupo, se guardal la observacion para agregarla al arreglo que guarda al grupo
                    $observaciones = $servicios[$j]['OBSERVACIONES'];
                    $grupo_array[] = array(
                        "nombre" => $servicios[$j]['DESCRIPCION_SERVICIO'],
                        "unidad" => $servicios[$j]["MEDIDA"],
                        "resultado" => $servicios[$j]['RESULTADO'],
                        "referencia" => $servicios[$j]['VALOR_DE_REFERENCIA']

                    );
                } else {
                    # si lo agregaron por separado, se tiene que agregar al arreglo actual, la observacion
                    $grupo_array[] = array(
                        "nombre" => $servicios[$j]['DESCRIPCION_SERVICIO'],
                        "unidad" => $servicios[$j]["MEDIDA"],
                        "resultado" => $servicios[$j]['RESULTADO'],
                        "referencia" => $servicios[$j]['VALOR_DE_REFERENCIA'],
                        "observaciones" => $servicios[$j]['OBSERVACIONES']

                    );
                }
            } else {
                if (isset($observaciones)) {
                    $group[$k] = array(
                        "estudio" => $grupo,
                        "analitos" => $grupo_array,
                        "metodo" => "OPTICO",
                        "observaciones" => $observaciones

                    );
                } else {
                    $group[$k] = array(
                        "estudio" => $grupo,
                        "analitos" => $grupo_array,
                        "metodo" => "OPTICO"
                    );
                }

                $k++;
                $grupo = $servicios[$j]['GRUPO'];
                $grupo_array = array();

                if (isset($servicios[$j]['GRUPO_ID'])) {
                    # si viene de un grupo, se guardal la observacion para agregarla al arreglo que guarda al grupo
                    $observaciones = $servicios[$j]['OBSERVACIONES'];
                    $grupo_array[] = array(
                        "nombre" => $servicios[$j]['DESCRIPCION_SERVICIO'],
                        "unidad" => $servicios[$j]["MEDIDA"],
                        "resultado" => $servicios[$j]['RESULTADO'],
                        "referencia" => $servicios[$j]['VALOR_DE_REFERENCIA']

                    );
                } else {
                    # si lo agregaron por separado, se tiene que agregar al arreglo actual, la observacion
                    $grupo_array[] = array(
                        "nombre" => $servicios[$j]['DESCRIPCION_SERVICIO'],
                        "unidad" => $servicios[$j]["MEDIDA"],
                        "resultado" => $servicios[$j]['RESULTADO'],
                        "referencia" => $servicios[$j]['VALOR_DE_REFERENCIA'],
                        "observaciones" => $servicios[$j]['OBSERVACIONES']

                    );
                }
            }

            $group[$k] = array(
                "estudio" => $grupo,
                "analitos" => $grupo_array,
                "metodo"        => "OPTICO",
            );
        }


        $aux = array(
            "area" => $clasificacion, # $clasificaciones[$i]['DESCRIPCION'],
            "estudios" => $group
        );

        if (!empty($absoluto_array)) {
            $position = count($aux['estudios'][0]['analitos']) - 1;
            $aux_abs = $aux['estudios'][0]['analitos'][$position];
            $aux['estudios'][0]['analitos'][$position] = $absoluto_array;
            $aux['estudios'][0]['analitos'][] = $aux_abs;
        }
        return $aux;
    }
}
