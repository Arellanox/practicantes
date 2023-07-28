<?php

use Masterminds\HTML5\Parser\CharacterReference;

require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/Pdf.php";
include_once "../clases/turnero_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    # $tokenVerification->logout();
    # exit;
}

#api
$api = $_POST['api'];

$turno_id = $_POST['turno_id'];
$area_fisica_id = $_POST['area_fisica_id'];

$master = new Master();
$jsonData = new JsonData();

$listaGlobal;

switch ($api) {
    case 1:
        # Liberar paciente.

        // $infoPaciente = $master->getByProcedure('sp_pantalla_turnero', [null]);
        // print_r($infoPaciente);

        $response = $master->updateByProcedure("sp_turnero_liberar_paciente", [$turno_id, $area_fisica_id]);
        $jsonData->removeArea($turno_id);
        $_SESSION['turnero'] = null;
        break;
    case 2:
        # llamar paciente

        # si la listaGlobal$listaGlobal esta vacia, la llenamos
        $request = llamarPaciente($master, $area_fisica_id);

        if (!is_array($request)) {
            if ($master->str_ends_with($request, "}")) {
                $req = json_decode($request, true);

                $response = $req['mensaje'];
                echo $master->returnApi($response, 3);
                exit;
            } else {
                $response = $request;
            }
        } else {
            $response = $request;
        }

        # cambiar el estado de la solicitud en turnero_data.json
        if ($request > 0 || is_array($request)) {
            changeStatusRequest(true);
        }

        break;
    case 3:
        # saltar paciente
        # modificado el 15 de marzo 2023

        # Actualizamos la lista por si existe algun cambio
        fillSessionList($master, $area_fisica_id);

        if (empty($listaGlobal)) {
            # si la lista esta vacia puede significar 2 cosas:
            # 1. Que no haya pacientes para esa area el dia actual.
            # 2. Que aun los pacientes no hayan pasado a toma de muestras o somatometria.
            # Si sucede lo anterior, enviamos un mensaje coqueto.
            $response = "Ya tienes un paciente en atención o no hay nada por aquí.";
            echo $master->returnApi($response, 3);
            exit;
        } else {
            # si no esta vacia.
            # verificamos que el turnero en session este iniciado
            #if (empty($_SESSION['turnero']) || !isset($_SESSION['turnero'])) {
            $aux = $jsonData->getJson();
            if (empty($aux) || !isset($aux)) {
                # si esta vacio o no existe el turnero en session no podemos saltar paciente, necesitamos llamarlo.
                $request = llamarPaciente($master, $area_fisica_id);

                if (!is_array($request)) {
                    if ($master->str_ends_with($request, "}")) {
                        $req = json_decode($request, true);

                        $response = $req['mensaje'];
                        echo $master->returnApi($response, 3);
                        exit;
                    } else {
                        $response = $request;
                    }
                } else {
                    $response = $request;
                }


                if ($request > 0 || is_array($request)) {
                    changeStatusRequest(true);
                }
            } else {
                # si ya existe el turnero, debemos verificar
                # si el paciente que estamos saltando es el correcto.

                #$x = $master->deleteByProcedure("sp_turnero_saltar_paciente", [$_SESSION['turnero'][$area_fisica_id]['turno'], $area_fisica_id]);
                $x = $master->deleteByProcedure("sp_turnero_saltar_paciente", [$jsonData->getData($area_fisica_id), $area_fisica_id]);
                if ($x > 0) {
                    #refresamos la listea para regresar al paciente que acabamos de saltar
                    fillSessionList($master, $area_fisica_id);
                    # buscar la posicion del turno que acabas de borrar
                    $position = 0;
                    foreach ($listaGlobal->getPacientes() as $pat) {

                        # if ($pat->getTurnoId() == $_SESSION['turnero'][$area_fisica_id]['turno']) {
                        if ($pat->getTurnoId() == $jsonData->getData($area_fisica_id)) {
                            $listaGlobal->setPosition($position);
                            break;
                        }
                        $position++;
                    }

                    $listaGlobal->setPosition($listaGlobal->getPosition() + 1);

                    #Obtenemos el paciente que saltamos
                    $omitted = $listaGlobal->getPacientes()[$position];
                    # llamamos al paciente que sigue
                    $next = $listaGlobal->getNextPatient();
                    # seteamos el response a un arreglo
                    $response = array("OMITTED" => $omitted, "NEXT" => $next);
                    # Reservamos el turno para el area correspondiente.
                    $sp = $master->insertByProcedure("sp_turnero_llamar_paciente", [$next->getTurnoId(), $area_fisica_id]);

                    # y finalmente actualizamos los datos por si hay que saltarlo de nuevo.
                    #$_SESSION['turnero'][$area_fisica_id]['turno'] = $next->getTurnoId();
                    $jsonData->setData($area_fisica_id, $next->getTurnoId());
                    changeStatusRequest(true);
                }
            }
        }

        break;
    case 4:
        # pantalla turnero
        $response1 = $master->getByNext('sp_turnero_pantalla', [isset($_SESSION['pacientes_llamados']) ? $_SESSION['pacientes_llamados'] : 0]);

        $response = $response1[0];

        $_SESSION['pacientes_llamados'] = $response1[1][0]["PACIENTES_LLAMADOS"];
        changeStatusRequest(false);
        break;
    case 5:
        # Muestra el sitio actual en el que se encuentra el paciente.
        # En sala de espera, o el nombre del area.

        $res = $master->getByProcedure("sp_turnero_paciente_area_actual", [$turno_id]);
    
        $response = [];
        foreach($res as $current){
            $current['AREAS_PENDIENTES'] = $master->decodeJson([$current['AREAS_PENDIENTES']])[0];
            $response[] = $current;
        }
        
        break;
    case 6:
        # paciente actual en el area.
        $response = $master->getByProcedure("sp_turnero_paciente_actual", [$area_fisica_id]);
        changeStatusOptimizador(false, $area_fisica_id);
        break;
    case 7:
        # ignorar los candados de laboratorio y somatometria,
        # y coloccar al siguiente paciente disponible
        # en la siguiente area disponible
        $response = $master->getByNext("sp_turnero_ignorar_candados", []);

        if (isset($response[0][0]['MSJ'])) {
            echo $master->returnApi($response[0][0]['MSJ'], 3);
            exit;
        } else {
            $jsonData->setData($response[0][0]['AREA_FISICA_ID'], $response[0][0]['ID_TURNO']);
            $response = $response[0][0];
            changeStatusRequest(true);
            changeStatusOptimizador(true, $response[0][0]['AREA_FISICA_ID']);
        }

        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);

