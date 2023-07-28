<?php
require_once "../clases/master_class.php";




$response = "";
// $master = new Master();

// $servicios = [
//     [
//         //Subir servicio
//         'descripcion' => 'HORA DE EMISIÓN',
//         'medida_id' => null,

//         //Valores de referencia 
//         'valor_minimo' => 'PROCESAMIENTO INMEDIATO',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'HORA DE INICIO DEL EXAMEN',
//         'medida_id' => null,

//         //Valores de referencia 
//         'valor_minimo' => 'PROCESAMIENTO INMEDIATO',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'ASPECTO',
//         'medida_id' => null,

//         //Valores de referencia 
//         'valor_minimo' => 'LIGERAMENTE TURBIO',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'COLOR',
//         'medida_id' => null,

//         //Valores de referencia 
//         'valor_minimo' => 'BLANCO GRISASEO',
//         'valor_maximo' => 'BLANCO AMARILLENTO',


//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'pH',
//         'medida_id' => null,

//         //Valores de referencia 
//         'valor_minimo' => '&gt;=  7.2',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'TURBIDEZ',
//         'medida_id' => null,

//         //Valores de referencia 
//         'valor_minimo' => 'MARCADA',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'VISCOCIDAD',
//         'medida_id' => 9,

//         //Valores de referencia 
//         'valor_minimo' => '&lt; 2 CM',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'VOLUMEN',
//         'medida_id' => 77,

//         //Valores de referencia 
//         'valor_minimo' => '1.4',
//         'valor_maximo' => '4.0',


//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'LICUEFACCIÓN',
//         'medida_id' => 76,

//         //Valores de referencia 
//         'valor_minimo' => 'TOTAL A LOS 60 MIN',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'MOTILIDAD PROGRESIVA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => '31%',
//         'valor_maximo' => '34%',

//     ],


//     [
//         //Subir servicio
//         'descripcion' => 'MOTILIDAD NO PROGRESIVA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => '&lt;= 8%',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'MOTILIDAD TOTAL',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => '38%',
//         'valor_maximo' => '42%',

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'INMOVILES',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => '&lt;= 38%',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'MACROCEFALIA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'MICROCEFALIA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'CABEZA ALARGADA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'DOBLE CABEZA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'DOBLE COLA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'COLA CORTA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'COLA LARGA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],


//     [
//         //Subir servicio
//         'descripcion' => 'NORMALES',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'ESPERMATOZOIDES MUERTOS',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => '< 43%',
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'ESPERMATOZOIDES VIVOS MOVILES',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => '55%',
//         'valor_maximo' => '63%',

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'ESPERMATOZOIDES POR MILILITRO',
//         'medida_id' => 77,

//         //Valores de referencia 
//         'valor_minimo' => '12',
//         'valor_maximo' => '15 X10^6 ML',

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'ESPERMATOZOIDES POR EYACULACIÓN',
//         'medida_id' => null,

//         //Valores de referencia 
//         'valor_minimo' => '33',
//         'valor_maximo' => '46 X10^6',

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'AGLUTINACION CABEZA CON CABEZA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'AGLUTINACION SEGMENTO',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'INTERMEDIO CON SEGMENTO',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'INTERMEDIO',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'AGUTINACION COLA CON COLA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],


//     [
//         //Subir servicio
//         'descripcion' => 'AGLUTINACION MIXTA',
//         'medida_id' => 17,

//         //Valores de referencia 
//         'valor_minimo' => null,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'LEUCOCITOS',
//         'medida_id' => 159,

//         //Valores de referencia 
//         'valor_minimo' => 0,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'ERITROCITOS',
//         'medida_id' => 159,

//         //Valores de referencia 
//         'valor_minimo' => 0,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'CELULAS EPITELIALES',
//         'medida_id' => 159,

//         //Valores de referencia 
//         'valor_minimo' => 0,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'BACTERIAS',
//         'medida_id' => 159,

//         //Valores de referencia 
//         'valor_minimo' => 0,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'CRISTALES',
//         'medida_id' => 159,

