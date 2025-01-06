<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";

$titolo = "Crea preventivo - EdilScavi";
$descrizione= "Crea un preventivo per i lavori di scavo ed edilizia con EdilScavi Srl!";
$keywords = "preventivo, scavi, edilizia, scavi brescia, lavori edilizi";

session_start();

if (AuthController::isLogged()) {
    session_reset();
    session_write_close();
    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
    echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "crea_preventivo.html");
    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
}
else
{
    header(header: 'Location:accedi.php?intended=crea_preventivo');
}
