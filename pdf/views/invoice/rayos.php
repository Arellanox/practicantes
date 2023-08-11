<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">  -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">

    <style>
    @page {
        margin: 0px 10px;
    }

    body {
        font-family: 'Roboto', sans-serif;
        margin-top: 60px;
        font-size: 10px;
    }

    /* .header {
            position: fixed;
            top: -165px;
            left: 25px;
            right: 25px;
            height: 220px;
            margin-top: 0;
        } */

    .footer {
        position: fixed;
        bottom: -165px;
        left: 25px;
        right: 25px;
        /* background-color: purple; */
    }

    .footer .page:after {
        content: counter(page);
    }

    /* Saltar a nueva pagina */
    .break {
        page-break-after: always;
    }

    /* Content */
    .invoice-content {
        border-radius: 4px;
        padding-bottom: 10px;
        padding-right: 30px;
        padding-left: 30px;
        text-align: justify;
        text-justify: inter-word;
        /* background-color: purple; */
    }


    h1 {
        font-size: 22px;
        margin-top: 2px;
        margin-bottom: 2px;
    }

    h2 {
        font-size: 18px;
        margin-top: 18px;
        margin-bottom: 10px;
        text-align: center;
        background-color: rgba(215, 222, 228, 0.748);
        /* padding-top: 10px; */
    }

    h3 {
        font-size: 18px;
        margin-top: 2px;
        margin-bottom: 2px;
    }

    h4 {
        font-size: 16px;
        margin-top: 2px;
        margin-bottom: 2px;
    }

    h5 {
        font-size: 14.5px;
        margin-top: 2px;
        margin-bottom: 2px;
    }

    p {
        font-size: 15px;
    }

    strong {
        font-size: 14px;
    }

    .align-center {
        text-align: center;
    }

    table {
        width: 100%;
        max-width: 100%;
        margin: auto;
        white-space: nowrap;
        /* table-layout:fixed; */
    }

    th,
    td {
        width: 100%;
        max-width: 100%;
        word-break: break-all;
    }

    /* Para divisiones de 3 encabezado*/
    .col-left {
        width: 35%;
        max-width: 35%;
        text-align: left;
        font-size: 12px;
    }

    .col-center {
        width: 35%;
        max-width: 35%;
        text-align: left;
        font-size: 12px;
    }

    .col-right {
        width: 30%;
        max-width: 30%;
        text-align: left;
        font-size: 12px;
    }

    /* divisiones de 3 footer */
    .col-foot-one {
        width: 30%;
        max-width: 30%;
        text-align: left;
        font-size: 12px;
    }

    .col-foot-two {
        width: 40%;
        max-width: 40%;
        text-align: center;
        font-size: 12px;
    }

    .col-foot-three {
        width: 30%;
        max-width: 30%;
        text-align: right;
        font-size: 12px;
    }

    /* Para divisiones de 4 */
    .result {
        font-size: 12px
    }

    /* diviciones de 2 */
    .col-izq {
        width: 30%;
        max-width: 30%;
        text-align: left;
    }

    .col-der {
        width: 70%;
        max-width: 70%;
        text-align: center;
    }

    /* Fivisiones de cinco */
    .col-one {
        width: 30%;
        max-width: 30%;
        text-align: left;
    }

    .col-two {
        width: 20%;
        max-width: 20%;
        text-align: right;
    }

    .col-three {
        width: 25%;
        max-width: 25%;
        text-align: center;

    }

    .col-four {
        width: 25%;
        max-width: 25%;
        text-align: center;
    }
    </style>
</head>


<?php

// para el path del logo 
$ruta = file_get_contents('../pdf/public/assets/icono_reporte.png');
$encode = base64_encode($ruta);

// Para la firma se requiere mandar la "firma" tambien en base 64 e incrustarlo como en el ejemplo de arriba,
//los datos de abajo son meramente informativos y solo sirven para rellenar la informacion del documento
// echo '<img src="data:image/png;base64, '. $img_valido .'" alt="" height="75" >';

