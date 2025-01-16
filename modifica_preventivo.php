<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'PreventivoController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$titolo = "Modifica preventivo - EdilScavi";
$descrizione = "Modifica un preventivo per i lavori di scavo ed edilizia con EdilScavi Srl!";
$keywords = "preventivo, modifica, scavi, edilizia, scavi brescia, lavori edilizi";
$sanitized = InputController::sanitizeAll($_GET);

$id = $sanitized['id'];
if (AuthController::isLogged()) {
    if (PreventivoController::authorizeFunction($id, (AuthController::getAuthUser())->getId())) {
        $preventivo = PreventivoController::getPreventivoById($id);
        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "modifica_preventivo.html");
        $template = str_replace("<!--id_preventivo-->", "<input type='hidden' id='id_preventivo' name='id_preventivo' value='" . $id . "'/>", $template);
        $template = str_replace("<!--Image-->", "<img class='preventivo-edit-foto' src='" . $preventivo->getFoto() . "' alt='Foto scelta per il preventivo' >", $template);
        $template = str_replace("placeholder=\"Es.: Estensione fognatura Via Trieste\"", "value='" . $preventivo->getTitolo() . "' placeholder='Titolo'", $template);
        $template = str_replace("placeholder=\"Es.: Via Trieste, 23, Brescia (BS)\"", "value=\"{$preventivo->getLuogo()}\"", $template);
        $dom = new DOMDocument();
        libxml_use_internal_errors(use_errors: true);
        $dom->loadHTML($template);

        $textareas = $dom->getElementsByTagName('textarea');
        foreach ($textareas as $textarea) {
            if ($textarea->getAttribute('id') == 'descrizione') {
                $textarea->textContent = $preventivo->getDescrizione();
            }
        }
        $template = $dom->saveHTML();
        session_reset();
        session_write_close();
        include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
        echo $template;
        include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
    } else {
        header(header: 'Location:500.php');
    }
} else {
    header(header: 'Location:accedi.php?intended=modifica_preventivo');
}