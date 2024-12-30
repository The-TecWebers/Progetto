<?php
$titolo = "Registrati - EdilScavi";
$descrizione = "Registrati ad EdilScavi! Accedi ai nostri servizi e richiedi un preventivo!";
$keywords = "registrati, account, dati personali, dati di accesso, registrazione, Edil Scavi";

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";

session_start();

try {
    if (AuthController::isLogged()) {
        /*if (AuthController::isAdmin())
             header("Location: dashboard.php");
         else */
             header("Location: area_privata.php");
    }
    $template = (file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'registrati.html'));

    $err = isset($_SESSION['error-reg']) ? $_SESSION['error-reg'] : null;

    if (isset($err)) {
        $template = str_replace("<!-- errorMessages -->", $err, $template);
        $template = str_replace("placeholder=\"Nome\"", "value=\"" . $_SESSION['nome*'] . "\"", $template);
        $template = str_replace("placeholder=\"Cognome\"", "value=\"" . $_SESSION['cognome*'] . "\"", $template);
        $template = str_replace("placeholder=\"E-mail\"", "value=\"" . $_SESSION['email*'] . "\"", $template);
        $template = str_replace("placeholder=\"Username\"", "value=\"" . $_SESSION['username*'] . "\"", $template);
        $template = str_replace("placeholder=\"Password\"", "value=\"" . $_SESSION['password*'] . "\"", $template);
        $template = str_replace("placeholder=\"Conferma password\"", "value=\"" . $_SESSION['password_confirmation*'] . "\"", $template);
    }

    session_write_close();
    session_abort();
} catch (Exception $e) {
    AuthController::serverError();
}

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";

echo $template;

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";