<?php

$titolo = "Accedi - EdilScavi";
$descrizione = "Accedi al tuo account EdilScavi per creare un preventivo o visualizzare i preventivi già creati.";
$keywords = "accedi, Edil Scavi, login, account, informazioni personali, accesso";

require_once "PHP/backend/controllers/AuthController.php";

session_start();

try {
    if (AuthController::isLogged()) {
        /*if (AuthController::isAdmin())
            header("Location: dashboard.php");
        else*/
            header("Location: area_privata.php");
    }
    $template = (file_get_contents('HTML/pages/accedi.html'));

    $err = isset($_SESSION['error-login']) ? $_SESSION['error-login'] : null;

    if (isset($err)){
        $template = str_replace("<!-- errorMessages -->", $err, $template);
        $template = str_replace("placeholder=\"Username\"", "value=\"" . $_SESSION['username*'] . "\"", $template);
        $template = str_replace("placeholder=\"Password\"", "value=\"" . $_SESSION['password*'] . "\"", $template);
    }

    session_write_close();
    session_abort();
} catch (Exception $e) {
    AuthController::serverError();
}

include "PHP/template/header.php";

echo $template;

include "PHP/template/footer.php";