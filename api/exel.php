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

        case 'I-SmartPro':

            $data = getValuesExelEquipos($datos, 1, 2, 3);
            $response = $master->insertByProcedure('sp_pseudo_interface', [json_encode($data)]);


            break;

        case 'ElectraProS':
            // $data = getValuesExelEquipos($datos, 2, 3, 4);

            // $fh = fopen("algo.txt", 'a');
            // fwrite($fh, json_encode($data));
            // fclose($fh);

            break;


        default:

            // $fh = fopen("algo.txt", 'a');
            // fwrite($fh, 'No hay equipo seleccionado');
            // fclose($fh);

    }


    echo $master->returnApi($response);

}





function getValuesExelEquipos($datos, $getVal1, $getVal2, $getVal3)
{

    $data = json_decode($datos['datos'], true);

    #Validamos si existe algun error con el los datos recibidos
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        $errorMessage = json_last_error_msg();
        $error = "Error al decodificar JSON: " . $errorMessage;

        // $fh = fopen("algo.txt", 'a');
        // fwrite($fh, $error);
        // fclose($fh);

        exit;
    }

    $datos = json_decode($data['datos'], true);
    $arreglo  = [];

    // Acceder a los valores de los datos y los guardamos en la variable de datos
    foreach ($data as $fila) {

        $arreglo[] = ['PREFOLIO' => $fila[$getVal1], 'ESTUDIO' => $fila[$getVal2], 'RESULTADO' => $fila[$getVal3]];
    }

    // $fh = fopen("algo.txt", 'a');
    // fwrite($fh, json_encode($arreglo));
    // fclose($fh);

    //Retornamos el arreglo de los datos
    return $arreglo;
}
