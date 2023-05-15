<?php

// $url = "bimo-lab.com";
// $https = 'https://';
// $url = "localhost";
$https = 'http://';

// $url = $_SERVER['HTTP_HOST'];
switch ($_SERVER['HTTP_HOST']) {
    default:
        $url = 'localhost';
        break;
}

$appname = "practicantes";
// echo $appname;

// echo $url;
// exit;
