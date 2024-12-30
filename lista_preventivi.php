<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";

session_start();
$titolo = "Lista preventivi - EdilScavi";
$descrizione = "Lista dei tuoi preventivi per i lavori di scavi e edilizia con EdilScavi";
$keywords = "preventivi, scavi, edilizia, scavi brescia, lavori edilizi";
if (AuthController::isLogged()) {
    session_write_close();
    session_abort();

    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
    echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "lista_preventivi.html");
    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
}
else
{
    $_SESSION['intended-messages'] = "Esegui il login per visualizzare la lista dei preventivi.";
    header(header: 'Location:accedi.php?intended=lista_preventivi');
}