//         //Valores de referencia 
//         'valor_minimo' => 0,
//         'valor_maximo' => null,

//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'OTROS',
//         'medida_id' => 159,

//         //Valores de referencia 
//         'valor_minimo' => 0,
//         'valor_maximo' => null,

//     ],
// ];



$servicios = [
    // [
    //     //Subir servicio
    //     'descripcion' => 'CAPTACION DE FIJACIÓN DE HIERRO',
    //     'medida_id' => null,

    //     //Valores de referencia 
    //     'valor_minimo' => null,
    //     'valor_maximo' => null,
    // ],
    // [
    //     //Subir servicio
    //     'descripcion' => 'INDICE DE SATURACIÓN',
    //     'medida_id' => null,

    //     //Valores de referencia 
    //     'valor_minimo' => null,
    //     'valor_maximo' => null,
    // ],
    // [
    //     //Subir servicio
    //     'descripcion' => 'TRANSFERRINA',
    //     'medida_id' => null,

    //     //Valores de referencia 
    //     'valor_minimo' => null,
    //     'valor_maximo' => null,
    // ]
];

// $orden = 1;
// $id = 150; #HIerro serico

// agregarGrupoExamen([
//     $grupo_id,
//     $id,
//     $orden
// ]);


// agregarContenedorExamenes([
//     $id,
//     4,
//     6
// ]);


// $serviciosSolos = [
//     [
//         //Subir servicio
//         'descripcion' => '25-HIDROXI VITAMINA D',
//         'id' => 680,
//         'medida_id' => 94,
//         'clasificacion_id' => 6,

//         //Valores de referencia 
//         'valor_minimo' => 20,
//         'valor_maximo' => 40,
//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'VITAMINA B12',
//         'id' => 681,
//         'medida_id' => 94,
//         'clasificacion_id' => 6,

//         //Valores de referencia 
//         'valor_minimo' => '&gt;20',
//         'valor_maximo' => null,
//     ],
//     [
//         //Subir servicio
//         'descripcion' => 'ACIDO FÓLICO',
//         'id' => 682,
//         'medida_id' => 94,
//         'clasificacion_id' => 6,

//         //Valores de referencia 
//         'valor_minimo' => '2.7',
//         'valor_maximo' => '17.0',
//     ],

// ];

$servicios = [
    [
        'descripcion' => 'Valor CT N1',
        'grupo_id' => [684]
    ],
    [
        'descripcion' => 'Valor CT N2',
        'grupo_id' => [684, 685]
    ],
    [
        'descripcion' => 'Valor CT N3',
        'grupo_id' => [684]
    ],
    [
        'descripcion' => 'RP',
        'grupo_id' => [684, 685]
    ],
    [
        'descripcion' => 'Influenza A',
        'grupo_id' => [685]
    ],
    [
        'descripcion' => 'Influenza B',
        'grupo_id' => [685]
    ],
    [
        'descripcion' => 'Kit de diagnóstico',
        'grupo_id' => [684, 685]
    ],
    [
        'descripcion' => 'Número de aurotrización',
        'grupo_id' => [684, 685]
    ],
    [
        'descripcion' => 'No. lote',
        'grupo_id' => [684, 685]
    ],
    [
        'descripcion' => 'Tipo de muestra',
        'grupo_id' => [684, 685]
    ]
];


$area = 12;
// $clasificacion_id = 2;
$grupo_id = 684;

$orden = 1;
foreach ($servicios as $key => $value) {
    $id = agregarServicio([
        null,
        $value['descripcion'],
        null,
        $area,
        null,
        null,
        null,

        1,
        null,
        null,
        1,
        1,

        0,
        0,
        null,
        'TODOS',
        1,
        1,
        1
    ]);

    foreach ($value['grupo_id'] as $key => $value) {
        agregarGrupoExamen([
            $value,
            $id,
            $orden
        ]);
    }

    $orden++;



    // agregarContenedorExamenes([
    //     $id,
    //     1,
    //     4
    // ]);

    // agregarValoresReferencia([
    //     null,
    //     $value['id'],
    //     $value['valor_minimo'],
    //     $value['valor_maximo'],
    //     'HOMBRE',
    //     1,
    //     100,
    //     null
    // ]);
}


