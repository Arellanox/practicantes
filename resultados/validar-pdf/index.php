<?php

// include_once '../../vista/variables.php';



date_default_timezone_set('America/Mexico_City');
session_start();
session_unset();
session_destroy();


$clave = isset($_GET['clave']) ? $_GET['clave'] : null;
$area = isset($_GET['modulo']) ?  $_GET['modulo'] : null;

// folio
// $explode = preg_split("/(\d+)/", $id, -1, PREG_SPLIT_DELIM_CAPTURE);
// $folio_etiqueta = $explode[0];
// $folio_numero = $explode[1];
// $master = new Master();

$url1 = "http://localhost/practicantes/api/qr_api.php";
// Los datos de enviados
$datos = [
    "api" => 1,
    "clave" => $clave,
    "area" => $area,
];

// Crear opciones de la petición HTTP
$opciones = array(
    "http" => array(
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($datos), # Agregar el contenido definido antes
    ),
);
# Preparar petición
$contexto = stream_context_create($opciones);
# Hacerla
$json = file_get_contents($url1, false, $contexto);

$res = json_decode($json, true);



$array = $res['response']['data'][0];
// echo '<pre>';
// var_dump($array);
// echo '</pre>';

// $msj_error = $array[0];
// var_dump($clave, $area, $array);
$code = $res['response']['code'];
$msj = $res['response']['msj'];


$http = 'http://';
$url = 'localhost';
$appname = 'practicantes';

$modulo = $area;


#Array de Somatometria
$soma = $array['INFO'];
$soma = json_decode($soma, true);

// foreach ($soma as $key => $value) {
//     echo '<pre>';
//     var_dump($value);
//     echo '</pre>';
// }

// echo '<pre>';
// var_dump($array[0]);

// echo '</pre>';


function ifnull($variable, $msj = "N/A")
{
    if ($variable == '') {
        return $msj;
    } else {
        return $variable;
    }
}