function llamarPaciente($master, $area_fisica_id)
{
    global $listaGlobal;
    global $jsonData;
    fillSessionList($master, $area_fisica_id);

    if (empty($listaGlobal)) {
        # si la lista sigue vacia despues de llamar el sp,
        # significa que no hay pacientes para esa area.
        $response = '{"mensaje":"Nada por aquí, nada por allá."}';
    } else {
        # si la lista no esta vacia, llamamos al primer paciente aceptado.
        $object = current($listaGlobal->getPacientes());
        // echo $object->getTurnoId();

        $response = $master->getByProcedure("sp_turnero_llamar_paciente", [$object->getTurnoId(), $area_fisica_id]);

        if (isset($response[0]['MSJ'])) {
            $response = $response[0]['MSJ'];
        }


        # verificar si ya existe, lo reemplazamos
        $jsonData->setData($area_fisica_id, $object->getTurnoId());
        // if(isset($_SESSION['turnero'])){
        //     $_SESSION['turnero'][$area_fisica_id] = array("turno" => $object->getTurnoId());
        // } else {
        //     $_SESSION['turnero'] = array($area_fisica_id => array("turno" => $object->getTurnoId()));
        // }

    }
    return $response;
}

function setDataJson($area, $turno)
{
    # recuperamos la informacion del archivo
    $data = file_get_contents("../data.json");
    # decodificamos la cadena
    $json = json_decode($data, true);

    # verificamos si ya se encuentra el area
    $json[$area] = $turno;

    # colocamos el nuevo dato en el archivo
    file_put_contents("../data.json", json_encode($json, JSON_PRETTY_PRINT));
}

function fillSessionList($master, $area)
{
    global $listaGlobal;
    $response = $master->getByProcedure('sp_turnero_lista_pacientes', [$area]);

    if (!isset($response[0]['MSJ'])) {
        $listaGlobal = fillListPatient($response);
    } else {
        $listaGlobal = null;
    }
}
function fillListPatient($query)
{

    $lista = new ListaPacientes();

    foreach ($query as $patient) {
        $paciente = new Paciente();
        $paciente->setAreaId($patient['AREA_ID']);
        $paciente->setEtiquetaTurno($patient['ETIQUETA_TURNO']);
        $paciente->setPaciente($patient['PACIENTE']);
        $paciente->setTurnoId($patient['TURNO_ID']);

        $lista->pushPaciente($paciente);
    }

    return $lista;
}

function changeStatusRequest($param)
{
    $turnero_data = "../turnero_data_" . $_SESSION['id'] . ".json";

    if ($param) {
        $archivos = glob("../turnero_data*");
        foreach ($archivos as $archivo) {
            if (file_exists($archivo)) {
                $data = file_get_contents($archivo);
                $request = json_decode($data, true);
                $request['request'] = $param;
                file_put_contents($archivo, json_encode($request));
            } else {
                file_put_contents($archivo, json_encode(array("request" => false)));
                $data = file_get_contents($archivo);
                $request = json_decode($data, true);
                $request['request'] = $param;
                file_put_contents($archivo, json_encode($request));
            }
        }
    } else {
        if (file_exists($turnero_data)) {
            $data = file_get_contents($turnero_data);
            $request = json_decode($data, true);
            $request['request'] = $param;
            file_put_contents($turnero_data, json_encode($request));
        } else {
            file_put_contents($turnero_data, json_encode(array("request" => false)));
            $data = file_get_contents($turnero_data);
            $request = json_decode($data, true);
            $request['request'] = $param;
            file_put_contents($turnero_data, json_encode($request));
        }
    }
}


function changeStatusOptimizador($param, $area)
{
    $data = file_get_contents("../archivos/sistema/json/turnero_optimizador.json");
    $request = json_decode($data, true);
    $master = new Master();
    $master->setLog("Area: $area", null);
    $request['Optimizador'][$area] = $param;
    file_put_contents("../archivos/sistema/json/turnero_optimizador.json", json_encode($request));
}
