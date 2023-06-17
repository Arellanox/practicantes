<?php
require_once('../php/phpqrcode/qrlib.php');
require_once("../lib/libmergpdf/vendor/autoload.php");

use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use iio\libmergepdf\Driver\TcpdiDriver;
use iio\libmergepdf\Driver\Fpdi2Driver;
use iio\libmergepdf\Source\FileSource;

include_once "Pdf.php";
date_default_timezone_set('America/Mexico_City');

class Miscelaneus
{
    public $ruta_reporte;

    function getFormValues($values)
    {
        $form = array();

        foreach ($values as $clave => $valor) {

            # Convierte el valor null tomado como string en un valor booleano
            if (is_string($valor)) {
                if (strtoupper($valor) == "NULL") {

                    $form[] = null;
                } else {

                    $form[] = $valor;
                }
            } else {

                $form[] = $valor;
            }
        }

        return $form;
    }

    function setRutaReporte($ruta)
    {
        $this->ruta_reporte = $ruta;
    }

    function getRutaReporte()
    {
        return $this->ruta_reporte;
    }

    function escaparDatos($datos, $conexion)
    {
        //global $conexion;

        $array_escaped = array();

        foreach ($datos as $dato) {
            // if(!is_numeric($dato)){
            //     $array_escaped[] = $conexion->real_escape_string($dato);
            // }else{
            //     $array_escaped[] = $dato;
            // }
            $array_escaped[] = $conexion->real_escape_string($dato);
        }

        return $array_escaped;
    }

    //$datos = datos a comprobar
    //$intergers = posiciones del arreglo $datos que deben ser enteros
    //$strings = posiciones del arreglo $datos que deben ser cadenas de texto
    //$doubles = posiciones del arreglo $datos que deben ser numeros con decimales
    function validarDatos($datos, $intergers, $strings, $doubles, $nulls = array())
    {
        $errors = array();

        $count = 0;
        foreach ($datos as $dato) {
            if (in_array($count, $intergers)) {
                // echo "este es el dato: ".$dato." esta en interger";
                // echo "<br>";
                if (!is_numeric($dato)) {
                    if (in_array($count, $nulls)) {
                        //si esta dentro de los nulls
                        // no es un error, por tanto no hace nada
                    } else {
                        $errors[] = $count;
                    }
                }
            }

            if (in_array($count, $strings)) {
                // echo "este es el dato: ".$dato." esta en string";
                // echo "<br>";
                if (!is_string($dato)) {
                    if (in_array($count, $nulls)) {
                        //si esta dentro de los nulls
                        // no es un error, por tanto no hace nada
                    } else {
                        $errors[] = $count;
                    }
                }
            }

            if (in_array($count, $doubles)) {
                // echo "este es el dato: ".$dato." esta en doubles";
                // echo "<br>";
                if (!is_float($dato)) {
                    if (in_array($count, $nulls)) {
                        //si esta dentro de los nulls
                        // no es un error, por tanto no hace nada
                    } else {
                        $errors[] = $count;
                    }
                }
            }

            $count = $count + 1;
        }

        return $errors;
    }

    function splitArray($source, $split)
    {
        $splitted = array();
        $counter = 0;
        $position = 0;
        $aux = 0;
        $position_split = 0;

        $splitted[$position] = array();

        foreach ($source as  $value) {

            if (isset($split[$position_split])) {
                if (count($splitted[$position]) < $split[$position_split]) {
                    $splitted[$position][] = $source[$counter];
                } else {
                    $position_split = $position_split + 1;
                    if (isset($split[$position_split])) {
                        $position = $position + 1;
                        $splitted[$position] = array();
                        $splitted[$position][] = $source[$counter];
                    } else {
                        $splitted[$position][] = $source[$counter];
                    }
                }
            } else {
                $splitted[$position][] = $source[$counter];
            }

            $counter = $counter + 1;
        }

        return $splitted;
    }

    function initValueNull($values)
    {
        $initedArray = array();

        foreach ($values as $value) {
            if (!isset($value)) {
                $initedArray[] = null;
            } else {
                $initedArray[] = $value;
            }
        }

        return $initedArray;
    }

    function setLog($message, $sp)
    {
        $file = "log.txt";
        $fp = fopen($file, 'a');
        $log = date("d/m/y H:i:s") . " " . $sp . " " . $message . "\n";
        fwrite($fp, $log);
        fclose($fp);
    }

    function returnApi($response, $specialCode = null)
    {

        if (is_array($response) || is_numeric($response) || is_object($response) && !isset($specialCode)) {
            $json = json_encode(
                array("response" => array(
                    'code' => 1,
                    'data' => $response
                ))
            );
        } else if (!isset($specialCode)) {
            $json = json_encode(
                array("response" => array(
                    'code' => 2,
                    'msj' => $response
                ))
            );
        } else {
            $json = json_encode(
                array("response" => array(
                    'code' => 'turnero',
                    'msj' => $response
                ))
            );
        }

        return $json;
    }

    function sayHello()
    {
        echo "Hello World!";
    }

    function generarQRURL($tipo, $codeContents, $nombre, $frame = QR_ECLEVEL_M, $size = 3)
    {
        # URL carpeta
        $tempDir = 'archivos/sistema/temp/qr/' . $tipo . '/';

        # Enviar la url o codigo necesario desde antes
        QRcode::png($codeContents, '../' . $tempDir . $nombre . '.png', $frame, $size, 2);

        # retorna la URL donde se ubica el archivo
        return 'https://bimo-lab.com/nuevo_checkup/' . $tempDir . $nombre . '.png';
    }

