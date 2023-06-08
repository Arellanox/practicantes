<?php
include_once("miscelaneus.php");
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Correo
{

    function Correo()
    {
    }

    function sendLinkByEmail($email, $token)
    {
        #envia la liga con un token para permitir a los pacientes realizar el prerregistro.

        #creamos un objeto de la clase phpmailer
        $mail = new PHPMailer(true);

        #configuramos el correo de donde saldran los mensajes, la cabecer, etc
        $username = 'hola@bimo-lab.com';
        $password = 'Bimo&2022';
        $fromName = 'bimo';

        $img = 'bimo.png';
        $descripcion = 'Laboratorio de Biología Molecular';
        // $fromName = utf8_decode('Biologia Molecular | Diagnóstico Biomolecular');
        // $descripcion = 'Laboratorio de Biología Molecular';

        try {
            # server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $username;                     //SMTP username
            $mail->Password   = $password;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;

            # recipients
            $mail->setFrom($username, $fromName);
            $mail->addAddress($email);

            # content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = utf8_decode('Agende su cita en [bimo Checkups]');
            $mail->Body = '<!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                </head>
                <body>
                    <div id="contenido" style="background-color:#f6fdff">
                        <div style="overflow:auto;text-align:left;background-color:rgb(000,078,089);padding:5px;color:white">
                            <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" alt="img" style="border-radius:15px;height:55px;float:left;padding:8px" class="CToWUd a6T" data-bit="iit" tabindex="0">
                            <p style="font-size:20px">Laboratorio Biologia Molecular</p>
                        </div>
                        <div style="padding:5px 20px 15px 20px;color:black;font-size:14px;background-color:#f6fdff">
                            <h2>
                                ¡Buenas tardes!
                            </h2>
                            <p align="justify">
                                Se ha generado un nuevo token para su Pre-registro en bimo:
                            </p>
                            <p>
                                <a href="https://bimo-lab.com/nuevo_checkup/vista/registro/?token=' . $token . '" target="_blank"> Registrar aqui </a>
                            </p>
                            <!-- <p> 
                                Guarde su nuevo prefolio de identificación (<strong>("FOLIO")</strong>) para el ingreso a _bimo checkup_
                            </p> -->

                            <div style="text-align:right">
                            <p>Atentamente</p>
                            <p>Laboratorio de Biología Molecular</p>
                            </div>
                        </div>
                    </div>
                </body>
            </html>';

            # send email
            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    function sendEmail($bodySelected, $subject, $emails = array(), $token = null, $reportes = array(), $resultados = 0, $paciente = null)
    # $bodyselected indica el cuerpo que se envia en el correo.
    # $emails, direcciones de correo electronico de destino.
    # $token, se usa para enviar el link de prerregistro.
    # $reportes, todos los archivos a enviar como imagenes o los resultados de las distintas areas.
    # $resultados, indicica si lo que se envia es un resultado [enviar 1]
    {
        #creamos un objeto de la clase phpmailer
        $mail = new PHPMailer(true);
        $mis = new Miscelaneus();

        #configuramos el correo de donde saldran los mensajes, la cabecer, etc
        if ($resultados == 0) {
            $username = 'hola@bimo-lab.com';
            $password = 'X@96ck6B1V4&tm!4QZp3F';
            $fromName = 'bimo';
        } else {
            $username = 'resultados@bimo-lab.com';
            $password = 'Bimo2023!';
            $fromName = 'Resultados [bimo]';
        }


        $img = 'bimo.png';
        $descripcion = 'Laboratorio de Biología Molecular';
        // $fromName = utf8_decode('Biologia Molecular | Diagnóstico Biomolecular');
        // $descripcion = 'Laboratorio de Biología Molecular';

        try {
            # server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $username;                     //SMTP username
            $mail->Password   = $password;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;

            # recipients
            $mail->setFrom($username, $fromName);
            foreach ($emails as $email) {
                $mail->addAddress($email);
            }
            #$mail->addBCC('josue.delacruz@bimo.com.mx');
            $mail->addBCC("hola@bimo.com.mx");
            #$mail->addBCC("luis.cuevas@bimo.com.mx");
            $mail->addBCC("confirmacion_resultados@bimo-lab.com");

            # attach files
            foreach ($reportes as $file) {
                $f = explode("nuevo_checkup", $file);
                if (!$mail->addAttachment(".." . $f[1])) {
                    $mis->setLog("No se adjunto el archivo.", basename($file));
                }
            }

            # content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = utf8_decode($subject);

            switch ($bodySelected) {
                case "token":
                    $mail->Body = $this->cuerpoCorreoToken($token);
                    break;
                case "resultados":
                    $mail->Body = $this->cuerpoCorreoLaboratorio();
                    break;
                case "password":
                    $mail->Body = $this->cuerpoRecuperarPassword($token);
                    break;
                case "fastck":
                    $f = str_replace("_"," ",$paciente);
                    $mail->Body = $this->cuerpoCorreoFastCheckup($f);
                    break;
            }

            # send email
            $mail->send();

            return true;
        } catch (Exception $e) {
            $mis->setLog($e, "Clase correo [sendMail]");
            return false;
        }
    }

    private function cuerpoCorreoFastCheckup($nombre){
        $html = '<!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>bimo checkups</title>
        </head>

   <body>
        <div id="contenido" style="background-color:#f6fdff">
            <div style="overflow:auto;text-align:left;background-color:rgb(000,078,089);padding:5px;color:white">
                <img src="https://bimo-lab.com/nuevo_checkup/archivos/sistema/icono_administrativo.jpeg" alt="img"
                style="border-radius:15px;height:55px;float:left;padding:8px">
                <p style="font-size: 20px; color:white">Diagnóstico Biomolecular S.A. de C.V.</p>
            </div>
            <div style="padding:5px 20px 15px 20px;color:black;font-size:14px;background-color:#f6fdff">
                <h2>
                    ¡Hola '.$nombre.'!
                </h2>
                <p>
                    En este correo encontrarás los resultados de tu “Fast Checkup” realizado el día de hoy por bimo.
                </p>
                <p>
                    Te invitamos a que conozcas nuestros servicios de laboratorio clínico, laboratorio de biología molecular, ultrasonografía, rayos X, espirometría, audiometría, valoración visual, electrocardiograma y nutrición.
                </p>
                <p>
                    Visítanos de lunes a sábado de 07:00 a 14:30 horas. en Avenida Pagés Llergo No. 150 interior 1, Col. Arboledas, Villahermosa Tabasco C.P. 86079. Teléfonos de contacto: 9936341483, 9936340250, 9936341469. Correo electrónico: hola@bimo.com.mx
                </p>

                <div style="text-align:right">
                    <p>Atentamente</p>
                    <p>bimo<br>Checkup Clinico y Preventivo</p>
                </div>
            </div>
        </div>
    </body>
        </html>';
return $html;
    }
    private function cuerpoCorreoLaboratorio()
    {


        $html = '<!DOCTYPE html>
                    <html lang="es">

                    <head>
                        <meta charset="UTF-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>bimo checkups</title>
                    </head>

               <body>
                    <div id="contenido" style="background-color:#f6fdff">
                        <div style="overflow:auto;text-align:left;background-color:rgb(000,078,089);padding:5px;color:white">
                            <img src="https://bimo-lab.com/nuevo_checkup/archivos/sistema/icono_administrativo.jpeg" alt="img"
                            style="border-radius:15px;height:55px;float:left;padding:8px">
                            <p style="font-size: 20px; color:white">Diagnóstico Biomolecular S.A. de C.V.</p>
                        </div>
                        <div style="padding:5px 20px 15px 20px;color:black;font-size:14px;background-color:#f6fdff">
                            <h2>
                                ¡Buenas tardes!
                            </h2>
                            <p>
                                Se adjuntan resultados.
                            </p>

                            <div style="text-align:right">
                                <p>Atentamente</p>
                                <p>bimo<br>Checkup Clinico y Preventivo</p>
                            </div>
                        </div>
                    </div>
                </body>
                    </html>';
        return $html;
    }

    private function cuerpoCorreoToken($token)
    {
        $html = '<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <div id="contenido" style="background-color:#f6fdff">
                    <div style="overflow:auto;text-align:left;background-color:rgb(000,078,089);padding:5px;color:white">
                        <img src="https://bimo-lab.com/nuevo_checkup/archivos/sistema/icono_administrativo.jpeg" alt="img"
                        style="border-radius:15px;height:55px;float:left;padding:8px">
                        <p style="font-size: 20px; color:white">Diagnóstico Biomolecular S.A. de C.V.</p>
                    </div>
                    <div style="padding:5px 20px 15px 20px;color:black;font-size:14px;background-color:#f6fdff">
                        <h2>
                            ¡Buenas tardes!
                        </h2>
                        <p align="justify">
                            Se ha generado un nuevo token para su Pre-registro en bimo:
                        </p>
                        <p>
                            <a href="https://bimo-lab.com/nuevo_checkup/vista/registro/?token=' . $token . '" target="_blank"> Registrar aqui </a>
                        </p>
                        <!-- <p> 
                            Guarde su nuevo prefolio de identificación (<strong>("FOLIO")</strong>) para el ingreso a _bimo checkup_
                        </p> -->

                        <div style="text-align:right">
                        <p>Atentamente</p>
                        <p>Laboratorio de Biología Molecular</p>
                        </div>
                    </div>
                </div>
            </body>
        </html>';

        return $html;
    }

    private function cuerpoRecuperarPassword($token){

        $token = base64_encode($token);
        $html = '<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <div id="contenido" style="background-color:#f6fdff">
                    <div style="overflow:auto;text-align:left;background-color:rgb(000,078,089);padding:5px;color:white">
                        <img src="https://bimo-lab.com/nuevo_checkup/archivos/sistema/icono_administrativo.jpeg" alt="img"
                        style="border-radius:15px;height:55px;float:left;padding:8px">
                        <p style="font-size: 20px; color:white">Diagnóstico Biomolecular S.A. de C.V.</p>
                    </div>
                    <div style="padding:5px 20px 15px 20px;color:black;font-size:14px;background-color:#f6fdff">
                        <h2>
                            ¡Buenas tardes!
                        </h2>
                        <p align="justify">
                            Se ha generado un nuevo token para su Pre-registro en bimo:
                        </p>
                        <p>
                            <a href="https://bimo-lab.com/nuevo_checkup/reset-password/?token=' . $token.' target="_blank">Cambia tu password aquí</a>
                        </p>
                        <!-- <p> 
                            Guarde su nuevo prefolio de identificación (<strong>("FOLIO")</strong>) para el ingreso a _bimo checkup_
                        </p> -->

                        <div style="text-align:right">
                        <p>Atentamente</p>
                        <p>Laboratorio de Biología Molecular</p>
                        </div>
                    </div>
                </div>
            </body>
        </html>';
        return $html;
    }
}
