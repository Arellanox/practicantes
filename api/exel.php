<?php
require_once "../clases/master_class.php";
$master = new Master();

$datos = json_decode(file_get_contents('php://input'), true);

if (isset($datos['dispositivo']) && $datos['datos']) {


    switch ($datos['dispositivo']) {

        case 'Maglumi':

            $data = getValuesExelEquipos($datos, 1, 2, 5);
            $response = $master->insertByProcedure('sp_pseudo_interface', [json_encode($data)]);

            break;

        case 'Erba':
            

            $data = getValuesCsvEquipos($datos);
            $response = $master->insertByProcedure('sp_pseudo_interface', [json_encode($data)]);

            $fp = fopen('algo.txt', 'a');
            fwrite($fp, json_encode($data));
            fclose($fp);
            break;

        case 'SelectraProS':

            $data = getValuesTxtEquipos($datos, 2, 7, 8);
            $response = $master->insertByProcedure('sp_pseudo_interface', [json_encode($data)]);

            // $fp = fopen('algo.txt', 'a');
            // fwrite($fp, json_encode($data));
            // fclose($fp);
           
            break;
        default:

            $response = 'No hay equipo definido';
            $fh = fopen("algo.txt", 'a');
            fwrite($fh, $datos);
            fclose($fh);
    }

    echo $master->returnApi($response);

}

#============================================================== FUNCIONES DE ORDENAMINETO DE DATOS

//FUNCION PARA EQUIPOS QUE DAN ARCHIVOS XLS (MAGLUMI)
function getValuesExelEquipos($datos, $getVal1, $getVal2, $getVal3)
{

    $data = json_decode($datos['datos'], true);
   

    #Validamos si existe algun error con el los datos recibidos
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        $errorMessage = json_last_error_msg();
        $error = "Error al decodificar JSON: " . $errorMessage;
        exit;
    }

    $datos = json_decode($data['datos'], true);
    $arreglo  = [];

    // Acceder a los valores de los datos y los guardamos en la variable de datos
    foreach ($data as $fila) {

        $arreglo[] = ['PREFOLIO' => $fila[$getVal1], 'ESTUDIO' => $fila[$getVal2], 'RESULTADO' =>       $fila[$getVal3]];

    }

    //Retornamos el arreglo de los datos
    return $arreglo;
}

//FUNCION PARA EQUIPOS QUE DAN ARCHIVOS TXT (SELECTRA)
function getValuesTxtEquipos($datos, $getVal1, $getVal2, $getVal3)
{
    $datos = json_decode($datos['datos'], true); //El parámetro true se utiliza para obtener un arreglo asociativo en lugar de un objeto.
    $resultado = array();
    $resultadoFinal = array();
    $nuevoArreglo = array(); //Creamos un arreglo vacio que almacenara los valores de cada fila

    // Recorrer el arreglo
    foreach ($datos as $i => $fila) {
        $keys = array_keys($fila); //Extraemos las key de la fila actual que se recorre
        $values = array_values($fila); //Extraemos los valores de la fila actual que se recorre

        //Separamos la fila de los valores por subvalores que seran ordenados respectivamente
        $colum2 = explode("\t", $values[0])[$getVal1];
        $colum7 = explode("\t", $values[0])[$getVal2];
        $colum8 = explode("\t", $values[0])[$getVal3];

        //Agregamos los valores anteriores a el arreglo vacio creado para almacenar nuestro nuevo array
        $nuevoArreglo["PREFOLIO"] = $colum2;
        $nuevoArreglo["ESTUDIO"] = $colum7;
        $nuevoArreglo["RESULTADO"] = $colum8;

        // Agregamos las datos de nuevoArreglo a el arreglo final que es resultado
        $resultado[] = $nuevoArreglo;

        #Calculamos el BUN
        if ($colum7 == 'URSL'){

            $nuevoArreglo["PREFOLIO"] = $colum2;
            $nuevoArreglo["ESTUDIO"] = 'BUN';
            $nuevoArreglo["RESULTADO"] = round($colum8 / 2.14, 2);
            $resultado[] = $nuevoArreglo;
        }

         #Calculamos el VLDL
        if ($colum7 == 'TGML'){

            $nuevoArreglo["PREFOLIO"] = $colum2;
            $nuevoArreglo["ESTUDIO"] = 'VLDL';
            $nuevoArreglo["RESULTADO"] = round($colum8 / 5, 2);
            $resultado[] = $nuevoArreglo;
        } 
    }

    $arregloAlbu = [];
    $relAG = [];
    foreach ($resultado as $item) {

        #Calculamos la BI dependiendo de BIDN y BITN 
        if ($item["ESTUDIO"] === "BIDN" || $item["ESTUDIO"] === "BITN") {
            $nuevoArreglo["PREFOLIO"] = $item["PREFOLIO"];
            $nuevoArreglo["ESTUDIO"] = 'BI';

            if ($item["ESTUDIO"] === "BIDN") {
                $bidn = $item["RESULTADO"];
            } else {
                $bitn = $item["RESULTADO"];
            }

            if (isset($bidn) && isset($bitn)) {
                $nuevoArreglo["RESULTADO"] = round($bitn - $bidn, 2);
                $resultado[] = $nuevoArreglo;
                unset($bidn, $bitn);
            }
        }

        #Calculamos la GLO dependiendo de PROB y ALBU
        if ($item["ESTUDIO"] === "PROB" || $item["ESTUDIO"] === "ALBU") {
            $nuevoArreglo["PREFOLIO"] = $item["PREFOLIO"];
            $nuevoArreglo["ESTUDIO"] = "GLO";

            if ($item["ESTUDIO"] === "PROB") {
                $prob = $item["RESULTADO"];
            } else {
                $albu = $item["RESULTADO"];

                #Guardamos todos los datos del estudio de ALBU para usarlos despues para sacar la REL A-G
                $arregloAlbu["PREFOLIO"] = $item["PREFOLIO"];
                $arregloAlbu["ESTUDIO"] = $item["ESTUDIO"];
                $arregloAlbu["RESULTADO"] = $item["RESULTADO"];
                $relAG[] = $arregloAlbu;
            }   

            if (isset($prob) && isset($albu)) {
                $nuevoArreglo["RESULTADO"] = round($prob - $albu, 2);
                $resultado[] = $nuevoArreglo;
                unset($prob, $albu);
            }
        }

        #Calculamos la Relacion COL/HDL dependiendo de CHSL y HDL
        if ($item["ESTUDIO"] === "CHSL" || $item["ESTUDIO"] === "HDL") {
            $nuevoArreglo["PREFOLIO"] = $item["PREFOLIO"];
            $nuevoArreglo["ESTUDIO"] = 'REL';

            if ($item["ESTUDIO"] === "CHSL") {
                $col = $item["RESULTADO"];
            } else {
                $hdl = $item["RESULTADO"];
            }

            if (isset($col) && isset($hdl)) {
                $nuevoArreglo["RESULTADO"] = round($col / $hdl, 2);
                $resultado[] = $nuevoArreglo;
                unset($col, $hdl);
            }
        }

    }


    #Guardamops el PREFOLIO, ESTUDIO y RESULTADO de GLO para sacar la REL A-G
    $arregloGlo  = [];
    foreach($resultado as $item){
        if($item["ESTUDIO"] === "GLO"){
            $arregloGlo["PREFOLIO"] = $item["PREFOLIO"];
            $arregloGlo["ESTUDIO"] = $item["ESTUDIO"];
            $arregloGlo["RESULTADO"] = $item["RESULTADO"];
            $relAG[] = $arregloGlo;
        }
    }


    #Validamos si nuestro arreglo del relAG tiene contenido
    if(count($relAG) > 0){
        $rel = calcularRelAG($relAG);
        $resultado = array_merge($resultado, $rel); #Si hay resultados de REL A-G combinamos el resultado con la REL A-G
    }
    

   
    return $resultado; 
}


