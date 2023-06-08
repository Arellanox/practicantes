<?php
function getHtml()
{
    ob_start();
    // include $_SERVER["DOCUMENT_ROOT"]."/views/$view_name";
    include "formato3.php";
    return ob_get_clean();
}

echo getHtml();
