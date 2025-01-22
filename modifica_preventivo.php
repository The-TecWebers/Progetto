<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'PreventivoController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$titolo = "Modifica preventivo - Edil Scavi";
$descrizione = "Modifica un preventivo per i lavori di scavo ed edilizia con Edil Scavi Srl!";
$keywords = "preventivo, modifica, scavi, edilizia, scavi brescia, lavori edilizi";
$sanitized = InputController::sanitizeAll($_GET);

$id = $sanitized['id'];
$err = isset($_SESSION['error-preventivi']) ? $_SESSION['error-preventivi'] : null;

if (AuthController::isLogged()) {
    if (PreventivoController::authorizeFunction($id, (AuthController::getAuthUser())->getId())) {
        $preventivo = PreventivoController::getPreventivoById($id);
        
        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "modifica_preventivo.html");
        if(isset($err))
        {
            $template = str_replace("<!-- errorMessages -->", $err, subject: $template);
            $fields = [
                'titolo' => 'Es.: Estensione fognatura Via Trieste',
                'luogo' => 'Es.: Via Trieste, 23, Brescia (BS)',
                'descrizione' => 'Es.: Stiamo portando a termine la costruzione di una casa ed è necessario includerla nella rete fognaria locale. Si tratta di realizzare un\'estensione della fognatura di Via Trieste perchè copra anche il numero civico 23.',
            ];
    
            foreach ($fields as $field => $label) {
                $sessionKey = $field . '*';
                if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] !== "") {
                    $template = str_replace( "placeholder=\"{$label}\"", "placeholder=\"{$label}\" value=\"" . $_SESSION[$sessionKey] . "\"", $template);
                } else {
                    $template = preg_replace('/name="' . $field . '" value=".*"/', 'placeholder="' . $label . '"', $template);
                }
            }
    
            if(isset($_SESSION['descrizione*']))
            {
                $template = str_replace("</textarea>", $_SESSION['descrizione*']."</textarea>", $template );
            }
            else
            {
                $template = preg_replace('/name="descrizione">.*<\/textarea>/',
                'name="descrizione" placeholder="' . $fields['descrizione'] . '"></textarea>', $template);
            }
        }
        else {
            $template = str_replace("placeholder=\"Es.: Estensione fognatura Via Trieste\"", "value=\"{$preventivo->getTitolo()}\" placeholder=\"Es.: Estensione fognatura Via Trieste\"", $template);
            $template = str_replace("placeholder=\"Es.: Via Trieste, 23, Brescia (BS)\"", "placeholder=\"Es.: Via Trieste, 23, Brescia (BS)\" value=\"{$preventivo->getLuogo()}\"", $template);
            $template = str_replace("</textarea>", "{$preventivo->getDescrizione()}</textarea>", $template);
        }
        $template = str_replace("<!--Image-->", "<img class=\"preventivo-edit-foto\" src=\"{$preventivo->getFoto()}\" alt=\"Foto scelta per il preventivo\">", $template);
        $template = str_replace("<!--id_preventivo-->", "<input type=\"hidden\" id=\"edit_preventivo_id\" name=\"edit_preventivo_id\" value=\"{$id}\"/>", $template);
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