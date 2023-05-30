// Exploracion clinica
$('#select-exploracion-clinica').on('change', function () {
    let selectoo = $('#select-exploracion-clinica').val();
    switch (selectoo) {
        case '1':
            $("#texto-exp-cli").html(`
      Estado de conciencia. Orientación temporo-espacial. Peso. Talla. Índice de masa corporal.
      Deformidades generales, parciales o regionales. Color de piel y mucosas (palidez. cianosis, ictericia, manchas,
      estado de nutrición e hidratación, presion arterial. Pulso y frecuencia de pulso. Temperatura. `);

            break;
        case '2':
            $("#texto-exp-cli").html(`
      Cráneo: configuración y deformidades. Pelo: implante, consistencia y aspecto. Cara: simetría o asimetría. Coloración. Percusión de senos paranasales. Motilidad facial y mandibular. Implantación de cejar. •	Ojos: Globo Ocular: tamaño: exolftalmía, enoftalmía, tensión. Motilidad. Conjuntiva ocular y palpebral, escleróticas, iris, pupila, córnea, reflejo fotomotor, movimientos oculares, fondo de ojo, agudeza visual.
      •	Oídos: forma, tamaño, posición, simetría, pabellón auricular, conducto auditivo externo, membrana timpánica. Higiene, presencia de secreciones, dificultad en la audición, dolor, secreción, infección de oído, otros.
      •	Naríz: fosas nasales, senos paranasales, tamaño, posición del tabique nasal, mucosa nasal, permeabilidad, olfato, coriza, aleteo nasal, lesiones.
      •	Amígdalas y faringe: lesiones, congestión, gusto.
        `)
            break;
        case '3':
            $("#texto-exp-cli").html(`
      "Deformidades generales, parciales o regionales. Color de piel y mucosas
      (palidez. Cavidad Bucal: labios (coloración, humedad, lesiones),
      dientes (presencia de prótesis, estado de conservación, caries, piezas faltantes),
      lengua (humedad, lesiones, movimientos), paladar duro y blando (lesiones, congestión)."

`)
            break;

        case '4':
            $("#texto-exp-cli").html(`
      Aspecto, simetría, forma y tamaño (ancho y corto, delgado y largo);
      movilidad (flexión, extensión, lateralización, rotación), ingurgitación yugular,
      pulso carotideo (presencia o ausencia, simetría, intensidad), sensibilidad,
      aumentos de volumen localizados (tumores, bocio, adenopatías), masa, rigidez
      a) Tiroides: aumentado de tamaño u otras alteraciones vasculares, presencia de lóbulos.
`)
            break;

        case '5':
            $("#texto-exp-cli").html(`"Conformación Ósea: simetría, uso musculatura accesoria, retracción o abombamiento de espacios intercostales, elasticidad, expansión, movilidad de la caja torácica, dolor, masas, lesiones, cicatrices, cambios de coloración.
Mamas: tamaño, simetría, forma, lesiones de piel, pezones, areolas, retracciones, tumoraciones, conductos galactófaros, cola de Spence, tejido adiposo
Axilas: búsqueda de ganglios linfáticos de la zona. Aspecto: consistencia, tamaño, adherencia a planos profundos y movilidad así como compromiso de la piel suprayacente."
`)
            break;

        case '6':
            $("#texto-exp-cli").html(`"Frecuencia respiratoria, movimientos respiratorios, expansibilidad torácica, ritmo respiratorio, describir el tipo, quejido, estridor, tiraje, abovedamientos, retracciones.
Expansibilidad torácica, vibraciones vocales (conservados, aumentados, disminuidas o abolidas).
Sonoridad pulmonar normal, hipersonoridad, timpanismo, submatidez, matidez. Murmullo vesicular (normal, disminuido, ausente), ruidos adventicios o estertores, auscultación de la tos, auscultación de la voz (pectoriloquia, broncofonia)."
`)
            break;

        case '7':
            $("#texto-exp-cli").html(`"
a)	Área Periférica: característica del pulso radial: sincronismo, amplitud, intensidad, determinar la presencia o ausencia de pulsos periféricos o disminución de la amplitud de los mismos (pulsos temporales superficiales, carotídeos, humerales, radiales, femorales, poplíteos, tibiales posteriores, pedios); Precisar la presencia de várices o microvárices.
b)	Área Central:
Ictus cordis: localización, extensión, intensidad, determinar los ruidos cardiacos en los focos de auscultación (punta, nórtico, pulmonar, tricuspideo y mosocardio). Precisar la presencia de: ritmo de galope, chasquido de apertura de la mitral, acentuación o desdoblamiento de los ruidos, clicks, soplos, arrastre. En el caso de soplos deben precisarse sus características (momento, localización, intensidad, tono, timbre, irradiación y modificación con diferentes maniobras)."
`)
            break;

        case '8':
            $("#texto-exp-cli").html(`Aspecto, simetría,
       abombamientos, circulación colateral,
       cicatrices, ombligo, *Maniobra de Valsalva, hernias, eventraciones. Dolor, tumoraciones,
       visceromegalias, signo de irritación peritoneal.
        Ascitis, distensión por gases, globo vesical, tumores de la pared o intraabdominal,
        sonoridad normal. Ruidos hidroaéreos (aumentados, disminuidos o ausentes).`);
            break;

        case '9':
            $("#texto-exp-cli").html(`Adenopatías inguinales (número, tamaño, consistencia, movilidad, adherencia a piel o planos profundos, sensibilidad y dolor, color de la piel que las recubre.
`)
            break;

        case '10':
            $("#texto-exp-cli").html(`"1.	Puñopercusión de fosas lumbares: aumento de volumen, cambios inflamatorios, dolorosa o no. 2.	Genitales Femeninos
Se comienzan examinando los genitales externos, observando caracteres sexuales secundarios, aspectos de labios mayores y menores, desarrollo del clítoris, desembocadura de la uretra, coloración de la mucosa e identificar si existe alguna lesión o abultamiento localizado anormal.  Inspección de región peri anal, lesiones, tumores, vesículas, fístulas. Secresiones: determinar características, color, fetidez y cantidad.
3) Genitales Masculinos:
Distribución pilosa, pene, prepucio, glande, bolsas escrotales, testículos, cordón espermático, próstata, etc."
`)
            break;

        case '11':
            $("#texto-exp-cli").html(`"Menarca. Fecha de última menstruación. Número de gestaciones. Partos. Cesareas. Abortos. Inicio de vida sexual. Método de planificación familiar.
"
`)
            break;

        case '12':
            $("#texto-exp-cli").html(`"Coloración general y sus alteraciones: palidez, rubicundez, cianosis, coloración amarilla (ictericia y seudoictericia), melanodermia.
Superficie: lustrosidad, humedad, descamaciones, grosor, nevos, efélides, manchas, pliegues, estrias, estado trófico, etc.
Faneras: pelo (cantidad, distribución, implantación, calidad, color, largo, grosor, resistencia), uñas (forma, aspecto, resistencia, crecimiento y color).
Tejido celular subcutáneo: determinar si está infiltrado o no por edema, mixedema o enfisema subcutáneo, características (distribución, color, temperatura, sensibilidad y consistencia)"
`)
            break;

        case '13':
            $("#texto-exp-cli").html(`"Ganglios Linfáticos: palpación meticulosa de las regiones ganglionares (retroauriculares, occipitales, submentonianas, submaxilares, cervicales, supraclaviculares, axilares, epitrocleares, inguinales), forma, consistencia, delimitación, movilidad, sensibilidad o dolor.
Hígado: normalmente no visible a la inspección, pero presumible por abombamiento del hipocondrio derecho. Se explora a la palpación superficial y profunda para determinar el tamaño, la consistencia, característica de su superficie si es lisa o nodular, delimitación de los bordes, etc.
Bazo: aumento de volumen del hipocondrio izquierdo (en grandes esplenomegalias). Realice la palpación en posición de Schuster, búsqueda de manifestaciones hemorrágicas: petequias, equimosis, vibices, hematomas, etc."
`)
            break;

        case '14':
            $("#texto-exp-cli").html(`"Columna Vertebral: determine la presencia de cifosis, lordosis, escoliosis, cifoescoliosis, palpación de las apófisis espinosas en busca de dolor y de los puntos entre dos apófisis espinosas (a 2 cm. a ambos lados de la línea media).
Articulaciones: precisar aumento de volumen, deformidad, cambios de coloración, grado de flexión y extensión, desviaciones articulares en uno u otro sentido, etc.
Miembros: aspecto, simetría	Motilidad: activa, pasiva
Músculos: volumen muscular, atrofias, tumoraciones, simetría, forma y movimiento, dolor consistencia."
`)
            break;

        case '15':
            $("#texto-exp-cli").html(`

"Estado de Conciencia: lúcido/a, desorientado/a en tiempo o espacio, somnoliento/a, obnubilado/a, estuporoso/a,
Escala de Glasgow. Lenguaje y habla: afasia y disfasias, disartria y anartria, polilalia, bradilalia y ecolalia.
Marcha: aspectos fundamentales a precisar en la marcha del paciente.
-	Capacidad de flexión y extensión de los segmentos de las extremidades inferiores.
-	Movimientos coordinados entre las extremidades superiores y el tronco.
-	Marcha en línea recta o no
-	Si el enfermo mira hacia delante, si mira al suelo y donde pone los pies o un punto fijo.
-	Si la marcha es rápida o lenta.
-	Si aumenta la base de sustentación.
-	Si al deambular apoya primero el talón o la punta del pie.
Tono y Trofismo muscular: aspecto, consistencia, relieve, contorno aumentado o disminuido, actitud de las extremidades. Resistencia de los músculos a la manipulación pasiva de los miembros, tronco y cabeza. El tono muscular puede estar normal, aumentado (hipertonía), disminuido (hipotonía), recurrir a la medición para identificar atrofia muscular. Pares Craneales: I-II-III-IV-V-VI-VII-VIII rama coclear y vestibular IX-X-XI-XII. Reflejos: cutáneos, osteotendinosos, clonus
Signos Meníngeos: rigidez de la nuca, Kernig, Brudzinski."

`)
            break;

        default:
            $("#texto-exp-cli").html(`Aqui se Mostrara Mas informacion`);
    }
})