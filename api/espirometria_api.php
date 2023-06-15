<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();

#OBTENEMOS LA API POR MEDIO DEL POST
$api = $_POST['api'];

$turno_id = $_POST['turno_id'];

$area_id = $_POST['id_area'];
$id_turno = $_POST['id_turno'];
$preguntasRespuestas = $_POST['respuestas'];
$confirmado = isset($_POST['confirmado']) ? $_POST['confirmado'] : 0;

$usuario_id = $_SESSION['id'];


//declaramos nuestras variables de almacenamineto para guardar nuestras preguntas y respuestas
$preguntas = [];
$respuestas = [];




#EJECUTAMOS LA API 
switch ($api) {



        #GUARDAMOS LOS DATOS
    case 1:


        $principal = [];
        $secundario = [];
        $posicion = 0;



        foreach ($preguntasRespuestas as $key => $value) {

            $principal[$posicion] = ['preguntaID' => $key];
            $valor = null;
            $comentario = null;

            if (COUNT($preguntasRespuestas[$key]) > 1) {



                foreach ($value as $item) {
                    $secundario[] = ['respuestaID' => $master->setToNull([$item['valor']])[0] ? $item['valor'] : $valor, 'comentario' => $master->setToNull([$item['comentario']])[0] ? $item['comentario'] : $comentario];
                }
            } else {

                $secundario = ['respuestaID' => isset($value[array_key_first($value)]['valor']) ? $value[array_key_first($value)]['valor'] : $valor, 'comentario' => isset($value[array_key_first($value)]['comentario']) ? $value[array_key_first($value)]['comentario'] : $comentario];
            }
            $principal[$posicion]['respuestaID'] = $secundario;
            $secundario = [];

            $posicion++;
        }


        $response = $master->insertByProcedure("sp_espiro_cuestionario_g", [json_encode($principal), $id_turno, $area_id, $usuario_id, $confirmado]);

        break;


        #RECUPERAMOS TODOS LOS DATOS DEL FORMULARIO (PREGUNTAS, RESPUESTAS Y COMENTARIOS)
    case 2:

        $response = $master->getByProcedure("sp_espiro_cuestionario_b", [$turno_id]);

        break;
    case 0:
        # json para el reporte de espirometria.
        $respuestas = $master->getByProcedure("sp_espiro_cuestionario_b", [$turno_id]);

        # declaramos el arreglo que guardara el id de la pregunta
        $preguntas = array();

        # llenamos el arreglo
        foreach($respuestas as $current){
            $preguntas[] = $current['ID_P'];
        }

        # eliminamos las duplicidades
        $preguntas = array_unique($preguntas);

        # Declaramos un arreglo que guarde el cuestionario del paciente.
        $cuestionario = array();

        # llenamos el cuestionario, preparando el arreglo para el json.
        foreach($preguntas as $pregunta){
            
            #filtramos las respuestas de cada pregunta del arreglo origina, el que viene de la base de datos.
            $res_pregunta = array_filter($respuestas, function($array) use ($pregunta){
                return $array['ID_P'] == $pregunta;
            });
            
            # formamos el arreglo para el json.
            $cuestionario[] = array(
                "pregunta" => $res_pregunta[array_key_first($res_pregunta)]['PREGUNTA'],
                "respuestas" => $master->getFormValues(array_map(function($item){
                    return array("respuesta"  => $item['RESPUESTA'], "comentario"=> $item['COMENTARIO']);
                },$res_pregunta))
            );
        }

        echo json_encode($cuestionario);
        break;

    default:

        $response = "Api no definida";
}

echo $master->returnApi($response);
