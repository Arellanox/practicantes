<?php
/* $folio = $_POST['folio']; */
?>

<!DOCTYPE html>
<html>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

<body>

    <div id="elemento-a-exportar">

        <head>
            <style>
                table {
                    border-collapse: collapse;
                }

                th,
                td {
                    border: 2px solid black;
                    padding: 1px;

                }

                td.empty {
                    margin-left: auto;
                    margin-right: auto;
                    padding: 0px;
                    /* width: 20px; */
                    min-width: 14px;
                    max-width: 14px;
                    max-height: 14px;
                    min-height: 14px;
                }



                .border-top {
                    border-top: 3px solid !important;
                }

                .border-bottomm {
                    border-bottom: 3px solid !important;
                }


                .turno-1 {
                    border: 0.02px dashed black !important;
                }

                .turno-2 {
                    border: 0.02px dashed black !important;
                }

                .turno-3 {
                    border-left: 0.02px dashed black !important;
                    border-top: 0.02px dashed black !important;
                    border-bottom: 0.02px dashed black !important;
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

                .text-rango {
                    /* font-size: 20px !important; */
                    font-weight: bold !important;
                    padding-top: 5px;
                    padding-bottom: 5px;
                }

                .dot {
                    /* max-height: 20px;
                              max-width: 10px; */
                    /* font-size: 20px;
                              text-align: center !important; */
                    /* font-size: 38px;
                              text-align: center !important;
                              /* padding: 0px; */
                    /* margin: 0px; 
                              height: 0px;
                              */

                    /* padding-left: 9px;
                              padding-bottom: 11px; */

                }

                .dot-div::before {
                    content: '';
                    display: inline-block;
                    width: 10px;
                    height: 10px;
                    -moz-border-radius: 7.5px;
                    -webkit-border-radius: 7.5px;
                    border-radius: 7.5px;
                    z-index: 100;
                    position: absolute;
                    /* background-color: #69b6d5; */
                }

                .dot-div {
                    position: relative;
                    /* top: 10px; */
                    left: 8.7px;
                    min-height: 0px;
                    max-height: 0px;
                    cursor: pointer;
                }

                .dot-div:hover {
                    background-color: rgb(0 175 170 / 60%)
                }


                /* .dot-div::after {
                              background-color: #ffa209;
                              border-radius: 50%;
                          } */

                .dot-blue::before {
                    background-color: blue;
                }

                .dot-mostaza::before {
                    background-color: #ffa209;
                }

                canvas {
                    position: absolute;
                    top: 42.4px;
                    left: 31px;
                    pointer-events: none;
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

                /* .table--container {

                              display: flex !important;
                              justify-content: center;
                          } */

                .container {
                    display: flex !important;
                    justify-content: center;
                    margin-left: auto;
                    margin-right: auto;
                }

                .bg-grey {
                    background-color: #d8dfe1;

                }
            </style>
        </head>

        <div>


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
                            echo "<th class='diaHeader' colspan='3'>" . $i . "</th>";
                        }
                        ?>
                    </tr>


                    <?php
                    $url = "http://localhost/practicantes/api/temperatura_api.php";
                    // Los datos de formulario
                    $datos = [
                        "api" => 7,
                        "folio" => 1,
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


                    $max = $array['response']['data']['EQUIPO']['INTERVALO_MAX'];
                    $min = $array['response']['data']['EQUIPO']['INTERVALO_MIN'];

                    $valores = $array['response']['data']['DIAS'];

                    $dotInicial =  array_key_first($valores);
                    $dotEnd =  array_key_last($valores);

                    function redondear($valor, $valorAprox, $max, $min)
                    {

                        $explode = explode('.', $valor);

                        // $signo = $explode[0] > 0 ? '' : '-';
                        // $unidad = $explode[0] > 0 ? $explode[0]  : ($explode[0] * -1);
                        // $decimal = $explode[1] > 50 ? 1 : 0;

                        // $valor_final = ($unidad + ($decimal));


                        //10px - 40px
                        //100% = 30px
                        //0.34
                        //30*0.34 = ?
                        //

                        if ($valor >= $max) {
                            $pixeles = 10;
                            $explode[0] = $max;
                        }

                        if ($valor <= $min) {
                            $pixeles = 10;
                            $explode[0] = $min;
                        }


                        if ($valor > 0 && $explode[1] > 0) {
                            $pixeles = (($explode[1] / 100) * 30) + 10;

                            $pixeles = (($pixeles) - ($pixeles * 0.8)) * -1;
                        } else {
                            $pixeles = (($explode[1] / 100) * 30) + 10;
                        }




                        # 3 / 100 =0.03
                        # 0.03 * 30 = 0.9
                        # 0.9 + 1- = 10.9


                        // $pixeles = $valor > 0 ? ($pixeles * -1) + ($pixeles * 0.8) : $pixeles;



                        return [$explode[0], $pixeles . "px"];


                        // return $explode[0];
                    }

                    function metodoCalculo($dia, $turno, $valorAprox)
                    {
                        global $valores;
                        global $max;
                        global $min;
                        if (isset($valores[$dia]) && isset($valores[$dia][$turno])) {
                            // $valor = floatval($valores[$dia][$turno]["valor"]);
                            // $valor_redondeado = round($valor);
                            $valor = $valores[$dia][$turno]["valor"];
                            $valor_turno = redondear($valores[$dia][$turno]["valor"], $valorAprox, $max + 5, $min - 5);
                            $valor_redondeado = $valor_turno[0];
                            $valor_decimal_px = $valor_turno[1];

                            $color = $valores[$dia][$turno]['color'];
                            $id = $valores[$dia][$turno]['id'];
                            if ($valor_redondeado == $valorAprox) {
                                $dotId = "dot-$dia-$turno"; // Generar el ID del dot

                                if ($valorAprox <= ($max - 1) && $valorAprox >= $min) {
                                    return "<td class='td-hover bg-grey empty turno-$turno'  data_id='$id'><div id='$dotId' class='dot dot-div dot-$color' style='top:$valor_decimal_px' data-bs-toggle='tooltip' data-bs-placement='top' title='$valor °C'></div></td>";
                                } else {
                                    return "<td class='td-hover empty turno-$turno'  data_id='$id'><div id='$dotId' class='dot dot-div dot-$color' style='top:$valor_decimal_px' data-bs-toggle='tooltip' data-bs-placement='top' title='$valor °C'></div></td>";
                                }
                            }
                        }

                        if ($valorAprox <= ($max - 1) && $valorAprox >= $min) {
                            return "<td class='bg-grey empty turno-$turno'></td>";
                        } else {
                            return "<td class='empty turno-$turno background$valorAprox'></td>";
                        }
                    }

                    // Generar las celdas de la tabla
                    for ($j = $max + 5; $j >= $min - 5; $j--) {
                        if ($j == $max) {
                            echo "<tr class='border-bottomm'>";
                        } else if ($j == $min) {
                            echo "<tr class='border-bottomm'>";
                        } else {
                            echo "<tr class='border$j'>";
                        }


                        if ($j == $max) {
                            echo "<th class='celdasDias text-rango'>" . $j . "</th>";
                        } else if ($j == $min) {
                            echo "<th class='celdasDias text-rango'>" . $j . "</th>";
                        } else {
                            echo "<th class='celdasDias text$j'>" . $j . "</th>";
                        }

                        $prevDot = null; // Dot previo para conectar con líneas

                        for ($i = 1; $i <= 31; $i++) {
                            echo metodoCalculo($i, 1, $j);
                            echo metodoCalculo($i, 2, $j);
                            echo metodoCalculo($i, 3, $j);
                            /* $dot3 = metodoCalculo($i, 3, $j); */
                        }
                        echo "</tr>";
                    }

                    echo "<tr class='border$j'>";
                    echo "<th class='celdasDias text$j'>" . $j . "</th>";
                    for ($i = 1; $i <= 31; $i++) {
                        echo "<td class='empty turno-1 background'></td>";
                        echo "<td class='empty turno-2 background'></td>";
                        echo "<td class='empty turno-3 background'></td>";
                    }
                    echo "</tr>";
                    ?>
                </table>


                <canvas id="canvas"></canvas>
            </div>


        </div>

    </div>

    <div id="copia_body">

    </div>
</body>

<button id="click-btn">Crear linea</button>
<button onclick="exportarComoImagen()">Exportar como imagen</button>

<script>
    $('#click-btn').click(function() {

    })

    window.addEventListener("load", function() {
        console.log("asdklsadljsas")
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
            dotInicial = <?php echo array_key_first($valores); ?>;

            prevDot = `dot-<?php echo array_key_first($valores) ?>-<?php echo array_key_first($valores[array_key_first($valores)]) ?>`;
            dotLast = <?php echo array_key_last($valores); ?>;
            prevDot = document.getElementById(prevDot);

            // for (var i = dotInicial; typeof(prevDot) != "object"; i++) {
            //     console.log(i)
            //     // console.log("si entro")
            //     for (var j = 1; j <= 2; j++) {
            //         console.log(document.getElementById('dot-' + i + '-' + j))
            //         prevDot = document.getElementById('dot-' + i + '-' + j);

            //         if (typeof(prevDot) == "object") {
            //             // prevDot = document.getElementById('dot-' + i + '-' + j)
            //             console.log(prevDot)
            //             j = 3
            //         }

            //     }

            // }

            // console.log(prevDot)

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
</script>

<canvas id="miCanvas"></canvas>


<script>
    function exportarComoImagen() {
        const elemento = document.getElementById("elemento-a-exportar");

        // Guarda el valor actual de 'display' del elemento
        const displayAnterior = elemento.style.display;

        // Cambia el valor de 'display' para que el elemento sea visible
        elemento.style.display = "block";

        html2canvas(elemento).then(function(canvas) {
            // Restaura el valor anterior de 'display'
            elemento.style.display = displayAnterior;

            // Crea un elemento <a> para descargar la imagen
            const enlace = document.createElement('a');
            enlace.href = canvas.toDataURL(); // Obtiene la URL de la imagen
            enlace.download = 'exportacion.png'; // Nombre del archivo de descarga

            // Simula un clic en el enlace para descargar la imagen
            enlace.click();
        });
    }
</script>



</html>