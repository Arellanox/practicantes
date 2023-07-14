<?php
require_once "../clases/master_class.php";
$master = new Master();

$datos = json_decode(file_get_contents('php://input'), true);

// if (isset($datos['dispositivo']) && $datos['datos']) {


    switch ($datos['dispositivo']) {

        case 'Maglumi':

            $data = getValuesExelEquipos($datos, 1, 2, 5);
            $response = $master->insertByProcedure('sp_pseudo_interface', [json_encode($data)]);

            break;

        case 'Erba':
            

            $data = getValuesCsvEquipos($datos);

            $fh = fopen("algo.txt", 'a');
            fwrite($fh, json_encode($data));
            fclose($fh);
             
       
            break;

        case 'SelectraProS':

            $data = getValuesTxtEquipos($datos, 2, 7, 8);
            $response = $master->insertByProcedure('sp_pseudo_interface', [json_encode($data)]);

           
            break;
        default:

            $response = 'No hay equipo definido';
            $fh = fopen("algo.txt", 'a');
            fwrite($fh, $datos);
            fclose($fh);
    }


    echo $master->returnApi($response);

// }




//FUNCION PARA EQUIPOS QUE DAN ARCHIVOS XLS
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


//FUNCION PARA EQUIPOS QUE DAN ARCHIVOS TXT
function getValuesTxtEquipos($datos, $getVal1, $getVal2, $getVal3)
{
   

    $datos = json_decode($datos['datos'], true); //El parámetro true se utiliza para obtener un arreglo asociativo en lugar de un objeto.

    $resultado = array();

    // Recorrer el arreglo
    foreach ($datos as $i => $fila) {
        $keys = array_keys($fila); //Extraemos las key de la fila actual que se recorre
        $values = array_values($fila); //Extraemos los valores de la fila actual que se recorre

        $nuevoArreglo = array(); //Creamos un arreglo vacio que almacenara los valores de cada fila

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
    }
    

    return $resultado;

}


function getValuesCsvEquipos($datos){


    $data = json_decode($datos['datos'], true);

    $arreglo = [];
    foreach ($data as $fila){

        if ($fila['Index'] == 'APTT'){

        $arreglo[] = ['PREFOLIO' => $fila['Method name'], 'TPT' => $fila['Date and time of results'], 'REL' => $fila['Result 1'],  'INDEX' => $fila['Index']];

        }else{
            $arreglo[] = ['PREFOLIO' => $fila['Method name'], 'ACT' => $fila['Date and time of results'], 'INR' => $fila['Result 1'], 'TP' => $fila['Result 2'], 'INDEX' => $fila['Index']];
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


 