// Obtener solo la extensión
$extension = ifnull($array['EXTENSION']);
$ruta_reporte = ifnull($array['RUTA_REPORTE']);
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">

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
    <div class="container-fluid " id="body-js" style='display:none;'>
        <!-- BODY -->
        <div class="card m-3 p-3">
            <!-- informacion paciente -->
            <h3 class="" style="font-size: 20px; font-weight: bold; margin-bottom: 15px;">Información personal</h3>
            <div class="row">
                <div class="col-12 col-md-auto d-flex justify-content-center">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="perfil" class="imagen-perfil" style="width:150px !Important">
                </div>
                <div class="col-auto col-md-6 info-detalle">
                    <div class="row">
                        <div class="col-12">
                            <p class="" id="nombre-persona"> <?php echo ifnull($array['NOMBRE']) ?></p>
                            <p class="none-p "> <strong id="edad-persona" class="none-p"><?php echo ifnull($array['EDAD']) ?></strong> años | <strong id="nacimiento-persona" class="none-p"><?php echo ifnull($array['NACIMIENTO']) ?></strong> </p>
                        </div>

                        <div class="col-12 row mt-3">
                            <div class="col-12 col-md-12 col-lg-auto">
                                <p class="none-p" id="nacimiento-paciente-consulta">Procedencia:</p>
                                <p class="info-detalle-p"><?php echo ifnull($array['PROCEDENCIA']) ?></p>
                            </div>
                            <div class="col-12 col-md-12 col-lg-auto">
                                <p class="none-p" id="edad-paciente-consulta">Diagnóstico:</p>
                                <p class='info-detalle-p'>
                                    <?php echo ifnull($array['DIAGNOSTICO']) ?></p>
                            </div>
                            <div class="col-12 col-md-12 col-lg-auto">
                                <p class="none-p" id="genero-paciente-consulta">Teléfono:</p>
                                <p class='info-detalle-p'>
                                    <?php echo ifnull($array['CELULAR']) ?> </p>
                            </div>
                            <div class="col-12 col-md-12 col-lg-auto">
                                <p class="none-p" id="correo-paciente-consulta">Correo:</p>
                                <p class='info-detalle-p'>
                                    <?php echo ifnull($array['CORREO']) ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <p>Pagina en mantenimiento :)</p>
            <p>Vuelva pronto para validar sus resultados correctamente.</p> -->
            </div>
        </div>

        <div class="card m-3 p-3">
            <section>
                <div class='row'>
                    <div class="col-12 col-md-6 d-flex align-self-center my-auto">
                        <h4 class="" style="font-size: 20px; font-weight: bold;">Resultados | <?php echo ifnull($array['NOMBRE_AREA']) ?></h4>
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        <button id="ReportePDF" data-url="<?php echo ifnull($array['RUTA_REPORTE']) ?>" class="btn btn-borrar ">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Descargar
                        </button>
                    </div>
                </div>
                <hr>
                <?php
                switch ($modulo) {
                    case 6: ?>
                        <!-- Laboratorio Clinico -->
                        <div id="6" style="display: none;" class="row mt-3">
                            <div class="col-12 col-lg-3">
                                <div class="row">
                                    <div class="col-12  text-center mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Fecha de Toma de Muestra / Collected:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['FECHA_TOMA_MUESTRA']) ?></span></p>
                                    </div>

                                    <div class="col-12  text-center mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Fecha de Resultado / Reported:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['FECHA_RESULTADO']) ?></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-9 overflow-auto" style="max-height:65vh;">
                                <div id="adobe-dc-view" class="border" width='100%'></div>
                            </div>
                        </div>
                    <?php break;
                    case 8:
                    case 11: ?>
                        <!-- Rayos X y Ultrasonido -->
                        <div id="8" style="display:none;">

                            <?php
                            $capturaID = 0;
                            foreach ($array['info'] as $key => $value) {
                                foreach ($array['info'][$key] as $key2 => $value2) { ?>
                                    <hr>
                                    <div class="row">
                                        <p> <?php echo ifnull($value2['SERVICIO']) ?> </p>

                                        <!-- Texto -->
                                        <div class='col-12 col-lg-6 mb-3 '>
                                            <div class="">
                                                <p class="none-p" id="nacimiento-paciente-consulta">Técnica:</p>
                                                <p class="info-detalle-p"><?php echo ifnull($value2['TECNICA']) ?></p>
                                            </div>
                                            <div class="">
                                                <p class="none-p" id="nacimiento-paciente-consulta">Hallazgo:</p>
                                                <p class="info-detalle-p"><?php echo ifnull($value2['HALLAZGO']) ?></p>
                                            </div>
                                            <div class="">
                                                <p class="none-p" id="nacimiento-paciente-consulta">COMENTARIO:</p>
                                                <p class="info-detalle-p"><?php echo ifnull($value2['COMENTARIO']) ?></p>
                                            </div>

                                        </div>

                                        <!-- Imagenes -->
                                        <div class="col-12 col-lg-6 mb-3 d-sm-block d-md-block d-lg-none d-xl-none d-xxl-none ">
                                            <div class=" image-row">
                                                <div class="row">

                                                    <?php foreach ($value2['CAPTURAS'] as $key3 => $value3) { ?>

                                                        <div class="col-6">
                                                            <img src="<?php echo $value3['url'] ?>" class="mb-3 rounded-2 img-fluid" alt="">
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-6 mb-3">
                                            <div class="image-row">
                                                <?php
                                                echo generateCarousel($value2['CAPTURAS'], $capturaID);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                    $capturaID++;
                                }
                            }
                            ?>

                        </div>
                    <?php break;
                    case 3: ?>
                        <!-- Oftalmologia -->
                        <div class="row mt-3" id="3" style="display: none;">
                            <div class="col-12 col-lg-3">
                                <div class="row">
                                    <div class="col-12  mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Diagnóstico:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['DIAGNOSTICO_OFTALMOLOGIA']) ?></span></p>
                                    </div>
                                    <div class="col-12  mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Plan / Plan:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['PLAN']) ?></span></p>
                                    </div>
                                    <div class="col-12  mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Fecha de Resultado / Reported:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['FECHA_RESULTADO']) ?></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-9 overflow-auto" style="max-height:65vh;">
                                <div id="adobe-dc-view" class="border" width='100%'></div>
                            </div>
                        </div>
                    <?php break;
                    case 5: ?>
                        <!-- ESPIROMETRIA -->
                        <div class="row mt-3" id="5" style="display: none;">
                            <div class="col-12 col-lg-3 mb-4">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="none-p" style="font-size: 16px; ">Fecha de Resultado / Reported:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['FECHA_RESULTADO']) ?></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-9 overflow-auto" style="max-height:65vh;">
                                <div id="adobe-dc-view" class="border" width='100%'></div>
                            </div>
                        </div>
                    <?php break;
                    case 4: ?>
                        <!-- AUDIOMETRIA -->
                        <div class="row mt-3" id="4" style="display: none;">
                            <div class="col-12 col-lg-3  mb-4">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="none-p" style="font-size: 16px; ">Fecha de Resultado / Reported:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['FECHA_RESULTADO']) ?></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-9 overflow-auto" style="max-height:65vh;">
                                <div id="adobe-dc-view" class="border" width='100%'></div>
                            </div>
                        </div>
                    <?php break;
                    case 2: ?>
                        <!-- SOMATOMETRIA -->
                        <div class="row mt-3 resultados-soma" id="2" style="display: none;">
                            <div class='col-12 col-md-4 overflow-auto' style="max-height: 80vh">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Fecha de Resultado / Reported:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['FECHA_RESULTADO']) ?></span></p>
                                    </div>
                                    <?php
                                    foreach ($soma as $key => $value7) { ?>
                                        <hr>
                                        <p><?php echo ifnull($value7['DESCRIPCION']) ?></p>
                                        <div class="col-12 mb-4">
                                            <p class="none-p" style="font-size: 16px; ">VALOR: <span class="span-info-paci info-detalle-p fw-bold" style="font-size: 18px;"><?php echo ifnull($value7['VALOR']) ?><?php echo ifnull($value7['UNIDAD_MEDIDA']) ?></span> </p>
                                            <p></p>
                                        </div>
                                        <!-- <div class="col-12 col-lg-6  mb-4">
                                            <p class="none-p" style="font-size: 16px; ">UM:</p>
                                            <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php # echo ifnull($value7['UNIDAD_MEDIDA']) 
                                                                                                                                    ?></span></p>
                                        </div> -->

                                    <?php } ?>
                                </div>
                                <hr>
                            </div>

                            <div class="col-12 col-md-8 overflow-auto" style="max-height: 80vh;">
                                <div id="adobe-dc-view" class="border" width='100%'></div>
                            </div>

                        </div>
                    <?php break;
                    case 1: ?>
                        <!-- CONSULTORIO 1 -->
                        <div class="row mt-3" id="1" style="display: none;">
                            <div class='col-12 col-md-4 overflow-auto' style="max-height: 80vh">
                                <div class="row mt-3">
                                    <div class="col-12 mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Conclusiones / Diagnóstico:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['CONCLUSIONES']) ?></span></p>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Fecha de Resultado / Reported:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['FECHA_RESULTADO']) ?></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-8 overflow-auto" style="max-height: 80vh;">
                                <div id="adobe-dc-view" class="border" width='100%'></div>
                            </div>
                        </div>
                    <?php break;
                    case 19: ?>
                        <!-- CONSULTORIO 2 -->
                        <div class="row mt-3" id="19" style="display: none;">
                            <div class='col-12 col-md-4 overflow-auto' style="max-height: 80vh">
                                <div class="row mt-3">
                                    <div class="col-12 mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Conclusiones / Diagnóstico:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['DIAGNOSTICO_CON2']) ?></span></p>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <p class="none-p" style="font-size: 16px; ">Fecha de Resultado / Reported:</p>
                                        <p class="info-detalle-p fw-bold" style="font-size: 18px;"><span class="span-info-paci"><?php echo ifnull($array['FECHA_RESULTADO']) ?></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-8 overflow-auto" style="max-height: 80vh;">
                                <div id="adobe-dc-view" class="border" width='100%'></div>
                            </div>
                        </div>
                <?php break;
                    default:
                        echo `No se hay ningun resultado para mostrar`;
                        break;
                }
                ?>
            </section>
        </div>
    </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" onclick="this.style.display='none'">
        <img id="lightbox-img" src="" alt="">
    </div>


    <script type="text/javascript">
        document.addEventListener("adobe_dc_view_sdk.ready", function() {
            var adobeDCView = new AdobeDC.View({
                clientId: "34a82f04f8804b4cbdc2cd6bc6a17c57",
                divId: "adobe-dc-view"
            });
            adobeDCView.previewFile({
                content: {
                    location: {
                        url: "<?php echo $ruta_reporte; ?>"
                    }
                },
                metaData: {
                    fileName: "Summary.pdf"
                }
            }, {
                embedMode: "IN_LINE",
                showDownloadPDF: false
            });
        });
    </script>

    <script>
        // Selecciona todas las imágenes
        var images = document.querySelectorAll('.image-row img');
        var lightbox = document.getElementById('lightbox');
        var lightboxImg = document.getElementById('lightbox-img');

        // Añade un evento de click a cada imagen
        images.forEach(function(img) {
            img.addEventListener('click', function(e) {
                lightboxImg.src = e.target.src; // Cambia la imagen del lightbox
                lightbox.style.display = 'flex'; // Muestra el lightbox
            });
        });
    </script>

    <script>
        modulo = `<?php echo $modulo ?>`;
        clave = `<?php echo $clave ?>`;
        code = parseInt(`<?php echo $code ?>`)
        msj_error = `<?php echo "error: $msj" ?>`
        // console.log(code)
        // console.log(msj_error)
        $(document).ready(function() {
            if (code == 2) {
                ClearBody(msj_error)
            } else if (code !== 2) {
                switch (parseInt(modulo)) {
                    case 11:
                        // Ultrasonido
                        fade(8, 'In');
                        break;
                    case 8:
                        // Rayos X
                        fade(modulo, 'In');
                        break;
                    case 6:
                        // Laboratorio Clinico
                        fade(modulo, 'In');
                        break;
                    case 3:
                        // Oftalmologia
                        fade(modulo, 'In');
                        break;
                    case 5:
                        // ESPIROMETRIA
                        fade(modulo, 'In');
                        break;
                    case 4:
                        // AUDIOMETRIAS
                        fade(modulo, 'In');
                        break;
                    case 2:
                        // SOMATOMETRIA
                        fade(modulo, 'In');
                        break;
                    case 1:
                        // CONSULTORIO 1 
                        fade(modulo, 'In')
                        break;
                    case 19:
                        // CONSULTORIO 2 
                        fade(modulo, 'In')
                        break;
                    default:
                        ClearBody(msj_eror)
                        break;
                }
            }
        })

        function fade(modulo, type) {
            if (type == 'In') {
                $('#body-js').fadeIn(0);
                $(`#${modulo}`).fadeIn(0)
            } else if (type == 'Out') {
                $(`#${modulo}`).fadeOut(0)
            }
        }

        function DownloadFromUrl(fileURL, fileName) {
            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                    const urlBlob = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = urlBlob;
                    a.download = fileName;
                    a.click();
                    URL.revokeObjectURL(urlBlob);
                })
                .catch(error => alertMsj({
                    title: 'No se pudo descargar el PDF',
                    text: 'La ruta del PDF esta dañada, contacte con el soporte de BIMO para apoyarlo con este problema',
                    footer: `error: ${error}`,
                    icon: 'error',
                    showCancelButton: false
                }))
        }

        function ClearBody(msj_error) {
            $('#body-js').html('');

            alertMsj({
                title: 'QR Invalido',
                text: 'El código escaneado está dañado o no es correcto, contacte con el soporte de BIMO para apoyarlo con este problema',
                footer: msj_error,
                icon: 'error',
                showCancelButton: false,
                allowOutsideClick: true
            })
        }


        function alertMsj(options, callback = function() {}) {

            if (!options.hasOwnProperty('title'))
                options['title'] = "¿Desea realizar esta acción?"

            if (!options.hasOwnProperty('text'))
                options['text'] = "Probablemente no podrá revertirlo"

            if (!options.hasOwnProperty('icon'))
                options['icon'] = 'warning'

            if (!options.hasOwnProperty('showCancelButton'))
                options['showCancelButton'] = true

            if (!options.hasOwnProperty('confirmButtonColor'))
                options['confirmButtonColor'] = '#3085d6'

            if (!options.hasOwnProperty('cancelButtonColor'))
                options['cancelButtonColor'] = '#d33'

            if (!options.hasOwnProperty('confirmButtonText'))
                options['confirmButtonText'] = 'Aceptar'

            if (!options.hasOwnProperty('cancelButtonText'))
                options['cancelButtonText'] = 'Cancelar'

            if (!options.hasOwnProperty('allowOutsideClick'))
                options['allowOutsideClick'] = false
            // if (!options.hasOwnProperty('timer'))
            //   options['timer'] = 4000
            // if (!options.hasOwnProperty('timerProgressBar'))
            //   options['timerProgressBar'] = true
            //
            Swal.fire(options).then((result) => {
                callback(result);
            })
        }

        $(document).on('click', '#ReportePDF', function(e) {
            url = $(this).attr('data-url');
            DownloadFromUrl(url, `document.<?php echo $extension ?>`)
        });
    </script>
