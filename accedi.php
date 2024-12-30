<?php

$titolo = "Accedi - EdilScavi";
$descrizione = "Accedi al tuo account EdilScavi per creare un preventivo o visualizzare i preventivi già creati.";
$keywords = "accedi, Edil Scavi, login, account, informazioni personali, accesso";

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";

session_start();

try {
    if (AuthController::isLogged()) {
        /*if (AuthController::isAdmin())
            header("Location: dashboard.php");
        else*/
            header("Location: area_privata.php");
    }
    $template = (file_get_contents('HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'accedi.html'));

    $err = isset($_SESSION['error-login']) ? $_SESSION['error-login'] : null;
    $msg = isset($_SESSION['intended-messages']) ? $_SESSION['intended-messages'] : null;

    if (isset($err)){
        $template = str_replace("<!-- errorMessages -->", $err, $template);
        $template = str_replace("placeholder=\"Username\"", "value=\"" . $_SESSION['username*'] . "\"", $template);
        $template = str_replace("placeholder=\"Password\"", "value=\"" . $_SESSION['password*'] . "\"", $template);
    }
    if(isset($msg))
    {
        $msg = "<p class='info-label centered'>".$msg."</p>";
        $template = str_replace("<!--intendedRedirectMessages-->", $msg, $template);
    }
    session_reset();
    unset($_SESSION['intended-messages']);
    if(!isset($_SESSION['intendedEdited']))
    {
        unset($_SESSION['intendedRoute']);
    }
    unset($_SESSION['intendedEdited']);
    session_write_close();
} catch (Exception $e) {
    AuthController::serverError();
}

include "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";

echo $template;

include "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";