// path firma
// Verifica si mandan firma o si existe en el arreglo
if (isset($encabezado->FIRMA)) {
    $ruta_firma = file_get_contents('http://bimo-lab.com/pdf/logo/firma.png'); //AQUI DEBO RECIBIR LA RUTA DE LA FIRMA
    $encode_firma = base64_encode($ruta_firma);
} else {
    $encode_firma = null;
}

if (!isset($qr)) {
    $qr = null;
}

?>

<body>
    <!-- header -->
    <div class="header">
        <br><br>

        <table>
            <tbody>
                <tr>
                    <td class="col-der" style="border-bottom: none">
                        <h4>
                            DIAGNOSTICO BIOMOLECULAR S.A.de C.V. <br>
                            Clínica Checkup <br>
                            <?php echo $encabezado->TITULO ?>
                        </h4>
                    </td>
                    <td class="col-izq" style="border-bottom: none; text-align:center;">
                        <?php
                        echo "<img src='data:image/png;base64, " . $encode . "' height='75' >";
                        // echo "<img src='data:image/png;base64," . $barcode . "' height='75'>";
                        ?>

                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
                <tr>
                    <td style="text-align: center; border-style: solid none solid none; ">
                        <h3>
                            <?php echo $encabezado->SUBTITULO ?>
                        </h3>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
                <tr>
                    <td class="col-left" style="border-bottom: none">
                        No. Identificación: <strong> <?php echo $encabezado->FOLIO_IMAGEN; ?> </strong>
                    </td>
                    <td class="col-center" style="border-bottom: none">
                        Edad: <strong style="font-size: 12px;"> <?php echo $encabezado->EDAD; ?> años</strong>
                    </td>
                    <td class="col-right" style="border-bottom: none">
                        Sexo: <strong style="font-size: 12px;"><?php echo $encabezado->SEXO; ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td class="col-left" style="border-bottom: none">
                        Nombre: <strong style="font-size: 12px;"> <?php echo $encabezado->NOMBRE; ?> </strong>
                    </td>
                    <td class="col-center" style="border-bottom: none">
                        Fecha de Nacimiento: <strong style="font-size: 12px;"> <?php echo $encabezado->NACIMIENTO; ?>
                        </strong>
                    </td>
                    <td class="col-right" style="border-bottom: none">
                    </td>
                </tr>
                <tr>
                    <td class="col-left" style="border-bottom: none">
                        <?php echo (isset($encabezado->PASAPORTE)) ? "Pasaporte: <strong>" . $encabezado->PASAPORTE . "</strong>" : ""; ?>
                    </td>
                    <td class="col-center" style="border-bottom: none">
                        Fecha de Resultado: <strong
                            style="font-size: 12px;"><?php echo $encabezado->FECHA_RESULTADO_IMAGEN; ?> </strong>
                    </td>
                    <td class="col-right" style="border-bottom: none">
                        <!-- Tipo de Muestra: <strong>Sangre</strong> -->
                    </td>
                </tr>
                <tr>
                    <td class="col-left" style="border-bottom: none">
                        Procedencia: <strong style="font-size: 12px;"><?php echo $encabezado->PROCEDENCIA; ?> </strong>
                    </td>
                    <td class="col-center" style="border-bottom: none">
                        <?php echo isset($encabezado->MEDICO_TRATANTE) ? "Médico Tratante: <strong style='font-size: 12px;'>" . $encabezado->MEDICO_TRATANTE . "</strong>" : ""; ?>
                    </td>
                    <td class="col-right" style="border-bottom: none">
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <p>Aqui va el encabezado y es el espacio disponible hasta donde llegue el titulo siguiente.</p> -->
    </div>

    <div class="footer">
        <table class="footer-table">
            <tbody>
                <tr class="col-foot-one">
                    <td colspan="12" style="text-align: right; padding-right: 0;"><strong
                            style="font-size: 12px;">Atentamente</strong></td>
                </tr>
                <tr class="col-foot-two">
                    <td colspan="10">
                    </td>
                    <td colspan="2" style="text-align: left;">
                        <?php
                        if ($preview == 0) {
                            echo "<img style='position:absolute; right:25px; margin-top: -15px ' src='data:image/png;base64, " . $encode_firma . "' height='80px'> ";
                        }
                        ?>
                    </td>
                </tr>
                <tr class="col-foot-three" style="font-size: 100px;">
                    <td colspan="6" style="text-align: center; width: 50%">
                        <?php
                        if ($preview == 0) {
                            echo "<a target='_blank' href='#'> <img src='" . $qr[1] . "' alt='QR Code' width='110' height='110'> </a>";
                        }
                        ?>
                    </td>
                    <td colspan="6" style="text-align: right; width: 50%; padding-top: 30px; margin-bottom: -25px">
                        <strong style="font-size: 12px;">
                            <?php
                            echo $pie['datos_medicos'][0]['NOMBRE_COMPLETO'] . '<br>' . $pie['datos_medicos'][0]['UNIVERSIDAD'] . ' - ' . $pie['datos_medicos'][0]['CEDULA'];
                            $indice = 1;
                            foreach ($pie['datos_medicos'][0]['ESPECIALIDADES'] as $key => $value) {
                                // $contador = count($value);
                                $indice++;
                                echo '<br>' . $value['CARRERA'] . ' / ' . $value['UNIVERSIDAD'] . ' / '  . $value['CEDULA'] . '<br>';
                                echo 'Certificado por: ' . $value['CERTIFICADO_POR'];
                            }
                            ?>
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr style="margin-top: -20px; height: 0.5px; background-color: black ;">
        <p style="text-align: center;"><small><strong style="font-size: 12px;">Avenida José Pagés Llergo No. 150
                    Interior 1, Colonia Arboledas, Villahermosa Tabasco, C.P. 86079</strong> <br> <strong
                    style="font-size: 12px;"> Teléfonos: 993 634 0251, 993 634 1469, 993 634 1483, 993 634 1484, 993 634
                    0245, 993 634 0246; </strong> <strong style="font-size: 12px;">Correo electrónico:</strong> <strong
                    style="font-size: 12px;">hola@bimo.com.mx</strong></small></p>
    </div>

    <!-- body -->
    <div class="invoice-content">
        <?php
        $count = 0;
        foreach ($resultados->ESTUDIOS as $key => $resultado) {
            echo "<h2 style='padding-bottom: 8px; padding-top: 8px;'>" . $resultado->ESTUDIO . "</h2>";
            echo "<h4 style='line-height: 1.5: padding-top: 20px;'>Hallazgos</h4>";
            echo "<p style='line-height: 1.5'>" . $resultado->HALLAZGO . "</p>";
            echo "<p style='line-height: 1.5'>" . $resultado->TECNICA . "</p>";
            echo "<p style='line-height: 1.5'><strong>Interpretación: </strong>" . $resultado->INTERPRETACION . "<br>";
            if ($resultado->COMENTARIO != "" || $resultado->COMENTARIO != null) {
                echo "<strong>Comentario: </strong>" . $resultado->COMENTARIO . "</p>";
            }
            $count++;
            if ($count % 2 == 0) {
        ?>
        <!-- <div class="break"></div> -->
        <?php
            }
        }
        ?>

        <div class="break"></div>
        <h2 style="padding-bottom: 8px; padding-top:8px">Estos son los resultados</h2>
        <?php
        $jsonData = $resultados->IMAGENES;

        $uniqueUrls = []; // Array para rastrear las URLs únicas

        foreach ($jsonData as $conjunto) {
            foreach ($conjunto as $captura) {
                $url = $captura->CAPTURAS[0][0]->url;

                if (!in_array($url, $uniqueUrls)) {
                    $uniqueUrls[] = $url;
                }
            }
        }

        // Ahora puedes mostrar las imágenes directamente en la página web
        foreach ($uniqueUrls as $url) {
            echo "<div style='text-align: center; margin-bottom: 20px;'><img style='width: 25%;' src='$url' alt='Imagen'></div>";
        }
        ?>
    </div>
</body>
<?php
$altura = 200;

for ($i = 2; $i < $indice; $i++) {
    $altura = $altura + 50;
}
?>
<style>
.footer {
    position: fixed;
    bottom: 50px;
    left: 25px;
    right: 25px;
    height: <?php echo $altura . 'px'?>;
    /* background-color: pink; */
}
</style>

</html>