// $id = agregarServicio([
//     null,
//     'ZINC',
//     null,
//     $area,
//     2,
//     null,
//     13,

//     1,
//     null,
//     null,
//     1,
//     1,

//     0,
//     0,
//     null,
//     'TODOS',
//     1,
//     1,
//     1
// ]);

// agregarContenedorExamenes([
//     $id,
//     1,
//     4
// ]);

// agregarValoresReferencia([
//     null,
//     $id,
//     'NIÑO 9 - 13 AÑOS                     8mg<br>ADOLECENTES 14 - 18 AÑOS  11mg<br>NIÑAS ADOLECENTES 14 - 18 AÑOS     9mg<br>ADULTOS                                       11mg',
//     null,
//     1,
//     1,
//     100,
//     null
// ]);

// NIÑO 9 - 13 AÑOS  8mg                                   
// ADOLECENTES 14 - 18 AÑOS  11mg                               
// NIÑAS ADOLECENTES 14 - 18 AÑOS     9mg                     
// ADULTOS  11mg









// echo 1;

// $orden = 1;
// foreach ($servicios as $key => $value) {
//     echo 1;
//     $id = agregarServicio([
//         null,
//         $value['descripcion'],
//         null,
//         $area,
//         $clasificacion_id,
//         null,
//         $value['medida_id'],

//         1,
//         null,
//         null,
//         1,
//         1,

//         0,
//         0,
//         null,
//         'Hombre',
//         1,
//         1,
//         1
//     ]);


//     echo $id . '</br>';

//     agregarGrupoExamen([
//         $grupo_id,
//         $id,
//         $orden
//     ]);


//     agregarValoresReferencia([
//         null,
//         $id,
//         $value['valor_minimo'],
//         $value['valor_maximo'],
//         'HOMBRE',
//         1,
//         100,
//         null
//     ]);


//     foreach ($metodos as $key2 => $idMetodo) {
//         agregarMetodo([
//             $idMetodo,
//             $id
//         ]);
//     }



//     agregarEquipoExamenes([
//         null,
//         7,
//         $id
//     ]);


//     agregarContenedorExamenes([
//         $id,
//         1,
//         4
//     ]);



//     // echo $id;
//     // print_r($id);

//     $orden++;
//     sleep(5);
// };


// foreach ($metodos as $key2 => $idMetodo) {
//     agregarMetodo([
//         $idMetodo,
//         305
//     ]);
// }

// agregarEquipoExamenes([
//     null,
//     7,
//     305
// ]);


// function agregarServicio($parametros)
// {
//     $master = new Master();
//     $response = $master->insertByProcedure('sp_servicios_g', $parametros);
//     return $response;
// }

// function agregarGrupoExamen($parametros) #Pueden ser vacios
// {
//     $master = new Master();
//     $response = $master->insertByProcedure('sp_detalle_grupo_g', $parametros);
//     echo "Grupo </br>";
// }

// function agregarValoresReferencia($parametros)
// {
//     $master = new Master();
//     $response = $master->insertByProcedure('sp_laboratorio_valores_referencia_g', $parametros);
//     // echo $response;
//     echo "referencia </br>";
// }

// function agregarMetodo($parametros) #pueden ser varios
// {
//     $master = new Master();
//     $master->insertByProcedure('sp_laboratorio_metodo_servicio_g', $parametros);
//     echo "metodo </br>";
// }

// function agregarEquipoExamenes($paramEX)
// {
//     $master = new Master();
//     $master->insertByProcedure('sp_equipos_examenes_g', $paramEX);
//     echo "Equipo </br>";
// }


// function agregarContenedorExamenes($parametros)
// {
//     $master = new Master();
//     $master->insertByProcedure('sp_contenedores_examenes_g', $parametros);
//     echo "Contenedor </br>";
// }