    function guardarFiles($files, $posicion = 'default', $dir/*, $carpetas = ['temp/']*/, $nombre)
    {

        $urlArray = array();
        // var_dump($files[$posicion]['name']);

        // var_dump($files);
        if (!empty($files[$posicion]['name'])) {

            if (empty($files[$posicion]['name'][0])) {
                // echo "haz algo";
                $this->setLog("El archivo esta vacio o dañado, error al subir archivo.", "[function guardarFiles][$posicion], [$nombre]");
                return array();
            }

            $next = 0;
            foreach ($files[$posicion]['name'] as $key => $value) {
                $extension = pathinfo($files[$posicion]['name'][$key], PATHINFO_EXTENSION);
                # obtenemos la ruta temporal del archivo
                $tmp_name = $files[$posicion]['tmp_name'][$key];

                # Nueva ubicacion del archivo.
                $ubicacion = $dir . $nombre . "_$next." . $extension;
                #cambiamos de lugar el archivo
                try {
                    move_uploaded_file($tmp_name, $ubicacion);
                    $urlArray[] = array('url' => $ubicacion, 'tipo' => $extension);
                } catch (\Throwable $th) {
                    $this->setLog("No se movieron los archivos $th", "{guardarfiles}");
                    return "Algunos archivos no se lograron mover, intentelo nuevamente.";
                    # si no se puede subir el archivo, desactivamos el resultado que se guardo en la base de datos
                    // $e = $master->deleteByProcedure('sp_resultados_reportes_e',[$response[0]['LAST_ID']]);
                }
                $next++;
            }
            return $urlArray;
        } else {
            $this->setLog("El archivo esta vacio o dañado, error al subir archivo.", "[function guardarFiles][$posicion]");
            return array();
        }
    }

    function createDir($dir)
    {
        if (!is_dir($dir)) {
            # si no existe el directorio, intenta crearlo
            if (!mkdir($dir, 0777, true)) {
                # si no puede ejecutar la linea del if, envia un mensaje de error al log
                $this->setLog("no pudo crear el directorio. $dir", $dir);
            } else {
                # si puede crearlo, enviar mensaje de exito [1]
                return 1;
            }
        } else {
            # si el directorio ya existe, envia codigo de exito [1]
            return 1;
        }
        # si no puede crearlo, envia mensaje de error [0]
        return 0;
    } //fin createDir

