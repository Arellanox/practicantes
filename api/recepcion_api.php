<?php
include_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$api = $_POST['api'];
$master = new Master();
$host = $master->selectHost($_SERVER['SERVER_NAME']);
$hoy = date("Ymd");

$estado_paciente = $_POST['estado'];
$idTurno = $_POST['id_turno'];
$idPaquete = $_POST['id_paquete']; #
$comentarioRechazo = $_POST['comentario_rechazo'];
$identificacion = $_POST['identificacion']; #url
$area_id = $_POST['area_id'];

$alergias = $_POST['alergias'];
$segmento_id = $_POST['segmento_id'];

# trabajadores de la ujat
$is_worker = $_POST['nuevo-trabajador']; # bit para saber si es ujat y se debe agregar la info del trabajador
$e_id_trabajador = $_POST['trabajador_id'];
$e_nombre = $_POST['nombre'];
$e_paterno = $_POST['paterno'];
$e_materno = $_POST['materno'];
$e_edad = $_POST['edad'];
$e_fecha_nacimiento = $_POST['nacimiento'];
$e_num_trabajador = $_POST['numero_trabajador'];
$e_curp = $_POST['curp'];
$e_pasaporte = $_POST['pasaporte'];
$e_extranjero = $_POST['extranjero'];
$e_genero = $_POST['genero'];
$e_ures = $_POST['ures'];
$e_categoria = $_POST['trabajador-categoria'];
$e_parentesco = $_POST['parentesco'];
$e_diagnostico = $_POST['diagnostico'];
$e_turno_id = $_POST['turno_id'];
$e_clave_beneficiario = $_POST['clave_beneficiado'];
$e_medico = $_POST['medico'];
$e_cedula = $_POST['cedula-medico'];
$e_pase = $_POST['pase'];
$parametro = $_POST['parametro'];

// nuevos datos
$foto_paciente = $_POST['avatar'];
$medico_tratante = $_POST['medico_tratante'];
$medico_correo = $_POST['medico_correo'];



# reagendar
$fecha_reagenda = $_POST['fecha_reagenda'];


#servicio para pacientes particulares o servicios extras para pacientes de empresas
if (!is_null($_POST['servicios'])) {
    $servicios = explode(",", $_POST['servicios']); //array
}

#ordenes medicas
$orden_laboratorio = $_FILES['orden-medica-laboratorio'];
$orden_rayos_x = $_FILES['orden-medica-rx'];
$orden_ultrasonido = $_FILES['orden-medica-us'];

# Pases de los pacientes de la ujat

$pase_ujat = $_FILES['pase-ujat'];

$ordenes = array(
    'ORDEN_LABORATORIO' => $orden_laboratorio,
    'ORDEN_RAYOS_X' => $orden_rayos_x,
    'ORDEN_ULTRASONIDO' => $orden_ultrasonido
);

$ordenes = $master->checkArray($ordenes, 1);

# para envio de correo de empresaas
$cliente_id = $_POST['cliente_id'];
$fecha_ingreso = $_POST['fecha_ingreso'];

