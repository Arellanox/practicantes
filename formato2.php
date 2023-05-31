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
            /* border: 1px solid black; */
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
            font-size: 20px !important;
            font-weight: bold !important;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .dot {
            font-size: 20px
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
                2 => array("valor" => "-25.1"),
                3 => array("valor" => "-38.6")
            ),
            2 => array(
                1 => array("valor" => "-30.1"),
                2 => array("valor" => "-25.1"),
                3 => array("valor" => "-38.6")
            ),
            21 => array(
                1 => array("valor" => "-33"),
                2 => array("valor" => "-20"),
                3 => array("valor" => "-21")
            )
        );

        function metodoCalculo($dia, $turno, $valorAprox)
        {
            global $valores;
            if (isset($valores[$dia]) && isset($valores[$dia][$turno])) {
                $valor = floatval($valores[$dia][$turno]["valor"]);
                $valor_redondeado = round($valor);
                if ($valor_redondeado == $valorAprox) {
                    return "<td class='empty turno-$turno background$valorAprox dot' id='dot-$dia-$turno'>&#8226;</td>";
                }
            }
            return "<td class='empty turno-$turno background$valorAprox'></td>";
        }

        for ($j = -40; $j <= -20; $j++) {
            echo "<tr class='border$j'>";



            echo "<th class='celdasDias text$j'>" . $j . "</th>";


            for ($i = 1; $i <= 31; $i++) {
                echo metodoCalculo($i, 1, $j);
                echo metodoCalculo($i, 2, $j);
                echo metodoCalculo($i, 3, $j);
            }
            echo "</tr>";
        }
        ?>
    </table>


    <canvas id="canvas"></canvas>
</body>
<script>
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    function connectDots(dot1, dot2) {
        var rect1 = dot1.getBoundingClientRect();
        var rect2 = dot2.getBoundingClientRect();
        var x1 = rect1.left + rect1.width / 2;
        var y1 = rect1.top + rect1.height / 2;
        var x2 = rect2.left + rect2.width / 2;
        var y2 = rect2.top + rect2.height / 2;

        ctx.beginPath();
        ctx.moveTo(x1, y1);
        ctx.lineTo(x2, y2);
        ctx.stroke();
    }

    var dot1 = document.getElementById('dot-1-1');
    var dot2 = document.getElementById('dot-2-2');

    connectDots(dot1, dot2);
</script>

</html>