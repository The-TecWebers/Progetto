<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";

$titolo = "Crea preventivo - EdilScavi";
$descrizione = "Crea un preventivo per i lavori di scavo ed edilizia con EdilScavi Srl!";
$keywords = "preventivo, scavi, edilizia, scavi brescia, lavori edilizi";

session_start();

if (AuthController::isAdmin()) {
    session_reset();
    session_write_close();
    header(header: 'Location:lista_preventivi.php');
} elseif (AuthController::isLogged()) {
    session_reset();
    session_write_close();
    $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "crea_preventivo.html");
    $err = isset($_SESSION['error-preventivi']) ? $_SESSION['error-preventivi'] : null;
    if(isset($err))
    {
        $template = str_replace("<!-- errorMessages -->", $err, $template);
        $fields = [
            'titolo' => 'Titolo',
            'luogo' => 'Luogo',
            'descrizione' => 'Descrizione'
        ];

        foreach ($fields as $field => $label) {
            $sessionKey = $field . '*';
            if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] !== "") {
                $template = str_replace("placeholder=\"{$label}\"", "value=\"" . $_SESSION[$sessionKey] . "\"", $template);
            } else {
                $template = preg_replace('/name="' . $field . '" value=".*"/', 'placeholder="' . $label . '"', $template);
            }
        }
    }
    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
    echo $template;
    include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
} else {
    header(header: 'Location:accedi.php?intended=crea_preventivo');
}
