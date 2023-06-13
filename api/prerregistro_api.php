<?php
include_once "../clases/master_class.php";

$master = new Master();
$api = $_POST['api'];

#datos de pacientes
$curp = $_POST['curp'];
$pasaporte = $_POST['pasaporte'];

# Datos de turnos
$idTurno = $_POST['idTurno'];
$pacienteId = $_POST['pacienteId'];
$paqueteId = $_POST['paqueteId'];
$prefolio = $_POST['prefolio'];
$folio = $_POST['folio'];
$fechaAgenda = $_POST['fechaAgenda'];
$fechaReagenda = $_POST['fechaReagenda'];
$fechaRecepcion = $_POST['fechaRecepcion'];
$turno = $_POST['turno'];
$habilitado = isset($_POST['habilitado']) ? $_POST['habilitado'] : 0;
$identificacion = $_POST['identificacion'];
$total = $_POST['total'];
$completado = $_POST['completado'];
$comentarioRechazo = $_POST['comentario_rechazo'];
$clienteId = $_POST['cliente_id'];
$segmentoId = $_POST['segmento_id'];

#Datos extras
$usuario_id = $_SESSION['id'];


#datos de antecedentes
$antecedentes = array_slice($_POST, 0, count($_POST) - 4);
// print_r($antecedentes);


#Datos de espiro
$espirometria = $_POST['respuestas'];