</body>
<style>
    .image-row img {
        width: 100%;
        /* max-width: 50%; */
        /* max-height: 87px; */
        max-width: 100%;
        cursor: pointer;
    }

    /* Estilos para el lightbox */
    #lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2 !important;
    }

    #lightbox img {
        max-width: 90%;
        max-height: 90%;
    }

    .span-info-paci {
        font-weight: 400px !important;
    }



    @media (min-width: "480px") {
        .resultados-soma {
            max-height: 80vh;
        }
    }
</style>
<?php
function generateCarousel($capturas,   $capturasID)
{

    $html = '<div class="d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">' .
        '<div id="CapturasImagen' . $capturasID . '" class="carousel slide">' .
        '<div class="carousel-indicators">';

    $current = '';
    foreach ($capturas as $key => $element) {
        if ($key == 0) {
            $current = 'class="active" aria-current="true"';
        } else {
            $current = '';
        }
        $html .= '<button type="button" data-bs-target="#CapturasImagen' . $capturasID . '" data-bs-slide-to="' . $key . '" ' . $current . ' aria-label="Slide ' . ($key + 1) . '"></button>';
    }
    $html .= '</div>' .
        '<div class="carousel-inner">';
    $active = '';

    foreach ($capturas as $key => $element) {
        if ($key == 0) {
            $active = 'active';
        } else {
            $active = '';
        }
        $html .= '<div class="carousel-item ' . $active . '"><img src="' . $element['url'] . '" class="d-block w-100" alt="img" data-enlargable></div>';
    }

    $html .= '</div>' .
        '<button class="carousel-control-prev" type="button" data-bs-target="#CapturasImagen' . $capturasID . '" data-bs-slide="prev">' .
        '<span class="carousel-control-prev-icon" aria-hidden="true"></span>' .
        '<span class="visually-hidden">Previous</span>' .
        '</button>' .
        '<button class="carousel-control-next" type="button" data-bs-target="#CapturasImagen' . $capturasID . '" data-bs-slide="next">' .
        '<span class="carousel-control-next-icon" aria-hidden="true"></span>' .
        '<span class="visually-hidden">Next</span>' .
        '</button>' .
        '</div> </div>';
    return $html;
}
?>


<!-- Carrousel de ultra y rayos X| -->
<style>
    .carousel-control-prev,
    .carousel-control-next {
        opacity: 1 !important;
    }


    .carousel-control-next-icon,
    .carousel-control-prev-icon,
    .carousel-indicators button {
        position: relative;

        filter: drop-shadow(0px 0 4px rgba(0, 0, 0, 1)) sepia(65%) saturate(100%) hue-rotate(192deg) !important;
    }


    /* .carousel-control-next-icon::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
        z-index: -1;
    } */
</style>

</html>