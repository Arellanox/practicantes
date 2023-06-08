<?php
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
// echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etiquetas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 8px;
            width: 50mm;
            max-width: 50mm;
            height: 25mm;
            max-height: 25mm;
            margin: 1px 5px 0px;
            /* list-style: circle; */
            /* background-color: aqua; */
        }

        p {
            white-space: normal;
            word-break: break-all;
        }

        .header {
            position: fixed;
            top: -2px;
            left: 2px;
            right: 2px;
            height: 3px;
            margin-top: 0;
            /*-30px*/
            /* background-color: aqua; */
        }

        .footer {
            position: fixed;
            bottom: -2px;
            left: 2px;
            right: 2px;
            height: 3px;
            /* background-color: magenta; */
        }

        table {
            width: 100%;
            max-width: 100%;
            text-align: justify;
            margin: auto;
            white-space: normal;
            word-break: break-all;
        }

        th,
        td {
            width: 100%;
            max-width: 90px;
            table-layout: fixed;
            /* border: 1px solid; */
        }

        .label {
            text-justify: inter-word;
            /* margin: 0px 5px 0px; */
        }

        .break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
    </div>
    <div class="footer">
    </div>
    <div class="label">
        <table>
            <?php
            $count = count($resultados->CONTENEDORES);
            $i = 0;

            $recipientes = $resultados;
            foreach ($recipientes->CONTENEDORES as $a => $recipiente) {
                echo "  <tr>
                                <td>
                                    <p style='font-size: 8px;'> <span style='font-weight:bold;'>" .   $recipiente->CONTENEDOR . " (" . $recipiente->MUESTRA . " ) </span> | " .   $recipientes->FECHA_TOMA . " </p>
                                    <p>" .   $recipientes->NOMBRE . "</p>
                                    <p>" .   $recipientes->EDAD . " AÑOS | " . $recipientes->SEXO .  "</p> 
                                    <p>" .   $recipiente->MAQUILA_ABR  . "</p>";
                $etiqueta = '';
                foreach ($recipiente->ESTUDIOS as $b => $estudio) {
                    $etiqueta = $etiqueta . $estudio->ABREVIATURA . ", ";
                }
                echo    "   
                                    <p style='text-align:center; padding-top: 4px; padding-bottom: 4px;'> 
                                      
                                    </p> 
                                    <p style='font-size: 9px; padding-right:2px;'>" . $etiqueta . "</p>
                                </td>
                            </tr>";

                // <img src='data:image/png;base64," .  $generator->getBarcode($barcode, $generator::TYPE_CODE_128)  .  " width='65px' height='30px'>
                $i++;
            }
            ?>
        </table>
    </div>
</body>

</html>