<?php
 
require_once '../php/dompdf/vendor/autoload.php';
require 'View.php';
require 'Qrcode.php';


use Dompdf\Adapter\PDFLib;
use Dompdf\Dompdf;
use Dompdf\Options;

class Reporte
{

    public $response;
    public $data;
    public $pie;
    public $archivo;
    public $tipo;
    public $orden;
    public $preview;
    public $area;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct($response, $data, $pie, $archivo, $tipo, $orden, $preview = 0, $area)
    {
        $this->response = $response; //cuerpo
        $this->data     = $data; //Ecabezado
        $this->pie      = $pie; //Footer <-- Se manda folio
        $this->archivo  = $archivo; //Ruta de reporte
        $this->tipo     = $tipo; //Tipo de resultado
        $this->orden    = $orden; //Forma de visualizar
        $this->preview = $preview;
        $this->area = $area;
    }

    public function build()
    {
        $response   = json_decode($this->response);
        $data       = json_decode($this->data); //Esperando la data general
        $pie        = $this->pie;
        $archivo    = $this->archivo;
        $tipo       = $this->tipo;
        $orden      = $this->orden;
        $preview    = $this->preview;
        $area       = $this->area;

        switch ($tipo) {
            case 'etiquetas':
                $generator = null;
                $barcode = null;
                // $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                // $barcode  = base64_encode($generator->getBarcode($response->BARRAS, $generator::TYPE_CODE_128));
                // $barcode  = base64_encode($generator->getBarcode('750169978916', $generator::TYPE_CODE_128));
                break;
            case 'resultados':
            case 'biomolecular':
            case 'oftalmologia':
            case 'ultrasonido':
            case 'rayos': //rayos piu piu
            case 'consultorio':
            case 'electro':
            case 'cotizacion':
            case 'ticket':
            case 'fast_checkup':
            case 'reporte_masometria':
            case 'espirometria': //nuevo case de espirometria
            case 'temperatura':
            case 'corte':  
            case 'consultorio2': //<--Consultorio2 (Creado Angel) 
            case 'receta': //<--Receta (Creado Angel)      
                $prueba = generarQRURL($pie['clave'], $pie['folio'], $pie['modulo']);
                break;
            default:
                $barcode = null;
                break;
        }

        //$host =  $_SERVER['SERVER_NAME'] = "localhost" ? "http://localhost/practicantes/" : "https://bimo-lab.com/nuevo_checkup/";
        // $host = 'http://localhost/nuevo_checkup/';
        // Path del dominio
        $path = $archivo['ruta'] . $archivo['nombre_archivo'] . ".pdf";
        // $path    = 'pdf/public/resultados/E-00001.pdf';
        // print_r($pie['datos_medicos'][0]['ESPECIALIDADES']);
        // print_r($path);

        session_start();
        $view_vars = array(
            "resultados"            => $response,
            "encabezado"            => $data,
            "pie"                   => isset($pie) ? $pie : null,
            "qr"                    => isset($prueba) ? $prueba : null,
            "barcode"               => isset($barcode) ? $barcode : null,
            "preview"               => $preview,
            "area"                  => isset($area) ? $area : null
        );

        // print_r($view_vars['resultados']->ANAMNESIS);
        // foreach($view_vars['resultados'] as $item){
        //     print_r($item);
        //     echo "<br>";
        // }
        // exit;

        $pdf = new Dompdf();
        // Recibe la orden de que tipo de archivo quiere
        switch ($tipo) {
            case 'etiquetas':
                $template = render_view('invoice/etiquetas.php', $view_vars);
                $pdf->loadHtml($template);

                $ancho = (5 / 2.54) * 72;
                $alto  = (2.5 / 2.54) * 72;

                $pdf->setPaper(array(0, 0, $ancho, $alto), 'portrait');
                // $pdf->setPaper('letter', 'portrait');
                // $path    = 'pdf/public/etiquetas/00001.pdf';
                break;

            case 'resultados':
                $template = render_view('invoice/resultados.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                // $path    = 'pdf/public/resultados/E-00001.pdf';
                // return $path;
                break;
            case 'espirometria':
                $template = render_view('invoice/esp.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;
            case 'oftalmologia':
                $template = render_view('invoice/oftalmologia.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                // $path    = 'pdf/public/oftalmologia/E-00001.pdf';
                break;

            case 'ultrasonido':
                $template = render_view('invoice/ultrasonidos.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;

            case 'rayos':
                $template = render_view('invoice/rayos.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;

            case 'electro':
                $template = render_view('invoice/electro.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;

            case 'reporte_masometria':
                $template = render_view('invoice/reporte_masometria.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;

            case 'biomolecular':
                $template = render_view('invoice/biomolecular.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;

            case 'consultorio':
                $template = render_view('invoice/consultorio.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;

            case 'ticket':
                $template = render_view('invoice/ticket.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;

            case 'cotizaciones':
                $template = render_view('invoice/cotizaciones.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;

            case 'fast_checkup':
                $template = render_view('invoice/fast_checkup.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;
            case 'corte':
                $template = render_view('invoice/corte.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;
            case 'temperatura':
                $template = render_view('invoice/formato2.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'landscape');
                break;
            
            case 'consultorio2':
                $template = render_view('invoice/consultorio2.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                break;
            
            case 'receta':
                $template = render_view('invoice/receta.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('executive', 'landscape');
                break;    

            default:
                $template = render_view('invoice/reportes.php', $view_vars);
                $pdf->loadHtml($template);
                $pdf->setPaper('letter', 'portrait');
                // $path    = 'pdf/public/oftalmologia/E00001.pdf';
                break;
        }
        // session_destroy();
        // Recibe la orden de que tipo de  modo de visualizacion quiere
        switch ($orden) {
            case 'descargar':
                $pdf->render();
                file_put_contents('../' . $path, $pdf->output());
                return $pdf->stream();
                break;
            case 'mostrar':
                $pdf->render();
                return $pdf->stream('documento.pdf', array("Attachment" => false));
                break;
            case 'url':
                $pdf->render();
                file_put_contents('../' . $path, $pdf->output());
                //return 'https://bimo-lab.com/nuevo_checkup/' . $path;
                return "http://localhost/practicantes/" . $path;
                // print_r($path);
                // return $host . $path;
                break;
            default:
                $pdf->render();
                return $pdf->stream('documento.pdf', array("Attachment" => false));
                break;

                session_write_close();
        }
    }
}
