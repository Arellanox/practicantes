<?php
session_start();

include "rechazados.html";
include "p_aceptar.html";
include "p_rechazar.html";
include "p_reagendar.html";
include "subir-perfil.html";
include "../../../include/modal/registrar-pruebas.php";
include "../../../include/modal/registrar-paciente.php";
include "../../../include/modal/editar-paciente.php";
include "solicitud-ingreso.html";

//UJAT
include "ujat-beneficiarios.html";

//documentos
include "ine-paciente.html";
include "ordenes-medicas.html";

//Actualizar estudios
if ($_SESSION['permisos']['RepActEstudios'])
    include "p_actualizar_estudios.html";



include "p_qr-clientes.html";