switch ($api) {
    case 1:
        # recuperar pacientes por estado
        # 1 para pacientes aceptados
        # 0 para pacientes rechazados
        # null o no enviar nada, para pacientes en espera
        $response = $master->getByProcedure('sp_buscar_paciente_por_estado', array($estado_paciente));

        break;
    case 2:
        # aceptar o rechazar pacientes [tambien regresar a la vida]
        # enviar 1 para aceptarlos, 0 para rechazarlos, null para pacientes en espera
        // $response = $master->updateByProcedure('sp_recepcion_cambiar_estado_paciente', array($idTurno, $estado_paciente, $comentarioRechazo));
        #
        $response = $master->getByNext('sp_recepcion_cambiar_estado_paciente', array($idTurno, $estado_paciente, $comentarioRechazo, $alergias, $e_diagnostico, null, $medico_tratante, $medico_correo)); #<-- la id de segmento manda error si no se le envia algo

        $etiqueta_turno = $response[1];

        # Insertar el detalle del paquete al turno en cuestion
        if ($estado_paciente == 1) {
            # si el paciente es aceptado, cargar los estudios correspondientes
            rename($identificacion, "../../archivos/identificaciones/" . $idTurno . ".png");
            $response = $master->insertByProcedure('sp_recepcion_detalle_paciente_g', array($idTurno, $idPaquete, null));
            #aqui subir las ordenes medicas si las hay
            #crear la carpeta de tunos dentro de 

            if (count($ordenes) > 0) {
                $dir = $master->urlComodin . $master->urlOrdenesMedicas . "$idTurno/";
                $r = $master->createDir($dir);
                if ($r == 1) {
                    #movemos las ordenes medicas
                    $return = $master->guardarFiles($_FILES, 'orden-medica-laboratorio', $dir, "ORDEN_MEDICA_LABORATORIO_$idTurno");
                    $return2 = $master->guardarFiles($_FILES, 'orden-medica-rx', $dir, "ORDEN_MEDICA_RX_$idTurno");
                    $return3 = $master->guardarFiles($_FILES, 'orden-medica-us', $dir, "ORDEN_MEDICA_ULTRASONIDO_$idTurno");

                    # metemos el area al que pertenece
                    $return[0]['area_id'] = 6;
                    $return2[0]['area_id'] = 8;
                    $return3[0]['area_id'] = 11;
                    $merge = array_merge($return, $return2, $return3);

                    #insertarmos las ordenes medicas en la base de datos
                    foreach ($merge as $item) {
                        if (!empty($item['tipo'])) {
                            $responseOrden = $master->insertByProcedure('sp_ordenes_medicas_g', [null, $idTurno, $item['url'], $item['tipo'], $item['area_id']]);
                        }
                    }
                } else {
                    $master->setLog("No se pudo crear el directorio para guardar las ordenes medicas", "recepcion_api.php [case 2]");
                }
            }
        } else {
            # si el paciente es rechazado, se desactivan los resultados de su turno.
            $response = $master->updateByProcedure('sp_recepcion_desactivar_servicios', array($idTurno));
        }

        # Insertar servicios extrar para pacientes empresas o servicios para particulares
        if (is_array($servicios)) {
            if (count($servicios) > 0) {
                # si hay algo en el arreglo lo insertamos
                foreach ($servicios as $key => $value) {
                    // print_r($servicios);
                    $response2 = $master->insertByProcedure('sp_recepcion_detalle_paciente_g', array($idTurno, null, $value));
                }
            }
        }

        $response = array_merge((array) $response, (array) $etiqueta_turno);
        break;
    case 3:
        # reagendar una cita
        $response = $master->updateByProcedure('sp_recepcion_reagendar', array($idTurno, $fecha_reagenda));
        break;
    case 4:
        # reenviar reportes e imagenes por correo de todas las areas.

        # recuperamos reportes e imagenes como arreglo unico.
        # decodificamos las imagenes para poderlas tratar como un array.
        $reportes = $master->cleanAttachFilesImage($master, $idTurno, null, 1, 1);

        # si existe algo, enviamos el correo.
        if (!empty($reportes[0])) {
            $mail = new Correo();
            $r = $mail->sendEmail("resultados", "[bimo] Resultados", [$reportes[1]], null, $reportes[0], 1);
            if ($r) {
                $master->setLog("Correo global enviado.", "[recepcion api, case 4]");
                $response = 1;
            } else {
                $master->setLog("Falla al enviar correo.", "[recepcion api, case 4]");
            }
        } else {
            $response = "Paciente sin resultados o imágenes.";
        }

        break;
    case 5:
        # Enzipar por paciente reportes e imagenes por cliente y enviarlo por correo eletronico
        $zip = new ZipArchive;
        $mail = new Correo();
        #recuperamos el los reportes y las imagenes de los pacientes del cliente seleccionado.
        $reportes = $master->cleanAttachFilesImage($master, null, null, $cliente_id, 0, $fecha_ingreso);

        if (!empty($reportes[0])) {
            #si hay algo, continuamos con el proceso.

            #creamos la carpeta temporal
            if (!is_dir("../tmp")) {
                if (!mkdir("../tmp")) {
                    $master->setLog("No se pudo crear la carpeta temporal", "recepcion api [case 5]");
                    $response = "No se pudo crear la carpeta temporal.";
                    break;
                }
            }

            # creamos el zip por cada paciente.
            for ($i = 0; $i < count($reportes[3]); $i++) {
                $nombre_zip = $explode = explode(".", $reportes[3][$i]);

                #creamos el archivo zip dentro de la carpeta temporal
                $fh = fopen("../tmp/" . $nombre_zip[0] . ".zip", 'a');
                // fwrite($fh, '<h1>Hello world!</h1>');
                fclose($fh);

                # Filtramos todos los archivos del paciente
                $str = "/" . $reportes[2][$i] . "/";
                $archivos_paciente = [];
                foreach ($reportes[0] as $ruta_archivo) {

                    $pos = strpos($ruta_archivo, $str);

                    try {
                        if ($pos !== false) {
                            array_push($archivos_paciente, $ruta_archivo);
                        }
                    } catch (Exception $e) {
                        print_r($e);
                    }
                }

                # enzipamos los archivos correspondientes al zip actual.
                foreach ($archivos_paciente as $a) {
                    $ruta = explode("nuevo_checkup", $a);
                    $ruta = ".." . $ruta[1];

                    // if ($zip->open("../tmp/".$nombre_zip[0].".zip") === TRUE) {
                    //     $zip->addFile($ruta, basename($ruta));
                    //     $zip->close();
                    // } else {
                    //     echo 'failed';
                    // }
                    if ($zip->open("../tmp/" . $nombre_zip[0] . ".zip") === TRUE) {
                        $zip->addFile("../checkup.sql", basename($ruta));
                        $zip->close();
                    } else {
                        echo 'failed';
                    }
                }
            }

            $archivos_enviar = [];


            if ($gestor = opendir('../tmp/')) {
                echo "Gestor de directorio: $gestor\n";
                echo "Entradas:\n";

                /* Esta es la forma correcta de iterar sobre el directorio. */
                $count = 0;
                while (false !== ($entrada = readdir($gestor))) {
                    if ($count > 1) {
                        array_push($archivos_enviar, "nuevo_checkup/tmp/" . $entrada);
                    }
                    $count++;
                }

                closedir($gestor);
            }
            print_r($archivos_enviar);

            $r = $mail->sendEmail("resultados", "Envio de resultados [bimo]", ["arellanox0392@gmail.com"], null, $archivos_enviar, 1);
        } else {
            $response = "No hay archivos disponible para el cliente seleccionado.";
        }

        break;
    case 6:
        # detalle del estudios cargados al paciente.
        $response = $master->getByProcedure("sp_paciente_servicios_cargados", [$idTurno, $area_id]);

        break;
    case 7:
        #Datos de beneficiario
        #========================================================================================
        ##############AGREGAR TRABAJAOR DE LA UJAT###############################################
        # insertar la ruta del pase para los pacientes de la ujat
        $dir = $master->urlComodin . $master->urlPases;
        $dir2 = $master->urlComodin . "archivos/verificaciones_ujat/";
        $r = $master->createDir($dir);
        $r2 = $master->createDir($dir2);

        $pase = $master->guardarFiles($_FILES, "pase-ujat", $dir, "PASE_$e_turno_id" . "_" . $master->getByPatientNameByTurno($master, $e_turno_id) . "_$hoy");

        $verificacion = $master->guardarFiles($_FILES, "verificacion-ujat", $dir2, "VERIFICACION_$e_turno_id" . "_" . $master->getByPatientNameByTurno($master, $e_turno_id) . "_$hoy");


        if (!empty($master->checkArray($verificacion))) {
            $url_verificacion = str_replace("../", $host, $verificacion[0]['url']);
        }

        $url_verificacion = str_replace("../", $host, $verificacion[0]['url']);

        if (!empty($pase[0]['tipo'])) {
            $url_pase = str_replace("../", $host, $pase[0]['url']);
            $r = $master->updateByProcedure("sp_actualizar_pase_empresas", [$e_turno_id, $url_pase]);
        }


        // if(isset($is_worker) && $is_worker== "on"){
        //$e_id_trabajador = is_numeric($e_id_trabajador) ? $e_id_trabajador : null;
        $e_id_trabajador = $_POST['nuevo-trabajador'] == "on" ? null : $e_id_trabajador;
        $e_genero = ($e_genero == "MASCULINO") ? 1 : 2;
        $response = $master->insertByProcedure("sp_trabajadores_empresas_g", [
            $e_id_trabajador,
            $e_nombre,
            $e_paterno,
            $e_materno,
            $e_edad,
            $e_fecha_nacimiento,
            $e_num_trabajador,
            $e_curp,
            $e_pasaporte,
            $e_extranjero,
            $e_genero,
            $e_ures,
            $e_categoria,
            $e_turno_id,
            $e_parentesco,
            $e_diagnostico,
            $e_clave_beneficiario,
            $e_medico,
            $e_cedula,
            $e_pase,
            $url_verificacion
        ]);
        // } else {
        //     $response = "nuevo-trabajador: off";
        // }
        #========================================================================================
        break;
    case 8:
        #lista de trabajadores
        #Front necesita: 
        #'ID_PACIENTE', 'CURP.PASAPORTE.NOMBRE_COMPLETO.NACIMIENTO.NUMBER_TRABAJADOR'
        #Del trabajador para enviarte la ID

        # recuperar la lista de lost trabajadores
        # Enviar el id del trabajdor para recuperar un solo registro.
        # Enviar cualquier palabra en $parametro para recuperar un set de datos
        # que coincidan con el nombre completo, categoria, num trabajador, etc.
        # Enviar solo la id del turno para recuperar la informacion del trabajador que
        # depende el beneficiario.
        $response = $master->getByProcedure("sp_trabajdores_empresas_b", [$e_id_trabajador, $parametro, $e_turno_id]);
        break;
    case 9:
        # actualizar la informacion de los trabajadores de la ujat.
        # siempre y cuando el usuario tenga el permiso.
        # Para actualizar, se necesita enviar la id del trabajdor de la ujat.
        $dir2 = $master->urlComodin . "archivos/verificaciones_ujat/";
        $r2 = $master->createDir($dir2);

        $verificacion = $master->guardarFiles($_FILES, "verificacion-ujat", $dir2, "VERIFICACION_$e_turno_id" . "_" . $master->getByPatientNameByTurno($master, $e_turno_id) . "_$hoy");

        if (!empty($verificacion)) {
            $url_verificacion = str_replace("../", $host, $verificacion[0]['url']);
        }

        $response = $master->updateByProcedure("sp_trabajadores_empresas_a", [
            $e_id_trabajador,
            $e_nombre,
            $e_paterno,
            $e_materno,
            $e_edad,
            $e_fecha_nacimiento,
            $e_num_trabajador,
            $e_curp,
            $e_pasaporte,
            $e_genero,
            $_SESSION['id'],
            isset($e_turno_id) ? $url_verificacion : null
        ]);
        break;
    case 10:
        # subir archivos del paciente.
        # como las ordenes medicas, la credencial del ine y la foto del paciente

        # subir ordenes medicas
        if (count($ordenes) > 0) {
            $dir = $master->urlComodin . $master->urlOrdenesMedicas . "$e_turno_id/";
            $r = $master->createDir($dir);
            if ($r == 1) {
                #movemos las ordenes medicas
                $return = $master->guardarFiles($_FILES, 'orden-medica-laboratorio', $dir, "ORDEN_MEDICA_LABORATORIO_$e_turno_id");
                $return2 = $master->guardarFiles($_FILES, 'orden-medica-rx', $dir, "ORDEN_MEDICA_RX_$e_turno_id");
                $return3 = $master->guardarFiles($_FILES, 'orden-medica-us', $dir, "ORDEN_MEDICA_ULTRASONIDO_$e_turno_id");

                # metemos el area al que pertenece
                $return[0]['area_id'] = 6;
                $return2[0]['area_id'] = 8;
                $return3[0]['area_id'] = 11;
                $merge = array_merge($return, $return2, $return3);

                #insertarmos las ordenes medicas en la base de datos
                foreach ($merge as $item) {
                    if (!empty($item['tipo'])) {
                        $url = str_replace("../", $host, $item['url']);
                        $responseOrden = $master->insertByProcedure('sp_ordenes_medicas_g', [null, $e_turno_id, $url, $item['tipo'], $item['area_id']]);
                    }
                }
            } else {
                $master->setLog("No se pudo crear el directorio para guardar las ordenes medicas", "recepcion_api.php [case 10]");
            }
        }

        # subir la foto del paciente
        $dir = $master->urlComodin . "archivos/perfiles_paciente/";
        $r = $master->createDir($dir);

        if ($r == 1) {
            $avatar_url = $master->guardarFiles($_FILES, 'avatar_paciente', $dir, "perfil_paciente_$e_turno_id");
            if (!empty($master->checkArray($avatar_url))) {
                $url = str_replace("../", $host, $avatar_url[0]['url']);
                $response = $master->updateByProcedure("sp_subir_archivos_turno", [$e_turno_id, $url, null]);
            }
        } else {
            $master->setLog("No se pudo crear el directorio de perfiles de paciente", "recepcion_api.php [case 10]");
        }

        # subir la credencial del ine
        $dir = $master->urlComodin . "archivos/credenciales_ine/";
        $r = $master->createDir($dir);

        if ($r == 1) {
            $ine = array();
            $ine_front = $master->guardarFiles($_FILES, 'paciente-ine-front', $dir, "ine_front_$e_turno_id");
            $url = str_replace("../", $host, $ine_front[0]['url']);
            $ine['front'] = $url;
            $ine_back = $master->guardarFiles($_FILES, 'paciente-ine-back', $dir, "ine_back_$e_turno_id");
            $url = str_replace("../", $host, $ine_back[0]['url']);
            $ine['back'] = $url;

            if (!empty($master->checkArray($ine))) {
                $response = $master->updateByProcedure("sp_subir_archivos_turno", [$e_turno_id, null, json_encode($ine)]);
            }
        } else {
            $master->setLog("No se pudo crear el directorio para las ines de los pacientes.", "recepcion_api [case 10]");
        }

        $response = 1;
        break;
    case 11:
        # recuperar todos los documentos que existen.
        $response = $master->getByProcedure("sp_recuperar_archivos_turno", [$e_turno_id]);
        $response[0]['ORDENES_MEDICAS'] = $master->decodeJson([$response[0]['ORDENES_MEDICAS']]);
        $response[0]['IDENTIFICACION'] = $master->decodeJson([$response[0]['IDENTIFICACION']]);
        break;

    case 12:
        #recuperar todos los tipops de cuestionarios
        $response = $master->getByProcedure("sp_cuestionarios_b", []);

        break;
    default:
        $response = "Api no definida.";
        break;
}

echo $master->returnApi($response);