    // comprueba si un arreglo esta realmente vacio
    public function checkArray($array, $isFile = 0)
    {
        $newArray = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!empty($this->checkArray($value))) {
                    $newArray[$key] = $this->checkArray($value);
                }
            } else {
                if (!empty($value)) {
                    $newArray[$key] = $value;
                }
            }
        } // fin del foreach

        if ($isFile == 1) {
            $aux = array();
            foreach ($newArray as $key => $value) {
                if (count($value) > 1) {
                    $aux[$key] = $value;
                }
            } // fin foreach
            $newArray = $aux;
        }
        return $newArray;
    } // fin de checkArray


    public function reportador($master, $turno_id, $area_id, $reporte, $tipo = 'url', $preview = 0, $lab = 0, $id_consulta = 0, $cliente_id = 1, $id_cotizacion = 8)
    {
        
        #Recupera la información personal del paciente
        $infoPaciente = $master->getByProcedure('sp_informacion_paciente', [$turno_id]);
        $infoPaciente = [$infoPaciente[count($infoPaciente) - 1]];

        $nombre_paciente = $infoPaciente[0]['NOMBRE'];

        #Recupera la informacion del cliente
        $infoCliente = $master->getByProcedure("sp_cotizaciones_gral", [$cliente_id]);
        $infoCliente = [$infoCliente[count($infoCliente) - 1]];

        $nombre_cliente = $infoCliente[0]['CLIENTE'];

        #Recuperamos el cuerpo y asignamos titulo si es necesario
        switch ($area_id) {
            case 0:
                # para las etiquetas
                $arregloPaciente = $this->getBodyInfoLabels2($master, $turno_id);
                $fecha_resultado = $infoPaciente[0]['FECHA_CARPETA'];
                $carpeta_guardado = "etiquetas";
                $datos_medicos = array();
                //print_r($arregloPaciente);
                break;
            case 6:
            case '6':
            case 12: //<-- Biomolecular
            case '12':
                $arregloPaciente = $this->getBodyInfoLab($master, $turno_id, $area_id);
                $clave = $master->getByProcedure("sp_generar_clave", []);
                $infoPaciente[0]['CLAVE_IMAGEN'] = $clave[0]['TOKEN'];
                $arregloPaciente = $arregloPaciente['global'];
                $fecha_resultado = $infoPaciente[0]['FECHA_CARPETA'];
                $carpeta_guardado = 'lab';
                $datos_medicos = array(); #Mandar vacio
                $folio = $infoPaciente[0]['FOLIO'];
                if ($area_id == 12 || $area_id == '12') {
                    $carpeta_guardado = 'lab-molecular';
                    $folio = $infoPaciente[0]['FOLIO_BIOMOLECULAR'];
                }
                break;
            case 8:
            case '8':
                $arregloPaciente = $this->getBodyInfoImg($master, $turno_id, $area_id);
                $info = $master->getByProcedure("sp_info_medicos", [$turno_id, $area_id]);
                $datos_medicos = $this->getMedicalCarrier($info);
                $fecha_resultado = $infoPaciente[0]['FECHA_CARPETA_IMAGEN'];
                $infoPaciente[0]['TITULO'] = 'Reporte de Rayos X';
                $carpeta_guardado = 'rayosx';

                //Folio
                $infoPaciente[0]['FOLIO_IMAGEN'] = $infoPaciente[0]['FOLIO_IMAGEN_US'];
                $folio = $infoPaciente[0]['FOLIO_IMAGEN'];
                break;
            case 11:
            case '11':
                $arregloPaciente = $this->getBodyInfoImg($master, $turno_id, $area_id);
                $info = $master->getByProcedure("sp_info_medicos", [$turno_id, $area_id]);
                $datos_medicos = $this->getMedicalCarrier($info);
                $fecha_resultado = $infoPaciente[0]['FECHA_CARPETA_IMAGEN'];
                $infoPaciente[0]['TITULO'] = 'Reporte de Ultrasonido';
                $carpeta_guardado = 'ultrasonido';

                //Folio
                $infoPaciente[0]['FOLIO_IMAGEN'] = $infoPaciente[0]['FOLIO_IMAGEN_RX'];
                $folio = $infoPaciente[0]['FOLIO_IMAGEN'];
                break;
            case 3:
            case '3': #Oftalmologia
                $arregloPaciente = $this->getBodyInfoOftal($master, $turno_id);
                $info = $master->getByProcedure("sp_info_medicos", [$turno_id, $area_id]);
                $infoPaciente[0]['CLAVE_IMAGEN'] = $arregloPaciente['CLAVE'];
                $datos_medicos = $this->getMedicalCarrier($info);
                $fecha_resultado = $infoPaciente[0]['FECHA_CARPETA_OFTALMO'];
                $carpeta_guardado = 'oftalmologia';
                $folio = $infoPaciente[0]['FOLIO_OFTALMO'];
                break;
            case 1:
            case '1':
                # CONSULTORIO
                $arregloPaciente = $this->getBodyInfoConsultorio($master, $turno_id, $id_consulta);
                $info = $master->getByProcedure("sp_info_medicos", [$turno_id, $area_id]);
                $datos_medicos = $this->getMedicalCarrier($info);
                $fecha_resultado = $infoPaciente[0]['FECHA_CARPETA_CONSULTA'];
                $infoPaciente[0]['FECHA_RESULTADO'] =
                    $infoPaciente[0]['FECHA_CONSULTA_HISTORIA'];
                $carpeta_guardado = 'consultorio';
                $folio = $infoPaciente[0]['FOLIO_CONSULTA'];
                $infoPaciente[0]['CLAVE_IMAGEN'] = $infoPaciente[0]['CLAVE_CONSULTA'];
                break;
            case 10:
            case '10':
                # ELECTROCARDIOGRAMA
                $arregloPaciente = $this->getBodyInfoElectro($master, $turno_id);
                $info = $master->getByProcedure("sp_info_medicos", [$turno_id, $area_id]);
                $datos_medicos = $this->getMedicalCarrier($info);
                $fecha_resultado = $infoPaciente[0]['FECHA_CARPETA_ELECTRO'];
                $carpeta_guardado = "electro";
                $folio = $infoPaciente[0]['FOLIO_ELECTRO'];
                $infoPaciente[0]['CLAVE_IMAGEN'] = $infoPaciente[0]['CLAVE_ELECTRO'];
                // $clave = $infoPaciente[0]['CLAVE_ELECTRO'];
                $infoPaciente[0]['TITULO'] = 'Reporte de Electrocardiograma';

                break;
            case 2:
            case "2":
                # SOMATOMETRIA
                $arregloPaciente = $this->getBodyInfoSoma($master, $turno_id);
                $fecha_resultado = $infoPaciente[0]['FECHA_CARPETA_MESO'];
                $carpeta_guardado = "somatometria";
                $folio = $infoPaciente[0]['FOLIO_SOMA'];
                $infoPaciente[0]['CLAVE_IMAGEN'] = $infoPaciente[0]['CLAVE_SOMA'];
                break;

            case 13:
            case "13":
                # COTIZACIONES
                $infoCliente = $this->getBodyInfoCotizacion($master, $id_cotizacion, $cliente_id);
                $fecha_resultado = $infoPaciente[0]['FECHA_CREACION'];
                $carpeta_guardado = "cotizacion";
                $infoCliente = [$infoCliente[count($infoCliente) - 1]];
                $folio = $infoPaciente[0]['FOLIO_COTIZACIONES'];
                break;
            case 5:
            case "5":
                #ESPIROMETRIA
                $datos_medicos = array();
                $arregloPaciente = $this->getBodyEspiro($master, $turno_id);
                $fecha_resultado = $infoPaciente[array_key_last($infoPaciente)]['FECHA_CARPETA_ESPIRO'];
                $carpeta_guardado = "espirometria";
                $folio = $infoPaciente[array_key_last($infoPaciente)]['FOLIO_ESPIRO'];
                $infoPaciente[0]['CLAVE_IMAGEN'] = $infoPaciente[array_key_last($infoPaciente)]['CLAVE_ESPIRO'];

                break;
        }
        

        if ($area_id == 0) {
            $area_id = 6;
        }
        $infoPaciente[0]['SUBTITULO'] = 'Datos del paciente';

        #Crear directorio
        $nombre = str_replace(
            " ",
            "_",
            $nombre_paciente
        );

        $ruta_saved = "reportes/modulo/$carpeta_guardado/$fecha_resultado/$turno_id/";

        # Seteamos la ruta del reporte para poder recuperarla despues con el atributo $ruta_reporte.
        $this->setRutaReporte($ruta_saved);

        # Crear el directorio si no existe
        $r = $master->createDir("../" . $ruta_saved);
        $archivo = array("ruta" => $ruta_saved, "nombre_archivo" => $nombre . "-" . $infoPaciente[0]['ETIQUETA_TURNO'] . '-' . $fecha_resultado);
        $pie_pagina = array("clave" => $infoPaciente[0]['CLAVE_IMAGEN'], "folio" => $folio, "modulo" => $area_id, "datos_medicos" => $datos_medicos);

        //  print_r(json_encode($arregloPaciente));
        //  print_r(json_encode($infoPaciente[0]));
        // exit;
        $pdf = new Reporte(json_encode($arregloPaciente), json_encode($infoPaciente[0]), $pie_pagina, $archivo, $reporte, $tipo, $preview, $area_id);
        // $pdf = '';
        
        $renderpdf = $pdf->build();
        
        if ($lab == 1 && $tipo == 'url') {

            $master->insertByProcedure('sp_reportes_areas_g', [null, $turno_id, 6, $infoPaciente[0]['CLAVE_IMAGEN'], $renderpdf, null]);
         }
        return $renderpdf;
    }

    private function getBodyInfoSoma($master, $id_turno)
    {
        # recuperamos los datos del paciente
        $response = $master->getByProcedure("sp_mesometria_signos_vitales_b", [$id_turno]);

        # declaramos el array final 
        $arregloPaciente = array();

        # convertimos los tipo de signos en claves y su resultado en el valor del arreglo
        foreach ($response as $sign) {
            $clave = str_replace(" ", "_", $sign['TIPO_SIGNO']);
            $arregloPaciente[$clave] = $sign['VALOR'];
        }
        $arregloPaciente['FECHA_REGISTRO'] = $response[0]['FECHA_REGISTRO'];


        return $arregloPaciente;
    }

    private function getBodyInfoElectro($master, $id_turno)
    {
        $response = $master->getByProcedure("sp_electro_resultados_b", [null, $id_turno, null]);
        $arregloPaciente = array(
            "ESTUDIO" => "ELECTROCARDIOGRAMA",
            "TECNICA" => $response[array_key_first($response)]["TECNICA"],
            "HALLAZGO" => $response[array_key_first($response)]['HALLAZGO'],
            "INTERPRETACION" => $response[array_key_first($response)]['INTERPRETACION'],
            "COMENTARIO" => $response[array_key_first($response)]['COMENTARIO']
        );

        return $arregloPaciente;
    }

    private function getBodyInfoCotizacion($master, $id_cotizacion, $cliente_id)
    {
        $arregloServicio = $master->getByNext("sp_cotizaciones_b", [$id_cotizacion, $cliente_id]);

        return $arregloServicio;
    }

    private function getBodyInfoConsultorio($master, $id_turno, $id_consulta)
    {
        # json reporte consultorio.
        $response = $master->getByNext('sp_reporte_consultorio', [$id_turno, $id_consulta]);

        $productoFinal = [];
        if (is_array($response)) {
            # recorremos el arreglo de las consultas [6 queries]
            for ($i = 0; $i < count($response); $i++) {
                switch ($i) {
                    case 0:
                        # DATOS DE CONSULTA
                        foreach ($response[$i][0] as $key => $value) {
                            if (is_string($key)) {
                                $productoFinal[$key] = $value;
                            }
                        }
                        break;
                    case 1:
                        # ANTECEDENTES
                        # $productoFinal['ANTECEDENTES'] = $master->checkArray($response[$i]);
                        $antecedentes = $master->checkArray($response[$i]);
                        $tipos = array();

                        # obtenemos el nombre del tipo de antecedente principal
                        foreach ($antecedentes as $item) {
                            $tipos[] = $item['TIPO'];
                        }

                        # eliminamos las duplicidades
                        $tipos = array_unique($tipos);


                        # filtramos los subtipos dado el nuevo arreglo $tipo.
                        $productoFinal['ANTECEDENTES'] = array();
                        foreach ($tipos as $tipo) {
                            $productoFinal['ANTECEDENTES'][$tipo] = array_filter($antecedentes, function ($obj) use ($tipo) {
                                return $obj['TIPO'] === $tipo;
                            });
                        }
                        break;
                    case 2:
                        # ANAMNESIS
                        #$productoFinal['ANAMNESIS'] = $master->checkArray($response[$i]);
                        $anamnesis = $master->checkArray($response[$i]);
                        #obtenenmos la clase
                        $clase = array();
                        foreach ($anamnesis as $current) {
                            $clase[] = $current['CLASE'];
                        }
                        # quitmos la duplicidad de las clases
                        $clase = array_unique($clase);

                        $newAnamnesis = array();
                        foreach ($clase as $current) {
                            $replace = str_replace(" ", "_", $current);
                            $newAnamnesis[$replace] = array_filter($anamnesis, function ($obj) use ($current) {
                                return $obj['CLASE'] == $current;
                            });
                        }
                        $productoFinal['ANAMNESIS'] = $newAnamnesis;
                        break;
                    case 3:
                        # ODONTOGRAMA
                        $productoFinal['ODONTOGRAMA'] = $master->checkArray($response[$i]);
                        break;
                    case 4:
                        # NUTRICION
                        $productoFinal['NUTRICION'] = $master->checkArray($response[$i][0]);
                        break;
                    case 5:
                        # EXPLORACION FISICA
                        $productoFinal['EXPLORACION_FISICA'] = $master->checkArray($response[$i]);
                        break;
                }
            }
        }

        return $productoFinal;
    }

    private function setLabels($infoPaciente, $infoEtiqueta)
    {
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
                $maquila = $infoEtiqueta[$i]['MAQUILA_ABR'];
                $array1 = array(
                    'CONTENEDOR' => $infoEtiqueta[$i]['CONTENEDOR'],
                    'MUESTRA' => $infoEtiqueta[$i]['MUESTRA'],
                    'ESTUDIOS' => $arrayEtiquetaEstudios,
                    'MAQUILA_ABR' => $maquila

                );
                array_push($arrayEtiqueta, $array1);
            } else if ($muestra !== $infoEtiqueta[$i]['MUESTRA']) {
                $content = $infoEtiqueta[$i]['CONTENEDOR'];
                $muestra = $infoEtiqueta[$i]['MUESTRA'];
                $maquila = $infoEtiqueta[$i]['MAQUILA_ABR'];
                $array1 = array(
                    'CONTENEDOR' => $infoEtiqueta[$i]['CONTENEDOR'],
                    'MUESTRA' => $infoEtiqueta[$i]['MUESTRA'],
                    'ESTUDIOS' => $arrayEtiquetaEstudios,
                    'MAQUILA_ABR' => $maquila

                );
                array_push($arrayEtiqueta, $array1);
            }
            $arrayEtiquetaEstudios = [];
        }



        return $arrayEtiqueta;
    }
    private function getBodyInfoLabels2($master, $id_turno)
    {
        $infoPaciente = $master->getByProcedure('sp_informacion_paciente', [$id_turno]);
        $infoPaciente = [$infoPaciente[count($infoPaciente) - 1]];
        $infoEtiqueta = $master->getByNext('sp_toma_de_muestra_servicios_b', [null, 6, $id_turno]);

        $locales = $this->setLabels($infoPaciente, $infoEtiqueta[0]);
        $subroga = $this->setLabels($infoPaciente, $infoEtiqueta[1]);


        $arrayEtiqueta = array_merge($locales, $subroga);
        $arregloPaciente = array(
            'NOMBRE' => $infoPaciente[0]['NOMBRE'],
            'FECHA_TOMA' => $infoPaciente[0]['FECHA_TOMA'],
            "FOLIO" => $infoPaciente[0]['FOLIO'],
            "EDAD" => $infoPaciente[0]['EDAD'],
            'SEXO' => $infoPaciente[0]['SEXO'],
            'BARRAS' => $infoPaciente[0]['CODIGO_BARRAS'],
            'CONTENEDORES' => $arrayEtiqueta,

        );

        return $arregloPaciente;
    }
    private function getBodyInfoLabels($master, $id_turno)
    {
        $infoPaciente = $master->getByProcedure('sp_informacion_paciente', [$id_turno]);
        $infoPaciente = [$infoPaciente[count($infoPaciente) - 1]];
        $infoEtiqueta = $master->getByProcedure('sp_toma_de_muestra_servicios_b', [null, 6, $id_turno]);

        $arrayEtiqueta = [];
        $arrayEtiquetaEstudios = [];
        $content = "";
        $muestra = "";
        $local = "";
        $maquila = "";
        for ($i = 0; $i < count($infoEtiqueta); $i++) {

            for ($e = 0; $e < count($infoEtiqueta); $e++) {

                if ($infoEtiqueta[$i]['CONTENEDOR'] == $infoEtiqueta[$e]['CONTENEDOR'] && $infoEtiqueta[$i]['MUESTRA'] == $infoEtiqueta[$e]['MUESTRA']) {
                    $arregloEtiqueta = array('ABREVIATURA' => $infoEtiqueta[$e]['ABR'], 'LOCAL' => $infoEtiqueta[$e]['LOCAL']);
                    array_push($arrayEtiquetaEstudios, $arregloEtiqueta);
                }
            }


            if ($content !== $infoEtiqueta[$i]['CONTENEDOR']) {
                $content = $infoEtiqueta[$i]['CONTENEDOR'];
                $muestra = $infoEtiqueta[$i]['MUESTRA'];
                $local = $infoEtiqueta[$i]['LOCAL'];
                $maquila = $infoEtiqueta[$i]['MAQUILA_ABR'];
                $array1 = array(
                    'CONTENEDOR' => $infoEtiqueta[$i]['CONTENEDOR'],
                    'MUESTRA' => $infoEtiqueta[$i]['MUESTRA'],
                    'MAQUILA_ABR' => $maquila,
                    'ESTUDIOS' => $arrayEtiquetaEstudios

                );
                array_push($arrayEtiqueta, $array1);
                if ($local == 0) {
                    $array1 = array(
                        'CONTENEDOR' => $infoEtiqueta[$i]['CONTENEDOR'],
                        'MUESTRA' => $infoEtiqueta[$i]['MUESTRA'],
                        'MAQUILA_ABR' => $maquila,
                        'ESTUDIOS' => $arrayEtiquetaEstudios

                    );
                    array_push($arrayEtiqueta, $array1);
                }
            } else if ($muestra !== $infoEtiqueta[$i]['MUESTRA']) {
                $content = $infoEtiqueta[$i]['CONTENEDOR'];
                $muestra = $infoEtiqueta[$i]['MUESTRA'];
                $local = $infoEtiqueta[$i]['LOCAL'];
                $maquila = $infoEtiqueta[$i]['MAQUILA_ABR'];
                $array1 = array(
                    'CONTENEDOR' => $infoEtiqueta[$i]['CONTENEDOR'],
                    'MUESTRA' => $infoEtiqueta[$i]['MUESTRA'],
                    'MAQUILA_ABR' => $maquila,
                    'ESTUDIOS' => $arrayEtiquetaEstudios

                );
                array_push($arrayEtiqueta, $array1);
                if ($local == 0) {
                    $array1 = array(
                        'CONTENEDOR' => $infoEtiqueta[$i]['CONTENEDOR'],
                        'MUESTRA' => $infoEtiqueta[$i]['MUESTRA'],
                        'MAQUILA_ABR' => $maquila,
                        'ESTUDIOS' => $arrayEtiquetaEstudios,

                    );
                    array_push($arrayEtiqueta, $array1);
                }
            }
            $arrayEtiquetaEstudios = [];
        }

        $arregloPaciente = array(
            'NOMBRE' => $infoPaciente[0]['NOMBRE'],
            'FECHA_TOMA' => $infoPaciente[0]['FECHA_TOMA'],
            "FOLIO" => $infoPaciente[0]['FOLIO'],
            "EDAD" => $infoPaciente[0]['EDAD'],
            'SEXO' => $infoPaciente[0]['SEXO'],
            'BARRAS' => $infoPaciente[0]['CODIGO_BARRAS'],
            'CONTENEDORES' => $arrayEtiqueta,

        );

        return $arregloPaciente;
    }

    private function getBodyInfoImg($master, $turno_id, $area_id)
    {
        #recuperar la informacion del Reporte de interpretacion de ultrasonido y rayosx
        # recuperar los resultados de ultrasonido y rayosx
        // $area_id = $area_id; #11 es el id para ultrasonido y rayosx.
        $response1 = $master->getByNext('sp_imagenologia_resultados_b', [null, $turno_id, $area_id]);

        $arrayimg = [];

        for ($i = 0; $i < count($response1[1]); $i++) {

            $servicio = $response1[1][$i]['SERVICIO'];
            $hallazgo = $response1[1][$i]['HALLAZGO'];
            $interpretacion = $response1[1][$i]['INTERPRETACION_DETALLE'];
            $comentario = $response1[1][$i]['COMENTARIO'];
            $tecnica = $response1[1][$i]['TECNICA'];
            $array1 = array(
                "ESTUDIO" => $servicio,
                "HALLAZGO" => $hallazgo,
                "INTERPRETACION" => $interpretacion,
                "COMENTARIO" => $comentario,
                "TECNICA" => $tecnica

            );
            array_push($arrayimg, $array1);
        }

        return array(
            'ESTUDIOS' => $arrayimg
        );
    }

    private function getMedicalCarrier($info = array())
    {
        // print_r($info);
        $carreraPrincipal = array_filter($info, function ($obj) {
            $r = $obj['ESPECIALIDAD'] == 0;
            return $r;
        });

        $especialidades = array_filter($info, function ($obj) {
            $r = $obj['ESPECIALIDAD'] == 1;
            return $r;
        });

        $carreraPrincipal[0]['ESPECIALIDADES'] = $especialidades;

        return $carreraPrincipal;
    }

    private function getBodyInfoOftal($master, $turno_id)
    {
        #recuperar la informacion del Reporte de interpretacion de oftalmología
        # recuperar los resultados de oftalmología
        $response1 = $master->getByProcedure('sp_oftalmo_resultados_b', [null, $turno_id]);
        $arrayoftalmo = [];

        for ($i = 0; $i < count($response1[0]); $i++) {

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
            $confirmado = $response1[$i]['CONFIRMADO'];
            $con_agudeza_visual = $response1[$i]['AGUDEZA_VISUAL_CON_CORRECCION'];
            $con_oi = $response1[$i]['CON_OD'];
            $con_od = $response1[$i]['CON_OI'];
            $con_jaeger = $response1[$i]['CON_JAEGER'];
            $clave = $response1[$i]['TOKEN'];
            $fecha_resultado = $response1[$i]['FECHA_RESULTADO'];
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
                "OBSERVACIONES" => $observaciones,
                "CONFIRMADO" => $confirmado,
                "AGUDEZA_VISUAL_CON_CORRECCION" => $con_agudeza_visual,
                "CON_OD" => $con_oi,
                "CON_OI" => $con_od,
                "CON_JAEGER" => $con_jaeger,
                "CLAVE" => $clave,
                "FECHA_RESULTADO" => $fecha_resultado
            );
            array_push($arrayoftalmo, $array1);
        }

        return $arrayoftalmo[0];
    }

    private function getBodyInfoLab($master, $id_turno, $area_id)
    {

        # informacion general del paciente

        #Estudios solicitados por el paciente
        $clasificaciones = $master->getByProcedure('sp_laboratorio_clasificacion_examen_b', [null, $area_id]);
        $response = $master->getByProcedure("sp_cargar_estudios", [$id_turno, $area_id]);

        #Generar clave de resultado
        $clave = $master->getByProcedure("sp_generar_clave", []);

        $arrayGlobal = array(
            'areas' => array()
        );

        # filtramos el arreglo principal y obtenemos aquellos estudios
        # que tienen valor absoluto.
        $serv_var_abs_obj = array_filter($response, function ($obj) {
            $return = $obj['TIENE_VALOR_ABSOLUTO'] == 1;
            return $return;
        });

        $serv_var_abs = $this->ordernarBodyLab($serv_var_abs_obj, "VALORES ABSOLUTOS", $id_turno, $area_id);
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

            if (!empty($servicios)) {

                $aux = $this->ordernarBodyLab($servicios, $clasificaciones[$i]['DESCRIPCION'], $id_turno, $area_id);

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

            $aux = $this->ordernarBodyLab($servicios, "NINGUNA", $id_turno, $area_id);
            $arrayGlobal['areas'][] = $aux;
        }

        return array('global' => $arrayGlobal, 'clave' => $clave);
    }

    private function ordernarBodyLab($servicios, $clasificacion, $turno, $area_id)
    {
        #obtener los valores absolutos
        $absoluto_array = array();
        $in_array = 0;
        #estamos buscandor el id 1 que corresponde a la biometria hematica
        foreach ($servicios as $current) {
            if (in_array(1, $current) || in_array(35, $current)) {
                $in_array++;
            }
        }

        #si existe la biometria hematica [id 1] o perfil reumatico [id 35], obtenemos los valores absolutos y creamos un array
        if ($in_array > 0) {
            $bh = array_filter($servicios, function ($obj) {
                $r = $obj['GRUPO_ID'] == 1 || 35;
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
                    "referencia" => $current['VALOR_REFERENCIA_ABS'],
                    "unidad" => $current['MEDIDA_ABS']
                );
            }
        }

        $master = new Master();
        $grupos = $master->getByProcedure('sp_cargar_grupos', [$turno, $area_id]);
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
                    $metodo_grupo = $current['METODOS_GRUPO'];
                    $equipo_grupo = $current['EQUIPOS_GRUPO'];
                    $clasificacion_id = $current['CLASIFICACION_ID'];

                    $item = array(
                        "nombre"            => $current['DESCRIPCION_SERVICIO'],
                        "unidad"            => $current['MEDIDA'],
                        "resultado"         => $current['RESULTADO'],
                        "referencia"        => $current['VALOR_DE_REFERENCIA'],
                        # "observaciones"     => isset($id_grupo) ? null : $current['OBSERVACIONES'],
                        "observaciones"     => $nombre_grupo != "OTROS SERVICIOS" ? null : $current['OBSERVACIONES'],
                        "metodo"     => $nombre_grupo != "OTROS SERVICIOS" ? null : $current['METODOS_ESTUDIO'],
                        "equipo"     => $nombre_grupo != "OTROS SERVICIOS" ? null : $current['EQUIPOS_ESTUDIO'],
                        #"metodo"            => isset($metodo_grupo) ? null : $current['METODOS_ESTUDIO'],
                        #"equipo"            => isset($equipo_grupo) ? null : $current['EQUIPOS_ESTUDIO']
                    );

                    $analitos[] = $item;
                }

                # para los valorse absolutos
                switch ($id_grupo) {
                        #biometria hematica
                    case 1:
                        $last_position = count($analitos) - 1;
                        $aux = $analitos[$last_position];
                        $analitos[$last_position] = $absoluto_array;
                        $analitos[] = $aux;
                        break;
                        #perfil reumatico
                    case 35:
                        if ($clasificacion_id == 1) {
                            # 1 para la clasificacion de hematologia. 
                            # Solo la hematoloigia debe mandar los valores absolutos                        
                            $last_position = count($analitos) - 2;
                            $aux = $analitos[$last_position];
                            $analitos[$last_position] = $absoluto_array;

                            $last_position++;
                            while (!empty($analitos[$last_position])) {
                                $auxc = $analitos[$last_position];
                                $analitos[$last_position] = $aux;
                                $aux = $auxc;
                                $last_position++;
                            }

                            $analitos[$last_position] = $aux;
                        }
                        break;
                }

                # llenar arreglo estudios
                $estudios[] = array(
                    "estudio"        => $nombre_grupo,
                    "analitos"       => $analitos,
                    "metodo"         => $metodo_grupo,
                    "equipo"         => $equipo_grupo,
                    "observaciones"  => isset($id_grupo) ? $observacionnes_generales : null
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

    function cleanAttachingFiles($files_array)
    {
        $files = [];
        foreach ($files_array as $file) {
            $files[] = $file['RUTA'];
        }

        return $files;
    }

    function decodeJson($parsing)
    {
        $decoded = array();

        foreach ($parsing as $key => $value) {

            if (!is_int($value)) {
                if ($this->str_ends_with($value, '}') || $this->str_ends_with($value, ']')) {
                    $aux = json_decode($value, true);
                    $s = 0;
                } else {
                    $aux = $value;
                }
            } else {

                $aux = $value;
            }
            // $aux = json_decode($value, true);
            // $s = 0;
            if (is_array($aux)) {
                foreach ($aux as $a) {
                    if (is_string($a)) {
                        $s = $s + 1;
                    }
                }
                if ($s > 0) {
                    $aux = $this->decodeJson($aux);
                }

                $decoded[$key] = $aux;
            } else {
                $decoded[$key] = $aux;
            }
        }

        return $decoded;
    }
    function str_ends_with($haystack, $needle)
    {
        return (@substr_compare($haystack, $needle, -strlen($needle)) == 0);
    }


    function cleanAttachFilesImage($master, $turno_id, $area_id, $cliente, $reenviar = 0, $fecha_busqueda = null)
    {
        # reporte
        $response = $master->getByProcedure("sp_recuperar_reportes_confirmados", [$turno_id, $area_id, $cliente, $fecha_busqueda, 0]);

        #reportes filtrados, solo los que estan validados
        if ($reenviar != 0) {
            $reportes_validados = array_filter($response, function ($obj) {
                $r = $obj['DOUBLE_CHECK'] == 1;
                return $r;
            });
            $response = $reportes_validados;
        }

        $reporte = $this->cleanAttachingFiles($response);

        # imagenes.
        $capturas = $master->getByProcedure("sp_capturas_imagen_b", [$turno_id, $area_id]);

        if ($reenviar != 0 || !is_null($fecha_busqueda)) {
            # imagenes filtradas
            $imagenes_array = [];
            foreach ($response as $item) {
                $area = $item['AREA'];
                $turno = $item['TURNO_ID'];
                $img = array_filter($capturas, function ($obj) use ($area, $turno) {
                    $r = $obj['TURNO_ID'] == $turno && $obj['AREA_ID'] == $area && isset($obj['RUTA']);
                    return $r;
                });

                if (!empty($img)) {
                    foreach ($img as $item) {
                        array_push($imagenes_array, $item);
                    }
                }
            }

            $capturas = $imagenes_array;
        }

        $decodedArray = [];
        foreach ($capturas as $cap) {
            $decodedArray[] = $this->decodeJson($cap);
        }

        $imagenes = array();
        foreach ($decodedArray as $item) {
            foreach ($item['CAPTURAS'][0] as $i) {
                $imagenes[] = $i['url'];
            }
        }


        # unimos ambos arreglos
        $attachment = array_merge($reporte, $imagenes);
        $attachment = array_unique($attachment);

        return [$attachment, $response[array_key_first($response)]['CORREO'], array_map(function ($obj) {
            return $obj['TURNO_ID'];
        }, $response), array_map(function ($obj) {
            return $obj['NOMBRE_ARCHIVO'];
        }, $response)];
    }

    public function joinPdf($files = [])
    {
        $merger = new Merger;
        if (!empty($files)) {
            $merger->addIterator($files);
            try {
                $createpdf = $merger->merge();
                return $createpdf;
            } catch (Exception $e) {
                echo $e;
            }
        }
        return null;
    }

    // public function changeLocationFile($old_directory,$new_directory){
    //     // if (copy(".." . $dir[1], $destination . basename($archivo))) {
    //     //     # si se copia correctamente, borramos el archivo de la carpeta generica.
    //     //     unlink('..'.$dir[1]);

    //     //     #guardarmos la direccion del electro.
    //     //     $response = $master->insertByProcedure("sp_electro_resultados_g", [$id_electro, $turno_id, $host . "reportes/modulo/electro/$turno_id", null, $comentario, $interpretacion, $tecnica, $hallazgo, null, null, $usuario]);
    //     // }

    //     if (copy($old_directory,$new_directory)) {
    //         # si se copia correctamente, borramos el archivo de la carpeta generica.
    //         unlink($old_directory);

    //         #guardarmos la direccion del electro.
    //         $response = $master->insertByProcedure("sp_electro_resultados_g", [$id_electro, $turno_id, $host . "reportes/modulo/electro/$turno_id", null, $comentario, $interpretacion, $tecnica, $hallazgo, null, null, $usuario]);
    //     }
    // }

    public function  scanDirectory($directory)
    {
        #enviar los dos puntos [../] basandose en el archivo de miscelaneus
        $files = array();
        if ($gestor = opendir($directory)) {
            // echo "Gestor de directorio: $gestor\n";
            // echo "Entradas:\n";

            /* Esta es la forma correcta de iterar sobre el directorio. */
            $count = 0;
            while (false !== ($entrada = readdir($gestor))) {
                if ($count > 1) {
                    array_push($files, $directory . $entrada);
                }
                $count++;
            }

            closedir($gestor);
        }

        return $files;
    }

    public function selectHost($domain)
    {

        switch ($domain) {
            case "localhost":
                $preUrl = "http://localhost/nuevo_checkup/";
                break;
            case "bimo-lab.com":
                $preUrl = "https://bimo-lab.com/nuevo_checkup/";
                break;
            case "drjb.com.mx":
                $preUrl = "https://drjb.com.mx/nuevo_checkup/";
                break;
            case "helicebiologicos.com":
                $preUrl = "http://helicebiologicos.com/nuevo_checkup/";
                break;
            default:
                $preUrl = "https://bimo-lab.com/nuevo_checkup/";
                break;
        }

        return $preUrl;
    }

    public function getByPatientNameByTurno($master, $turno)
    {
        $name = $master->getByProcedure("sp_get_patient_name_by_turno", [$turno]);
        return isset($name[0]['NOMBRE_COMPLETO']) ? $name[0]['NOMBRE_COMPLETO'] : "NONE";
    }

    public function setToNull($params = array())
    {
        # esta funcion convierte en null 
        # todas aquellas variables que tengans strlen =0,
        # las que tengas la palabra "null" o las que no traigan contenido.
        # Si trae algo distinto en su valor, lo deja intacto.

        $formattedParams = array();

        foreach ($params as $param) {
            if (!isset($param) || strlen($param) == 0 || strtolower($param) == "null") {
                $formattedParams[] = null;
            } else {
                $formattedParams[] = $param;
            }
        }

        return $formattedParams;
    }

    public function getBodyEspiro($master, $turno_id){
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
                "id_pregunta" => $res_pregunta[array_key_first($res_pregunta)]['ID_P'],
                "pregunta" => $res_pregunta[array_key_first($res_pregunta)]['PREGUNTA'],
                "respuestas" => $master->getFormValues(array_map(function ($item) {
                    return array("respuesta"  => $item['RESPUESTA'], "comentario" => $item['COMENTARIO']);
                }, $res_pregunta))
            );
        }

        return $cuestionario;
    }
}
