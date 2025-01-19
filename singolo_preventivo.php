<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "PreventivoController.php";

session_start();
$titolo = "Singolo preventivo - Edil Scavi";
$descrizione = "Singolo preventivo per i lavori di scavi e edilizia con Edil Scavi";
$keywords = "preventivi, scavi, edilizia, scavi brescia, lavori edilizi";

$template = file_get_contents(filename: __DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "singolo_preventivo.html");

if(AuthController::isAdmin())
{
    $preventivo = PreventivoController::getSingoloPreventivo();
    $template = str_replace("<!--VistaPreventivi-->", $preventivo, $template);
}
session_write_close();
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo $template;
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";

