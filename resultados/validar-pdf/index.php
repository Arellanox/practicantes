<?php
include '../../vista/variables.php';
// include '../../clases/master_class.php';
date_default_timezone_set('America/Mexico_City');
session_start();
session_unset();
session_destroy();

$clave = $_GET['clave'];
$modulo = $_GET['modulo'];
$id = $_GET['id']; // folio
// $explode = preg_split("/(\d+)/", $id, -1, PREG_SPLIT_DELIM_CAPTURE);
// $folio_etiqueta = $explode[0];
// $folio_numero = $explode[1];

// $master = new Master();


?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
<!-- recibes queo nada -->

<head>
    <?php include "../../vista/include/head.php"; ?>
    <title>Resultados | Bimo</title>
</head>

<body class="" id="body-controlador">
    <header id="header-js">
        <nav class="navbar border-3 border-bottom border-dark bg-navbar">
            <div class="container-fluid d-flex justify-content-center">
                <a href="#" class="navbar-brand" id="img"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa_login" /> </a>
            </div>
        </nav>
    </header>
    <div id="titulo-js"> <!-- SIN TITULO --></div>
    <div class="container-fluid " id="body-js">
        <!-- BODY -->
        <div class="card m-3 p-3">
            <!-- informacion paciente -->
            <h3>Información personal</h3>
            <div class="row">
                <div class="col-12 col-md-auto d-flex justify-content-center">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="perfil" class="imagen-perfil" style="width:150px !Important">
                </div>
                <div class="col-auto col-md-6 info-detalle">
                    <div class="row">
                        <div class="col-12">
                            <p id="nombre-persona"> Luis Gerardo Cuevas González</p>
                            <p class="none-p"> <strong id="edad-persona" class="none-p">22</strong> años | <strong id="nacimiento-persona" class="none-p">22/06/2000</strong> </p>
                        </div>
                        <div class="col-12 row">
                            <div class="col-6 col-md-12 col-lg-auto">
                                <p class="info-detalle-p" id="nacimiento-paciente-consulta">Procedencia: <span class="span-info-paci">bimo</span></p>
                            </div>
                            <div class="col-6 col-md-12 col-lg-auto">
                                <p class="info-detalle-p" id="edad-paciente-consulta">Diagnóstico: <span class="span-info-paci">COVID</span></p>
                            </div>
                            <div class="col-6 col-md-12 col-lg-auto">
                                <p class="info-detalle-p" id="genero-paciente-consulta">Telefono: <span class="span-info-paci">9934305006</span> </p>
                            </div>
                            <div class="col-6 col-md-12 col-lg-auto">
                                <p class="info-detalle-p" id="curp-paciente-consulta">Prefolio: <span class="span-info-paci">202341LGG014</span> </p>
                            </div>
                            <div class="col-6 col-md-12 col-lg-auto">
                                <p class="info-detalle-p" id="correo-paciente-consulta">Correo: <span class="span-info-paci">luis.cuevas@bimo.com.mx</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <p>Pagina en mantenimiento :)</p>
            <p>Vuelva pronto para validar sus resultados correctamente.</p> -->
            </div>
        </div>

        <div class="card m-3 p-3">

            <!-- Laboratorio -->
            <section>
                <h4>Resultados | Laboratorio Clínico</h4>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p class="info-detalle-p" id="fecha_muestra-resultado">Fecha de Toma de Muestra / Collected: <span class="span-info-paci">27/06/2023</span></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="info-detalle-p" id="fecha_muestra-resultado">Fecha de Resultado / Reported: <span class="span-info-paci">27/06/2023</span></p>
                    </div>
                </div>
            </section>

        </div>

    </div>


    </div>
</body>
<style>
    .span-info-paci {
        font-weight: 400px !important;
    }
</style>

</html>