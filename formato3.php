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
            padding: 3.4px;
            min-width: 8px;
            max-height: 10px;
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

        .turno-2 {
            border: 2px dashed black !important;
        }

        .turno-3 {
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
            color: blue;
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th class="celdasDias"></th>
            <?php
            for ($i = 1; $i <= 31; $i++) {
                echo "<th class='diaHeader' colspan='3'>" . $i . "</th>";
            }
            ?>
        </tr>
        <?php
        $valores = array(
            1 => array(
                1 => array("valor" => "-30.1"),
                2 => array("valor" => "-30.3"),
                3 => array("valor" => "-38.6")
            ),
            2 => array(
                1 => array("valor" => "-30.1"),
                2 => array("valor" => "-25.1"),
                3 => array("valor" => "-38.6")
            ),
            3 => array(
                1 => array("valor" => "-30"),
                2 => array("valor" => "-20"),
                3 => array("valor" => "-21")
            ),
            4 => array(
                1 => array("valor" => "-20")
            ),
            5 => array(
                1 => array("valor" => "-30")
            ),
            6 => array(
                1 => array("valor" => "-25"),
                2 => array("valor" => "-33")
            ),
            7 => array(
                1 => array("valor" => "-30"),
                2 => array("valor" => "-32"),
                3 => array("valor" => "-30")

            ),
            16 => array(
                2 => array("valor" => "-40")
            ),
            31 => array(
                1 => array("valor" => "-30"),
                2 => array("valor" => "-30"),
                3 => array("valor" => "-30")
            )
        );

        function metodoCalculo($dia, $turno, $valorAprox)
        {
            global $valores;
            if (isset($valores[$dia]) && isset($valores[$dia][$turno])) {
                $valor = floatval($valores[$dia][$turno]["valor"]);
                $valor_redondeado = round($valor);
                if ($valor_redondeado == $valorAprox) {
                    $dotId = "dot-$dia-$turno"; // Generar el ID del dot
                    return "<td class='empty turno-$turno background$valorAprox dot' id='$dotId'>&#8226;</td>";
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
                $dot3 = metodoCalculo($i, 3, $j);

                if ($dot1 != '<td class="empty turno-1 background' . $j . '"></td>') {
                    echo $dot1;
                    if ($dot2 != '<td class="empty turno-2 background' . $j . '"></td>') {
                        echo $dot2;
                        if ($dot3 != '<td class="empty turno-3 background' . $j . '"></td>') {
                            echo $dot3;

                            $currentDotId = "dot-$i-3"; // ID del dot actual
                            if ($prevDot) {
                                $prevDotId = $prevDot->getAttribute('id');
                                "<script> connectDots($prevDotId, $currentDotId)</script>"; // Conectar dots
                            }
                            $prevDot = $dots[$currentDotId]; // Guardar dot previo
                        } else {
                            $prevDot = null; // No hay dot en el turno 3, reiniciar dot previo
                        }
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

    <canvas id="canvas"></canvas>

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
                ctx.strokeStyle = "blue";
                ctx.stroke();
            }

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
                    for (var j = 1; j <= 3; j++) {
                        prevDot = document.getElementById('dot-' + i + '-' + j);

                        if (typeof(prevDot) == "object") {
                            prevDot = document.getElementById('dot-' + i + '-' + j)
                            j = 4
                        }

                    }
                }

                for (var i = dotInicial; i <= dotLast; i++) {
                    for (var j = 1; j < 4; j++) {
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