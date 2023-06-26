<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultorio 2</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">  -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 10px;
        }

        .header {
            position: fixed;
            top: -165px;
            left: 25px;
            right: 25px;
            height: 220px;
            margin-top: 0;
            /* background-color: cadetblue; */
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
        }


        h1 {
            font-size: 22px;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        h2 {
            font-size: 15px;
            margin-top: 18px;
            /* margin-bottom: 10px; */
            text-align: center;
            background-color: rgba(215, 222, 228, 0.748);
            /* padding-top: 10px; */
        }

        h3 {
            font-size: 16px;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        h4 {
            font-size: 14px;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        h5 {
            font-size: 12.5px;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        p {
            font-size: 12px;
        }

        strong {
            font-size: 12px;
        }

        .align-center {
            text-align: center;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin: auto;
            white-space: normal;
            word-break: break-all;
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
            width: 42%;
            max-width: 42%;
            text-align: left;
            font-size: 11px;
            margin-left: 2px;
        }

        .col-center {
            width: 41%;
            max-width: 41%;
            text-align: left;
            font-size: 11px;
            margin-left: 2px;
        }

        .col-right {
            width: 17%;
            max-width: 17%;
            text-align: left;
            font-size: 11px;
            margin-left: 2px;
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

        body {
            font-size: 11px;
        }

        .cuartos {
            width: 25%;
        }

        .venticinco {
            width: 25%;
        }

        .setentaycinco {
            width: 75%;
        }

        .footer {
            position: fixed;
            bottom: -40px;
            left: 0px;
            right: 0px;
        }

        .bold {
            font-weight: bold;
        }

        .cursive {
            font-style: italic;
        }

        .content {
            border-radius: 3px;
            background-color: #f7be16;
        }

        .rojo {
            color: red;
        }

        .verde {
            color: greenyellow;
        }
    </style>
</head>

<?php
// para el path del logo 
$ruta = file_get_contents('../pdf/public/assets/icono_reporte_checkup.png');
$encode = base64_encode($ruta);

// Para la firma se requiere mandar la "firma" tambien en base 64 e incrustarlo como en el ejemplo de arriba,
//los datos de abajo son meramente informativos y solo sirven para rellenar la informacion del documento
// echo '<img src="data:image/png;base64, '. $img_valido .'" alt="" height="75" >';

// path firma
// Verifica si mandan firma o si existe en el arreglo
if (isset($pie['datos_medicos'][0]['FIRMA_URL'])) {
    $ruta_firma = file_get_contents($pie['datos_medicos'][0]['FIRMA_URL']); //AQUI DEBO RECIBIR LA RUTA DE LA FIRMA
    $encode_firma = base64_encode($ruta_firma);
} else {
    $ruta_firma = file_get_contents('../pdf/public/assets/firma_beatriz.png'); //AQUI DEBO RECIBIR LA RUTA DE LA FIRMA
    $encode_firma = base64_encode($ruta_firma); #IMPORTANTE RECIBIRLO 
}
// $ruta_firma = file_get_contents('http://bimo-lab.com/pdf/logo/firma.png'); //AQUI DEBO RECIBIR LA RUTA DE LA FIRMA

if (!isset($qr)) {
    $qr = null;
}

?>

<body>
    <div class="container-fluid">
        <br><br>
        <table>
            <tbody>
                <tr>
                    <td class="col-der" style="border-bottom: none">
                        <h4>
                            DIAGNOSTICO BIOMOLECULAR S.A.de C.V. <br>
                            Checkup Clínica y Prevención<br>
                            Reporte de Somatometría
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
        <hr style="height: 1px; background-color: black ;">
        <p style="text-align: center; margin: -4px; font-size: 16px;"><strong>DATOS DEL PACIENTE</strong></p>
        <hr style="height: 1px; background-color: black ;">
        <br>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td class="col-left" style="border-bottom: none">
                        No. Identificación: <strong style="font-size: 12px;"> <?php echo $encabezado->FOLIO_SOMA ?> </strong>
                    </td>
                    <td class="col-center" style="border-bottom: none">
                        Edad: <strong style="font-size: 12px;"> <?php echo $encabezado->EDAD < 1 ? ($encabezado->EDAD * 10) . " meses" : $encabezado->EDAD . " años"; ?></strong>
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
                        Fecha de Nacimiento: <strong style="font-size: 12px;"> <?php echo $encabezado->NACIMIENTO; ?> </strong>
                    </td>
                    <td class="col-right" style="border-bottom: none">
                        Pasaporte: <strong style='font-size:12px'> <?php echo (isset($encabezado->PASAPORTE) && !empty($encabezado->PASAPORTE)) ? $encabezado->PASAPORTE : "SD"; ?>
                    </td>
                </tr>
                <tr>
                    <td class="col-left" style="border-bottom: none">
                        Fecha de Resultado: <strong style="font-size: 12px;"> <?php echo $encabezado->FECHA_RESULTADO_MESO; ?> </strong>
                    </td>
                    <td class="col-center" style="border-bottom: none">
                    </td>
                    <td class="col-right" style="border-bottom: none">
                        <!-- Tipo de Muestra: <strong>Sangre</strong> -->
                    </td>
                </tr>
                <tr>
                    <td class="col-left" style="border-bottom: none">
                        <!-- Procedencia -->
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="font-size: 12px; padding-left: 3.5px; margin: -1px;">
            <?php echo "Procedencia: <strong style='font-size: 12px;'> $encabezado->PROCEDENCIA"; ?> </strong>
        </p>
        <p style="font-size: 12px; padding-left: 3.5px; margin: -1px; margin-top: 5px">
            <?php echo (isset($encabezado->MEDICO_TRATANTE) || !empty($encabezado->MEDICO_TRATANTE)) ? "Médico Tratante: <strong style='font-size: 10px;'>" . $encabezado->MEDICO_TRATANTE . "</strong>" : ""; ?> </strong>
        </p>
        <!-- <p style="background-color: darkgrey; padding: 5px;text-align: center;"><strong>INFORMACIÓN CLÍNICA</strong></p> -->
        <br>
    </div>

    <!-- body -->
    <div class="invoice-content row">
        <section id="card-nota-consulta" class="card mt-3">
            <h4 class="m-3">Nota de consulta</h4>
            <p><?php echo $resultados[0][0]->NOTAS_CONSULTA; ?></p>
            <hr class="dropdown-divider m-2"><br>
        </section>

        <section id="card-exploracion-clinica" class="card mt-3">
            <h4 class="m-3">Exploración física</h4>
            <hr class="dropdown-divider m-2">

            <div class="row" style="margin:0">
                <div id="notas-historial-consultorio" class="mt-3">
                    <h8><b>Listado de las exploraciones físicas</b></h8>

                    <?php
                    for ($i = 0; $i < count($resultados[1]); $i++) {
                        echo '<p>Tipo de exploración: ' . $resultados[1][$i]->TIPO_EXPLORACION . '</p>';
                        echo '<p>Exploración: ' . $resultados[1][$i]->EXPLORACION . '</p>';
                        echo '<hr class="dropdown-divider m-2">';
                    }
                    ?>
                </div>

            </div>
        </section>

        <section id="card-diagnostico" class="card mt-3">
            <h4 class="m-3">Diagnóstico</h4>
            <hr class="dropdown-divider m-2">

            <div class="row">
                <div class="col-6 p-4">
                    <p><?php echo $resultados[0][0]->DIAGNOSTICO ?></p>
                    <hr class="dropdown-divider m-2">
                </div>
                <div class="col-6">
                    <p><b>Lista de Diagnosticos secundarios:</b></p>
                    <?php
                    for ($i = 0; $i < count($resultados[0]); $i++) {
                        echo '<p>' . $resultados[0][$i]->DIAGNOSTICO2 . '</p>';
                    }
                    ?>
                </div>

                <hr class="dropdown-divider m-2">
            </div>
        </section>

        <section id="card-solicitud-estudios" class="card mt-3">
            <h4 class="m-3">Solicitud de estudios</h4>
            <hr class="dropdown-divider m-2">
            <div class="row m-2">
                <div class="col-8">
                    <p>Lista de estudios solicitados</p>
                </div>
                <hr class="dropdown-divider m-2">
            </div>
        </section>


        <section id="card-receta" class="card mt-3">
            <h4 class="m-3">Receta</h4>
            <hr class="dropdown-divider m-2">
            <div id="recetas-medicamentos">
                <div class="row">
                    <div class="col-4">
                        <p>Lista de medicamentos Guardados</p>
                    </div>
                </div>
                <hr class="dropdown-divider m-2">
            </div>
        </section>

        <section id="card-plan-tratamiento" class="card mt-3">
            <h4 class="m-3">Plan de Tratamiento</h4>
            <p><?php echo $resultados[0][0]->PLAN_TRATAMIENTO; ?></p>
            <hr class="dropdown-divider m-2">
        </section>

    </div>


    <div style="padding-top: 150px;">
        <div class="">
            <?php
            $footerDoctor = 'Dra. BEATRIZ ALEJANDRA RAMOS GONZÁLEZ <br>UJAT - Cédula profesional: 7796595';

            include 'includes/footer.php';
            ?>
        </div>
    </div>
</body>

<?php
$altura = 200;

?>
<style>
    .footer {
        position: fixed;
        bottom: -165px;
        left: 25px;
        right: 25px;
        height: 200px
    }
</style>

</html>