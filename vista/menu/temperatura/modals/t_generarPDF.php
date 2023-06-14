<div class="modal fade" id="GenerarTemperaturaModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="liberarDiaTitle">Vista previa del mes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table--container" id="grafica">
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

                    <canvas id="canvas"></canvas>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i>
                    Cancelar</button>
                <button type="submit" form="liberarDiaTemperaturaForm" class="btn btn-confirmar" id="btn-generarPDF-temperatura">
                    <i class="bi bi-arrow-down-circle-fill"></i> Generar
                </button>
                <button id="click-btn">Crear linea</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('#click-btn').click(function() {
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
    })