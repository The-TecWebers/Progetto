<?php
$titolo = "Registrati - EdilScavi";
$descrizione = "Registrati ad EdilScavi per poter richiedere il tuo preventivo.";
$keywords = "registrati, Edil Scavi, account, Dati personali, Dati di accesso, registrazione";

require_once "PHP/backend/controllers/AuthController.php";

session_start();
session_destroy();

try {
    if (AuthController::isLogged()) {
        /*if (AuthController::isAdmin())
            header("Location: dashboard.php");
        else */
            header("Location: area_privata.php");
    }
    $template = (file_get_contents('HTML/pages/registrati.html'));

    $err = isset($_SESSION['error-reg']) ? $_SESSION['error-reg'] : null;

    session_write_close();
    session_abort();

    include "./PHP/template/header.php";

    if (isset($err)) {
        $template = str_replace("<!-- errorMessages -->", $err, $template);
    }
    echo $template;
} catch (Exception $e) {
    AuthController::serverError();
}
include "./PHP/template/footer.php";
?>