<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";

session_start();
$titolo = "Crea preventivo - EdilScavi";
$descrizione= "Crea un preventivo per i lavori di scavo ed edilizia con EdilScavi Srl.";
$keywords = "preventivo, scavi, edilizia, scavi brescia, lavori edilizi";

if (AuthController::isLogged()) {
    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
    echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "crea_preventivo.html");
    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
}
else
{
    $_SESSION['intended-messages'] = "Esegui il login per creare un preventivo.";
    $_SESSION['intendedRoute'] = "crea_preventivo.php";
    $_SESSION['intendedEdited'] = "True";
    header(header: 'Location:accedi.php');
}
