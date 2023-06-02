<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Somatometría y Signos Vitales</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">  -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <title>Somatometria</title>

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


    <div>
        <table style="width: 100%; border-collapse: collapse; text-align: center;">
            <tr style="background-color: #d8e0e2;" class="bold">
                <td colspan="12" style="text-justify: left;">SOMATOMETRíA Y SIGNOS VITALES</td>
            </tr>
            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <tr style="background-color: #d8e0e2;" class="bold">
                <td colspan="12" style="text-align: left;">SOMATOMETRíA</td>
            </tr>
        </table>
        <!--Somatometría-->
        <table style="width: 100%; border-collapse: collapse; text-align: center;">
            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;" class="cursive"> Estatura </td>
                <td colspan="2" style="text-align: left;">
                    <strong style="font-size: 12px;"><?php echo $resultados->ESTATURA; ?> cm </strong>
                </td>
                +<td colspan="3"> </td>
                <td colspan="3" style="text-align: left;" class="cursive">Indice de masa corporal</td>
                <td colspan="2" style="text-align: left;">
                    <strong style="font-size: 12px;"><?php echo $resultados->MASA_GRASA_CORPORAL; ?> cm</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;" class="cursive">Peso</td>
                <td colspan="2" style="text-align: left;">
                    <strong style="font-size: 12px;"><?php echo $resultados->PESO; ?> kg</strong>
                </td>
                <td colspan="3"></td>
                <td colspan="3" style="text-align: left;" class="cursive">Huesos</td>
                <td colspan="2" style="text-align: left;">
                    <strong style="font-size: 12px;"><?php echo $resultados->HUESOS; ?> mm</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;" class="cursive">Masa corporal</td>
                <td colspan="2" style="text-align: left;">
                    <strong style="font-size: 12px;"><?php echo $resultados->MASA_CORPORAL; ?> kg/m2</strong>
                </td>
                <td colspan="3"></td>
                <td colspan="3" style="text-align: left;" class="cursive"> Mineral</td>
                <td colspan="2" style="text-align: left;">
                    <strong style="font-size: 12px;"><?php echo $resultados->Mineral; ?> %</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;" class="cursive">Masa muscular</td>
                <td colspan="2" style="text-align: left;">
                    <strong style="font-size: 12px;"><?php echo $resultados->MASA_MUSCULAR; ?> kg </strong>
                </td>
                <td colspan="3"></td>
                <td colspan="3" style="text-align: left;" class="cursive">Porcentaje de grasa visceral</td>
                <td colspan="2" style="text-align: left;">
                    <strong style="font-size: 12px;"><?php echo $resultados->PORCENTAJE_DE_GRASA_VISCERAL; ?> %</strong>
                </td>
            </tr>

            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <!--signos vitales-->
            <tr style="background-color: #d8e0e2;" class="bold">
                <td colspan="12" style="text-align: left;">SIGNOS VITALES</td>
            </tr>
        </table>
        <div style="display: flex; justify-content: space-between; flex-basis: auto; padding-top: 8px;">
            <!-- <p colspan="12"> &nbsp;</p> -->

            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left;">
                        <table style="width: 95%; border-collapse: collapse; text-align: center;" border="2">
                            <thead>
                                <tr style="text-align: center; background-color: #d8e0e2;">
                                    <th colspan="6">PRESIÓN ARTERIAL:
                                        <?php echo $resultados->SISTOLICA; ?> /
                                        <?php echo $resultados->DIASTOLICA; ?>
                                    </th>
                                </tr>
                            </thead>
                            <tr <?php if (($resultados->SISTOLICA >= 81 && $resultados->SISTOLICA <= 129) && ($resultados->DIASTOLICA >= 61 && $resultados->DIASTOLICA <= 80)) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Óptima</td>
                                <td colspan="3">&lt;= 120/&lt;= 80</td>
                            </tr>
                            <tr <?php if (($resultados->SISTOLICA >= 121 && $resultados->SISTOLICA <= 129) && ($resultados->DIASTOLICA >= 81 && $resultados->DIASTOLICA <= 84)) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Normal</td>
                                <td colspan="3">120-129 / 80-84</td>
                            </tr>
                            <tr <?php if ($resultados->SISTOLICA < 80  && $resultados->DIASTOLICA < 60) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipotensión</td>
                                <td colspan="3">&lt; 80 / &lt; 60</td>
                            </tr>
                            <tr <?php if (($resultados->SISTOLICA >= 130 && $resultados->SISTOLICA >= 129) && ($resultados->DIASTOLICA >= 85 && $resultados->DIASTOLICA <= 89)) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Normal alta</td>
                                <td colspan="3">130-139 / 85-89</td>
                            </tr>
                            <tr <?php if (($resultados->SISTOLICA >= 140 && $resultados->SISTOLICA <= 159) && ($resultados->DIASTOLICA >= 90 && $resultados->DIASTOLICA <= 99)) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipertensión G1</td>
                                <td colspan="3">140-159 / 90-99</td>
                            </tr>
                            <tr <?php if (($resultados->SISTOLICA >= 160 && $resultados->SISTOLICA <= 179) && ($resultados->DIASTOLICA >= 100 && $resultados->DIASTOLICA <= 109)) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipertensión G2</td>
                                <td colspan="3">160-179 / 100-109</td>
                            </tr>
                            <tr <?php if ($resultados->SISTOLICA >= 180 &&  $resultados->DIASTOLICA >= 110) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipertensión G3</td>
                                <td colspan="3">180 / &gt;= 110</td>
                            </tr>
                            <tr <?php if ($signos->PRESION_SISTOLICA >= 140 &&  $signos->PRESION_DIASTOLICA <= 90) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipertensión sistólica</td>
                                <td colspan="3">&gt;= 140 / &lt;= 90</td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align: right;">
                        <table style="width: 95%; border-collapse: collapse; text-align: center;" border="2">
                            <thead>
                                <tr style="text-align: center; background-color: #d8e0e2;">
                                    <th colspan="6">TEMPERATURA:
                                        <?php echo $resultados->TEMPERATURA; ?>°C
                                    </th>
                                </tr>
                            </thead>
                            <tr <?php if ($resultados->TEMPERATURA >= 17 && $resultados->TEMPERATURA < 28) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipotermia profunda</td>
                                <td colspan="3">entre 17 °C - 28 °C</td>
                            </tr>
                            <tr <?php if ($resultados->TEMPERATURA >= 28 && $resultados->TEMPERATURA <= 35) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipotermia ligera</td>
                                <td colspan="3">entre 28 °C - 35 °C</td>
                            </tr>
                            <tr <?php if ($resultados->TEMPERATURA >= 36 && $resultados->TEMPERATURA <= 37) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Temperatura normal</td>
                                <td colspan="3">entre 36 °C - 37 °C</td>
                            </tr>
                            <tr <?php if ($resultados->TEMPERATURA >= 37.4 && $resultados->TEMPERATURA <= 37.9) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Febrícula</td>
                                <td colspan="3">entre 37.4 °C - 37.9 °C</td>
                            </tr>
                            <tr <?php if ($resultados->TEMPERATURA >= 38 && $resultados->TEMPERATURA <= 38.9) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Fiebre moderada</td>
                                <td colspan="3">entre 38 °C - 38.9°C</td>
                            </tr>
                            <tr <?php if ($resultados->TEMPERATURA >= 39 && $resultados->TEMPERATURA <= 39.9) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Fiebre alta</td>
                                <td colspan="3">entre 39 °C - 39.9 °C</td>
                            </tr>
                            <tr <?php if ($resultados->TEMPERATURA >= 40 && $resultados->TEMPERATURA <= 41.5) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Fiebre muy alta</td>
                                <td colspan="3">entre 40 °C - 41.5 °C</td>
                            </tr>
                            <tr <?php if ($resultados->TEMPERATURA > 41.5) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hiperpirexia </td>
                                <td colspan="3">&gt; 41.5 °C</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="width: 95%; border-collapse: collapse; text-align: center; padding-top: 5px;" border="2">
                            <thead>
                                <tr style="text-align: center; background-color: #d8e0e2;">
                                    <th colspan="6">OXIMETRÍA DEL PULSO:
                                        <?php echo $resultados->SATURACION_DE_OXIGENO; ?>%
                                    </th>
                                </tr>
                            </thead>
                            <tr <?php if ($resultados->SATURACION_DE_OXIGENO >= 95 && $resultados->SATURACION_DE_OXIGENO <= 100) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Normal</td>
                                <td colspan="3">95-100%</td>
                            </tr>
                            <tr <?php if ($resultados->SATURACION_DE_OXIGENO >= 91 && $resultados->SATURACION_DE_OXIGENO <= 94) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipoxia leve</td>
                                <td colspan="3">91-94%</td>
                            </tr>
                            <tr <?php if ($resultados->SATURACION_DE_OXIGENO >= 85 && $resultados->SATURACION_DE_OXIGENO <= 90) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipoxia moderada</td>
                                <td colspan="3">85-90%</td>
                            </tr>
                            <tr <?php if ($resultados->SATURACION_DE_OXIGENO < 85) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Hipoxia severa</td>
                                <td colspan="3">&lt; 85%</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 95%; border-collapse: collapse; text-align: center; padding-top: 5px;" border="2">
                            <thead>
                                <tr style="text-align: center; background-color: #d8e0e2;">
                                    <th colspan="6">FRECUENCIA RESPIRATORIA:
                                        <?php echo $resultados->FRECUENCIA_RESPIRATORIA; ?>rpm
                                    </th>
                                </tr>
                            </thead>
                            <tr <?php if ($resultados->FRECUENCIA_RESPIRATORIA >= 12 && $resultados->FRECUENCIA_RESPIRATORIA <= 18) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Normal (Eupnea)</td>
                                <td colspan="3">12-18 rpm</td>
                            </tr>
                            <tr <?php if ($resultados->FRECUENCIA_RESPIRATORIA < 10) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Bradipnea</td>
                                <td colspan="3">&lt; 10 rpm</td>
                            </tr>
                            <tr <?php if ($resultados->FRECUENCIA_RESPIRATORIA > 20) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Taquipnea</td>
                                <td colspan="3">&gt; 20 rpm</td>
                            </tr>
                            <tr <?php if ($resultados->FRECUENCIA_RESPIRATORIA = 0) {
                                    echo 'style="background-color: #f7be16;"';
                                } ?>>
                                <td colspan="3">Apnea</td>
                                <td colspan="3">ausencia respiratoria</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>

    </div>
    <!--    <table style="width: 100%;">
            <tr>
                <td colspan="12" style="text-align: right;"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
                <td colspan="12" style="text-align: right;"><strong>Atentamente:</strong></td>
            </tr>
            <tr>
                <td style="height: 60px"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center; width:33.3%">AQUI VA EL QR</td>
                <td colspan="4" style="text-align: right; width: 33.3%"><strong>Q.F.B. NERY FABIOLA ORNELAS RESENDIZ
                        <br>UPCH - Cédula profesional: 09291445</strong></td>
            </tr>
        </table>
        <hr style="height: 2px; background-color: black ;">
        <p style="text-align: center;"><small><strong>Avenidad Universidad S/N Colonia Casa Blanca, Villahermosa,
                    Tabasco - Teléfono: 993 131 00 42 Correo electrónico:
                    biologia.molecular@hguadalupe.com</strong></small></p>-->
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