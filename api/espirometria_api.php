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
$turno_id = $_POST['id_turno'];
$area_id = $_POST['id_area'];
$preguntasRespuestas = $_POST['respuestas'];

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


        $response = $master->insertByProcedure("sp_espiro_cuestionario_g", [json_encode($principal), $turno_id, $area_id, $usuario_id]);

        break;


        #RECUPERAMOS TODOS LOS DATOS DEL FORMULARIO (PREGUNTAS, RESPUESTAS Y COMENTARIOS)
    case 2:

        $response = $master->getByProcedure("sp_espiro_cuestionario_b", [$turno_id]);

        break;

    default:

        $response = "Api no definida";
}

echo $master->returnApi($response);