switch ($api) {
    case 1:
        #buscar el paciente por medio de la curp
        if (!isset($pacienteId)) {
            $paciente = $master->getByProcedure('sp_pacientes_b', array(null, $curp, $pasaporte, null));

            if (!count($paciente) > 0) {
                echo json_encode(array('response' => array('code' => 2, 'data' => "CURP/Pasaporte no registrado.")));
                exit;
            }
            $pacienteId = $paciente[0]['ID_PACIENTE'];
        }

        # preparamos el array para que consuma el procedure
        $preTurno = array(
            $idTurno,
            $pacienteId,
            $paqueteId,
            $prefolio,
            $folio,
            $fechaAgenda,
            $fechaReagenda,
            $fechaRecepcion,
            $turno,
            $habilitado,
            $identificacion,
            $total,
            $completado,
            $comentarioRechazo,
            $clienteId,
            $segmentoId
        );

        #insertar antecedentes
        $lastId = $master->insertByProcedure('sp_turnos_g', $preTurno);

        if  (is_numeric($lastId)) {
            #si el turno se inserto correctamente, se procede a insertar los antecedentes a ese turno
            $prefolio = $master->getByProcedure('sp_turnos_b', array($lastId, null, null));
            foreach ($antecedentes as $ante) {
                if (count($ante) == 3) {
                    # si el arreglo tiene 3
                    # quiere decir que tiene id antecedente, id respuesta, y observaciones
                    $ant = array(
                        null, #id_consultortio_antecedente
                        $lastId, #turno_id,
                        $ante[0], #antecedente_subtipo_id
                        $ante[1], #antecedente_respuesta_id
                        $ante[2] #notas
                    );
                    $response = $master->insertByProcedure('sp_consultorio_antecedentes_g', $ant);
                } else {
                    #si el arreglo tiene 2 elementos
                    # quiere decir que tiene id, antecedente y observaciones [sin el id de respuesta]
                    if (is_numeric($ante[1])) {
                        $ant = array(
                            null, #id_consultortio_antecedente
                            $lastId, #turno_id,
                            $ante[0], #antecedente_subtipo_id
                            $ante[1], # antecedentes_respuesta_id
                            null #notas
                        );
                    } else {
                        $ant = array(
                            null, #id_consultortio_antecedente
                            $lastId, #turno_id,
                            $ante[0], #antecedente_subtipo_id
                            null, # antecedentes_respuesta_id
                            $ante[1] #notas
                        );
                    }

                    $response = $master->insertByProcedure('sp_consultorio_antecedentes_g', $ant);
                }
            }

            #Insertamos las respuestas de el formulario de espirometria --- verificamos si hay un formulario de espiro
            
                
                $principal = [];
                $secundario = [];
                $posicion = 0;

                foreach ($espirometria as $key => $value) {

                    $principal[$posicion] = ['preguntaID' => $key];
                    $valor = null;
                    $comentario = null;

                    if (COUNT($espirometria[$key]) > 1) {
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

                                                                                                                    
            $response = $master->getByNext("sp_espiro_cuestionario_g", [json_encode($principal), $lastId, 5, $usuario_id]);
            print_r($response);
            exit;
            


        } else {
            # si no se puede insertar el turno, termina el ejecucion
            echo json_encode(array('response' => array('code' => 2, 'data' => "No hemos podido agendar su visita.")));
            exit;

        } 

        echo json_encode(array('response' => array('code' => 1, 'data' => $prefolio[0]['PREFOLIO'])));
        exit;

        break;


    case 2: #No se usa
        # recuperar de los ultimos antecedentes registrardos de un paciente por medio de la curp
        #buscar el paciente por medio de la curp
        $paciente = $master->getByProcedure('sp_pacientes_b', array(null, $curp, $pasaporte));

        if (!is_array($paciente)) {
            echo "identificación no reconocida";
            exit;
        }

        if (count($paciente) == 0) {
            echo "CURP incorrecta. La consulta no devolvió datos.";
        }

        # obtenemos el id del paciente que despues enviaremos al sp para obtener sus antecedentes
        $pacienteId = $paciente[0]['ID_PACIENTE'];

        $ultimosAntecedentes = $master->getByProcedure('sp_ultimos_antecedentes_paciente', array($pacienteId));

        # creamos un array vacio que contendra los antecedentes por subtipo
        $antecedentes = array();
        # creamos una varible para identificar el tipo de antecedente que tenemos actualmente
        $idTipo = 1; # se inicializa en 1 para poder guardar el primer tipo
        $count = 0;
        $tipoArray = array();
        

        foreach ($ultimosAntecedentes as $ultimo) {

            #comparamos el primer idTipo
            if ($ultimo['ID_TIPO'] == $idTipo) {
                $subtipoArray = array(
                    '0' => $ultimo['ID_RESPUESTA'],
                    '1' => $ultimo['NOTAS'],
                    '2' => $ultimo['ID_SUBTIPO']
                );
                ## asignamos una etiqueta al arreglo
                $label = str_replace(" ", "_", $ultimo['SUBTIPO']);

                $tipoArray[] = $subtipoArray;
            } else {
                $idTipo = $ultimo['ID_TIPO'];
                $antecedentes[] = $tipoArray;
                $tipoArray = array();

                $subtipoArray = array(
                    '0' => $ultimo['ID_RESPUESTA'],
                    '1' => $ultimo['NOTAS'],
                    '2' => $ultimo['ID_SUBTIPO']
                );
                ## asignamos una etiqueta al arreglo
                $label = str_replace(" ", "_", $ultimo['SUBTIPO']);

                $tipoArray[] = $subtipoArray;

                /* # Guardamos el arreglo que hemos estado guardando en nuestro arreglo $antecedentes
                $antecedentes[$label] = $tipoArray;
                # guardarmos el el id de tipo en la variable $idTipo
                $idTipo = $ultimo['ID_SUBTIPO'];
                $label = str_replace(" ","_",$ultimo['SUBTIPO']);
                $tipoArray = array();*/
            }
        }
        $antecedentes[] = $tipoArray;
        echo json_encode($antecedentes);
        break;

    case 3:
        #buscar paciente por curp
        $response = $master->getByProcedure('sp_pacientes_b', array(null, $curp, $pasaporte));
        echo $master->returnApi($response);
        break;

    default:
        echo "La selección actual no esta disponible. (API).";
        break;
}
