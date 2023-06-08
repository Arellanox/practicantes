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

//para las advertencias
// para el path del logo 
$ruta_advertencia_amarilla = file_get_contents('../pdf/public/assets/advertencia_amarilla.png');
$encode_advertencia_amarilla = base64_encode($ruta_advertencia_amarilla);

$ruta_advertencia_roja = file_get_contents('../pdf/public/assets/advertencia_roja.png');
$encode_advertencia_roja = base64_encode($ruta_advertencia_roja);

$ruta_advertencia_verde = file_get_contents('../pdf/public/assets/advertencia_verde.png');
$encode_advertencia_verde = base64_encode($ruta_advertencia_verde);

$textoVerde = " 
<br>El continuar con hábitos de estilo de vida saludable te ayudará a que el margen de riesgo de padecer enfermedades crónico degenerativas sea menor; sin embargo, debes tener en cuenta las siguientes recomendaciones: 
<br>1.- Visita a tu médico una vez al año.
<br>2.- Hazte a un checkup médico al menos una vez al año, recuerda incluir química sanguínea, examen general de orina, biometría hemática, electrocardiograma y rayos x de tórax, en bimo estaremos encantados de recibirte.
<br>3.-  Realiza actividad física aeróbica (caminar, trotar, correr o andar en bicicleta) por lo menos 30 minutos 5 veces a la semana, así ayudarás a mejorar tu sistema cardiovascular y a que tu cuerpo tenga mayor resistencia. 
<br>4.- Realiza tus tres comidas e incluye colaciones (el desayuno es importante ¡no lo evites!), añade el consumo de carnes magras (sin grasa), aumenta el consumo de alimentos ricos en fibra saludable, toma 2 litros de agua al día (un vaso de agua media hora antes de la comida) y preferentemente cocina tus alimentos de la siguiente forma: asado, al vapor, horneado y a la plancha; reduce el consumo de azúcar o sal, evita el consumo de grasas saturadas y limita el consumo de bebidas azucaradas y alimentos con alto contenido de grasas.
";

$textoamarillo = "
<br>Es hora de pensar en el estilo de vida actual y tomar algunas acciones para adoptar hábitos saludables que te ayudarán a reducir el margen de riesgo de padecer enfermedades crónico degenerativas; te sugerimos las siguientes recomendaciones:
<br>1.- Visita a tu médico, esto servirá para que él conozca tu estado actual de salud y te guíe en hacer cambios significativos.
<br>2.- Es un buen momento para realizarte un checkup médico, recuerda incluir química sanguínea, examen general de orina, biometría hemática, electrocardiograma y rayos x de tórax, en bimo estamos encantados de recibirte.
<br>3.-  Realiza actividad física aeróbica (caminar, trotar, correr o andar en bicicleta) por lo menos 30 minutos 3 veces a la semana, así ayudarás a mejorar tu sistema cardiovascular y a que tu cuerpo tenga mayor resistencia. 
<br>4.- Realiza tus tres comidas e incluye colaciones (el desayuno es importante ¡no lo evites!), añade el consumo de carnes magras (sin grasa), aumenta el consumo de alimentos ricos en fibra saludable, toma 2 litros de agua al día (un vaso de agua media hora antes de la comida) y preferentemente cocina tus alimentos de la siguiente forma: asado, al vapor, horneado y a la plancha; reduce el consumo de azúcar o sal, evita el consumo de grasas saturadas y limita el consumo de bebidas azucaradas y alimentos con alto contenido de grasas.
";

$textorojo = "
<br>Es momento de revisar tu estado de salud, acude a tu médico, no dejes pasar el tiempo, tienes una elevada probabilidad de estar padeciendo en este momento una enfermedad crónico-degenerativa, mientras tanto te damos estas recomendaciones: 
<br>1.- Visita a tu médico a la brevedad posible esto servirá para que él conozca tu estado actual de salud e inicie un plan de tratamiento adecuado.
<br>2.- Es un buen momento para realizarte un checkup médico, recuerda incluir química sanguínea, examen general de orina, biometría hemática, electrocardiograma y rayos x de tórax, en bimo estamos encantados de recibirte.
<br>3.-  Realiza actividad física aeróbica (caminar, trotar, correr o andar en bicicleta) por lo menos 30 minutos 3 veces a la semana, así ayudarás a mejorar tu sistema cardiovascular y a que tu cuerpo tenga mayor resistencia. 
<br>4.- Realiza tus tres comidas e incluye colaciones (el desayuno es importante ¡no lo evites!), añade el consumo de carnes magras (sin grasa), aumenta el consumo de alimentos ricos en fibra saludable, toma 2 litros de agua al día (un vaso de agua media hora antes de la comida) y preferentemente cocina tus alimentos de la siguiente forma: asado, al vapor, horneado y a la plancha; reduce el consumo de azúcar o sal, evita el consumo de grasas saturadas y limita el consumo de bebidas azucaradas y alimentos con alto contenido de grasas.
";

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
if (isset($qr)) {
    $qr = null;
}
# success, warning, danger
$tipoAdvertencia = $resultados->TIPO_RIESGO;
$imagenAdvertencia = "";
$textoRecomendacion = "";
$colorAdvertencia = "";
$titulo = "";

