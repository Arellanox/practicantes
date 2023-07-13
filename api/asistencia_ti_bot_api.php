<?php
include_once "../clases/master_class.php";

class MiClase {
  public function miMetodo() {
    $params = array(
      'token' => 'edgo0h81kywa8qmg',
      'to' => '120363138555833074@g.us',
      'body' => 'Los usuarios mortales necesitan tu ayuda!',
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
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
  }
}

$master = new Master();

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
        
        // Crear objeto y llamar al método
        $objeto = new MiClase();
        $objeto->miMetodo();
        break;

    default:
        $response = "API no definida";
        break;
}

echo $master->returnApi(["TICKET" => $response]);
