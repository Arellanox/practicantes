<?php
/* $folio = $_POST['folio']; */
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 2px solid black;
            padding: 7px;

        }

        td.empty {
            margin-left: auto;
            margin-right: auto;
            padding: 3.4px;
            width: 20px;
        }

        .border-34 {
            border-top: 3px solid !important;
        }

        .border-25 {
            border-bottom: 3px solid;
        }

        .background-25,
        .background-26,
        .background-27,
        .background-28,
        .background-29,
        .background-30,
        .background-31,
        .background-32,
        .background-33,
        .background-34 {
            background-color: #d8dfe1;
        }

        .turno-1 {
            border: 2px dashed black !important;
        }

        /*  .turno-2 {
            border: 2px dashed black !important;
        } */

        .turno-2 {
            border-left: 2px dashed black !important;
            border-top: 2px dashed black !important;
            border-bottom: 2px dashed black !important;
        }

        .celdasDias {
            font-weight: normal !important;
            border-left: none !important;
            border-top: 5px solid #0000 !important;
            border-bottom: none !important;
        }

        .diaHeader {
            padding: 2px !important;
            background-color: #d8dfe1 !important;
        }

        .text-25,
        .text-35 {
            font-size: 20px !important;
            font-weight: bold !important;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .dot {
            font-size: 30px;
            text-align: center !important;
        }

        .dot-blue {
            color: blue;
        }

        .dot-mostaza {
            color: #ffa209;
        }

        canvas {
            position: absolute;
            top: 70px;
            left: 0;
        }

        #equipo {
            width: 900px;
            border: 1px solid black;
            margin-left: 10px;
            margin-right: 10px;
        }

        .equipo-header {
            align-self: center;
            margin-top: auto;
            margin-bottom: auto;
            background: #d8dfe1;
            height: 20px;
            display: flex;
            justify-content: center;
            border-bottom: 1px solid black;
        }

        .equipo-header h5 {
            align-self: center;
        }

        .equipo-body {
            display: flex;
            margin-top: 5px;
            margin-bottom: 5px;
            margin-right: 30px;
        }

        .equipo--input {
            display: flex;
            justify-content: center;
            align-self: center;
            width: 170px !important;
            border-bottom: 2px solid black;
        }

        .equipo--container {
            height: 20px !important;
            display: flex;
            padding: 5px 20px;
        }

        label {
            font-size: 15px;
        }

        .table--container {
            display: flex !important;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
        }

        .container {
            display: flex !important;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>

    <canvas id="canvas"></canvas>

    <div class="container " style="display: flex;">
        <div id="equipo">
            <div class="equipo-header">
                <h5>EQUIPO</h5>
            </div>
            <div class="equipo--container">
                <div class="equipo-body">
                    <label style="margin-right: 5px;">Equipo:</label>
                    <small class="equipo--input">
                        CONGELADOR
                    </small>
                </div>
                <div class="equipo-body">
                    <label style="margin-right: 5px;">Modelo:</label>
                    <div class="equipo--input">
                        as
                    </div>
                </div>
                <div class="equipo-body">
                    <label style="margin-right: 5px;">Localización:</label>
                    <div class="equipo--input" style="width: 250px !important">
                        ass
                    </div>
                </div>
            </div>
            <div class="equipo--container">
                <div class="equipo-body">
                    <label style="margin-right: 5px;">Marca:</label>
                    <div class="equipo--input">
                        <span></span>
                    </div>
                </div>
                <div class="equipo-body">
                    <label style="margin-right: 5px;">N° Serie:</label>
                    <div class="equipo--input" style="width: 260px !important">
                        <small></small>
                    </div>
                </div>
                <div class="equipo-body">
                    <label style="margin-right: 5px;">Intervalo Optimo:</label>
                    <div class="equipo--input" style="width:100px !important;">
                        <span style="font-weight: bold;">-25 A -35°C</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="equipo">
            <div class="equipo-header">
                <h5>TERMOMETRO</h5>
            </div>
            <div class="equipo--container">
                <div class="equipo-body">
                    <label style="margin-right: 5px;">Marca:</label>
                    <small class="equipo--input">
                        CONGELADOR
                    </small>
                </div>
                <div class="equipo-body">
                    <label style="margin-right: 5px; width:150px !important;">Factor de correción:</label>
                    <div class="equipo--input">
                        °C
                    </div>
                </div>
                <div class="equipo-body">
                    <label style="margin-right: 5px;">MES:</label>
                    <div class="equipo--input">
                        ass
                    </div>
                </div>
            </div>
            <div class="equipo--container">
                <div class="equipo-body">
                    <label style="margin-right: 5px;">ID:</label>
                    <div class="equipo--input">
                        <span></span>
                    </div>
                </div>
                <div class="equipo-body">
                    <label style="margin-right: 5px; width:150px !important;">Fecha de verificación:</label>
                    <div class="equipo--input">
                        <small>s</small>
                    </div>
                </div>
                <div class="equipo-body">
                    <label style="margin-right: 5px;">AÑO:</label>
                    <div class="equipo--input">
                        <small>s</small>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="table--container">
        <table>
            <tr>
                <th class="celdasDias"></th>
                <?php
                for ($i = 1; $i <= 31; $i++) {
                    echo "<th class='diaHeader' colspan='2'>" . $i . "</th>";
                }
                ?>
            </tr>
            <?php
            $url = "http://localhost/practicantes/api/temperatura_api.php";
            // Los datos de formulario
            $datos = [
                "api" => 7,
                "folio" => 2,
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
            $json = file_get_contents($url, false, $contexto);

            $array = json_decode($json, true);

            foreach ($array['response'] as $key1 => $e) {
                $valores = $e;
            }

            /* $valores = array(
            1 => array(
                1 => array("valor" => "-30.1", "color" => "blue"), //Primero del primer tuno 7:30 am 11:59 am,
                2 => array("valor" => "-30.3", "color" => "blue") //Primero del segundo turno de las 12:00 pm - 7:00 pm,

            ),
            2 => array(
                1 => array("valor" => "-30.1", "color" => "blue"),
                2 => array("valor" => "-25.1", "color" => "blue"),

            ),
            3 => array(
                1 => array("valor" => "-30", "color" => "blue"),
                2 => array("valor" => "-20", "color" => "blue"),

            ),
            4 => array(
                1 => array("valor" => "-20", "color" => "blue")
            ),
            5 => array(
                1 => array("valor" => "-30", "color" => "mostaza")
            ),
            6 => array(
                1 => array("valor" => "-25", "color" => "blue"),
                2 => array("valor" => "-33", "color" => "blue")
            ),
            7 => array(
                1 => array("valor" => "-30", "color" => "blue"),
                2 => array("valor" => "-32", "color" => "blue"),

            ),
            11 => array(
                3 => array("valor" => "-34", "color" => "blue")
            ),
            16 => array(
                2 => array("valor" => "-36", "color" => "blue")
            ),
            20 => array(
                2 => array("valor" => "-33", "color" => "blue")
            ),
            27 => array(
                1 => array("valor" => "-33", "color" => "blue"),
                2 => array("valor" => "-31", "color" => "blue"),
            ),
            31 => array(
                2 => array("valor" => "-33", "color" => "blue")
            )
        ); */

            function metodoCalculo($dia, $turno, $valorAprox)
            {
                global $valores;
                if (isset($valores[$dia]) && isset($valores[$dia][$turno])) {
                    $valor = floatval($valores[$dia][$turno]["valor"]);
                    $valor_redondeado = round($valor);
                    $color = $valores[$dia][$turno]['color'];
                    if ($valor_redondeado == $valorAprox) {
                        $dotId = "dot-$dia-$turno"; // Generar el ID del dot
                        return "<td class='empty turno-$turno background$valorAprox dot dot-$color' id='$dotId'>&#8226;</td>";
                    }
                }
                return "<td class='empty turno-$turno background$valorAprox'></td>";
            }

            // Generar las celdas de la tabla
            for ($j = -40; $j <= -20; $j++) {
                echo "<tr class='border$j'>";
                echo "<th class='celdasDias text$j'>" . $j . "</th>";

                $prevDot = null; // Dot previo para conectar con líneas

                for ($i = 1; $i <= 31; $i++) {
                    $dot1 = metodoCalculo($i, 1, $j);
                    $dot2 = metodoCalculo($i, 2, $j);
                    /* $dot3 = metodoCalculo($i, 3, $j); */

                    if ($dot1 != '<td class="empty turno-1 background' . $j . '"></td>') {
                        echo $dot1;
                        if ($dot2 != '<td class="empty turno-2 background' . $j . '"></td>') {
                            echo $dot2;
                        } else {
                            $prevDot = null; // No hay dot en el turno 2, reiniciar dot previo
                        }
                    } else {
                        $prevDot = null; // No hay dot en el turno 1, reiniciar dot previo
                    }
                }
                echo "</tr>";
            }
            ?>
        </table>


    </div>

    <script>
        window.addEventListener('load', function() {
            var canvas = document.getElementById('canvas');
            var ctx = canvas.getContext('2d');
            var dots = document.getElementsByClassName('dot');

            function connectDots(dot1, dot2) {
                var rect1 = dot1.getBoundingClientRect();
                var rect2 = dot2.getBoundingClientRect();
                var x1 = rect1.left + rect1.width / 2 - canvas.getBoundingClientRect().left;
                var y1 = rect1.top + rect1.height / 2 - canvas.getBoundingClientRect().top;
                var x2 = rect2.left + rect2.width / 2 - canvas.getBoundingClientRect().left;
                var y2 = rect2.top + rect2.height / 2 - canvas.getBoundingClientRect().top;


                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.lineWidth = 3;
                ctx.strokeStyle = "blue";
                ctx.stroke();
            }

            /* function getDotCenter(dot) {
                var rect = dot.getBoundingClientRect();
                var x = rect.left + rect.width / 2 - canvas.getBoundingClientRect().left;
                var y = rect.top + rect.height / 2 - canvas.getBoundingClientRect().top;

                return {
                    x: x,
                    y: y
                };
            }

            function connectDots(dot1, dot2) {
                var dot1Center = getDotCenter(dot1);
                var dot2Center = getDotCenter(dot2);

                var x1 = dot1Center.x;
                var y1 = dot1Center.y;
                var x2 = dot2Center.x;
                var y2 = dot2Center.y;

                var controlX = (x1 + x2) / 2;
                var controlY = (y1 + y2) / 2 - Math.abs(x1 - x2) / 4;

                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.quadraticCurveTo(controlX, controlY, x2, y2);
                ctx.strokeStyle = "blue "; // Cambiar el color de la línea a rojo
                ctx.lineWidth = 3; // Ajustar el ancho de línea
                ctx.stroke();
            } */






            function positionDots() {
                var dotCount = dots.length;
                var containerWidth = dots[0].closest('table').offsetWidth;

                // Ajustar el tamaño del canvas al ancho del contenedor
                canvas.width = containerWidth;
                canvas.height = dots[0].closest('table').offsetHeight;


                for (var i = 0; i < dotCount; i++) {
                    var dot = dots[i];
                    var rect = dot.getBoundingClientRect();
                    var x = rect.left + rect.width / 2 - canvas.getBoundingClientRect().left;
                    var y = rect.top + rect.height / 2 - canvas.getBoundingClientRect().top;

                    dot.dataset.x = x; // Guardar la posición x en un atributo de datos
                    dot.dataset.y = y; // Guardar la posición y en un atributo de datos
                }
            }

            function drawLines() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                var prevDot;

                var dotInicial = <?php echo array_key_first($valores); ?>;

                var dotLast = <?php echo array_key_last($valores); ?>;


                for (var i = dotInicial; typeof(prevDot) != "object"; i++) {
                    for (var j = 1; j <= 2; j++) {
                        prevDot = document.getElementById('dot-' + i + '-' + j);

                        if (typeof(prevDot) == "object") {
                            prevDot = document.getElementById('dot-' + i + '-' + j)
                            j = 3
                        }

                    }
                }

                for (var i = dotInicial; i <= dotLast; i++) {
                    for (var j = 1; j < 3; j++) {
                        var currentDotId = 'dot-' + i + '-' + j;
                        var currentDot = document.getElementById(currentDotId);


                        if (currentDot == null) {
                            prevDot = prevDot
                        } else {
                            if (currentDot) {
                                connectDots(prevDot, currentDot);
                                prevDot = currentDot;
                            } else {
                                break;
                            }

                        }



                    }
                }
            }

            positionDots();
            drawLines();
        });
    </script>

</body>

</html>