<?php
// URL del archivo en el servidor
$url = 'http://localhost/nuevo_checkup/pdf/views/invoice/includes/temperatura_tabla.php';

// Datos a enviar en la solicitud POST
$data = array(
    'parametro1' => 'valor1',
    'parametro2' => 'valor2'
);

// Inicializar una sesión cURL
$ch = curl_init();

// Establecer la URL de la solicitud
curl_setopt($ch, CURLOPT_URL, $url);

// Establecer el método de la solicitud como POST
curl_setopt($ch, CURLOPT_POST, 1);

// Establecer los datos a enviar en la solicitud POST
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Cerrar la sesión cURL
curl_close($ch);

// Hacer algo con la respuesta recibida
echo $response;
