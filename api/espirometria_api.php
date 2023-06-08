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
$preguntasRespuestas = $_POST['respuestas'];


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
       

        foreach ($preguntasRespuestas as $key => $value){

            $principal[$posicion] = ['preguntaID' => $key] ;
            $valor = null;
            $comentario = null;

            if (COUNT($preguntasRespuestas[$key]) > 1){

                

                foreach ($value as $item ){
                    $secundario[] = ['respuestaID' => isset($item['valor']) ? $item['valor'] : $valor, 'comentario' => isset($item['comentario']) ? $item['comentario']: $comentario] ;
                    
                }
                     
            }else{
                
                $secundario = ['respuestaID' => isset($value[array_key_first($value)]['valor']) ? $value[array_key_first($value)]['valor'] : $valor, 'comentario' => isset($value[array_key_first($value)]['comentario']) ? $value[array_key_first($value)]['comentario']: $comentario] ;

            }
            $principal[$posicion]['respuestaID'] = $secundario;
            $secundario = [];

            $posicion++;
            
        }


        $response = $master->insertByProcedure("sp_espiro_cuestionario_g", [json_encode($principal), $turno_id]);

        // echo json_encode($preguntasRespuestas);
        // exit;


         //Hacemos un ciclo para poder recorrer todas las resouestas y datos enviados
        //  foreach ($preguntasRespuestas as $preguntaId => $respuestasArray) {
    
          
        //     $comentario = null;
            
        //      // Agregamos la pregunta a la lista de preguntas
        //      $preguntas[] = $preguntaId;
        //      $respuesta[] = array('valor' => $respuestasArray['valor'] , 'comentario' =>isset($respuestasArray['comentario']) ? $respuestasArray['comentario'] : $comentario );

             //Recorremos todas las respuestas y las almacenamos en nuestra variable de respuestas
            //  foreach ($respuestasArray as $respuestaId => $respuesta) {
      
            //      // Verificamos si la respuesta tiene un comentario para alamacenarla con la respuesta
            //      if (isset($respuesta['comentario']) && !empty($respuesta['comentario'])){ 
            //          // Agregamos la respuesta con comentario a la lista de respuestas

            //          $respuestas[$preguntaId][] = [
            //              'valor' => $respuesta['valor'],
            //              'comentario' => $respuesta['comentario']
            //          ];
            //      } else {

            //          // Agregamos la respuesta sin comentario a la lista de respuestas

            //          $respuestas[$preguntaId][] = $respuesta['valor'];
            //      }
            //  }

        // }

        // $response = $master->insertByProcedure("sp_espiro_cuestionario_g", [json_encode($preguntas), json_encode($respuesta), $turno_id]);


        // // Imprimir las preguntas con sus respectivas respuestas
        // // foreach ($preguntas as $preguntaId) {
        // //     echo "Pregunta: $preguntaId" . "<br>";

        // //     foreach ($respuestas[$preguntaId] as $respuesta) {
        // //         //Comprobamos si existe un comentario en nuestro array
        // //         if (is_array($respuesta)) {
        // //             echo "Respuesta (con comentario): " . $respuesta['valor'] . " - Comentario: " . $respuesta['comentario'] . "<br>";
        // //         } else {
        // //             echo "Respuesta: $respuesta" . "<br>";
        // //         }
        // //     }

        // //     echo  "<br>";
        // // }

        // foreach ($preguntas as $preguntaId) {

        //     foreach ($respuestas[$preguntaId] as $respuesta) {

        //         // Comprobar si la respuesta tiene un comentario
        //         if (is_array($respuesta)) {
                    
        //             $valor = $respuesta['valor'];
        //             $comentario = $respuesta['comentario'];

        //             //Guardamos todos nuestros valores en una variable global
        //             $params = $master->setToNull(array(
        //                 $preguntaId,
        //                 $valor,
        //                 $comentario,
        //                 $turno_id
        //             ));

        //             //LLamamos al procedure y ejecutamos
        //             $response = $master->insertByProcedure("sp_espiro_cuestionario_g", $params);

        //            //En caso de no tener comentarios lo pasamos como null
        //         } else {

        //             $valor = $respuesta;
        //             $comentario = null;

        //             //Guardamos todos nuestros nuestros valores en una variable global
        //             $params = $master->setToNull(array(
        //                 $preguntaId,
        //                 $valor,
        //                 $comentario,
        //                 $turno_id
        //             ));

        //             //Llamamos a nuestro procedure y lo ejecutamos
        //             $response = $master->insertByProcedure("sp_espiro_cuestionario_g", $params);
                    
        //         }
        //     }

        // }



        break;

    default:

        $response = "Api no definida";

}

echo $master->returnApi($response);



   











