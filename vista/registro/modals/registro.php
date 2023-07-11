<?php
// include "registrar-paciente.php";
// include "registrar-pruebas.php";
// include "consultar-resultado.php";
$language = isset($_POST['language']) ? $_POST['language'] : '';

// echo "../../include/modal/registrar-pruebas$language.php";

include "../../include/modal/registrar-pruebas$language.php";
include "../../include/modal/registrar-paciente$language.php";
