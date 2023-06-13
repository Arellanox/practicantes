<!-- <div class="col-12 loader" id="loader" style="">
    <div class="preloader" id="preloader"> </div>
</div> -->



<div class="row">
    <!-- <div class="col-lg-3" id="formularioDesktopTemperatura">
        <div class="card mt-3 p-3">
            <p class=" my-2">Los datos como la <strong>fecha de captura</strong> y el
                <strong>usuario</strong> que lo hizo que realizo la
                captura <strong>se
                    agregan automaticamente.</strong>
            </p>
            <form id="formCapturarTemperatura" name="formCapturarTemperatura">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="mb-3">
                            <label for="Enfriador" class="form-label">Enfriador:</label>
                            <select class="form-select input-form" name="Enfriador" id="Enfriador">
                                <option selected>Eliga un enfriador</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="mb-3">
                            <label for="Termometro" class="form-label">Termometro:</label>
                            <select class="form-select input-form" name="Termometro" id="Termometro">
                                <option selected>Eliga un termometro</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="mb-3">
                            <label for="enfriadorMarca">Marca del enfriador:</label>
                            <input type="text" name="enfriadorMarca" value="" class="form-control input-form"
                                id="enfriadorMarca" readonly disabled>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="mb-3">
                            <label for="termometroMarca">Marca del termometro:</label>
                            <input type="text" name="termometroMarca" value="" class="form-control input-form"
                                id="termometroMarca" readonly disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="mb-3">
                            <label for="intervalo">Intevalo Optimo:</label>
                            <input type="text" name="intervalo" value="" class="form-control input-form" id="intervalo"
                                readonly disabled>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="mb-3">
                            <label for="lectura">Lectura:</label>
                            <input type="number" name="lectura" value="" class="form-control input-form" required
                                id="lectura">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 ">
                        <div class="mb-3">
                            <label for="observaciones">Observaciones:</label>
                            <input type="text" name="observaciones" value="" class="form-control input-form" required
                                id="observaciones">
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 d-flex align-self-center my-auto mb-3">
                        <p id="usuarioQueCargar"></p>
                    </div>
                </div>
            </form>
            <button type="submit" form="formCapturarTemperatura" class="btn btn-confirmar" id="btn-subir-temperatura">
                <i class="bi bi-person-x"></i> Subir
            </button>
        </div>
    </div> -->

    <div class="col-12 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3 p-3" id="lista-pacientes">
                    <h5>Lista de Equipos Enfriadores</h5>

                    <form name="EquiposTemperaturasForm" id="EquiposTemperaturasForm">
                        <div class="mb-3">
                            <label for="Equipo" class="form-label">Equipo:</label>
                            <select class="form-select input-form" name="Equipo" id="Equipo" required>
                                <option selected>Eliga un equipo</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" form="EquiposTemperaturasForm" class=" btn btn-confirmar" id="btn-equipo-temperatura">
                                <i class="bi bi-person-x"></i> Mostrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card mt-3 p-3">
                    <h5>Agregar Nueva Lectura</h5>
                    <form id="formCapturarTemperatura" name="formCapturarTemperatura" enctype="multipart/form-data">

                    </form>
                </div>
            </div>
        </div>
        <div class="row" id="lista-meses-temperatura" style="">
            <div class=" col-12" style="margin-right: -5px !important;">
                <div class="card mt-3 p-3 ">
                    <h5>Lista de Registro de Temperaturas</h5>

                    <!-- Control de turnos -->
                    <div id="turnos_panel"></div>
                    <table class="table display responsive" id="TablaTemperaturasFolio" style="width: 100%">
                        <thead class="">
                            <tr>
                                <th scope="col d-flex justify-content-center" class="all">#</th>
                                <th scope="col d-flex justify-content-center" class="all">Descripcion</th>
                                <th scope="col d-flex justify-content-center" class="min-tablet">Folio</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-9 informacion-temperatura" style="margin-right: -5px !important;">

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card mt-3 p-3">
                    <h5>Lista de Equipos Enfriadores</h5>

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
            </div>
        </div>
        <!-- <div class="col-12 col-lg-9 informacion-temperatura" style="margin-right: -5px !important; display: none;">
        <div class="card mt-3 p-3" id="TablaTemperaturaDia">
            <table class="table table-hover display responsive" id="TablaTemperatura" style="width: 100%;"></table>
        </div> -->


    </div>
    <!-- <div class="col-12 col-lg-9  d-flex justify-content-center align-items-center" id='loaderDivtemperatura'
        style="max-height: 75vh; display: none; ">
        <div class="preloader" id="loader-temperatura"></div>
    </div> -->

</div>


<style media="screen">
    /*    #TablaTemperaturasFolio_filter {
        display: none
    } */

    /* #capturarTemperatura {
        display: none;
    }
 */
    @media (max-width: 768px) {

        /*  #capturarTemperatura {
            display: contents;
        }
 */
        #formularioDesktopTemperatura {
            display: none;
        }
    }


    #grafica table {
        border-collapse: collapse;
    }

    #grafica th,
    #grafica td {
        border: 2px solid black;
        padding: 1px;

    }

    #grafica td.empty {
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

    /* .turno-2 {
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

    #grafica canvas {
        position: absolute;
        top: 0;
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
    }

    .container {
        display: flex !important;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
    }

    ;
</style>