<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de interpretación de Historia Clinica</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">  -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 165px 10px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin-top: 70px;
            margin-bottom: 40px;
            font-size: 10px;
            /* background-color: gray; */
        }

        .header {
            position: fixed;
            top: -165px;
            left: 25px;
            right: 25px;
            height: 220px;
            margin-top: 0;
        }

        .footer {
            position: fixed;
            bottom: -165px;
            left: 25px;
            right: 25px;
            height: 220px;
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
          /*tabla de espiro */
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

        .pregunta-row {
            background-color: #f2f2f2;
            font-weight: bold;
            padding: 10px;
        }

        .respuesta-row,
        .comentario-row {
            background-color: #fff;
            padding: 5px;
            border-bottom: 1px solid #ddd;
            border-top: 1px solid #ddd;
        }

        /* termina estilo de tabla espiro */
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
        $tituloPersonales = 'Informacón del paciente';
        $subtitulo = 'Historia Clínica';
        $encabezado->FECHA_RESULTADO = $encabezado->FECHA_RESULTADO_ESPIRO;
        include 'includes/header.php';
        ?>
    </div>

    <div class="footer">
        <?php
        $footerDoctor = 'Dra. BEATRIZ ALEJANDRA RAMOS GONZÁLEZ <br>UJAT - Cédula profesional: 7796595';

        include 'includes/footer.php';
        ?>
    </div>


    <!-- body -->
    <div class="invoice-content">
        <?php 
        # filtramos las preguntas que van dentro de comentario en la pregunta 14
        $arreglo = [];
        $arreglo = array_filter($resultados, function ($item) {
            return $item->id_pregunta == 39 || $item->id_pregunta == 40 || $item->id_pregunta == 41;
        });

        # dividimos el cuestionario de espiro en tablas para dibujar
        # en una tabla en cada hoja y no se encime con el encabezado.
        $tablas = dividirTablaEnPaginas(json_encode($resultados)); 
            $ait = new ArrayIterator($tablas);
            $cit = new CachingIterator($ait);
        
        foreach($cit as $tabla):
            echo "<br>"; ?>
            <table class="table">
                <?php foreach ($tabla as $preguntaIndex => $pregunta): ?>
                    <?php if (!in_array($pregunta['id_pregunta'],[39,40,41])):  ?>
                        <?php $respuestas = $pregunta['respuestas']; ?>
                        <?php $numRespuestas = count($respuestas); ?>
                        <tr class="pregunta-row">
                            <td colspan="3" class="pregunta-row"><?php echo $pregunta['pregunta']; ?></td>
                        </tr>
                        <?php if ($numRespuestas > 0): ?>
                            <?php foreach ($respuestas as $respuestaIndex => $respuesta): ?>
                                <tr>
                                    <td class="respuesta-row"><?php echo $respuesta['respuesta'] !== null ? $respuesta['respuesta'] : $respuesta['comentario']; ?></td>
                                    <td class="comentario-row">
                                        <?php
                                        if (in_array($pregunta['id_pregunta'],[14])){
                                            foreach($arreglo as $arregloIndex){
                                                echo $arregloIndex->pregunta. ' '. $arregloIndex->respuestas[0]->comentario."<br>";
                                            }
                                        } else {
                                            echo $respuesta['comentario'] !== null ? ($respuesta['respuesta'] !== null ? $respuesta['comentario'] : "-") : '-';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <!-- termina segundo foreach -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td class="respuesta-row" colspan="3">No hay respuestas disponibles</td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                <!-- termina primer foreach -->
                <?php endforeach; ?> 
            </table>
        <?php    
            if ($cit->hasNext())   
                echo '<div class="break"></div>';
            endforeach;
        ?>
    </div>
</body>


<?php
$altura = 200;

for ($i = 2; $i < $indice; $i++) {
    $altura = $altura + 50;
}

function dividirTablaEnPaginas($json) {
    $preguntas = json_decode($json, true);
  
    $altoTabla = 0;
    $altoPagina = 500; // Tamaño carta: 8.5 x 11 pulgadas (en puntos) 792
    $tablas = [];
    $tablaActual = [];
  
    foreach ($preguntas as $pregunta) {
      $respuestas = $pregunta['respuestas'];
      $altoFila = 20; // Altura de cada fila (valor de ejemplo)
  
      // Verificar si la fila actual excede el espacio disponible en la página actual
      if (($altoTabla + $altoFila) > $altoPagina) {
        // Si excede, agregar la tabla actual a la lista de tablas y reiniciar el alto de la tabla
        $tablas[] = $tablaActual;
        $tablaActual = [];
        $altoTabla = 0;
      }
  
      // Agregar la pregunta a la tabla actual
      $tablaActual[] = [
        'id_pregunta' => $pregunta['id_pregunta'],
        'pregunta' => $pregunta['pregunta'],
        'respuestas' => $respuestas
      ];
      $altoTabla += $altoFila;
  
      // Agregar las respuestas como filas individuales a la tabla actual
    //   foreach ($respuestas as $respuesta) {
    //     $tablaActual[] = [
    //       'pregunta' => $respuesta['respuesta'],
    //       'respuestas' => $respuesta['comentario']
    //     ];
    //     $altoTabla += $altoFila;
    //   }
  
    //   // Verificar si la tabla actual excede el espacio disponible en la página actual
    //   if (($altoTabla + $altoFila) > $altoPagina) {
    //     // Si excede, agregar un salto de página
    //     $tablaActual[] = ['salto_pagina' => true];
    //     $altoTabla += $altoFila;
    //   }
    }
  
    // Agregar la última tabla actual a la lista de tablas
    $tablas[] = $tablaActual;
  
    return $tablas;
  }
?>

</html>