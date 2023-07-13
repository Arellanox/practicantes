<?php
include_once "../clases/master_class.php";
include_once "../clases/correo_class.php";

class MiClase {
  public function miMetodo($mensaje) {
    $params = array(
      'token' => 'edgo0h81kywa8qmg',
      'to' => '120363138555833074@g.us',
      'body' => $mensaje,
      'priority' => '10',
      'referenceId' => '',
      'msgId' => '',
      'mentions' => ''
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.ultramsg.com/instance53560/messages/chat",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => http_build_query($params),
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return [2, "cURL Error #:" . $err];
    } else {
      return [1, $response];
    }
  }
}

$master = new Master();
$correo = new Correo();

$datos = json_decode(file_get_contents('php://input'), true);

$api = $datos['api'];


#insertar datos
$msj = $datos['msj'];
$nombre_usuario = $datos['nombre_usuario'];
$numero_usuario = $datos['numero_usuario'];
$token = $datos['token'];

$fh = fopen("log.txt", 'a');
fwrite($fh, json_encode($datos));
fclose($fh);

$parametros = $master->setToNull(array(
    $msj,
    $nombre_usuario,
    $numero_usuario,
    $token
));

// echo json_encode(['result' => '99999']);
switch ($api) {

    //Inserta en el bot de WhatsApp
    case 1:
        $response = $master->insertByProcedure("sp_asistencia_ti_bot_g", $parametros);

        $objeto = new MiClase();
        if ($response > 0){
            $correo_cath = $objeto->miMetodo("Los usuarios mortales necesitan tu ayuda! #Ticket: " .$response);
            
            if($correo_cath[0] != 1){
                $razon_envio = "Los usuarios mortales necesitan tu ayuda! #Ticket: " .$response;

                $correo->sendEmail("soporte_ti", "Asistente virtual TI", ["luis.cuevas@bimo.com.mx", "josue.delacruz@bimo.com.mx", "monica.gallegos@bimo-lab.com"], $correo_cath[1].". ".$razon_envio);
            }
        }else{
          $correo_cath = $objeto->miMetodo("$nombre_usuario intento hacer un ticket pero no lo logró.");

          $razon_envio = "$nombre_usuario intento hacer un ticket pero no lo logró.";
          $correo->sendEmail("soporte_ti", "Asistente virtual TI", ["luis.cuevas@bimo.com.mx", "josue.delacruz@bimo.com.mx", "monica.gallegos@bimo-lab.com"], $correo_cath[1].". ".$razon_envio);
        }

        break;

    default:
        $response = "API no definida";
        break;
}

echo $master->returnApi(["TICKET" => $response]);
