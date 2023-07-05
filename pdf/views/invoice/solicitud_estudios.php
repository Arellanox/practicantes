<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de estudios</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">  -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 165px 10px;
            size: 21.59cm 13.97cm;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin-top: -2px;
            margin-bottom: 1px;
            font-size: 10px;
            /* background-color: gray; */
        }

        .header {
            position: fixed;
            top: -160px;
            left: 25px;
            right: 25px;
            height: 160px;
            margin-top: 0;
            /* background-color: purple; */
        }

        .footer {
            position: fixed;
            bottom: -206px;
            left: 25px;
            right: 25px;
            height: 200px;
            /* background-color: pink; */
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
            position: relative;
            top: 10px;
            border-radius: 4px;
            padding-bottom: 5px;
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
            line-height: 1;
        }

        h5 {
            font-size: 12.5px;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        p {
            font-size: 12px;
            line-height: 1;
        }

        strong {
            font-size: 12px;
            /* line-height: 1.3; */
            margin-top: 0.5em;
            margin-bottom: 0.5em;

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
            width: 28%;
            max-width: 41%;
            text-align: left;
            font-size: 11px;
            margin-left: 2px;
        }

        .col-right {
            width: 26%;
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
            text-align: center;
        }

        .col-der {
            width: 70%;
            max-width: 70%;
            text-align: left;
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

        .table {
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            margin: auto;
            white-space: normal;
            word-break: break-all;
        }

        .table>tr,
        .table>tr>td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;

        }

        .table>tr {
            background-color: #f2f2f2;
        }

        .pregunta-row,
        .tratamiento-titulo {
            background-color: #f2f2f2;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        .respuesta-row,
        .comentario-row {
            background-color: #fff;
            padding: 5px;
            border-bottom: 1px solid #ddd;
            border-top: 1px solid #ddd;
            font-size: 13px;
        }

        .respuesta2-row {
            background-color: #fff;
            padding: 5px;
            border-bottom: 1px solid #ddd;
            border-top: 1px solid #ddd;
            font-size: 11px;
        }

        /* cuerpo del tratamiento */
        .tratamiento {
            background-color: #fff;
            font-size: 13px;
        }

        .tratamiento-cuerpo {
            background-color: #fff;
            padding: 5px;
            border-bottom: 1px solid #ddd;
            border-top: 1px solid #ddd;
            font-size: 13px;
        }

        /* para la marca de agua */
        /* .marca-agua {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.5;
            font-size: 48px;
            color: #cccccc;
            z-index: 9999;
        } */
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
$ruta_firma = file_get_contents('../pdf/public/assets/firma_beatriz.png');
$encode_firma = base64_encode($ruta_firma);


?>

<body>

    <!-- header -->
    <div class="header">
        <?php
        $titulo = 'Checkup Clínica y Prevención';
        $tituloPersonales = 'Información del paciente';
        $subtitulo = 'Solicitud de estuidos';
        $encabezado->FECHA_RESULTADO = $encabezado->FECHA_RESULTADO_CONSULTA;
        include 'includes/header_receta.php';
        ?>
    </div>

    <div class="footer">
        <?php
        $footerDoctor = 'Dra. BEATRIZ ALEJANDRA RAMOS GONZÁLEZ <br>UJAT - Cédula profesional: 7796595';

        include 'includes/footer_soli_estudios.php';
        ?>
    </div>
    <br>
    <!-- Body -->
    <div class="invoice-content row">
        <table class="table">
            <thead>
                <tr>
                    <td class="pregunta-row">Solicitudes de estudios:</td>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($resultados[2]); $i++) : ?>
                    <tr>
                        <td class="respuesta-row"><?php echo $resultados[2][$i]->DESCRIPCION.' - '.$resultados[2][$i]->ABREVIATURA; ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        <?php
    print_r($resultados);
        ?>
    </div>

</body>

</html>