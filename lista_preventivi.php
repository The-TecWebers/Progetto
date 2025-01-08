<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "PreventivoController.php";

session_start();
$titolo = "Lista preventivi - EdilScavi";
$descrizione = "Lista dei tuoi preventivi per i lavori di scavi e edilizia con EdilScavi";
$keywords = "preventivi, scavi, edilizia, scavi brescia, lavori edilizi";
if (AuthController::isLogged()) {
    $template = file_get_contents(filename: __DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "lista_preventivi.html");

    if(AuthController::isAdmin())
    {
        $tabella = PreventivoController::getTabellaPreventivi();
        $template = str_replace("<!--VistaPreventivi-->",$tabella,$template);
    }
    else
    {
        $creaPreventivo = '<a href="crea_preventivo.php">Crea preventivo</a>';
        $lista = PreventivoController::getListaPreventivi();
        $template = str_replace("<!--CreaPreventivi-->", $creaPreventivo, $template);
        $template = str_replace("<!--VistaPreventivi-->", $lista, $template);
    }
    if(isset($_SESSION['Messages']))
    {
        $template = str_replace("<!--Messages-->", $_SESSION['Messages'], $template);
        $_SESSION['Messages']=null;

    }
    session_write_close();

    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
    echo $template;
    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
}
else
{
    $_SESSION['intended-messages'] = "Accedi per visualizzare la lista dei preventivi.";
    header(header: 'Location:accedi.php?intended=lista_preventivi');
}