#FUNCION PARA EQUIPOS QUE DAN ARCHIVOS DE CSV (ERBA)
function getValuesCsvEquipos($datos){

    // $fp = fopen('algo.txt', 'a');
    // fwrite($fp, json_encode($datos));
    // fclose($fp);

    $data = json_decode($datos['datos'], true);

    $arreglo = [];
    foreach ($data as $fila){
        if ($fila['Sample ID'] != 0){

            if ($fila['Index'] == 'APTT') {

                $arreglo[] = ['PREFOLIO' => $fila['Sample ID'], 'TPT' => $fila['Result 1'], 'REL' => $fila['Result 2'],  'INDEX' => $fila['Index']];
            } else {
                $arreglo[] = ['PREFOLIO' => $fila['Sample ID'], 'ACT' => $fila['Result 1'], 'INR' => $fila['Result 2'], 'TP' => $fila['Result 3'], 'INDEX' => $fila['Index']];
            }
        }
     
        
    }

    $prefolios = array_map(function($item){
        return $item['PREFOLIO'];
    }, $arreglo);

    $PREFOLIOS = array_unique($prefolios); 

    $arregloFinal = [];
    // $arregloResultado = [];
    foreach ($PREFOLIOS as $fila){
        
      $filtrado = array_filter($arreglo, function($item) use($fila) {

            return $item['PREFOLIO'] == $fila;
      });

        foreach($filtrado as $key => $value){
            
            foreach($value as $k => $v){

                if(!in_array($k, ['PREFOLIO', 'INDEX'])){

                    $arregloFinal[] = ['PREFOLIO' => $fila, 'ESTUDIO' => $k, 'RESULTADO' => $v];
                }

            }
        }
        
    }



    

    return $arregloFinal;

        
}

#FUNCION PARA CALCULAR LA REL A-G YA QUE ESTABA DIFICIL EN EL MISMO FOREACH 
function calcularRelAG($datos)
{   
    #Declaramos nuestras variables de almacenamiento de datos
    $resultadosGLO = array();
    $resultadosALBU = array();
    $resultadoRelAG = array();

    #Recorremos el arreglo que nos llega y sacamos los resultados de GLO y ALBU tomando como clave asociativa el PREFOLIO
    foreach ($datos as $dato) {
        if ($dato["ESTUDIO"] === "GLO") {
            $resultadosGLO[$dato["PREFOLIO"]] = $dato["RESULTADO"];
        } elseif ($dato["ESTUDIO"] === "ALBU") {
            $resultadosALBU[$dato["PREFOLIO"]] = $dato["RESULTADO"];
        }
    }

    #Recorremos el arreglo de GLO que contienen los resultados de dicho ESTUDIO
    foreach ($resultadosGLO as $prefolio => $resultadoGLO) {
        if (isset($resultadosALBU[$prefolio])) { #Preguntamos si existe un resultado de ALBU con el mismo PREFOLIO que estamos usando
            $resultadoRelAG[] = array(
                "PREFOLIO" => $prefolio, #Asignamos el PREFOLIO actual 
                "ESTUDIO" => "REL A-G",  #Asignamos el nombre del ESTUDIO
                "RESULTADO" => round($resultadosALBU[$prefolio] / $resultadosGLO[$prefolio], 2) #Calculamos el resultado con el resultado de ALBU y GLO 
            );
        }
    }

    return $resultadoRelAG; #Retornamos el resultado general
}