if ($tipoAdvertencia === "LEVE") {
    $imagenAdvertencia = $encode_advertencia_verde;
    $textoRecomendacion = $textoVerde;
    $colorAdvertencia = "#6dcd01";
    $tamaño_letra = "font-size: 11px";
    $color_letra = "color: black";
    $riesgo = "BAJO";
    $titulo = "¡Enhorabuena!";
} else if ($tipoAdvertencia === "MODERADO") {
    $imagenAdvertencia = $encode_advertencia_amarilla;
    $textoRecomendacion = $textoamarillo;
    $colorAdvertencia = "#ffd42a";
    $tamaño_letra = "font-size: 11px";
    $color_letra = "color: black";
    $riesgo = "MODERADO";
    $titulo = "¡Es tiempo de hacer un cambio!";
} else {
    $imagenAdvertencia = $encode_advertencia_roja;
    $textoRecomendacion = $textorojo;
    $colorAdvertencia = "#fd1d1d";
    $tamaño_letra = "font-size: 11px";
    $color_letra = "color: white";
    $riesgo = "ALTO";
    $titulo = "¡Es momento de actuar!";
}
?>

<body>
    <div class="container-fluid">
        <table>
            <tbody>
                <tr>
                    <td class="col-der" style="border-bottom: none">
                        <p>
                            <b>DIAGNOSTICO BIOMOLECULAR</b><br>
                            RFC DBI2012084N2<br>
                            Calle AV. RUIZ CORTINES, 1344, TABASCO 2000, CENTRO,<br>
                            VILLAHERMOSA, TABASCO, 86060, MEX<br>
                            9936340250<br>
                            hola@bimo.com.mx
                        </p>
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
                        No. Identificación: <strong style="font-size: 12px;"> <?php echo $resultados->FOLIO ?> </strong>
                    </td>
                    <td class="col-center" style="border-bottom: none">
                        Edad: <strong style="font-size: 12px;"> <?php echo $encabezado->EDAD < 1 ? ($encabezado->EDAD * 10) . " meses" : $encabezado->EDAD . " años"; ?></strong>
                    </td>
                    <td class="col-right" style="border-bottom: none">
                        Sexo: <strong style="font-size: 12px;"><?php echo $resultados->SEXO; ?> </strong>
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
                        Fecha de Resultado: <strong style="font-size: 12px;"> <?php echo $encabezado->FECHA_RESULTADO; ?> </strong>
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
                <td colspan="12" style="text-justify: left;font-size: 12px; padding-top: 3px; padding-bottom: 3px;"> "FAST CHECKUP" DE RIESGO DE ENFERMEDADES CRÓNICO DEGENERATIVAS</td>
            </tr>
        </table>
    </div>
    <div>
        <table style="text-align: center; font-size: 13px; border-collapse: collapse;padding-top: 2rem; width: 520px;">
            <tbody>
                <tr>
                    <td colspan="2">Resultado</td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $resultados->SCORE; ?> PUNTOS</td>
                </tr>
                <tr>
                    <td style="align-items: center; align-content: center; vertical-align: middle; text-align: right; width: 60%;">
                        <?php
                        echo "<img src='data:image/png;base64, " . $imagenAdvertencia . "' height='75' >";
                        ?>
                    </td>
                    <td style="font-size: 16px; align-items: center; align-content: center; text-align: left;">
                        RIESGO <?php echo $riesgo; ?>
                    </td>
                </tr>
                <tr style="background-color: <?php echo $colorAdvertencia; ?>; font-size: 14px; <?php echo $color_letra; ?>;">
                    <td colspan="2" style="padding-top: 4px;"><?php echo $titulo; ?></td>
                </tr>
                <tr>
                    <td style="text-align: left; border: 1.5px solid <?php echo $colorAdvertencia; ?>; <?php echo $tamaño_letra; ?>; padding-bottom: 4px; padding-left: 6px; line-height: 1.5;" colspan="2">
                        <?php echo $textoRecomendacion; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="padding-top: 100px;">
        <div class="footer">
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
        bottom: -50px;
        left: 25px;
        right: 25px;
        height: 200px
    }
</style>

</html>